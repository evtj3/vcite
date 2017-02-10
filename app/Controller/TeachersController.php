<?php
App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * Teachers Controller
 *
 * @property Teacher $Teacher
 * @property PaginatorComponent $Paginator
 */
App::import('Model', 'Subject');
App::import('Model', 'Topic');
App::import('Model', 'Quizzes');
App::import('Model', 'Quizresult');
App::import('Model', 'Student');
App::import('Model', 'Readpage');
App::import('Model','Log');
App::import('Model','Otppstudent');
App::import('Model','Notification');
App::import('Model','Vcitepermission');

class TeachersController extends AppController {
	/**
	* Components
	*
	* @var array
	*/
	public $components = array('Paginator', 'Context' ,'Detergent','MobileDetect');
	public $helpers = array('Latex','Detergent','Ck');
	/**
	* index method
	*
	* @return void
	*/
	public $paginate = array(
        'limit' => 2
    );
    
	public function index() {

		$isAdmin = $this->Teacher->find('first',array('conditions' => array(
			'id' => $this->Session->read('User.id')
			),'recursive' => -1));

		
		if($isAdmin['Teacher']['isadmin'] != 1){
		$this->Session->setFlash(__('Sorry you dont have a permission to access. Please ask the administrator.'), 'default', array('class' => 'alert alert-danger'));
		return $this->redirect(array('controller' => '/'));
		}

		$this->Teacher->recursive = 0;
		$this->set('teachers', $this->Paginator->paginate());
	}
	
	/**
	* view  method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function view($id = null) {
		if (!$this->Teacher->exists($id)) {
			throw new NotFoundException(__('Invalid teacher'));
		}
		$options = array('conditions' => array('Teacher.' . $this->Teacher->primaryKey => $id));
		$this->set('teacher', $this->Teacher->find('first', $options));
	}
	public function graph(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");


		$subjects = new Subject();
		$students = new Student();
		$readPage = new Readpage();
		$quiz = new Quizzes();
		$quizResult = new Quizresult();
		$overallProg = new Otppstudent();
		$opArray = array();

		//formula for Student's Total Progress per section
		$teachersData = $this->Teacher->find('first',array('fields' => 'id','conditions'=>array(
			'id' => $this->Session->read('User.id')
			),'recursive' => -1));
		$subjectsData = $subjects->find('all',array('fields' => 'id,title','conditions' => array(
				'teacher_id' => $teachersData['Teacher']['id']
				),'recursive' => -1));
		if(!empty($this->request->data)){
			
			$studentsData = $students->find('all',array('fields' =>array(
			'Student.fname,Student.lname,Student.ext,Student.section,Student.subjects'
			),'conditions' => array('subjects LIKE "%['.$this->request->data['subject'].']%"')
			,'recursive' => 1));
		}else{
			
			
			$studentsData = $students->find('all',array('fields' =>array(
				'Student.fname,Student.lname,Student.ext,Student.section,Student.subjects'
				)
				,'recursive' => 1));
		}
		//pr($this->data);
		//formula
		$countStudent = 0;
		$stDataArr = array();
		$stDataArr2 = array();
		$stDataArr3 = array();
		$stDataArr4 = array();
		
		$stDataArr6 = array();
		//pr($studentsData);
		if(!empty($this->data['subject'])){
			//activity logs start here
				$id = $this->Session->read('User.id');
				$name = $this->Session->read('User.wholename');
				$activity = 'Create a graphical data for the Total progress of the students per subject';
				$this->createLogs($id,0,$name,$activity);
			//end logs
			foreach($studentsData as $std){

				
				$quizzesArrDataScore = array();
				$quizzesArrDataTotalScore = array();

				$readpagesArrDataRead = array();
				$readpagesArrDataTotalRead = 0;

				//pr($std['Student']);
				//pr($std['Student']['section']);
				//pr($std['Student']['id']);
				
				array_push($stDataArr,$std['Student']);
				array_push($stDataArr2,$std['Student']);

				foreach($std['Quizresult'] as $stdq){
					
						if($stdq['subject_id'] == $this->data['subject']){
							array_push($quizzesArrDataScore,$stdq['score']);
							array_push($quizzesArrDataTotalScore,$stdq['total_score']);
						}
					
				}
				
				$quizzesArrDataScore = array_sum($quizzesArrDataScore);
				$quizzesArrDataTotalScore = array_sum($quizzesArrDataTotalScore);

				//pr($quizzesArrDataScore);
				//pr($quizzesArrDataTotalScore);

				if($quizzesArrDataTotalScore == 0)
				$AveQuizTaken = 0;
				else
				$AveQuizTaken = ($quizzesArrDataScore / $quizzesArrDataTotalScore) * 100;
				

				//pr($AveQuizTaken);

				foreach($std['Readpage'] as $stdrp){
					//if($stdrp['subject_id'] ===	 1){
						//pr($stdrp['subject_id']);
						if($stdrp['subject_id'] == $this->data['subject']){
						array_push($readpagesArrDataRead,$stdrp['page_read']);
						$readpagesArrDataTotalRead = $stdrp['total_page'];
						}
				}
				$readpagesArrDataRead = array_sum($readpagesArrDataRead);
				
				//pr($readpagesArrDataRead);
				//pr($readpagesArrDataTotalRead);

				if($readpagesArrDataTotalRead == 0)
					$AvePageRead = 0;
				else
				$AvePageRead = ($readpagesArrDataRead / $readpagesArrDataTotalRead) * 100;

				//pr($AvePageRead);

				$totalPercentage = number_format((($AveQuizTaken + $AvePageRead) / 2),2, '.', '');
				
				//pr($totalPercentage);

				//array_unique($stDataArr2[$countStudent][]['section']);
				//pr('asdasd = '.$stDataArr2[$countStudent]['section']);
				array_push($stDataArr3,$stDataArr2[$countStudent]['section']);
				//array_push($stDataArr[$countStudent],$totalPercentage);
				//save overall total progress per section
				//pr($std['Student']['section']);
				
				//array_push($stDataArr,$totalPercentage);
				
				if(!empty($std)){
					
					$opdata = $overallProg->find('all',array('fields'=>'id,student_id,section','conditions' => array(
						'student_id' => $std['Student']['id']
						),'recursive' => -1));				
					//pr($opdata);
					if(!empty($opdata)){
						foreach($opdata as $op){
							$opArray = array(
								'id' => $op['Otppstudent']['id'],
								'student_id' => $std['Student']['id'],
								'section' => $op['Otppstudent']['section'],
								'progress' => $totalPercentage
							);
						}
						//pr($opArray);
						if(!empty($this->data['update'])){
							if($overallProg->save($opArray)){
								//$this->Session->setFlash(__('The Overall progess has been updated.'), 'default', array('class' => 'alert alert-success'));
							}else{
								$this->Session->setFlash(__('Cannot update the progress.'), 'default', array('class' => 'alert alert-danger'));
							}
						}
					}else{
						
						$opArray = array(
							'student_id' => $std['Student']['id'],
							'section' => $std['Student']['section'],
							'progress' => $totalPercentage
						);
						$overallProg->create();
						if($overallProg->save($opArray)){
							//$this->Session->setFlash(__('The Overall progess has been saved.'), 'default', array('class' => 'alert alert-success'));
						}else{
							$this->Session->setFlash(__('Cannot save the progress.'), 'default', array('class' => 'alert alert-danger'));
						}
						
					}
				}
				$stDataArr[$countStudent]['totalPercentage'] = $totalPercentage;
				$countStudent += 1;
				
			}
			//pr($stDataArr3);
			$stDataArr3 = array_unique($stDataArr3);
			//pr($stDataArr3);
			//pr($stDataArr2);
			foreach($stDataArr3 as $sd3){
				//pr($sd3);
			
				$stDataArr5 = array();
				//overall percentage per section
				$opdata = $overallProg->find('all',array('fields'=>'section,progress','conditions' => array(
					'section' => $sd3
					),'recursive' => -1));
				
				for($i=0;$i<count($opdata);$i++){
					//pr($opdata[$i]['Otppstudent']);
					$stDataArr4 =  $opdata[$i]['Otppstudent']['progress'];
					array_push($stDataArr5,$stDataArr4);
				}
				//pr($stDataArr4);
				//pr($stDataArr5);
				//pr(array_sum($stDataArr5) / count($stDataArr5));
				$countstDataArr5 = count($stDataArr5);
				if($countstDataArr5 <= 0)
				$totalStData = 0;
				else
				$totalStData = array_sum($stDataArr5) / count($stDataArr5);
				array_push($stDataArr6,$totalStData);
			}
		}
		//pr($stDataArr6);
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
		$this->set(compact('stDataArr','stDataArr3','stDataArr6','subjectsData'));
	}
	public function get_duplicates( $array ) {
    return array_unique( array_diff_assoc( $array, array_unique( $array ) ) );
	}
	/**
	* add method
	*
	* @return void
	*/
	public function add() {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		$security = new Security();
		#pr($this->Session->read('User'));

		$isAdmin = $this->Teacher->find('first',array('conditions' => array(
			'id' => $this->Session->read('User.id')
			),'recursive' => -1));

		
		if($isAdmin['Teacher']['isadmin'] != 1)
			return $this->redirect(array('action' => 'dashboard'));

		if ($this->request->is('post')) {
			$hashpwd = $security->hash($this->request->data['Teacher']['pword']);
			$this->request->data['Teacher']['pword'] = $hashpwd;
			#pr($this->data);exit();

			$this->Teacher->create();
			if ($this->Teacher->save($this->request->data)) {
				//activity logs start here
					$id = $this->Session->read('User.id');
					$name = $this->Session->read('User.wholename');
					$activity = 'Added a new Teacher';
					$this->createLogs($id,0,$name,$activity);
				//end logs
				$this->Session->setFlash(__('The teacher has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'add'));
			} else {
				$this->Session->setFlash(__('The teacher could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
	}
	public function mainconedit($id = null){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$decoded_id = $this->Detergent->urlsafe_b64decode($id);
		$split_id = explode("|", $decoded_id);

		$folderName = basename(ROOT);
		$topicModel = new Topic();

		$topic = $topicModel->find('first',array('fields' => array('Topic.id,Topic.title,Topic.content'),array('conditions' => array('Topic.id' => $id),'recursive' => -1)));
		/*//activity logs start here
			$id = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Edit mainpage\'s public content';
			$this->createLogs($id,0,$name,$activity);
		//end logs
		
		$topicArr = array();
		foreach($topic as $topics){
			$topicArr = array('Topic' => $topics['Topic']);
		}
		$topic = $topicArr;
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
		$this->set(compact('folderName','id','split_id','topic'));
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

		$decoded_id = $this->Detergent->urlsafe_b64decode($id);
		$split_id = explode("|", $decoded_id);

		if (!$this->Teacher->exists($id)) {
			throw new NotFoundException(__('Invalid teacher'));
		}
		$security = new Security();
		
		if ($this->request->is(array('post', 'put'))) {
			
			$hashpwd = $security->hash($this->request->data['Teacher']['pword']);
			$this->request->data['Teacher']['pword'] = $hashpwd;

			if ($this->Teacher->save($this->request->data)) {
				$this->Session->setFlash(__('The teacher has been saved.'), 'default', array('class' => 'alert alert-success'));
				
				//activity logs start here
					$id = $this->Session->read('User.id');
					$name = $this->Session->read('User.wholename');
					$activity = 'Update a profile';
					$this->createLogs($id,0,$name,$activity);
				//end logs

				return $this->redirect(array('controller'=> 'teachers','action' => 'dashboard'));
			} else {
				$this->Session->setFlash(__('The teacher could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Teacher.' . $this->Teacher->primaryKey => $id));
			$this->request->data = $this->Teacher->find('first', $options);
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

	}

	/**
	* delete method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function delete($id = null) {
		$this->Teacher->id = $id;
		if (!$this->Teacher->exists()) {
			throw new NotFoundException(__('Invalid teacher'));
		}
		$list_of_names = $this->Teacher->find('first',array('fields' => 'fname,lname','conditions' =>array(
			'id' => $id
			),'recursive' => -1));
		//activity logs start here
			$id = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Delete a Teacher\'s account named: '.$list_of_names['Teacher']['fname'].' '.$list_of_names['Teacher']['lname'];
			$this->createLogs($id,0,$name,$activity);
		//end logs
		$this->request->onlyAllow('post', 'delete');
		if ($this->Teacher->delete()) {
			$this->Session->setFlash(__('The teacher has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The teacher could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function dashboard() {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		
		$isMobile = $this->request->is('mobile');
		if ($isMobile) {
			$this->Session->setFlash(__('Sorry, your are now using a mobile. If you wanted to use the file manager or edit/add/delete a content. Please change into desktop in order for you to use the important features of this application and for your convenience. If you have any concern please ask the administrator or email me: evtj393@gmail.com.'), 'default', array('class' => 'alert alert-danger'));
		}else{
			//pr('desktop mani');
		}

		$id = $this->Session->read('User.id');
		
		if (!$this->Teacher->exists($id)) {
			throw new NotFoundException(__('Invalid teacher'));
		}

		$folderName = basename(ROOT);
		$subjectModel = new Subject();
		$subjects = $subjectModel->find('all', array('fields' => array('Subject.id',
																	   'Subject.title',
																	   'Subject.description',
																	   'Subject.cover_img',
																	   'Subject.created'
																	  ),
													 //'conditions' => array('Subject.teacher_id' => $id),
													 'recursive' => -1
													 ));
		$subjects2 = $subjectModel->find('all', array('fields' => array('Subject.id',
																	   'Subject.title',
																	   'Subject.description',
																	   'Subject.cover_img',
																	   'Subject.created'
																	  ),
													 'conditions' => array('Subject.teacher_id' => $id),
													 'recursive' => -1
													 ));

		$countSubjects2 = 0;
		$subject_array2 = array();
		foreach($subjects2 as $subject2){
			$countSubjects2 += 1;
			$subject_array2[] = array('Subject' => $subject2['Subject']);	
		}
		
		$subject_array = array();
		foreach ($subjects as $subject) {
			$topic_count = $subjectModel->Topic->find('count', array('conditions' => array('Topic.subject_id' => $subject['Subject']['id']),
													 			 'recursive' => -1
													 			 ));

			$student_count = $subjectModel->Student->find('count', array('conditions' => array('Student.subjects LIKE "['.$subject['Subject']['id'].']" '),
															 			 'recursive' => -1
															 			 ));

			$subject_array[] = array('Subject' => $subject['Subject'],
									 'Topic' => $topic_count,
									 'Student' => $student_count
									);
		}

		$subjects = $subject_array;
		$subjects2 = $subject_array2;

		
		
		

		$topicModel = new Topic();
		$mainPage = $topicModel->find('first', array('fields' => array('Topic.id',
																	   'Topic.title',
																	   'Topic.content'
																	  ), array('conditions' => array(
																	'Topic.isadmin' => 1
																	)
												 ,'recursive' => -1)));
		$topic_array = array();
		
		#pr($mainPage);

		
		$quiz = new Quizzes();
		$quizResult = new Quizresult();
		$student = new Student();
		$subject = new Subject();
		$topic = new Topic();
		
		$latestAssestmentOfStudents = '';
		$countListOfAssTaken = 0;

		#$this->Paginator->settings = $this->paginate;

	    // similar to findAll(), but fetches paged results
	   

		$quizData = $quiz->find('all',array('fields' => 'Quizzes.id,Quizzes.teacher_id,Quizzes.subject_id,Quizzes.topic_id','conditions' => array(
			'Quizzes.teacher_id' => $this->Session->read('User.id')
			),'recursive'=> -1));
		$chapter_counter = 0;
		foreach($quizData as $qd){
			$quizResultData = $quizResult->find('all',array('fields'=> 'Quizresult.modified,Quizresult.student_id,Quizresult.subject_id,Quizresult.score,Quizresult.total_score,Quizresult.topic_id','conditions'=>array(
				'Quizresult.quiz_id' => $qd['Quizzes']['id']
				),'order' => 'Quizresult.modified desc','recursive' => -1));

			foreach($quizResultData as $qrd){
				$chapter_counter += 1;
				$studentData = $student->find('all',array('fields'=>'Student.fname,Student.lname,Student.ext,Student.subjects','conditions'=> array(
				'Student.subjects LIKE "%['.$qrd['Quizresult']['subject_id'].']%"',
				'Student.id' => $qrd['Quizresult']['student_id']
				),'recursive'=> -1));

				foreach($studentData as $sd){
					$subjectData = $subject->find('all',array('fields' => 'Subject.id,Subject.title','conditions' => array(
						'id' => $qrd['Quizresult']['subject_id']
						),'recursive'=> -1));
						
					foreach($subjectData as $subd){
						$topicData = $topic->find('all',array('fields'=>'Topic.id,Topic.subject_id,Topic.title','conditions'=> array(
							'subject_id' => $subd['Subject']['id'],
							'id' => $qrd['Quizresult']['topic_id']
							),'recursive' => -1));
						
						$currentDate = Date("Y-m-d H:i:s");
			
						foreach($topicData as $td){

							$newQuiz = '';
							if(date('Y-m-d',strtotime($currentDate)) == date('Y-m-d',strtotime($qrd['Quizresult']['modified'])))
							$newQuiz = ' -<font style="color:red; font-style:italic;"> new </font>';

							$name = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($sd['Student']['fname'].' '.$sd['Student']['lname'].' '.$sd['Student']['ext']))));

							$chapter_title = "Chapter ".$chapter_counter.": ".$td['Topic']['title'];
							$link = Router::url('/subjects/set_subject/', true);
							$score = $qrd['Quizresult']['score'].'/'.$qrd['Quizresult']['total_score'];
							
							if($countListOfAssTaken >= 5){
								$latestAssestmentOfStudents .= '';
							}else{
							$latestAssestmentOfStudents .= '<li style="list-style:none;"><span class="glyphicon glyphicon-user"></span> '.$name.' - ';
							$latestAssestmentOfStudents .= '<a href="'.$link.''.$subd['Subject']['id'].'">';
							$latestAssestmentOfStudents .= $subd['Subject']['title'].' ('.$td['Topic']['title'].')</a> '.$score.' '.$newQuiz.'</li>';
							}
							$countListOfAssTaken += 1;
							#pr($td);
						}
						
					}
					
				}

				
			}
		}

		if(empty($latestAssestmentOfStudents))
			$latestAssestmentOfStudents = '<font style="font-style:italic;"> No assesstment taken yet</font>';

	
		/* tutorial function start */
		$checkTeachersTutorial = $this->Teacher->find('first',array('fields' => 'istutorial','conditions' => array(
			'id' => $this->Session->read('User.id')
			),'recursive' => -1));

		$isTutorial = $checkTeachersTutorial['Teacher']['istutorial'];
		
		if($checkTeachersTutorial && !$isMobile)
		$this->eCITEtutorial($checkTeachersTutorial['Teacher']['istutorial']);
		
		$scriptTutorial = "
				<script>
					var clickedMnv = false;
					var count = 0;
						$('#tutorDiv1 button').click(function(){
							count += 1;
							if(count == 1){
								$('#tutorDiv1').fadeOut(500);
								$('#tutorDiv2').fadeIn(1000);

							}
						});
						$('#tutorDiv2 button').click(function(){
							count += 1;
							if(count == 2){
								$('#tutorDiv2').fadeOut(500);
								$('#tutorDiv3').fadeIn(1000);
							}
						});
						$('#tutorDiv3 button').click(function(){
							count += 1;
							if(count == 3){
								$('#tutorDiv3').fadeOut(500);
								$('#tutorDiv4').fadeIn(1000);
								$('html,body').animate({scrollTop:'250px'},'slow');
							}
						});
						$('#tutorDiv4 button').click(function(){
							count += 1;
							if(count == 4){
								$('#tutorDiv4').fadeOut(500);
								$('#tutorDiv5').fadeIn(1000);

							}
						});
						$('#tutorDiv5 button').click(function(){
							count += 1;
							if(count == 5){
								$('#tutorDiv5').fadeOut(500);
								$('#tutorDiv6').fadeIn(1000);
								$('html,body').animate({scrollTop:'550px'},'slow');
							}
						});
						$('#tutorDiv6 button').click(function(){
							count += 1;
							if(count == 6){
								$('#tutorDiv6').fadeOut(500);
								$('#tutorDiv7').fadeIn(1000);
								$('html,body').animate({scrollTop: '0'},'slow');
							}
						});
						$('#blackScreen').fadeIn('slow');
						$('#mainTutorDiv').fadeIn('slow');
						$('#tutorDiv1').fadeIn(1000);
						
						

				</script>
		";
		/* tutorial function end */

		//notifications
		$notification = new Notification();
		$notifs = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers NOT LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'order' => array(
							'created' => 'desc'
						),'recursive' => -1));
		$notifs_read = $notification->find('all',array('conditions' => array(
			'notif_teachers LIKE "%['.$this->Session->read('User.id').']%"',
			'notified_teachers LIKE "%['.$this->Session->read('User.id').']%"'
			
			),'order' => array(
							'modified' => 'desc'
						),'recursive' => -1));
		
		//notifications
		
		/* vcite permission */
		$vPermit = new Vcitepermission();

		$vPermit_data = $vPermit->find('first',array('recursive' => -1));
		/*------------------*/

		$this->set(compact('vPermit_data','notifs','notifs_read','isMobile','scriptTutorial','isTutorial','countSubjects2','countListOfAssTaken','folderName','subjects','subjects2','mainPage','latestAssestmentOfStudents'));
	}
	public function edit_profile(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$id = $this->Session->read('User.id');
		
		if (!$this->Teacher->exists($id)) {
			throw new NotFoundException(__('Invalid teacher'));
		}


	}
	public function teacher_profile(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		
		$id = $this->Session->read('User.id');
		
		if (!$this->Teacher->exists($id)) {
			throw new NotFoundException(__('Invalid teacher'));
		}

		$isMobile = $this->request->is('mobile');
		if ($isMobile) {
			$this->Session->setFlash(__('Sorry, your are now using a mobile. If you wanted to use the file manager or edit/add/delete a content. Please change into desktop in order for you to use the important features of this application and for your convenience. If you have any concern please ask the administrator or email me: evtj393@gmail.com.'), 'default', array('class' => 'alert alert-danger'));
		}else{
			//pr('desktop mani');
		}

		$subjectModel = new Subject();
		$subjects = $subjectModel->find('all', array('fields' => array('Subject.id',
																	   'Subject.title',
																	   'Subject.description',
																	   'Subject.cover_img',
																	   'Subject.created'
																	  ),
													 'conditions' => array('Subject.teacher_id' => $id),
													 'recursive' => -1
													 ));
		$subject_array = array();
		foreach ($subjects as $subject) {
			$topic_count = $subjectModel->Topic->find('count', array('conditions' => array('Topic.subject_id' => $subject['Subject']['id']),
													 			 'recursive' => -1
													 			 ));
			$subjectData = $subject['Subject']['id'];

			
			$student_count = $subjectModel->Student->find('count', array('conditions' => array('Student.subjects LIKE "%['.$subject['Subject']['id'].']%"'),
															 			 'recursive' => -1
															 			 ));
			

			$subject_array[] = array('Subject' => $subject['Subject'],
									 'Topic' => $topic_count,
									 'Student' => $student_count
									);
		}

		$subjects = $subject_array;
		// activity logs

		$students = new Student();
		$actLogs = new Log();
		$ActivityLogsStudents = array();
		$teacherLogs = $this->Teacher->find('all',array('conditions'=>array(
				'id' => $this->Session->read('User.id')
			),'recursive' => 1));

		foreach($teacherLogs as $tl){
			
			foreach($tl['Subject'] as $subj){
				
				$studentLogs = $students->find('all',array('conditions' => array(
					'subjects LIKE "%['.$subj['id'].']%"'
					),'recursive' => -1));

				foreach($studentLogs as $stl){
					
					$countlogs = $actLogs->find('count',array('conditions'=> array(
						'fkey_st_id' => $stl['Student']['id']
						),'recursive' => -1));

					$logs = $actLogs->find('all',array('conditions'=> array(
						'fkey_st_id' => $stl['Student']['id']
						),'recursive' => -1));

					array_push($ActivityLogsStudents,$logs);
				}
				
			}
		}
		$countlogs = 0;
		$logs2 = array();
		foreach($ActivityLogsStudents as $alst){
			foreach($alst as $st){
				$countlogs += 1;
				$logs = $st;
				array_push($logs2,$logs);

			}
		}
		$logStudents = array();
		foreach($logs2 as $lg2){
			array_push($logStudents,$lg2['Log']['id']);
		}
		#pr($logStudents);
		
		$logs2 = $actLogs->find('all',array('conditions'=> array(
						'id' => $logStudents
						),'limit' => 5,'order' => array(
							'Log.modified' => 'desc'
						),'recursive' => -1));
		$countLogDistinctUser = $actLogs->find('all',array('fields'=>array(
				'DISTINCT (Log.fkey_st_id)'
			),'conditions'=> array(
						'id' => $logStudents
						),'limit' => 5,'order' => array(
							'Log.modified' => 'desc'
						),'recursive' => -1));
		#$logs2 = array_splice($logs2, 0,5);
	#	pr($countLogDistinctUser);
		//$isMobile = $this->request->is('mobile');
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
		$this->set(compact('notifs','notifs_read'));
		$this->set(compact('isMobile','subjects','logs2','countlogs','countLogDistinctUser'));
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
	/* my tutorial function - start*/
	public function eCITEtutorial($isTutorial){
		
		if($isTutorial){
			
			#pr('Tutorial Begin.');
			/* desktop tutorial*/
			echo '<div id="mainTutorDiv" style="display:none;">';
			echo '<div class="row" id="tutorDiv1" >';
			echo '
						<div class="col-md-10">
							<div class="directionSpan1" >
								<span style="font-size:45px; right:-256px; top:15px;  " class="glyphicon glyphicon-arrow-right"></span>
							</div>
							<h3>Teacher\'s profile</h3>
							<ul >
								<li><p><span class="glyphicon glyphicon-record"></span> Edit personal information</p></li>
								<li><p><span class="glyphicon glyphicon-record"></span> Create a new subject</p></li>
								<li><p><span class="glyphicon glyphicon-record"></span> Create a new Topic within a subject</p></li>
								<li><p><span class="glyphicon glyphicon-record"></span> Create a quiz within a Topic</p></li>
								<li><p><span class="glyphicon glyphicon-record"></span> Create a Math Equations</p></li>
								<li><p><span class="glyphicon glyphicon-record"></span> Activity logs of the students</p></li>
								<li style="text-align:right;"><button class="btn btn-default">Next</button></li>
							</ul>

						</div>
						
			';
			echo '</div>';
			
			echo '<div class="row" id="tutorDiv2">';
			echo '
						<div class="col-md-10">
							<div class="directionSpan2">
								<span style="font-size:45px; right:10px; top:-34px;  " class="glyphicon glyphicon-arrow-up"></span>
							</div>
							<h3>File Manager</h3>
							<ul >
								<li><p><span class="glyphicon glyphicon-record"></span> Upload files (pdf, image, swf and video)</p></li>
								<li><p><span class="glyphicon glyphicon-record"></span> Download</p></li>
								<li><p><span class="glyphicon glyphicon-record"></span> Organize files (Edit, delete, rename, create, rename & delete a folder)</p></li>
								<li style="text-align:right;"><button class="btn btn-default">Next</button></li>
							</ul>
						</div>
						
			';
			echo '</div>';
			
			echo '<div class="row" id="tutorDiv3">';
			echo '
						<div class="col-md-10">
							<div class="directionSpan3">
								<span style="font-size:45px; right:-110px; top:-34px;  " class="glyphicon glyphicon-arrow-up"></span>
							</div>
							<h3>Statistics</h3>
							<ul >
								<li><p><span class="glyphicon glyphicon-record"></span> Create a Graphical Data of your invited students per subject</p></li>
								<li style="text-align:right;"><button class="btn btn-default" >Next</button></li>
							</ul>
						</div>
						
			';
			echo '</div>';
			echo '<div class="row" id="tutorDiv4" >';
			echo '
						<div class="col-md-10">
							<div class="directionSpan4">
								<span style="font-size:45px; right:51px; top:39px;  " class="glyphicon glyphicon-arrow-left"></span>
							</div>	
							<h3>Creating a subject</h3>
							<ul >
								<li><p><span class="glyphicon glyphicon-record"></span> If you don\'t have a subject yet, just click the link. It will redirect you to the [add new subject] page.</p></li>
								<li style="text-align:right;"><button class="btn btn-default" >Next</button></li>
							</ul>
						</div>
						
			';
			echo '</div>';
			echo '<div class="row" id="tutorDiv5">';
			echo '
						<div class="col-md-10">
							<div class="directionSpan5">
								<span style="font-size:45px; right:-256px; top:39px;  " class="glyphicon glyphicon-arrow-right"></span>
							</div>
							<div class="directionSpan5-2">
								<span style="font-size:45px; right:-38px; top:39px;  " class="glyphicon glyphicon-arrow-left"></span>
							</div>
							<h3>Latest Assesstment</h3>
							';
			
			echo '
							<ul >
								<li><p><span class="glyphicon glyphicon-record"></span> Latest assesstment of the students that are invited per subject.</p></li>
								<li><p><span class="glyphicon glyphicon-record"></span> Names , Topics and scores of the students are shown.</p></li>
								<li style="text-align:right;"><button class="btn btn-default" >Next</button></li>
							</ul>
							';
			
			echo '
						</div>
						
			';
			echo '</div>';
			echo '<div class="row" id="tutorDiv6">';
			echo '
						<div class="col-md-10">
							<div class="directionSpan6">
								<span style="font-size:45px; right:-214px; top:176px;  " class="glyphicon glyphicon-arrow-down"></span>
							</div>
							<h3>Public content</h3>
							';
			//echo '<form method="POST">';
			//echo '<form method="POST" action="teachers/tutorial">';
			//echo'<input type="hidden" name="isTutorial" value="0"/>';
			echo '
							<ul >
								<li><p><span class="glyphicon glyphicon-record"></span> This content can be seen by all. (Students and Teachers)</p></li>
								<li><p><span class="glyphicon glyphicon-record"></span> Edit (only teachers are allowed).</p></li>
								<li style="text-align:right;"><button class="btn btn-default" >Next</button></li>
							</ul>
				';
			//echo '</form>';
			//<li style="text-align:right;"><input type="submit" class="btn btn-default" value="Done!"></li>
			//<li style="text-align:right;"><input type="submit" name="mainpage" class="btn btn-default" value="Done!"></li>
			echo '
						</div>
						
			';
			echo '</div>';
			echo '<div class="row" id="tutorDiv7">';
			echo '<form method="POST" action="teachers/tutorial">';
			echo'<input type="hidden" name="isTutorial" value="0"/>';
			echo '
						<div class="col-md-10">
							<div class="directionSpan7" style="opacity:0;">
								<span style="color:#256D7D; font-size:45px; top:315px;  " class="glyphicon glyphicon-arrow-right"></span>
							</div>
							<h3>Tutorial</h3>
							<ul >
								<li><p><span class="glyphicon glyphicon-record"></span> To finish the tutorial click [Done!] </p></li>
								<li><p><span class="glyphicon glyphicon-record"></span> You want to retry the tutorial click [Retry] </p></li>
								<li style="text-align:right;"><input type="submit" name="mainpage" class="btn btn-default" value="Done!"> <a href="'.Router::url('/', true).'" class="btn btn-default" >Retry</a></li>
							</ul>

						</div>
						
			';
			echo '</form>';
			echo '</div>';
			echo '</div>';

			echo '<div id="blackScreen" style="display:none; background-color:#000; position:fixed; opacity:0.6; z-index:2; width:100%; height:100%;">';
			echo '</div>';
			//activity logs start here
				$id = $this->Session->read('User.id');
				$name = $this->Session->read('User.wholename');
				$activity = 'Started a tutorial';
				$this->createLogs($id,0,$name,$activity);
			//end logs
		}
	}
	/*check permission*/
	public function vcite_permission($isEnabled = null){

		$vPermit = new Vcitepermission();
		$Student = new Student();
		$vPermit_data = $vPermit->find('first',array('recursive' => -1));
		$students_data = $Student->find('all',array('recursive' => -1));
		//pr($students_data); exit();
		$data = array();
		$st_data = array();
		if($isEnabled == 1){
			pr('1');
			$data = array('id' => 1,'isEnabled' => 1,'list_of_sections_enabled' => null,'list_of_students_enabled' => null);
		}else{
			pr('0');
			$data = array('id' => 1,'isEnabled' => 0,'list_of_sections_enabled' => null,'list_of_students_enabled' => null);
		
		}

		if($vPermit->save($data)){
			if($data['isEnabled'] == 0){
				//reset all allowed subjects to null
				foreach($students_data as $stdata){
					$st_data = array(
						'id' => $stdata['Student']['id'],
						'allowed_subjects' => null
						);
					if($Student->save($st_data)){

					}else{

					}
				}
			}
			return $this->redirect(array('controller'=> 'teachers','action' => 'dashboard'));
		}else{

		}
		
		exit();
	}
	/*-----------------------*/
	/* my tutorial function - end*/
	public function tutorial(){
		//pr($this->data);

		$teachersTutorial = $this->Teacher->find('first',array('fields' => 'id,istutorial','conditions' => array(
			'id' => $this->Session->read('User.id')
			),'recursive' => -1));
		//pr($teachersTutorial);

		$arr = array(
				'id' => $teachersTutorial['Teacher']['id'],
				'istutorial' => $this->data['isTutorial']
			);
		//pr($arr);

		if($this->Teacher->save($arr)){
			//activity logs start here
				$id = $this->Session->read('User.id');
				$name = $this->Session->read('User.wholename');
				$activity = 'Finished a tutorial';
				$this->createLogs($id,0,$name,$activity);
			//end logs
			$this->Session->setFlash(__('Cogratulations! The tutorial was successful. You may now help the students by sharing your knowledge and skills.'), 'default', array('class' => 'alert alert-success'));
			return $this->redirect(array('controller' => 'teachers','action' => 'dashboard'));
		}else{

		}
	}
}