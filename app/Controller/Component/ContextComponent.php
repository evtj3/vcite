<?php
/**
 * SessionComponent.  Provides access to Sessions from the Controller layer
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller.Component
 * @since         CakePHP(tm) v 0.10.0.1232
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Component', 'Controller');
App::uses('Utility', 'Sanitize');

/**
* Session Component.
*
* Session handling from the controller.
*
* @package       Cake.Controller.Component
* @link http://book.cakephp.org/2.0/en/core-libraries/components/sessions.html
* @link http://book.cakephp.org/2.0/en/development/sessions.html
*/

class ContextComponent extends Component {
		public function startup(&$controller){
				#$this->name = $controller->name;
		}

		public function started() {
			return CakeSession::started();
		}
		
		function checkSession(&$controller){
			if ($controller->Session->read('User.id')==NULL) $controller->redirect('/pages/login');
		}
		
		function doNotPermit(&$controller, $group){
			if ($controller->Session->read('User.id')==NULL) $controller->redirect('/pages/login');
			
			$array_groups = explode(",", $group);

			foreach($array_groups as $group) {
				if (strtoupper($controller->Session->read('User.group')) == trim(strtoupper($group))) {
					$controller->redirect('/pages/select_dashboard');
				}
			}
		}

		function createUserSession(&$controller, $data = array()) {
			if (array_key_exists('User', $data)) {
				$controller->Session->write('User.id', $data['User']['id']);
				$controller->Session->write('User.wholename', $data['User']['fname'].' '.$data['User']['lname']);
				$controller->Session->write('User.group', $data['User']['group']);
			} else {
				$controller->redirect('/users/login');
			}
		}
			
		public function destroy(&$controller) {
			$controller->Session->delete('User');
		}
}
?>
