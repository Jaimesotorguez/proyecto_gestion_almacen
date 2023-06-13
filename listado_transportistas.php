<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listado transportistas</title>
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
            <h2>Listado transportistas</h2>
			<div class="form-group">
    			<table id="mi_tabla">
            		<thead>
            			<tr>
            				<th>ID_transportista</th>
            				<th>Nombre</th>
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
                  url: 'obtener_ids_transportistas.php',
                  method: 'GET',
                  
                  success: function(response) {
                    // Parsear la respuesta JSON
                    
                    var servicios = JSON.parse(response);
                    // Crear una nueva fila para la tabla
                    
                    servicios.forEach(function(servicio) {
                        var fila = '<tr>' +
                            '<td>' + servicio.id + '</td>' +
                            '<td>' + servicio.nombre + '</td>' +
                            '<td><button class="btn btn-danger btn-sm">Editar</button></td>' +
                            '</tr>';
                    
                        // Añadir la fila a la tabla
                        $('table tbody').append(fila);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(errorThrown);
                    }
                });
            });

    </script>
</body>
</html>