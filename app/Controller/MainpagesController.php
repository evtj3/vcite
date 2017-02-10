<?php
App::uses('AppController', 'Controller');
/**
 * Discussions Controller
 *
 * @property Discussion $Discussion
 * @property PaginatorComponent $Paginator
 */
class MainpagesController extends AppController {

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
		$this->Mainpage->recursive = 0;
		$this->set('mainpages', $this->Paginator->paginate());

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->set('tags', $this->Recipe->Tag->find('list'));

		
	}

/**