<h2>Charlas agendadas</h2>
<p><?php  echo $paginator->counter(array('format' => 'Pagina %page% de %pages%,  mostrando %current% conferencias de %count%')); ?></p>
<div id="table">
<table  class="scaffold" cellpadding="2"  cellspacing="0">
<thead>
	<tr>
		<th><?php echo  $paginator->sort('Titulo','title'); ?></th>
		<th><?php echo  $paginator->sort('Fecha','date'); ?></th>
		<th><?php echo  $paginator->sort('Oradores','speakers'); ?></th>
		<th><?php echo  $paginator->sort('Lugar','location'); ?></th>
		<?php if($current_user['User']['type'] == 'admin'){?>
			<th>Acciones</th>
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
			<?php echo  $html->link('Editar', array('action' => 'edit', $id));?>
			<?php echo  $html->link('Borrar', array('action' => 'delete', $id),null,
				sprintf("¿Está  seguro que quiere borrar '%s'?", $title));?>
		<?php } ?>
	</td>
	<?php }
	} ?>
</tbody>
</table>
</div>
<div  class="paging">
	<?php 
	$paginator->options(array('url'=>$this->passedArgs));
	echo  $paginator->prev('← Charlas anteriores', null, null,  array('class'=>'disabled'));?>
	|
	<?php echo  $paginator->next('Charlas siguientes →', null, null,  array('class'=>'disabled'));?>
</div>
<div  class="actions">
	<ul>
		<?php if($current_user['User']['type'] == 'admin') { ?>
			<li>
				<?php echo  $html->link('Agregar Charla', array('action' => 'add')); ?>
			</li>
		<?php }?>
	</ul>
</div>