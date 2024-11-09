$(document).ready(function() {
    // Función para cargar proveedores
    function cargarProveedores() {
        $.ajax({
            url: 'proveedores.php',
            type: 'GET',
            dataType: 'json',
            success: function(proveedores) {
                let html = '';
                proveedores.forEach(proveedor => {
                    html += `
                        <tr>
                            <td>${proveedor.id_proveedor}</td>
                            <td>${proveedor.nombre}</td>
                            <td>${proveedor.telefono || ''}</td>
                            <td>${proveedor.email || ''}</td>
                            <td>${proveedor.direccion || ''}</td>
                        </tr>
                    `;
                });
                $('#proveedoresTableBody').html(html);
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar proveedores: ", status, error);
            }
        });
    }

    // Evento para agregar proveedores
    $('#proveedorForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'proveedores.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Proveedor agregado con éxito');
                    $('#proveedorForm')[0].reset();
                    cargarProveedores();
                } else {
                    alert('Error al agregar proveedor: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al agregar proveedor: ", status, error);
            }
        });
    });

    // Inicializar la carga de proveedores
    cargarProveedores();
});
