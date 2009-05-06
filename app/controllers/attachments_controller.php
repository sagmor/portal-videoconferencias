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

		$filePath = $file['Attachment']['location'].DS.$file['Attachment']['filename'];
		
		debug(WWW_ROOT.$filePath);
		$this->layout=null;
		$this->set('file',$filePath);
		// $this->redirect(array('controller' => '',));
		#return WWW_ROOT.$filePath;
		
		#exit();
	}

	function delete($attachment) {
		
	}

	function upload($speech_id, $folder, $speech_title) {
//		debug($this->data);
//		debug($folder);
//		debug($speech_title);
		$folder = $folder.DS.$speech_title;
		$folder_url = WWW_ROOT.$folder;

		//reemplazo los espacios por _ en caso de ser necesario.
		$folder_url = str_replace(' ', '_', $folder_url);
		$rel_url = str_replace(' ', '_', $folder);

//		debug($folder_url);
		if(!is_dir($folder_url)) {
			mkdir($folder_url);
		}

		$file = $this->data['Attachment']['File'];
//		debug($file);
		$filename = str_replace(' ', '_', $file['name']);
//		debug($filename);
		switch($file['error']) {

			case 0:
			// check filename already exists
				if(!file_exists($folder_url.DS.$filename)) {
					// create full filename
					$full_url = $folder_url.DS.$filename;
					$url = $rel_url.DS.$filename;
					debug($url);
					// upload the file
					$success = move_uploaded_file($file['tmp_name'], $url);
				} else {
					// create unique filename and upload file
					ini_set('date.timezone', 'Europe/London');
					$now = date('Y-m-d-His');
					$full_url = $folder_url.DS.$now.$filename;
					$url = $rel_url.DS.$now.$filename;
					$success = move_uploaded_file($file['tmp_name'], $url);
				}
				// if upload was successful
				if($success) {
					// save the url of the file
					$result['urls'][] = $url;
				} else {
					$result['errors'][] = "Error uploaded $filename. Please try again.";
				}
				break;
			case 3:
				// an error occured
				$result['errors'][] = "Error uploading $filename. Please try again.";
				break;
			default:
				// an error occured
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
