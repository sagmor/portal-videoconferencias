<h2><?php __('next_speeches_element')?></h2>
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
																		'controller' => 'speeches',
																		'action' => 'show',
																		$speech['Speech']['id']));?>
				</li>
		<?php
			}
		?>
	</ul>
<?php
	} else {
		echo __('not_next_speeches', true);
	}
?>
