<?php
class JsController extends AppController {

	var $name = 'Js';
	var $uses = array();
	
	function beforeFilter() {
	  if ($this->params['url']['ext'] != 'js') {
      exit;
    }
    $this->layout = null;
    $this->ext = '.js';
    Configure::write('debug',0);
	}
	
	function calendar()
	{
	  
	}
}
?>
