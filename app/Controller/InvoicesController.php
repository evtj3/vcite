<?php
    Configure::write('CakePdf', array(
        'engine' => 'CakePdf.WkHtmlToPdf',
        'options' => array(
            'print-media-type' => false,
            'outline' => true,
            'dpi' => 96
        ),
        'margin' => array(
            'bottom' => 15,
            'left' => 50,
            'right' => 30,
            'top' => 45
        ),
        'orientation' => 'landscape',
        'download' => true
    ));
?>
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
App::import('Model','Topic');
class InvoicesController extends AppController {

	/**
	* This controller does not use a model
	*
	* @var array
	*/
	public $name = 'Invoices';
	public $uses = null;
	public $components = array('RequestHandler');
	/**
	* Displays a view
	*
	* @param mixed What page to display
	* @return void
	* @throws NotFoundException When the view file could not be found
	*	or MissingViewException in debug mode.
	*/
	public function view($id = null) {
       
        
        $topics = new Topic();
        $tp = $topics->find('first',array('conditions' => array(
        	'id' => $id
        	),'recursive' => -1));
        
        $this->pdfConfig = array(
            'orientation' => 'portrait',
            'filename' => 'Invoice_' . $id
        );
        //$this->renderer($this->pdfConfig);
      # pr($this->pdfConfig);
        $this->set(compact('tp'));
    	
    }
	
}
