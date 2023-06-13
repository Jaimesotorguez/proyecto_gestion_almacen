<?php

if (!empty($_GET['estado']) and !empty($_GET['cliente']) and !empty($_GET['servicio'])) 
{
    $estado = $_GET['estado'];
    $cliente123 = $_GET['cliente'];
    $servicio123 = $_GET['servicio'];
        
    if($estado == 'No entregado')
    {
        $sql = "SELECT id, n_pedido FROM pedidos WHERE id NOT IN (SELECT id_pedido FROM pedidos_entregados) AND id_cliente = '$cliente123' AND id_servicio = '$servicio123'";
    }
    else if($estado == 'Entregado')
    {
        $sql = "SELECT id, n_pedido FROM pedidos WHERE id IN (SELECT id_pedido FROM pedidos_entregados) AND id_cliente = '$cliente123' AND id_servicio = '$servicio123'";
    }
        
} 
    else if (!empty($_GET['cliente']) and !empty($_GET['servicio']))
    {
        $cliente123 = $_GET['cliente'];
        $servicio123 = $_GET['servicio'];
        $sql = "SELECT id, n_pedido FROM pedidos WHERE id_cliente = '$cliente123' AND id_servicio = '$servicio123'";
        
    }
    else if (!empty($_GET['estado']) and !empty($_GET['servicio']))
    {
        $estado = $_GET['estado'];
        $servicio123 = $_GET['servicio'];
        if($estado == 'No entregado')
        {
            $sql = "SELECT id, n_pedido FROM pedidos WHERE id NOT IN (SELECT id_pedido FROM pedidos_entregados) AND id_servicio = '$servicio123'";
        }
        else if($estado == 'Entregado')
        {
            $sql = "SELECT id, n_pedido FROM pedidos WHERE id IN (SELECT id_pedido FROM pedidos_entregados) AND id_servicio = '$servicio123'";
        }
        
    }
    else if (!empty($_GET['cliente']) and !empty($_GET['estado']))
    {
        $cliente123 = $_GET['cliente'];
        $estado = $_GET['estado'];
        
        if($estado == 'No entregado')
        {
            $sql = "SELECT id, n_pedido FROM pedidos WHERE id NOT IN (SELECT id_pedido FROM pedidos_entregados) AND id_cliente = '$cliente123'";
        }
        else if($estado == 'Entregado')
        {
            $sql = "SELECT id, n_pedido FROM pedidos WHERE id IN (SELECT id_pedido FROM pedidos_entregados) AND id_cliente = '$cliente123'";
        }
        else if($estado == 'por facturar')
        {
            $sql = "SELECT id, n_pedido FROM pedidos WHERE id NOT IN (SELECT id_pedido FROM pedido_facturado) AND id_cliente = '$cliente123'";
        }
        else if($estado == 'facturado')
        {
            $sql = "SELECT id, n_pedido FROM pedidos WHERE id IN (SELECT id_pedido FROM pedido_facturado) AND id_cliente = '$cliente123'";
        }
        
    }
    else if (!empty($_GET['cliente']))
    {
        $cliente123 = $_GET['cliente'];
        
        $sql = "SELECT id, n_pedido FROM pedidos WHERE id_cliente = '$cliente123'";
        
    }
    else if (!empty($_GET['estado']))
    {
        $estado = $_GET['estado'];
        
        if($estado == 'No entregado')
        {
            $sql = "SELECT id, n_pedido FROM pedidos WHERE id NOT IN (SELECT id_pedido FROM pedidos_entregados)";
        }
        else if($estado == 'Entregado')
        {
            $sql = "SELECT id, n_pedido FROM pedidos WHERE id IN (SELECT id_pedido FROM pedidos_entregados)";
        }
        else if($estado == 'por facturar')
        {
            $sql = "SELECT id, n_pedido FROM pedidos WHERE id NOT IN (SELECT id_pedido FROM pedido_facturado)";
        }
        else if($estado == 'facturado')
        {
            $sql = "SELECT id, n_pedido FROM pedidos WHERE id IN (SELECT id_pedido FROM pedido_facturado)";
        }
        
        
    }
    else if (!empty($_GET['servicio']))
    {
        $servicio123 = $_GET['servicio'];
        
        $sql = "SELECT id, n_pedido FROM pedidos WHERE id_servicio = '$servicio123'";
        
    }
    else
    {
        $sql = "SELECT id, n_pedido FROM pedidos";
        
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
        array_push($id_pedidos, $row["id"]);
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