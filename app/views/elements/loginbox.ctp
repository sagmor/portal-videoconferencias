<h2><b class="text1">Ingreso</b></h2>
  <?php echo $form->create('User', array('url' =>
  											  array('controller' => 'users', 'action' => 'login'),
  											  'id' => 'login'));?>
	<fieldset>
	  <?php
      	echo $form->input('User.email', array('label' => 'Correo electrónico'));
     	 	echo $form->input('User.password', array('label' => 'Contraseña'));
    ?>
	  <input type="submit" value="Ingresar" />
	  <?php echo $html->link('Registrar', array('controller' => 'users', 
	                                      'action' => 'register')); ?>
  </form>