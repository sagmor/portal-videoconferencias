<h2><b class="text1">Cambiar contraseña</b></h2>
<?php echo $form->create('User', array('url' =>
									   array('controller' => 'users', 'action' => 'changePass')));?>
	<?php
   	 	echo $form->input('User.0.password', array( 'label' => 'Nueva contraseña: '));
    	echo $form->input('User.1.password', array( 'label' => 'Confirmar nueva contraseña: '));
	?>
<?php echo $form->end('Cambiar contraseña');?>
