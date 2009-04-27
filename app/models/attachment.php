<?php

/**
 * Controlador para los archivos adjuntos de una charla
 *
 * @author Felipe Urbina
 */
class attachment extends AppModel {
    var $name = 'Attachment';
    var $validate = array(
						'name' => VALID_NOT_EMPTY,
						'speech_id' => VALID_NOT_EMPTY,
						'filename' => VALID_NOT_EMPTY,
					);
}
?>
