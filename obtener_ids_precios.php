<?php
$sql = "SELECT c.nombre AS nombre_cliente, s.nombre AS nombre_servicio, p.precio 
FROM clientes_servicios p 
INNER JOIN clientes c ON p.id_cliente = c.id 
INNER JOIN servicios s ON p.id_servicio = s.id";

if (!empty($_GET['servicio']) and !empty($_GET['cliente'])) 
{
    $cliente123 = $_GET['cliente'];
    $servicio123 = $_GET['servicio'];
    $sql = "SELECT c.nombre AS nombre_cliente, s.nombre AS nombre_servicio, p.precio 
FROM clientes_servicios p 
INNER JOIN clientes c ON p.id_cliente = c.id 
INNER JOIN servicios s ON p.id_servicio = s.id
WHERE p.id_cliente = '$cliente123' AND p.id_servicio = '$servicio123'";
}

else if (!empty($_GET['cliente'])) 
{
    $cliente123 = $_GET['cliente'];
    $sql = "SELECT c.nombre AS nombre_cliente, s.nombre AS nombre_servicio, p.precio 
FROM clientes_servicios p 
INNER JOIN clientes c ON p.id_cliente = c.id 
INNER JOIN servicios s ON p.id_servicio = s.id
WHERE p.id_cliente = '$cliente123'";
}


else if(!empty($_GET['servicio']))
{
    $servicio123 = $_GET['servicio'];
    $sql = "SELECT c.nombre AS nombre_cliente, s.nombre AS nombre_servicio, p.precio 
FROM clientes_servicios p 
INNER JOIN clientes c ON p.id_cliente = c.id 
INNER JOIN servicios s ON p.id_servicio = s.id
WHERE p.id_servicio = '$servicio123'";
}

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