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

class DocfilesController extends AppController {

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
		pr($this->request->data);
		if($this->request->is('post')){
			//$base = Router::url( "/", true ); 
			$base = '/vcite/'; 
			//pr($this->request->data); pr($base);exit();
			if(!empty($this->request->data['Docfile']['lasdoc_id']))
			$lasdoc_id = $this->request->data['Docfile']['lasdoc_id'];
			if(!empty($this->request->data['Docfile']['document_id']))
			$document_id = $this->request->data['Docfile']['document_id'];

			
			$linkTo = $this->request->data['Docfile']['link'];
			$fileManager = $base.'app/webroot/js/ckeditor/plugins/fileman/Uploads';
			$file = $this->request->data['Docfile']['file or Link'];

			$mystring = $file;
			$findme   = $base;
			$pos = strpos($mystring, $findme);
			if ($pos === false) {
				    $link = $fileManager.$linkTo.''.$file;
				   // pr( "The string '$findme' was not found in the string '$mystring'");
				} else {
				    $link = $file;
				    //pr( "The string '$findme' was found in the string '$mystring'");
				    //pr( " and exists at position $pos");
				}
			//pr( "asdasd".$pos); 
			//exit();
			$data = array();
			if(!empty($document_id)){
			$data = array(
					'document_id' => $document_id,
					'foldertree' => $this->request->data['Docfile']['foldertree_id'],
					'title' => $this->request->data['Docfile']['title'],
					'link' => $link
				);
			}elseif(!empty($lasdoc_id)){
				$data = array(
					'lasdoc_id' => $lasdoc_id,
					'laspagelink_id' =>  $this->request->data['Docfile']['laspagelink_id'],
					'foldertree' => $this->request->data['Docfile']['foldertree_id'],
					'title' => $this->request->data['Docfile']['title'],
					'link' => $link
				);
			}

			$this->Docfile->create();
			if($this->Docfile->save($data)){
				return $this->redirect($this->referer());
			}else{

			}
			
		}
	}
	public function edit(){

		
		if($this->request->is('post')){
			//$base = Router::url( "/", true ); 
			$base = '/vcite/'; 
			#pr($this->request->data); pr($base);exit();
			$data = array(
					'document_id' => $this->request->data['Docfile']['document_id'],
					'foldertree' => $this->request->data['Docfile']['foldertree_id'],
					'title' => $this->request->data['Docfile']['title'],
					'link' => $base.'app/webroot/js/ckeditor/plugins/fileman/Uploads'.$this->request->data['Docfile']['link'].''.$this->request->data['Docfile']['file']
				);
			$this->Docfile->create();
			if($this->Docfile->save($data)){
				return $this->redirect(array('controller' => 'documents','action' => 'view?doc='.$this->request->data['Docfile']['foldertree'].'&docid='.$this->request->data['Docfile']['document_id']));
			}else{

			}
			
		}
	}
	public function delete($id = null){
		#pr($id); exit();
		$this->Docfile->id = $id;
		if (!$this->Docfile->exists()) {
			throw new NotFoundException(__('Invalid topic'));
		}
		
		if ($this->Docfile->delete()) {
			
			
		} else {
			
		}
		return $this->redirect($this->referer());
	}
}
