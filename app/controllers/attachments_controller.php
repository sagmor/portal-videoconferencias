<?php
/**
 * Controlador de los archivos adjuntos
 *
 * @author Felipe Urbina
 */
class AttachmentsController extends AppController {

	var $name = 'Attachments';

	function getFiles($idSpeech) {
		$files = $this->Attachment->find(
										'all', array(
												'conditions' => array(
																'Attachment.speech_id' => $idSpeech)));
		return $files;
	}
	function download($id) {
		$file = $this->Attachment->findById($id);

		$filePath = $file['Attachment']['location'].'/'.$file['Attachment']['filename'];

		$this->layout=null;
		$this->set('file',$filePath);
		// $this->redirect(array('controller' => '',));
		#return WWW_ROOT.$filePath;

		#exit();
	}

	function delete($id, $speech_id) {
		if ($this->validateAdmin()) {
			$attachment = $this->Attachment->find('all', array('conditions' => array('id'  => $id)));
			unlink(WWW_ROOT.$attachment[0]['Attachment']['location'].'/'.$attachment[0]['Attachment']['filename']);
			$this->Attachment->del($id);
			$this->redirect(array('controller' => 'speeches','action' => 'show', $speech_id));
		}
	}

	function upload($speech_id, $folder, $speech_title) {
		$folder = $folder.'/'.$speech_title;
		$folder_url = WWW_ROOT.$folder;

		//reemplazo los espacios por _ en caso de ser necesario.
		$folder_url = str_replace(' ', '_', $folder_url);
		$rel_url = str_replace(' ', '_', $folder);

		if(!is_dir($folder_url)) {
			mkdir($folder_url);
			//en unix, permisos.
			chmod($folder_url, 0757);
		}

		$file = $this->data['Attachment']['File'];
		$filename = str_replace(' ', '_', $file['name']);
		switch($file['error']) {

			case 0:
				// verifica si ya está el archivo
				if(!file_exists($folder_url.'/'.$filename)) {
					// crea el nombre completo del archivo
					$full_url = $folder_url.'/'.$filename;
					$url = $rel_url.'/'.$filename;
					// sube el archivo
					$success = move_uploaded_file($file['tmp_name'], $full_url);
					// despues de mover, cambiar permisos del file a 0757.
				} else {
					// crea un único nombre de archivo y lo sube
					ini_set('date.timezone', 'Europe/London');
					$now = date('Y-m-d-His');
					$full_url = $folder_url.DS.$now.$filename;
					$url = $rel_url.'/'.$now.$filename;
					$success = move_uploaded_file($file['tmp_name'], $url);
				}
				// si se subió correctamente
				if($success) {
					// guarda la url del archivo
					$result['urls'][] = $url;
				} else {
					$result['errors'][] = "Error uploaded $filename. Please try again.";
				}
				break;
			case 3:
				// un error ha ocurrido
				$result['errors'][] = "Error uploading $filename. Please try again.";
				break;
			default:
				// un error ha ocurrido
				$result['errors'][] = "System error uploading $filename. Contact webmaster.";
				break;
		}
		$this->data['Attachment']['filename'] = str_replace(' ', '_', $this->data['Attachment']['File']['name']);
		$this->data['Attachment']['type'] = $this->data['Attachment']['File']['type'];
		$this->data['Attachment']['size'] = $this->data['Attachment']['File']['size'];
		$this->data['Attachment']['speech_id'] = $speech_id;
		$this->data['Attachment']['location'] = $rel_url;
		$this->Attachment->save($this->data);

		$this->redirect('/speeches/show/'.$speech_id);
	}
}
?>
