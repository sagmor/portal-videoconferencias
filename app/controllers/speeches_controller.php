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
        'conditions'=>array('date BETWEEN ? AND ?' => array("$year-$month-01", "$year-$month-31"))));
        
      foreach ($result as $i => $data) {
       $result[$i]['Speech']['url'] = Router::url(array('action'=>'show','id'=>$result[$i]['Speech']['id']));
      }
      $this->set('result', $this->json->encode($result));
    }

    function edit($id = null) {
      if ($this->validateAdmin()) {
        $this->Speech->id = $id;
        if (empty($this->data)) {
				$this->data = $this->Speech->read();
        } else {
			if(!empty($this->data['Tag'])){
				if ($this->Speech->save($this->data)) {
					$this->flash('La charla ha sido modificada exitosamente.', '/', 1);
					$this->redirect(array('action' => '/'));
				}
			} else {
				$this->flash('Requiere tener al menos una categoría', '', 10);
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

	function searchBySpeaker() {
		$this->set('speeches', '');
		if(!empty($this->data)) {
			if(!empty($this->data['Speech']['Speaker'])) {
				$speaker = $this->data['Speech']['Speaker'];
				$speeches = $this->Speech->find('all', array(
													'conditions' => 'Speech.speakers LIKE \'%'.$speaker.'%\''));
				$this->set('speeches', $speeches);
			}
		}
	}

	function search() {

	}

	function getTagsBySpeechId($speechId) {
		$tags = $this->Speech->find('all', array(
											'conditions' => array(
																'Speech.id' => $speechId)));
		return $tags[0]['Tag'];
	}

	function getLocations() {
		$speeches = $this->Speech->find('all');
		$arrLocations = array();
		foreach($speeches as $speech){
			$arrLocations[$speech['Speech']['location']] = $speech['Speech']['location'];
		}
		return $arrLocations;
	}

	function searchByLocation() {
		$this->set('speeches', '');
		if(!empty($this->data)) {
			#debug($this->data);
			if(!empty($this->data['Speech']['Location'])) {
				$dataLocations = $this->data['Speech']['Location'];
				#debug($dataLocations);
				$allSpeeches = $this->Speech->find('all');
				$i = 0;
				$speeches = array();
				foreach($allSpeeches as $speech){
					$location = $speech['Speech']['location'];
					#debug($location);
					foreach ($dataLocations as $dataLocation) {
						if ($location == $dataLocation) {
							$isAdded = false;
							foreach ($speeches as $speechSelected) {
								if($speechSelected == $speech['Speech']) {
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
				$this->set('speeches', $speeches);
			}
		}
	}

	function searchByTags() {
		$this->set('speeches', '');
		if(!empty($this->data)) {
			if(!empty($this->data['Tag'])){
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

	function searchByDate() {
		#debug($this->data);
		$year = $this->data['Speech']['date']['year'];
		$month = $this->data['Speech']['date']['month'];
		$result = $this->Speech->find('all', array(
												'conditions'=>array(
															'date BETWEEN ? AND ?' => array(
																						"$year-$month-01",
																						"$year-$month-31"))));
		#debug($result);
		$this->set('speeches', $result);
	}
	
}
?>