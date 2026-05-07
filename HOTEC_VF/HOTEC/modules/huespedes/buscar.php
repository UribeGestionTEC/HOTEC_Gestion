<?php
include("../../config/conexion.php");

header('Content-Type: application/json');

$documento = $_GET['documento'] ?? '';
$tipo = $_GET['tipo'] ?? '';

$sql = "SELECT * FROM huespedes WHERE documento = ? AND tipo_documento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $documento, $tipo);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows > 0){
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(null);
}
?>