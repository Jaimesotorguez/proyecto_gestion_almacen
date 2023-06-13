<?php

require_once('conexion.php');
require_once('funciones.php');


$idPedido = $_GET['id'];

$resultado = estado_pedido($idPedido, $conexion);


$query = "SELECT p.id, p.n_pedido, p.ubicacion, c.nombre AS cliente_nombre, s.nombre, cs.precio AS precio_servicio
	FROM pedidos p
	JOIN clientes c ON p.id_cliente = c.id
	JOIN servicios s ON p.id_servicio = s.id
	JOIN clientes_servicios cs ON p.id_servicio = cs.id_servicio AND p.id_cliente = cs.id_cliente
    WHERE p.id = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $idPedido);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pedido = mysqli_fetch_assoc($result);

if($resultado[1])
{
    $pedido['facturado'] = "Facturado";
}
else
{
    $pedido['facturado'] = "Pendiente";
}

if($resultado[0])
{
    $pedido['entregado'] = "Entregado";
}
else
{
    $pedido['entregado'] = "En almacén";
}

if($resultado[2])
{
    $pedido['liquidado'] = "Liquidado";
}
else
{
    $pedido['liquidado'] = "Pendiente";
}



// Devolver la información en formato JSON
echo json_encode($pedido);

?>