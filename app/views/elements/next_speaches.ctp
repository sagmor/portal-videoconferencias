<h2><strong>Próximas</strong> Conferencias</h2>
<?php
	$speeches = $this->requestAction(array('controller' => 'Speeches',
										'action' => 'nextSpeeches'));
	if (!empty($speeches)) {
?>
	<ul>
		<?php
			foreach($speeches as $speech) {
		?>
				<li><?php echo  $html->link($speech['Speech']['title'], array(
																		'action' => 'show',
																		$speech['Speech']['id']));?>
				</li>
		<?php
			}
		?>
	</ul>
<?php
	} else {
		echo 'No hay charlas agendadas próximas a venir';
	}
?>
