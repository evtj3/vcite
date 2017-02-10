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

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */

class DocumentsController extends AppController {

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

		$docs = $this->Document->find('all',array('recursive' => 1));

		$this->set(compact('isMobile','notifs','notifs_read','docs'));
	}
	public function add(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		/*
		pr($this->request->is('post')); 
		pr($this->request->data);
		exit();
		*/
		//save new document
		if($this->request->is('post')){

			$this->Document->create();
			if($this->Document->save($this->request->data)){
				$this->Session->setFlash(__('Document has been saved.'), 'default', array('class' => 'alert alert-success'));
					//activity logs start here
						$id = $this->Session->read('User.id');
						$name = $this->Session->read('User.wholename');
						$activity = 'Added a new Document Titled: '.$this->request->data['Document']['title'];
						$this->createLogs($id,0,$name,$activity);
					//end logs
				return $this->redirect(array('controller' => 'documents','action' => 'index'));
			}else{
				$this->Session->setFlash(__('Document has not been saved.'), 'default', array('class' => 'alert alert-danger'));
				return $this->redirect(array('controller' => 'documents','action' => 'index'));
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
		$docs = $this->Document->find('all',array('recursive' => 1));
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
			'document_id LIKE "%['.$this->params['url']['docid'].']%"'
			),'recursive' => -1));
		$docs = $this->Document->find('first',array('conditions' => array(
			'Document.id' => $this->params['url']['docid']
			),'recursive' => 1));
		
		$docfiles = $docs['Docfile'];
		
		$this->set(compact('isMobile','notifs','notifs_read','folderName','docfiles'));
	}
	public function read(){
		if(empty($this->params['url']['docid']))
			$this->redirect(array('action' => '/'));

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
			'document_id LIKE "%['.$this->params['url']['docid'].']%"'
			),'recursive' => -1));
		$docs = $this->Document->find('first',array('conditions' => array(
			'Document.id' => $this->params['url']['docid']
			),'recursive' => 1));
		
		$docfiles = $docs['Docfile'];
		
		$this->set(compact('isMobile','notifs','notifs_read','folderName','docfiles'));
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
		$docs = $this->Document->find('first',array('conditions' => array(
			'id' => $this->params['url']['docid']
			),'recursive' => 1));
		$removeFolder = $folders->find('all',array('conditions' => array(
			'document_id LIKE "%['.$docs['Document']['id'].']%"'
			),'recursive' => 1));
		//pr($docs);exit();

		$this->set(compact('isMobile','notifs','notifs_read','removeFolder'));
	}
	public function adddoc(){
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

		$docs = $this->Document->find('all',array('recursive' => 1));
		
		//pr($docs);exit();

		$this->set(compact('isMobile','notifs','notifs_read','docs'));
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
		$docs = $this->Document->find('first',array('conditions' => array(
			'id' => $this->params['url']['docid']
			),'recursive' => 1));
		$updateFolder = $folders->find('all',array('conditions' => array(
			'document_id LIKE "%['.$docs['Document']['id'].']%"'
			),'recursive' => 1));
		//pr($docs);exit();

		$this->set(compact('isMobile','notifs','notifs_read','docs','updateFolder'));
	}
	public function remove($id = null){

		if(!empty($id)){

			$this->Document->id = $id;

			if (!$this->Document->exists()) {
				throw new NotFoundException(__('Invalid topic'));
			}
			if($this->Document->delete()){

			}else{

			}
			return $this->redirect(array('controller' => 'documents', 'action' => 'index'));

		}else
		return $this->redirect(array('controller' => 'documents', 'action' => 'index'));

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

			$this->Document->id = $id;
			if($this->Document->save($this->request->data)){
				$this->Session->setFlash(__('Document has been updated.'), 'default', array('class' => 'alert alert-success'));
					//activity logs start here
						$id = $this->Session->read('User.id');
						$name = $this->Session->read('User.wholename');
						$activity = 'Updated a Document Titled: '.$this->request->data['Document']['title'];
						$this->createLogs($id,0,$name,$activity);
					//end logs
				return $this->redirect(array('controller' => 'documents','action' => 'index'));
			}else{
				$this->Session->setFlash(__('Document has not been saved.'), 'default', array('class' => 'alert alert-danger'));
				return $this->redirect(array('controller' => 'documents','action' => 'index'));
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
