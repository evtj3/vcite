<?php
App::uses('AppController', 'Controller');
/**
 * Discussions Controller
 *
 * @property Discussion $Discussion
 * @property PaginatorComponent $Paginator
 */
class DiscussionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Discussion->recursive = 0;
		$this->set('discussions', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Discussion->exists($id)) {
			throw new NotFoundException(__('Invalid discussion'));
		}
		$options = array('conditions' => array('Discussion.' . $this->Discussion->primaryKey => $id));
		$this->set('discussion', $this->Discussion->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Discussion->create();
			if ($this->Discussion->save($this->request->data)) {
				$this->Session->setFlash(__('The discussion has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The discussion could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Discussion->exists($id)) {
			throw new NotFoundException(__('Invalid discussion'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Discussion->save($this->request->data)) {
				$this->Session->setFlash(__('The discussion has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The discussion could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Discussion.' . $this->Discussion->primaryKey => $id));
			$this->request->data = $this->Discussion->find('first', $options);
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
		$this->Discussion->id = $id;
		if (!$this->Discussion->exists()) {
			throw new NotFoundException(__('Invalid discussion'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Discussion->delete()) {
			$this->Session->setFlash(__('The discussion has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The discussion could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}