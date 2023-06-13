<?php
require_once('conexion.php');
// Obtener los valores del formulario
$vehiculo = $_POST['vehiculo'];
$transportista = $_POST['transportista'];
$fecha = $_POST['fecha'];
$pedidos = json_decode($_POST['pedidos']);

// Verificar que se hayan ingresado todos los datos necesarios
if ($vehiculo && $transportista && $fecha && $pedidos) {

  // Insertar la ruta en la tabla de rutas
  $query_ruta = "INSERT INTO rutas (id_vehiculo, id_transportista, fecha_entrega) VALUES ('$vehiculo', '$transportista', '$fecha')";
  $resultado_ruta = mysqli_query($conexion, $query_ruta);

  // Verificar si la consulta se realizó correctamente
  if (!$resultado_ruta) {
    die("Error al insertar ruta: " . mysqli_error($conexion));
  }

  // Obtener el id de la ruta recién insertada
  $id_ruta = mysqli_insert_id($conexion);

  // Insertar cada pedido en la tabla de pedidos_entregados
  // Insertar cada pedido en la tabla de pedidos_ruta
    if (is_array($pedidos)) {
      foreach ($pedidos as $pedido) {
        if (is_numeric($pedido)) {
          $query_pedido = "INSERT INTO pedidos_entregados (id_ruta, id_pedido) VALUES ('$id_ruta', '$pedido')";
          mysqli_query($conexion, $query_pedido);
        }
      }
    } else {
      // Si la variable $pedidos no es un array, mostrar un mensaje de error
      echo "La variable \$pedidos no es un array.";
    }

  // Cerrar la conexión a la base de datos
  mysqli_close($conexion);

  // Redireccionar al listado de rutas
  //header('Location: pruebas.php');
  exit;

} else {
  // Si falta algún dato, mostrar un mensaje de error
  echo "Faltan datos para guardar la ruta";
}
?>
