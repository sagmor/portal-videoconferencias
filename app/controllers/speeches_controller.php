<?php
class SpeechesController extends AppController {
    var $helpers = array('Html', 'Javascript', 'Form', 'Paginator');
    var $name = 'Speeches';
	var $scaffold;
	var $paginate = array('limit' => 10, 
						'order' => array('Speech.date' => 'asc'),
						'fields' => array('Speech.id',
										'Speech.date',
										'Speech.title',
										'Speech.location',
										'Speech.speakers',
										));
    
    var $components = array('RequestHandler','json');

	var $uses = array('Speech', 'SpeechesTags');
	var $speakerSearched;

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

	function index() {
		$this->set('data',  $this->paginate('Speech'));
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

	function searchBySpeaker() {
		$this->set('isSearch', false);
		$speaker = $this->data['Speech']['speaker'];
		if(isset($this->passedArgs['speaker'])) {
			$speaker = $this->passedArgs['speaker'];
		}
		if (!empty($speaker)) {
			$this->set('isSearch', true);
			$this->set('data',  $this->paginate('Speech', array('Speech.speakers LIKE' => '%'.$speaker.'%')));
		}
	}

	function searchByDate() {
		$this->set('isSearch', false);
		$year = $this->data['Speech']['date']['year'];
		$month = $this->data['Speech']['date']['month'];
		if(isset($this->passedArgs['year'])) {
			$year = $this->passedArgs['year'];
			$month = $this->passedArgs['month'];
		}
		if (!empty($year)) {
			$this->set('isSearch', true);
			$this->set('data',  $this->paginate('Speech', array('Speech.date BETWEEN ? AND ?' => array(
																							"$year-$month-01",
																							"$year-$month-31"))));
		}
	}

	function searchByLocation() {
		$this->set('isSearch', false);
		$locations = $this->data['Speech']['locations'];
		if(isset($this->passedArgs) && $this->passedArgs != array()) {
			$locations = $this->passedArgs;
		}
		if (!empty($locations)) {
			$this->set('isSearch', true);
			$this->set('data',  $this->paginate('Speech', array('Speech.location' => $locations)));
		}

	}
//FIXME: muy mala implementación de la consulta, hecha así para aprovechar el paginamiento de cake
	function searchByTags() {
		$dataTags = '';
		$speechesIds = '';
		$this->set('isSearch', false);
		if(isset($this->data['Tag']) && !empty($this->data['Tag'])){
			$dataTags = $this->data['Tag']['Tag'];
		}
		if(isset($this->passedArgs) && $this->passedArgs != array()) {
			for($i = 0; $i < count($this->passedArgs); $i++)
				if($this->passedArgs[$i] != '')
					$dataTags[$i] = $this->passedArgs[$i];
		}
		if ($dataTags != '') {
			$this->set('isSearch', true);
			$allSpeeches = $this->Speech->find('all', array('order' => 'Speech.date'));
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
								$speechesIds[$i] = $speech['Speech']['id'];
								$i++;
							}
						}
					}
				}
			}
			$this->set('data',  $this->paginate('Speech', array('Speech.id' => $speechesIds)));
		}
	}

	function nextSpeeches() {
		$currentTime = date('Y-m-d-His');
		$nextSpeeches = $this->Speech->find('all', array(
											'conditions' => array(
																'Speech.date >=' => $currentTime),
																'limit' => 5,
																'order' => 'Speech.date'));
		return $nextSpeeches;
	}
}
?>