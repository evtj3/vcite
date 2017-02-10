<?php
App::uses('AppModel', 'Model');
/**
 * Student Model
 *
 */
class Student extends AppModel {

	public $hasMany = array(
        'Quizresult' => array(
            'className' => 'Quizresult',
            'foreignKey' => 'student_id',
            'fields' => 'id,quiz_id,topic_id,subject_id,score,total_score'
        ),
        'Readpage' => array(
            'className' => 'Readpage',
            'foreignKey' => 'student_id',
            'fields' => 'id,topic_id,subject_id,page_read,total_page'
        )
    );
	/*
	public $hasAndBelongsToMany = array(
        'Ingredient' =>
            array(
                'className' => 'Ingredient',
                'joinTable' => 'ingredients_recipes',
                'foreignKey' => 'recipe_id',
                'associationForeignKey' => 'ingredient_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => ''
            )
    );*/
}
