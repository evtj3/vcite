<?php
App::uses('AppController', 'Controller');
/**
 * Exams Controller
 *
 * @property Exam $Exam
 * @property PaginatorComponent $Paginator
 */
App::import('Model', 'Log');

class MathformulasController extends AppController {

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

	public function add($id = null){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

				

		if($this->request->is('post')){
			if(!empty($this->request->data)){
				
				
				$this->Mathformula->create();
				if($this->Mathformula->save($this->request->data)){

					//activity logs start here
						$ids = $this->Session->read('User.id');
						$name = $this->Session->read('User.wholename');
						$activity = 'Created a new Math Equations';
						$this->createLogs($ids,0,$name,$activity);
					//end logs
					$this->Session->setFlash(__('Math Formula has been successfully created.'),'default',array('class'=>'alert alert-success'));
					return $this->redirect(array('controller' => 'topics', 'action' => 'view',$id));
				}else{
					$this->Session->setFlash(__('Cannot create Math Formula. Please try again.'),'default',array('class'=>'alert alert-danger'));
					return $this->redirect(array('controller' => 'topics', 'action' => 'view',$id));
				}
			}
		}
	}
	public function delete($topic_id = null){
		$this->Context->checkSession($this);
		$this->Context->doNotPermit($this, "student");

		$totalFormula = $this->Mathformula->find('count');
		
		$checkCount = 0;
		for($i=1;$i<=$totalFormula;$i++){
			$checkCount += 1;
			if(!empty($this->data['math'.$i])){
				#echo 'math'.$i;
			
				$this->Mathformula->id = $this->data['math'.$i];
				if (!$this->Mathformula->exists()) {
					throw new NotFoundException(__('Invalid Math'));
				}
					#$this->request->onlyAllow('post', 'delete');
					if ($this->Mathformula->delete()) {
						$this->Session->setFlash(__('The Math has been deleted.'), 'default', array('class' => 'alert alert-success'));
					} else {
						$this->Session->setFlash(__('The Math could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
					}
					
			}
			
		}

		if($checkCount == $totalFormula){
		//activity logs start here
			$ids = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Deleted a Math Equations';
			$this->createLogs($ids,0,$name,$activity);
		//end logs
		return $this->redirect(array('controller' => 'topics', 'action' => 'view',$topic_id));
		
		}
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