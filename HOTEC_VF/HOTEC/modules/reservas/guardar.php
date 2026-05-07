<?php
include("../../config/conexion.php");

// ======================
// DATOS DEL FORMULARIO
// ======================
$tipo_documento = $_POST['tipo_documento'];
$documento      = $_POST['documento'];

$nombre     = $_POST['nombre'];
$apellido   = $_POST['apellido'];
$email      = $_POST['email'];
$telefono   = $_POST['telefono'];
$nacionalidad = $_POST['nacionalidad'];

$fecha_entrada = $_POST['fecha_entrada'];
$fecha_salida  = $_POST['fecha_salida'];

$id_habitacion = $_POST['id_habitacion'];
$origen        = $_POST['origen'];

$conn->begin_transaction();

try {

    // ======================
    // 1. BUSCAR HUESPED
    // ======================
    $stmt = $conn->prepare("
        SELECT id_huesped, email, telefono 
        FROM huespedes 
        WHERE documento = ? AND tipo_documento = ?
    ");
    $stmt->bind_param("ss", $documento, $tipo_documento);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){

        // ======================
        // EXISTE → ACTUALIZAR
        // ======================
        $huesped = $result->fetch_assoc();
        $id_huesped = $huesped['id_huesped'];

        $update = $conn->prepare("
            UPDATE huespedes 
            SET nombre = ?, apellido = ?, email = ?, telefono = ?, nacionalidad = ?
            WHERE id_huesped = ?
        ");
        $update->bind_param(
            "sssssi",
            $nombre,
            $apellido,
            $email,
            $telefono,
            $nacionalidad,
            $id_huesped
        );
        $update->execute();

    } else {

        // ======================
        // NO EXISTE → CREAR
        // ======================
        $insert = $conn->prepare("
            INSERT INTO huespedes 
            (tipo_documento, documento, nombre, apellido, email, telefono, nacionalidad)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $insert->bind_param(
            "sssssss",
            $tipo_documento,
            $documento,
            $nombre,
            $apellido,
            $email,
            $telefono,
            $nacionalidad
        );
        $insert->execute();

        $id_huesped = $conn->insert_id;
    }

    // ======================
    // 2. CREAR RESERVA
    // ======================
    $reserva = $conn->prepare("
        INSERT INTO reservas 
        (id_huesped, fecha_entrada, fecha_salida, estado, origen)
        VALUES (?, ?, ?, 'pendiente', ?)
    ");
    $reserva->bind_param(
        "isss",
        $id_huesped,
        $fecha_entrada,
        $fecha_salida,
        $origen
    );
    $reserva->execute();

    $id_reserva = $conn->insert_id;

    // ======================
    // 3. ASIGNAR HABITACIÓN
    // ======================
    $hab = $conn->prepare("
        INSERT INTO reserva_habitacion (id_reserva, id_habitacion)
        VALUES (?, ?)
    ");
    $hab->bind_param("ii", $id_reserva, $id_habitacion);
    $hab->execute();

    // ======================
    // 4. OCUPAR HABITACIÓN
    // ======================
    $conn->query("
        UPDATE habitaciones 
        SET estado = 'ocupada'
        WHERE id_habitacion = $id_habitacion
    ");

    $conn->commit();

    header("Location: ../../views/reservas_view.php");
    exit();

} catch(Exception $e){
    $conn->rollback();
    echo "Error en reserva: " . $e->getMessage();
}
?>