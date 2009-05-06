<form method="post" action="<?php echo $html->url('/speeches/searchByTags')?>">
	<h1>Búsqueda de Charlas por categoría</h1>
	<h3>Seleccione la o las categorías por las que desea realizar la búsqueda</h3>
	<?php
		$tags = $this->requestAction('/tags/getTags');
		echo $form->input('Tag', array('label' => '',
									   'multiple' => 'checkbox',
									   'options' => $tags));

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
				debug($speeches);
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
			echo 'No se encuentran charlas asociadas a esta categoría';
	endif ?>
</form>

