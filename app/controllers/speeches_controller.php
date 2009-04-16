<?php
class SpeechesController extends AppController {
	var $helpers = array('Html', 'Javascript', 'Form');
	var $name = 'Speeches';
	
	function index() {
		$this->set('speeches', $this->Speech->findAll());
	}
	
	function view_speech($id = null) {
		$this->Speech->id = $id;
		$this->set('speech', $this->Speech->read());
	}
	
	function add() {
		if(!empty($this->data)) {
			if($this->Speech->save($this->data)) {
				$this->flash('Nueva charla creada', '/');
			}
		}
	}
}
?>