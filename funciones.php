<?php

// Función para obtener el estado del pedido
function estado_pedido($numero_pedido, $conexion) {
    
    //require_once('conexion.php');
    
    // Aquí iría la lógica para obtener el estado del pedido según su número
    // Por ejemplo:
    $sql_facturado = "SELECT COUNT(*) as facturado FROM pedido_facturado WHERE id_pedido = ".$numero_pedido;
    $resultado_facturado = mysqli_query($conexion, $sql_facturado);
    $facturado = mysqli_fetch_assoc($resultado_facturado)['facturado'] > 0;
    
    // Buscar el estado de entrega en la tabla pedidos_entregados
    $sql_entregado = "SELECT COUNT(*) as entregado FROM pedidos_entregados WHERE id_pedido = ".$numero_pedido;
    $resultado_entregado = mysqli_query($conexion, $sql_entregado);
    $entregado = mysqli_fetch_assoc($resultado_entregado)['entregado'] > 0;
    
    $sql_liquidado = "SELECT COUNT(*) as liquidado FROM liquidacion WHERE id_pedido = ".$numero_pedido;
    $resultado_liquidado = mysqli_query($conexion, $sql_liquidado);
    $liquidado = mysqli_fetch_assoc($resultado_liquidado)['liquidado'] > 0;
    
    // Combinar ambos estados en un arreglo y devolverlo
    return array($entregado, $facturado, $liquidado);
}

?>