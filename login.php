<?php
session_start();

// Si el usuario ya ha iniciado sesión, redirigirlo a la página principal
if (isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit;
}
require_once('conexion.php');

// Si se ha enviado un formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Conectar a la base de datos

	// Obtener los datos enviados por el usuario
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Consultar si el usuario existe en la base de datos
	$query = "SELECT id, email, password, id_cliente, role FROM users WHERE email = '$email'";
	$result = mysqli_query($conexion, $query);
	$user = mysqli_fetch_assoc($result);

	// Verificar la contraseña
	if (password_verify($password, $user['password'])) {
	  // Iniciar sesión con los datos del usuario
	  session_start();
	  $_SESSION['user_id'] = $user['id'];
	  $_SESSION['user_email'] = $user['email'];
	  $_SESSION['user_role'] = $user['role'];
	  $_SESSION['cliente_id'] = $user['id_cliente'];
	  header('Location: index.php');
	  exit;
	} else {
	  $error = "Usuario o contraseña incorrectos";
	}
}

// Mostrar el formulario de inicio de sesión
?>

<!DOCTYPE html>
<html>
<head>
  <title>Iniciar sesión</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include('nav.php'); ?>
  
  <div class="container">
    <h1>Iniciar sesión</h1>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Iniciar sesión</button>
    </form>
  </div>

</body>
</html>
