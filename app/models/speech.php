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

	function beforeDelete(){
		
		$speech = $this->findById($this->id);
		$this->data['Speech'] = $speech['Speech'];
		$userIds = $speech['User'];
	        $userIds = array_unique($userIds);
		foreach($userIds as $user){
			$this->sendMail($user, false, true);
		}
		return true;
		
	}

	function afterSave($created){
		
		$userIds = array();
		
		if(!$created){
			$userIds = $this->SpeechesUser->find('list',
			                                      array('conditions' =>
			                                            array('speech_id' => $this->data['Speech']['id']),
                                                        'fields' => 
			                                            array('user_id')));
		}
		else{
			foreach($this->data['Tag'] as $tag_id){
				$userIds = array_merge($userIds,
			                           $this->User->UsersTag->find('list', //No funciona DISTINCT ni OR!!!
		                                                           array('conditions' => 
		                                                                 array('tag_id' => $tag_id),
                                                                         'fields' =>
		                                                                 array('user_id'))));
			}
		}                                                       
		$userIds = array_unique($userIds);
		foreach($userIds as $user_id){
			$user = $this->User->findById($user_id);
			$user = $user['User'];
			$this->sendMail($user, $created);
		}
		return true;
	}

function sendMail($user, $created, $del = false){
        	if($user['lang'] == 'esp'){
        		$to = $user['email'];
        		$subject = $created?
                           'Nueva charla '.$this->data['Speech']['title'].'. Portal conferencias DCC':
                           'La charla '.$this->data['Speech']['title'].($del? ' ha sido eliminada':
        		                                                              ' ha sufrido cambios');
        		$from = 'Portal Conferencias DCC <no-reply@videosdcc.cl>';
        		$text = $del? 'La charla fue eliminada' :
        		              'Para más información visite la siguiente dirección '.
        		            $this->getRoot().'/speeches/show/'.$this->id;
        		$this->ae_send_mail($from, $to, $subject, $text);
        	}
        	else{
        		$to = $user['email'];
        		$subject = $created?
                           'New Lecture '.$this->data['Speech']['title'].'. Portal conferencias DCC':
                           'The Lecture '.$this->data['Speech']['title'].($del? ' has been deleted':
        		                                                                ' has been modified');
        		$from = 'Portal Conferencias DCC <no-reply@videosdcc.cl>';
        		$text =$del? 'The lecture was deleted' : 
        		             'For further information visit the next page '.
        		             $this->getRoot().'/speeches/show/'.$this->id;
        		$this->ae_send_mail($from, $to, $subject, $text);
        	}
        }
        
}
?>
