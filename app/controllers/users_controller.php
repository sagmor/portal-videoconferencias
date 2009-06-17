<?php
class UsersController extends AppController
{
	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'Captcha' );
	var $components = array('Captcha');

	function index(){
		if ($this->validateAdmin()) {
			$users = $this->User->find('all',
				array('fields' => array('User.id',
									   'User.name',
									   'User.email',
									   'User.type')));
			$this->set('users', $users);
		}
	}

	function register() {
		if (!empty($this->data['User'])){
			//			if ($this->Captcha->protect('User')) {
			if ($this->User->save($this->data)){
				$this->Session->write('user_id', $this->User->id);
				$this->flash(__('your_user_has_been_created', true), '/');
			} else {
				$this->data['User']['password'] = $this->data['User']['password_confirmation'] = '';
			}
			//			} else {
			//				echo 'Falló la captura de imagen';
			//			}

		}
	}

	function edit($id = null){
		if ($this->validateUser()) {
			$current_user = $this->currentUser();

			if ($id == null) {
				$this->User->id = $current_user['User']['id'];
			} elseif ($id != $current_user['User']['id'] && $this->validateAdmin() ) {
				return;
			} else {
				$this->User->id = $id;
			}

			if (empty($this->data)) {
				$this->data = $this->User->read();
			} else {
				$this->User->read();
				if ($this->User->save($this->data)) {
					$this->flash(__('your_profile_is_update', true), '/');
				}
			}
		}
	}

	function login()
	{
		if (!empty($this->data['User'])){
			$result = $this->User->authenticate($this->data['User']['email'], $this->data['User']['password']);

			if ($result != null) {
				$this->Session->write('user_id', $result['User']['id']);
				$this->flash('Bienvenido', '/');
			} else {
				$this->flash(__('wrong_user_or_password', true), array('action' => 'login'));
			}
		}
	}

	function logout()
	{
		$this->Session->delete('user_id');
		$this->flash(__('goodbye', true), '/');
	}

	function verSuscripciones()
	{
		$subscripciones = $this->User
		->find('all',
			array('fields' =>
				array('User.name', 'Tag.name')));

	}

	function getCurrentUserType(){
		$username = $this->Session->read('user');
		$result = $this->User->findByName($username);
		return $result['User']['type'];
	}

	function cambiarPermiso($user_id){
		if ($this->validateAdmin()) {
			$user = $this->User->find('first',
				array('conditions' => array('User.id' => $user_id)));
			$user['User']['type'] = $user['User']['type'] == 'admin'? 'normal':'admin';
			$this->User->save($user);
			$this->redirect(array('action' => 'index'));
		}
	}

	function eliminar($user_id){
		if ($this->validateAdmin()) {
			$this->User->del($user_id);
			$this->redirect(array('action' => 'index'));
		}
	}

	function captcha() {

		$this->Captcha->show();

	}

}
?>