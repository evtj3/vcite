<?php
App::uses('AppController', 'Controller');
/**
 * Topics Controller
 *
 * @property Topic $Topic
 * @property PaginatorComponent $Paginator
 */
App::import('Model', 'Discussion');
App::import('Model', 'Question');
App::import('Model', 'Option');
App::import('Model', 'Quizzes');
App::import('Model', 'Quizresult');
App::import('Model', 'Readpage');
App::import('Model', 'Mathformula');
App::import('Model', 'Student');
App::import('Model' ,'Log');
App::import('Vendor' ,'MathjaxNode');
App::import('Model' ,'Teacher');
App::import('Model' ,'Notification');
#App::import('Vendor', 'dompdf/dompdf.php');
class TopicsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Context', 'Detergent','MobileDetect',
		'RequestHandler'
		);
	public $helpers = array('Detergent');

	/**
	* index method
	*
	* @return void
	*/
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

		$this->Topic->recursive = 0;
		$this->set('topics', $this->Paginator->paginate());
	}
	public function download_pdf($id = null) {
 	
 		$decoded_id = $this->Detergent->urlsafe_b64decode($id);
		$split_id = explode("|", $decoded_id);

		if (!$this->Topic->exists($split_id[0])) {
			throw new NotFoundException(__('Invalid topic'));
		}

		//activity logs start here
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Downloaded a topic titled: '.$split_id[1];
			if($this->Session->read('User.group') == 'teacher')
			$this->createLogs($ids,0,$name,$activity);
			if($this->Session->read('User.group') == 'student')
			$this->createLogs(0,$ids,$name,$activity);
		//end logs

		/* download pdf*/
		   $this->viewClass = 'Media';
 
		    $params = array(
		 
		        'id' => $split_id[0].'.pdf',
		        'name' => $split_id[1] ,
		        'download' => true,
		        'extension' => 'pdf',
		        'path' => APP . 'files/pdf' . DS
		    );
		 
		    $this->set($params);
		   #return $this->redirect(array('controller' => 'topics' , 'action' => 'view',$id));
 		
	}
	public function viewpdf($id = null) {
		
		$decoded_id = $this->Detergent->urlsafe_b64decode($id);
		$split_id = explode("|", $decoded_id);

		if (!$this->Topic->exists($split_id[0])) {
			throw new NotFoundException(__('Invalid topic'));
		}

           $topics = $this->Topic->find('all',array(
           		'conditions' => array('id' => $split_id[0])
           	,'recursive' => -1));
		    $this->set(compact('topics','split_id'));
		 
		    $this->layout = '/pdf/default';
		 
		   $this->render('/Pdf/my_pdf_view');
		  
		  return $this->redirect(array('controller' => 'topics' , 'action' => 'download_pdf',$id));
		   
    }
    
	/**
	* view method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function searched_data(){

		if($this->Session->read('User.group') == 'teacher'){


		$searcher = '';
		if(!empty($this->params['url']['searcher']))
			$searcher = $this->params['url']['searcher'];

		$this->Paginator->settings = array(

				'conditions' => array(
					'Subject.teacher_id' => $this->Session->read('User.id'),
						'OR' => array(
								'Topic.title LIKE' => '%'.$searcher.'%',
								'Topic.content LIKE' => '%'.$searcher.'%',
								'Subject.title LIKE' => '%'.$searcher.'%',
								'Subject.description LIKE' => '%'.$searcher.'%'
							)
					)
			);

		}elseif($this->Session->read('User.group') == 'student'){
			
			$studentModel = new Student();
			$student = $studentModel->find('all',array('fields' => 'subjects,id','conditions'=>array(
				'id' => $this->Session->read('User.id')
				)));
			$subjectsData = str_replace('][', ',', $student[0]['Student']['subjects']);
			$subjectsData = str_replace('[', ' ', $subjectsData);
			$subjectsData = str_replace(']', ' ', $subjectsData);
			$subjectsData = explode(',',$subjectsData);
			

			#pr($subjectsData);
			$subjectsInvited = $this->Topic->find('all');
			#pr($student);
			#pr($subjectsInvited);

				$searcher = '';
				if(!empty($this->params['url']['searcher']))
					$searcher = $this->params['url']['searcher'];

				$this->Paginator->settings = array(

						'conditions' => array(
							'Subject.id' => $subjectsData,
								'OR' => array(
										'Topic.title LIKE' => '%'.$searcher.'%',
										'Topic.content LIKE' => '%'.$searcher.'%',
										'Subject.title LIKE' => '%'.$searcher.'%',
										'Subject.description LIKE' => '%'.$searcher.'%'
									)
							)
					);
		}
		$this->Topic->recursive = 0;
		$this->set('topics', $this->Paginator->paginate());
	}
	public function view($id = null) {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		
		//$isMobile = $this->request->is('mobile');
		$decoded_id = $this->Detergent->urlsafe_b64decode($id);
		$split_id = explode("|", $decoded_id);

	
		if (!$this->Topic->exists($split_id[0])) {
			throw new NotFoundException(__('Invalid topic'));
		}
		
		$folderName = basename(ROOT);

		$discussionModel = new Discussion();
		if ($this->request->is('post')) {
			if (!empty($this->request->data['Discussion']['content'])) {
				

				$data['Discussion']['discussion_on'] = $decoded_id;
				$data['Discussion']['discussed_by'] = $this->Session->read('User.id')."|teacher|".$this->Session->read('User.wholename');
				$data['Discussion']['content'] = $this->request->data['Discussion']['content'];

				$discussionModel->create();
				$discussionModel->save($data);
			}
		}

		$topic = $this->Topic->find('first', array('fields' => array('Topic.content',
																	 'Topic.modified'
																	),
												   'conditions' => array('Topic.' . $this->Topic->primaryKey => $split_id[0]),
												   'recursive' => -1
												  ));

		$discussions = $discussionModel->find('all', array('fields' => array('Discussion.discussed_by',
																			 'Discussion.content',
																			 'Discussion.created'
																			),
														   'conditions' => array('Discussion.discussion_on' => $decoded_id),
														   'order' => array('Discussion.created ASC'),
														   'recursive' => -1
														  ));
		
		$ismainpage = $this->Topic->find('first',array('conditions' => array(
				'id' => $split_id[0]
			),'recursive' => -1));
		if($ismainpage['Topic']['ismainpage'] == 1){
			return $this->redirect(array('controller' => 'teachers','action' => 'dashboard'));
		}
		
		$topics = $this->Topic->find('all',array('fields' => array('Topic.id,Topic.subject_id'),'conditions'=> array('Topic.id' => $split_id[0]),'order' => array('Topic.created ASC'),
														   'recursive' => -1
														  ));

		$topicArr = array();
		foreach($topics as $topicss){
			$topicArr = array('Topic' => $topicss['Topic']);
		}
		$topics = $topicArr;

		$questionModel = new Question();
		
		$questions = $questionModel->find('all',array('fields' =>
			array('Question.id,
				Question.subject_id,
				Question.topic_id,
				Question.type,
				Question.content,
				Question.shuffle,
				Question.tag'),'conditions' => array(
					'Question.subject_id' => $topics['Topic']['subject_id']
				),'recursive' => -1
														  ));
		
		/*
		$quesCount = $questionModel->find('count',array('fields' =>
			array('Question.id,
				Question.subject_id,
				Question.type,
				Question.content,
				Question.shuffle,
				Question.tag'),'conditions' => array('Question.subject_id' => $topics['Topic']['subject_id']),'recursive' => -1
														  ));
		*/$optionModel = new Option();

		

		
		$options = $optionModel->find('all',array('fields' => array('Option.id',
			'Option.question_id','Option.options','Option.correct','Option.alternate_option'),
		#'Conditions' => array(''),
		#'order' => 'rand()',
		'recursive' => -1));
		
        
		//edit exams----------------------------modal
		$questionData_multiEdit = $questionModel->find('all',array('fields'=>'Question.id,
				Question.subject_id,
				Question.topic_id,
				Question.type,
				Question.content,
				Question.shuffle,
				Question.tag','conditions' => array(
					'topic_id' => $split_id[0],
					'type' => 'Multiple Choice'
					),'recursive' => -1));
		$questionData_tofEdit = $questionModel->find('all',array('fields'=>'Question.id,
				Question.subject_id,
				Question.topic_id,
				Question.type,
				Question.content,
				Question.shuffle,
				Question.tag','conditions' => array(
					'topic_id' => $split_id[0],
					'type' => 'True or False'
					),'recursive' => -1));
		$questionCount = $questionModel->find('count',array('conditions' => array(
			'topic_id'=> $split_id[0]
			),'recursive' => -1));
		$optionsData_multiEdit = $optionModel->find('all',array('fields'=>
			'Option.id,Option.question_id,Option.options,Option.correct','recursive' => -1));

		#pr($questionData_multiEdit);
		#pr($optionsData_multiEdit);
       # pr($this->data);
        
        if($this->request->is('Post') && !empty($this->data['ques'])){
        	
        	$totalans = count($this->data['Answer']);
        	$correct = 0;

        	for($i=1;$i<=$totalans;$i++){
        		if(!empty($this->data['ques'][$i])){
        		if($this->data['Answer'][$i] == $this->data['ques'][$i]){
        			$correct += 1;
        		#	echo $this->data['ques'][$i].'= correct</br>';
        		}else{
        		#	echo $this->data['ques'][$i].'= wrong</br>';
        		}}

        	}
        	$average = round(($correct/$totalans) * 100);
        	#echo 'Total Correct: '.$correct.'<br/>Total Wrong: '.($totalans - $correct);
        	#echo '</br>'.$average;
        }
		
		#pr($this->data);
        #pr($questions);
		//display math formulas
		$math = new Mathformula();
		 $mathformulaData = $math->find('all',array('fields' => 'id,content,size','conditions' => array(
		 	'teacher_id' => $this->Session->read('User.id')
		 	),'recursive' => -1));
       	 #pr($mathformulaData);
		 
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
        $this->set(compact(
        	'folderName',
        	'mathformulaData',
        	'id', 
        	'split_id',
        	'topics', 
        	'topic',
        	'questions',
        	'options', 
        	'discussions',
        	'questionData_multiEdit',
        	'questionData_tofEdit',
        	'optionsData_multiEdit',
        	'average',
        	'totalans',
        	'correct',
        	'questionCount'));
	}
	
	public function validate_created_data($id = null){
		

		
	}
	/* STUDENTS VIEW */
	public function read($id = null) {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "teacher");

		$decoded_id = $this->Detergent->urlsafe_b64decode($id);
		$split_id = explode("|", $decoded_id);

		if (!$this->Topic->exists($split_id[0])) {
			throw new NotFoundException(__('Invalid topic'));
		}

		//activity logs start here
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Reading a topic titled: '.$split_id[1];
			$this->createLogs(0,$ids,$name,$activity);
		//end logs

		$discussionModel = new Discussion();

		if ($this->request->is('post')) {
			if (!empty($this->request->data['Discussion']['content'])) {
				

				$data['Discussion']['discussion_on'] = $decoded_id;
				$data['Discussion']['discussed_by'] = $this->Session->read('User.id')."|student|".$this->Session->read('User.wholename');
				$data['Discussion']['content'] = $this->request->data['Discussion']['content'];

				$discussionModel->create();
				$discussionModel->save($data);
			}
		}

		$topic = $this->Topic->find('first', array('fields' => array('Topic.content',
																	 'Topic.modified'
																	),
												   'conditions' => array('Topic.' . $this->Topic->primaryKey => $split_id[0]),
												   'recursive' => -1
												  ));

		$discussions = $discussionModel->find('all', array('fields' => array('Discussion.discussed_by',
																			 'Discussion.content',
																			 'Discussion.created'
																			),
														   'conditions' => array('Discussion.discussion_on' => $decoded_id),
														   'order' => array('Discussion.created ASC'),
														   'recursive' => -1
														  ));


		$topics = $this->Topic->find('all',array('fields' => array('Topic.id,Topic.subject_id'),'conditions'=> array('Topic.id' => $split_id[0]),'order' => array('Topic.created ASC'),
														   'recursive' => -1
														  ));

		$topicArr = array();
		foreach($topics as $topicss){
			$topicArr = array('Topic' => $topicss['Topic']);
		}
		$topics = $topicArr;

		$questionModel = new Question();
		
		$questions = $questionModel->find('all',array('fields' =>
			array('Question.id,
				Question.subject_id,
				Question.topic_id,
				Question.type,
				Question.content,
				Question.shuffle,
				Question.tag'),'conditions' => array(
					'Question.subject_id' => $topics['Topic']['subject_id']
				),'recursive' => -1
														  ));
		
		/*
		$quesCount = $questionModel->find('count',array('fields' =>
			array('Question.id,
				Question.subject_id,
				Question.type,
				Question.content,
				Question.shuffle,
				Question.tag'),'conditions' => array('Question.subject_id' => $topics['Topic']['subject_id']),'recursive' => -1
														  ));
		*/$optionModel = new Option();

		

		
		$options = $optionModel->find('all',array('fields' => array('Option.id',
			'Option.question_id','Option.options','Option.correct','Option.alternate_option'),
		#'Conditions' => array(''),
		#'order' => 'rand()',
		'recursive' => -1));
		
        
		$questionCount = $questionModel->find('count',array('conditions' => array(
			'topic_id'=> $split_id[0]
			),'recursive' => -1));
		#pr($discussions);

        if($this->request->is('Post') && !empty($this->data['ques'])){
        	
        	$totalans = count($this->data['Answer']);
        	$correct = 0;

        	for($i=1;$i<=$totalans;$i++){
        		if(!empty($this->data['ques'][$i])){
        		if($this->data['Answer'][$i] == $this->data['ques'][$i]){
        			$correct += 1;
        		#	echo $this->data['ques'][$i].'= correct</br>';
        		}else{
        		#	echo $this->data['ques'][$i].'= wrong</br>';
        		}}

        	}
        	$average = round(($correct/$totalans) * 100);
        	#echo 'Total Correct: '.$correct.'<br/>Total Wrong: '.($totalans - $correct);
        	#echo '</br>'.$average;
        }

       	#pr($this->data);
        $quiz = new Quizzes();
        $quizResult = new Quizresult();
       
	        $quizData = $quiz->find('first',array('conditions' => array(
	        	'subject_id' => $topics['Topic']['subject_id'],
	        	'topic_id' => $split_id[0]
	        	),'recursive' => -1));
	       
	     if($this->request->is('post') && !empty($this->data['ques'])){
	           #pr($quizData);
	     
	        $result = array('Quizresult'=> array(
					'quiz_id' => $quizData['Quizzes']['id'],
					'student_id' => $this->Session->read('User.id'),
					'topic_id' => $quizData['Quizzes']['topic_id'],
					'subject_id' => $quizData['Quizzes']['subject_id'],
					'score' => $correct,
					'total_score' => $totalans
					));
       	$quizResultData = $quizResult->find('first',array('conditions'=>array(
				'quiz_id' => $quizData['Quizzes']['id'],
				'student_id' => $result['Quizresult']['student_id'],
				'topic_id' => $result['Quizresult']['topic_id'],
				'subject_id' => $result['Quizresult']['subject_id']
				),'recursive' => -1));
       #	pr($quizResultData);
				
				if(!empty($quizResultData)){
					//activity logs start here
						$ids = $this->Session->read('User.id');
						$name = $this->Session->read('User.wholename');
						$activity = 'Submit a quiz from a topic titled: '.$split_id[1].' and got a scored of '.$correct.' out of '.$totalans;
						$this->createLogs(0,$ids,$name,$activity);
					//end logs
					$data = array('Quizresult' => array(
					'id' => $quizResultData['Quizresult']['id'],
					'quiz_id' => $quizData['Quizzes']['id'],
					'student_id' => $this->Session->read('User.id'),
					'topic_id' => $quizData['Quizzes']['topic_id'],
					'subject_id' => $quizData['Quizzes']['subject_id'],
					'score' => $correct,
					'total_score' => $totalans
					));	
					#echo 'this data is already exists';
				
					if ($quizResult->save($data)) {

						$this->Session->setFlash(__('Your Quiz results has been updated.'), 'default', array('class' => 'alert alert-success'));
					} else {
						$this->Session->setFlash(__('Your Quiz could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
					}
				}else{
					#echo 'this data did not exists';
					
					$quizResult->create();
					if($quizResult->save($result)){
						$this->Session->setFlash(__('Your Quiz results been saved.'), 'default', array('class' => 'alert alert-success'));
					} else {
						$this->Session->setFlash(__('Your Quiz could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
					}
					
				}
		
			}

			date_default_timezone_set('Asia/Manila');
			$timeInterval = date('g:i:s');
			$topicData = $this->Topic->find('all',array('fields'=>'Topic.subject_id','conditions'=>array(
				'subject_id' => $topics['Topic']['subject_id']
				),'recursive' => -1));

			#$readpageDataCheck = '';
			$readpage = new Readpage();
			$readpageDataCheck = $readpage->find('all',array('fields' => 'Readpage.id,,Readpage.student_id,Readpage.topic_id,Readpage.subject_id,Readpage.page_read,Readpage.total_page,Readpage.time_finished_read',
					'conditions' => array(
						'student_id' => $this->Session->read('User.id'),
						'subject_id' => $topicData[0]['Topic']['subject_id'],
						'topic_id' => $split_id[0],
						'page_read' => 1
						),'recursive' => -1));
			#pr($readpageDataCheck);
			$readpageData = array(
					'Readpages' => array(
							'student_id' => $this->Session->read('User.id'),
							'topic_id' => $split_id[0],
							'subject_id' => $topics['Topic']['subject_id'],
							'page_read' => 1,
							'total_page' => count($topicData),
							'time_finished_read' => $timeInterval
						)
					);
			#pr($readpageData);
			$outline_map = unserialize(base64_decode($this->Session->read('Subject.outline')));
			$topic_map_id = array_search($id, $outline_map);
			#
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
								
								if(empty($outline_map[$topic_map_id + 1]))
								return $this->redirect(array('controller' => 'subjects', 'action' => 'read'));
								else	
				                return $this->redirect(array('controller' => 'topics', 'action' => 'read',$outline_map[$topic_map_id + 1]));
							} else {
								$this->Session->setFlash(__('Cannot update requested data. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
							}
							
						}else{
							
							$readpage->create();
							if ($readpage->save($readpageData['Readpages'])) {
								$this->Session->setFlash(__('Checking complete.'), 'default', array('class' => 'alert alert-success'));
								
								if(empty($outline_map[$topic_map_id + 1]))
								return $this->redirect(array('controller' => 'subjects', 'action' => 'read'));
								else
				                return $this->redirect(array('controller' => 'topics', 'action' => 'read',$outline_map[$topic_map_id + 1]));
							} else {
								$this->Session->setFlash(__('Cannot complete requested data. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
							}
							
							#echo 'data did not exist yet!';
							#pr($this->data);
						}
				} else {
					$this->Session->setFlash(__('The topic could not be saved. Please complete the required fields.'), 'default', array('class' => 'alert alert-danger'));
				}
				
			}

			#pr($readpageData);
        $this->set(compact('readpageData','quizData','id', 'split_id','topics', 'topic', 'discussions','average','correct','totalans','questionCount','questions','options'));
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
		$folderName = basename(ROOT);
		
		if ($this->request->is('post')) {
			
			//pr($this->request->data);// exit();
			
			if (!empty($this->request->data['Topic']['title'])) {
				$this->request->data['Topic']['subject_id'] = $this->Session->read('Subject.id');
	                    
				$this->Topic->create();
				if ($this->Topic->save($this->request->data)) {
					$this->Session->setFlash(__('The topic has been saved.'), 'default', array('class' => 'alert alert-success'));
					
					//activity logs start here
						$ids = $this->Session->read('User.id');
						$name = $this->Session->read('User.wholename');
						$activity = 'Added a new Topic title: '.$this->request->data['Topic']['title'];
						$this->createLogs($ids,0,$name,$activity);
					//end logs

	                return $this->redirect(array('controller' => 'subjects', 'action' => 'view'));
				} else {
					$this->Session->setFlash(__('The topic could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
				}
			} else {
				$this->Session->setFlash(__('The topic could not be saved. Please complete the required fields.'), 'default', array('class' => 'alert alert-danger'));
			}
			
		}
                
                
        $subject_chapters = $this->Topic->find('all', array('fields' => array('Topic.id',
                                                                              'Topic.title'),
                                                            'conditions' => array('Topic.chapter' => '',
                                                                                  'Topic.subject_id' => $this->Session->read('Subject.id')
                                                                                  ),
                                                            'order' => array('Topic.id' => 'ASC'),
                                                            'recursive' => -1
                                                        ));
                
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
		$this->set(compact('folderName','subject_chapters'));
	}
	public function addlas(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		pr($this->data); #exit();
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
		$folderName = basename(ROOT);
		$decoded_id = $this->Detergent->urlsafe_b64decode($id);
		$split_id = explode("|", $decoded_id);

		if (!$this->Topic->exists($split_id[0])) {
			throw new NotFoundException(__('Invalid topic'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if (!empty($this->request->data['Topic']['title'])) {
				$this->request->data['Topic']['id'] = $split_id[0];

				if ($this->Topic->save($this->request->data)) {
					//activity logs start here
						$ids = $this->Session->read('User.id');
						$name = $this->Session->read('User.wholename');
						$activity = 'Edited a Topic titled: '.$this->request->data['Topic']['title'];
						$this->createLogs($ids,0,$name,$activity);						
					//end logs
					$this->Session->setFlash(__('The content has been saved.'), 'default', array('class' => 'alert alert-success'));
					
					if($split_id[0] == 1)
					return $this->redirect(array('controller' => 'teachers','action' => 'dashboard'));
					else
					return $this->redirect(array('action' => 'view', $id));
				} else {
					$this->Session->setFlash(__('The topic could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
				}
			} else {
				$this->Session->setFlash(__('The topic could not be saved. Please complete the required fields.'), 'default', array('class' => 'alert alert-danger'));
			}	
		} else {
			$options = array('fields' => array('Topic.title', 'Topic.content'),
							 'conditions' => array('Topic.' . $this->Topic->primaryKey => $split_id[0]),
							 'recursive' => -1
							);

			$this->request->data = $this->Topic->find('first', $options);
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
		$this->set(compact('folderName','id'));

	}

	/**
	* delete method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function delete($id = null) {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$decoded_id = $this->Detergent->urlsafe_b64decode($id);
		$split_id = explode("|", $decoded_id);

		//activity logs start here
		$topicToBeRemoved = $this->Topic->find('first',array('conditions'=> array('id' => $split_id[0]),'recursive' => -1));
		
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Deleted a Topic titled: '.$topicToBeRemoved['Topic']['title'];
			$this->createLogs($ids,0,$name,$activity);

			#pr($topicToBeRemoved); exit();
		//end logs

		$this->Topic->id = $split_id[0];
		if (!$this->Topic->exists()) {
			throw new NotFoundException(__('Invalid topic'));
		}

		$this->request->onlyAllow('post', 'delete');
		
		if ($this->Topic->delete()) {
			
			$this->Session->setFlash(__('The topic has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The topic could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('controller' => 'subjects', 'action' => 'view'));
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
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Login';
			$this->createLogs($ids,0,$name,$activity);
		//end logs
		*/

	}

}