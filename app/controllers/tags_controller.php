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
	  if ($this->validateAdmin()) {
		  $this->data['Tag']['tags'] = $this->Tag->find('all');
		  $this->set('data', $this->data['Tag']['tags']);
		  
		  if(!empty($this->data['Tag']['name'])){
			  $this->Tag->save($this->data);
			  $this->flash('Se ha creado el Tag', array('action' => 'administrar'));
		  }
	  }
	}

	function delete($tag_id){
	  if ($this->validateAdmin()) {
		  $this->Tag->del($tag_id, true);
      $this->flash('Se ha eliminado el Tag', array('action' => 'administrar'));
    }
	}

}
?>