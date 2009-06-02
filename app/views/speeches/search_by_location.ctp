<h1>Búsqueda de Charlas por lugar</h1>

<?php
	echo $form->create('Speech', array('action' => 'searchByLocation'));

	$locations = $this->requestAction(array('controller' => 'speeches',
											'action' => 'getLocations'));
	echo $form->input('locations', array('label' => '',
									   'multiple' => 'checkbox',
									   'options' => $locations));
	if(isset($this->params['pass']) && $this->params['pass'] != array()) {
		$this->data['Speech']['locations'] = $this->params['pass'];
	}

	echo $form->submit('Buscar');

?>

<div id="resultSearch">
<p><?php  
	echo $paginator->counter(array('format' => 'Pagina %page% de %pages%,  mostrando %current% conferencias de %count%'));
	$paginator->options(array('url'=>$this->data['Speech']['locations']));
	?>
</p>
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
		echo  $paginator->prev('← Charlas anteriores', null, null,  array('class'=>'disabled'));?>
	|
	<?php echo  $paginator->next('Charlas siguientes →', null, null,  array('class'=>'disabled'));?>
</div>
<?php if($current_user['User']['type'] == 'admin') { ?>
<div  class="actions">
	<ul>
		<li>
			<?php echo  $html->link('Agregar Charla', array('action' => 'add')); ?>
		</li>
	</ul>
</div>
<?php } ?>
<?php
	$form->end();
?>