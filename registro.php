<?php

require_once('conexion.php');

// Obtener los datos enviados por el usuario
$nombre = $_POST['nombre'];
$roll = $_POST['roll'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Verificar si las contraseñas coinciden
if ($password !== $confirm_password) {
	die('Las contraseñas no coinciden');
}

// Verificar si el correo electrónico ya está registrado
$consulta_email = "SELECT id FROM users WHERE email = '$email'";
$resultado_email = mysqli_query($conexion, $consulta_email);
if (mysqli_num_rows($resultado_email) > 0) {
	die('El correo electrónico ya está registrado');
}

// Hash de la contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar el usuario en la base de datos
$consulta_insertar = "INSERT INTO users (username, role, email, password) VALUES ('$nombre', '$roll', '$email', '$password_hash')";
$resultado_insertar = mysqli_query($conexion, $consulta_insertar);

if ($resultado_insertar) {
	echo 'Usuario registrado exitosamente';
} else {
	die('Error al insertar usuario en la base de datos: ' . mysqli_error($conexion));
}

// Cerrar conexión a la base de datos
mysqli_close($conexion);
?>

