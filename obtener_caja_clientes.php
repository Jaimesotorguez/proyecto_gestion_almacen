<?php

$sql = "SELECT c.nombre AS cliente, SUM(saldo) AS saldo
FROM (
    SELECT sc.id_cliente, SUM(sc.cantidad) AS saldo
    FROM salidas_caja sc
    GROUP BY sc.id_cliente

    UNION ALL

    SELECT p.id_cliente, SUM(a.liquidacion_pendiente) * -1 AS saldo
    FROM liquidacion l 
    INNER JOIN pedidos p ON l.id_pedido = p.id
    INNER JOIN albaranes a ON l.id_pedido = a.id_pedido
    WHERE l.id_pago = 1
    GROUP BY p.id_cliente
) AS movimientos
INNER JOIN clientes c ON movimientos.id_cliente = c.id
GROUP BY c.nombre
";

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