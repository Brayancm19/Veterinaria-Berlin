$(document).ready(function() {
    // Función para cargar el historial médico de una mascota
    function cargarHistorial(idMascota) {
        $.ajax({
            url: 'mascotas.php',
            type: 'GET',
            data: { action: 'get_historial', id: idMascota },
            success: function(response) {
                $('#historialTable').html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar el historial médico: " + error);
            }
        });
    }

       // Evento para abrir el modal y cargar el historial médico
       $(document).on('click', '.btn-historial', function() {
        var idMascota = $(this).data('id');
        cargarHistorial(idMascota);
        $('#historialMascotaModal').modal('show');
    });
});
