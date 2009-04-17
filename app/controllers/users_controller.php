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
					$this->Session->write('user', $this->data['User']['name']);
					$this->flash('Te haz registrado correctamente', '/');
					$this->redirect('/');
					exit();
				}
				else {
					$this->flash('Hubo un problema mientras te registrabas',
					'/');
					exit();
				}
			}
		}
	}
	
	function login($name, $password)
	{
		if ($name && $password){
			$result = $this->User->findByName($name);
			if($result && $result['User']['password'] == md5($password)){
				$this->Session->write('user', $result['User']['name']);
			}
			else{
				$this->flash('name = '+$this->params['form']['name']+
				' password = '+$this->params['form']['password'], '/');
			}
		}
	}
}
?>