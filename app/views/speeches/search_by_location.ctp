<h1>Búsqueda de Charlas por lugar</h1>

<?php
	echo $form->create('Speech', array('action' => 'searchByLocation'));

	$locations = $this->requestAction(array('controller' => 'speeches',
											'action' => 'getLocations'));
	echo $form->input('Location', array('label' => '',
									   'multiple' => 'checkbox',
									   'options' => $locations));

	echo $form->submit('Buscar');

?>

<?php
	if($speeches != array()):
?>
	<table>
		<tr>
			<th>Título</th>
			<th>Fecha</th>
		</tr>
		<?php
			foreach ($speeches as $speech): ?>
				<tr>
					<td>
					<?php echo $html->link($speech['title'],
											"/speeches/show/".$speech['id']); ?>
					</td>
					<td><?php echo $speech['date']; ?></td>
					<!-- Sólo el administrador puede borrar o editar una charla -->
					<?php if($this->requestAction('/users/getCurrentUserType') == 'admin'):?>
						<td>
							<?php echo $html->link('Editar', array('action'=>'edit', 'id'=>$speech['id']));?>
						</td>
						<td>
							<?php echo $html->link('Borrar', array('action'=>'delete',
																	'id'=>$speech['id']), null, '¿Está seguro?')?>
						</td>
					<?php endif?>
				</tr>
		<?php endforeach; ?>
	</table>
<?php
	else :
		echo 'No hay charlas agendadas en este lugar';
endif ?>

<?php
	$form->end();
?>