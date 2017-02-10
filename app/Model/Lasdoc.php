<?php
App::uses('AppModel', 'Model');
/**
 * Option Model
 *
 * @property Question $Question
 */
class Lasdoc extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
public $hasMany = array(
		
		'Docfile' => array(
			'className' => 'Docfile',
			'foreignKey' => 'lasdoc_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => array('Docfile.id',
							  'Docfile.lasdoc_id',
							  'Docfile.foldertree',
							  'Docfile.title',
							  'Docfile.link',
							  'Docfile.modified'
							 ),
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
}
