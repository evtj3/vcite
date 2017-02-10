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

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
App::import('Model', 'Student');
App::import('Model', 'Teacher');
App::import('Model', 'Subject');
App::import('Model', 'Notification');
class LogsController extends AppController {

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
		
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		// activity logs

		$students = new Student();
		$teachers = new Teacher();
		$ActivityLogsStudents = array();
		$teacherLogs = $teachers->find('all',array('conditions'=>array(
				'id' => $this->Session->read('User.id')
			),'recursive' => 1));

		foreach($teacherLogs as $tl){
			
			foreach($tl['Subject'] as $subj){
				
				$studentLogs = $students->find('all',array('conditions' => array(
					'subjects LIKE "%['.$subj['id'].']%"'
					),'recursive' => -1));

				foreach($studentLogs as $stl){
					

					
					array_push($ActivityLogsStudents,$stl);
				}
				
			}
		}
		$arrData = array();
		foreach($ActivityLogsStudents as $alst){
			#pr($alst);
			
			array_push($arrData,$alst['Student']['id']);
		}
	

		$this->Paginator->settings = array(
			'conditions' => array(
				
				'fkey_st_id' => $arrData

				),
			'order' => array(
	            'Log.modified' => 'desc'
	        )
		);
		
		$this->Log->recursive = 0;
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
		$this->set(compact('notifs','notifs_read','isMobile'));
		$this->set('logs', $this->Paginator->paginate());
	}
	public function view(){

	}
	
}
