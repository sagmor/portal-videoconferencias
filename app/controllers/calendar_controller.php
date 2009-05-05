<?php
class CalendarController extends AppController {

	var $name = 'Calendar';
	var $uses = array();
	
	function index()
	{
	  $this->set('month', $this->params['month']);
    $this->set('year', $this->params['year']);
	}
	
	function table() {
	  $this->layout = null;
	  Configure::write('debug',0);
	  
    $this->set('month', $this->params['month']);
    $this->set('year', $this->params['year']);
    $this->set('type', $this->params['type']);
	}
}
?>
