<?php
$conn = new mysqli("localhost", "root", "", "hotec");
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion"])) {
    $accion = $_POST["accion"];
    $numero = (int)$_POST["numero"];

    if ($accion === "registrar") {
        $tipo = $_POST["tipo"];
        $num_h = (int)$_POST["num_h"];
        $estado = "Ocupada"; // Texto en vez de número

        $sql = "UPDATE habitaciones SET tipo = ?, estado = ?, num_huespedes = ? WHERE numero = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) die("Error al preparar la consulta: " . $conn->error);

        $stmt->bind_param("ssii", $tipo, $estado, $num_h, $numero);
        if ($stmt->execute()) {
            echo "<script>alert('Habitación registrada correctamente.'); window.location.href='GH_Hotec.html';</script>";
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();

    } elseif ($accion === "liberar") {
        $estado = "Disponible";

        $sql = "UPDATE habitaciones SET estado = ?, num_huespedes = 0 WHERE numero = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) die("Error al preparar la consulta: " . $conn->error);

        $stmt->bind_param("si", $estado, $numero);
        if ($stmt->execute()) {
            echo "<script>alert('Habitación liberada.'); window.location.href='GH_Hotec.html';</script>";
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>
