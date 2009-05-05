<?php
/**
 * Controlador de los archivos adjuntos
 *
 * @author Felipe Urbina
 */
class AttachmentsController extends AppController {

	var $name = 'Attachments';

	function download($id) {
		Configure::write('debug', 0);
		$file = $this->Attachment->findById($id);

		header('Content-type: ' . $file['Attachment']['type']);
		header('Content-length: ' . $file['Attachment']['size']); // some people reported problems with this line (see the comments), commenting out this line helped in those cases
		header('Content-Disposition: attachment; filename="'.$file['Attachment']['name'].'"');
		echo $file['Attachment']['data'];

		exit();
	}

	function upload($speech_id, $speech_location) {
	  if ($this->validateAdmin()) {
		  if (!empty($this->data) && is_uploaded_file($this->data['Attachment']['File']['tmp_name'])) {
			  $fileData = fread(fopen($this->data['Speech']['File']['tmp_name'], "r"),
                                     $this->data['Speech']['File']['size']);

        $this->data['Attachment']['name'] = $this->data['Attachment']['File']['name'];
        $this->data['Attachment']['type'] = $this->data['Attachment']['File']['type'];
        $this->data['Attachment']['size'] = $this->data['Attachment']['File']['size'];
			  $this->data['Attachment']['speech_id'] = $speech_id;
			  $this->data['Attachment']['location'] = $speech_location;
        $this->data['Attachment']['data'] = $fileData;
        $this->Attachment->save($this->data);

        $this->flash('El archivo se ha subido', array('action'=>'show', 'id'=>$speech_id));
      }
    }
	}
}
?>
