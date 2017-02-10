<?php
App::uses('AppController', 'Controller');
/**
 * Options Controller
 *
 * @property Option $Option
 * @property PaginatorComponent $Paginator
 */
class ReadpagesController extends AppController {

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
		$this->Readpage->recursive = 0;
		$this->set('readpages', $this->Paginator->paginate());
	}
	public function checkdata($id = null){
		#pr($id);
		#if(!empty($id))
		#	return $this->redirect(array('controller' => 'topics', 'action' => 'read',$id));
	}
	public function view(){

	}
}
