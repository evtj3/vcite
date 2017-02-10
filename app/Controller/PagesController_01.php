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
App::uses('Security', 'Utility'); 
App::import('Model', 'Student');
App::import('Model', 'Teacher');
App::import('Model' , 'Log');
App::import('Model' , 'Login');
App::import('Model' , 'Loginst');
App::import('Model', 'Siscakesession');

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

	/**
	* This controller does not use a model
	*
	* @var array
	*/
	public $components = array('Context');
	public $uses = array();
	/**
	* Displays a view
	*
	* @param mixed What page to display
	* @return void
	* @throws NotFoundException When the view file could not be found
	*	or MissingViewException in debug mode.
	*/
	public function index(){
		return $this->redirect(array('controller' => 'lasdocs','action' => 'index'));
	}
	public function displays() {
		
		$path = func_get_args();
		#$layout = "empty";
		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	public function select_dashboard() {
		//$this->Context->checkSession($this);

		if ($this->Session->read('User.group')=="teacher") $this->redirect(array('controller' => 'teachers', 'action' => 'dashboard'));
		if ($this->Session->read('User.group')=="student") $this->redirect(array('controller' => 'students', 'action' => 'dashboard'));

		exit();
	}
	//checklogin
	public function login(){
		$this->autoRender = false;
		$serverName = $_SERVER['SERVER_NAME'];
		$sisDb = new Login();
		$sisstDb = new Loginst();
        $userData = array();
        $teachers = new Teacher();
        $students = new Student();
        $dataToLogs = array();
		//$teacherModel = new Teacher();
      	//pr(base64_encode('270'));
        //pr(base64_encode('3815'));
        //pr(base64_encode('256'));
        
        if(!empty($this->params['url']['uid'])){
                $urlUID = $this->params['url']['uid'];
                $decodeUID = base64_decode($urlUID);
               // pr($decodeUID);
               //pr($decodeUID); exit();

        //Cake Sessions
        //$cakesessions = new Siscakesession();
        $cakeSesData = $sisDb->find('first',array('conditions' => array("id" => $decodeUID),'recursive'=> -1));
        if(empty($cakeSesData))
        	$cakeSesData = $sisstDb->find('first',array('conditions' => array("id" => $decodeUID),'recursive'=> -1));

       // pr($cakeSesData);
        $SISdataArr = array();
        $SISdataArr = $cakeSesData;
        //pr($SISdataArr);
        //exit();
        /*
        foreach($cakeSesData as $csd){

        $cakeSesDataSimplify = $csd['Siscakesession']['data'];
        $cakeSesDataSimplify = explode('User|',$cakeSesDataSimplify);
        $cakeSesDataSimplify = str_replace('General|','',$cakeSesDataSimplify[1]);
        $cakeSesDataSimplify = unserialize($cakeSesDataSimplify);

        //pr($cakeSesDataSimplify);
        array_push($SISdataArr,$cakeSesDataSimplify);

        }*/
        //load json data
        	
		    $server = 'http://'.$serverName;
		    $url = $server.'/cis_sh/class_advisories/show_sections/index.ctp';
			$url2 = '';
			$datas = '';
			
			function loadFile($url) {
			    $ch = curl_init();

			    curl_setopt($ch, CURLOPT_HEADER, 0);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_URL, $url);

			    $data = curl_exec($ch);
			    curl_close($ch);

			    return $data;
			}
			
			//if(!empty($this->params['url']['sections']))
				$datas = loadFile($url); 
				$data_json = new RecursiveIteratorIterator(
			    new RecursiveArrayIterator(json_decode($datas, TRUE)),
			    RecursiveIteratorIterator::SELF_FIRST);
				//pr($data_json);
				$data_arr = array();
				$count = 1;

				foreach ($data_json as $key => $val) {
				    
				    if(is_array($val)) {
				    	$count++;
				    	//pr($count);
				    	$r = $count % 2;
				    	//pr($r);
				    	if($r == 1){
					        //pr($val);
					        array_push($data_arr, $val);
					    }
				    } else {
				        
				    }

				}
       	
        //exit();
        if(empty($SISdataArr))
        {
        	return $this->redirect(array('controller' => 'lasdocs','action' => 'index'));
        }

        //students data
        $st_id = '';
       	if(!empty($SISdataArr['Loginst']['id'])){
		if($SISdataArr['Loginst']['id'] != null)
		$st_id = $SISdataArr['Loginst']['id'];
	}
        if(!empty($SISdataArr)){
	        //teacher //student
	        $sisData = '';
	        $sisstData = '';
	        // check if advise or admin -- 10-18-2016
	        if(!empty($SISdataArr['Login']['group']) && $SISdataArr['Login']['group'] == 'Adviser' || !empty($SISdataArr['Login']['group']) && $SISdataArr['Login']['group'] == 'Administrator'){
	        $sisData = $sisDb->find('first',array('fields' =>'id,group,fname,lname,ext,uname,pword,email_address','conditions'=>array('id'=>$SISdataArr['Login']['id']),'recursive'=>-1));
	        }
	        else{

	        $sisstData = $sisstDb->find('first',array('fields' =>'id,section_id,batch,student_id,pd_fname,pd_lname,pd_ext,password','conditions'=>array('id'=>$st_id),'recursive'=>-1));
	       	}
	       	//pr($SISdataArr);
	       	//pr($sisstData);
	       	//exit();
	       	if(!empty($sisData)){
	        //teacher
	       		$istuorialtemp = '';
	       	$checkTeacherDB = $teachers->find('first',array('fields'=>'uname,pword,istutorial','conditions' => array('uname' => $sisData['Login']['uname'],'pword' => $sisData['Login']['pword']),'recursive'=>-1));

	       	$isAdmin = 0;

	            if($sisData['Login']['group'] == 'Admin')
	                    $isAdmin = 1;
	            else
	                  	pr('Current Permission: '.$sisData['Login']['group']);
	    	
	    	if(empty($checkTeacherDB['Teacher']['email']))
	    		$defaultEmail = $sisData['Login']['uname'];
	    	else
	    		$defaultEmail = $sisData['Login']['email'];

	            $userdata = array('id'=>$sisData['Login']['id'],'fname'=> $sisData['Login']['fname'],'lname' =>$sisData['Login']['lname'],'ext' =>$sisData['Login']['ext'],'uname' => $sisData['Login']['uname'],'pword' => $sisData['Login']['pword'],'email' =>$sisData['Login']['email_address'],'isadmin' => $isAdmin,'istutorial'=> 1,'email'=>$defaultEmail);
	            pr('Local Userdata to be save: ');
	            pr($userdata);

	        pr('Local Teachers DB: ');
	        pr($checkTeacherDB);

	        pr('SIS plus Database: ');
	        pr($sisData);

			        if(!empty($sisData)){
			                    if(!empty($checkTeacherDB)){
			                            pr('Account is already exist.');
			                            pr('Account is already exist in the local database');
			                                $teachers->id = $userdata['id'];
			                                 $userdata['istutorial'] = $checkTeacherDB['Teacher']['istutorial'];
			                                 if($teachers->save($userdata)){

			                                            }else{

			                                            }

			                    }else{
			                          	//save data from sis_plus_db to vcite_db
			                            if(!empty($userdata)){

			                                            pr('Account did not exist');
			                                            pr('New Account has beed save');
			                                            $teachers->create();
			                                            if($teachers->save($userdata)){

			                                            }else{

			                                            }
			                                            $istuorialtemp = $userdata['istutorial'];
			                            }
			                    }

			    	}

			    	$userdata = array('id'=>$sisData['Login']['id'],'fname'=> $sisData['Login']['fname'],'lname' =>$sisData['Login']['lname'],'ext' =>$sisData['Login']['ext'],'uname' => $sisData['Login']['uname'],'pword' => $sisData['Login']['pword'],'email' =>$sisData['Login']['email_address'],'isadmin' => $isAdmin,'istutorial'=> $istuorialtemp,'email'=>$defaultEmail);
			        pr('UserData: ');
			        pr($userdata);
	            }elseif(!empty($sisstData)){
		            	pr('wews wala may teachers');
		            	pr($sisstData);
		            	//students
				       	$checkStudentDB = $students->find('first',array('fields'=>'email,pword,section','conditions' => array('email' => $sisstData['Loginst']['student_id'],'pword' => $sisstData['Loginst']['password']),'recursive'=>-1));
				       //pr($data_arr);
				       	$students_section = '';
				       	$students_batch = '';
				       	for($c=0;$c<count($data_arr);$c++){
				       		//pr($c);
				       		if($data_arr[$c]['section_id'] === $sisstData['Loginst']['section_id'] && $data_arr[$c]['batch_id'] === $sisstData['Loginst']['batch']){
				       			pr($data_arr[$c]['advisory_class']);
				       			pr($data_arr[$c]['section_id'].' = '.$sisstData['Loginst']['section_id']);
				       			$students_section = $data_arr[$c]['advisory_class'];
				       			$students_batch = $data_arr[$c]['batch_id'];
				       		}else{

				       		}
				       	}
				       	

			            $userdata = array('id'=>$sisstData['Loginst']['id'],'section' => $students_section,'batch' => $students_batch,'fname'=> $sisstData['Loginst']['pd_fname'],'lname' =>$sisstData['Loginst']['pd_lname'],'ext' =>$sisstData['Loginst']['pd_ext'],'email' => $sisstData['Loginst']['student_id'],'pword' => $sisstData['Loginst']['password']);
			            pr('Local Userdata to be save: ');
			            pr($userdata);

				        pr('Local Students DB: ');
				        pr($checkStudentDB);

				        pr('SIS plus Database: ');
				        pr($sisstData);
				        
						        if(!empty($sisstData)){
						                    if(!empty($checkStudentDB)){
						                            pr('Account is already exist.');
						                            pr('Account is already exist in the local database');
						                                $students->id = $userdata['id'];
						                                 if($students->save($userdata)){

						                                            }else{

						                                            }

						                    }else{
						                          	//save data from sis_plus_db to vcite_db
						                            if(!empty($userdata)){

						                                            pr('Account did not exist');
						                                            pr('New Account has beed save');
						                                            $students->create();
						                                            if($students->save($userdata)){

						                                            }else{

						                                            }

						                            }


						                    }


						    	}
						    	$userdata = array('id'=>$sisstData['Loginst']['id'],'fname'=> $sisstData['Loginst']['pd_fname'],'lname' =>$sisstData['Loginst']['pd_lname'],'ext' =>$sisstData['Loginst']['pd_ext'],'uname' => $sisstData['Loginst']['student_id'],'pword' => $sisstData['Loginst']['password']);
						        pr('UserData: ');
						        pr($userdata);
		            }
	           //exit();
		    }

            	if(!empty($userdata)){
	            $uname = $userdata['uname'];
				$pword = $userdata['pword'];
				pr($uname.'-'.$pword);

			//checking login
			
				

				$hashpwd = $pword;
				//$hashpwd = $this->request->data['Page']['password'];
				#pr($this->request->data['Page']['password']);
				#pr($hashpwd); exit();
			
					
					#pr($hashpwd);
					$check_teacher = $teachers->find('first', array('fields' => array('Teacher.id',
																						  'Teacher.fname',
																						  'Teacher.lname',
																						  'Teacher.ext'
																						 ),
																		'conditions' => array('Teacher.uname' => $uname,
																							  'Teacher.pword' => $hashpwd,
																							 ),
																		'recursive' => -1
																		));

					pr($check_teacher);
					if ($check_teacher) {
						$data['User']['id'] = $check_teacher['Teacher']['id'];
						$data['User']['fname'] = $check_teacher['Teacher']['fname'];
						$data['User']['lname'] = $check_teacher['Teacher']['lname'];
						$data['User']['ext'] = $check_teacher['Teacher']['ext'];
						$data['User']['group'] = "teacher";
						
						$this->Context->createUserSession($this, $data);
						
						//activity logs start here
							$id = $data['User']['id'];
							$name = $this->Session->read('User.wholename');
							$activity = 'Login';
							$this->createLogs($id,0,$name,$activity);
						//end logs
						pr($data);
						pr($this->Session->read('User'));
						$this->redirect(array('controller' => 'teachers', 'action' => 'dashboard'));
						/**/
					} else {
						
						$studentModel = new Student();

						$check_student = $studentModel->find('first', array('fields' => array('Student.id',
																							  'Student.fname',
																							  'Student.lname',
																							  'Student.ext'
																							 ),
																			'conditions' => array('Student.email' => $uname,
																								  'Student.pword' => $hashpwd,
																								 ),
																			'recursive' => -1
																			));

						if ($check_student) {
							$data['User']['id'] = $check_student['Student']['id'];
							$data['User']['fname'] = $check_student['Student']['fname'];
							$data['User']['lname'] = $check_student['Student']['lname'];
							$data['User']['ext'] = $check_student['Student']['ext'];
							$data['User']['group'] = "student";
							//pr($check_student);
							
							$this->Context->createUserSession($this, $data);
							
							//activity logs start here
								$id = $data['User']['id'];
								$name = $this->Session->read('User.wholename');
								$activity = 'Login';
								$this->createLogs(0,$id,$name,$activity);
							//end logs

							$this->redirect(array('controller' => 'students', 'action' => 'dashboard'));
							/**/
						} else {
							$this->Session->setFlash(__('Sorry, but we cannot find your account.'), 'default', array('class' => 'alert alert-danger'));
						}


						/**/
				
					}
				}else{
					$warningMsg = '
					There is something wrong. User\'s database cannot be found. Please ask the administrator.
					';
					echo $warningMsg;
					//header('Location: http://192.168.12.5/vcite');
				    exit();
				}
		}else {
				pr('no id found!');
				//$this->Session->setFlash(__('Please enter you login information.'), 'default', array('class' => 'alert alert-danger'));
				header('Location: http://'.$serverName.'/cis');
				exit();
			}

	}
	/*
	public function login() {
		
		$this->layout = "empty";
		$security = new Security();
		if ($this->request->is('post')) {
			

			$hashpwd = $security->hash($this->request->data['Page']['password']);
			//$hashpwd = $this->request->data['Page']['password'];
			#pr($this->request->data['Page']['password']);
			#pr($hashpwd); exit();
			if (!empty($this->request->data['Page']['emailadd']) && !empty($hashpwd)) {
				$dataToLogs = array();
				$teacherModel = new Teacher();
				#pr($hashpwd);
				$check_teacher = $teacherModel->find('first', array('fields' => array('Teacher.id',
																					  'Teacher.fname',
																					  'Teacher.lname',
																					  'Teacher.ext'
																					 ),
																	'conditions' => array('Teacher.email' => h($this->request->data['Page']['emailadd']),
																						  'Teacher.pword' => h($hashpwd),
																						 ),
																	'recursive' => -1
																	));

				if ($check_teacher) {
					$data['User']['id'] = $check_teacher['Teacher']['id'];
					$data['User']['fname'] = $check_teacher['Teacher']['fname'];
					$data['User']['lname'] = $check_teacher['Teacher']['lname'];
					$data['User']['ext'] = $check_teacher['Teacher']['ext'];
					$data['User']['group'] = "teacher";

					$this->Context->createUserSession($this, $data);
					
					//activity logs start here
						$id = $data['User']['id'];
						$name = $this->Session->read('User.wholename');
						$activity = 'Login';
						$this->createLogs($id,0,$name,$activity);
					//end logs

					$this->redirect(array('controller' => 'teachers', 'action' => 'dashboard'));
					
				} else {
					$studentModel = new Student();

					$check_student = $studentModel->find('first', array('fields' => array('Student.id',
																						  'Student.fname',
																						  'Student.lname',
																						  'Student.ext'
																						 ),
																		'conditions' => array('Student.email' => h($this->request->data['Page']['emailadd']),
																							  'Student.pword' => $hashpwd,
																							 ),
																		'recursive' => -1
																		));

					if ($check_student) {
						$data['User']['id'] = $check_student['Student']['id'];
						$data['User']['fname'] = $check_student['Student']['fname'];
						$data['User']['lname'] = $check_student['Student']['lname'];
						$data['User']['ext'] = $check_student['Student']['ext'];
						$data['User']['group'] = "student";
						$this->Context->createUserSession($this, $data);
						
						//activity logs start here
							$id = $data['User']['id'];
							$name = $this->Session->read('User.wholename');
							$activity = 'Login';
							$this->createLogs(0,$id,$name,$activity);
						//end logs

						$this->redirect(array('controller' => 'students', 'action' => 'dashboard'));
						
					} else {
						$this->Session->setFlash(__('Sorry, but we cannot find your account.'), 'default', array('class' => 'alert alert-danger'));
					}



				}
				
			} else {
				$this->Session->setFlash(__('Please enter you login information.'), 'default', array('class' => 'alert alert-danger'));
			}

			
		}
	}
	*/
	public function logout() {
		$serverName = $_SERVER['SERVER_NAME'];
		//activity logs start here
			$id = $this->Session->read('User.id');
			$name = $this->Session->read('User.wholename');
			$activity = 'Logout';
			if($this->Session->read('User.group') == 'teacher')
			$this->createLogs($id,0,$name,$activity);
			if($this->Session->read('User.group') == 'student')
			$this->createLogs(0,$id,$name,$activity);
		//end logs
		//$this->Session->delete('User');

		
		header('Location: http://'.$serverName.'/cis/pages');
		exit();
		//$this->redirect(array('action' => '/'));
		/**/
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
			$id = $data['User']['id'];
			$name = $data['User']['fname'].' '.$data['User']['lname'].' '.$data['User']['ext'];
			$activity = 'Login';
			$this->createLogs($id,0,$name,$activity);
		//end logs
		*/

	}
}
