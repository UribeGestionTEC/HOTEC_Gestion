<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar - HOTEC</title>

    <link rel="stylesheet" href="assets/css/main.css"> 
</head>

<body>

<h1>Reservar Habitación</h1>

<a class="btn-volver" href="index.html">← Volver al inicio</a>

<hr>

<form action="modules/reservas/guardar.php" method="POST">

    <!-- =========================
         DATOS DEL HUÉSPED
    ========================== -->

    <h2>Datos del huésped</h2>

    <label>Tipo de documento:</label>
    <select name="tipo_documento" required>
        <option value="INE">INE</option>
        <option value="PASAPORTE">Pasaporte</option>
        <option value="CONSULAR">Consular</option>
    </select>

    <br><br>

    <label>Número de documento:</label>
    <input type="text" name="documento" required>

    <br><br>

    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <br><br>

    <label>Apellido:</label>
    <input type="text" name="apellido" required>

    <br><br>

    <label>Email:</label>
    <input type="email" name="email" required>

    <br><br>

    <label>Teléfono:</label>
    <input type="text" name="telefono" required>

    <br><br>

    <label>Nacionalidad:</label>
    <input type="text" name="nacionalidad" required>

    <hr>

    <!-- =========================
         RESERVA
    ========================== -->

    <h2>Datos de la reserva</h2>

    <label>Fecha entrada:</label>
    <input type="date" name="fecha_entrada" required>

    <br><br>

    <label>Fecha salida:</label>
    <input type="date" name="fecha_salida" required>

    <br><br>

    <label>Tipo de habitación:</label>
    <select name="id_tipo" required>

        <?php
        include("config/conexion.php");

        $tipos = $conn->query("SELECT * FROM tipos_habitacion");

        while($t = $tipos->fetch_assoc()){
            echo "<option value='{$t['id_tipo']}'>{$t['nombre']}</option>";
        }
        ?>

    </select>
    
    <input type="hidden" name="origen" value="online">

    <br><br>

    <button type="submit">
        Confirmar Reserva
    </button>

</form>

</body>
</html>