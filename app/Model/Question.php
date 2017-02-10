<?php
App::uses('AppModel', 'Model');
/**
 * Question Model
 *
 * @property Subject $Subject
 * @property Option $Option
 */
class Question extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Subject' => array(
			'className' => 'Subject',
			'foreignKey' => 'subject_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Option' => array(
			'className' => 'Option',
			'foreignKey' => 'question_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => array('Option.id',
							  'Option.option',
							  'Option.correct',
							  'Option.alternate_option'
							 ),
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
