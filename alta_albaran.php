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
	<title>Introducir un albaran</title>
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
    <div class="container">
        <div class="form-container">
            <h2>Introducir un albarán</h2>
            <form method="post">
                <div class="form-group form-row">
                    <label class="col-sm-3" for="pedido">Pedido:</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="pedido" name="pedido">
                            <option value="">Selecciona un pedido</option>
                            <?php
                        
                                // Consulta para obtener los pedidos
                                $consulta_pedidos = "SELECT id, n_pedido FROM pedidos WHERE id NOT IN (SELECT id_pedido FROM albaranes)";
                                $resultado_pedidos = mysqli_query($conexion, $consulta_pedidos);
                        
                                // Iteración a través de los resultados y creación de las opciones para el menú desplegable
                                while($fila_pedido = mysqli_fetch_assoc($resultado_pedidos)){
                                    echo '<option value="'.$fila_pedido['id'].'">'.$fila_pedido['n_pedido'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
				<div class="form-group form-row">
                    <label class="col-sm-3" for="nombre">Nombre del cliente:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                </div>
				<div class="form-group form-row">
                    <label class="col-sm-3" for="telefono">Telefono del cliente:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="direccion">Dirección de entrega:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="pendiente">Liquidación pendiente:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="pendiente" name="pendiente" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="fecha">Fecha de entrega prevista:</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="fecha" name="fecha">
                    </div>
                </div>
                <div class="centrar">
                    <button type="submit" class="btn btn-primary" name="submit">Introducir Albarán</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php
      if(isset($_POST['submit'])){
        $direccion = $_POST['direccion'];
        $fecha = $_POST['fecha'];
        $pedido = $_POST['pedido'];
        $liquidacion = $_POST['pendiente'];
		$nombre = $_POST['nombre'];
		$telefono = $_POST['telefono'];
    
        $consulta = "INSERT INTO albaranes (id_pedido, fecha_entrega_prevista, liquidacion_pendiente,direccion_entrega,telefono,nombre_cliente) VALUES ('$pedido', '$fecha', '$liquidacion','$direccion', '$telefono', '$nombre')";
    
        if(mysqli_query($conexion, $consulta)){
          echo '<div class="alert alert-success">Albarán guardado correctamente</div>';
        }else{
          echo '<div class="alert alert-danger">Error al guardar el albarán</div>';
        }
    
        mysqli_close($conexion);
      }
    ?>

    <script src="menu.js"></script>

</body>
</html>