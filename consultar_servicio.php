<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$id_servicio = $_GET['id_cliente'];

require_once('conexion.php');
$consulta_servicios = "SELECT * FROM servicios WHERE id = $id_servicio";
$resultado_clientes = mysqli_query($conexion, $consulta_servicios);
while($fila_cliente = mysqli_fetch_assoc($resultado_clientes)){
        $nombre = $fila_cliente['nombre'];
        $descripcion = $fila_cliente['descripcion'];
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Servicio</title>
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
			<h2>Servicio</h2>
			<form>
				<div class="form-group form-row">
					<label class="col-sm-3" for="id">ID:</label>
					<div class="col-sm-9">
						<label class="col-sm-3" for="id"><?= $id_servicio ?></label>
					</div>
				</div>
				<div class="form-group form-row">
					<label class="col-sm-3" for="nombre">Nombre:</label>
					<div class="col-sm-9">
						<label for="id"><?= $nombre ?></label>
					</div>
				</div>
				<div class="form-group form-row">
					<label class="col-sm-3" for="servicio">Descripcion:</label>
					<div class="col-sm-9">
						<label for="id"><?= $descripcion ?></label>
					</div>
				</div>
				<hr>
				<h5 style="text-align:center;">Clientes</h5>
				<div>
					<hr>
					<table id="mi_tabla">
                		<thead>
                			<tr>
                				<th>Cliente</th>
                				<th>Precio</th>
                			</tr>
                		</thead>
                		<tbody>
                		    <?php
                		    $consulta_servicios = "SELECT c.nombre AS cliente, cs.precio AS precio 
                		    FROM clientes_servicios cs
                		    INNER JOIN clientes c ON cs.id_cliente = c.id
                		    WHERE id_servicio = '$id_servicio'";
                		    $resultado_clientes = mysqli_query($conexion, $consulta_servicios);
                            while($fila_cliente = mysqli_fetch_assoc($resultado_clientes)){
                                    echo '<tr>';
                                    echo '<td>' . $fila_cliente['cliente'] . '</td>';
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
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button type="button" class="btn btn-secondary" id="enviar">Buscar</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script>
        document.getElementById("enviar").addEventListener("click", function() {
            window.location.href = "buscar_servicio.php";
        });
    </script>
</body>
</html>