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
    <title>Listado de pedidos</title>
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
        <div class="caja">
            <h2>Listado pedidos</h2>
            <div class="form-group form-row">
                <label class="col-sm-3" for="cliente">Cliente:</label>
				<div class="col-sm-9">
    				<select class="form-control" id="cliente" name="cliente">
    					
    					<?php
                                  // Comprobar si la conexión ha sido exitosa
                                  if (mysqli_connect_errno()) {
                                    echo "Error en la conexión: " . mysqli_connect_error();
                                    exit();
                                  }
                                  
                                  // Realizar la consulta a la tabla vehiculos
                                  if ($_SESSION['user_role']=='cliente') 
                                    {
                                        $_SESSION['cliente_id'];
                                        $consulta = "SELECT id, nombre FROM clientes where id =". $_SESSION['cliente_id'];
                                        echo "<option value=".$_SESSION['cliente_id'].">Selecciona un cliente</option>";
                                    }
                                    else
                                    {
                                        $consulta = "SELECT id, nombre FROM clientes";
                                    }
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
                                  //mysqli_close($conexion);
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
                                  
                                  // Comprobar si la conexión ha sido exitosa
                                  if (mysqli_connect_errno()) {
                                    echo "Error en la conexión: " . mysqli_connect_error();
                                    exit();
                                  }
                                  
                                  // Realizar la consulta a la tabla vehiculos
                                  $consulta = "SELECT id, nombre FROM servicios";
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
    					<option value="Entregado">Entregado</option>
    					<option value="No entregado">No entregado</option>
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
            				<th>Facturado</th>
            				<th>Liquidado</th>
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
                    estado: $('#estado').val(),
                    servicio: $('#servicio').val(),
                  },
                  
                  success: function(response) {
                    // Parsear la respuesta JSON
                    var idsPedidos = JSON.parse(response);
                    
                    $('table tbody').empty();
                    
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
                            var fila = '<tr style="background-color: ' + (pedido.entregado === 'Entregado' ? 'rgba(0, 128, 0, 0.3)' : 'rgba(128, 0, 0, 0.3)') + '">' +
							  '<td>' + pedido.id + '</td>' +
							  '<td>' + pedido.n_pedido + '</td>' +
							  '<td>' + pedido.cliente_nombre + '</td>' +
							  '<td>' + pedido.nombre + '</td>' +
							  '<td>' + pedido.entregado + '</td>' +
							  '<td>' + pedido.facturado + '</td>' +
							  '<td>' + pedido.liquidado + '</td>' +
							  '<td><button class="btn btn-danger btn-sm">Ver</button></td>' +
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
                
                $.ajax({
                  url: 'obtener_ids_pedido.php',
                  method: 'GET',
                  data: { cliente: $('#cliente').val(),
                    estado: $('#estado').val(),
                    servicio: $('#servicio').val(),
                  },
                  
                  success: function(response) {
                    // Parsear la respuesta JSON
                    var idsPedidos = JSON.parse(response);
                    
                    $('table tbody').empty();
                    
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
                            var fila = '<tr style="background-color: ' + (pedido.entregado === 'Entregado' ? 'rgba(0, 128, 0, 0.3)' : 'rgba(128, 0, 0, 0.3)') + '">' +
							  '<td>' + pedido.id + '</td>' +
							  '<td>' + pedido.n_pedido + '</td>' +
							  '<td>' + pedido.cliente_nombre + '</td>' +
							  '<td>' + pedido.nombre + '</td>' +
							  '<td>' + pedido.entregado + '</td>' +
							  '<td>' + pedido.facturado + '</td>' +
							  '<td>' + pedido.liquidado + '</td>' +
							  '<td><button class="btn btn-danger btn-sm">Ver</button></td>' +
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
            
            $('table tbody').on('click', 'button', function() {
                // Obtener la fila
                var fila = $(this).closest('tr');
                
                // Obtener el valor de la primera columna de la fila
                var valor = fila.find('td:first').text();
                
                // Redirigir a la dirección con el parámetro
                window.location.href = 'https://logisticstrack.es/consultar_pedido.php?id_cliente=' + valor;
            });
        });

    </script>
</body>
</html>