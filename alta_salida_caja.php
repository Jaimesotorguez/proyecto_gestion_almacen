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
	<title>Salida caja</title>
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
            <h2>Registrar salida de caja</h2>
            <form method="post">
                <div class="form-group form-row">
                    <label for="cliente" class="col-sm-3">Cliente:</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="cliente" name="cliente">
                            <option value="">Selecciona un cliente</option>
                            <?php
                                if (mysqli_connect_errno()) {
                                    echo "Error al conectar a la base de datos: " . mysqli_connect_error();
                                    exit();
                                }
                                
                                // Consulta para obtener los servicios
                                $consulta_servicios = "SELECT id, nombre FROM clientes";
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
                    <label for="cantidad" class="col-sm-3">Cantidad:</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="number" id="cantidad" name="cantidad" step="0.01">
                    </div>
                </div>
                <div class="centrar">
                    <button type="submit" class="btn btn-primary" name="submit_button">Registrar</button>
                </div>
            </form>
        </div>
    </div>
    <?php
        if(isset($_POST['submit_button'])){
        // Obtener los valores del formulario
        $id_cliente = $_POST['cliente'];
        $cantidad = $_POST['cantidad'];
        
        if (mysqli_connect_errno()) {
            echo "Error al conectar a la base de datos: " . mysqli_connect_error();
            exit();
        }
    
        // Consulta para insertar los valores en la tabla
        $consulta = "INSERT INTO salidas_caja (id_cliente, cantidad) VALUES ('$id_cliente', '$cantidad')";
    
        // Ejecutar la consulta
        if(mysqli_query($conexion, $consulta)){
            echo '<div class="alert alert-success">La salida ha sido guardada correctamente</div>';
        } else{
            echo '<div class="alert alert-danger">Error al guardar la salida de caja</div>';
        }
    
        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);
    }
    ?>
    <script src="menu.js"></script>

</body>
</html>