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

// Obtener productos del inventario
$sql = "SELECT * FROM Inventario";
$result = $conn->query($sql);

$productos = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $productos .= "
        <tr>
            <td>{$row['id_producto']}</td>
            <td>{$row['nombre_producto']}</td>
            <td>{$row['descripcion']}</td>
            <td>{$row['precio_unitario']}</td>
            <td>{$row['cantidad']}</td>
            <td>
                <input type='number' min='1' max='{$row['cantidad']}' value='1' class='cantidad-producto' data-id='{$row['id_producto']}' step='1' title='Cantidad a comprar' placeholder='Cantidad' />
            </td>
            <td>
                <button class='btn btn-primary btn-sm agregar-carrito' data-id='{$row['id_producto']}' data-nombre='{$row['nombre_producto']}' data-descripcion='{$row['descripcion']}' data-precio='{$row['precio_unitario']}' data-cantidad='{$row['cantidad']}'>Agregar al Carrito</button>
            </td>
        </tr>
        ";
    }
} else {
    $productos = "<tr><td colspan='7'>No hay productos en el inventario</td></tr>";
}

echo $productos;

$conn->close();
?>
