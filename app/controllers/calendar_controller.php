<?php
class CalendarController extends AppController {

	var $name = 'Calendar';
	var $uses = array();
	
	function index()
	{
	  
	}
	
	function table() {
	  $this->layout = null;
	  
	  echo debug($this->params);
	  
    $this->set('month', $this->params['month']);
    $this->set('year', $this->params['year']);
    $this->set('type', $this->params['type']);
	}
}
?>
