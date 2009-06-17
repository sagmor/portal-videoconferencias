<?php

uses('L10n');

class AppController extends Controller {
	var $helpers = array('Html', 'Javascript', 'Form');
	var $uses = array('User');

	var $current_user = null;

	function beforeFilter() {
		if ($this->Session->check('user_id')) {
			$this->current_user = $this->User->findById( $this->Session->read('user_id') );
		}

		$this->set('current_user', $this->current_user);

		$this->L10n = new L10n();
		$languages=array('esp','en');
		$lang = 'esp';
		if(isset($this->current_user)) {
			$lang = $this->current_user['User']['lang'];
		}
		$this->Session->write('lang',$lang);
		
		$this->L10n->get($lang);
		Configure::write('Config.language', $lang);
	}

	protected function currentUser() {
		return $this->current_user;
	}

	protected function validateUser() {
		if ($this->currentUser() == null) {
			$this->flash(__('you_have_to_enter', true), array('controller'=>'users', 'action'=>'login'));

			return false;
		}

		return true;
	}

	protected function validateAdmin() {
		if (!$this->validateUser()) return false;

		if ($this->current_user['User']['type'] != 'admin') {
			$this->flash(__('not_permited', true), '/');
			return false;
		}

		return true;
	}
}
?>