<div class="mainform">
  <h2>Editar datos personales</h2>
  <?php echo $form->create('User', array('url' =>
  									   array('controller' => 'users', 'action' => 'edit')));?>
    <fieldset id="suscriptions" class="">
      <legend>Suscripciones</legend>
      <?php $tags = $this->requestAction('/tags/getTags');
    		  	echo $form->input('Tag', array('label' => 'Subscripciones',
    		  								   'multiple' => 'checkbox',
    		  								   'options' => $tags));
    	?>
    </fieldset>
    
    <p>
      <?php echo $form->input('User.name', array( 'label' => 'Nombre:')); ?>
    </p>
    <p>
      <?php echo $form->input('User.email', array( 'label' => 'Correo electónico:')); ?>
    </p>
    <p>
      <?php echo $form->input('User.password', array( 'label' => 'Contraseña:')); ?>
    </p>
    <p>
      <?php echo $form->input('User.password_confirmation', array( 'label' => 'Confirmar contraseña:', 'type'=>'password')); ?>
    </p>
    <p>
      <?php echo $form->input('User.lang', 
    					  array ('label' => 'Idioma: ',
    						     'options' => array(
    						          'es' => "Español", 
													'en' => 'English'
													))); ?>
    </p>
  <?php echo $form->end('Modificar');?>
</div>


	
	


