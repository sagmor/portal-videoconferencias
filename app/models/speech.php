<?php
class Speech extends AppModel {
	var $name = 'Speech';

	var $hasAndBelongsToMany = array(
									'Tag' => array(
												'className' => 'Tag',
												'joinTable' => 'speeches_tags',
												'foreignKey' => 'speech_id',
												'associationForeignKey' => 'tag_id'));

	var $validate = array(
						'title' => array('rule' => 'notEmpty',
										'message' => 'La conferencia debe tener un título'),
						'speakers' => array('rule' => 'notEmpty',
										'message' => 'La conferencia debe tener al menos un orador'),
						'location' => array('rule' => 'notEmpty',
										'message' => 'La conferencia debe tener un lugar donde realizarse'),
						'date' => array('rule' => 'notEmpty',
										'message' => 'La conferencia debe tener una fecha a realizarse')
	);

	function beforeValidate(){
		if(!isset($this->data['Tag'])) {
			echo 'Debe seleccionar al menos una categoría';
			$this->validationErrors['Speech']['title'] = 'Debe seleccionar al menos una categoría';
		} else if(empty($this->data['Tag'])){
			echo 'Debe seleccionar al menos una categoría';
			$this->validationErrors['Tag']['title'] = 'Debe seleccionar al menos una categoría';
		}

		if(isset($this->data['Tag']['Tag'])) {
			if(empty($this->data['Tag']['Tag'])){
				echo 'Debe seleccionar al menos una categoría';
				$this->validationErrors['Tag']['Tag'] = 'Debe seleccionar al menos una categoría';
			}
		}
	}
}
?>