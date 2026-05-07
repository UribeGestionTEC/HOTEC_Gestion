<?php
include("../../config/conexion.php");
session_start();

if(!isset($_SESSION['id_usuario'])){
    die("No autorizado");
}

$id_reserva = intval($_POST['id_reserva']);

$conn->begin_transaction();

try {

    // 1. Buscar check-in
    $checkin = $conn->query("
        SELECT id_checkin 
        FROM check_in 
        WHERE id_reserva = $id_reserva
        ORDER BY id_checkin DESC 
        LIMIT 1
    ")->fetch_assoc();

    if(!$checkin){
        throw new Exception("No existe check-in para esta reserva");
    }

    $id_checkin = $checkin['id_checkin'];

    // 2. Crear check-out
    $conn->query("
        INSERT INTO check_out (id_checkin)
        VALUES ($id_checkin)
    ");

    // 3. Obtener habitación
    $hab = $conn->query("
        SELECT id_habitacion 
        FROM reserva_habitacion 
        WHERE id_reserva = $id_reserva
        LIMIT 1
    ")->fetch_assoc();

    $id_habitacion = $hab['id_habitacion'];

    // 4. Cambiar estado habitación
    $conn->query("
        UPDATE habitaciones 
        SET estado = 'limpieza'
        WHERE id_habitacion = $id_habitacion
    ");

    // 5. Marcar reserva como finalizada (NO cancelada)
    $conn->query("
        UPDATE reservas 
        SET estado = 'finalizada'
        WHERE id_reserva = $id_reserva
    ");

    $conn->commit();

    header("Location: ../../views/reservas_view.php");
    exit();

} catch(Exception $e){

    $conn->rollback();
    echo "Error en check-out: " . $e->getMessage();
}
?>