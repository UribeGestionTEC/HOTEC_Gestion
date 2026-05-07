<?php
include("../../config/conexion.php");

$id = $_POST['id_habitacion'];
$estado = $_POST['estado'];

$sql = "UPDATE habitaciones SET estado=? WHERE id_habitacion=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $estado, $id);

if($stmt->execute()){
    header("Location: ../../views/habitaciones_view.php");
} else {
    echo "Error";
}
?>