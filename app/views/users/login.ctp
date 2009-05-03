<h2><b class="text1">Login</b></h2>
<?php echo $form->create('User', array('url' =>
											    array('controller' => 'users', 'action' => 'login')));?>
<?php
	echo $form->input('User.name', array( 'label' => 'Usuario: '));
	echo $form->input('User.password', array( 'label' => 'Contraseña: ')); ?>
<?php echo $form->end('Ingreso'); echo $html->link("Registro", "/register")?>
