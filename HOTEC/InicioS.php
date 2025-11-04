<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "hotec");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if (!empty($_POST['correo_e']) && !empty($_POST['contrasena'])) {
    $correo_e = $_POST['correo_e'];
    $contrasena = $_POST['contrasena'];

    $stmt = $conexion->prepare("SELECT ID_User, contrasena FROM usuarios WHERE correo_e = ?");
    if (!$stmt) {
        die("Error en prepare: " . $conexion->error);
    }

    $stmt->bind_param("s", $correo_e);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if ($contrasena === $usuario['contrasena']) {
            $_SESSION['ID_User'] = $usuario['ID_User'];
            echo "<script>alert('Inicio de sesión exitoso, Bienvenido otra vez!!'); window.location.href='HOTEC_PW.html';</script>";
        } else {
            echo "<script>alert('La Contraseña es incorrecta, por favor ingresala otra vez :/'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Correo no encontrado'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Por favor complete todos los campos'); window.history.back();</script>";
}

$conexion->close();
?>
