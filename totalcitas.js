$(document).ready(function() {
    function cargarCitas() {
        $.ajax({
            url: 'totalcitas.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data && data.citas) {
                    let totalIngresos = 0;
                    let html = '';
                    data.citas.forEach(cita => {
                        totalIngresos += parseFloat(cita.monto);
                        html += `
                            <tr>
                                <td>${cita.id_cita}</td>
                                <td>${cita.cliente}</td>
                                <td>${cita.servicio}</td>
                                <td>${cita.veterinario}</td>
                                <td>${cita.fecha_hora}</td>
                                <td>${cita.monto}</td>
                            </tr>
                        `;
                    });
                    $('#citasTableBody').html(html);
                    $('#totalIngresos').text(totalIngresos.toFixed(2));
                } else {
                    console.error("Estructura de datos inesperada:", data);
                    alert("No se pudo cargar la información de citas.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar citas: ", status, error);
            }
        });
    }

    // Inicializar la carga de citas
    cargarCitas();
});
