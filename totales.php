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

// Intentar obtener los datos de ventas y citas, capturando cualquier excepción
try {
    // Obtener el total de ventas
    $sql_ventas = "SELECT SUM(v.total) AS total_ventas
                   FROM Ventas v";
    $result_ventas = $conn->query($sql_ventas);

    $total_ventas = 0;
    if ($result_ventas->num_rows > 0) {
        $row = $result_ventas->fetch_assoc();
        $total_ventas = $row['total_ventas'] !== null ? (float)$row['total_ventas'] : 0;
    }

    // Obtener el total de citas
    $sql_citas = "SELECT SUM(s.precio) AS total_citas
                  FROM Citas c
                  JOIN Servicios s ON c.id_servicio = s.id_servicio";
    $result_citas = $conn->query($sql_citas);

    $total_citas = 0;
    if ($result_citas->num_rows > 0) {
        $row = $result_citas->fetch_assoc();
        $total_citas = $row['total_citas'] !== null ? (float)$row['total_citas'] : 0;
    }

    $total_general = $total_ventas + $total_citas;

    echo json_encode([
        "total_ventas" => $total_ventas,
        "total_citas" => $total_citas,
        "total_general" => $total_general
    ], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Capturar errores y devolver un mensaje JSON
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

$conn->close();
?>
