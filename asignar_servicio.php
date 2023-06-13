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
	<title>Asignar precio a un servicio</title>
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
				<h2>Asignar un servicio a un cliente</h2>
				<form method="post">
    			    <div class="form-group form-row">
						<label class="col-sm-3" for="cliente">Cliente:</label>
						<div class="col-sm-9">
    						<select class="form-control" id="cliente" name="cliente">
    							<option value="">Selecciona un cliente</option>
    							<?php
    								
    								// Consulta para obtener los clientes
    								$consulta_clientes = "SELECT id, nombre FROM clientes";
    								$resultado_clientes = mysqli_query($conexion, $consulta_clientes);
    								
    								// Iteración a través de los resultados y creación de las opciones para el menú desplegable
    								while($fila_cliente = mysqli_fetch_assoc($resultado_clientes)){
    									echo '<option value="'.$fila_cliente['id'].'">'.$fila_cliente['nombre'].'</option>';
    								}
    							?>
    						</select>
    					</div>
					</div>
    			    <div class="form-group form-row">
						<label class="col-sm-3" for="servicio">Servicio:</label>
						<div class="col-sm-9">
    						<select class="form-control" id="servicio" name="servicio">
    							<option value="">Selecciona un servicio</option>
    							<?php
    								// Consulta para obtener los servicios
    								$consulta_servicios = "SELECT id, nombre FROM servicios";
    								$resultado_servicios = mysqli_query($conexion, $consulta_servicios);
    								
    								// Iteración a través de los resultados y creación de las opciones para el menú desplegable
    								while($fila_servicio = mysqli_fetch_assoc($resultado_servicios)){
    									echo '<option value="'.$fila_servicio['id'].'">'.$fila_servicio['nombre'].'</option>';
    								}
    							?>
    						</select>
    					</div>
					</div>
					<div class="form-group form-row">
						<label class="col-sm-3" for="precio">Precio:</label>
						<div class="col-sm-9">
						    <input type="number" class="form-control" id="precio" name="precio" step="0.01" min="0" required>
						</div>
					</div>
					<div class="centrar">
					    <button type="submit" class="btn btn-primary" name="submit">Asignar Precio</button>
					</div>
				</form>
		</div>
	</div>
	
	<?php
      if(isset($_POST['submit'])){
        $id_cliente = $_POST['cliente'];
        $id_servicio = $_POST['servicio'];
        $precio = $_POST['precio'];
        
        $consulta = "INSERT INTO clientes_servicios (id_cliente, id_servicio, precio) VALUES ('$id_cliente', '$id_servicio', '$precio')";
        
        if(mysqli_query($conexion, $consulta)){
          echo '<div class="alert alert-success">Registro guardado correctamente</div>';
        }else{
          echo '<div class="alert alert-danger">Error al guardar el registro</div>';
        }
        
        mysqli_close($conexion);
      }
    ?>
    
    
</body>
</html>
