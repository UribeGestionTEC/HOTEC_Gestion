<?php
session_start();
include("../../config/conexion.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: login_view.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Check-in - HOTEC</title>

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

<h1>Check-in de Huésped</h1>

<div class="card">

<h2>Buscar reserva</h2>

<form id="formBusqueda">

    <label>Tipo documento</label>
    <select id="tipo_documento">
        <option value="INE">INE</option>
        <option value="PASAPORTE">Pasaporte</option>
        <option value="CONSULAR">Consular</option>
    </select>

    <label>Documento</label>
    <input type="text" id="documento">

    <br><br>

    <button type="button" onclick="buscarReserva()">Buscar reserva</button>

</form>

</div>

<!-- RESULTADO -->
<div class="card" id="resultado" style="display:none; margin-top:20px;">

<h2>Datos de la reserva</h2>

<form method="POST" action="../../modules/reservas/procesar_checkin.php">

    <input type="hidden" name="id_reserva" id="id_reserva">
    <input type="hidden" name="id_huesped" id="id_huesped">

    <p><b>Huésped:</b> <span id="nombre_completo"></span></p>
    <p><b>Habitación:</b> <span id="habitacion"></span></p>
    <p><b>Fechas:</b> <span id="fechas"></span></p>

    <hr>

    <label>Email (actualizable)</label>
    <input type="text" name="email" id="email">

    <label>Teléfono (actualizable)</label>
    <input type="text" name="telefono" id="telefono">

    <br><br>

    <button type="submit">Confirmar Check-in</button>

</form>

</div>

</div>

<script>
function buscarReserva(){

    let documento = document.getElementById('documento').value;
    let tipo = document.getElementById('tipo_documento').value;

    if(documento === '' || tipo === '') return;

    fetch(`../../modules/reservas/buscar_checkin.php?documento=${documento}&tipo=${tipo}`)
    .then(res => res.json())
    .then(data => {

        if(data){

            document.getElementById('resultado').style.display = 'block';

            document.getElementById('id_reserva').value = data.id_reserva;
            document.getElementById('id_huesped').value = data.id_huesped;

            document.getElementById('nombre_completo').innerText =
                data.nombre + " " + data.apellido;

            document.getElementById('habitacion').innerText = data.numero;

            document.getElementById('fechas').innerText =
                data.fecha_entrada + " → " + data.fecha_salida;

            document.getElementById('email').value = data.email || '';
            document.getElementById('telefono').value = data.telefono || '';

        } else {
            alert("No se encontró ninguna reserva activa");
        }

    });

}
</script>

</body>
</html>