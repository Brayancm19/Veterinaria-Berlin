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

// Obtener datos del cliente desde la solicitud POST
$nombreCliente = isset($_POST['nombreCliente']) ? $_POST['nombreCliente'] : '';
$apellidoCliente = isset($_POST['apellidoCliente']) ? $_POST['apellidoCliente'] : '';
$direccionCliente = isset($_POST['direccionCliente']) ? $_POST['direccionCliente'] : '';
$telefonoCliente = isset($_POST['telefonoCliente']) ? $_POST['telefonoCliente'] : '';
$emailCliente = isset($_POST['emailCliente']) ? $_POST['emailCliente'] : '';

$response = ["success" => false];

// Iniciar una transacción
$conn->begin_transaction();

try {
    // Insertar cliente
    $sqlCliente = "INSERT INTO Clientes (nombre, apellido, direccion) VALUES ('$nombreCliente', '$apellidoCliente', '$direccionCliente')";
    if (!$conn->query($sqlCliente)) {
        throw new Exception("Error al insertar cliente: " . $conn->error);
    }
    $idCliente = $conn->insert_id;

    // Insertar medio de contacto (teléfono)
    $sqlTelefono = "INSERT INTO Medio_Contacto (tipo_contacto, valor_contacto) VALUES ('Telefono', '$telefonoCliente')";
    if (!$conn->query($sqlTelefono)) {
        throw new Exception("Error al insertar teléfono: " . $conn->error);
    }
    $idTelefono = $conn->insert_id;

    // Insertar relación cliente-contacto (teléfono)
    $sqlClienteTelefono = "INSERT INTO Cliente_Contacto (id_cliente, id_contacto) VALUES ('$idCliente', '$idTelefono')";
    if (!$conn->query($sqlClienteTelefono)) {
        throw new Exception("Error al insertar relación cliente-teléfono: " . $conn->error);
    }

    // Insertar medio de contacto (email)
    $sqlEmail = "INSERT INTO Medio_Contacto (tipo_contacto, valor_contacto) VALUES ('Email', '$emailCliente')";
    if (!$conn->query($sqlEmail)) {
        throw new Exception("Error al insertar email: " . $conn->error);
    }
    $idEmail = $conn->insert_id;

    // Insertar relación cliente-contacto (email)
    $sqlClienteEmail = "INSERT INTO Cliente_Contacto (id_cliente, id_contacto) VALUES ('$idCliente', '$idEmail')";
    if (!$conn->query($sqlClienteEmail)) {
        throw new Exception("Error al insertar relación cliente-email: " . $conn->error);
    }

    // Confirmar la transacción
    $conn->commit();

    $response["success"] = true;
} catch (Exception $e) {
    // Deshacer la transacción en caso de error
    $conn->rollback();
    $response["error"] = $e->getMessage();

    // Registrar el error en un archivo de log
    error_log($e->getMessage(), 3, "errores.log");
}

// Devolver la respuesta
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
