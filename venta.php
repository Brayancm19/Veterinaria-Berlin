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

// Obtener datos del carrito y el cliente desde la solicitud POST
$carrito = isset($_POST['carrito']) ? $_POST['carrito'] : [];
$idCliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : null;

$response = ["success" => false];

// Verificar que se ha seleccionado un cliente
if (!$idCliente) {
    $response["error"] = "Cliente no seleccionado";
    echo json_encode($response);
    exit;
}

// Iniciar una transacción
$conn->begin_transaction();

try {
    $totalVenta = 0;

    // Procesar cada producto del carrito
    foreach ($carrito as $producto) {
        $idProducto = $producto['id_producto'];
        $cantidad = $producto['cantidad'];
        $precioUnitario = $producto['precio_unitario'];
        $totalProducto = $cantidad * $precioUnitario;
        $totalVenta += $totalProducto;

        // Registrar la venta
        $sqlVenta = "INSERT INTO Ventas (id_cliente, id_producto, cantidad, total, fecha_venta) VALUES ('$idCliente', '$idProducto', '$cantidad', '$totalProducto', NOW())";
        if (!$conn->query($sqlVenta)) {
            throw new Exception("Error al registrar la venta: " . $conn->error);
        }

        // Obtener el id_venta generado
        $idVenta = $conn->insert_id;

        // Registrar el pago
        $metodoPago = "Tarjeta"; // Puedes ajustar esto según lo que se reciba en la solicitud
        $sqlPago = "INSERT INTO Pagos (id_venta, metodo_pago, fecha_pago, monto) VALUES ('$idVenta', '$metodoPago', NOW(), '$totalProducto')";
        if (!$conn->query($sqlPago)) {
            throw new Exception("Error al registrar el pago: " . $conn->error);
        }

        // Actualizar inventario
        $sqlActualizarInventario = "UPDATE Inventario SET cantidad = cantidad - '$cantidad' WHERE id_producto = '$idProducto'";
        if (!$conn->query($sqlActualizarInventario)) {
            throw new Exception("Error al actualizar el inventario para el producto ID $idProducto: " . $conn->error);
        }
    }

    // Confirmar la transacción
    $conn->commit();

    $response["success"] = true;
} catch (Exception $e) {
    // Deshacer la transacción en caso de error
    $conn->rollback();
    $response["error"] = "Error: " . $e->getMessage();

    // Registrar el error en un archivo de log
    error_log($e->getMessage(), 3, "errores.log");
}

// Devolver la respuesta
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
