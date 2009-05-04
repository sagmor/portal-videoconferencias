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
}
?>