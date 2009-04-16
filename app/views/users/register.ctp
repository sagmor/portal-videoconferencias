<form action="/users/register" method="post">
<p>Registro</p>
<label>Nombre:</label>
	<input name="username" size="40" />
<label>Correo Electrónico:</label>
	<input name="email" size="40" maxlength="255" />
<label>Contraseña:</label>
	<input type="password" name="password" size="40"/>
<label>Confirmar contraseña:</label>
	<input type="password" name="confirmed_password" size="40"/>
<label>Idioma:</label>
	<input name="lang" size="40" />
<input type="submit" value="register" />
</form>
