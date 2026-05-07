<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: login_view.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard HOTEC</title>
    <link rel="stylesheet" href="../assets/css/dash.css">
</head>
<body>

<div class="sidebar">
    <h2>HOTEC</h2>

    <a href="huespedes_view.php">Huéspedes</a>
    <a href="habitaciones_view.php">Habitaciones</a>
    <a href="reservas_view.php">Reservas</a>

    <hr>

    <a href="../modules/auth/logout.php">Cerrar sesión</a>
</div>

<div class="main">
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>

    <p>Rol: <strong><?php echo $_SESSION['rol']; ?></strong></p>

    <div class="card">
        <h3>Resumen</h3>
        <p>Aquí podrás gestionar el sistema del hotel.</p>
    </div>
</div>

</body>
</html>