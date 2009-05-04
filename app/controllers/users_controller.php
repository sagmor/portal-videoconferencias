<?php
class UsersController extends AppController
{
	var $name = 'Users';
	var $helpers = array('Html', 'Form' );

	function register() {
		if (!empty($this->data['User'])){
		  if ($this->User->save($this->data)){
		    $this->Session->write('user_id', $this->User->id);
		    $this->flash('Tu usuario ha sido creado correctamente', '/');
	    } else {
	      $this->data['User']['password'] = $this->data['User']['password_confirmation'] = '';
	    }
		}
	}

	function edit($id = null){
	  $current_user = $this->currentUser();
	  
	  if ($current_user == null) {
	    $this->flash('Acción no autorizada', '/');
	  } elseif ($id == null) {
	    $this->User->id = $current_user['User']['id'];
	  } elseif ( $current_user['User']['type'] != 'admin' && $id != $current_user['User']['id'] ) {
	    $this->flash('Acción no autorizada', '/');
	    return;
	  } else {
	    $this->User->id = $id;
    }
    
    
	    
	  if (empty($this->data)) {
	    $this->data = $this->User->read();
    } else {
      $this->User->read();
      if ($this->User->save($this->data)) {
        $this->flash('Se han actualizado los datos', '/');
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
				$this->flash('El usuario no existe o la contraseña es incorrecta', array('action' => 'login'));
			}
		}
	}
	
	function logout()
	{
		$this->Session->delete('user_id');
		$this->flash('Hasta Pronto', '/');
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

}
?>