<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
require_once('conexion.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Alta transportista</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="styles.css">
	<!-- CSS de Bootstrap -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-kPRrPbH0RnzvQs4s4+B4VcG0dZaXvq3oYgvcT48TJmgABFWxuV6Ud/i6UuV6Ud/i" crossorigin="anonymous">

	<!-- JavaScript de Bootstrap (requiere jQuery) -->
	<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha384-HaLwdZUCT+vAkbggju3LqWp3TcpJKarlOTI+wnE9GS9iUivZI6jJ6Gwejk6WSPt8" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ZJ1gTskF2fvd70FHac9J/yKc+YpUPVTanJAFM+u8CvNuyLljDjj6JjUWsvX8JsyB" crossorigin="anonymous"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include('nav.php'); ?>
    <script src="menu.js"></script>

	<div class="container">
		<div class="form-container">
			<h2 class="mb-4">Alta transportista</h2>
			<form method="POST" action="">
    			<div class="form-group form-row">
    				<label class="col-sm-3" for="nombre">Nombre</label>
    				<div class="col-sm-9">
    				    <input type="text" name="nombre" id="nombre" class="form-control" required>
    				</div>
    			</div>
    			<div class="centrar">
				    <button type="submit" name="submit" class="btn btn-primary">Registrar transportista</button>
				</div>
			</form>
		</div>
	</div>

	<?php
	if(isset($_POST['submit'])){
	  $nombre = $_POST['nombre'];

	  $consulta = "INSERT INTO transportistas (nombre) VALUES ('$nombre')";

	  if(mysqli_query($conexion, $consulta)){
	    echo '<div class="alert alert-success">Transportista registrado correctamente</div>';
	  }else{
	    echo '<div class="alert alert-danger">Error al registrar el transportista</div>';
	  }

	  mysqli_close($conexion);
	}
	?>
</body>
</html>
