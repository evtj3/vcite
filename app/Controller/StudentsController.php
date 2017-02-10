<?php
App::uses('AppController', 'Controller');
App::uses('Security','Utility');
/**
 * Students Controller
 *
 * @property Student $Student
 * @property PaginatorComponent $Paginator
 */
App::import('Model', 'Subject');
App::import('Model', 'Topic');
App::import('Model', 'Quizzes');
App::import('Model', 'Quizresult');
App::import('Model' , 'Log');
App::import('Model' , 'Notification');
App::import('Model' , 'Tempstudent');
class StudentsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Context', 'Detergent');
	public $helpers = array('Detergent');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student,teacher");

		$subject = new Subject();
		/*
		$this->Paginator->settings = array(
				'conditions' => array('')
			);
		*/
		
		$this->Student->recursive = 0;
		$this->set('students', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function listloas(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$subject = new Subject();
		$sub = $subject->find('all',array('fields' => 'id','conditions' => array(
				'teacher_id' => $this->Session->read('User.id')
			),'recursive' => -1));
		

		$quizResult = new Quizresult();
		$list = array();
		$lists = '';
		foreach($sub as $sb){

			$quizData = $quizResult->find('all',array( 'fields'=>'subject_id,student_id','conditions' => array(
				
				'subject_id' => $sb['Subject']['id']
				),'recursive' => -1));
			foreach($quizData as $qd){
					#array_push($list, $qd['Quizresult']['student_id']);
						#pr($qd['Quizresult']['student_id']);
						#$list = array_merge($qd['Quizresult']['student_id'])
						#$list = implode(",",$qd['Quizresult']['student_id']);
						#$list = $qd['Quizresult']['student_id'];
						#$lists .= '['.$qd['Quizresult']['student_id'].']';
						
						#$list = $qd['Quizresult']['student_id'];
						array_push($list, $qd['Quizresult']['student_id']);
			}
			
		}
		
		$this->Paginator->settings = array(
				'conditions' => array(
						'Student.id' => $list
					)
			);
		#$this->Student->recursive = 0;
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
		$this->set('list', $this->Paginator->paginate());
	}
	public function view($id = null) {
		if (!$this->Student->exists($id)) {
			throw new NotFoundException(__('Invalid student'));
		}
		$options = array('conditions' => array('Student.' . $this->Student->primaryKey => $id));
		$this->set('student', $this->Student->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */

public function deletetempst() {
		/*
		$this->Student->id = $id;
		if (!$this->Student->exists()) {
			throw new NotFoundException(__('Invalid student'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Student->delete()) {
			$this->Session->setFlash(__('The student has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The student could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
		*/
	}
	public function addtempst(){
		/*
		
		//pr($this->request->data);
		$data = $this->request->data['Section_checkbox2'];
		//pr($data);
		$data_arr = array();
		$data_to_save = array();
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
					$currtempSt = $this->Student->find('first',array('fields'=>'id,temp_student_id,subjects','conditions'=> array(
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
								
								if($this->Student->save($data_ar2)){
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
								
								if($this->Student->save($data_ar2)){
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
								
								$this->Student->create();
								
								if($this->Student->save($data_ar2)){
									
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
		}elseif(empty($this->params)){

			$this->Session->setFlash(__('Sorry, You did not select a Section from the previous Subject you were in. Please try again.'), 'default', array('class' => 'alert alert-danger'));
			return $this->redirect(array('controller' => 'teachers','action' => 'teacher_profile'));
		}
		$this->set(compact('data_arr'));
		*/
	}
	public function add() {
		$tempst = new Tempstudent();
		
		if(!empty($this->request->data)){
			//pr($this->request->data);

			$section = $this->request->data['1stTriSections'];
			$total_students = $this->request->data['totalSt'];
			$batch = $this->request->data['batch'];
			$data = array();
			for($i=1;$i<=$total_students;$i++){
				$data = array(
					'fname' => 'cite',
					'lname' => 'user'.$i,
					'ext' => 'student',
					'section' => $section,
					'email' => 'citeuser'.$i.'_'.$section,
					'pword' => '6b1e9a9c6bff35398628e53ba445a36b3d66d91b',//citeinfo
					'batch' => $batch
					);
				//pr($data);
				if ($this->request->is('post')) {
					$tempst->create();
					if ($tempst->save($data)) {
						
					} else {
						$this->Session->setFlash(__('The Temporary account could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
					}
					if($i >= $total_students){
						//activity logs start here
							$id = $this->Session->read('User.id');
							$name = $this->Session->read('User.wholename');
							$activity = 'Create a new 1st Tri sections';
							$this->createLogs($id,0,$name,$activity);
						//end logs
						$this->Session->setFlash(__('The Temporary account has been saved.'), 'default', array('class' => 'alert alert-success'));
						return $this->redirect(array('controller' => 'subjects','action' => 'view'));
					}
				}
			}
			
		}	
		/*
		if ($this->request->is('post')) {
			$this->Student->create();
			if ($this->Student->save($this->request->data)) {
				$this->Session->setFlash(__('The student has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The student could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		*/
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
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Student->exists($id)) {
			throw new NotFoundException(__('Invalid student'));
		}
		$security = new Security();

		
		/*
		if(empty($this->data)){
		//activity logs start here
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Editing profile';
			$this->createLogs(0,$ids,$name,$activity);
		//end logs
		}*/	
		if ($this->request->is(array('post', 'put'))) {
			$hashpwd = $security->hash($this->request->data['Student']['pword']);
			$this->request->data['Student']['pword'] = $hashpwd;
			if ($this->Student->save($this->request->data)) {

				//activity logs start here
					$id = $this->Session->read('User.id');
					$name = $this->Session->read('User.wholename');
					$activity = 'Updated a profile';
					$this->createLogs($id,0,$name,$activity);
				//end logs

				$this->Session->setFlash(__('The student has been updated.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The student could not be update. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Student.' . $this->Student->primaryKey => $id));
			$this->request->data = $this->Student->find('first', $options);
		}

		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Student->id = $id;
		if (!$this->Student->exists()) {
			throw new NotFoundException(__('Invalid student'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Student->delete()) {
			$this->Session->setFlash(__('The student has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The student could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function invite() {

		pr($this->request->data);
		/*
		if ($this->request->is('post')) {
			#pr($this->data); exit();

			$data['Student']['fname'] = "Juan";
			$data['Student']['lname'] = $this->data['Student']['email'];
			$data['Student']['subjects'] = "[".$this->Session->read('Subject.id')."]";

			$this->Student->create();
			if ($this->Student->save($data)) {
				$this->Session->setFlash(__('Invitation successfully sent to '.$this->data['Student']['email']), 'default', array('class' => 'alert alert-success'));
				
			} else {
				$this->Session->setFlash(__('Failed sending invitation. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}

		return $this->redirect(array('controller' => 'subjects', 'action' => 'view'));
		*/
	}

	public function dashboard() {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "teacher");
		
		$folderName = basename(ROOT);

		$topicModel = new Topic();
		$mainPage = $topicModel->find('first', array('fields' => array('Topic.id',
																	   'Topic.title',
																	   'Topic.content'
																	  ), array('conditions' => array(
																	'Topic.isadmin' => 1
																	)
												 ,'recursive' => -1)));
		$topic_array = array();
		
		/*
		if(empty($this->data)){
		//activity logs start here
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Reading mainpage';
			$this->createLogs(0,$ids,$name,$activity);
		//end logs
		}	*/
		/*
		foreach($mainPage as $mainCon){
			$topic_array = array('mainTopic' => $mainCon['Topic']);
		}
		$mainPage = $topic_array;
		*/
		$studentData = $this->Student->find('all',array('fields' => 'Student.id,Student.subjects','conditions' => array('Student.id' => $this->Session->read('User')),'recursive' => -1));
		$studentArrData = array();
		foreach($studentData as $std){
			$studentArrData = $std;
		}
		$studentData = $studentArrData;
		
		#pr($studentData);
		
		$mysubjects = "";

		$mysubjects = str_replace('][', ',', $studentData['Student']['subjects']);
		$mysubjects = str_replace('[', '', $mysubjects);
		$mysubjects = str_replace(']', '', $mysubjects);

		$subjects = explode(',',$mysubjects);
		#pr($subjects);

		$countSubjects = count($subjects);

		$quiz = new Quizzes();
		$quizResult = new Quizresult();

		$subject = new Subject();
		$subjectArrData = array();
		$listOfSubject = '';
		$listOfAssestments = '';
		$lesson_counter = 0;
		$chapter_counter = 0;
		$countAssTaken = 0;
		for($i=0;$i<$countSubjects;$i++){
			$subjectData = $subject->find('all',array('fields' => 'Subject.teacher_id,Subject.id,Subject.title','conditions' => array(
			'Subject.id' => $subjects[$i]),'recursive' => -1));
		
			foreach($subjectData as $sjd){
				$listOfSubject .= '<a href="/'.$folderName.'/subjects/set_subject/'.$sjd['Subject']['id'].'"><li style="list-style:none;"><span class="glyphicon glyphicon-list-alt"></span> '.$sjd['Subject']['title'].'</li></a>';
				
				$quizData = $quiz->find('all',array('conditions' => array(
				'teacher_id' => $sjd['Subject']['teacher_id'],
				'subject_id' => $sjd['Subject']['id']
				),'limit' => 10,
				'recursive' => -1));

				foreach($quizData as $qd){
					$topicData = $topicModel->find('all',array('fields' => 'Topic.subject_id,Topic.id,Topic.title','conditions' => array(
						'id' => $qd['Quizzes']['topic_id'],
						'subject_id' => $qd['Quizzes']['subject_id']
						),'recursive' => -1));
					
					foreach($topicData as $td){
						$subjectData2 = $subject->find('all',array(
							'fields'=>'Subject.id,Subject.title',
							'conditions'=> array(
								'id' => $td['Topic']['subject_id']
													),
							'recursive' => -1));
						$chapter_counter += 1;
						foreach($subjectData2 as $sd2){
							
							$listOfAssestmentTaken = array(
								'Assestment' => array(
									'Subject' => $sd2['Subject']['title'],
									'Topic' => $td['Topic']['title']
									)
							);
							
							foreach($listOfAssestmentTaken as $loat){
									
								#pr($qd);
								$currentDate = Date("Y-m-d H:i:s");
								#pr($currentDate);
								$quizDataResult = $quizResult->find('all',array('conditions' => array(
									'quiz_id' => $qd['Quizzes']['id']
									),'recursive' => -1));

								foreach($quizDataResult as $qdr){
									
									$newQuiz = '';
									if(date('Y-m-d',strtotime($currentDate)) == date('Y-m-d',strtotime($qdr['Quizresult']['modified'])))
									$newQuiz = ' -<font style="color:red; font-style:italic;"> new </font>';

									$link = Router::url('/topics/read/', true);
									$chapter_title = "Chapter ".$chapter_counter.": ".$td['Topic']['title'];
									
									if($qdr['Quizresult']['student_id'] == $this->Session->read('User.id')){
									$listOfAssestments .= '<a href="'.$link.''.$this->Detergent->urlsafe_b64encode($qd['Quizzes']['topic_id'].'|'.$chapter_title).'"><li style="list-style:none;"> <span style="color:#000;" class="glyphicon glyphicon-user"></span> <span class="glyphicon glyphicon-briefcase"></span> '.$loat['Subject'].' ( '.$loat['Topic'].' )'.$newQuiz.'</li></a>';
									$countAssTaken += 1;
									}
									#else
									#$listOfAssestments .= '<a href="'.$link.''.$this->Detergent->urlsafe_b64encode($qd['Quizzes']['topic_id'].'|'.$chapter_title).'"><li style="list-style:none;"> <span style="opacity:0;" class="glyphicon glyphicon-user"></span> <span class="glyphicon glyphicon-briefcase"></span> '.$loat['Subject'].' ( '.$loat['Topic'].' )'.$newQuiz.'</li></a>';
								}
							}
							
						}
						
						
						
					}
					
				}
				
			}
			

			
			#pr($topics);
			
		}
		if(empty($listOfAssestments))
			$listOfAssestments = '<font style="font-style:italic;"> No assesstment taken yet</font>';

		/*
		$quizResultData = $quizResult->find('all',array('conditions' => array(
			'quiz_id' => $
			),'recursive' => -1));
		*/
		
		#echo $folderName;
		$this->set(compact('countSubjects','countAssTaken','folderName','mainPage','listOfSubject','listOfAssestments'));

	}
	public function students_profile(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "teacher");

		if (!$this->Student->exists($this->Session->read('User.id'))) {
			throw new NotFoundException(__('Invalid student'));
		}

		$my_subjects = $this->Student->find('first', array('fields' => array('Student.subjects'),
														 'conditions' => array('Student.id' => $this->Session->read('User.id')),
														 'recursive' => -1
														));

		
		
		if(!empty($my_subjects['Student']['subjects'])){
		
		$mysubjects = "";
		/*
		if(empty($this->data)){
		//activity logs start here
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Checking profile';
			$this->createLogs(0,$ids,$name,$activity);
		//end logs
		}	*/
		$mysubjects = str_replace('][', ',', $my_subjects['Student']['subjects']);
		$mysubjects = str_replace('[', '', $mysubjects);
		$mysubjects = str_replace(']', '', $mysubjects);

		
		
		$subjectModel = new Subject();
		$subjects = $subjectModel->find('all', array('fields' => array('Subject.id',
																	   'Subject.title',
																	   'Subject.description',
																	   'Subject.cover_img',
																	   'Subject.created'
																	  ),
													 'conditions' => array('Subject.id IN ('.$mysubjects.')'),
													 'recursive' => -1
													 ));
		#pr($subjects); exit();
		$subject_array = array();
		foreach ($subjects as $subject) {
			$topic_count = $subjectModel->Topic->find('count', array('conditions' => array('Topic.subject_id' => $subject['Subject']['id']),
													 			 'recursive' => -1
													 			 ));

			$subject_array[] = array('Subject' => $subject['Subject'],
									 'Topic' => $topic_count
									);
		}

		$subjects = $subject_array;
		
		//count pages read by students
		/*
		$countTotalTopics = 0;
		foreach($subjects as $sb){

			$countTotalTopics += $sb['Topic'];


		}

		pr($countTotalTopics);*/
		}else{
			$subjects = '';
		}
		$this->set(compact('subjects'));

		


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
		/* App::import('Model' , 'Log');
	
		//activity logs start here
			$id = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Login';
			$this->createLogs($id,0,$name,$activity);
		//end logs
		*/

	}

}