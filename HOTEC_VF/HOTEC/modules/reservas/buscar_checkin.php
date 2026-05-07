<?php
include("../../config/conexion.php");

header('Content-Type: application/json');

$documento = $_GET['documento'];
$tipo = $_GET['tipo'];

$sql = "
SELECT 
    r.id_reserva,
    r.fecha_entrada,
    r.fecha_salida,
    h.id_huesped,
    h.nombre,
    h.apellido,
    h.email,
    h.telefono,
    hab.numero
FROM reservas r
JOIN huespedes h ON r.id_huesped = h.id_huesped
JOIN reserva_habitacion rh ON r.id_reserva = rh.id_reserva
JOIN habitaciones hab ON rh.id_habitacion = hab.id_habitacion
WHERE h.documento = ? AND h.tipo_documento = ?
AND r.estado = 'pendiente'
LIMIT 1
";

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