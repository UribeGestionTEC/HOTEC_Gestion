<?php
session_start();

// Si ya inició sesión, redirigir
if(isset($_SESSION['id_usuario'])){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login HOTEC</title>
    <link rel="stylesheet" href="../assets/css/dash.css">
</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        <h2>HOTEC</h2>
        <p>Acceso de personal</p>

        <form action="../modules/auth/login.php" method="POST">

            <label>Correo</label>
            <input type="email" name="email" placeholder="ejemplo@email.com" required>

            <label>Contraseña</label>
            <input type="password" name="password" placeholder="••••••••" required>

            <button type="submit" name="login">Iniciar sesión</button>

        </form>

    </div>

</div>

</body>
</html>