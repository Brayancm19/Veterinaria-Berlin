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

// Intentar obtener ventas detalladas y capturar cualquier excepción
try {
    $sql = "SELECT v.id_venta, c.nombre AS cliente, 
                   IFNULL(p.nombre_producto, s.nombre_servicio) AS producto, 
                   v.cantidad, v.total, v.fecha_venta
            FROM Ventas v
            LEFT JOIN Clientes c ON v.id_cliente = c.id_cliente
            LEFT JOIN Inventario p ON v.id_producto = p.id_producto
            LEFT JOIN Servicios s ON v.id_producto = s.id_servicio";
    $result = $conn->query($sql);

    $ventas = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ventas[] = $row;
        }
    }

    echo json_encode(["ventas" => $ventas], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Capturar errores y devolver un mensaje JSON
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

$conn->close();
?>
