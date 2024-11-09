$(document).ready(function() {
    let carrito = [];
    let totalVenta = 0;

    // Función para cargar productos desde el inventario
    function cargarProductos() {
        $.ajax({
            url: 'venta_inventario.php',
            type: 'GET',
            success: function(response) {
                $('#productosTableBody').html(response);
            }
        });
    }

    // Función para actualizar el carrito
    function actualizarCarrito() {
        $('#carritoTableBody').empty();
        totalVenta = 0;

        carrito.forEach((producto, index) => {
            let totalProducto = producto.cantidad * producto.precio_unitario;
            totalVenta += totalProducto;

            $('#carritoTableBody').append(`
                <tr>
                    <td>${producto.id_producto}</td>
                    <td>${producto.nombre_producto}</td>
                    <td>${producto.cantidad}</td>
                    <td>${producto.precio_unitario.toFixed(2)}</td>
                    <td>${totalProducto.toFixed(2)}</td>
                    <td><button class="btn btn-danger btn-sm eliminar-producto" data-index="${index}">Eliminar</button></td>
                </tr>
            `);
        });

        $('#totalVenta').text(totalVenta.toFixed(2));
    }

    // Evento para agregar productos al carrito
    $(document).on('click', '.agregar-carrito', function() {
        let idProducto = $(this).data('id');
        let nombreProducto = $(this).data('nombre');
        let descripcion = $(this).data('descripcion');
        let precioUnitario = parseFloat($(this).data('precio'));
        let cantidadDisponible = parseInt($(this).data('cantidad'));
        let cantidad = parseInt($(`.cantidad-producto[data-id='${idProducto}']`).val());  // Obtener la cantidad ingresada

        if (cantidad <= 0 || cantidad > cantidadDisponible) {
            alert('Cantidad no válida o excede la cantidad disponible en el inventario');
            return;
        }

        // Verificar si el producto ya está en el carrito
        let productoEnCarrito = carrito.find(producto => producto.id_producto === idProducto);

        if (productoEnCarrito) {
            if (productoEnCarrito.cantidad + cantidad <= cantidadDisponible) {
                productoEnCarrito.cantidad += cantidad;
            } else {
                alert('No hay suficiente cantidad disponible en el inventario');
            }
        } else {
            if (cantidad <= cantidadDisponible) {
                carrito.push({ id_producto: idProducto, nombre_producto: nombreProducto, descripcion: descripcion, precio_unitario: precioUnitario, cantidad: cantidad });
            } else {
                alert('No hay suficiente cantidad disponible en el inventario');
            }
        }

        actualizarCarrito();
    });

    // Evento para eliminar productos del carrito
    $(document).on('click', '.eliminar-producto', function() {
        let index = $(this).data('index');
        carrito.splice(index, 1);
        actualizarCarrito();
    });

    // Evento para completar la venta
    $('#completarVentaBtn').on('click', function() {
        let idCliente = $('#clienteSelect').val();  

        if (!idCliente) {
            alert('Seleccione un cliente');
            return;
        }

        if (carrito.length === 0) {
            alert('El carrito está vacío');
            return;
        }

        $.ajax({
            url: 'venta.php',
            type: 'POST',
            data: { carrito: carrito, id_cliente: idCliente },
            success: function(response) {
                console.log(response); 
                if (response.success) {
                    alert('Venta completada con éxito');
                    carrito = [];
                    actualizarCarrito();
                    cargarProductos();
                } else {
                    alert('Error al completar la venta: ' + response.error);
                }
            }
        });
    });


    cargarProductos();
});
