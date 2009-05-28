<form>

	<h1>Charlas agendadas</h1>
	<?php
		if ($this->params['url']['actualPage'] != 0) {
			echo $html->link('← Charlas anteriores',
								'/?actualPage='.($this->params['url']['actualPage'] - 1),
								array('class' => 'prev'));
		}
		if ($this->params['url']['actualPage'] + 1 < count($tableSpeeches)) {
			echo $html->link('Charlas siguientes →',
								'/?actualPage='.($this->params['url']['actualPage'] + 1),
								array('class' => 'next'));
		}
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
			foreach ($tableSpeeches[$this->params['url']['actualPage']] as $speech): ?>
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

</form>