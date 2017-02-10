<?php
App::uses('AppModel', 'Model');
/**
 * Subject Model
 *
 * @property Teacher $Teacher
 * @property Topic $Topic
 */
class Subject extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */

	public $belongsTo = array(
		'Teacher' => array(
			'className' => 'Teacher',
			'foreignKey' => 'teacher_id',
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
		
		'Topic' => array(
			'className' => 'Topic',
			'foreignKey' => 'subject_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => array('Topic.id',
							  'Topic.chapter',
							  'Topic.title',
							  'Topic.content',
							  'Topic.modified'
							 ),
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		) ,
        'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'subject',
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

}
