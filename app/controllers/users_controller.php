<?php
class UsersController extends AppController
{
	var $name = 'Users';
	var $helpers = array('Html', 'Form' );
	
	function register()
	{
		if (!empty($this->data['User']))
		{
			if($this->data['User'][0]['password'] == $this->data['User'][1]['password']){
				$this->data['User']['salt'] = md5(time());
				$this->data['User']['password'] = md5($this->data['User']['salt'] + 
													  $this->data['User'][0]['password']);
				$this->data['User']['type'] = 'normal';
				if ($this->User->save($this->data['User']))
				{
					#$result = $this->User->findByName($this->data['User']['name']);
					#$tag_subscription['user_id'] = $result['Useer']['id'];
					#$tag_subscription['tag_id'] = $this->data[]
					$this->Session->write('user', $this->data['User']['name']);
					$this->flash('Te haz registrado correctamente', '/');
					$this->redirect('/');
					exit();
				}
				else {
					$this->flash('Hubo un problema mientras te registrabas', '/');
					exit();
				}
			}
		}
	}
	
	function login()
	{
		if (!empty($this->data['User'])){
			$result = $this->User->findByName($this->data['User']['name']);
			if($result && $result['User']['password'] == md5($result['User']['salt'] + 
															 $this->data['User']['password'])){
				$this->Session->write('user', $result['User']['name']);
				$this->redirect('/');
			}
			else{
				$this->flash('El usuario no existe o la contraseña es incorrecta', 'users/login');
			}
		}
	}
}
?>