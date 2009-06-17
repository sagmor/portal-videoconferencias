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

	//función que muestra ek contenigo de una conferencia
	function show($id = null) {
		$this->Speech->id = $id;
		$this->set('speech', $this->Speech->read());
	}

	//función para agregar una conferencia
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
		$date = mktime(12, 0, 0, $month, 1, $year);
		$next = $date - mktime(0,0,0,0,0,0) + mktime(0,0,0,0,31,0); #mktime(12, 0, 0, $month+1%12, 0, $year);
		$prev = $date + mktime(0,0,0,0,0,0) - mktime(0,0,0,0,31,0);
		$first = date('m-d-Y',$prev);
		$last = date('m-d-Y',$next);
		$result = $this->Speech->find('all', array(
							'conditions'=>array('date BETWEEN ? AND ?' => array($first, $last))));
		foreach ($result as $i => $data) {
			$result[$i]['Speech']['url'] = Router::url(array('action'=>'show','id'=>$result[$i]['Speech']['id']));
		}
		$this->set('result', $this->json->encode($result));
	}

	//función para editar una conferencia
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

	//función para eliminar una conferencia
	function delete($id) {
		if ($this->validateAdmin()) {
			$this->Speech->del($id);
			$this->flash('La conferencia ha sido eliminada.', '/speeches/', 0);
			$this->redirect(array('action' => '/'));
		}
	}

	//función que muestra las conferencias en el index
	function index() {
		$this->set('data',  $this->paginate('Speech'));
	}

	function search() {
	}

	//función que recupera las categorías de una conferencia
	function getTagsBySpeechId($speechId) {
		$tags = $this->Speech->find('all', array(
											'conditions' => array(
																'Speech.id' => $speechId)));
		return $tags[0]['Tag'];
	}

	//función que entrega todos los lugares donde se realizan charlas
	function getLocations() {
		$speeches = $this->Speech->find('all');
		$arrLocations = array();
		foreach($speeches as $speech){
			$arrLocations[$speech['Speech']['location']] = $speech['Speech']['location'];
		}
		return $arrLocations;
	}

	//función que busca todas las conferencias asociadas a uno o más oradores
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

	//función que busca todas las conferencias asociadas a una fecha
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
																							"$month-01-$year",
																							"$month-31-$year"))));
		}
	}

	//función que busca todas las conferencias asociadas a un lugar
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
			if(isset($this->passedArgs[$i]) && $this->passedArgs[$i] != '')
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

	//función que entrega las próximas 5 charlas, para cambiar esto sólo es necesario cambiar el valor de 'limit'
	function nextSpeeches() {
		$currentTime = date('m-d-Y');
		$nextSpeeches = $this->Speech->find('all', array(
											'conditions' => array(
																'Speech.date >=' => $currentTime),
																'limit' => 5,
																'order' => 'Speech.date'));
		return $nextSpeeches;
	}

	//función que retorna la fecha de la última conferencia agendada
	function getDateLastSpeech() {
		$lastSpeech = $this->Speech->find('first', array('order' => array('Speech.date' => 'desc')));
		$dateLastSpeech = $lastSpeech['Speech']['date'];
		return $dateLastSpeech;
	}

	//función que retorna la fecha de la última conferencia agendada
	function getDateFirstSpeech() {
		$firstSpeech = $this->Speech->find('first', array('order' => array('Speech.date' => 'asc')));
		$dateFirstSpeech = $firstSpeech['Speech']['date'];
		return $dateFirstSpeech;
	}

	//función para filtrar las charlas en el calendario
	//FIXME: aqui hay que decidir si darle los parametros como argumento o los sacamos de $this->data
	function filterCalendar() {
		return $this->Speech->find('all', array(
												'conditions' => array(
																	'Speech.speakers LIKE' => '%'.$speaker.'%',
																	'Tag.name' => $tag,
																	'Speech.location' => $location)));
	}
}
?>