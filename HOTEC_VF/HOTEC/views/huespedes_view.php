<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: login_view.php");
    exit();
}

include("../config/conexion.php");

$busqueda = $_GET['busqueda'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Huéspedes - HOTEC</title>
    <link rel="stylesheet" href="../assets/css/dash.css">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>HOTEC</h2>

    <a href="habitaciones_view.php">Habitaciones</a>
    <a href="reservas_view.php">Reservas</a>
    <hr>
    <a href="../modules/auth/logout.php">Cerrar sesión</a>
    <hr>
</div>

<!-- MAIN -->
<div class="main">

<h1>Huéspedes Registrados</h1>

<hr>

<!-- BUSCADOR -->
<form method="GET" style="margin-bottom:20px;">
    <input 
        type="text" 
        name="busqueda" 
        placeholder="Buscar por nombre o documento..." 
        value="<?php echo $busqueda; ?>"
        style="padding:8px; width:300px;"
    >
    <button type="submit">Buscar</button>
</form>

<h2>Lista de Huéspedes</h2>

<?php

$sql = "SELECT * FROM huespedes";

if(!empty($busqueda)){
    $sql .= " WHERE nombre LIKE '%$busqueda%' 
              OR apellido LIKE '%$busqueda%' 
              OR documento LIKE '%$busqueda%'";
}

$sql .= " ORDER BY id_huesped DESC";

$result = $conn->query($sql);

if($result->num_rows > 0){

    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Documento</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Teléfono</th>
          </tr>";

    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>{$row['id_huesped']}</td>
                <td>{$row['documento']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['apellido']}</td>
                <td>{$row['email']}</td>
                <td>{$row['telefono']}</td>
              </tr>";
    }

    echo "</table>";

} else {
    echo "<p>No se encontraron huéspedes.</p>";
}
?>

</div>

</body>
</html>