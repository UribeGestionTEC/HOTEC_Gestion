<?php
$conexion = new mysqli("localhost", "root", "", "hotec");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

function registrarHabitacion($conexion) {
    $numero = $_POST['numero'];
    $tipo = $_POST['tipo'];
    $num_h = $_POST['num_h'];

    $verificar = $conexion->prepare("SELECT * FROM habitacion WHERE numero = ?");
    $verificar->bind_param("s", $numero);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>alert('La habitación ya está registrada.');</script>";
    } else {
        $stmt = $conexion->prepare("INSERT INTO habitacion (numero, tipo, estado, num_huespedes) VALUES (?, ?, 'Disponible', ?)");
        $stmt->bind_param("ssi", $numero, $tipo, $num_h);
        $stmt->execute();
    }
}

function cambiarEstado($conexion, $id_habitacion, $nuevo_estado) {
    $stmt = $conexion->prepare("UPDATE habitacion SET estado = ? WHERE id_habitacion = ?");
    $stmt->bind_param("si", $nuevo_estado, $id_habitacion);
    $stmt->execute();
}

function mostrarTabla() {
    global $conexion;
    $resultado = $conexion->query("SELECT * FROM habitacion");
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
            <td>{$fila['id_habitacion']}</td>
            <td>{$fila['numero']}</td>
            <td>{$fila['tipo']}</td>
            <td>{$fila['num_huespedes']}</td>
            <td>{$fila['estado']}</td>
            <td>
                <form method='POST'>
                    <input type='hidden' name='id_habitacion' value='{$fila["id_habitacion"]}'>
                    <button type='submit' name='cambiar_estado' value='" . ($fila["estado"] == "Disponible" ? "Ocupada" : "Disponible") . "'>
                        Cambiar a " . ($fila["estado"] == "Disponible" ? "Ocupada" : "Disponible") . "
                    </button>
                </form>
            </td>
        </tr>";
    }
}

function mostrarOpcionesDisponibles() {
    global $conexion;
    $resultado = $conexion->query("SELECT numero FROM habitacion WHERE estado = 'Disponible'");
    while ($fila = $resultado->fetch_assoc()) {
        echo "<option value='{$fila["numero"]}'>{$fila["numero"]}</option>";
    }
}
?>
