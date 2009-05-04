<?php
class User extends AppModel
{
	var $name = 'User';
	var $hasAndBelongsToMany = array('Tag' =>
									 array('className' => 'Tag',
            							   'joinTable' => 'users_tags',
            							   'foreignKey' => 'user_id',
            							   'associationForeignKey' => 'tag_id'));
	var $validate = array('name' => array('alphaNumeric' => array('rule' => 'alphaNumeric',
										  'required' => true,
												  'message' => 'Solo letras y números')),
						  'password' => array('rule' => array('minLength', '5'),
											  'required' => true,
											  'message' => 'Debe contener más de 5 caracteres'),
						  'email' => array('rule' => 'email',
						  				   'required' => true,
						  				   'message' => 'Ingrese un correo válido'));


	function beforeValidate() {
		if (!$this->id) {
			if ($this->findCount(array('User.name' =>
									   $this->data['User']['name'])) > 0) {
				$this->invalidate('username_unique');
				return false;
			}
		}
		return true;
	}


}
?>