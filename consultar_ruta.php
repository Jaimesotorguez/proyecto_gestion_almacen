<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$id_cliente = $_GET['id_cliente'];

require_once('conexion.php');
$consulta_servicios = "SELECT v.matricula AS coche, t.nombre AS nombre, r.fecha_entrega AS fecha 
FROM rutas r
INNER JOIN vehiculos v ON r.id_vehiculo = v.id
INNER JOIN transportistas t ON r.id_transportista = t.id
WHERE r.id = $id_cliente";
$resultado_clientes = mysqli_query($conexion, $consulta_servicios);
while($fila_cliente = mysqli_fetch_assoc($resultado_clientes)){
        $nombre = $fila_cliente['nombre'];
        $coche = $fila_cliente['coche'];
        $fecha = $fila_cliente['fecha'];
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ruta</title>
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
			<h2>Ruta</h2>
			<form>
				<div class="form-group form-row">
					<label class="col-sm-3" for="id">ID:</label>
					<div class="col-sm-9">
						<label for="id"><?= $id_cliente ?></label>
					</div>
				</div>
				<div class="form-group form-row">
					<label class="col-sm-3" for="nombre">Transportista:</label>
					<div class="col-sm-9">
						<label for="id"><?= $nombre ?></label>
					</div>
				</div>
				<div class="form-group form-row">
					<label class="col-sm-3" for="cliente">Matricula vehículo:</label>
					<div class="col-sm-9">
						<label for="id"><?= $coche ?></label>
					</div>
				</div>
				<div class="form-group form-row">
					<label class="col-sm-3" for="cliente">Fecha entrega:</label>
					<div class="col-sm-9">
						<label for="id"><?= $fecha ?></label>
					</div>
				</div>
				<hr>
				<h5 style="text-align:center;">Pedidos entregados</h5>
				<div>
					<hr>
					<table id="mi_tabla">
                		<thead>
                			<tr>
                				<th>ID</th>
                				<th>n_pedido</th>
                				<th>cliente</th>
                				<th>servicio</th>
                				<th>Precio</th>
                			</tr>
                		</thead>
                		<tbody>
                		    <?php
                		    $consulta_servicios = "SELECT p.n_pedido AS pedido, pe.id_pedido AS id, c.nombre AS cliente, cs.precio AS precio, s.nombre AS servicio
                		    FROM pedidos_entregados pe
                		    INNER JOIN pedidos p ON pe.id_pedido = p.id
                		    INNER JOIN clientes c ON p.id_cliente = c.id
                		    INNER JOIN servicios s ON p.id_servicio = s.id
                		    INNER JOIN clientes_servicios cs ON p.id_cliente = cs.id_cliente and p.id_servicio = cs.id_servicio
                		    WHERE pe.id_ruta = '$id_cliente'";
                		    $resultado_clientes = mysqli_query($conexion, $consulta_servicios);
                            while($fila_cliente = mysqli_fetch_assoc($resultado_clientes)){
                                    echo '<tr>';
                                    echo '<td>' . $fila_cliente['id'] . '</td>';
                                    echo '<td>' . $fila_cliente['pedido'] . '</td>';
                                    echo '<td>' . $fila_cliente['cliente'] . '</td>';
                                    echo '<td>' . $fila_cliente['servicio'] . '</td>';
                                    echo '<td>' . $fila_cliente['precio'] . '</td>';
                                    echo '</tr>';
                                }
                		    
                		    ?>
                		</tbody>
                	</table>
					<hr>
				</div>
				<div class="form-group form-row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-primary" id="editar">Editar</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button type="button" class="btn btn-secondary" id="enviar">Buscar otra ruta</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script>
        document.getElementById("enviar").addEventListener("click", function() {
            window.location.href = "bbuscar_ruta.php";
        });
    </script>
</body>
</html>