$(document).ready(function() {

    function cargarProveedores() {
        $.ajax({
            url: 'proveedores.php',
            type: 'GET',
            dataType: 'json',
            success: function(proveedores) {
                $('#proveedorSelect').empty();
                $('#editIdProveedor').empty();
                proveedores.forEach(proveedor => {
                    $('#proveedorSelect').append(`
                        <option value="${proveedor.id_proveedor}">${proveedor.nombre}</option>
                    `);
                    $('#editIdProveedor').append(`
                        <option value="${proveedor.id_proveedor}">${proveedor.nombre}</option>
                    `);
                });
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar proveedores: ", status, error);
            }
        });
    }


    function cargarInventario() {
        $.ajax({
            url: 'inventario.php',
            type: 'GET',
            success: function(response) {
                $('#inventarioTableBody').html(response);


                $('.edit-btn').on('click', function() {
                    const id = $(this).data('id');
                    cargarProducto(id);
                });

                $('.delete-btn').on('click', function() {
                    const id = $(this).data('id');
                    eliminarProducto(id);
                });
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar inventario: ", status, error);
            }
        });
    }


    function cargarProducto(id) {
        $.ajax({
            url: 'inventario.php',
            type: 'GET',
            data: { edit_id: id },
            dataType: 'json',
            success: function(producto) {
                $('#editIdProducto').val(producto.id_producto);
                $('#editNombreProducto').val(producto.nombre_producto);
                $('#editDescripcion').val(producto.descripcion);
                $('#editCantidad').val(producto.cantidad);
                $('#editPrecioUnitario').val(producto.precio_unitario);
                $('#editIdProveedor').val(producto.id_proveedor);
                $('#editModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar producto: ", status, error);
            }
        });
    }


    function eliminarProducto(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
            $.ajax({
                url: 'inventario.php',
                type: 'POST',
                data: { delete_id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Producto eliminado con éxito');
                        cargarInventario();
                    } else {
                        alert('Error al eliminar producto: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al eliminar producto: ", status, error);
                }
            });
        }
    }


    $('#productoForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'inventario.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Producto agregado con éxito');
                    $('#productoForm')[0].reset();
                    cargarInventario();
                } else {
                    alert('Error al agregar producto: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al agregar producto: ", status, error);
            }
        });
    });


    $('#editProductoForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'inventario.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Producto actualizado con éxito');
                    $('#editModal').modal('hide');
                    cargarInventario();
                } else {
                    alert('Error al actualizar producto: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al actualizar producto: ", status, error);
            }
        });
    });


    cargarProveedores();
    cargarInventario();
});
