$(document).ready(function() {
    // Función para cargar el total vendido y las ventas detalladas
    function cargarVentas() {
        $.ajax({
            url: 'ventas.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data && data.ventas) {
                    let totalVendido = 0;
                    let html = '';
                    data.ventas.forEach(venta => {
                        totalVendido += parseFloat(venta.total);
                        html += `
                            <tr>
                                <td>${venta.id_venta}</td>
                                <td>${venta.cliente}</td>
                                <td>${venta.producto}</td>
                                <td>${venta.cantidad}</td>
                                <td>${venta.total}</td>
                                <td>${venta.fecha_venta}</td>
                            </tr>
                        `;
                    });
                    $('#ventasTableBody').html(html);
                    $('#totalVendido').text(totalVendido.toFixed(2));
                } else {
                    console.error("Estructura de datos inesperada:", data);
                    alert("No se pudo cargar la información de ventas.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar ventas: ", status, error);
            }
        });
    }

    // Inicializar la carga de ventas
    cargarVentas();
});
