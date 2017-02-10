<?php
App::uses('AppController', 'Controller');
/**
 * Exams Controller
 *
 * @property Exam $Exam
 * @property PaginatorComponent $Paginator
 */


class QuizresultsController extends AppController {

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
		$this->Quizresult->recursive = 0;
		$this->set('quizresults', $this->Paginator->paginate());
	}

	public function lists() {
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		
		$this->Quizresult->recursive = 0;

		$this->Paginator->paginate = array('fields' => array(),
										   'conditions' => array('Quizresult.student_id' => $this->Session->read('Subject.id')),
										   'recursive' -1
										  );


		$this->set('quizresults', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		/*
		if (!$this->Quizresult->exists($id)) {
			throw new NotFoundException(__('Invalid quizresult'));
		}
		$options = array('conditions' => array('Quizresult.' . $this->Quizresult->primaryKey => $id));
		$this->set('quizresult', $this->Quizresult->find('first', $options));
		*/
	}


/**
 * add method
 *
 * @return void
 */
	public function add() {
		/*
		if ($this->request->is('post')) {
			$this->Exam->create();
			if ($this->Exam->save($this->request->data)) {
				$this->Session->setFlash(__('The exam has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'lists'));
			} else {
				$this->Session->setFlash(__('The exam could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$subjects = $this->Exam->Subject->find('list');
		$this->set(compact('subjects'));
		*/
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		/*
		$id = $this->Detergent->urlsafe_b64decode($id);

		if (!$this->Exam->exists($id)) {
			throw new NotFoundException(__('Invalid exam'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Exam']['id'] = $id;
			$this->request->data['Exam']['time_limit'] = $this->request->data['Exam']['limit_hour'].":".$this->request->data['Exam']['limit_minute'].":00";
			$this->request->data['Exam']['allow_retake'] = (array_key_exists('allow_retake', $this->request->data['Exam'])) ? 1 : 0;
			
			if ($this->Exam->save($this->request->data)) {
				$this->Session->setFlash(__('The exam has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'lists'));
			} else {
				$this->Session->setFlash(__('The exam could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$this->request->data = $this->Exam->find('first', array('fields' => array('Exam.id',
																					  'Exam.title',
																					  'Exam.time_limit',
																					  'Exam.allow_retake'
																					 ),
																	'conditions' => array('Exam.id' => $id),
																	'recursive' => -1
																   ));

			#pr($this->request->data);
		}
		$subjects = $this->Exam->Subject->find('list');
		$this->set(compact('subjects'));
		*/
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		/*
		$id = $this->Detergent->urlsafe_b64decode($id);

		$this->Exam->id = $id;
		if (!$this->Exam->exists()) {
			throw new NotFoundException(__('Invalid exam'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Exam->delete()) {
			$this->Session->setFlash(__('The exam has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The exam could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'lists'));
		*/
	}

}