<?php
App::uses('AppController', 'Controller');
/**
 * Questions Controller
 *
 * @property Question $Question
 * @property PaginatorComponent $Paginator
 */
App::import('Model', 'Exam');
App::import('Model', 'Topic');
App::import('Model', 'Question');
App::import('Model', 'Option');
App::import('Model', 'Quizzes');
App::import('Model', 'Log');

class QuestionsController extends AppController {

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
		$this->Question->recursive = 0;
		$this->set('questions', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Question->exists($id)) {
			throw new NotFoundException(__('Invalid question'));
		}
		$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
		$this->set('question', $this->Question->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		if ($this->request->is('post')) {
			$this->Question->create();
			if ($this->Question->save($this->request->data)) {
				$this->Session->setFlash(__('The question has been saved.'), 'default', array('class' => 'alert alert-success'));
				
				//activity logs start here
					$ids = $this->Session->read('User.id');
					$name = $this->Session->read('User.wholename');
					$activity = 'Added a new question';
					$this->createLogs($ids,0,$name,$activity);
				//end logs

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$subjects = $this->Question->Subject->find('list');
		$this->set(compact('subjects'));
	}
	public function assestment($exam_id = null){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		$id = $this->Detergent->urlsafe_b64decode($exam_id);
		$split_id = explode("|", $id);

		$topic = new Topic();
		$question = new Question();
		$option = new Option();
		$quiz = new Quizzes();

		
    	#exit();
    	#pr($this->data); exit();
		if ($this->request->is('post')) {
			if(!empty($this->request->data)){
				switch($this->data['quiztype']){
					case 'Multiple Choice';
					#pr($this->data);exit();
						if(!empty($this->data['answers']) && !empty($this->data['answers1']) && !empty($this->data['answers2']) && !empty($this->data['answers3']) && !empty($this->data['answers4']) && !empty($this->data['assestment']['Valid Question:'])){
							
							#return $this->redirect(array('action' => '.././questions/assestment/'.$id,$this->data));
							#echo 'wews';
						}else{
							$this->Session->setFlash(__('You have submitted an incomplete data. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
							return $this->redirect(array('action' => '.././topics/view/'.$exam_id));
						}
					break;
					case 'True or False';
					#pr($this->data);exit();
						if(!empty($this->data['answers']) && !empty($this->data['answers1']) && !empty($this->data['answers2']) && !empty($this->data['assestment']['Valid Question:'])){
							#return $this->redirect(array('action' => '.././questions/assestment/'.$id,$this->data));
							#echo 'wews';
						}else{
							$this->Session->setFlash(__('You have submitted an incomplete data. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
							return $this->redirect(array('action' => '.././topics/view/'.$exam_id));
						}
					break;

					default;
						$this->Session->setFlash(__('You have submitted an invalid data. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
						return $this->redirect(array('action' => '.././topics/view/'.$id));
					break;
				}
			
			}
		}else{
			$this->Session->setFlash(__('You have submitted an invalid data. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			return $this->redirect(array('action' => '.././topics/view/'.$id));
		}


		$topicData = $topic->find('all',array('fields' => 'Topic.id,Topic.subject_id','conditions'=> array(
			'Topic.id' => $id
			),'recursive' => -1));

		$topicArr = array();
		foreach($topicData as $topics){
			$topicArr = $topics;
		}
		$topicData = $topicArr;

		$questionData = '';
		$questionArrData = array();

		if ($this->request->is('post')) {
			foreach($this->data['assestment'] as $q){
				$questionArrData['Question']['content'] = '<p>'.$q.'</p>';
				$questionArrData['Question']['subject_id'] = $topicArr['Topic']['subject_id'];
				$questionArrData['Question']['topic_id'] = $topicArr['Topic']['id'];
				$questionArrData['Question']['type'] = $this->data['quiztype'];
			}
			$questionData = $questionArrData;
			
			    $question->create();
				if ($question->save($questionData)) {
					$this->Session->setFlash(__('The question has been saved.'), 'default', array('class' => 'alert alert-success'));
					
					//activity logs start here
						$ids = $this->Session->read('User.id');
						$name = $this->Session->read('User.wholename');
						$activity = 'Created a new quiz.';
						$this->createLogs($ids,0,$name,$activity);
					//end logs
					#return $this->redirect(array('action' => '.././topics/view/'.$exam_id));
				} else {
					$this->Session->setFlash(__('The question could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
				}

				

			$optionsData = '';
			
				$questionData2 = '';
				$questionArrData2 = array();
				$questionData2 = $question->find('all', array('fields' => 'Question.id,Question.topic_id,Question.type,Question.content','conditions'=>array(
					'topic_id' => $split_id[0],'subject_id' => $topicArr['Topic']['subject_id'],'content'=>'<p>'.$q.'</p>'),'recursive' => -1));
				foreach($questionData2 as $qp2){
					$questionArrData2 = $qp2;
				}
					$questionData2 = $questionArrData2;

			if($this->data['quiztype'] == 'Multiple Choice')
				$totalOptions = 4;
			else if($this->data['quiztype'] == 'True or False')
				$totalOptions = 2;

			for($i=1;$i<=$totalOptions; $i++){


				if($this->data['answers'] == $i)
					$optionsArrData = array('Option'=> array('options' => $this->data['answers'.$i],'question_id' => $questionData2['Question']['id'],'correct' => 1));	
				else
					$optionsArrData = array('Option'=> array('options' => $this->data['answers'.$i],'question_id' => $questionData2['Question']['id'],'correct' => 0));	
				
				$optionsData = $optionsArrData;
				
				
				$option->create();
				if ($option->save($optionsData)) {
					$this->Session->setFlash(__('New Quiz has been saved.'), 'default', array('class' => 'alert alert-success'));
					//activity logs start here
					#if($i >= $totalOptions)
					#return $this->redirect(array('action' => '.././topics/view/'.$exam_id));
				} else {
					$this->Session->setFlash(__('The option could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
				}
			}
			//Save quiz
        	$data = array('Quizzes' => array(
	    			'teacher_id' => $this->Session->read('User.id'),
	    			'subject_id' => $topicArr['Topic']['subject_id'],
	    			'topic_id' => $split_id[0],
	    			'questions' => '['.$questionData2['Question']['id'].']'
	    			));
	    	if(!empty($this->data['saveRecord'])){
	    		#pr( $this->data['saveRecord']);
	    		#$quizzes = new Quizzes();
	    		#pr($id);

	    		$quizData = $quiz->find('all',array('fields' => 'Quizzes.id,Quizzes.teacher_id,Quizzes.subject_id,Quizzes.topic_id,Quizzes.questions','conditions' => array(
	    			'teacher_id' => $this->data['saveRecord']['Quizzes']['teacher_id']
	    			),'recursive' => -1));
	    		
	    		if(!empty($quizData)){
	    			#echo 'this data is already exist!';
	    			$data = array('Quizzes' =>array(
	    					'teacher_id' => $this->Session->read('User.id'),
			    			'subject_id' => $this->data['saveRecord']['Quizzes']['subject_id'],
			    			'topic_id' => $this->data['saveRecord']['Quizzes']['topic_id'],
			    			'questions' => $this->data['saveRecord']['Quizzes']['questions'].'['.$questionData2['Question']['id'].']'
	    				));
	    			$this->request->data = $data;
	    			
	    			$this->request->data['Quizzes']['id'] = $quizData[0]['Quizzes']['id'];
						
						
						if ($quiz->save($this->request->data)) {
							$this->Session->setFlash(__('The Quiz has been updated.'), 'default', array('class' => 'alert alert-success'));
							if($i >= $totalOptions){
							
									//activity logs start here
										$ids = $this->Session->read('User.id');
										$name = $this->Session->read('User.wholename');
										$activity = 'Updated a quiz';
										$this->createLogs($ids,0,$name,$activity);
									//end logs
							return $this->redirect(array('action' => '.././topics/view/'.$exam_id));
							}
						} else {
							$this->Session->setFlash(__('The Quiz could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
						}
					
	    		}else{
	    			#echo 'this data did not exist!';
		    		
					$quiz->create();
					if ($quiz->save($this->data['saveRecord'])) {
						$this->Session->setFlash(__('The Quiz has been saved.'), 'default', array('class' => 'alert alert-success'));
						if($i >= $totalOptions){
						
						//activity logs start here
							$ids = $this->Session->read('User.id');
							$name = $this->Session->read('User.wholename');
							$activity = 'Added a new quiz';
							$this->createLogs($ids,0,$name,$activity);
						//end logs
						return $this->redirect(array('action' => '.././topics/view/'.$exam_id));
						}
					} else {
						$this->Session->setFlash(__('The Quiz could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
					}
					
				}
	    	}else{
	    		
	    		$quiz->create();
					if ($quiz->save($data)) {
						$this->Session->setFlash(__('The Quiz has been saved.'), 'default', array('class' => 'alert alert-success'));
						if($i >= $totalOptions){
							//activity logs start here
								$ids = $this->Session->read('User.id');
								$name = $this->Session->read('User.wholename');
								$activity = 'Added a new quiz';
								$this->createLogs($ids,0,$name,$activity);
							//end logs
						return $this->redirect(array('action' => '.././topics/view/'.$exam_id));
						}
					} else {
						$this->Session->setFlash(__('The Quiz could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
					}

	    	}
			
			//saving quiz ended
		}
		
		
		$this->set(compact('split_id','exam_id','topicArr'));
	}
	public function assestment_edit($exam_id = null){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		$id = $this->Detergent->urlsafe_b64decode($exam_id);
		$split_id = explode("|", $id);

		
			
		$questionData = '';
		$questionArrdata = array();
		$questionData2 = '';
		$questionArrdata2 = array();
		
		#pr($this->request->data);exit();
			//update questions
			for($i=1; $i<=$this->data['totalQuestion'];$i++){
				$questionArrdata['Question']['id'] = $this->data['Question'.$i]['queId'.$i];
				$questionArrdata['Question']['content'] = $this->data['Question'.$i]['ques'.$i];
				$questionArrdata['Question']['subject_id'] = $this->data['Question'.$i]['subjectID'];
				$questionArrdata['Question']['topic_id'] = $this->data['Question'.$i]['topicID'];

				$questionData = $questionArrdata;
				#pr($questionData);
				
				if ($this->request->is(array('post', 'put'))) {
					
					if ($this->Question->save($questionData)) {
						
						$this->Session->setFlash(__('The question has been saved.'), 'default', array('class' => 'alert alert-success'));
						#return $this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash(__('The question could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
					}
					
				} else {
					$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $questionData['id']));
					$this->request->data = $this->Question->find('first', $options);
				}
				
			}

			$option = new Option();
			//update options
			$count = 0;
			$totalOpt = 0;
			for($g=1; $g<=$this->data['totalOption'];$g++){
				$totalOpt += $this->data['Option'.$g]['totalOptEvQue'];

				for($f=1;$f<=$this->data['Option'.$g]['totalOptEvQue'];$f++){
					$count += 1;
					$questionArrdata2['Option']['id'] = $this->data['Option'.$g]['optionId'.$g.''.$f];
					$questionArrdata2['Option']['question_id'] = $this->data['Option'.$g]['questionID'];
					$questionArrdata2['Option']['options'] = $this->data['Option'.$g]['Answers'.$f];
					$questionArrdata2['Option']['correct'] = 0;

					if(empty($this->data['Option'.$g]['CorrectAnswer'])){
						$this->Session->setFlash(__('Please do not forget to select the correct answer.'), 'default', array('class' => 'alert alert-danger'));
						return $this->redirect(array('action' => '.././topics/view/'.$exam_id));
					}
						
					if($this->data['Option'.$g]['CorrectAnswer'] == $f)
						$questionArrdata2['Option']['correct'] = 1;

					

					$questionData2 = $questionArrdata2;
					
					if ($this->request->is(array('post', 'put'))) {
						
						if ($option->save($questionData2)) {
							$this->Session->setFlash(__('The question has been saved.'), 'default', array('class' => 'alert alert-success'));
							
						} else {
							$this->Session->setFlash(__('The question could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
						}
						
					} else {
						$options = array('conditions' => array('Question.' . $option->primaryKey => $questionData2['id']));
						$this->request->data = $option->find('first', $options);
					}
					
					
					#pr($questionData2);
				}

			}

			if($count == $totalOpt){
				//activity logs start here
					$ids = $this->Session->read('User.id');
					$name = $this->Session->read('User.wholename');
					$activity = 'Updated a quiz';
					$this->createLogs($ids,0,$name,$activity);
				//end logs
			return $this->redirect(array('action' => '.././topics/view/'.$exam_id));
			}
			#pr($this->data);
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
		if (!$this->Question->exists($id)) {
			throw new NotFoundException(__('Invalid question'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Question->save($this->request->data)) {
				//activity logs start here
					$ids = $this->Session->read('User.id');
					$name = $this->Session->read('User.wholename');
					$activity = 'Updated a question';
					$this->createLogs($ids,0,$name,$activity);
				//end logs
				$this->Session->setFlash(__('The question has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
			$this->request->data = $this->Question->find('first', $options);
		}
		$subjects = $this->Question->Subject->find('list');
		$this->set(compact('subjects'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Question->id = $id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Question->delete()) {
			//activity logs start here
				$ids = $this->Session->read('User.id');
				$name = $this->Session->read('User.wholename');
				$activity = 'Deleted a question';
				$this->createLogs($ids,0,$name,$activity);
			//end logs
			$this->Session->setFlash(__('The question has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The question could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	public function delete_quiz($topic_id = null) {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		//activity logs start here
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Deleted a quiz';
			$this->createLogs($ids,0,$name,$activity);
		//end logs
			$id = $this->Detergent->urlsafe_b64decode($topic_id);
			$split_id = explode("|", $id);

			//pr($split_id);
		$option = new Option();
		$quizzes = new Quizzes();
		
		//questions
		$questionData = '';
		$questionArrdata = array();
		
		if(empty($this->data)){
			$this->Session->setFlash(__('You have submitted an empty data. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			return $this->redirect(array('action' => '.././topics/view/'.$topic_id));
		}

		
		
		
		for($i=1; $i<= $this->data['counter'];$i++){
				
			if(!empty($this->data['Question'.$i])){
				$questionArrdata['Question'] = $this->data['Question'.$i];

				$questionData = $questionArrdata;
				#pr($questionData);
				
					//options
					$optionData = $option->find('all',array('fields'=>'Option.id,Option.question_id','conditions' => array(
						'Option.question_id' => $questionData['Question']['id']
						),'recursive' => -1));

					$optionsArrData = array();
					
					foreach($optionData as $opt){
						$optionsArrData = $opt;
						
						$optionData = $optionsArrData;
						#pr($optionData);
						$option->id = $optionData['Option']['id'];
						
						if ($option->delete()) {
							$this->Session->setFlash(__('The question has been deleted.'), 'default', array('class' => 'alert alert-success'));
						} else {
							$this->Session->setFlash(__('The question could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
						}
					}
					#pr($questionData);
					$this->Question->id = $questionData['Question']['id'];
					#pr($questionData['Question']['id']);
					
					if ($this->Question->delete()) {
						$this->Session->setFlash(__('The question has been deleted.'), 'default', array('class' => 'alert alert-success'));
					} else {
						$this->Session->setFlash(__('The question could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
					}	
					
					
			}
		}
		$questionsCount = $this->Question->find('count',array('conditions' => array(
			'topic_id' => $split_id[0]
			),'recursive' => -1));
		
		if($questionsCount == 0){
			//delete quiz
			$quizzesData = $quizzes->find('first',array('fields' => 'id,questions','conditions' => array(
			'teacher_id' => $this->Session->read('User.id')
			),'recursive' => -1));

			$quizzes->id = $quizzesData['Quizzes']['id'];
			if ($quizzes->delete()) {
				$this->Session->setFlash(__('The question has been deleted.'), 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(__('The question could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}	
		}
		#if($i >= count($this->data))
			return $this->redirect(array('action' => '.././topics/view/'.$topic_id));
		
		#pr($this->data);
		
		
		
	}

	public function create($exam_id = null, $type = "Multiple Choice") {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$this->layout = "empty";

		$id = $this->Detergent->urlsafe_b64decode($exam_id);

		$examModel = new Exam();
		if (!$examModel->exists($id)) {
			throw new NotFoundException(__('Invalid exam'));
		}

		//activity logs start here
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Added a new question';
			$this->createLogs($ids,0,$name,$activity);
		//end logs

		if ($this->request->is('post')) {
			$exam = $examModel->find('first', array('fields' => array('Exam.questions'),
													'conditions' => array('Exam.id' => $id),
													'recursive' => -1
													));

			#pr($this->request->data); exit();

			$data['Question']['subject_id'] = $this->Session->read('Subject.id');
			$data['Question']['content'] = $this->request->data['Question']['content'];
			$data['Question']['type'] = $type;

			$data['Question']['shuffle'] = (array_key_exists('shuffle', $this->request->data['Question'])) ? 1 : 0;

			if ($data['Question']['type']=="Multiple Select") {
				$this->Question->create();
				if ($this->Question->save($data)) {
					$qid = $this->Question->getLastInsertID();

					$data['Option']['question_id'] = $qid;
					foreach ($this->request->data['Option'] as $key => $option) {
						if (!empty($option)) {
							$data['Option']['correct'] = 0;
							if (array_key_exists($key, $this->request->data['Answer'])) $data['Option']['correct'] = 1;

							$data['Option']['option'] = $option;

							$this->Question->Option->create();
							$this->Question->Option->save($data);
						}
					}

					$exam_questions = $exam['Exam']['questions']."[{$qid}]";

					$data['Exam']['id'] = $id;
					$data['Exam']['questions'] = $exam_questions;
					$examModel->save($data);

					$this->Session->setFlash(__('The exam question has been saved.'), 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash(__('The exam question was not saved.'), 'default', array('class' => 'alert alert-error'));
				}
			} elseif ($data['Question']['type']=="Matching Type") {
				$this->Question->create();
				if ($this->Question->save($data)) {
					$qid = $this->Question->getLastInsertID();

					$data['Option']['question_id'] = $qid;
					foreach ($this->request->data['Option'] as $key => $option) {
						if (!empty($option)) {
							if (!empty($this->request->data['Alternate'][$key])) $data['Option']['alternate_option'] = $this->request->data['Alternate'][$key];

							$data['Option']['option'] = $option;

							$this->Question->Option->create();
							$this->Question->Option->save($data);
						}
					}

					$exam_questions = $exam['Exam']['questions']."[{$qid}]";

					$data['Exam']['id'] = $id;
					$data['Exam']['questions'] = $exam_questions;
					$examModel->save($data);

					$this->Session->setFlash(__('The exam question has been saved.'), 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash(__('The exam question was not saved.'), 'default', array('class' => 'alert alert-error'));
				}
			} else {
				$this->Question->create();
				if ($this->Question->save($data)) {
					$qid = $this->Question->getLastInsertID();

					$data['Option']['question_id'] = $qid;
					foreach ($this->request->data['Option'] as $key => $option) {
						$data['Option']['correct'] = 0;
						if ($this->request->data['Answer']['correct']==$key) $data['Option']['correct'] = 1;

						$data['Option']['option'] = $option;

						$this->Question->Option->create();
						$this->Question->Option->save($data);
					}


					$exam_questions = $exam['Exam']['questions']."[{$qid}]";

					$data['Exam']['id'] = $id;
					$data['Exam']['questions'] = $exam_questions;
					$examModel->save($data);

					$this->Session->setFlash(__('The exam question has been saved.'), 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash(__('The exam question was not saved.'), 'default', array('class' => 'alert alert-error'));
				}
			}

			$this->redirect(array('controller' => 'exams', 'action' => 'questions', $exam_id));
		}

		$this->set(compact("type"));
	}

	public function update($exam_id = null, $question_id = null, $type = "Multiple Choice") {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$this->layout = "empty";

		$clean_exam_id = $this->Detergent->urlsafe_b64decode($exam_id);

		$examModel = new Exam();
		if (!$examModel->exists($clean_exam_id)) {
			throw new NotFoundException(__('Invalid exam'));
		}

		$clean_question_id = $this->Detergent->urlsafe_b64decode($question_id);

		if (!$this->Question->exists($clean_question_id)) {
			throw new NotFoundException(__('Invalid question'));
		}

		//activity logs start here
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Update a new question';
			$this->createLogs($ids,0,$name,$activity);
		//end logs

		#if ($this->request->is('post')) {
		if (!empty($this->request->data)) {
			#pr($this->request->data); exit();

			$exam = $examModel->find('first', array('fields' => array('Exam.questions'),
													'conditions' => array('Exam.id' => $exam_id),
													'recursive' => -1
													));

			$data['Question']['id'] = $clean_question_id;
			$data['Question']['content'] = $this->request->data['Question']['content'];
			
			$data['Question']['shuffle'] = (array_key_exists('shuffle', $this->request->data['Question'])) ? 1 : 0;

			if ($this->request->data['Type']['question_type']=="Multiple Select") {
				
				if ($this->Question->save($data)) {

					foreach ($this->request->data['Option'] as $option_id => $option) {
						$data['Option']['id'] = $option_id;

						if (!empty($option)) {
							$data['Option']['correct'] = 0;
							if (array_key_exists($option_id, $this->request->data['Answer'])) $data['Option']['correct'] = 1;

							$data['Option']['option'] = $option;

							$this->Question->Option->save($data);
						}
					}

					$this->Session->setFlash(__('The exam question has been saved.'), 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash(__('The exam question was not saved.'), 'default', array('class' => 'alert alert-error'));
				}
			} elseif ($this->request->data['Type']['question_type']=="Matching Type") {
				if ($this->Question->save($data)) {
					foreach ($this->request->data['Option'] as $option_id => $option) {
						$data['Option']['id'] = $option_id;

						if (!empty($option)) {
							if (!empty($this->request->data['Alternate'][$option_id])) $data['Option']['alternate_option'] = $this->request->data['Alternate'][$option_id];

							$data['Option']['option'] = $option;

							$this->Question->Option->save($data);
						}
					}

					$this->Session->setFlash(__('The exam question has been saved.'), 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash(__('The exam question was not saved.'), 'default', array('class' => 'alert alert-error'));
				}
			} else {
				if ($this->Question->save($data)) {
					foreach ($this->request->data['Option'] as $option_id => $option) {
						$data['Option']['id'] = $option_id;
						$data['Option']['correct'] = 0;
						if ($this->request->data['Answer']['correct']==$option_id) $data['Option']['correct'] = 1;

						$data['Option']['option'] = $option;

						$this->Question->Option->save($data);
					}

					$this->Session->setFlash(__('The exam question has been saved.'), 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash(__('The exam question was not saved.'), 'default', array('class' => 'alert alert-error'));
				}
			}

			$this->redirect(array('controller' => 'exams', 'action' => 'questions', $exam_id));
		} else {
			$this->request->data = $this->Question->find('first', array('fields' => array('Question.id',
																						  'Question.content',
																						  'Question.shuffle'
																						 ),
																		'conditions' => array('Question.id' => $clean_question_id),
																		));

			#pr($this->request->data);
		}

		$this->set(compact("type"));
	}

	public function reuse_preview($exam_id = null) {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$this->layout = "empty";

		$clean_exam_id = $this->Detergent->urlsafe_b64decode($exam_id);

		$examModel = new Exam();
		if (!$examModel->exists($clean_exam_id)) {
			throw new NotFoundException(__('Invalid exam'));
		}

		$this->Question->recursive = 0;

		//$this->Paginator->settings = $this->paginate;

		$this->Paginator->settings = array('fields' => array('Question.id',
															 'Question.type',
															 'Question.content'
															),
										   'conditions' => array('Question.subject_id' => $clean_exam_id),
										   'recursive' => 1,
										   'limit' => 1
										  );
		
		#pr($this->Paginator->paginate());
		$this->set('question', $this->Paginator->paginate());
		$this->set(compact('exam_id'));
	}

	public function remove($exam_id = null, $question_id = null) {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$this->layout = "empty";

		$clean_exam_id = $this->Detergent->urlsafe_b64decode($exam_id);

		$examModel = new Exam();
		if (!$examModel->exists($clean_exam_id)) {
			throw new NotFoundException(__('Invalid exam'));
		}

		$clean_question_id = $this->Detergent->urlsafe_b64decode($question_id);
		$this->Question->id = $clean_question_id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}

		//activity logs start here
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Removed a question';
			$this->createLogs($ids,0,$name,$activity);
		//end logs

		$this->request->onlyAllow('get', 'delete');
		if ($this->Question->delete()) {
			$exam = $examModel->find('first', array('fields' => array('Exam.questions'),
													'conditions' => array('Exam.id' => $clean_exam_id),
													'recursive' => -1
													));

			$data['Exam']['id'] = $clean_exam_id;
			$data['Exam']['questions'] = str_replace("[{$clean_question_id}]", "", $exam['Exam']['questions']);
			$examModel->save($data);

			$this->Session->setFlash(__('The question has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The question could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('controller' => 'exams', 'action' => 'questions', $exam_id));
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