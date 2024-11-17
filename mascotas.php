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
        case 'get_mascotas':
            getMascotas();
            break;
        case 'get_clientes':
            getClientes();
            break;
        case 'get_mascota':
            getMascota($_GET['id']);
            break;
        case 'get_historial':
            getHistorial($_GET['id']);
            break;
    }
} elseif (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add_mascota':
            addMascota();
            break;
        case 'edit_mascota':
            editMascota();
            break;
        case 'delete_mascota':
            deleteMascota();
            break;
    }
}

function getMascotas() {
    global $conn;
    $query = "SELECT m.*, c.nombre AS nombre_cliente, c.apellido AS apellido_cliente
              FROM Mascotas m
              JOIN Clientes c ON m.id_cliente = c.id_cliente";
    $result = $conn->query($query);
    $mascotas = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($mascotas as $mascota) {
        echo "<tr>";
        echo "<td>{$mascota['id_mascota']}</td>";
        echo "<td>{$mascota['nombre_mascota']}</td>";
        echo "<td>{$mascota['especie']}</td>";
        echo "<td>{$mascota['raza']}</td>";
        echo "<td>{$mascota['edad']}</td>";
        echo "<td>{$mascota['sexo']}</td>";
        echo "<td>{$mascota['nombre_cliente']} {$mascota['apellido_cliente']}</td>";
        echo "<td>
                <button class='btn btn-info btn-edit' data-id='{$mascota['id_mascota']}'>Modificar</button>
                <button class='btn btn-danger btn-delete' data-id='{$mascota['id_mascota']}'>Eliminar</button>
                <button class='btn btn-secondary btn-historial' data-id='{$mascota['id_mascota']}'>Historial Médico</button>
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

function getMascota($id) {
    global $conn;
    $query = "SELECT * FROM Mascotas WHERE id_mascota = $id";
    $result = $conn->query($query);
    $mascota = $result->fetch_assoc();
    echo json_encode($mascota);
}

function addMascota() {
    global $conn;
    $nombre = $_POST['nombreMascota'];
    $especie = $_POST['especieMascota'];
    $raza = $_POST['razaMascota'];
    $edad = $_POST['edadMascota'];
    $sexo = $_POST['sexoMascota'];
    $id_cliente = $_POST['clienteMascota'];
    
    $query = "INSERT INTO Mascotas (nombre_mascota, especie, raza, edad, sexo, id_cliente) 
              VALUES ('$nombre', '$especie', '$raza', $edad, '$sexo', $id_cliente)";
    if ($conn->query($query) === TRUE) {
        echo "Mascota registrada correctamente";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

function editMascota() {
    global $conn;
    $id = $_POST['idMascota'];
    $nombre = $_POST['nombreMascota'];
    $especie = $_POST['especieMascota'];
    $raza = $_POST['razaMascota'];
    $edad = $_POST['edadMascota'];
    $sexo = $_POST['sexoMascota'];
    $id_cliente = $_POST['clienteMascota'];
    
    $query = "UPDATE Mascotas SET nombre_mascota='$nombre', especie='$especie', raza='$raza', edad=$edad, sexo='$sexo', id_cliente=$id_cliente
              WHERE id_mascota = $id";
    if ($conn->query($query) === TRUE) {
        echo "Mascota actualizada correctamente";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

function deleteMascota() {
    global $conn;
    $id = $_POST['idMascota'];
    
    $query = "DELETE FROM Mascotas WHERE id_mascota = $id";
    if ($conn->query($query) === TRUE) {
        echo "Mascota eliminada correctamente";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

function getHistorial($id) {
    global $conn;
    $query = "SELECT c.fecha_hora AS fecha, s.nombre_servicio, v.nombre AS nombre_veterinario
              FROM Citas c
              JOIN Servicios s ON c.id_servicio = s.id_servicio
              JOIN Veterinarios v ON c.id_veterinario = v.id_veterinario
              WHERE c.id_mascota = $id";
    $result = $conn->query($query);
    $historial = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($historial as $registro) {
        echo "<tr>";
        echo "<td>{$registro['fecha']}</td>";
        echo "<td>{$registro['nombre_servicio']}</td>";
        echo "<td>{$registro['nombre_veterinario']}</td>";
        echo "</tr>";
    }
}

$conn->close();
?>
