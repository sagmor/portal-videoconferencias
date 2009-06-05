<?php
class Speech extends AppModel {
	var $name = 'Speech';

	var $hasAndBelongsToMany = array(
									'Tag' => array(
												'className' => 'Tag',
												'joinTable' => 'speeches_tags',
												'foreignKey' => 'speech_id',
												'associationForeignKey' => 'tag_id'),
            					     'User' =>
									 array('className' => 'User',
            							   'joinTable' => 'speeches_users',
            							   'foreignKey' => 'speech_id',
            							   'associationForeignKey' => 'user_id'));

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
	
//	function beforeSave(){
//
//		/*$relatedUsers = $this->find('all',
//		 array('conditions' => array('Speech.id' => $this->data['Speech']['id'])),
//		 array('fields' => array('User.name', 'User.email')));
//		 if($oldTag[''])*/
//
//	}

        function afterSave($created){

                if($created){
                        $userIds = $this->User->UsersTag->find('list',
                                                                    array('conditions' =>
                                                                          array('tag_id' => $this->data['Tag']),
                                                                          'fields' => 
                                                                          array('UsersTag.user_id'))); 
                        $userIds = array_unique($userIds);
                        echo debug($this->data['Tag']);                                                  
                        echo debug(array_unique($userIds));
                        foreach($userIds as $user_id){
                        	$user = $this->User->findById($user_id);
                        	echo debug($user);
                        }
                }
                
                return false;

        }
        
}
?>