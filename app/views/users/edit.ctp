<h2><b class="text1">Editar datos personales</b></h2>
<?php echo $form->create('User', array('url' =>
									   array('controller' => 'users', 'action' => 'edit')));?>
	<?php
    	echo $form->input('User.name', array( 'label' => 'Nombre: '));
    	echo $form->input('User.email', array( 'label' => 'Correo electónico: '));
   	 	echo $form->input('User.0.password', array( 'label' => 'Contraseña: '));
    	echo $form->input('User.1.password', array( 'label' => 'Confirmar contraseña: '));
    	echo $form->input('User.lang', 
    					  array ('label' => 'Idioma: ',
    						     'options' => array('Español' => "Español", 
													'English' => 'English')));
	?>
	<?php $tags = $this->requestAction('/tags/getTags');
		  	echo $form->input('Tag', array('label' => 'Susbcripciones',
		  								   'multiple' => 'checkbox',
		  								   'options' => $tags));
	?>
	<?php
		if($this->requestAction('/users/getCurrentUserType') == 'admin'){
			echo $form->input('Privilegios', array('multiple' => 'checkbox',
												   'options' => array(1 => 'Administrador')));
		} 
	?>
<?php echo $form->end('Modificar');?>

