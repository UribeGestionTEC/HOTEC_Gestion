<?php
$conexion = new mysqli("localhost", "root", "", "HOTEC");

if (
    isset($_POST['nombre'], $_POST['apellido'], $_POST['check_in'], $_POST['check_out'], $_POST['nacionalidad']) &&
    !empty($_POST['nombre']) &&
    !empty($_POST['apellido']) &&
    !empty($_POST['check_in']) &&
    !empty($_POST['check_out']) &&
    !empty($_POST['nacionalidad'])
) {
    if (!$conexion) {
        die("Error: no se pudo conectar a la base de datos.");
    }

    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $apellido = $conexion->real_escape_string($_POST['apellido']);
    $checkin = $conexion->real_escape_string($_POST['check_in']);
    $checkout = $conexion->real_escape_string($_POST['check_out']);
    $nacionalidad = $conexion->real_escape_string($_POST['nacionalidad']);

    $sql = "INSERT INTO reserva (nombre, apellido, nacionalidad, check_in, check_out)
            VALUES ('$nombre', '$apellido', '$nacionalidad', '$checkin', '$checkout')";

    if ($conexion->query($sql) === TRUE) {
        header("Location: GH_HOTEC.html");
        exit();
    } else {
        echo "<p style='color:red;'>Error en la consulta: " . $conexion->error . "</p>";
    }
} else {
    echo "<p style='color:red;'>Faltan datos del formulario.</p>";
}
?>
