<?php
$conn = new mysqli("localhost", "root", "", "hotec");
if ($conn->connect_error) die("Conexión fallida");

$sql = "SELECT numero FROM habitaciones WHERE estado = 0 ORDER BY numero ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

$options = "";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='{$row['numero']}'>{$row['numero']}</option>";
}

echo $options;
$conn->close();
?>
