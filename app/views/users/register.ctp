<h2><b class="text1">Registro</b></h2>
<?php echo $form->create('User', array('url' =>
											  array('controller' => 'users', 'action' => 'register')));?>
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
	<h3>Tags</h3>
	<?php $tags = $this->requestAction('/tags/getTags');
		  $i = 0;
	      foreach($tags as $tag) {
		  	echo $form->input('User.tag[]', array('type' => 'checkbox',
		  													'label' => $tag['Tag']['name'],
		  													'value' => $tag['Tag']['id']));
	      }
	?>
<?php echo $form->end('Registrar');?>

