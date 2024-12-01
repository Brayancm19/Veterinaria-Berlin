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

// Agregar proveedor y contactos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombreProveedor'])) {
    $nombreProveedor = $_POST['nombreProveedor'];
    $telefonoProveedor = $_POST['telefonoProveedor'];

    $direccionProveedor = $_POST['direccionProveedor'];

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Insertar proveedor
        $sql = "INSERT INTO Proveedores (nombre, direccion) VALUES ('$nombreProveedor', '$direccionProveedor')";
        if (!$conn->query($sql)) {
            throw new Exception("Error al insertar proveedor: " . $conn->error);
        }
        $idProveedor = $conn->insert_id; // Obtener el ID del proveedor insertado

        // Insertar contactos del proveedor
        $sqlTelefono = "INSERT INTO Medio_Contacto (tipo_contacto, valor_contacto) VALUES ('Telefono', '$telefonoProveedor')";
        if (!$conn->query($sqlTelefono)) {
            throw new Exception("Error al insertar teléfono: " . $conn->error);
        }
        $idContactoTelefono = $conn->insert_id;

        $sqlEmail = "INSERT INTO Medio_Contacto (tipo_contacto, valor_contacto) VALUES ('Email', '$emailProveedor')";
        if (!$conn->query($sqlEmail)) {
            throw new Exception("Error al insertar email: " . $conn->error);
        }
        $idContactoEmail = $conn->insert_id;

        // Relacionar contactos con el proveedor
        $sqlRelacionTelefono = "INSERT INTO Proveedor_Contacto (id_proveedor, id_contacto) VALUES ('$idProveedor', '$idContactoTelefono')";
        if (!$conn->query($sqlRelacionTelefono)) {
            throw new Exception("Error al insertar relación proveedor-teléfono: " . $conn->error);
        }

        $sqlRelacionEmail = "INSERT INTO Proveedor_Contacto (id_proveedor, id_contacto) VALUES ('$idProveedor', '$idContactoEmail')";
        if (!$conn->query($sqlRelacionEmail)) {
            throw new Exception("Error al insertar relación proveedor-email: " . $conn->error);
        }

        // Confirmar la transacción
        $conn->commit();

        echo json_encode(["success" => true, "message" => "Proveedor y contactos agregados correctamente."]);
    } catch (Exception $e) {
        // Deshacer la transacción en caso de error
        $conn->rollback();
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

// Obtener proveedores y sus contactos para la tabla
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['edit_id'])) {
    $sql = "SELECT p.id_proveedor, p.nombre, mc1.valor_contacto AS telefono, mc2.valor_contacto AS email, p.direccion 
            FROM Proveedores p
            LEFT JOIN Proveedor_Contacto pc1 ON p.id_proveedor = pc1.id_proveedor
            LEFT JOIN Medio_Contacto mc1 ON pc1.id_contacto = mc1.id_contacto AND mc1.tipo_contacto = 'Telefono'
            LEFT JOIN (SELECT id_proveedor, id_contacto FROM Proveedor_Contacto) pc2 ON p.id_proveedor = pc2.id_proveedor
            LEFT JOIN Medio_Contacto mc2 ON pc2.id_contacto = mc2.id_contacto AND mc2.tipo_contacto = 'Email'
            GROUP BY p.id_proveedor";
    $result = $conn->query($sql);

    $proveedores = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $proveedores[] = $row;
        }
    }

    echo json_encode($proveedores, JSON_PRETTY_PRINT);
}

$conn->close();
?>
