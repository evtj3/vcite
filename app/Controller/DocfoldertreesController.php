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

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */

class DocfoldertreesController extends AppController {

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
	public function add(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		
		if(!empty($this->request->data['submit_usefolder'])){
			//pr($this->request->data); exit();	

			$fdtree = $this->Docfoldertree->find('first',array('conditions' => array(
				'id' => $this->request->data['exist_folders']
				),'recursive' => -1));

			$this->Docfoldertree->id = $this->request->data['exist_folders'];
			$data = array('lasdoc_id' => $fdtree['Docfoldertree']['lasdoc_id'].'['.$this->request->data['Docfoldertree']['lasdocid'].']');


			
			if($this->Docfoldertree->save($data)){
				$this->Session->setFlash(__('Folder named '.$fdtree['Docfoldertree']['foldername'].' has been used.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect($this->referer(array('action' => 'view?doc='.$this->request->data['Docfoldertree']['doc'].'&docid='.$this->request->data['Docfoldertree']['lasdocid'])));
			}
			
		}


		if(!empty($this->request->data['submit_create'])){
			$las_id = $this->request->data['Docfoldertree']['lasdocid'];
			$document_id = $this->request->data['Docfoldertree']['docid'];
			$las_docdb = '';
			$document_db = '';


			if(!empty($document_id)){
			$Docfoldertree_db = $this->Docfoldertree->find('first',array('conditions' => array(
				'foldername LIKE "'.$this->request->data['Docfoldertree']['foldername'].'"',
				'document_id NOT LIKE "%['.$document_id.']%"'
				),'recursive' => -1));
			}elseif(!empty($las_id)){
			$Docfoldertree_db = $this->Docfoldertree->find('first',array('conditions' => array(
				'foldername LIKE "'.$this->request->data['Docfoldertree']['foldername'].'"',
				'lasdoc_id NOT LIKE "%['.$las_id.']%"'
				),'recursive' => -1));
			}
			#pr($Docfoldertree_db);pr($this->request->data);exit();

			if(!empty($las_id))
			$las_docdb = $Docfoldertree_db['Docfoldertree']['lasdoc_id'].'['.$las_id.']';
			elseif(!empty($document_id))
			$document_db = $Docfoldertree_db['Docfoldertree']['document_id'].'['.$document_id.']';
			if($this->request->is('post')){
				/*
				if(empty($Docfoldertree_db)){
				$this->Session->setFlash(__('Folder named '.$this->request->data["Docfoldertree"]["foldername"].' already exist.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('controller' => 'documents','action' => 'view?doc='.$this->request->data['Docfoldertree']['doc'].'&docid='.$this->request->data['Docfoldertree']['docid']));
				}
				*/
				if(!empty($las_id)){
					$data = array(
							'lasdoc_id' => '['.$las_id.']',
							//'document_id' => '['.$document_id.']',
							'foldername' => $this->request->data['Docfoldertree']['foldername']
						);
					if(!empty($Docfoldertree_db)){
						$data = array(
							'lasdoc_id' => $las_docdb,
							//'document_id' => $document_db,
							'foldername' => $this->request->data['Docfoldertree']['foldername']);
					}
				}elseif(!empty($document_id)){
					$data = array(
							//'lasdoc_id' => '['.$las_id.']',
							'document_id' => '['.$document_id.']',
							'foldername' => $this->request->data['Docfoldertree']['foldername']
						);
					if(!empty($Docfoldertree_db)){
						$data = array(
							//'lasdoc_id' => $las_docdb,
							'document_id' => $document_db,
							'foldername' => $this->request->data['Docfoldertree']['foldername']);
					}
				}
				$this->Docfoldertree->create();

				if($this->Docfoldertree->save($data)){
					$this->Session->setFlash(__('Folder named '.$this->request->data["Docfoldertree"]["foldername"].' has been created.'), 'default', array('class' => 'alert alert-success'));
					return $this->redirect($this->referer(array('action' => 'view?doc='.$this->request->data['Docfoldertree']['doc'].'&docid='.$this->request->data['Docfoldertree']['docid'])));
				}else{

				}
				
			}

		}
		exit();
	}
	public function edit(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		
		if(!empty($this->request->data['Docfoldertree']['document_id'])){
		$docdata = $this->Docfoldertree->find('all',array('conditions' => array(
			'document_id LIKE "%['.$this->request->data['Docfoldertree']['document_id'].']%"'
			),'recursive' => -1));
		}elseif(!empty($this->request->data['Docfoldertree']['lasdoc_id'])){
		$docdata = $this->Docfoldertree->find('all',array('conditions' => array(
			'lasdoc_id LIKE "%['.$this->request->data['Docfoldertree']['lasdoc_id'].']%"'
			),'recursive' => -1));
		}
		$dataarr = array();
		//pr($this->request->data); pr($docdata); exit();
		if($this->request->is('post')){
			
			foreach($docdata as $dd){
				
				$this->Docfoldertree->id = $this->request->data['Docfoldertree'][$dd['Docfoldertree']['id']];
				$dataarr = array(
					'foldername' => $this->request->data['Docfoldertree'][$dd['Docfoldertree']['foldername']]
					);
				
				if($this->Docfoldertree->save($dataarr)){

				}else{
					$this->Session->setFlash(__('Folders has not been updated.'), 'default', array('class' => 'alert alert-danger'));
					if(!empty($this->request->data['Docfoldertree']['lasdoc_id']))
					return $this->redirect($this->referer(array('action' => 'view?doc='.$this->request->data['Docfoldertree']['doc'].'&docid='.$this->request->data['Docfoldertree']['lasdoc_id'])));
					elseif(!empty($this->request->data['Docfoldertree']['document_id']))
					return $this->redirect($this->referer(array('action' => 'view?doc='.$this->request->data['Docfoldertree']['doc'].'&docid='.$this->request->data['Docfoldertree']['document_id'])));
				}
				/**/
			}	
			
		}
		
		$this->Session->setFlash(__('Folders has been updated.'), 'default', array('class' => 'alert alert-success'));
		if(!empty($this->request->data['Docfoldertree']['lasdoc_id']))
		return $this->redirect($this->referer(array('action' => 'view?doc='.$this->request->data['Docfoldertree']['doc'].'&docid='.$this->request->data['Docfoldertree']['lasdoc_id'])));
		elseif(!empty($this->request->data['Docfoldertree']['document_id']))
		return $this->redirect($this->referer(array('action' => 'view?doc='.$this->request->data['Docfoldertree']['doc'].'&docid='.$this->request->data['Docfoldertree']['document_id'])));
		
		exit();
	}
	public function delete(){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");
		
		$data = $this->request->data;
		$delData = array();
		$countFolder = $this->Docfoldertree->find('count');
		// pr($data); exit();
		for($i=0;$i<$countFolder;$i++){
			

			if(!empty($data['Docfoldertree'][$i])){
				//pr($data['Docfoldertree'][$i]);
				array_push($delData,$data['Docfoldertree'][$i]);
				}
			//else
				//pr('wala man');
		}
		//	pr($delData);
		
	
		for($x=0;$x<count($delData);$x++){
			pr($delData[$x]);

			
			$this->Docfoldertree->id = $delData[$x];
			if (!$this->Docfoldertree->exists()) {
				throw new NotFoundException(__('Invalid Folder'));
			}
			
			if ($this->Docfoldertree->delete()) {
				
				
			} else {
				
			}
			
		}
		$this->Session->setFlash(__('The Folder has been deleted.'), 'default', array('class' => 'alert alert-success'));
		return $this->redirect($this->referer(array('action' => 'view?doc='.$this->request->data['Docfoldertree']['doc'].'&docid='.$this->request->data['Docfoldertree']['docid'])));
	}
}
