$(document).ready(function() {
    // Función para cargar proveedores
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

    // Función para cargar productos del inventario
    function cargarInventario() {
        $.ajax({
            url: 'inventario.php',
            type: 'GET',
            success: function(response) {
                $('#inventarioTableBody').html(response);

                // Activar eventos de editar y eliminar
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

    // Función para cargar un producto en el formulario de edición
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

    // Función para eliminar un producto
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

    // Evento para agregar productos al inventario
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

    // Evento para editar productos
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

    // Inicializar la carga de proveedores y productos
    cargarProveedores();
    cargarInventario();
});
