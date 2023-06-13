<?php

$sql = "SELECT i.id AS id, m.motivo AS motivo, r.fecha_entrega AS fecha, p.n_pedido AS pedido
FROM incidencias i 
INNER JOIN rutas r ON i.id_ruta = r.id 
INNER JOIN motivos_incidencias m ON i.id_motivo = m.id
INNER JOIN pedidos p ON i.id_pedido = p.id";

require_once('conexion.php');
    
    // Preparar la consulta SQL
    $stmt = $conexion->prepare($sql);
    
    // Ejecutar la consulta SQL
    $stmt->execute();
    
    // Obtener los resultados de la consulta
    $result = $stmt->get_result();
    
    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
    
      // Crear un array para almacenar los ID de pedido
      $id_pedidos = array();
    
      // Recorrer los resultados y guardar los ID de pedido en el array
      while($row = $result->fetch_assoc()) {
        array_push($id_pedidos, $row);
      }
    
      // Enviar los ID de pedido como respuesta JSON
      echo json_encode($id_pedidos);
    
    } else {
      // Si no se encontraron resultados, enviar un mensaje de error como respuesta JSON
      echo json_encode(array("message" => "No se encontraron ID de pedido."));
    }
    
    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conexion->close();
    

?>