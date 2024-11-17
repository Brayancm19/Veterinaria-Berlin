$(document).ready(function() {
    // Cargar mascotas en la tabla
    function cargarMascotas() {
        $.ajax({
            url: 'mascotas.php',
            type: 'GET',
            data: { action: 'get_mascotas' },
            success: function(response) {
                $('#mascotasTable').html(response);
            }
        });
    }

    cargarMascotas();

    
    $(document).ready(function() {
        // Cargar clientes en el formulario de registro
        function cargarClientes() {
            $.ajax({
                url: 'mascotas.php',
                type: 'GET',
                data: { action: 'get_clientes' },
                success: function(response) {
                    $('#clienteMascota').html(response);
                    $('#editClienteMascota').html(response);
                }
            });
        }
    
        cargarClientes();
    });
    

    // Registrar nueva mascota
    $('#addMascotaForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'mascotas.php',
            type: 'POST',
            data: $(this).serialize() + '&action=add_mascota',
            success: function(response) {
                $('#addMascotaModal').modal('hide');
                cargarMascotas();
                $('#addMascotaForm')[0].reset();
            }
        });
    });

    // Editar mascota
    $(document).on('click', '.btn-edit', function() {
        var idMascota = $(this).data('id');
        $.ajax({
            url: 'mascotas.php',
            type: 'GET',
            data: { action: 'get_mascota', id: idMascota },
            success: function(response) {
                var mascota = JSON.parse(response);
                $('#editMascotaId').val(mascota.id);
                $('#editNombreMascota').val(mascota.nombre);
                $('#editEspecieMascota').val(mascota.especie);
                $('#editRazaMascota').val(mascota.raza);
                $('#editEdadMascota').val(mascota.edad);
                $('#editSexoMascota').val(mascota.sexo);
                $('#editClienteMascota').val(mascota.id_cliente);
                $('#editMascotaModal').modal('show');
            }
        });
    });

    $('#editMascotaForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'mascotas.php',
            type: 'POST',
            data: $(this).serialize() + '&action=edit_mascota',
            success: function(response) {
                $('#editMascotaModal').modal('hide');
                cargarMascotas();
            }
        });
    });

    // Eliminar mascota
    $(document).on('click', '.btn-delete', function() {
        var idMascota = $(this).data('id');
        $('#deleteMascotaId').val(idMascota);
        $('#deleteMascotaModal').modal('show');
    });

    $('#deleteMascotaForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'mascotas.php',
            type: 'POST',
            data: $(this).serialize() + '&action=delete_mascota',
            success: function(response) {
                $('#deleteMascotaModal').modal('hide');
                cargarMascotas();
            }
        });
    });

    // Ver historial médico de la mascota
    $(document).on('click', '.btn-historial', function() {
        var idMascota = $(this).data('id');
        $.ajax({
            url: 'mascotas.php',
            type: 'GET',
            data: { action: 'get_historial', id: idMascota },
            success: function(response) {
                $('#historialTable').html(response);
                $('#historialMascotaModal').modal('show');
            }
        });
    });
});
