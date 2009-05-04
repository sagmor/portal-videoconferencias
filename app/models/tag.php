<?php
class Tag extends AppModel
{
	var $name = 'Tag';
	
	var $validate = array('name' => array('alphaNumeric' => array('rule' => 'alphaNumeric',
																  'required' => true,
																  'message' => 'Solo letras y números')));

}
?>