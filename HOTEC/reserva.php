<?php
include 'conexion.php';
session_start();
$id_usuario = $_SESSION['id'];

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$nacionalidad = $_POST['pais'];
$habitacion = $_POST['habitacion'];

$sql = "INSERT INTO reservas (id_usuario, nombre, apellido, checkin, checkout, nacionalidad, tipo_habitacion)
        VALUES ('$id_usuario', '$nombre', '$apellido', '$checkin', '$checkout', '$nacionalidad', '$habitacion')";

if (mysqli_query($conn, $sql)) {
    echo "Reserva registrada con éxito.";
} else {
    echo "Error al registrar la reserva.";
}
?>
