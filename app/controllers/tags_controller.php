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
		$this->data['Tag']['tags'] = $this->Tag->find('all');
		$this->set('data', $this->data['Tag']['tags']);
		if(!empty($this->data['Tag']['name'])){
			$this->Tag->save($this->data);
			$this->redirect(array('action' => 'administrar'));
			echo 'hola';
		}
	}

	function delete($tag_id){
		$this->Tag->del($tag_id, true);
        $this->flash('El tag: '.$tag_id.' ha sido borrar.', '/', 1);
        $this->redirect(array('action' => 'administrar'));
	}
}
?>