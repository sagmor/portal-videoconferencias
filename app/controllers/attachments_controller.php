<?php
/**
 * Controlador de los archivos adjuntos
 *
 * @author Felipe Urbina
 */
class AttachmentsController extends AppController {

	var $name = 'Attachments';

	function getAttachmentFiles($speech_id) {
		return $this->Attachment->find('all',
										array(
											'fields' => 'Attachment.*',
											'conditions' => array(
																'Attachment.speech_id' => $speech_id)));
	}

	function add() {
	  if ($this->validateAdmin()) {
        if (!empty($this->params['form']) &&
             is_uploaded_file($this->params['form']['Attachment']['tmp_name']))
        {
            $fileData = fread(fopen($this->params['form']['Attachment']['tmp_name'], "r"),
                                     $this->params['form']['Attachment']['size']);
            $this->params['form']['Attachment']['data'] = $fileData;

            $this->File->save($this->params['form']['Attachment']);

            $this->redirect('speeches/view_speech');
        }
      }
    }

}
?>
