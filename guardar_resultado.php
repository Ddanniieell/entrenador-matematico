<?php
$conexion = new mysqli('localhost', 'root', '', 'entrenador');

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$respuesta = $_POST['respuesta'];
$correcto = $_POST['correcto'];

$query = "INSERT INTO resultados (respuesta_usuario, correcta) VALUES ('$respuesta', '$correcto')";
$conexion->query($query);

$conexion->close();
?>
