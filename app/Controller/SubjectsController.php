<?php
App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');
/**
 * Subjects Controller
 *
 * @property Subject $Subject
 * @property PaginatorComponent $Paginator
 */
App::import('Model', 'Readpage');
App::import('Model', 'Topic');
App::import('Model', 'Quizresult');
App::import('Model', 'Quizzes');
App::import('Model', 'Student');
App::import('Model', 'Log');
App::import('Model','Teacher');
App::import('Model','Notification');
App::import('Model','Tempstudent');
class SubjectsController extends AppController {

	/**
	* Components
	*
	* @var array
	*/
	public $name = 'Subjects';
	
	#public $helpers = array('Detergent');
	public $helpers = array('Detergent');
	public $components = array('Paginator', 'Context', 'Detergent','RequestHandler','MobileDetect');
	#public $name = 'Tutors';
	#'Js' => array('Jquery')
	#var $helpers = array('Html', 'Javascript', 'Ajax');
	#var $helpers = array('Html','Ajax','Javascript');
	/**
	* index method
	*
	* @return void
	*/
	/*
	public function beforeFilter() {
		parent::beforeFilter();

		// Change layout for Ajax requests
		if ($this->request->is('ajax')) {
			$this->layout = 'ajax';
		
		}
		#$this->Security->csrfExpires = '+1 hour';
	}*/
	
	public function index() {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$teacher = new Teacher();
		$isAdmin = $teacher->find('first',array('conditions' => array(
			'id' => $this->Session->read('User.id')
			),'recursive' => -1));
	
		if($isAdmin['Teacher']['isadmin'] != 1){
		$this->Session->setFlash(__('Sorry you dont have a permission to access. Please ask the administrator.'), 'default', array('class' => 'alert alert-danger'));
		return $this->redirect(array('controller' => '/'));
		}

		$this->Subject->recursive = 0;
		#$this->layout='default';
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
		$this->set('subjects', $this->Paginator->paginate());
	}
     
     public function listsub(){
     	$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		
		
			$this->Paginator->settings = array(

				'conditions' => array(
						'Subject.teacher_id' => $this->Session->read('User.id')
					)
			);


     	$this->Subject->recursive = 0;
		#$this->layout='default';
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
		$this->set('subjects', $this->Paginator->paginate());

     	
     }   
    public function set_subject($subject_id) {
    		$this->Context->checkSession($this);
			
            $this->Session->write('Subject.id', $subject_id);
            
            if ($this->Session->read('User.group')=="teacher") $this->redirect(array('action' => 'view'));
            if ($this->Session->read('User.group')=="student") $this->redirect(array('action' => 'read'));
            
            

            $this->redirect(array('controller' => 'pages', 'action' => 'login'));
    }

    /**
	* view method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function ajaxdata(){
		pr($this->data);
		
			echo '<input type="text" name="firstname" value="'.$this->data['firstname'].'" />';
			echo '<input type="text" name="lastname" value="'.$this->data['lastname'].'" />';
		
		$this->layout='empty';
		#return(array('controller'=>'subjects','action'=>'view',$this->data));
	}
	public function view() {

		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		$isMobile = $this->request->is('mobile');
        if (!$this->Session->check('Subject.id')) $this->redirect(array('controller' => 'teachers', 'action' => 'dashboard'));
            
		if (!$this->Subject->exists($this->Session->read('Subject.id'))) {
			throw new NotFoundException(__('Invalid subject'));
		}
			
		//array
		/*
		if(!empty($this->request->data)){
		pr($this->request->data); exit();
		}*/
		//end of
		$options = array('conditions' => array('Subject.' . $this->Subject->primaryKey => $this->Session->read('Subject.id')));


		$subject = $this->Subject->find('first', array('fields' => array('Subject.id',
                                                                                 'Subject.title',
                                                                                 'Subject.description',
                                                                                 'Subject.cover_img',
                                                                                 'Subject.created',
                                                                                ),
                                                               'conditions' => array('Subject.' . $this->Subject->primaryKey => $this->Session->read('Subject.id')),
                                                               'recursive' => -1,
                                                               ));
                
        $this->Session->write('Subject.title', $subject['Subject']['title']);
		$outline = array();
		$subject_chapters = $this->Subject->Topic->find('all', array('fields' => array('Topic.id',
                                                                                               'Topic.title'),
                                                                             'conditions' => array('Topic.chapter' => '',
                                                                                                   'Topic.subject_id' => $this->Session->read('Subject.id')
                                                                                                  ),
                                                                             'order' => array('Topic.id' => 'ASC'),
                                                                             'recursive' => -1
                                                                            ));

		foreach ($subject_chapters as $chapter) {
			$chapters_topics = $this->Subject->Topic->find('all', array('fields' => array('Topic.id',
                                                                                                      'Topic.title'),
                                                                                    'conditions' => array('Topic.chapter' => $chapter['Topic']['id'],
                                                                                                          'Topic.subject_id' => $this->Session->read('Subject.id')
                                                                                                         ),
                                                                                    'order' => array('Topic.id' => 'ASC'),
                                                                                    'recursive' => -1
                                                                                    ));

			$outline[] = array('Chapter' => $chapter['Topic'],
                               'Lessons' => $chapters_topics,
                              );
		}

		#pr($outline);
        $studentsCount  = $this->Subject->Student->find('count', array('fields' => array('Student.id',
                                                                                 'Student.fname',
                                                                                 'Student.lname',
                                                                                 'Student.modified',
                                                                                 'Student.section'
                                                                                ),
                                                               'conditions' => array("Student.subjects LIKE '%[{$this->Session->read('Subject.id')}]%'" ),
                                                               'order' => array('Student.modified ASC'),
                                                               'recursive' => -1
                                                              ));    	  
        $students = $this->Subject->Student->find('all', array('fields' => array('Student.id',
                                                                                 'Student.fname',
                                                                                 'Student.lname',
                                                                                 'Student.modified',
                                                                                 'Student.section'
                                                                                ),
                                                               'conditions' => array("Student.subjects LIKE '%[{$this->Session->read('Subject.id')}]%'" ),
                                                               'order' => array('Student.modified ASC'),
                                                               'recursive' => -1
                                                              ));
        //pr($studentsCount);
        
        if(!empty($this->data['searcher']))
        	$searcher = $this->data['searcher'];
        else
        	$searcher = '';

         $this->Paginator->settings = array(
				'fields' => array('Student.id',
                                 'Student.fname',
                                 'Student.lname',
                                 'Student.ext',
                                 'Student.modified',
                                 'Student.section'
                                ),
               'conditions' => array(
               	"Student.subjects LIKE '%[{$this->Session->read('Subject.id')}]%'",
				"OR" => array(
						"Student.fname LIKE" => "%".$searcher."%",
						"Student.lname LIKE" => "%".$searcher."%",
						"Student.ext LIKE" => "%".$searcher."%",
						"Student.section LIKE" => "%".$searcher."%"
					)
               	),
				'order' => array('Student.modified ASC')
               ,'limit' => 25
			);
         $students = $this->Paginator->paginate($this->Subject->Student);
		#pr($this->Paginator->paginate($this->Subject->Student));

        $quizzes = new Quizzes();
        $quizzesData = $quizzes->find('all',array('fields' => 'DISTINCT topic_id,subject_id,','conditions'=>array(
        	'teacher_id' => $this->Session->read('User.id')
        	),'recursive' => -1));
        $quzzesArr = array();
        foreach($quizzesData as $qd){
        	array_push($quzzesArr,$qd);
        }

       //progress
        $security = new Security();
        $readpage = new Readpage();
        $quizresult = new Quizresult();
        $starr = array();
	       $readpageData = $readpage->find('all',array('fields' => 'topic_id,subject_id,page_read,student_id,total_page,time_finished_read','conditions' => array(
				'subject_id' => $subject['Subject']['id']
				
				),'recursive' => -1));
		    $quizresultData = $quizresult->find('all',array('fields' => 'student_id,topic_id,subject_id,score,total_score','conditions' => array(
		    	'subject_id' => $subject['Subject']['id']
		    	
		    	),'recursive'=> -1));
		   
		    //load json data
		    $server = 'http://192.168.12.5';
		    $url = $server.'/cis/class_advisories/show_sections/index.ctp';
			$url2 = '';
			$datas = '';
			//if(!empty($this->params['url']['section']) && !empty($this->params['url']['id']) && !empty($this->params['url']['batch']))
			//$url2 = 'http://192.168.12.65/cis/students/show_students/'.$this->params['url']['id'].'/'.$this->params['url']['batch'];
			#$url = 'file:///home/jejetabadzki/Downloads/wew.txt';
			//echo $url2;
			
			//$sl2 = file_get_contents($url);
			//pr($sl2);
			function loadFile($url) {
			    $ch = curl_init();

			    curl_setopt($ch, CURLOPT_HEADER, 0);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_URL, $url);

			    $data = curl_exec($ch);
			    curl_close($ch);

			    return $data;
			}
			
			if(!empty($this->params['url']['sections']))
				$datas = loadFile($url); 

			#$data2 = '';
			$studentData = new Student();
			# pr($this->data);
			 $sectioDataArr = array();
			 $dataArr = array();
			 $dataArr2 = array();
			 $sectionDataArr2 = array();
			 $dataArr3 = array();
			 $dataArr4 = array();
			 $listOfStudentsArr = array();
			 $listOfStudentsArr2 = array();
			 $countStudents = 0;
			
			 if(!empty($this->data['Student_checkbox'])){
			 	#pr($this->data);
			 	$listOfStudentsData = '';
			 	$limitDisData = 0;
			 	#$limitDisData = count($this->data['Student_checkbox']);
			 		#pr($limitDisData);
			 	
			 	foreach($this->data['Student_checkbox'] as $stc){
			 		
			 		#pr($stc);
			 		$countStudents += 1;
			 		$listOfStudentsData = explode('!', $stc);
			 		

			 		$dataArr3 = array(
		 				'id' => $listOfStudentsData[0],
		 				'email' => $listOfStudentsData[1],
		 				'fname' => $listOfStudentsData[2],
		 				'lname' => $listOfStudentsData[3],
		 				'ext' => $listOfStudentsData[4],
		 				'section' => $listOfStudentsData[5],
		 				'pword' => null,
		 				'subjects' => '['.$subject['Subject']['id'].']'
		 			);
		 			
			 		#array_push($listOfStudentsArr2,$dataArr2);
			 			#pr($countStudents);
				 	if(!empty($dataArr3)){
				 		#pr($listOfStudentsArr2);
				 		//$limitData
			 			
			 			$studentDataCheck = $studentData->find('all',array('fields'=> 'id,email,lname,fname,ext,section,pword,subjects','conditions'=>array(
					 			'email' => $dataArr3['email'],
					 			'section' => $dataArr3['section']
					 			
					 			),'recursive'=> -1));

			 			//pr($dataArr3);
			 			

			 			if(!empty($studentDataCheck)){
			 					$strr = '';
					 			#$countSubjects = 0;
					 			
					 			foreach($studentDataCheck as $sd2){
					 				$subjectSubmitted = $subject['Subject']['id'];

					 				$sample = $sd2['Student']['subjects'];
					 				$strr = str_replace('][', '-', $sample);
					 				$strr = str_replace('[', '', $strr);
					 				$strr = str_replace(']', '', $strr);
					 				$strr = explode('-', $strr);
					 				
					 				for($j=0;$j<count($strr);$j++){
					 					
										$isExsist = strpos($sd2['Student']['subjects'], $subjectSubmitted);
										
										if($isExsist){
							 				$dataArr4 = array(
								 				#'id' => $sd2['Student']['id'],
								 				'email' => $sd2['Student']['email'],
								 				'fname' => $sd2['Student']['fname'],
								 				'lname' => $sd2['Student']['lname'],
								 				'ext' => $sd2['Student']['ext'],
								 				'section' => $sd2['Student']['section'],
								 				'pword' => $sd2['Student']['pword'],
								 				'subjects' => $sd2['Student']['subjects']

								 			);
								 			$dataArr4['Student']['id'] = $sd2['Student']['id'];
							 					#if($counter >= $limitData){
								 					
								 					if ($studentData->save($dataArr4)) {
														$this->Session->setFlash(__('Students are already invited.'), 'default', array('class' => 'alert alert-success'));
														//activity logs start here
															$ids = $this->Session->read('User.id');
															$name = $this->Session->read('User.wholename');
															$activity = 'Invited a student but student is already invited.';
															$this->createLogs($ids,0,$name,$activity);
														//end logs
													} else {
														$this->Session->setFlash(__('Students could not be invited. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
													}
							 					#}
												
							 			}else{
							 				
													$dataArr4 = array(
								 				'id' => $sd2['Student']['id'],
								 				'email' => $sd2['Student']['email'],
								 				'fname' => $sd2['Student']['fname'],
								 				'lname' => $sd2['Student']['lname'],
								 				'ext' => $sd2['Student']['ext'],
								 				'section' => $sd2['Student']['section'],
								 				'pword' => $sd2['Student']['pword'],
								 				'subjects' => $sd2['Student']['subjects'].'['.$subjectSubmitted.']'

								 			);
								 			
													if ($studentData->save($dataArr4)) {
														$this->Session->setFlash(__('New Students has been invited.'), 'default', array('class' => 'alert alert-success'));
														//activity logs start here
															$ids = $this->Session->read('User.id');
															$name = $this->Session->read('User.wholename');
															$activity = 'Invited a new student in a subject titled: '.$this->Session->read('Subject.title');
															$this->createLogs($ids,0,$name,$activity);
														//end logs
													} else {
														$this->Session->setFlash(__('Students could not be invited. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
													}
							 			}
					 					/**/

					 				}
					 				
						 			#$countSubjects += 1;
					 			}
					 			#pr($strr);
					 		}else{
								$studentData->create();
								if ($studentData->save($dataArr3)) {
									$this->Session->setFlash(__('New Students has been invited.'), 'default', array('class' => 'alert alert-success'));
									//activity logs start here
										$ids = $this->Session->read('User.id');
										$name = $this->Session->read('User.wholename');
										$activity = 'Invited a new student in a subject titled: '.$this->Session->read('Subject.title');
										$this->createLogs($ids,0,$name,$activity);
									//end logs
									
								} else {
									$this->Session->setFlash(__('Students could not be invited. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
								}
						}
						$limitDisData = $countStudents;
				 	}
			 	}
			 	if($countStudents == $limitDisData)
				return $this->redirect(array('controller' => 'subjects ', 'action' => 'view'));
			 }
			 
		if(!empty($this->request->data['studentsBtn'])){
			 
			 if(!empty($this->data['Section_checkbox'])){

			 	$sectionData = $this->data['Section_checkbox'];
			 	$count= 0;
			 	$counter = 0;
			 	foreach($sectionData as $sd){
			 		$explodedData = explode('-',$sd);
			 		
			 		$sectioDataArr = array(

			 					'Data' => $explodedData

			 			);
			 		
			 	#pr($sectioDataArr);
			 		
				 	$url2 = $server.'/cis/students/show_students/'.$sectioDataArr['Data'][0].'/'.$sectioDataArr['Data'][1];
				 	
				 	$dataStudents = loadFile($url2);
				 	$parseJson  = json_decode($dataStudents,true);
				 	//pr($parseJson);
				 	$limitData = 0;
				 	
					 	foreach($parseJson as $pj){
					 		$counter += 1;

					 		//pr($pj);
					 		//$subject['Subject']['title']
					 		$dataArr = array(
					 				'id' => $pj['Student']['id'],
					 				'email' => $pj['Student']['student_id'],
					 				'fname' => $pj['Student']['pd_fname'],
					 				'lname' => $pj['Student']['pd_lname'],
					 				'ext' => $pj['Student']['pd_ext'],
					 				'section' => $sectioDataArr['Data'][2],
					 				'pword' => null, //$security->hash('citeinfo')
					 				'subjects' => '['.$subject['Subject']['id'].']'
					 			);
					 		
					 		#pr($dataArr);
					 		#array_push($listOfStudentsArr,$dataArr);
					 		
					 		$studentData2 = $studentData->find('all',array('fields'=> 'id,email,lname,fname,ext,section,pword,subjects','conditions'=>array(
					 			'email' => $dataArr['email'],
					 			'section' => $dataArr['section']
					 			
					 			),'recursive'=> -1));
					 		
					 		if(!empty($studentData2)){
					 			
					 			$strr = '';
					 			#$countSubjects = 0;
					 			
					 			foreach($studentData2 as $sd2){
					 				$subjectSubmitted = $subject['Subject']['id'];

					 				
					 				$sample = $sd2['Student']['subjects'];
					 				$strr = str_replace('][', '-', $sample);
					 				$strr = str_replace('[', '', $strr);
					 				$strr = str_replace(']', '', $strr);
					 				$strr = explode('-', $strr);
					 				
					 				for($j=0;$j<count($strr);$j++){
					 				
										$isExsist = strpos($sd2['Student']['subjects'], $subjectSubmitted);
										
										if($isExsist){
							 				$dataArr2 = array(
								 				#'id' => $sd2['Student']['id'],
								 				'email' => $sd2['Student']['email'],
								 				'fname' => $sd2['Student']['fname'],
								 				'lname' => $sd2['Student']['lname'],
								 				'ext' => $sd2['Student']['ext'],
								 				'section' => $sd2['Student']['section'],
								 				'pword' => $sd2['Student']['pword'],
								 				'subjects' => $sd2['Student']['subjects']

								 			);
								 			$dataArr2['Student']['id'] = $sd2['Student']['id'];
							 					#if($counter >= $limitData){
								 					
								 					if ($studentData->save($dataArr2)) {
														$this->Session->setFlash(__('Students are already invited.'), 'default', array('class' => 'alert alert-success'));
														#if($counter >= $limitData)
														#return $this->redirect(array('controller' => 'subjects ', 'action' => 'view'));
														
													} else {
														$this->Session->setFlash(__('Students could not be invited. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
													}
							 					#}
												
							 			}else{
							 				
													$dataArr2 = array(
								 				'id' => $sd2['Student']['id'],
								 				'email' => $sd2['Student']['email'],
								 				'fname' => $sd2['Student']['fname'],
								 				'lname' => $sd2['Student']['lname'],
								 				'ext' => $sd2['Student']['ext'],
								 				'section' => $sd2['Student']['section'],
								 				'pword' => $sd2['Student']['pword'],
								 				'subjects' => $sd2['Student']['subjects'].'['.$subjectSubmitted.']'

								 			);
								 			#pr($dataArr2);
								 			//update Data
												
													if ($studentData->save($dataArr2)) {
														$this->Session->setFlash(__('New Students has been invited.'), 'default', array('class' => 'alert alert-success'));
														#if($counter >= $limitData)
														#return $this->redirect(array('controller' => 'subjects ', 'action' => 'view'));
														
													} else {
														$this->Session->setFlash(__('Students could not be invited. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
													}
							 			}
					 					/**/

					 				}
					 				
						 			#$countSubjects += 1;
					 			}
					 			#pr($strr);
					 		}else{
					 			
					 			
								$studentData->create();
								if ($studentData->save($dataArr)) {
									$this->Session->setFlash(__('New Students has been invited.'), 'default', array('class' => 'alert alert-success'));
									
									
								} else {
									$this->Session->setFlash(__('Students could not be invited. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
								}
								
								
							}
							$limitData = $counter;
					 	}
				 		
					/**/
					#pr($url2);
			 		#pr($sectioDataArr);
			 		$count += 1;
			 	}
			 	if($counter == $limitData)
				return $this->redirect(array('controller' => 'subjects ', 'action' => 'view'));
			 	#pr('limit:'.$limitData);
			 	#pr('total:'.$counter);
			 	//$sectionData = explode('-',$sectionData[0]);
			 	#$sectionData = explode('[', $this->data['Section_checkbox']);
			 	#$sectionData = explode('][', $sectionData);
			 	#$sectionData = explode(']', $sectionData);

			 	
			 	
			 }
			 }
				$parseJson = '';
				$inviteStudents = '<p id="invitemsg" style="font-size:12px; padding-left:30px; font-style:italic;">Enroll your students here.</p>';
				$limitDataSt = 0;
				if(!empty($this->params['url']['sid']) && !empty($this->params['url']['batch']) && !empty($this->params['url']['section'])){
					$inviteStudents = '';

					$url2 = $server.'/cis/students/show_students/'.$this->params['url']['sid'].'/'.$this->params['url']['batch'];
				 	
				 	$dataStudents = loadFile($url2);
				 	$parseJsonst  = json_decode($dataStudents,true);

				 	$limitDataSt = count($parseJsonst);
				 	
					#$inviteStudents = '<p style="font-size:12px; margin-bottom:30px; font-style:italic;">Total Sections Students: '.$limitData.'<input style="float:right; "type="submit" class="btn btn-default" name="" value="Invite"/></p>'; 

				}

				if(!empty($this->params['url']['sections']) && $this->params['url']['sections'] == 'checked'){
				$parseJson  = json_decode($datas,true);
				$TotalSectionData = count($parseJson);
				
				if($TotalSectionData != 0)
					$inviteStudents = '<p style="font-size:12px; margin-bottom:30px; font-style:italic;">Total Sections Populated: '.$TotalSectionData.'<input style="float:right; "type="submit" class="btn btn-default" name="studentsBtn" value="Enroll"/></p>';
				else
					$inviteStudents = '<p id="invitemsgSt" style="font-size:12px; margin-bottom:30px; font-style:italic;">Sorry, unable to connect to SIS database.<a href="'.$this->here.'"  onclick="recon()" style="float:right;"  class="btn btn-default" >Retry</a></p>';
				
				
				
				
			}

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

		$section = $this->Subject->Student->find('all', array('fields' => array(
                                                                                 'DISTINCT Student.section'
                                                                                ),
                                                               'conditions' => array("Student.subjects LIKE '%[{$this->Session->read('Subject.id')}]%'" ),
                                                               'order' => array('Student.modified ASC'),
                                                               'recursive' => -1
                                                              ));
		
		$tempst = new Tempstudent();
		$tempst_section = $tempst->find('all',array('fields' => array('DISTINCT section')));
		//pr($tempst_section);
		$section_array = array();
		$sect_batch_array = array();
		foreach($tempst_section as $tmpsec){
			
			array_push($section_array, $tmpsec['Tempstudent']['section']);
			
		}
		//pr($section_array);
		for($i=0;$i<count($section_array);$i++){
			//pr($i);
			$tempst_section2 = $tempst->find('first',array('fields' => 'id,fname,lname,ext,section,batch,email,pword','conditions' => array(
			'section' => $section_array[$i]
			),'recursive' => -1));
			//pr($tempst_section2);
			array_push($sect_batch_array,$tempst_section2);
		}
		
		//pr($sect_batch_array);
		//enroll temporary students
		$data_arr = array();
		$data_to_save = array();

		if(!empty($this->request->data['Section_checkbox2'])){
			$data = $this->request->data['Section_checkbox2'];
			//pr($data);
			
			$tempst = new Tempstudent();
			$tempst_count = $tempst->find('count',array('fields' => 'DISTINCT section','recursive' => -1));
			//pr($tempst_count);
			if(!empty($data)){
				for($i=1;$i<=$tempst_count;$i++){
					if(empty($data[$i])){
						pr($i.' opss wala');
					}else{
					$data_arr = explode('-', $data[$i]);
					
					array_push($data_to_save,$data_arr);
					}
				}
				//pr($data_to_save);
				$count_data = 0;

				foreach($data_to_save as $dsave){
					$count_data++;
					
					$data_ar = array(
						
						'section' => $dsave[0],
						'batch' => $dsave[1],
						'subjects' => '['.$dsave[2].']'
						);

					//pr($data_ar);	
					$tempstdata = $tempst->find('all',array('fields' => 'id,fname,lname,ext,section,batch,email,pword','conditions' => array(
						'section' => $data_ar['section'],
						'batch' => $data_ar['batch']
						),'recursive' => -1));
					
					foreach($tempstdata as $stsave){
						//pr($stsave);
						$currtempSt = $studentData->find('first',array('fields'=>'id,temp_student_id,subjects','conditions'=> array(
							'temp_student_id' => $stsave['Tempstudent']['id']
							),'recursive' => -1));
						
						if(!empty($currtempSt)){
							$checkIfSubjectExist = strpos($currtempSt['Student']['subjects'],$dsave[2]);
							//pr($checkIfSubjectExist);
							if($checkIfSubjectExist){
								//update
							$data_insert = '';
								$data_ar2 = array(
								'id' => $currtempSt['Student']['id'],
								'subjects' => $currtempSt['Student']['subjects']
								);
								
								if ($this->request->is('post')) {
									
									//$this->Student->create();
									
									if($studentData->save($data_ar2)){
										$this->Session->setFlash(__('The Temporary account has been updated.'), 'default', array('class' => 'alert alert-success'));
									}else{
										$this->Session->setFlash(__('The Temporary account could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
									}
								}
							}
							else{	
								//update
							$data_insert = $currtempSt['Student']['subjects'];
								$data_ar2 = array(
								'id' => $currtempSt['Student']['id'],
								'subjects' => $currtempSt['Student']['subjects'].''.$data_ar['subjects']
								);
								
								if ($this->request->is(array('post', 'put'))) {
									
									//$this->Student->create();
									
									if($studentDatastudentData->save($data_ar2)){
										$this->Session->setFlash(__('The Temporary account has been save.'), 'default', array('class' => 'alert alert-success'));
									}else{
										$this->Session->setFlash(__('The Temporary account could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
									}
								}
								
							}
							//pr($currtempSt);
							//pr($data_ar2);
						}else{
							//save
							
								$data_ar2 = array(
								'temp_student_id' => $stsave['Tempstudent']['id'],
								'fname' => $stsave['Tempstudent']['fname'],
								'lname' => $stsave['Tempstudent']['lname'],
								'ext' => $stsave['Tempstudent']['ext'],
								'section' => $stsave['Tempstudent']['section'],
								'batch' => $stsave['Tempstudent']['batch'],
								'email' => $stsave['Tempstudent']['email'],
								'pword' => $stsave['Tempstudent']['pword'],
								'subjects' => $data_ar['subjects']
								);
								
								if ($this->request->is('post')) {
									
									$studentData->create();
									
									if($studentData->save($data_ar2)){
										
										$this->Session->setFlash(__('The Temporary account has been save.'), 'default', array('class' => 'alert alert-success'));
									}else{
										$this->Session->setFlash(__('The Temporary account could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
									}
								}
						}
					}
					if($count_data >= count($data_to_save)){
							//$this->Session->setFlash(__('The Temporary account has been enrolled from previous Subject you were in.'), 'default', array('class' => 'alert alert-success'));
							//activity logs start here
								$id = $this->Session->read('User.id');
								$name = $this->Session->read('User.wholename');
								$activity = 'Enroll a Temporary Account';
								$this->createLogs($id,0,$name,$activity);
							//end logs
							return $this->redirect(array('controller' => 'teachers','action' => 'teacher_profile'));
						}
				}
				//pr(count($data_to_save));
			}

		}
			
		
			//remove 1st tri students
			$strtmpst = '';
			foreach($tempst_section as $tmpst){
				//pr($tmpst['Tempstudent']['section']);
				$strtmpst .= '['.$tmpst['Tempstudent']['section'].']';
			}
			if(empty($tempst_section))
				$strtmpst = '';
			//pr($strtmpst);
			//------------------------------
			//remove enrolled students
			$strtmpst2 = '';
			foreach($section as $tmpst2){
				//pr($tmpst['Tempstudent']['section']);
				$strtmpst2 .= '['.$tmpst2['Student']['section'].']';
			}
			if(empty($section))
				$strtmpst2 = '';
			//pr($strtmpst);
			//------------------------------
		$this->set(compact('data_arr','strtmpst','strtmpst2'));
		$this->set(compact('sect_batch_array','tempst_section','section','notifs_read','notifs','isMobile','limitDataSt','parseJsonst','parseJson','TotalSectionData','inviteStudents','datas','readpageData','quizresultData','quzzesArr','subject', 'outline', 'students','studentsCount'));
	}
	public function deletecurrentenrolled(){
		//pr($this->request->data); exit();
		$st = new Student();
		//pr($this->Session->read('Subject'));
		if(!empty($this->request->data)){
			if(!empty($this->request->data['removeenrolledst'])){
				$tmpsecs = str_replace('][', '-', $this->request->data['currsections']);
				$tmpsecs = str_replace('[','',$tmpsecs);
				$tmpsecs = str_replace(']','',$tmpsecs);
				$tmpsecs = explode('-', $tmpsecs);
				//pr($tmpsecs);
				
				$stdata = $st->find('all',array('fields' => 'id,subjects','conditions' => array(
					'section' => $tmpsecs
					),'recursive' => -1));
				//pr(count($stdata));
				$dataStarr = array();

				foreach($stdata as $stu){
					$data = $stu['Student']['subjects'];
					$data = str_replace('['.$this->Session->read('Subject.id').']','', $data);
					//pr($data);
					$dataStarr = array(
						'id' => $stu['Student']['id'],
						'subjects' => $data
						);
					
						if ($this->request->is(array('post', 'put'))) {
					
							if ($st->save($dataStarr)) {
								$this->Session->setFlash(__('The Enrolled sections has been remove.'), 'default', array('class' => 'alert alert-success'));
							
							} else {
								$this->Session->setFlash(__('The Enrolled sections could not be removed. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
							}
							
						} 
					
				}
				//activity logs start here
					$id = $this->Session->read('User.id');
					$name = $this->Session->read('User.wholename');
					$activity = 'Remove all sections from Subject titled: '.$this->Session->read('Subjects.title');
					$this->createLogs($id,0,$name,$activity);
				//end logs
				return $this->redirect(array('action' => 'view'));

			}
		}
		exit();
	}
	public function deletetempst(){
		pr($this->request->data);
		$tmpsecs = '';
		$tmpst = new Tempstudent();
		if(!empty($this->request->data['removetempst'])){
			
			$tmpsecs = str_replace('][', '-', $this->request->data['sections']);
			$tmpsecs = str_replace('[','',$tmpsecs);
			$tmpsecs = str_replace(']','',$tmpsecs);
			$tmpsecs = explode('-', $tmpsecs);
			//pr($tmpsecs);
			
				$tmpstsecs = $tmpst->find('all',array('fields' => 'id','conditions' => array(
				'section' => $tmpsecs
				),'recursive' => -1));
				//pr($tmpstsecs);
			
			
			//delete
				$count = count($tmpstsecs);
			foreach($tmpstsecs as $tmpsc){
				$count++;
				$tmpst->id = $tmpsc['Tempstudent']['id'];
				$this->request->onlyAllow('post', 'delete');
				
				if ($tmpst->delete()) {
					
				} else {
					//$this->Session->setFlash(__('Sections could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
				}
				
			}
				//activity logs start here
						$id = $this->Session->read('User.id');
						$name = $this->Session->read('User.wholename');
						$activity = 'Remove all 1st Tri Sections: ';
						$this->createLogs($id,0,$name,$activity);
					//end logs
				$this->Session->setFlash(__('All 1st Tri sections has been deleted.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'view'));
			
		}
		//exit();
	}
	/* STUDENTS VIEW */
	public function read() {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "teacher");
		
        if (!$this->Session->check('Subject.id')) $this->redirect(array('controller' => 'students', 'action' => 'dashboard'));
            
		if (!$this->Subject->exists($this->Session->read('Subject.id'))) {
			throw new NotFoundException(__('Invalid subject'));
		}
		if(empty($this->data)){
		//activity logs start here
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Reading a subject titled: '.$this->Session->read('Subject.title');
			$this->createLogs(0,$ids,$name,$activity);
		//end logs
		}	
		$options = array('conditions' => array('Subject.' . $this->Subject->primaryKey => $this->Session->read('Subject.id')));

		$subject = $this->Subject->find('first', array('fields' => array('Subject.id',
                                                                         'Subject.title',
                                                                         'Subject.description',
                                                                         'Subject.cover_img',
                                                                         'Subject.created',
                                                                        ),
                                                       'conditions' => array('Subject.' . $this->Subject->primaryKey => $this->Session->read('Subject.id')),
                                                       'recursive' => -1,
                                                       ));
                
        $this->Session->write('Subject.title', $subject['Subject']['title']);
		$outline = array();
		$subject_chapters = $this->Subject->Topic->find('all', array('fields' => array('Topic.id',
                                                                                       'Topic.title,Topic.subject_id'),
                                                                     'conditions' => array('Topic.chapter' => '',
                                                                                           'Topic.subject_id' => $this->Session->read('Subject.id')
                                                                                          ),
                                                                     'order' => array('Topic.id' => 'ASC'),
                                                                     'recursive' => -1
                                                                    ));

		$topics = new Topic();
		date_default_timezone_set('Asia/Manila');
		$timeInterval = date('g:i:s');
		$readpage = new Readpage();
		
		foreach ($subject_chapters as $chapter) {
			$chapters_topics = $this->Subject->Topic->find('all', array('fields' => array('Topic.id',
                                                                                          'Topic.title,Topic.subject_id'),
                                                                        'conditions' => array('Topic.chapter' => $chapter['Topic']['id'],
                                                                                              'Topic.subject_id' => $this->Session->read('Subject.id')
                                                                                             ),
                                                                        'order' => array('Topic.id' => 'ASC'),
                                                                        'recursive' => -1
                                                                        ));

			$outline[] = array('Chapter' => $chapter['Topic'],
                               'Lessons' => $chapters_topics,
                              );
		}
		#pr($this->data);
		#pr($outline);
		//count pages already read
		$countChapter = 0;
		$countLessons = 0;
		$totalTopics = 0;
		$totalTopicPerChapter = '';
		$readpageData = array();
		
		$quizresult = new Quizresult();
		$currTopTaken = 0;
		$currQuizTaken = 0;
		$totalQuiz = 0;
		$totalProgress = 0;

		$quizzes = new Quizzes();

		$quizesArr = array();

		if(!empty($outline)){
						$readpageDataCheck = $readpage->find('all',array('fields' => 'Readpage.id,,Readpage.student_id,Readpage.topic_id,Readpage.subject_id,Readpage.page_read,Readpage.total_page,Readpage.time_finished_read',
									'conditions' => array(
										'student_id' => $this->Session->read('User.id'),
										'subject_id' => $outline[0]['Chapter']['subject_id'],
										'page_read' => 1
										),'recursive' => -1));
						#pr($outline);
						#pr(count($outline));
						foreach($outline as $ot){
							
							$countChapter += 1;
							
							
							foreach($ot['Lessons'] as $otl){
								$countLessons += 1;
								$totalTopicPerChapter = $ot['Chapter']['title'].' - '.$countLessons;

								
							}	
							 
						}

							$readpageData = array(
								'Readpages' => array(
										'student_id' => $this->Session->read('User.id'),
										'topic_id' => $outline[0]['Chapter']['id'],
										'subject_id' => $outline[0]['Chapter']['subject_id'],
										'page_read' => 1,
										'total_page' => $countChapter + $countLessons,
										'time_finished_read' => $timeInterval
									)
								);
							
							#pr($readpageData);
							$chapter_title = "Chapter ".$countChapter.": ".$ot['Chapter']['title'];
							if(!empty($this->data['confirm'])){   
								
								if (!empty($readpageData)) {
									#echo 'saving many times';
						              
										if(!empty($readpageDataCheck)){
											#echo 'data already exist';
											#pr($readpageDataCheck);
											
											$readpageData['Readpages']['id'] = $readpageDataCheck[0]['Readpage']['id'];
											$readpageData['Readpages']['topic_id'] = $readpageDataCheck[0]['Readpage']['topic_id'];
											$readpageData['Readpages']['subject_id'] = $readpageDataCheck[0]['Readpage']['subject_id'];
											
											if ($readpage->save($readpageData['Readpages'])) {
												$this->Session->setFlash(__('Submitted data already exist. Updating complete.'), 'default', array('class' => 'alert alert-success'));
												
								                return $this->redirect(array('controller' => 'topics', 'action' => 'read',$this->data['Readpages']['hashID']));
											} else {
												$this->Session->setFlash(__('Cannot update requested data. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
											}
											
										}else{
											$readpage->create();
											if ($readpage->save($readpageData['Readpages'])) {
												$this->Session->setFlash(__('Checking complete.'), 'default', array('class' => 'alert alert-success'));
												
								               return $this->redirect(array('controller' => 'topics', 'action' => 'read',$this->data['Readpages']['hashID']));
											} else {
												$this->Session->setFlash(__('Cannot complete requested data. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
											}
										}
								} else {

									$this->Session->setFlash(__('The topic could not be saved. Please complete the required fields.'), 'default', array('class' => 'alert alert-danger'));
								}
								
							}
						
								#pr($readpageDataCheck);
						$totalTopics = $countChapter + $countLessons;
						#pr($readpageDataCheck);

						//progress bar here
						
						
						if(!empty($readpageDataCheck)){
							$quizresultData = $quizresult->find('all',array('fields' => 'Quizresult.quiz_id,Quizresult.student_id,Quizresult.topic_id,Quizresult.subject_id,Quizresult.score,Quizresult.total_score','conditions' => array(
								'student_id' => $readpageDataCheck[0]['Readpage']['student_id']
								
								),'recursive'=> -1));

						#pr($quizresultData);
							
							foreach($readpageDataCheck as $rpdc){
								$currTopTaken += 1;
								#pr($rpdc);
							}

							$totalcqt = array();
							$totaltq = array();
							foreach($quizresultData as $qrd){
								$currQuizTaken = $qrd['Quizresult']['score'];
								$totalQuiz = $qrd['Quizresult']['total_score'];
								array_push($totalcqt,$currQuizTaken);
								array_push($totaltq,$totalQuiz);

							}


							//progress 
							$current_topic_taken = $currTopTaken;
					        $total_topic = $totalTopics;

					        $current_quiz_taken = array_sum($totalcqt);
					        $total_quiz = array_sum($totaltq);

					        $average_topic_taken = 0;
							if($current_topic_taken != 0)
							$average_topic_taken = ($current_topic_taken / $total_topic) * 100;
							

							$average_quiz_taken = 0;
							if($current_quiz_taken != 0)
					        $average_quiz_taken = ($current_quiz_taken / $total_quiz)*100;
					    	

					        $average = $average_topic_taken + $average_quiz_taken;

					       	$totalProgress = 0;

					        if($average != 0){
					        $totalProgress = $average / 2;
					    	$totalProgress = number_format($totalProgress, 2, '.', '');
							}
							
							/*
							$progressData = array(
								'Subject' => $subject['Subject']['title'],
								'topic' => ,
								'' => ,
								);
							*/
							$quizzesDataCheck = $quizzes->find('all',array('fields' => 'DISTINCT topic_id, subject_id','conditions' => array(
							'subject_id' => $readpageDataCheck[0]['Readpage']['subject_id'],
								

							),'recursive'=> -1));

							
							foreach($quizzesDataCheck as $qdc2){
								#$quizesArr = $qdc2;
								array_push($quizesArr,$qdc2);
							}
						
						}
		
		}
		
		#pr($quizesArr);
		$this->set(compact('quizesArr','totalProgress','readpageDataCheck','readpageData','subject', 'outline', 'students','countChapter','countLessons','totalTopics'));
	}
	/* END OF STUDENTS VIEW */

	/**
	* add method
	*
	* @return void
	*/
	public function add() {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		if ($this->request->is('post')) {
			#pr($this->data); exit();

			if (!empty($this->request->data['Subject']['title'])) {
				$this->request->data['Subject']['teacher_id'] = $this->Session->read('User.id');
				#$this->data
				$this->Subject->create();
				if ($this->Subject->save($this->request->data)) {
					$this->Session->setFlash(__('The subject has been saved.'), 'default', array('class' => 'alert alert-success'));
					
					//activity logs start here
						$id = $this->Session->read('User.id');
						$name = $this->Session->read('User.wholename');
						$activity = 'Added a new subject Titled: '.$this->request->data['Subject']['title'];
						$this->createLogs($id,0,$name,$activity);
					//end logs

					return $this->redirect(array('controller' => 'teachers', 'action' => 'teacher_profile'));
				} else {
					$this->Session->setFlash(__('The subject could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
				}
			} else {
				$this->Session->setFlash(__('The subject could not be saved. Please complete the required fields.'), 'default', array('class' => 'alert alert-danger'));
			}

			
		}
		$teachers = $this->Subject->Teacher->find('list');
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
		$this->set(compact('teachers'));
	}

	/**
	* edit method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function edit($id = null) {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		if (!$this->Subject->exists($id)) {
			throw new NotFoundException(__('Invalid subject'));
		}
		//pr($this->request->data);
		
		if ($this->request->is(array('post', 'put'))) {
			
			$this->request->data['Subject']['id'] = $id;
			if ($this->Subject->save($this->request->data)) {
				$this->Session->setFlash(__('The subject has been updated.'), 'default', array('class' => 'alert alert-success'));
			
				return $this->redirect(array('controller' => 'subjects','action' => 'view'));
			} else {
				$this->Session->setFlash(__('The subject could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} 
		/*else {
			$options = array('conditions' => array('Subject.' . $this->Subject->primaryKey => $id));
			$this->request->data = $this->Subject->find('first', $options);
		}*/
		$teachers = $this->Subject->find('first',array('conditions' => array(
			'teacher_id' => $this->Session->read('User.id'),
			'id' => $id
			),'recursive' => -1));
		//pr($teachers);
		if(!empty($this->request->data)){
		//activity logs start here
			$id = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Update a Subject Description: '.$this->request->data['Subject']['description'];
			$this->createLogs($id,0,$name,$activity);
		//end logs
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
		$this->set(compact('notifs','notifs_read','isMobile'));
		$this->set(compact('teachers','id'));
	}

	/**
	* delete method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function delete($id = null) {
		$this->Subject->id = $id;
		if (!$this->Subject->exists()) {
			throw new NotFoundException(__('Invalid subject'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ($this->Subject->delete()) {
			$this->Session->setFlash(__('The subject has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The subject could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function remove($id = null) {
		$this->Subject->id = $id;
		if (!$this->Subject->exists()) {
			throw new NotFoundException(__('Invalid subject'));
		}
		$subjectRemoved = $this->Subject->find('first',array('fields' => 'title','conditions' => array(
			'id' => $id
			),'recursive' => -1));
			
		//activity logs start here
			$id = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Removed a subject Titled: '.$subjectRemoved['Subject']['title'];
			$this->createLogs($id,0,$name,$activity);
		//end logs


		$this->request->onlyAllow('get');
		if ($this->Subject->delete()) {
			$this->Session->setFlash(__('The subject has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The subject could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('controller' => 'teachers', 'action' => 'teacher_profile'));
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