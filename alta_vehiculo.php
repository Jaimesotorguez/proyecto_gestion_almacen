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
	<title>Introducir un vehículo</title>
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
            <h2>Introducir un vehículo</h2>
            <form method="post">
                <div class="form-group form-row">
                    <label class="col-sm-3" for="marca">Marca:</label>
    				<div class="col-sm-9">
                        <input type="text" class="form-control" id="marca" name="marca" required>
    				</div>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="modelo">Modelo:</label>
    				<div class="col-sm-9">
                        <input type="text" class="form-control" id="modelo" name="modelo" required>
    				</div>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="matricula">Matricula:</label>
    				<div class="col-sm-9">
                        <input type="text" class="form-control" id="matricula" name="matricula" required>
    				</div>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="color">Color:</label>
    				<div class="col-sm-9">
                        <input type="text" class="form-control" id="color" name="color" required>
    				</div>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="fecha">Fecha próxima itv:</label>
    				<div class="col-sm-9">
                        <input type="date" class="form-control" id="fecha" name="fecha">
    				</div>
                </div>
                <div class="centrar">
                    <button type="submit" class="btn btn-primary" name="submit">Introducir Vehículo</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php
        if(isset($_POST['submit'])){
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $matricula = $_POST['matricula'];
            $color = $_POST['color'];
            $itv = $_POST['fecha'];
    
            $consulta = "INSERT INTO `vehiculos` (`id`, `marca`, `modelo`, `matricula`, `color`, `fecha_proxima_itv`) VALUES (NULL, '$marca', '$modelo', '$matricula', '$color', '$itv')";
    
            if(mysqli_query($conexion, $consulta)){
                echo '<div class="alert alert-success">Vehículo guardado correctamente</div>';
            }else{
                echo '<div class="alert alert-danger">Error al guardar el vehículo</div>';
            }
    
            mysqli_close($conexion);
        }
    ?>

    
</body>
</html>