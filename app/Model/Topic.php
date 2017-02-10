<?php
App::uses('AppModel', 'Model');
/**
 * Topic Model
 *
 * @property Subject $Subject
 */
class Topic extends AppModel {


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
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'topic_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => array('Question.id',
							  'Question.subject_id',
							  'Question.topic_id',
							  'Question.type',
							  'Question.content',
							  'Question.category',
							  'Question.shuffle',
							  'Question.tag'
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
