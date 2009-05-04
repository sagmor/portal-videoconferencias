<?php
class UsersController extends AppController
{
	var $name = 'Users';
	var $helpers = array('Html', 'Form' );

	function index(){
		
	}
	
	function register()
	{
		//echo debug($this->data);
		if (!empty($this->data['User'])){
			if($this->data['User'][0]['password'] == $this->data['User'][1]['password']){
				$this->data['User']['salt'] = md5(time());
				$this->data['User']['password'] = md5($this->data['User']['salt'] +
				$this->data['User'][0]['password']);
				if(!empty($this->data['User']['Privilegios']) && $this->data['User']['Privilegios'][0] == 1){
					$this->data['User']['type'] = 'admin';
				}
				else{
					$this->data['User']['type'] = 'normal';
				}
				if ($this->User->save($this->data)){
					$this->Session->write('user', $this->data['User']['name']);
					$this->redirect(array('action' => 'index'));
				}
				else {
					$this->data['User']['password'] = '';
					$this->Session->setFlash('Hubo un problema al guardar sus datos');

				}
			}
		}
	}

	function edit(){
		if (!empty($this->data['User'])){
			$result = $this->User->findByName($this->Session->read('user'));
			$this->data['User']['id'] = $result['User']['id'];
			if($this->data['User'][0]['password'] == $this->data['User'][1]['password']){
				$this->data['User']['salt'] = md5(time());
				$this->data['User']['password'] = md5($this->data['User']['salt'] +
				$this->data['User'][0]['password']);
				if(!empty($this->data['User']['Privilegios']) && $this->data['User']['Privilegios'][0] == 1){
					$this->data['User']['type'] = 'admin';
				}
				else{
					$this->data['User']['type'] = 'normal';
				}
				if ($this->User->save($this->data)){
					$this->Session->write('user', $this->data['User']['name']);
					$this->redirect(array('action' => 'index'));
					exit();
				}
				else {
					$this->flash('Hubo un problema mientras editabas tus datos', '/');
					exit();
				}
			}
		}
		else{
			$result = $this->User->findByName($this->Session->read('user'));
			$this->data['User']['name'] = $result['User']['name'];
			$this->data['User']['email'] = $result['User']['email'];
			$this->data['User']['lang'] = $result['User']['lang'];
			$arrTags = array();
			$i = 0;
			foreach($result['Tag'] as $tag){
				$arrTags[$i++] = $tag['id'];
			}
			$this->data['Tag']['Tag'] = $arrTags;
		}
	}

	function verSuscripciones()
	{
		$subscripciones = $this->User
							   ->find('all',
									  array('fields' =>
									  array('User.name', 'Tag.name')));
		echo debug($subscripciones);

	}

	function getCurrentUserType(){
		$username = $this->Session->read('user');
		$result = $this->User->findByName($username);
		return $result['User']['type'];
	}

	function login()
	{
		if (!empty($this->data['User'])){
			$result = $this->User->findByName($this->data['User']['name']);
			if($result && $result['User']['password'] == md5($result['User']['salt'] +
			$this->data['User']['password'])){
				$this->Session->write('user', $result['User']['name']);
				$this->redirect(array('action' => 'index'));
			}
			else{
				$this->flash('El usuario no existe o la contraseña es incorrecta', 'users/login');
			}
		}
	}
	
	
	function logout()
	{
		$this->Session->delete('user');
		$this->redirect(array('action' => 'index'), null, true);
	}

}
?>