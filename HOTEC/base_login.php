<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "HOTEC");



if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$contrasena = $_POST['password'];


$sql = "INSERT INTO usuarios (nombre, apellido, correo_e, contrasena)
        VALUES ('$nombre', '$apellido', '$correo', '$contrasena')";

if ($conexion->query($sql) === TRUE) {
    header("Location: HOTEC_PW.html"); // Redirige después del registro
    exit();

    $stmt->close();
} else {
    echo "<script>alert('Error: Este correo ya esta registrado!!!'); window.history.back();</script>";
}

$conexion->close();
?>

