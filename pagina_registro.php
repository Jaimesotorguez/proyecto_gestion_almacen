<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Registro de Usuario</title>
</head>
<body>
	<h1>Registro de Usuario</h1>
	<form action="registro.php" method="post">
		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre" required><br><br>
		
		<label for="roll">Roll:</label>
		<input type="text" name="roll" required><br><br>
		
		<label for="email">Correo electrónico:</label>
		<input type="email" name="email" required><br><br>
		
		<label for="password">Contraseña:</label>
		<input type="password" name="password" required><br><br>
		
		<label for="confirm_password">Confirmar contraseña:</label>
		<input type="password" name="confirm_password" required><br><br>
		
		<input type="submit" value="Registrarse">
	</form>
</body>
</html>
