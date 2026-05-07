<?php
include("../../config/conexion.php");

$habitaciones = $conn->query("
SELECT 
    h.id_habitacion,
    h.numero,
    th.nombre
FROM habitaciones h
JOIN tipos_habitacion th ON h.id_tipo = th.id_tipo
WHERE h.estado = 'disponible'
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Reserva - HOTEC</title>

    <link rel="stylesheet" href="../../assets/css/dash.css">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>HOTEC</h2>

    <a href="../../views/reservas_view.php">Reservas</a>
    <a href="../../views/huespedes_view.php">Huéspedes</a>
    <a href="../../views/habitaciones_view.php">Habitaciones</a>
    <hr>
    <a href="../../modules/auth/logout.php">Cerrar sesión</a>
</div>

<!-- MAIN -->
<div class="main">

<h1>Nueva Reserva</h1>

<div class="card">

<form method="POST" action="guardar.php">

    <h2>Datos del huésped</h2>

    <label>Tipo de documento</label>
    <select id="tipo_documento" name="tipo_documento" required>
        <option value="">Seleccione</option>
        <option value="INE">INE</option>
        <option value="PASAPORTE">Pasaporte</option>
        <option value="CONSULAR">Consular</option>
    </select>

    <label>Documento</label>
    <input type="text" id="documento" name="documento" required>

    <label>Nombre</label>
    <input type="text" id="nombre" name="nombre" required>

    <label>Apellido</label>
    <input type="text" id="apellido" name="apellido" required>

    <label>Email</label>
    <input type="email" id="email" name="email">

    <label>Teléfono</label>
    <input type="text" id="telefono" name="telefono">

    <label>Nacionalidad</label>
    <input type="text" id="nacionalidad" name="nacionalidad">

</div>

<div class="card">

    <h2>Datos de la reserva</h2>

    <label>Fecha entrada</label>
    <input type="date" name="fecha_entrada" required>

    <label>Fecha salida</label>
    <input type="date" name="fecha_salida" required>

    <label>Habitación disponible</label>
    <select name="id_habitacion" required>
        <?php while($hab = $habitaciones->fetch_assoc()){ ?>
            <option value="<?= $hab['id_habitacion'] ?>">
                <?= $hab['numero'] ?> - <?= $hab['nombre'] ?>
            </option>
        <?php } ?>
    </select>

    <input type="hidden" name="origen" value="online">

    <br><br>

    <button type="submit">Crear Reserva</button>

</form>

</div>

</div>

</body>
</html>