<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conexion = new mysqli("localhost", "root", "", "hotec");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    if (
        isset($_POST['numero']) && isset($_POST['tipo']) &&
        isset($_POST['estado']) && isset($_POST['num_h'])
    ) {
        $numero = $_POST['numero'];
        $tipo = $_POST['tipo'];
        $estado = $_POST['estado'];
        $num_h = intval($_POST['num_h']);

        // Verificar si ya existe la habitación
        $stmt = $conexion->prepare("SELECT ID_Habitacion FROM habitacion WHERE numero = ?");
        $stmt->bind_param("i", $numero);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Actualizamos
            $stmt = $conexion->prepare("UPDATE habitacion SET tipo = ?, estado = ?, num_huespedes = ? WHERE numero = ?");
            $stmt->bind_param("ssii", $tipo, $estado, $num_h, $numero);
        } else {
            // Insertamos
            $stmt = $conexion->prepare("INSERT INTO habitacion (numero, tipo, estado, num_huespedes) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("issi", $numero, $tipo, $estado, $num_h);
        }

        if ($stmt->execute()) {
            echo "<script>alert('¡Habitación registrada correctamente!');</script>";
        } else {
            echo "<script>alert('Error al registrar la habitación.');</script>";
        }

        $stmt->close();
        $conexion->close();
    } else {
        echo "<script>alert('Por favor complete todos los campos.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>HOTEC: Registro de Habitaciones</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="css/stylez.css">
</head>
<body>

<nav class="top-bar">
  <div class="top-bar-title">
    <img src="LogoH.png" alt="Logotipo" class="logo">
    <a href="#"><strong>Servicio HOTEC</strong></a>
  </div>
  <div class="topbar-responsive-links">
    <ul class="menu simple">
      <li><a href="HOTEC.html">Página Principal</a></li>
      <li><a href="LOGIN_HOTEC.html">Registro</a></li>
      <li><a href="INICIO_HOTEC.html">Iniciar Sesión</a></li>
    </ul>
  </div>
</nav>

<div class="hero-section">
  <div class="hero-section-text">
    <h1>Registro de Habitaciones</h1>
    <h5>Seleccione y registre el estado de las habitaciones</h5>
  </div>
</div>

<section class="translucent-form-overlay">
  <form id="form-registro" method="POST" action="">
    <label for="numero">Número de Habitación:</label>
    <select id="numero" name="numero" required>
      <option value="">Selecciona la habitación</option>
      <?php
      for ($i = 101; $i <= 105; $i++) echo "<option value='$i'>$i</option>";
      for ($i = 201; $i <= 205; $i++) echo "<option value='$i'>$i</option>";
      for ($i = 301; $i <= 305; $i++) echo "<option value='$i'>$i</option>";
      ?>
    </select>

    <label for="num_h">Número de Huéspedes:</label>
    <input type="number" id="num_h" name="num_h" placeholder="Huéspedes a Registrar" min="1" required>

    <label for="tipo">Tipo de habitación:</label>
    <select id="tipo" name="tipo" required>
      <option value="Simple">Simple</option>
      <option value="Doble">Doble</option>
      <option value="Suite">Suite</option>
    </select>

    <label for="estado">Estado:</label>
    <select id="estado" name="estado" required>
      <option value="Disponible">Disponible</option>
      <option value="Ocupada">Ocupada</option>
    </select>

    <button type="submit">Registrar</button>
  </form>
</section>

<h3>Estado Actual de Habitaciones</h3>
<table>
  <thead>
    <tr>
      <th>Código</th>
      <th>Número</th>
      <th>Tipo</th>
      <th>Huéspedes</th>
      <th>Estado</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $conexion = new mysqli("localhost", "root", "", "hotec");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT * FROM habitacion ORDER BY numero ASC";
    $result = $conexion->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['ID_Habitacion'] . "</td>";
        echo "<td>" . $row['numero'] . "</td>";
        echo "<td>" . $row['tipo'] . "</td>";
        echo "<td>" . $row['num_huespedes'] . "</td>";
        echo "<td>" . $row['estado'] . "</td>";
        echo "</tr>";
    }

    $conexion->close();
    ?>
  </tbody>
</table>

<footer>
  <p>&copy; 2025 HOTEC. Todos los derechos reservados.</p>
</footer>

</body>
</html>
