<?php
$conn = new mysqli("localhost", "root", "", "hotec");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($conn->real_escape_string($_POST['nombre']));
    $apellido = trim($conn->real_escape_string($_POST['apellido']));
    $ID_Reserva = (int)$_POST['ID_Reserva'];
    $fecha = trim($conn->real_escape_string($_POST['fecha']));

    // Nueva consulta directa a la tabla reserva
    $consulta = "SELECT * FROM reserva 
                 WHERE id_reserva = '$ID_Reserva'
                 AND LOWER(nombre) = LOWER('$nombre')
                 AND LOWER(apellido) = LOWER('$apellido')
                 AND check_out = '$fecha'";

    $resultado = $conn->query($consulta);

    if ($resultado->num_rows > 0) {
        $eliminar = "DELETE FROM reserva WHERE id_reserva = '$ID_Reserva'";
        if ($conn->query($eliminar) === TRUE) {
            echo "<script>alert('Check-Out realizado con éxito.'); window.location.href='HOTEC.html';</script>";
        } else {
            echo "<script>alert('Error al eliminar la reserva.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No se encontró una reserva con los datos proporcionados.'); window.history.back();</script>";
    }

    $conn->close();
}
?>
