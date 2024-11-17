$(document).ready(function() {
    function cargarTotales() {
        $.ajax({
            url: 'totales.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data) {
                    // Verificar y convertir los valores a números
                    let totalVentas = parseFloat(data.total_ventas) || 0;
                    let totalCitas = parseFloat(data.total_citas) || 0;
                    let totalGeneral = parseFloat(data.total_general) || 0;

                    // Actualizar el total general
                    $('#totalGeneral').text(totalGeneral.toFixed(2));

                    // Actualizar el total de ventas
                    $('#totalVentas').text(totalVentas.toFixed(2));

                    // Actualizar el total de citas
                    $('#totalCitas').text(totalCitas.toFixed(2));
                } else {
                    console.error("Estructura de datos inesperada:", data);
                    alert("No se pudo cargar la información.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar los totales: ", status, error);
            }
        });
    }

    // Inicializar la carga de totales
    cargarTotales();
});
