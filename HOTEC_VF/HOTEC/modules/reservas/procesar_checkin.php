<?php
include("../../config/conexion.php");

session_start();

$id_reserva = $_POST['id_reserva'];
$id_usuario = $_SESSION['id_usuario'];

$email = $_POST['email'];
$telefono = $_POST['telefono'];

// actualizar contacto del huésped
$id_huesped = $_POST['id_huesped'];

$conn->query("
UPDATE huespedes 
SET email='$email', telefono='$telefono'
WHERE id_huesped=$id_huesped
");

// crear check-in
$conn->query("
INSERT INTO check_in (id_reserva, id_usuario)
VALUES ($id_reserva, $id_usuario)
");

// actualizar reserva
$conn->query("
UPDATE reservas 
SET estado='confirmada'
WHERE id_reserva=$id_reserva
");

header("Location: ../../views/reservas_view.php");
?>