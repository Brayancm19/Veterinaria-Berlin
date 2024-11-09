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

// Obtener los clientes de la base de datos
$sql = "SELECT id_cliente, nombre, apellido FROM Clientes";
$result = $conn->query($sql);

$clientes = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
}

// Devolver los datos de los clientes en formato JSON
header('Content-Type: application/json');
echo json_encode($clientes, JSON_PRETTY_PRINT);

$conn->close();
?>
