<?php
include("../../config/conexion.php");

$numero = $_POST['numero'];
$id_tipo = $_POST['id_tipo'];
$estado = $_POST['estado'];

// Evitar duplicados de número
$check = $conn->prepare("SELECT id_habitacion FROM habitaciones WHERE numero = ?");
$check->bind_param("i", $numero);
$check->execute();
$res = $check->get_result();

if($res->num_rows > 0){
    echo "La habitación ya existe";
    exit();
}

$sql = "INSERT INTO habitaciones (numero, id_tipo, estado)
VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $numero, $id_tipo, $estado);

if($stmt->execute()){
    header("Location: ../../views/habitaciones_view.php");
} else {
    echo "Error al guardar";
}
?>