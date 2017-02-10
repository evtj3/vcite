<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');
App::import('Model','Notification');
App::import('Model', 'Log');
App::import('Model','Docfoldertree');
App::import('Model','Laspagelink');
App::import('Model','Docfile');
App::import('Model','Vcitepermission');
App::import('Model','Student');
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */

class LasdocsController extends AppController {

	/**
	* This controller does not use a model
	*
	* @var array
	*/
	public $components = array('Paginator','Context');
	public $uses = array();

	/**
	* Displays a view
	*
	* @param mixed What page to display
	* @return void
	* @throws NotFoundException When the view file could not be found
	*	or MissingViewException in debug mode.
	*/
	public function index(){
		$session_id = $this->Session->read('User.id');
		$Student = new Student();
		$Student_data = $Student->find('first',array('conditions' => array(
			'id' => $session_id
			),'recursive' => -1));

		$vPermit = new Vcitepermission();
		$vPermit_data = $vPermit->find('first',array('conditions' => array(
			'isEnabled' => 0
			),'recursive' => -1));
		
		
		//pr($Student_data);
		//pr($this->Session->read('User'));
		//pr($vPermit_data);
		$session_data = $this->Session->read('User.group');
		//$session_flash = $this->Session->setFlash(__('Sorry, you don\'t have a permission to access the LAS. Please ask your respective subject teacher.'), 'default', array('class' => 'alert alert-danger'));
if(empty($vPermit_data)){
			//owright!
			//pr('bay enable ang vcite sa tanan studyante.');
		}else{
			
			if($session_data == 'teacher'){
				//pr('bay enable ang vcite sa tanan maestro.');
			}else{
				$check1 = strpos($vPermit_data['vcite_permissions']['list_of_sections_enabled'],$Student_data['Student']['section']);
				$check2 = strpos($vPermit_data['vcite_permissions']['list_of_students_enabled'],$Student_data['Student']['id']);
				if(!empty($check1)){
					//pr(strpos($vPermit_data['vcite_permissions']['list_of_sections_enabled'],$Student_data['Student']['section']));
					//pr('enable tanan sa section '.$Student_data['Student']['section']);
				}elseif(!empty($check2)){
					//pr(strpos($vPermit_data['vcite_permissions']['list_of_students_enabled'],$Student_data['Student']['id']));
					//pr('enable sa student nga naay ID '.$Student_data['Student']['id']);
				}elseif($vPermit_data['vcite_permissions']['isEnabled'] == 1){

				}
				else{
					//pr('bay disable ang vcite sa tanan studyante.');
					$this->Session->setFlash(__('Sorry, you don\'t have a permission to access the LAS. Please ask your respective subject teacher.'), 'default', array('class' => 'alert alert-danger'));
					return $this->redirect(array('controller' => 'students','action' => 'dashboard'));
				}
			}
		}

		$isMobile = $this->request->is('mobile');
		

		//notifications
		$notification = new Notification();
		$notifs = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		$notifs_read = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		//pr($notifs);
		//notifications
		$lasPDFfiles = new Docfile();
		$link = new Laspagelink();
		$links = $link->find('count',array('recursive' => -1));
		$lasPDFfiles_data = $lasPDFfiles->find('count',array('conditions' => array(
			'document_id' => null
			),'recursive' => -1));
		$docs = $this->Lasdoc->find('all',array('recursive' => 1));
		
		$this->set(compact('isMobile','notifs','notifs_read','docs','lasPDFfiles_data','links'));
	}
	public function add(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		
		//save new document
		if($this->request->is('post')){
			/*
			pr($this->request->data);
			exit();
			*/
			$this->Lasdoc->create();
			if($this->Lasdoc->save($this->request->data)){
				$this->Session->setFlash(__('LAS has been saved.'), 'default', array('class' => 'alert alert-success'));
					//activity logs start here
						$id = $this->Session->read('User.id');
						$name = $this->Session->read('User.wholename');
						$activity = 'Added a new LAS Titled: '.$this->request->data['Lasdoc']['title'];
						$this->createLogs($id,0,$name,$activity);
					//end logs
				return $this->redirect(array('controller' => 'lasdocs','action' => 'index'));
			}else{
				$this->Session->setFlash(__('LAS has not been saved.'), 'default', array('class' => 'alert alert-danger'));
				return $this->redirect(array('controller' => 'lasdocs','action' => 'index'));
			}

		}

		$isMobile = $this->request->is('mobile');
		//notifications
		$notification = new Notification();
		$notifs = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		$notifs_read = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		//pr($notifs);
		//notifications
		$docs = $this->Lasdoc->find('all',array('recursive' => 1));
		$this->set(compact('isMobile','notifs','notifs_read','docs'));
	}
	public function view(){
		if(empty($this->params['url']['docid']))
			$this->redirect(array('action' => '/'));

		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		$isMobile = $this->request->is('mobile');

		//notifications
		$notification = new Notification();
		$notifs = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		$notifs_read = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		//pr($notifs);
		//notifications

		
		$folders = new Docfoldertree();
		$folderName = $folders->find('all',array('conditions' => array(
			'lasdoc_id LIKE "%['.$this->params['url']['docid'].']%"'
			),'recursive' => -1));
		$Laspagelink = new Laspagelink();

		$docs = $this->Lasdoc->find('first',array('conditions' => array(
			'Lasdoc.id' => $this->params['url']['docid']
			),'recursive' => 1));
		$Laspagelink_db = $Laspagelink->find('all',array('conditions' => array(
			'lasdoc_id LIKE "%'.$docs['Lasdoc']['id'].'%"'
			),'recursive' => -1));
		$Laspagelink_db2 = $Laspagelink->find('all',array('conditions' => array(
			'lasdoc_id LIKE "%'.$docs['Lasdoc']['id'].'%"'
			),'recursive' => -1));
		$Laspagelink_db3 = $Laspagelink->find('all',array('recursive' => -1));
		//pr($folderName);
		$docfiles = $docs['Docfile'];
		$Docfile = new Docfile();
		$lasdocsfiles = $Docfile->find('all',array('conditions' => array(
			'document_id' => null
			),'recursive' => -1));
		//pr($lasdocsfiles); 
		//pr($Laspagelink_db3); exit();
		$this->set(compact('lasdocsfiles','isMobile','notifs','notifs_read','folderName','docfiles','Laspagelink_db','Laspagelink_db2','Laspagelink_db3'));
	}
	public function read(){
		if(empty($this->params['url']['docid']))
			$this->redirect(array('action' => '/'));

		$vcite_permissions = new Vcitepermission();
		$vcite_permit = $vcite_permissions->find('first',array('recursive' => -1));
		$ses_data_id = $this->Session->read('User.id');
		$Student = new Student();
		$student_data = $Student->find('first',array('conditions' => array(
			'id' => $ses_data_id
			),'recursive' => -1));
		
		if($vcite_permit['vcite_permissions']['isEnabled'] == 1 || strpos($vcite_permit['vcite_permissions']['list_of_students_enabled'], $student_data['Student']['email']) || strpos($vcite_permit['vcite_permissions']['list_of_sections_enabled'], $student_data['Student']['section'])){
			$this->Session->setFlash(__('Permission Granted. Learn more and enjoy reading.'), 'default', array('class' => 'alert alert-success'));
		}else{
			$this->Session->setFlash(__('Sorry, you don\'t have a permission to access the LAS. Please ask your respective subject teacher.'), 'default', array('class' => 'alert alert-danger'));
			return $this->redirect(array('controller' => 'students','action' => 'dashboard'));
		}
		$disabled_link = '';

		$isMobile = $this->request->is('mobile');

		//notifications
		$notification = new Notification();
		$notifs = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		$notifs_read = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		//pr($notifs);
		//notifications

		
		$folders = new Docfoldertree();
		$folderName = $folders->find('all',array('conditions' => array(
			'lasdoc_id LIKE "%['.$this->params['url']['docid'].']%"'
			),'recursive' => -1));
		$Laspagelink = new Laspagelink();

		$docs = $this->Lasdoc->find('first',array('conditions' => array(
			'Lasdoc.id' => $this->params['url']['docid']
			),'recursive' => 1));
		$Laspagelink_db = $Laspagelink->find('all',array('conditions' => array(
			'lasdoc_id LIKE "%'.$docs['Lasdoc']['id'].'%"'
			),'recursive' => -1));
		$Laspagelink_db2 = $Laspagelink->find('all',array('conditions' => array(
			'lasdoc_id LIKE "%'.$docs['Lasdoc']['id'].'%"'
			),'recursive' => -1));
		$Laspagelink_db3 = $Laspagelink->find('all',array('recursive' => -1));

		//pr($folderName);
		$docfiles = $docs['Docfile'];
		
		$this->set(compact('student_data','vcite_permit','isMobile','notifs','notifs_read','folderName','docfiles','Laspagelink_db','Laspagelink_db2'));
	}
	public function deletedoc(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		$isMobile = $this->request->is('mobile');

		//notifications
		$notification = new Notification();
		$notifs = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		$notifs_read = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		//pr($notifs);
		//notifications
		$folders = new Docfoldertree();
		$docs = $this->Lasdoc->find('first',array('conditions' => array(
			'id' => $this->params['url']['docid']
			),'recursive' => 1));
		$removeFolder = $folders->find('all',array('conditions' => array(
			'lasdoc_id LIKE "%['.$docs['Lasdoc']['id'].']%"'
			),'recursive' => 1));
		//pr($docs);exit();

		$this->set(compact('isMobile','notifs','notifs_read','removeFolder'));
	}
	public function adddoc(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		$isMobile = $this->request->is('mobile');
		

		//notificationsqq
		$notification = new Notification();
		$notifs = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		$notifs_read = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		//pr($notifs);
		//notifications

		$docs = $this->Lasdoc->find('all',array('recursive' => 1));
		$folderTree = new Docfoldertree();
		$folderTrees = $folderTree->find('all',array('recursive' => 1));
		//pr($docs);exit();

		$this->set(compact('isMobile','notifs','notifs_read','docs','folderTrees'));
	}
	public function editdoc(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		$isMobile = $this->request->is('mobile');

		//notifications
		$notification = new Notification();
		$notifs = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		$notifs_read = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		//pr($notifs);
		//notifications
		$folders = new Docfoldertree();
		$docs = $this->Lasdoc->find('first',array('conditions' => array(
			'id' => $this->params['url']['docid']
			), 'recursive' => 1));
		$updateFolder = $folders->find('all',array('conditions' => array(
			'lasdoc_id LIKE "%['.$docs['Lasdoc']['id'].']%"'
			),'recursive' => 1));
		//pr($docs);pr($updateFolder);exit();

		$this->set(compact('isMobile','notifs','notifs_read','docs','updateFolder'));
	}
	public function remove($id = null){

		if(!empty($id)){

			$this->Lasdoc->id = $id;

			if (!$this->Lasdoc->exists()) {
				throw new NotFoundException(__('Invalid topic'));
			}
			if($this->Lasdoc->delete()){

			}else{

			}
			return $this->redirect(array('controller' => 'lasdocs', 'action' => 'index'));

		}else
		return $this->redirect(array('controller' => 'lasdocs', 'action' => 'index'));

		exit();
	}
	public function edit($id = null){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		
		/*
		pr($this->request->is('post')); 
		pr($this->request->data);
		exit();
		*/

		//edit document
		if($this->request->is('post')){

			$this->Lasdoc->id = $id;

			if($this->Lasdoc->save($this->request->data)){
				$this->Session->setFlash(__('LAS has been updated.'), 'default', array('class' => 'alert alert-success'));
					//activity logs start here
						$id = $this->Session->read('User.id');
						$name = $this->Session->read('User.wholename');
						$activity = 'Updated a LAS Titled: '.$this->request->data['Lasdoc']['title'];
						$this->createLogs($id,0,$name,$activity);
					//end logs
				return $this->redirect(array('controller' => 'lasdocs','action' => 'index'));
			}else{
				$this->Session->setFlash(__('LAS has not been saved.'), 'default', array('class' => 'alert alert-danger'));
				return $this->redirect(array('controller' => 'lasdocs','action' => 'index'));
			}

		}

		$isMobile = $this->request->is('mobile');
		//notifications
		$notification = new Notification();
		$notifs = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		$notifs_read = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'recursive' => -1));
		//pr($notifs);
		//notifications
		$docs = $this->Document->find('first',array('fields' => 'title,description','conditions' => array(
			'id' => $id
			),'recursive' => 1));
		//pr($docs);
		$this->set(compact('isMobile','notifs','notifs_read','docs'));
	
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
