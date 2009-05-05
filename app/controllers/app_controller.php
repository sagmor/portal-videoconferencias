<?php
class AppController extends Controller {
	var $helpers = array('Html', 'Javascript', 'Form');
	var $uses = array('User');
	
	var $current_user = null;
	
	function beforeFilter() {
	  if ($this->Session->check('user_id')) {
	    $this->current_user = $this->User->findById( $this->Session->read('user_id') );
	  }
	  
	  $this->set('current_user', $this->current_user);
	}
	
	protected function currentUser() {
	  return $this->current_user;
	}
	
	protected function validateUser() {
	  if ($this->currentUser() == null) {
	    $this->flash('Debes ingresar al sistema para realizar esta operación', array('controller'=>'users', 'action'=>'login'));
	    
	    return false;
	  }
	  
	  return true;
	}
	
	protected function validateAdmin() {
	  if (!$this->validateUser()) return false;
	  
	  if ($this->current_user['User']['type'] != 'admin') {
	    $this->flash('Acción no autorizada', '/');
	    return false;
	  }
	  
	  return true;
	}
}
?>