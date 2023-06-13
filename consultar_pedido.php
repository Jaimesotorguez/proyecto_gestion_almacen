<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$id_pedido = $_GET['id_cliente'];

require_once('conexion.php');
require_once('funciones.php');

$resultado = estado_pedido($id_pedido, $conexion);
if($resultado[1])
{
    $facturado = "Facturado";
}
else
{
    $facturado = "Pendiente";
}

if($resultado[0])
{
    $entregado = "Entregado";
}
else
{
    $entregado = "En almacén";
}

if($resultado[2])
{
    $liquidado = "Liquidado";
	
	$consulta_servicios = "SELECT * FROM liquidacion WHERE id_pedido =".$id_pedido;
	$resultado_clientes = mysqli_query($conexion, $consulta_servicios);
	while($fila_cliente = mysqli_fetch_assoc($resultado_clientes))
	{
		$fecha_pago = $fila_cliente['fecha'];
		$metodo_pago = $fila_cliente['id_pago'];
		if($metodo_pago == 1)
		{
			$metodo_pago = 'efectivo';
		}
		else
		{
			$metodo_pago = 'tarjeta';
		}
	}
}
else
{
    $liquidado = "Pendiente";
	$fecha_pago = "Pendiente";
	$metodo_pago = "Pendiente";
}

$consulta_servicios = "SELECT * FROM pedidos WHERE id =".$id_pedido;
$resultado_clientes = mysqli_query($conexion, $consulta_servicios);
while($fila_cliente = mysqli_fetch_assoc($resultado_clientes))
{
    $n_pedido = $fila_cliente['n_pedido'];
    $id_servicio = $fila_cliente['id_servicio'];
    $id_cliente = $fila_cliente['id_cliente'];
    $fecha_almacen = $fila_cliente['fecha'];
}

$consulta_servicios = "SELECT * FROM clientes_servicios WHERE id_servicio = ".$id_servicio." AND id_cliente = ".$id_cliente;
$resultado_clientes = mysqli_query($conexion, $consulta_servicios);
while($fila_cliente = mysqli_fetch_assoc($resultado_clientes))
{
    $precio = $fila_cliente['Precio'];
}

$consulta_servicios = "SELECT * FROM albaranes WHERE id_pedido =".$id_pedido;
$resultado_clientes = mysqli_query($conexion, $consulta_servicios);
while($fila_cliente = mysqli_fetch_assoc($resultado_clientes))
{
    $direccion = $fila_cliente['direccion_entrega'];
	$cantidad_liquidacion = $fila_cliente['liquidacion_pendiente'];
	$telefono = $fila_cliente['telefono'];
	$nombre_cliente = $fila_cliente['nombre_cliente'];
}

$consulta_servicios = "SELECT * FROM servicios WHERE id =".$id_servicio;
$resultado_clientes = mysqli_query($conexion, $consulta_servicios);
while($fila_cliente = mysqli_fetch_assoc($resultado_clientes))
{
    $servicio = $fila_cliente['nombre'];
}

$consulta_servicios = "SELECT * FROM clientes WHERE id =".$id_cliente;
$resultado_clientes = mysqli_query($conexion, $consulta_servicios);
while($fila_cliente = mysqli_fetch_assoc($resultado_clientes))
{
    $cliente = $fila_cliente['nombre'];
}

$consulta_servicios = "SELECT * FROM pedidos_entregados WHERE id_pedido =".$id_pedido;
$resultado = mysqli_query($conexion, $consulta_servicios);
if(mysqli_num_rows($resultado) == 0) {
    $id_ruta = 'Pendiente';
    $fecha_entrega = 'Pendiente';
} 
else 
{
    // se encontró al menos un pedido con el id especificado
    $fila = mysqli_fetch_assoc($resultado);
    $id_ruta = $fila['id_ruta'];
    $id = $fila['id'];
    
    $consulta_servicios = "SELECT * FROM rutas WHERE id =".$id_ruta;
    $resultado = mysqli_query($conexion, $consulta_servicios);
    if(mysqli_num_rows($resultado) == 0) 
    {
        $fecha_entrega = 'Pendiente';
    } 
    else 
    {
        // se encontró al menos un pedido con el id especificado
        $fila = mysqli_fetch_assoc($resultado);
        $fecha_entrega = $fila['fecha_entrega'];
        // haz algo con la fecha_pedido y la cantidad
    }
}



    
?>

<!DOCTYPE html>
<html>
<head>
	<title>Pedido</title>
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
			<h2>Pedido <?= $entregado ?></h2>
			<form>
				<div class="form-group form-row">
					<label class="col-sm-3" for="id">ID:</label>
					<label for="id"><?= $id_pedido ?></label>
				</div>
				<div class="form-group form-row">
					<label class="col-sm-3" for="n_pedido">Número pedido:</label>
					<label for="n_pedido"><?= $n_pedido ?></label>
				</div>
				<div class="form-group form-row">
					<label class="col-sm-3" for="servicio">Servicio:</label>
					<label for="id"><?= $servicio ?></label>
				</div>
				<div class="form-group form-row">
					<label class="col-sm-3" for="cliente">Cliente:</label>
					<label for="id"><?= $cliente ?></label>
				</div>
				<hr>
				<h5 style="text-align:center;">Almacén</h5>
				<div>
					<hr>
					<div class="form-group form-row">
						<label class="col-sm-3" for="fecha_entrada">Fecha entrada:</label>
						<label for="fecha_entrada"><?= $fecha_almacen ?></label>
					</div>
					<div class="form-group form-row">
						<label class="col-sm-3" for="fecha_salida">Fecha Salida:</label>
						<label for="fecha_salida"><?= $fecha_entrega ?></label>
					</div>
					<hr>
				</div>
				<hr>
				<h5 style="text-align:center;">Ruta</h5>
				<div>
					<hr>
					<div class="form-group form-row">
						<label class="col-sm-3" for="fecha_entrega">Fecha entrega:</label>
						<label class="col-sm-3" for="fecha_entrega"><?= $fecha_entrega ?></label>
						<button class="btn btn-danger btn-sm">Añadir a ruta</button>
					</div>
					<div class="form-group form-row">
						<label class="col-sm-3" for="id_ruta">ID ruta:</label>
						<label class="col-sm-3" for="id_ruta"><?= $id_ruta ?></label>
					</div>
					<hr>
				</div>
				<hr>
            
            <h5 style="text-align:center;">Albarán</h5>
            <div>
                <hr>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="fecha_entrada">Nombre:</label>
                    <label class="col-sm-3" for="fecha_entrada"><?= $nombre_cliente ?></label>
                    <button class="btn btn-danger btn-sm">Generar albarán</button>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="fecha_salida">Teléfono:</label>
                    <label class="col-sm-3" for="fecha_salida"><?= $telefono ?></label>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="fecha_salida">Direccion:</label>
                    <label class="col-sm-3" for="fecha_salida"><?= $direccion ?></label>
                </div>
                <hr>
            </div>
            
            <h5 style="text-align:center;">Liquidación</h5>
            <div>
                <hr>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="fecha_entrada">Cantidad pendiente:</label>
                    <label class="col-sm-3" for="fecha_entrada"><?= $cantidad_liquidacion ?></label>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="fecha_salida">Estado:</label>
                    <label class="col-sm-3" for="fecha_salida"><?= $liquidado ?></label>
                    <button class="btn btn-danger btn-sm">Liquidar</button>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="fecha_salida">Fecha liquidación:</label>
                    <label class="col-sm-3" for="fecha_salida"><?= $fecha_pago ?></label>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="fecha_salida">Modalidad de pago:</label>
                    <label class="col-sm-3" for="fecha_salida"><?= $metodo_pago ?></label>
                </div>
                <hr>
            </div>
            
            <h5 style="text-align:center;">Facturación</h5>
            <div>
                <hr>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="fecha_entrada">Precio:</label>
                    <label class="col-sm-3" for="fecha_entrada"><?= $precio ?></label>
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="fecha_salida">Estado:</label>
                    <label class="col-sm-3" for="fecha_salida"><?= $facturado ?></label>
                    <button class="btn btn-danger btn-sm">Facturar</button>
                </div>
                <hr>
            </div>
            
        </div>
    </div>
</body>
</html>