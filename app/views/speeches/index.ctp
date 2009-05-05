<form>

	<h1>Charlas agendadas</h1>
	<table>
		<tr>
			<th>Título</th>
			<th>Fecha</th>
			<!--<th>Categorías</th>-->
		</tr>

		<?php foreach ($speeches as $speech): ?>
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

</form>