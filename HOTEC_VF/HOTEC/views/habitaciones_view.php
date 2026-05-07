<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: login_view.php");
    exit();
}

include("../config/conexion.php");

// Filtro
$filtro = $_GET['filtro'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitaciones - HOTEC</title>
    <link rel="stylesheet" href="../assets/css/dash.css">
</head>

<body>

<!-- SIDEBAR (si ya la usas en dashboard, aquí la mantenemos igual) -->
<div class="sidebar">
    <h2>HOTEC</h2>

    <a href="huespedes_view.php">Huéspedes</a>
    <a href="reservas_view.php">Reservas</a>
    <hr>
    <a href="../modules/auth/logout.php">Cerrar sesión</a>
</div>

<!-- CONTENIDO PRINCIPAL -->
<div class="main">

    <h1>Panel de Habitaciones</h1>

    <hr>

    <!-- FILTRO -->
    <h3>Filtrar habitaciones</h3>

    <form method="GET">
        <label>Estado:</label>
        <select name="filtro">
            <option value="">Todos</option>
            <option value="disponible">Disponible</option>
            <option value="ocupada">Ocupada</option>
            <option value="limpieza">Limpieza</option>
            <option value="mantenimiento">Mantenimiento</option>
        </select>

        <button type="submit">Filtrar</button>
    </form>

    <hr>

    <!-- FORMULARIO -->
    <h2>Registrar Habitación</h2>

    <form action="../modules/habitaciones/guardar.php" method="POST">

        <label>Número</label>
        <input type="number" name="numero" required>

        <label>Tipo</label>
        <select name="id_tipo" required>
            <?php
            $tipos = $conn->query("SELECT * FROM tipos_habitacion");
            while($t = $tipos->fetch_assoc()){
                echo "<option value='{$t['id_tipo']}'>{$t['nombre']}</option>";
            }
            ?>
        </select>

        <label>Estado inicial</label>
        <select name="estado">
            <option value="disponible">Disponible</option>
            <option value="limpieza">Limpieza</option>
            <option value="mantenimiento">Mantenimiento</option>
        </select>

        <button type="submit">Guardar habitación</button>
    </form>

    <hr>

    <!-- LISTA -->
    <h2>Lista de Habitaciones</h2>

    <?php

    if($filtro){
        $sql = "
        SELECT h.id_habitacion, h.numero, h.estado, t.nombre AS tipo
        FROM habitaciones h
        JOIN tipos_habitacion t ON h.id_tipo = t.id_tipo
        WHERE h.estado = '$filtro'
        ORDER BY h.numero
        ";
    } else {
        $sql = "
        SELECT h.id_habitacion, h.numero, h.estado, t.nombre AS tipo
        FROM habitaciones h
        JOIN tipos_habitacion t ON h.id_tipo = t.id_tipo
        ORDER BY h.numero
        ";
    }

    $result = $conn->query($sql);

    if($result->num_rows > 0){

        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Número</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>";

        while($row = $result->fetch_assoc()){

            echo "<tr>";

            echo "<td>{$row['id_habitacion']}</td>";
            echo "<td>{$row['numero']}</td>";
            echo "<td>{$row['tipo']}</td>";
            echo "<td>{$row['estado']}</td>";

            echo "<td>";

            echo "<form method='POST' action='../modules/habitaciones/cambiar_estado.php'>";
            echo "<input type='hidden' name='id_habitacion' value='{$row['id_habitacion']}'>";

            if($row['estado'] == 'disponible'){

                echo "
                <button name='estado' value='limpieza'>Limpieza</button>
                <button name='estado' value='mantenimiento'>Mantenimiento</button>
                ";
            }
            elseif($row['estado'] == 'limpieza'){

                echo "
                <button name='estado' value='disponible'>Disponible</button>
                <button name='estado' value='mantenimiento'>Mantenimiento</button>
                ";
            }
            elseif($row['estado'] == 'mantenimiento'){

                echo "
                <button name='estado' value='disponible'>Disponible</button>
                ";
            }
            else{
                echo "Sin acciones";
            }

            echo "</form>";

            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";

    } else {
        echo "No hay habitaciones registradas";
    }

    ?>

</div>

</body>
</html>