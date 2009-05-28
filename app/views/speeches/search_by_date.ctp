<h1>Búsqueda de Charlas por mes y año</h1>

<?php
	echo $form->create('Speech', array('action' => 'searchByDate'));

	echo $form->input('date', array(
								'label' => 'Fecha (mes - año)',
								'size' => '1',
								'type' => 'date',
								'dateFormat' => 'MY',
								'selected' => array('year'=>'2009'),
								));
	echo $form->submit('Buscar');
?>

<?php 
	if($speeches != array()):
?>
	<table class="sortable">
		<thead>
			<tr>
				<th>Título</th>
				<th>Fecha</th>
				<th>Lugar</th>
				<th>Presentadores</th>
			</tr>
		</thead>
		<?php
			foreach ($speeches as $speech):
				#debug($speech);
		?>
				<tr>
					<td>
					<?php echo $html->link($speech['Speech']['title'],
											"/speeches/show/".$speech['Speech']['id']); ?>
					</td>
					<td><?php echo $speech['Speech']['date']; ?></td>
					<td><?php echo $speech['Speech']['location']; ?></td>
					<td><?php echo $speech['Speech']['speakers']; ?></td>
					<!-- Sólo el administrador puede borrar o editar una charla -->
					<?php if($current_user['User']['type'] == 'admin'):?>
						<td>
							<?php echo $html->link('Editar', array('action'=>'edit', 'id'=>$speech['Speech']['id']));?>
						</td>
						<td>
							<?php echo $html->link('Borrar', array('action'=>'delete',
																	'id'=>$speech['Speech']['id']), null, '¿Está seguro?')?>
						</td>
					<?php endif?>
				</tr>
		<?php endforeach; ?>
	</table>
<?php
	else :
		echo 'No hay charlas agendadas para este mes';
endif ?>

<?php
	$form->end();
?>