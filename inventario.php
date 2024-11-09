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

// Agregar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombreProducto'])) {
    $nombreProducto = $_POST['nombreProducto'];
    $descripcion = $_POST['descripcionProducto'];
    $cantidad = $_POST['cantidadProducto'];
    $precioUnitario = $_POST['precioProducto'];
    $idProveedor = $_POST['proveedorSelect'];

    $sql = "INSERT INTO Inventario (nombre_producto, descripcion, cantidad, precio_unitario, id_proveedor) VALUES ('$nombreProducto', '$descripcion', '$cantidad', '$precioUnitario', '$idProveedor')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Producto agregado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al agregar producto: " . $conn->error]);
    }
    exit;
}

// Eliminar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    $sql = "DELETE FROM Inventario WHERE id_producto = '$delete_id'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Producto eliminado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar producto: " . $conn->error]);
    }
    exit;
}

// Editar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editIdProducto'])) {
    $idProducto = $_POST['editIdProducto'];
    $nombreProducto = $_POST['editNombreProducto'];
    $descripcion = $_POST['editDescripcion'];
    $cantidad = $_POST['editCantidad'];
    $precioUnitario = $_POST['editPrecioUnitario'];
    $idProveedor = $_POST['editIdProveedor'];

    $sql = "UPDATE Inventario SET nombre_producto='$nombreProducto', descripcion='$descripcion', cantidad='$cantidad', precio_unitario='$precioUnitario', id_proveedor='$idProveedor' WHERE id_producto='$idProducto'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Producto actualizado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar producto: " . $conn->error]);
    }
    exit;
}

// Obtener producto para editar
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    $sql = "SELECT * FROM Inventario WHERE id_producto = '$edit_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        echo json_encode($producto);
    } else {
        echo json_encode(["success" => false, "message" => "Producto no encontrado."]);
    }
    exit;
}

// Obtener productos con proveedores
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
