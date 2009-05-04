<?php echo $form->create('Tag', array('url' =>
									   array('controller' => 'users', 'action' => 'index')));
?>
<h2><b class="text1">Bienvenido</b></h2>
<table>

<?php

		echo $html->tableCells(array($html->link('Editar Datos Personales', array('action'=>'edit'))));?>
<?php 
	if($this->requestAction('/users/getCurrentUserType') == 'admin'){
		echo $html->tableCells(array($html->link('Administrar categorias',
										   array('controller' => 'tags', 'action' => 'administrar'))));
		echo $html->tableCells(array($html->link('Crear usuario', 
										   array('action' => 'register'))));
	}
?>
</table>