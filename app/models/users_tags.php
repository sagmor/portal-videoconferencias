<?php
class UsersTags extends AppModel
{
	var $name = 'UsersTags';
	var $belongsTo = array('User' => array('className' => 'User',
	                                   'foreignKey' => 'user_id'),
	                       'Tag' => array('className' => 'Tag',
	                                      'foreignKey' => 'tag_id'));
}
?>