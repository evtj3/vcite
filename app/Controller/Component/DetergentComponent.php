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
class DetergentComponent extends Component {

    #public function startup(&$controller){
            #$this->name = $controller->name;
    #}

	public function started() {
		return CakeSession::started();
	}

    public function urlsafe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_','.'),$data);

        return $data;
    }

    public function urlsafe_b64decode($string) {
        $data = str_replace(array('-','_','.'),array('+','/','='),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }

        return base64_decode($data);
    }

    public function get_as_of($date1, $date2 = null) {
            if (empty($date2)) $date2 = date('Y-m-d H:i:s');

            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);

            $seconds_diff = $timestamp2 - $timestamp1;
            $day_diff = floor($seconds_diff / 3600 / 24);

            if ($day_diff==0) {
                return "Today";
            } else if ($day_diff==1) {
                return "Yesterday";
            } else {
                return $date1;
            }
    }
}
