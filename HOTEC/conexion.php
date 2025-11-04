<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hotec";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
