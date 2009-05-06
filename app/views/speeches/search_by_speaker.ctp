<h1>Búsqueda de Charlas por orador</h1>
<?php
	echo $form->create('Speech', array('action' => 'searchBySpeaker'));

	echo $form->input('Speaker', array('label' => 'Ingrese el nombre del orador'));

	echo $form->submit('Buscar');

?>

<?php
	if($speeches != array() && $speeches != ''):
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
					<?php echo $html->link($speech['Speech']['title'],
											"/speeches/show/".$speech['Speech']['id']); ?>
					</td>
					<td><?php echo $speech['Speech']['date']; ?></td>
					<!-- Sólo el administrador puede borrar o editar una charla -->
					<?php if($this->requestAction('/users/getCurrentUserType') == 'admin'):?>
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
		echo 'No se encuentra registrado este orador';
endif ?>

<?php
	$form->end();
?>