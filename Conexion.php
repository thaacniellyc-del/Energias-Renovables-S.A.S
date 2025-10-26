<?php
$conexion = new mysqli("localhost", "root", "", "sesion");

if ($conexion->connect_error) {
    die("❌ Error de conexión con MySQL: " . $conexion->connect_error);
}
?>

