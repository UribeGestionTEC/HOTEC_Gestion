<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: login_view.php");
    exit();
}

include("../config/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas - HOTEC</title>
    <link rel="stylesheet" href="../assets/css/dash.css">
</head>

<body>

<div class="sidebar">
    <h2>HOTEC</h2>

    <a href="huespedes_view.php">Huéspedes</a>
    <a href="habitaciones_view.php">Habitaciones</a>
    <hr>
    <a href="../modules/auth/logout.php">Cerrar sesión</a>
</div>

<div class="main">

    <h1>Reservas</h1>

    <hr>

    <h2>Lista de Reservas</h2>

    <a class="btn" href="../modules/reservas/form_reserva.php">
        ➕ Nueva Reserva
    </a>

    <?php

    $sql = "
    SELECT r.id_reserva, r.estado, r.fecha_entrada, r.fecha_salida,
           h.nombre, h.apellido,
           hab.numero
    FROM reservas r
    JOIN huespedes h ON r.id_huesped = h.id_huesped
    JOIN reserva_habitacion rh ON r.id_reserva = rh.id_reserva
    JOIN habitaciones hab ON rh.id_habitacion = hab.id_habitacion
    ORDER BY r.id_reserva DESC
    ";

    $result = $conn->query($sql);

    if($result->num_rows > 0){

        echo "<table>";

        echo "<tr>
                <th>ID</th>
                <th>Huésped</th>
                <th>Habitación</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>";

        while($row = $result->fetch_assoc()){

            echo "<tr>";

            echo "<td>{$row['id_reserva']}</td>";
            echo "<td>{$row['nombre']} {$row['apellido']}</td>";
            echo "<td>{$row['numero']}</td>";
            echo "<td>{$row['fecha_entrada']}</td>";
            echo "<td>{$row['fecha_salida']}</td>";
            echo "<td>{$row['estado']}</td>";

            echo "<td>";

            // CHECK-IN
            if($row['estado'] == 'pendiente'){

                echo "
                <form method='POST' action='../modules/reservas/checkin.php'>
                    <input type='hidden' name='id_reserva' value='{$row['id_reserva']}'>
                    <button type='submit'>Check-in</button>
                </form>
                ";
            }

            // CHECK-OUT
            elseif($row['estado'] == 'confirmada'){

                echo "
                <form method='POST' action='../modules/reservas/checkout.php'>
                    <input type='hidden' name='id_reserva' value='{$row['id_reserva']}'>
                    <button type='submit'>Check-out</button>
                </form>
                ";
            }

            else{
                echo "<span>Finalizada</span>";
            }

            echo "</td>";

            echo "</tr>";
        }

        echo "</table>";

    } else {
        echo "<p>No hay reservas registradas</p>";
    }

    ?>

</div>

</body>
</html>