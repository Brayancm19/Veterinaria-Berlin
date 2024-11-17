<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "veterinaria_berlin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'get_citas':
            getCitas();
            break;
        case 'get_clientes':
            getClientes();
            break;
        case 'get_mascotas':
            getMascotas($_GET['id_cliente']);
            break;
        case 'get_servicios':
            getServicios();
            break;
        case 'get_veterinarios':
            getVeterinarios();
            break;
        case 'get_cita':
            getCita($_GET['id']);
            break;
    }
} elseif (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add_cita':
            addCita();
            break;
        case 'edit_cita':
            editCita();
            break;
    }
}

function getCitas() {
    global $conn;
    $query = "SELECT c.*, cl.nombre AS nombre_cliente, cl.apellido AS apellido_cliente,
                     m.nombre_mascota, s.nombre_servicio, v.nombre AS nombre_veterinario
              FROM Citas c
              JOIN Clientes cl ON c.id_cliente = cl.id_cliente
              JOIN Mascotas m ON c.id_mascota = m.id_mascota
              JOIN Servicios s ON c.id_servicio = s.id_servicio
              JOIN Veterinarios v ON c.id_veterinario = v.id_veterinario";
    $result = $conn->query($query);
    $citas = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($citas as $cita) {
        echo "<tr>";
        echo "<td>{$cita['id_cita']}</td>";
        echo "<td>{$cita['nombre_cliente']} {$cita['apellido_cliente']}</td>";
        echo "<td>{$cita['nombre_mascota']}</td>";
        echo "<td>{$cita['nombre_servicio']}</td>";
        echo "<td>{$cita['nombre_veterinario']}</td>";
        echo "<td>{$cita['fecha_hora']}</td>";
        echo "<td>{$cita['estado']}</td>";
        echo "<td>
                <button class='btn btn-info btn-edit' data-id='{$cita['id_cita']}'>Modificar</button>
              </td>";
        echo "</tr>";
    }
}

function getClientes() {
    global $conn;
    $query = "SELECT id_cliente, nombre, apellido FROM Clientes";
    $result = $conn->query($query);
    $clientes = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($clientes as $cliente) {
        echo "<option value='{$cliente['id_cliente']}'>{$cliente['nombre']} {$cliente['apellido']}</option>";
    }
}

function getMascotas($id_cliente) {
    global $conn;
    $query = "SELECT id_mascota, nombre_mascota FROM Mascotas WHERE id_cliente = $id_cliente";
    $result = $conn->query($query);
    $mascotas = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($mascotas as $mascota) {
        echo "<option value='{$mascota['id_mascota']}'>{$mascota['nombre_mascota']}</option>";
    }
}

function getServicios() {
    global $conn;
    $query = "SELECT id_servicio, nombre_servicio FROM Servicios";
    $result = $conn->query($query);
    $servicios = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($servicios as $servicio) {
        echo "<option value='{$servicio['id_servicio']}'>{$servicio['nombre_servicio']}</option>";
    }
}

function getVeterinarios() {
    global $conn;
    $query = "SELECT id_veterinario, nombre FROM Veterinarios";
    $result = $conn->query($query);
    $veterinarios = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($veterinarios as $veterinario) {
        echo "<option value='{$veterinario['id_veterinario']}'>{$veterinario['nombre']}</option>";
    }
}

function getCita($id) {
    global $conn;
    $query = "SELECT * FROM Citas WHERE id_cita = $id";
    $result = $conn->query($query);
    $cita = $result->fetch_assoc();

    echo json_encode($cita);
}

function addCita() {
    global $conn;
    $id_cliente = $_POST['clienteCita'];
    $id_mascota = $_POST['mascotaCita'];
    $id_servicio = $_POST['servicioCita'];
    $id_veterinario = $_POST['veterinarioCita'];
    $fecha_hora = $_POST['fechaHoraCita'];
    $estado = $_POST['estadoCita'];

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Insertar la cita en la tabla `Citas`
        $queryCita = "INSERT INTO Citas (id_cliente, id_mascota, id_servicio, id_veterinario, fecha_hora, estado)
                      VALUES ($id_cliente, $id_mascota, $id_servicio, $id_veterinario, '$fecha_hora', '$estado')";
        $conn->query($queryCita);

        // Obtener el precio del servicio
        $queryPrecio = "SELECT precio FROM Servicios WHERE id_servicio = $id_servicio";
        $result = $conn->query($queryPrecio);
        $precio = $result->fetch_assoc()['precio'];

        // Insertar la venta en la tabla `Ventas`
        $queryVenta = "INSERT INTO Ventas (id_cliente, id_producto, cantidad, total, fecha_venta)
                       VALUES ($id_cliente, $id_servicio, 1, $precio, '$fecha_hora')";
        $conn->query($queryVenta);

        // Confirmar la transacción
        $conn->commit();
        
        echo "Cita agendada y venta registrada correctamente";
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}

function editCita() {
    global $conn;
    $id_cita = $_POST['idCita'];
    $id_cliente = $_POST['clienteCita'];
    $id_mascota = $_POST['mascotaCita'];
    $id_servicio = $_POST['servicioCita'];
    $id_veterinario = $_POST['veterinarioCita'];
    $fecha_hora = $_POST['fechaHoraCita'];
    $estado = $_POST['estadoCita'];

    $query = "UPDATE Citas SET id_cliente=$id_cliente, id_mascota=$id_mascota, id_servicio=$id_servicio, id_veterinario=$id_veterinario, fecha_hora='$fecha_hora', estado='$estado'
              WHERE id_cita = $id_cita";
    if ($conn->query($query) === TRUE) {
        echo "Cita actualizada correctamente";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

$conn->close();
?>
