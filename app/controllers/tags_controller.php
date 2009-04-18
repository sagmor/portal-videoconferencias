<?php
class TagsController extends AppController
{
	var $name = 'Tags';
	
	function getTags()
	{
		return $this->Tag->find('all');	
	}
}
?>