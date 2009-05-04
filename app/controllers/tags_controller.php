<?php
class TagsController extends AppController
{
	var $name = 'Tags';
	var $helpers = array('Html', 'Form' );

	function getTags()
	{
		$tags = $this->Tag->find('all');
		$arrTags = array();
		foreach($tags as $tag){
			$arrTags[$tag['Tag']['id']] = $tag['Tag']['name'];
		}
		return $arrTags;
	}

	function administrar(){
		$this->data['Tag']['tags'] = $this->Tag->find('list');
		$this->set('data', $this->data['Tag']['tags']);
		echo debug($this->data['Tag']['tags']);
	}

	function eliminar($tag){
		echo debug($tag);
	}

}
?>