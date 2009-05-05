<?php
class Tag extends AppModel
{
	var $name = 'Tag';
	
	var $validate = array('name' => array( 
                'rule' => '/.+/',
                'required' => true,
                'message' => 'Debes ingresar Algo'
              ));

}
?>