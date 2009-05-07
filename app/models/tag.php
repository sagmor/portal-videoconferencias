<?php
class Tag extends AppModel
{
	var $name = 'Tag';
	
	var $validate = array('name' => VALID_NOT_EMPTY);

}
?>