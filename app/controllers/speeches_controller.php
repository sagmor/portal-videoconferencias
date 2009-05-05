<?php
class SpeechesController extends AppController {
    var $helpers = array('Html', 'Javascript', 'Form');
    var $name = 'Speeches';
    
    var $components = array('json');

    function index() {
        $this->set('speeches', $this->Speech->find('all'));
    }

    function show($id = null) {
        $this->Speech->id = $id;
        $this->set('speech', $this->Speech->read());
    }

    function add() {
      if ($this->validateAdmin()) {
        if(!empty($this->data)) {
            if($this->Speech->save($this->data)) {
                $this->flash('Nueva charla creada', '', 1);
                $this->redirect(array('action' => '/'));
            }
        }
      }
    }
    
    function index_json() {
      $this->layout = null;
         Configure::write('debug',0);
         
      $month = $this->params['month'];
      $year = $this->params['year'];
      
      $result = $this->Speech->find('all', array(
        'condittions'=>array('date BETWEEN ? AND ?' => array("$year-$month-01", "$year-$month-31"))));
      
      $this->set('result', $this->json->encode($result));
    }

    function edit($id = null) {
      if ($this->validateAdmin()) {
        $this->Speech->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Speech->read();
        } else {
            if ($this->Speech->save($this->data)) {
                $this->flash('La charla ha sido modificada exitosamente.', '/', 1);
                $this->redirect(array('action' => '/'));
            }
        }
      }
    }

    function delete($id) {
      if ($this->validateAdmin()) {
        $this->Speech->del($id);
        $this->flash('The speech with id: '.$id.' has been deleted.', '/speeches/', 0);
        $this->redirect(array('action' => '/'));
      }
    }

	function searchByTags() {
		$this->set('speeches', '');
		if(!empty($this->data)) {
			$dataTags = $this->data['Tag'];
			$allSpeeches = $this->Speech->find('all');
			$i = 0;
			$speeches = array();
			foreach($allSpeeches as $speech){
				$tags = $speech['Tag'];
				foreach ($tags as $tag) {
					foreach ($dataTags as $dataTag) {
						if ($tag['id'] == $dataTag) {
							$isAdded = false;
							foreach ($speeches as $speechTagged) {
								if($speechTagged == $speech['Speech']) {
									$isAdded = true;
								}
							}
							if(!$isAdded) {
								$speeches[$i] = $speech['Speech'];
								$i++;
							}
						}
					}
				}
			}
			$this->set('speeches', $speeches);
		}
	}
}
?>