<div id="menu" style="float:left">
	<ul>
		<li>
		  <?php echo $html->link(__('search_by_tag', true), array(
															'controller' => 'speeches',
															'action' => 'searchByTags')); ?>
		<li>
		  <?php echo $html->link(__('search_by_speaker', true), array(
															'controller' => 'speeches',
															'action' => 'searchBySpeaker')); ?>
		</li>
		<li>
		  <?php echo $html->link(__('search_by_location', true), array(
															'controller' => 'speeches',
															'action' => 'searchByLocation')); ?>
		</li>
		<li>
		  <?php echo $html->link(__('search_by_date', true), array(
															'controller' => 'speeches',
															'action' => 'searchByDate')); ?>
		</li>
	</ul>
</div>
<div id="content">
	<h3>
		<?php
			echo __('message', true);
		?>
	</h3>
</div>