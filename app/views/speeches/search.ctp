<div id="menu" style="float:left">
	<ul>
		<li>
		  <?php echo $html->link('Buscar por categoría', array(
															'controller' => 'speeches',
															'action' => 'searchByTags')); ?>
		<li>
		  <?php echo $html->link('Buscar por orador', array(
															'controller' => 'speeches',
															'action' => 'searchBySpeaker')); ?>
		</li>
		<li>
		  <?php echo $html->link('Buscar por lugar', array(
															'controller' => 'speeches',
															'action' => 'searchByLocation')); ?>
		</li>
		<li>
		  <?php echo $html->link('Buscar por fecha', array(
															'controller' => 'speeches',
															'action' => 'searchByDate')); ?>
		</li>
	</ul>
</div>
<div id="content">
	<h3>
		<?php
			echo 'Seleccione un criterio de búsqueda en el menú superior';
		?>
	</h3>
</div>