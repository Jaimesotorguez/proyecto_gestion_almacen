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
    <title>Alta ruta</title>
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
    
    <style>
      .disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
      }

      .active {
        opacity: 1;
        cursor: pointer;
        pointer-events: auto;
      }
    </style>
</head>
<body>
    <?php include('nav.php'); ?>
	<div class="container">
		<div class="form-container">
				<h2>Dar de alta una ruta</h2>
				<form method="post">
					<div class="form-group form-row">
						<label class="col-sm-3" for="cliente">Vehiculo:</label>
						<div class="col-sm-9">
    						<select class="form-control" id="vehiculo" name="vehiculo">
    							<option value="">Selecciona un vehiculo</option>
    							<?php
                                  
                                  // Comprobar si la conexión ha sido exitosa
                                  if (mysqli_connect_errno()) {
                                    echo "Error en la conexión: " . mysqli_connect_error();
                                    exit();
                                  }
                                  
                                  // Realizar la consulta a la tabla vehiculos
                                  $consulta = "SELECT id, matricula FROM vehiculos";
                                  $resultado = mysqli_query($conexion, $consulta);
                                  
                                  // Comprobar si la consulta ha sido exitosa
                                  if (!$resultado) {
                                    echo "Error en la consulta: " . mysqli_error($conexion);
                                    exit();
                                  }
                                  
                                  // Crear las opciones del select
                                  while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo "<option value='" . $fila['id'] . "'>" . $fila['matricula'] . "</option>";
                                  }
                                  
                                ?>

    						</select>
    					</div>
					</div>
					<div class="form-group form-row">
						<label class="col-sm-3" for="cliente">Transportista:</label>
						<div class="col-sm-9">
    						<select class="form-control" id="transportista" name="transportista">
    							<option value="">Selecciona un transportista</option>
    							 <?php
                                  
                                  // Comprobar si la conexión ha sido exitosa
                                  if (mysqli_connect_errno()) {
                                    echo "Error en la conexión: " . mysqli_connect_error();
                                    exit();
                                  }
                                  
                                  // Realizar la consulta a la tabla vehiculos
                                  $consulta = "SELECT id, nombre FROM transportistas";
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
                                  
                                ?>
    						</select>
    					</div>
					</div>
					<div class="form-group form-row">
					    <label class="col-sm-3" for="fecha">Fecha:</label>
					    <div class="col-sm-9">
			                <input class="form-control" type="date" id="fecha">
			            </div>
			        </div>
			        
					<div class="form-group">
    					<table id="mi_tabla">
            				<thead>
            					<tr>
            						<th>ID_pedido</th>
            						<th>N_pedido</th>
            						<th>Cliente</th>
            						<th>Servicio</th>
            						<th>Precio</th>
            					</tr>
            				</thead>
            				<tbody>
            				</tbody>
            			</table>
					</div>
					
					<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                    $(document).ready(function() {
                      $('#add-pedido').click(function(event) {
                        event.preventDefault();
                        
                        var idPedido = $('#pedido').val();
						$('#pedido option:selected').remove();
                        
                        // Buscar la celda con el ID en la tabla
                        var celdaId = $('table tbody td:first-child').filter(function() {
                          return $(this).text() === idPedido;
                        });
                        
                        // Verificar si existe una celda con ese ID
                        if (celdaId.length) {
                          alert('Ya existe un pedido con ese ID');
                        } else {
                          $.ajax({
                            url: 'obtener-pedido.php',
                            method: 'GET',
                            data: { id: idPedido },
                            success: function(response) {
                              // Parsear la respuesta JSON
                              var pedido = JSON.parse(response);
                              // Crear una nueva fila para la tabla
                              var fila = '<tr>' +
                                           '<td>' + pedido.id + '</td>' +
                                           '<td>' + pedido.n_pedido + '</td>' +
                                           '<td>' + pedido.cliente_nombre + '</td>' +
                                           '<td>' + pedido.nombre + '</td>' +
                                           '<td>' + pedido.precio_servicio + '</td>' +
                                           '<td><button class="btn btn-danger btn-sm">Eliminar</button></td>'
                                         '</tr>';
                              
                              // Añadir la fila a la tabla
                              $('table tbody').append(fila);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                              console.error(errorThrown);
                            }
                          });
                        }
                      });
                      
                      $('table tbody').on('click', 'button', function() {
						  // Obtener la fila
						  var fila = $(this).closest('tr');

						  // Obtener el valor eliminado
						  var valorEliminado = fila.find('td:first-child').text();
						  var valorEliminado2 = fila.find('td:nth-child(2)').text();
						  

						  // Eliminar la fila
						  fila.remove();

						  // Crear una nueva opción para el select
						  var opcionNueva = $('<option>').val(valorEliminado).text(valorEliminado2);

						  // Agregar la opción nueva al select
						  $('#pedido').append(opcionNueva);
						});
                      
                      $('#guardar_pedido').click(function() {
                          // Validar campos
                          var vehiculo = $('#vehiculo').val();
                          var transportista = $('#transportista').val();
                          var fecha = $('#fecha').val();
                          var num_pedidos = $('table tbody tr').length;
                          
                          if (!vehiculo || !transportista || !fecha || num_pedidos == 0) {
                            alert('Por favor, complete todos los campos y agregue al menos un pedido.');
                            return false;
                          }
                          // Obtener la tabla por su ID
                          const tabla = document.getElementById('mi_tabla');
                    
                          // Crear un array vacío para almacenar los valores de la primera columna
                          const valoresColumna1 = [];
                    
                          // Iterar sobre cada fila de la tabla
                          for (let i = 0; i < tabla.rows.length; i++) {
                    
                            // Obtener la primera celda de la fila actual
                            const celda = tabla.rows[i].cells[0];
                    
                            // Agregar el valor de la celda al array de valores de la primera columna
                            valoresColumna1.push(celda.innerText);
                          }
                          
                          // Enviar datos por AJAX
                          $.ajax({
                            url: 'guardar_pedido.php',
                            method: 'POST',
                            data: {
                              vehiculo: vehiculo,
                              transportista: transportista,
                              fecha: fecha,
                              pedidos: JSON.stringify(valoresColumna1),

                            },
                            success: function(response) {
                              // Manejar respuesta de la página PHP
                              //alert(response);
                              //bloquearFormulario();
                              return true;
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                              console.error(errorThrown);
                            }
                          });
                          
                          // Detener el envío del formulario
                          //return false;
                        });


                    });
                    
                    </script>

					<hr>
			        <div class="form-group form-row">
                    	<label for="pedido_entregado" class="col-sm-3">Pedido:</label>
                    	<div class="col-sm-9">
                    		<select class="form-control" id="pedido" name="pedido">
                    			<option value="">Selecciona un pedido</option>
                    			<?php
                                  
                                  // Comprobar si la conexión ha sido exitosa
                                  if (mysqli_connect_errno()) {
                                    echo "Error en la conexión: " . mysqli_connect_error();
                                    exit();
                                  }
                                  
                                  // Realizar la consulta a la tabla vehiculos
                                  $consulta = "SELECT id, n_pedido FROM pedidos WHERE id NOT IN (SELECT id_pedido FROM pedidos_entregados)";
                                  $resultado = mysqli_query($conexion, $consulta);
                                  
                                  // Comprobar si la consulta ha sido exitosa
                                  if (!$resultado) {
                                    echo "Error en la consulta: " . mysqli_error($conexion);
                                    exit();
                                  }
                                  
                                  // Crear las opciones del select
                                  while ($fila = mysqli_fetch_assoc($resultado)) {
                                    echo "<option value='" . $fila['id'] . "'>" . $fila['n_pedido'] . "</option>";
                                  }
                                  
                                  // Cerrar la conexión a la base de datos
                                  mysqli_close($conexion);
                                ?>
                    		</select>
                    		
                    	</div>
                    	<button class="secondary" id="add-pedido" type="submit" name="submit">Añadir pedido</button>
                    </div>
					
					<div class="centrar">
                      <button class="btn btn-primary" type="button" name="submit" id="guardar_pedido">Guardar ruta</button>
                    </div>
				</form>
		</div>
	</div>
    
</body>
</html>