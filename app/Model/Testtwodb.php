<?php
App::uses('AppModel','Model');

Class Testtwodb extends AppModel{

         public $useTable = 'cake_sessions';
         public $useDbConfig = 'testtwodatabase';
}

?>
