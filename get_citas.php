<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "veterinaria_berlin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$query = "SELECT c.id_cita, cl.nombre AS nombre_cliente, cl.apellido AS apellido_cliente, m.nombre_mascota, s.nombre_servicio, v.nombre AS nombre_veterinario, c.fecha_hora, c.estado
          FROM Citas c
          JOIN Clientes cl ON c.id_cliente = cl.id_cliente
          JOIN Mascotas m ON c.id_mascota = m.id_mascota
          JOIN Servicios s ON c.id_servicio = s.id_servicio
          JOIN Veterinarios v ON c.id_veterinario = v.id_veterinario";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id_cita']}</td>";
        echo "<td>{$row['nombre_cliente']} {$row['apellido_cliente']}</td>";
        echo "<td>{$row['nombre_mascota']}</td>";
        echo "<td>{$row['nombre_servicio']}</td>";
        echo "<td>{$row['nombre_veterinario']}</td>";
        echo "<td>{$row['fecha_hora']}</td>";
        echo "<td>{$row['estado']}</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No hay citas programadas</td></tr>";
}

$conn->close();
?>
