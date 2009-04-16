<?php
class Speech extends AppModel {
	var $name = 'Speech';
	var $validate = array(
						'title' => VALID_NOT_EMPTY,
						'speakers' => VALID_NOT_EMPTY,
						'description' => VALID_NOT_EMPTY,
						'location' => VALID_NOT_EMPTY,
						'date' => VALID_NOT_EMPTY,
					);
}
?>