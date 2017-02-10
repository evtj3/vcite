<?php
App::uses('AppController', 'Controller');
/**
 * Topics Controller
 *
 * @property Topic $Topic
 * @property PaginatorComponent $Paginator
 */
App::import('Model','Notification');
App::import('Model','Log');
class NotificationsController extends AppController {
	public $components = array('Paginator', 'Context');
	public function notifs($id = null){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		$notification = new Notification();
		
		//pr($notifs);
		$notification->id = $id;
		
		
		$notifs2 = $notification->find('first',array('conditions' => array(
			'id' => $id
			),'recursive' => -1));
		$data = array(
			'id' => $id,
			'notified_teachers' => $notifs2['Notification']['notified_teachers'].'['.$this->Session->read('User.id').']'
			);
		$notiCheck = $notification->find('all',array('conditions' => array(
			'id' => $id,
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		if(empty($notiCheck)){
			if($notification->save($data)){
				//$this->Session->setFlash(__('The teacher has been saved.'), 'default', array('class' => 'alert alert-success'));
				
				//activity logs start here
					$id = $this->Session->read('User.id');
					$name = $this->Session->read('User.wholename');
					$activity = 'Read a notice from: '.$notifs2['Notification']['sender'];
					$this->createLogs(0,$id,$name,$activity);
				//end logs
				//return $this->redirect(array('controller'=> 'teachers','action' => 'dashboard'));
			} else {
				$this->Session->setFlash(__('There is something wrong. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}else{
			//pr('naa namay existing data ana brad');
		}
		$isMobile = $this->request->is('mobile');

		//notifications
		$notifs = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		$notifs_read = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		//notifications
		$this->set(compact('notifs_read','notifs','notifs2','isMobile'));
	}
	public function read(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$isMobile = $this->request->is('mobile');

		//notifications
		$notifs = $this->Notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		$notifs_read = $this->Notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		//notifications
		$this->set(compact('notifs_read','notifs','notifs2','isMobile'));
	}
	public function unread(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$isMobile = $this->request->is('mobile');

		//notifications
		$notifs = $this->Notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		$notifs_read = $this->Notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		//notifications
		$this->set(compact('notifs_read','notifs','notifs2','isMobile'));
	}
	public function createLogs($fktc = null,$fkst = null,$name = null,$activity = null){

		$activityLogs = new Log();

		$dataToLogs = array(
			'fkey_st_id' => $fkst,
			'fkey_tc_id' => $fktc,
			'name' => $name,
			'activity' => $activity
		);

		$activityLogs->create();
		if ($activityLogs->save($dataToLogs)) {
			
		} else {
			$this->Session->setFlash(__('Cannot create a log. Please ask the administrator.'), 'default', array('class' => 'alert alert-danger'));
		} 
		/* App::uses('Model' , 'Log');
		
		//activity logs start here
			$id = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Login';
			$this->createLogs($id,0,$name,$activity);
		//end logs
		*/

	}
}