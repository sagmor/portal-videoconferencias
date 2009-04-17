<h2><b class="text1">Registro</b></h2>
<!--<form action="/portal-videoconferencias/users/register" method="post">
	<label>Nombre:</label>
		<input name="username" size="40" /><br />
	<label>Correo Electrónico:</label>
		<input name="email" size="40" maxlength="255" /><br />
	<label>Contraseña:</label>
		<input type="password" name="password" size="40"/><br />
	<label>Confirmar contraseña:</label>
		<input type="password" name="confirmed_password" size="40"/><br />
	<label>Idioma:</label>
		<select name="lang">
  			<option value="Español">Español</option>
  			<option value="English">English</option>
		</select><br />
	<input type="submit" value="register" />
</form>-->
<?php echo $form->create('User', array('url' =>
											  array('controller' => 'users', 'action' => 'register')));?>
<table border="0">
	<tr>
	<td>
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
	</td>
	<td>
		<?php echo $form->checkbox('User.0.tag', array('type' => 'checkbox',
													   'options' => array('Tag0 ' => 'Tag0 ',
																		  'Tag1' => 'Tag1')));?>
	</td>
	</tr>
</table>
<?php echo $form->end('Registrar');?>

