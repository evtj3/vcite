<?php
App::uses('AppModel', 'Model');
/**
 * Teacher Model
 *
 * @property Subject $Subject
 */
class Teacher extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $validate = array(
	    'pword' => array(
	        'rule' => array('minLength', 8)
	    )
	);
	public $hasMany = array(
		'Subject' => array(
			'className' => 'Subject',
			'foreignKey' => 'teacher_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => array('Subject.id', 
							  'Subject.title',
							  'Subject.description',
							  'Subject.cover_img',
							  'Subject.created'
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
