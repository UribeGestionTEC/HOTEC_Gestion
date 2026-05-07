<?php
include("../../config/conexion.php");

$tipo = $_POST['tipo_documento'];
$documento = $_POST['documento'];

$sql_check = "SELECT id_huesped FROM huespedes WHERE documento=? AND tipo_documento=?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("ss", $documento, $tipo);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    echo "Huésped ya existe";
    exit();
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];

$sql = "INSERT INTO huespedes (tipo_documento, documento, nombre, apellido, email, telefono)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $tipo, $documento, $nombre, $apellido, $email, $telefono);

if($stmt->execute()){
    echo "Huésped registrado";
} else {
    echo "Error";
}
?>