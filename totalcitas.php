<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "veterinaria_berlin";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el manejo de errores para devolver JSON válidos
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json');

// Intentar obtener las citas con sus montos y capturar cualquier excepción
try {
    $sql = "SELECT c.id_cita, cl.nombre AS cliente, s.nombre_servicio AS servicio, v.nombre AS veterinario, c.fecha_hora, s.precio AS monto
            FROM Citas c
            JOIN Clientes cl ON c.id_cliente = cl.id_cliente
            JOIN Servicios s ON c.id_servicio = s.id_servicio
            JOIN Veterinarios v ON c.id_veterinario = v.id_veterinario";
    $result = $conn->query($sql);

    $citas = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $citas[] = $row;
        }
    }

    echo json_encode(["citas" => $citas], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Capturar errores y devolver un mensaje JSON
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

$conn->close();
?>
