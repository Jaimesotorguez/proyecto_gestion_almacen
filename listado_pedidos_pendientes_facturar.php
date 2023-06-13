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
    <title>Listado pendiente factura</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


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
            <h2>Listado pedidos pendientes de facturar</h2>
            <div class="form-group form-row">
                <label class="col-sm-3" for="cliente">Cliente:</label>
				<div class="col-sm-9">
    				<select class="form-control" id="cliente" name="cliente">
    					<option value="">Selecciona un cliente</option>
    					<?php
                                  
                                  // Comprobar si la conexión ha sido exitosa
                                  if (mysqli_connect_errno()) {
                                    echo "Error en la conexión: " . mysqli_connect_error();
                                    exit();
                                  }
                                  
                                  // Realizar la consulta a la tabla vehiculos
                                  $consulta = "SELECT id, nombre FROM clientes";
                                  $resultado = mysqli_query($conexion, $consulta);
                                  
                                  // Comprobar si la consulta ha sido exitosa
                                  if (!$resultado) {
                                    echo "Error en la consulta: " . mysqli_error($conexion);
                                    exit();
                                  }
                                  
                                  // Crear las opciones del select
                                  while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo "<option value='" . $fila['id'] . "'>" . $fila['nombre'] . "</option>";
                                  }
                                  
                                  // Cerrar la conexión a la base de datos
                                  mysqli_close($conexion);
                        ?>

    				</select>
    			</div>
			</div>
			<div class="form-group form-row">
				<label class="col-sm-3" for="estado">Estado:</label>
				<div class="col-sm-9">
    				<select class="form-control" id="estado" name="estado">
    					<option value="">Estado del pedido</option>
    					<option value="por facturar">Pendiente factura</option>
    					<option value="facturado">facturado</option>
    				</select>
    			</div>
			</div>
			<div class="centrar">
			    <button type="button" class="btn btn-primary" id="hola">Aplicar filtros</button>
			</div>
			<div class="form-group">
    			<table id="mi_tabla">
            		<thead>
            			<tr>
            				<th>ID_pedido</th>
            				<th>N_pedido</th>
            				<th>Cliente</th>
            				<th>Servicio</th>
            				<th>Estado</th>
            			</tr>
            		</thead>
            		<tbody>
            		</tbody>
            	</table>
			</div>
        </div>
    </div>
    <script>
        // Hacer una consulta para obtener todos los ID de pedidos
        $(document).ready(function() {
			
			$.ajax({
                  url: 'obtener_ids_pedido.php',
                  method: 'GET',
                  data: { cliente: $('#cliente').val(),
                    estado: $('#estado').val()
                  },
                  
                  success: function(response) {
                    // Parsear la respuesta JSON
                    var idsPedidos = JSON.parse(response);
                    
                    // Llamar a la función para cada ID de pedido
                    idsPedidos.forEach(function(idPedido) {
                        $.ajax({
                          url: 'obtener-pedido.php',
                          method: 'GET',
                          data: { id: idPedido },
                          
                          success: function(response) {
                            // Parsear la respuesta JSON
                            var pedido = JSON.parse(response);
                            // Crear una nueva fila para la tabla
							  var fila = '<tr style="background-color: ' + (pedido.facturado === 'Facturado' ? 'rgba(0, 128, 0, 0.3)' : 'rgba(128, 0, 0, 0.3)') + '">' +
                                         '<td>' + pedido.id + '</td>' +
                                         '<td>' + pedido.n_pedido + '</td>' +
                                         '<td>' + pedido.cliente_nombre + '</td>' +
                                         '<td>' + pedido.precio_servicio + '</td>' +
                                         '<td>' + pedido.facturado + '</td>' +
                                         '<td><button class="btn btn-danger btn-sm">Editar</button></td>'
                                       '</tr>';
                
                            // Añadir la fila a la tabla
                            $('table tbody').append(fila);
                          },
                          error: function(jqXHR, textStatus, errorThrown) {
                            console.error(errorThrown);
                          }
                        });
                    });
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                    alert('Me quedo por aquí');
                  }
                });
			
            $('#hola').click(function(event) {
                $('table tbody').empty();
                $.ajax({
                  url: 'obtener_ids_pedido.php',
                  method: 'GET',
                  data: { cliente: $('#cliente').val(),
                    estado: $('#estado').val()
                  },
                  
                  success: function(response) {
                    // Parsear la respuesta JSON
                    var idsPedidos = JSON.parse(response);
                    
                    // Llamar a la función para cada ID de pedido
                    idsPedidos.forEach(function(idPedido) {
                        $.ajax({
                          url: 'obtener-pedido.php',
                          method: 'GET',
                          data: { id: idPedido },
                          
                          success: function(response) {
                            // Parsear la respuesta JSON
                            var pedido = JSON.parse(response);
                            // Crear una nueva fila para la tabla
                            var fila = '<tr style="background-color: ' + (pedido.facturado === 'Facturado' ? 'rgba(0, 128, 0, 0.3)' : 'rgba(128, 0, 0, 0.3)') + '">' +
                                         '<td>' + pedido.id + '</td>' +
                                         '<td>' + pedido.n_pedido + '</td>' +
                                         '<td>' + pedido.cliente_nombre + '</td>' +
                                         '<td>' + pedido.precio_servicio + '</td>' +
                                         '<td>' + pedido.facturado + '</td>' +
                                         '<td><button class="btn btn-danger btn-sm">Editar</button></td>'
                                       '</tr>';
                
                            // Añadir la fila a la tabla
                            $('table tbody').append(fila);
                          },
                          error: function(jqXHR, textStatus, errorThrown) {
                            console.error(errorThrown);
                          }
                        });
                    });
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                    alert('Me quedo por aquí');
                  }
                });
            });
        });

    </script>
</body>
</html>