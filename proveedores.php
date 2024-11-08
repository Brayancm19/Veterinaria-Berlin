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

// Obtener proveedores para la lista desplegable
$sql = "SELECT * FROM Proveedores";
$result = $conn->query($sql);

$proveedores = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $proveedores .= "<option value='{$row['id_proveedor']}'>{$row['nombre']}</option>";
    }
} else {
    $proveedores = "<option value=''>No hay proveedores disponibles</option>";
}

echo $proveedores;

$conn->close();
?>
