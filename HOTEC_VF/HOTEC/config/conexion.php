<?php
$host = "localhost";
$usuario = "root";
$password = "";
$bd = "hotec";

$conn = new mysqli($host, $usuario, $password, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Para evitar problemas con acentos
$conn->set_charset("utf8");
?>