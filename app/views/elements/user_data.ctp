<h2><strong>Usuario</strong></h2>
Saludos: <br />
  <?php echo $current_user['User']['name']; ?>
<ul>
	<li><?php echo $html->link('Editar Datos', array('controller' => 'users', 
                                      'action' => 'edit')); ?></li>
    <?php if($current_user['User']['type'] == 'admin'){ ?>
      <li>
      	<?php echo $html->link('Agregar Charla', array('controller' => 'speeches', 'action' => 'add')); ?>
      </li>
      <li>
      	<?php echo $html->link('Configurar permisos', array('controller' => 'users', 'action' => 'index')); ?>
      </li>
   	  <li>
   	    <?echo $html->link('Configurar categorías', array('controller' => 'tags', 'action' => 'administrar')); ?>
   	  </li>
   	<?php } ?>
	<li><?php echo $html->link('Salir', array('controller' => 'users', 
                                        'action' => 'logout')); ?></li>
</ul>