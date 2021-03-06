<h1><?php__ ('title_search_by_speaker') ?></h1>
<?php
	echo $form->create('Speech', array('action' => 'searchBySpeaker'));
	echo $form->input('speaker', array('label' => __('search_message_speaker', true)));
	if(isset($this->params['named']['speaker'])) {
		$this->data['Speech']['speaker'] = $this->params['named']['speaker'];
	}
	echo $form->submit(__('search', true));

?>
<?php if ($isSearch) {
		if(empty($data)) {
			echo __('not_founded_by_speaker', true);
		} else {?>
<div id="resultSearch">
<p>
	<?php
		echo $paginator->counter(array('format' =>
										__('table_page', true).' %page% '.
										__('of', true).' %pages%, '.
										__('showing', true).' %current% '.
										__('of', true).' %count%'.' '.
										__('speeches', true)));
		$paginator->options(array('url'=>$this->data['Speech']));
	?>
</p>
<div  class="paging">
	<?php
		echo  $paginator->prev(__('prev_speeches', true) , null, null,  array('class'=>'disabled'));
	?>
	|
	<?php echo  $paginator->next(__('next_speeches', true), null, null,  array('class'=>'disabled'));?>
</div>
<table  class="scaffold" cellpadding="7"  cellspacing="0">
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
		<?php echo  $html->link($time->format('d-m-y H:i', $date), array('action' => 'show', $id));?>
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
<?php
	}
}?>
<?php
	echo $form->end();
?>