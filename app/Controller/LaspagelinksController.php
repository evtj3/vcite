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
App::import('Model', 'Lasdoc');
App::import('Model', 'Docfile');
App::import('Model', 'Student');
App::import('Model' , 'Loginst');
App::import('Model', 'Vcitepermission');
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */

class LaspagelinksController extends AppController {

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
	public function addnewsubtopic(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
      
      

      $data = array();
     // $data = $this->request->data['Laspagelink'];
      if(!empty($this->request->data['Laspagelink']['title'])){
      	//pr($this->request->data); exit();
      	$data = $this->request->data['Laspagelink'];
      		$this->Laspagelink->create();
	      if($this->Laspagelink->save($data)){
	      	$this->Session->setFlash(__('Subtopic titled '.$this->request->data["Laspagelink"]["title"].' has been created.'), 'default', array('class' => 'alert alert-success'));
	      	return $this->redirect($this->referer(array('action' => 'view?doc='.$this->request->data['Laspagelink']['foldertree'].'&docid='.$this->request->data['Laspagelink']['lasdoc_id'])));
	      }else{

	      }
      }else{
      	$laspagelinks_db = $this->Laspagelink->find('first',array('conditions' => array(
      	'id' => $this->request->data['sub_topic']
      	),'recursive' => -1));
      	//pr($this->request->data); exit();
      	$data = array(
      		'id' => $this->request->data['sub_topic'],
      		'lasdoc_id' => $laspagelinks_db['Laspagelink']['lasdoc_id'].','.$this->request->data['Laspagelink']['lasdoc_id']
      		);

      	  if($this->Laspagelink->save($data)){
	      	$this->Session->setFlash(__('Subtopic titled '.$this->request->data["Laspagelink"]["title"].' has been created.'), 'default', array('class' => 'alert alert-success'));
	      	return $this->redirect($this->referer(array('action' => 'view?doc='.$this->request->data['Laspagelink']['foldertree'].'&docid='.$this->request->data['Laspagelink']['lasdoc_id'])));
	      }else{

	      }
      }

	}
	public function addnewsublink(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		//pr($this->request->data); exit();

		if($this->request->is('post')){
			if(!empty($this->request->data['Laspagelink']['Topic'])){
				$data = array(
						//'id' => $this->request->data['Laspagelink']['subtopic_id'],
						'lasdoc_id' => $this->request->data['Laspagelink']['lasdoc_id'],
						'lasfolder_id' => $this->request->data['Laspagelink']['lasfolder_id'],
						'subtopic_id' => $this->request->data['Laspagelink']['subtopic_id'],
						'subtopic' => $this->request->data['Laspagelink']['Topic'],
						'folder_subject' => $this->request->data['Laspagelink']['subject_code']
					);
				$this->Laspagelink->create();
				if($this->Laspagelink->save($data)){
					$this->Session->setFlash(__('Sub Link titled '.$this->request->data["Laspagelink"]["Topic"].' has been created.'), 'default', array('class' => 'alert alert-success'));
	      			return $this->redirect($this->referer());
				}else{

				}
			}else{
				$laspagelinks_db = $this->Laspagelink->find('first',array('conditions' => array(
		      	'id' => $this->request->data['sub_topic_link']
		      	),'recursive' => -1));
		      	//pr($this->request->data); exit();
		      	$data = array(
		      		'id' => $this->request->data['sub_topic_link'],
		      		'lasdoc_id' => $laspagelinks_db['Laspagelink']['lasdoc_id'].','.$this->request->data['Laspagelink']['lasdoc_id']
		      		);

		      	  if($this->Laspagelink->save($data)){
			      	$this->Session->setFlash(__('Subtopic titled '.$laspagelinks_db["Laspagelink"]["subtopic"].' has been created.'), 'default', array('class' => 'alert alert-success'));
			      	return $this->redirect($this->referer(array('action' => 'view?doc='.$this->request->data['Laspagelink']['foldertree'].'&docid='.$this->request->data['Laspagelink']['lasdoc_id'])));
			      }else{

			      }
			}
		}	
	}
	public function addnewlasfile(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		//pr($this->request->data); exit();

		if($this->request->is('post')){
			$data = array(
				'subject_code' => $this->request->data['subjcode'],
				'duration' => $this->request->data['duration'],
				'subject_description' => $this->request->data['subjdes']
				);
			$this->Laspagelink->id = $this->request->data['id'];
			if($this->Laspagelink->save($data)){
				$this->Session->setFlash(__('Contents has been updated.'), 'default', array('class' => 'alert alert-success'));
	  			return $this->redirect($this->referer());
			}else{

			}
		}
		
	}
	public function view($id){
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

		$laspagelinks_db = $this->Laspagelink->find('first',array('conditions' => array(
			'id' => $id
			),'recursive' => -1));
		$lasdoc = new Lasdoc();
		$lasdoc_db = $lasdoc->find('first',array('conditions' => array(
			'id' => $laspagelinks_db['Laspagelink']['lasdoc_id']
			),'recursive' => -1));
		$Docfile = New Docfile();
		$Docfile_db = $Docfile->find('all',array('conditions' => array(
			'laspagelink_id' => $id
			)
		,'recursive' => -1));

		//exit();

		//load json data NOTE: Make sure you connect through a local network for 192.168.12.4
		    $server = 'http://192.168.12.4';
		    $url = $server.'/cis/class_advisories/show_sections/index.ctp';
			$url2 = '';

			function loadFile($url) {
			    $ch = curl_init();

			    curl_setopt($ch, CURLOPT_HEADER, 0);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_URL, $url);

			    $data = curl_exec($ch);
			    curl_close($ch);

			    return $data;
			}
			
			//if(!empty($this->params['url']['sections']))
				//$datas = loadFile($url); 
				$datas = null;
				$dataIsDisabled = true;
				$data_arr = array();
				if(!$dataIsDisabled && empty($datas)){ print_r("Network is not available as these moment. ".$server.": General Failure");
				exit();}else if($dataIsDisabled && $datas != null){
					$data_json = new RecursiveIteratorIterator(
				    new RecursiveArrayIterator(json_decode($datas, TRUE)),
				    RecursiveIteratorIterator::SELF_FIRST);
					//pr($data_json);
					
					$count = 1;

					foreach ($data_json as $key => $val) {
					    
					    if(is_array($val)) {
					    	$count++;
					    	//pr($count);
					    	$r = $count % 2;
					    	//pr($r);
					    	if($r == 1){
						        //pr($val);
						        array_push($data_arr, $val);
						    }
					    } else {
					        
					    }

					}
				}
				//pr($data_arr);
				
		//pr($this->request->data);
		$this->set(compact('id','server','data_arr','isMobile','notifs','notifs_read','laspagelinks_db','lasdoc_db','Docfile_db'));
	}
	public function share_document_by_section($laspage_id = null){
		$data = $this->request->data;
		$vPermit = new Vcitepermission();
		$vPermit_data = $vPermit->find('first',array('recursive' => -1));
		$merge = '';
		
		for($cd=0;$cd<=$data['total_students_per_section'];$cd++){
			if(!empty($data['sections_checklist'.$cd]))
				$merge .= '['.$data['sections_checklist'.$cd].']';
		}
			if(!empty($vPermit_data['vcite_permissions']['list_of_sections_enabled'])){
				$data_permit = array(
				'id' => $vPermit_data['vcite_permissions']['id'],
				'list_of_sections_enabled' => $vPermit_data['vcite_permissions']['list_of_sections_enabled'].$merge
				);
			}else{
				$data_permit = array(
				'id' => $vPermit_data['vcite_permissions']['id'],
				'list_of_sections_enabled' => $merge
				);
			}
			if($vPermit->save($data_permit)){

			}else{

			}
		/*---------------------------*/

		$Student = new Student();
		if(!empty($vPermit_data)){
			$data = $this->request->data;

			$student_db = $Student->find('all',array('conditions' => array(
				'section' => $data
				),'recursive' => -1));

			
			$data_section_arr = array();
			foreach($student_db as $stdb){
				
				if(strpos($data_permit['list_of_sections_enabled'], $stdb['Student']['section'])){
					if(strpos($stdb['Student']['allowed_subjects'], $laspage_id)){
						$add_sec = '';
					}else{
						$add_sec = '['.$laspage_id.']';
					}

					$data_section_arr = array(
						'id' => $stdb['Student']['id'],
						'allowed_subjects' => $stdb['Student']['allowed_subjects'].''.$add_sec
						);
					
					if($Student->save($data_section_arr)){

					}else{

					}
				}
			}
			return $this->redirect($this->referer());
			exit();
		}
	}
	public function share_document_by_student($laspage_id = null){
		$data = $this->request->data;

		$vPermit = new Vcitepermission();
		$vPermit_data = $vPermit->find('first',array('recursive' => -1));
		$merge = '';
		
		for($cd=0;$cd<=	$data['total_students_per_section'];$cd++){
			if(!empty($data['students_checklist'.$cd]))
				$merge .= '['.$data['students_checklist'.$cd].']';

			//pr($data_permit);
		}

		
			if(!empty($vPermit_data['vcite_permissions']['list_of_students_enabled'])){
				$data_permit = array(
				'id' => $vPermit_data['vcite_permissions']['id'],
				'list_of_students_enabled' => $vPermit_data['vcite_permissions']['list_of_students_enabled'].$merge
				);
			}else{
				$data_permit = array(
				'id' => $vPermit_data['vcite_permissions']['id'],
				'list_of_students_enabled' => $merge
				);
			}
			
			if($vPermit->save($data_permit)){

			}else{

			}
			
		/*---------------------------*/
		$Student = new Student();

		$Student_sis = new Loginst();

		$students_arr = array();
		for($c=0;$c<$data['total_students_per_section'];$c++){
			//pr($data['students_checklist'.$c]);
			

			if(!empty($data['students_checklist'.$c]))
			array_push($students_arr,$data['students_checklist'.$c]);
		}
		

		$student_data = $Student->find('all',array('conditions' => array(
			'email' => $students_arr
			),'recursive' => -1));

		foreach($student_data as $std){
			
			$add_subj = '';
			if(strpos($std['Student']['allowed_subjects'], $laspage_id)){
				$add_subj = '';
			}else{
				$add_subj = '['.$laspage_id.']';
			}
			$sdata = array(
				'id' => $std['Student']['id'],
				'allowed_subjects' => $std['Student']['allowed_subjects'].''.$add_subj,
				'section' =>$data['advisory_class']
				);
			
			if($Student->save($sdata)){

			}else{

			}
			
			
		}
		
		if(!empty($student_data))
		return $this->redirect($this->referer());
		

		if(empty($student_data)){
			$student_data = $Student_sis->find('all',array('conditions' => array(
			'student_id' => $students_arr
			),'recursive' => -1));
		}

		//pr($student_data);
		
		foreach($student_data as $std){
			//pr($std);
			
			$sdata = array(
				'id' => $std['Loginst']['id'],
				'temp_student_id' => '',
				'allowed_subjects' => '['.$laspage_id.']',
				'fname' => $std['Loginst']['pd_fname'],
				'lname' => $std['Loginst']['pd_lname'],
				'ext' => $std['Loginst']['pd_ext'],
				'section' => '',
				'batch' => $std['Loginst']['batch'],
				'email' => $std['Loginst']['student_id'],
				'pword' => $std['Loginst']['password'],
				'subjects' => null
				);
			
			$Student->create();
			if($Student->save($sdata)){

			}else{

			}
		}
		return $this->redirect($this->referer());
	}
	public function read($id){
		#$this->Context->checkSession($this);
		#$this->Context->doNotPermit($this, "student");
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

		$laspagelinks_db = $this->Laspagelink->find('first',array('conditions' => array(
			'id' => $id
			),'recursive' => -1));
		$lasdoc = new Lasdoc();
		$lasdoc_db = $lasdoc->find('first',array('conditions' => array(
			'id' => $laspagelinks_db['Laspagelink']['lasdoc_id']
			),'recursive' => -1));
		$Docfile = New Docfile();
		$Docfile_db = $Docfile->find('all',array('conditions' => array(
			'laspagelink_id' => $id
			),'recursive' => -1));
		//exit();
		$this->set(compact('isMobile','notifs','notifs_read','laspagelinks_db','lasdoc_db','Docfile_db'));
	}	
	public function delete($id){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$this->Laspagelink->id = $id;
			if (!$this->Laspagelink->exists()) {
				throw new NotFoundException(__('Invalid Subtopic'));
			}
			
			if ($this->Laspagelink->delete()) {
				
				
			} else {
				
			}
			return $this->redirect($this->referer());
	}
}