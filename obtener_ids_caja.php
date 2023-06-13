<?php

/*$sql = "SELECT sc.cantidad AS salida, c.nombre AS cliente, sc.fecha AS fecha, 0 AS entrada, '-' AS pedido
FROM salidas_caja sc 
INNER JOIN clientes c ON sc.id_cliente = c.id";

$sql = "SELECT c.nombre AS cliente, l.fecha AS fecha, a.liquidacion_pendiente AS entrada, p.n_pedido AS pedido, 0 AS salida
FROM liquidacion l 
INNER JOIN pedidos p ON l.id_pedido = p.id
INNER JOIN clientes c ON p.id_cliente = c.id
INNER JOIN albaranes a ON l.id_pedido = a.id_pedido
WHERE id_pago = 1";*/

$sql = "SELECT sc.cantidad AS salida, c.nombre AS cliente, sc.fecha AS fecha, 0 AS entrada, '-' AS pedido
FROM salidas_caja sc 
INNER JOIN clientes c ON sc.id_cliente = c.id

UNION ALL

SELECT 0 AS salida, c.nombre AS cliente, l.fecha AS fecha, a.liquidacion_pendiente AS entrada, p.n_pedido AS pedido
FROM liquidacion l 
INNER JOIN pedidos p ON l.id_pedido = p.id
INNER JOIN clientes c ON p.id_cliente = c.id
INNER JOIN albaranes a ON l.id_pedido = a.id_pedido
WHERE id_pago = 1
ORDER BY fecha";

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