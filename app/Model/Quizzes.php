<?php
App::uses('AppModel', 'Model');
/**
 * Exam Model
 *
 * @property Subject $Subject
 * @property Result $Result
 */
class Quizzes extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
/*
	public $belongsTo = array(
		'Subject' => array(
			'className' => 'Subject',
			'foreignKey' => 'subject_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
*/
/**
 * hasMany associations
 *
 * @var array
 *//*
	public $hasMany = array(
		'Result' => array(
			'className' => 'Result',
			'foreignKey' => 'exam_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
*/
}
