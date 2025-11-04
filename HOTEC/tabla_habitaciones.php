<?php
$conn = new mysqli("localhost", "root", "", "hotec");
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

// Mostrar la tabla
$sql = "SELECT numero, tipo, estado, num_huespedes FROM habitaciones ORDER BY numero ASC";
$result = $conn->query($sql);


echo "<table border='1'>
<tr>
  <th>Número</th>
  <th>Tipo</th>
  <th>Estado</th>
  <th>Huéspedes</th>
  <th>Acción</th>
</tr>";

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['numero']}</td>
                <td>{$row['tipo']}</td>
                <td>{$row['estado']}</td>
                <td>{$row['num_huespedes']}</td>
                <td>";

        if ($row["estado"] == "Ocupada") {
            echo "<form method='POST' action='R_Habit.php' onsubmit='return confirm(\"¿Seguro que quieres liberar la habitación?\")'>
                    <input type='hidden' name='numero' value='{$row['numero']}'>
                    <input type='hidden' name='accion' value='liberar'>
                    <button type='submit'>Liberar</button>
                  </form>";
        } else {
            echo "-";
        }

        echo "</td></tr>";
    }
} else {
    echo "<tr><td colspan='5'>No hay habitaciones registradas.</td></tr>";
}

echo "</table>";
$conn->close();
?>
