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
	<title>Alta liquidacion</title>
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
            <h2>Alta liquidacion</h2>
            <form method="post">
                <div class="form-group form-row">
                    <label for="id_pedido" class="col-sm-3">Pedido:</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="id_pedido" name="id_pedido">
                            <option value="">Selecciona un pedido</option>
                            <?php
                                // Consulta para obtener los servicios
                                $consulta_servicios = "SELECT id, n_pedido FROM pedidos WHERE id NOT IN (SELECT id_pedido FROM liquidacion)";
                                $resultado_servicios = mysqli_query($conexion, $consulta_servicios);
                                
                                // Iteración a través de los resultados y creación de las opciones para el menú desplegable
                                while($fila_servicio = mysqli_fetch_assoc($resultado_servicios)){
                                    echo '<option value="'.$fila_servicio['id'].'">'.$fila_servicio['n_pedido'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group form-row">
                    <label for="id_metodo" class="col-sm-3">Metodo de pago:</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="id_metodo" name="id_metodo">
                            <option value="">Selecciona un metodo de pago</option>
                            <?php
                                
                                // Consulta para obtener los servicios
                                $consulta_servicios = "SELECT id, metodo FROM metodo_pago";
                                $resultado_servicios = mysqli_query($conexion, $consulta_servicios);
                                
                                // Iteración a través de los resultados y creación de las opciones para el menú desplegable
                                while($fila_servicio = mysqli_fetch_assoc($resultado_servicios)){
                                    echo '<option value="'.$fila_servicio['id'].'">'.$fila_servicio['metodo'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="centrar">
                    <button type="submit" class="btn btn-primary" name="submit">Registrar liquidacion</button>
                </div>
            </form>
        </div>
    </div>
    <?php
        if(isset($_POST['submit'])){
        // Obtener los valores del formulario
        $id_pedido = $_POST['id_pedido'];
        $id_metodo = $_POST['id_metodo'];
        
        $consulta = "INSERT INTO liquidacion (id_pedido, id_pago) VALUES ('$id_pedido', '$id_metodo')";
        // Ejecutar la consulta
        if(mysqli_query($conexion, $consulta)){
            echo '<div class="alert alert-success">Registro eliminado correctamente</div>';
        } else{
            echo '<div class="alert alert-danger">Error al eliminar el pedido entregado</div>';
        }
    
        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);
    }
    ?>
    <script src="menu.js"></script>

</body>
</html>