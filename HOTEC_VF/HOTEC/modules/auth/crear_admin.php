<?php
include("../../config/conexion.php");

$nombre = "Admin";
$apellido = "Principal";
$email = "admin@hotec.com";
$password = password_hash("123456", PASSWORD_DEFAULT);
$rol = "admin";

$sql = "INSERT INTO usuarios (nombre, apellido, email, password, rol)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nombre, $apellido, $email, $password, $rol);

if($stmt->execute()){
    echo "Admin creado correctamente";
} else {
    echo "Error: " . $stmt->error;
}
?>