<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "veterinaria_berlin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombreProducto'])) {
    $nombreProducto = $_POST['nombreProducto'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precioUnitario = $_POST['precioUnitario'];
    $idProveedor = $_POST['idProveedor'];

    $sql = "INSERT INTO Inventario (nombre_producto, descripcion, cantidad, precio_unitario, id_proveedor) VALUES ('$nombreProducto', '$descripcion', '$cantidad', '$precioUnitario', '$idProveedor')";
    $conn->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    $sql = "DELETE FROM Inventario WHERE id_producto = '$delete_id'";
    $conn->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editIdProducto'])) {
    $idProducto = $_POST['editIdProducto'];
    $nombreProducto = $_POST['editNombreProducto'];
    $descripcion = $_POST['editDescripcion'];
    $cantidad = $_POST['editCantidad'];
    $precioUnitario = $_POST['editPrecioUnitario'];
    $idProveedor = $_POST['editIdProveedor'];

    $sql = "UPDATE Inventario SET nombre_producto='$nombreProducto', descripcion='$descripcion', cantidad='$cantidad', precio_unitario='$precioUnitario', id_proveedor='$idProveedor' WHERE id_producto='$idProducto'";
    $conn->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    $sql = "SELECT * FROM Inventario WHERE id_producto = '$edit_id'";
    $result = $conn->query($sql);
    $producto = $result->fetch_assoc();

    echo json_encode($producto);
    exit;
}

$sql = "SELECT i.*, p.nombre AS nombre_proveedor FROM Inventario i LEFT JOIN Proveedores p ON i.id_proveedor = p.id_proveedor";
$result = $conn->query($sql);

$productos = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $productos .= "
        <tr>
            <td>{$row['id_producto']}</td>
            <td>{$row['nombre_producto']}</td>
            <td>{$row['descripcion']}</td>
            <td>{$row['cantidad']}</td>
            <td>{$row['precio_unitario']}</td>
            <td>{$row['nombre_proveedor']}</td>
            <td>
                <button class='btn btn-warning edit-btn' data-id='{$row['id_producto']}'>Editar</button>
                <button class='btn btn-danger delete-btn' data-id='{$row['id_producto']}'>Eliminar</button>
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
