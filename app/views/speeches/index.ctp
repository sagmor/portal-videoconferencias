<h2><?php __('title_index') ?></h2>
<!--información de la página de la tabla actual-->
<p><?php  echo $paginator->counter(array('format' => 
										__('table_page', true).' %page% '.
										__('of', true).' %pages%, '.
										__('showing', true).' %current% '.
										__('speeches', true).' '.
										__('of', true).' %count%'));
//		$lastSpeech = $this->requestAction('/speeches/getDateLastSpeech');
//		$firstSpeech = $this->requestAction('/speeches/getDateFirstSpeech');
//		debug($lastSpeech);
//		debug($firstSpeech);
	?></p>
<div id="table">
<div  class="paging">
	<?php
	$paginator->options(array('url'=>$this->passedArgs));
	echo  $paginator->prev(__('prev_speeches', true) , null, null,  array('class'=>'disabled'));?>
	|
	<?php echo  $paginator->next(__('next_speeches', true), null, null,  array('class'=>'disabled'));?>
</div>

<table  class="scaffold" cellpadding="2"  cellspacing="0">
<thead>
	<tr>
		<th><?php echo  $paginator->sort(__('title', true),'title'); ?></th>
		<th><?php echo  $paginator->sort(__('date', true),'date'); ?></th>
		<th><?php echo  $paginator->sort(__('speakers', true),'speakers'); ?></th>
		<th><?php echo  $paginator->sort(__('location', true),'location'); ?></th>
		<?php if($current_user['User']['type'] == 'admin'){?>
			<th><?php __('actions') ?></th>
		<?php }?>
	</tr>
</thead>
<tbody>
	<!--<?php  print_r($data); ?>-->
<?php
$i = 0;
if(is_array($data)) {
	foreach ($data as $row) {

		$id =  $row['Speech']['id'];
		$title =  $row['Speech']['title'];
		$date =  $row['Speech']['date'];
		$speakers =  $row['Speech']['speakers'];
		$location =  $row['Speech']['location'];

		if($i++ % 2 == 0) {
			echo '<tr>';
		} else {
			echo '<tr  class="altrow">';
		}
		?>
	<td>
		<?php echo  $html->link($title, array('action' => 'show', $id));?>
	</td>
	<td>
		<?php echo  $html->link($date, array('action' => 'show', $id));?>
	</td>
	<td>
		<?php echo  $html->link($speakers, array('action' => 'show', $id));?>
	</td>
	<td>
		<?php echo  $html->link($location, array('action' => 'show', $id));?>
	</td>
	<td>
		<?php if($current_user['User']['type'] == 'admin') { ?>
			<?php echo  $html->link(__('edit', true), array('action' => 'edit', $id));?>
			<?php echo  $html->link(__('delete', true) , array('action' => 'delete', $id),null,
				sprintf(__('are_you_sure_delete', true).' %s?', $title));?>
		<?php } ?>
	</td>
	<?php }
	} ?>
</tbody>
</table>
</div>

<div  class="actions">
	<ul>
		<?php if($current_user['User']['type'] == 'admin') { ?>
			<li>
				<?php echo  $html->link(__('add_speech', true), array('action' => 'add')); ?>
			</li>
		<?php }?>
	</ul>
</div>