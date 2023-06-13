<?php
$host = "PMYSQL169.dns-servicio.com:3306";
$user = "id20584686_jaimesoto";
$password = "*MUk%ev[RJ<9fSxb";
$database = "9843550_jaimesoto";

$conexion = mysqli_connect($host, $user, $password, $database);

if (!$conexion) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}
?>
