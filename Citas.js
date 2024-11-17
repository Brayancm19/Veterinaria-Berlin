$(document).ready(function() {
    // Cargar citas en la tabla
    function cargarCitas() {
        $.ajax({
            url: 'citas.php',
            type: 'GET',
            data: { action: 'get_citas' },
            success: function(response) {
                $('#citasTable').html(response);
            }
        });
    }

    cargarCitas();

    // Cargar clientes en el formulario de agendar cita
    function cargarClientes() {
        $.ajax({
            url: 'citas.php',
            type: 'GET',
            data: { action: 'get_clientes' },
            success: function(response) {
                $('#clienteCita').html(response);
                $('#editClienteCita').html(response);
            }
        });
    }

    cargarClientes();

    // Cargar mascotas según el cliente seleccionado para agendar nueva cita
    $('#clienteCita').change(function() {
        var idCliente = $(this).val();
        $.ajax({
            url: 'citas.php',
            type: 'GET',
            data: { action: 'get_mascotas', id_cliente: idCliente },
            success: function(response) {
                console.log(response); // Verificar la respuesta en la consola del navegador
                $('#mascotaCita').html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar las mascotas: " + error);
            }
        });
    });

   
    $('#editClienteCita').change(function() {
        var idCliente = $(this).val();
        $.ajax({
            url: 'citas.php',
            type: 'GET',
            data: { action: 'get_mascotas', id_cliente: idCliente },
            success: function(response) {
                console.log(response); // Verificar la respuesta en la consola del navegador
                $('#editMascotaCita').html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar las mascotas: " + error);
            }
        });
    });
    
    // Cargar servicios en el formulario de agendar cita
    function cargarServicios() {
        $.ajax({
            url: 'citas.php',
            type: 'GET',
            data: { action: 'get_servicios' },
            success: function(response) {
                $('#servicioCita').html(response);
                $('#editServicioCita').html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar los servicios: " + error);
            }
        });
    }
    
    cargarServicios();
    
    // Cargar veterinarios en el formulario de agendar cita
    function cargarVeterinarios() {
        $.ajax({
            url: 'citas.php',
            type: 'GET',
            data: { action: 'get_veterinarios' },
            success: function(response) {
                $('#veterinarioCita').html(response);
                $('#editVeterinarioCita').html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar los veterinarios: " + error);
            }
        });
    }
    
    cargarVeterinarios();
    
    // Agendar nueva cita
    $('#agendarCitaForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'citas.php',
            type: 'POST',
            data: $(this).serialize() + '&action=add_cita',
            success: function(response) {
                $('#agendarCitaModal').modal('hide');
                cargarCitas();
                $('#agendarCitaForm')[0].reset();
            },
            error: function(xhr, status, error) {
                console.error("Error al agendar la cita: " + error);
            }
        });
    });
    
    // Editar cita
    $(document).on('click', '.btn-edit', function() {
        var idCita = $(this).data('id');
        $.ajax({
            url: 'citas.php',
            type: 'GET',
            data: { action: 'get_cita', id: idCita },
            success: function(response) {
                try {
                    var cita = JSON.parse(response);
                    $('#editCitaId').val(cita.id_cita);
                    $('#editClienteCita').val(cita.id_cliente).trigger('change'); // Para cargar las mascotas al cambiar el cliente
                    $('#editMascotaCita').val(cita.id_mascota);
                    $('#editServicioCita').val(cita.id_servicio);
                    $('#editVeterinarioCita').val(cita.id_veterinario);
                    $('#editFechaHoraCita').val(cita.fecha_hora);
                    $('#editEstadoCita').val(cita.estado);
                    $('#editCitaModal').modal('show');
                } catch (error) {
                    console.error("Error al analizar la respuesta JSON: ", error);
                    console.log("Respuesta recibida: ", response);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener los datos de la cita: " + error);
            }
        });
    });
    
    $('#editCitaForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'citas.php',
            type: 'POST',
            data: $(this).serialize() + '&action=edit_cita',
            success: function(response) {
                $('#editCitaModal').modal('hide');
                cargarCitas();
            },
            error: function(xhr, status, error) {
                console.error("Error al editar la cita: " + error);
            }
        });
    });
    });
    