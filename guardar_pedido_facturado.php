<?php

// Obtener los valores del formulario
$cliente = $_POST['cliente'];
$factura = $_POST['factura'];
$fecha = $_POST['fecha'];
$pedidos = json_decode($_POST['pedidos']);

require_once('conexion.php');

// Verificar que se hayan ingresado todos los datos necesarios
if ($cliente && $factura && $fecha && $pedidos) {

  // Insertar la ruta en la tabla de rutas
  $query_ruta = "INSERT INTO facturas (numero_factura, id_cliente, fecha_factura) VALUES ('$factura', '$cliente', '$fecha')";
  $resultado_ruta = mysqli_query($conexion, $query_ruta);

  // Verificar si la consulta se realizó correctamente
  if (!$resultado_ruta) {
    die("Error al insertar la factura: " . mysqli_error($conexion));
  }

  // Obtener el id de la ruta recién insertada
  $id_factura = mysqli_insert_id($conexion);

  // Insertar cada pedido en la tabla de pedidos_entregados
  // Insertar cada pedido en la tabla de pedidos_ruta
    if (is_array($pedidos)) {
      foreach ($pedidos as $pedido) {
        if (is_numeric($pedido)) {
          $query_pedido = "INSERT INTO pedido_facturado (id_factura, id_pedido) VALUES ('$id_factura', '$pedido')";
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


// Crear el contenido HTML de la factura
$html = '<h1>Factura</h1>';
$html .= '<table>';
$html .= '<tr><th>Producto</th><th>Cantidad</th><th>Precio</th></tr>';
$html .= '<tr><td>Producto 1</td><td>1</td><td>$10.00</td></tr>';
$html .= '<tr><td>Producto 2</td><td>2</td><td>$20.00</td></tr>';
$html .= '<tr><td>Producto 3</td><td>3</td><td>$30.00</td></tr>';
$html .= '</table>';

// Incluir la biblioteca Dompdf
require_once 'vendor/autoload.php';

// Crear una instancia de Dompdf
use Dompdf\Dompdf;
$dompdf = new Dompdf();

// Cargar el contenido HTML de la factura
$dompdf->loadHtml($html);

// Renderizar el contenido HTML en un documento PDF
$dompdf->render();

// Generar el PDF y guardarlo en un archivo
$pdf = $dompdf->output();
file_put_contents('factura.pdf', $pdf);


?>