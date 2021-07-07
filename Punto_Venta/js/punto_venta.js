var total = 0; //Variable para llevar el control del total
var totalFinal = 0; //Variable para llevar el control del total
var indArt = 0; //Variable que lleva el indice de los articulos agregados
var totalDev = 0; //Variable para llevar el control del total de la devolucion
/************************************** LOGIN **************************************/
function login() {
    var user = $("#login_user").val();
    var pass = $("#login_pass").val();

    $.ajax({
        data: "user="+user+"&pass="+pass,
        type: "POST",
        url: "php/login.php",
        success: function(data) {
            // alert(data);
            var datos = JSON.parse(data);
            if(!datos.success) {
                alert(datos.error);
                return;
            }
            window.location = datos.page;
        }
    });
}

function cerrarSesion() {
    var confirmacion = confirm("¿Está seguro que desea cerrar sesión?");
    if (confirmacion) {
        $.ajax({
            data: "",
            type: "POST",
            url: "php/cerrarSesion.php",
            success: function(data) {
                window.location = data;
            }
        });
    }
}

function retiros(tipo) { //Function que trae las ventas de la base de datos y las muestra en una tabla
    $.ajax({
        data: "tipo_consulta="+tipo,
        type: "POST",
        url: "php/buscaRetiros.php",
        success: function(data) {
            $('#divRetiros').html(data);
            $('#tabla').DataTable({ responsive: true, order: [[ 0, "desc" ]] });
        }
    });
}

function filtroFecha_Retiros() { //Se usa esta funcion cuando se busca por un rango de fecha especifico.
    var desde = $('#fechaVentasDesde').val();
    var hasta = $('#fechaVentasHasta').val();
    var caja = document.getElementById('cajas_').value;
    //alert("Desde: "+desde+" hasta: "+hasta+" caja: "+caja);

    if (caja==0 || caja=='0')
    {
        alert("Seleccione una caja.");
    }

    else
    {
        if(hasta < desde)
          alert("El rango de fecha no es valido.");
        else {
          $.ajax({
            data: "cajas="+caja+"&desde="+desde+"&hasta="+hasta,
            type: "POST",
            url: "php/buscaRetiros_.php",
            success: function(data) {
                $('#divRetiros').html(data);
                $('#tabla').DataTable({ responsive: true, order: [[ 0, "desc" ]] });
            }
          });
        }
    }
}

/***********************************************************************************/
function ventas(tipo) { //Function que trae las ventas de la base de datos y las muestra en una tabla
   //alert("hola");
   var desde = $('#desde').val();
   var hasta = $('#hasta').val();

    $.ajax({
        data: { tipo_consulta: tipo, desde: desde, hasta: hasta },
        type: "POST",
        url: "php/buscaVentas.php",
        success: function(data) {
            $('#divVentas').html(data);
            $('#tabla').DataTable({ responsive: true, order: [[ 0, "desc" ]] });
        }
    });
}

function ventasporProducto() { //Function que trae las ventas de la base de datos y las muestra en una tabla
    $.ajax({
        url: "php/buscaVentasporproducto.php",
        success: function(data) {
            $('#divVentas').html(data);
            $('#tabla').DataTable({ responsive: true, order: [[ 0, "desc" ]] });
        }
    });
}

function ventasporProductoFiltro() { //Function que trae las ventas de la base de datos y las muestra en una tabla
    var desde = $('#fechaVentasDesde').val();
    var hasta = $('#fechaVentasHasta').val();
     if(hasta < desde)
        alert("El rango de fecha no es valido.");
    else {
    $.ajax({
        data: "desde="+desde+"&hasta="+hasta,
        type: "POST",
        url: "php/buscaVentasporproductofiltro.php",
        success: function(data) {
            $('#divVentas').html(data);
            $('#tabla').DataTable({ responsive: true, order: [[ 0, "desc" ]] });
        }
    });
    }
}

function filtroFecha_Ventas(tipo) { //Se usa esta funcion cuando se busca por un rango de fecha especifico.
    var desde = $('#fechaVentasDesde').val();
    var hasta = $('#fechaVentasHasta').val();
    if(hasta < desde)
        alert("El rango de fecha no es valido.");
    else {
        $.ajax({
            data: "tipo_consulta="+tipo+"&desde="+desde+"&hasta="+hasta,
            type: "POST",
            url: "php/buscaVentas.php",
            success: function(data) {
                $('#divVentas').html(data);
                $('#tabla').DataTable({ responsive: true, order: [[ 0, "desc" ]] });
            }
        });
    }
}



function facturar(id_venta, id_cliente) { //Funcion para llevar a cabo la facturacion de una venta
    var confirmacion = confirm("¿Esta seguro de esto?");
    if (confirmacion) {
        if(id_cliente == 0) { //En caso de que se quiera facturar y no haya un cliente seleccionado se mostrara un formulario para registrar un nuevo cliente.
            $('#id_venta').val(id_venta);
            $('#modal_cliente').modal({
                show:true,
                backdrop:'static'
            });
        }
        else { //Si existe un cliente seleccionado se toma su id y se manda a facturar a su nombre
            $('#modal_cliente').modal('hide');
            $.ajax({
                data: "id_venta="+id_venta+"&id_cliente="+id_cliente,
                type: "POST",
                url: "php/facturar.php",
                beforeSend: function() { //Se muestra un loader mientras de factura
                    $.blockUI({
                        message: '<h3>Facturando la venta...</h3><img src="img/loader.gif">',
                        css: {
                            border: 'none',
                            padding: '15px',
                            backgroundColor: '#000',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: .6,
                            color: '#fff',
                            cursor:'default',
                        }
                    });
                },
                success: function(data) {
                    $.unblockUI();
                    alert(data);
                    ventas(4);
                }
            });
        }
    }
}

function formFactura() { //Esta funcion muestra u oculta el formulario para insertar un nuevo cliente, dependiendo si se selecciona un cliente o no.
    var id_cliente = $('#id_cliente').val();
    var nom_cliente = $('#clientes').find('option[value="'+id_cliente+'"]').attr('nom-cl');

    if(id_cliente == "") {
        $('#formDatos').show();
    }
    else {
        $('#formDatos').hide();
    }
}

function verDetalles(id_venta) { //Funcion que trae los detalles de una venta y los muestra en una modal.
    $.ajax({
        data: "id_venta="+id_venta,
        type: "POST",
        url: "php/buscaDetallesVentas.php",
        success: function(data) {
            $('#body_modal').html(data);
            $('#modal_detVenta').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
}

function cancelar(id_xml) { //Funcion para cancelar una factura, esta pedira una confirmacion ademas de un codigo para poder cancelarla.
    var confirmacion = confirm("¿Desea cancelar la factura?");
    if (confirmacion) {
        var codCancelar = prompt("Introduce el código de cancelación:");
        if (codCancelar != "") {
            $.ajax({
                data: "codigo="+codCancelar,
                type: "POST",
                url: "php/verificarCodigo.php", //Se recibe el codigo y lo verifica en la base de datos, se busca que coincida con cualquier codigo que tenga un administrador.
                success: function(data) {
                    if(data == "Ok") {
                        $.ajax({
                            data: "id_xml="+id_xml,
                            type: "POST",
                            url: "php/cancelaFactura.php",
                            beforeSend: function() {
                                $.blockUI({
                                    message: '<h3>Cancelando la factura...</h3><img src="img/loader.gif">',
                                    css: {
                                        border: 'none',
                                        padding: '15px',
                                        backgroundColor: '#000',
                                        '-webkit-border-radius': '10px',
                                        '-moz-border-radius': '10px',
                                        opacity: .6,
                                        color: '#fff',
                                        cursor:'default',
                                    }
                                });
                            },
                            success: function(data) {
                                $.unblockUI();
                                alert(data);
                                ventas(3);
                            }
                        });
                    }
                    else if(data == "Not") {
                        alert("Codigo incorrecto");
                    }
                    else {
                        alert("Error: " + data);
                    }
                }
            });
        }
    }
}

function cancelarVenta(id_venta) { //Funcion para cancelar una venta, de igual manera requiere un codigo de cancelacion. Si la venta fue facturada tambien cancela la factura.
    var confirmacion = confirm("¿Desea cancelar la venta?");
    if (confirmacion) {
        var codCancelar = prompt("Introduce el código de cancelación:");
        if (codCancelar != "") {
            $.ajax({
                data: "codigo="+codCancelar,
                type: "POST",
                url: "php/verificarCodigo.php",
                success: function(data) {
                    if(data == "Ok") {
                        $.ajax({
                            data: "id_venta="+id_venta,
                            type: "POST",
                            url: "php/cancelaVenta.php",
                            beforeSend: function() {
                                $.blockUI({
                                    message: '<h3>Cancelando la venta...</h3><img src="img/loader.gif">',
                                    css: {
                                        border: 'none',
                                        padding: '15px',
                                        backgroundColor: '#000',
                                        '-webkit-border-radius': '10px',
                                        '-moz-border-radius': '10px',
                                        opacity: .6,
                                        color: '#fff',
                                        cursor:'default',
                                    }
                                });
                            },
                            success: function(data) {
                                $.unblockUI();
                                alert(data);
                                ventas(5);
                            }
                        });
                    }
                    else if(data == "Not") {
                        alert("Codigo incorrecto");
                    }
                    else {
                        alert("Error: " + data);
                    }
                }
            });
        }
    }
}

function inventario() { //Funcion para traer las materias primas existentes en la base de datos.
    $.ajax({
        type: "POST",
        url: "php/buscaInventario.php",
        success: function(data) {
            $('#divInventario').html(data);
            $('#tabla').DataTable({ responsive: true });
        }
    });
}

function nuevo_articulo() { //Esta funcion hace llamado a otra que limpia los input y muestra la venta modal de registro.
    limpiaModal();
    $('#myModalLabel').text("Registro Materia Prima");
    $('#modal_inventario').modal({
        show: true,
        backdrop: 'static'
    });
}

function nuevo_producto() {
    limpiaModal();
    $('#myModalLabel').text("Registro Producto");
    $('#modal_inventario').modal({
        show: true,
        backdrop: 'static'
    });
}

function registraEntrada() { //Funcion para mostrar la ventana modal para registrar una entrada de materia prima.
    $('#nombreArticulo').val("");
    $('#cantidad').val("");
    $('#modal_entrada').modal({
        show: true,
        backdrop: 'static'
    });
}

function guardaEntrada() { //Esta funcion verifica que no se manden registros vacios, y luego los inserta en la base de datos.
    var nom_articulo = $('#nombreArticulo').val();
    var id_articulo = $('#articulos').find('option[value="'+nom_articulo+'"]').attr('data-id');
    var cantidad = $('#cantidad').val();

    if(nom_articulo == "") {
        alert("Debe seleccionar un elemento.");
        $('#nombreArticulo').focus();
    }
    else if(cantidad == "") {
        alert("Debe introducir una cantidad.");
        $('#cantidad').focus();
    }
    else {
        $.ajax({
            data: {id_articulo: id_articulo, cantidad: cantidad},
            type: "POST",
            url: "php/guarda_entrada.php",
            success: function(data) {
                $('#modal_entrada').modal('hide');
                alert(data);
                inventario();
            }
        });
    }
}

function eliminarArticulo() { //Funcion para eliminar un articulo de la base de datos. NO SE UTILIZA.
    var id_articulo = [], i = 0;

    $("input:checkbox[class='cbSelect']:checked").each(function() {
        id_articulo[i] = $(this).val();
        i++;
    });

    if(i == 0) {
        alert("Seleccione minimo un artículo de la lista.")
    }
    else {
        var confirmacion = confirm("Se eliminara el artículo seleccionado");
        if(confirmacion) {
            var confirmacion = confirm("¿Está totalmente seguro?");
            if(confirmacion) {
                $.ajax({
                    data: {id_articulo: id_articulo},
                    type: "POST",
                    url: "php/eliminarArticulo.php",
                    success: function(data) {
                        alert(data);
                    }
                });
            }
        }
    }
}

function guardarMateriaPrima() { //Funcion para insertar una nueva materia prima en la base de datos. Verifica que no se manden registros vacios.
    var id_materiaP = $('#id_materiaP').val();
    var nom_materiaP = $('#nom_materiaP').val();
    var stock_materiaP = $('#stock_materiaP').val();
    var reorden_materiaP = $('#reorden_materiaP').val();
    var categoria_materiaP = $('#categoria_materiaP').val();

    if(nom_materiaP == "") {
        alert("Debe introducir el nombre.");
        $('#nom_materiaP').focus();
    }
    else if(stock_materiaP == "") {
        alert("Debe introducir la cantidad disponible.");
        $('#stock_materiaP').focus();
    }
    else if(reorden_materiaP == "") {
        alert("Debe introducir el punto de reorden.");
        $('#reorden_materiaP').focus();
    }
    else if(categoria_materiaP == "0") {
        alert("Debe seleccionar la categoria.");
        $('#categoria_materiaP').focus();
    }
    else {
        $.ajax({
            data: "nom_materiaP="+nom_materiaP+"&stock_materiaP="+stock_materiaP+"&reorden_materiaP="+reorden_materiaP+
            "&categoria_materiaP="+categoria_materiaP+"&id_materiaP="+id_materiaP,
            type: "POST",
            url: "php/guardar_materiaP.php",
            success: function(data) {
                $('#modal_inventario').modal('hide');
                alert(data);
                inventario();
                limpiaModal();
            }
        });
    }
}

function verProductos(id_materiaP) { //Consulta los productos derivados de la materia prima y los muestra en una modal.
    $.ajax({
        data: "id_materiaP="+id_materiaP,
        type: "POST",
        url: "php/buscaProductosMatP.php",
        success: function(data) {
            $('#body_modal').html(data);
            $('#modal_productos').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
}

function editarArticulo(id_materiaP) { //Si se quiere editar un articulo manda a traer la informacion de dicho articulo, y la muestra en una modal donde puede editarse la informacion.
    $.ajax({
        data: "id_materiaP="+id_materiaP+"&consulta=1",
        type: "POST",
        url: "php/datosMateriaP.php",
        success: function(data) {
            if(datos = JSON.parse(data)) {
                $('#myModalLabel').text("Editar Materia Prima");
                $('#id_materiaP').val(id_materiaP);
                $('#nom_materiaP').val(datos[0]);
                $('#stock_materiaP').val(datos[1]);
                $('#reorden_materiaP').val(datos[2]);

                $('#modal_inventario').modal({
                    show:true,
                    backdrop:'static'
                });
            }
        }
    });
}

function productos() { //Trae todos los productos registrados en la base de datos.
    $.ajax({
        type: "POST",
        url: "php/buscaProductos.php",
        success: function(data) {
            $('#divInventario').html(data);
            $('#tabla').DataTable({ responsive: true });
        }
    });
}

function editarProducto(id_producto) { //Trae los datos de un producto especifico los muestra en una modal para editarlos si asi se quiere.
    $.ajax({
        data: "id_producto="+id_producto,
        type: "POST",
        url: "php/datosProducto.php",
        success: function(data) {
            if(datos = JSON.parse(data)) {
                $('#myModalLabel').text("Editar Producto");
                $('#id_producto').val(id_producto);
                $('#nom_producto').val(datos[0]);
                $('#id_matP').val(datos[1]);
                $('#clave_producto').val(datos[2]);
                $('#precio_producto').val(datos[3]);
                $('#unidad_art').val(datos[4]);

                $('#modal_inventario').modal({
                    show:true,
                    backdrop:'static'
                });
            }
        }
    });
}

function guardarProducto() { //Funcion para guardar un nuevo producto, verifica que no se dejen registros en blanco.
    var id_producto = $('#id_producto').val();
    var nom_producto = $('#nom_producto').val();
    var clave_producto = $('#clave_producto').val();
    var precio_producto = $('#precio_producto').val();
    var id_matP = $('#id_matP  option:selected').val();
    var u_medida = $('#unidad_art option:selected').val();

    if(nom_producto == "") {
        alert("Debe introducir el nombre.");
        $('#nom_producto').focus();
    }
    else if(clave_producto == "") {
        alert("Debe introducir la clave.");
        $('#clave_producto').focus();
    }
    else if(id_matP == 0) {
        alert("Debe seleccionar una opción.");
        $('#id_matP').focus();
    }
    else if(precio_producto == "") {
        alert("Debe introducir el precio unitario.");
        $('#precio_producto').focus();
    }
    else if(u_medida == "") {
        alert("Debe introducir la unidad de medida.");
        $('#unidad_art').focus();
    }
    else {
        $.ajax({
            data: "id_producto="+id_producto+"&nom_producto="+nom_producto+"&clave_producto="+clave_producto+"&precio_producto="+precio_producto+"&id_matP="+id_matP+"&u_medida="+u_medida,
            type: "POST",
            url: "php/guardar_producto.php",
            success: function(data) {
                $('#modal_inventario').modal('hide');
                alert(data);
                productos();
                limpiaModal();
            }
        });
    }
}

function selecArticulo() { //Cuando se selecciona un articulo del listado, se trae su precio de la base de datos y se muestra.
    $('#precio').val("");
    $('#unidades').val("");
	var nom_articulo = $('#nombreArticulo').val();
    var id_articulo = $('#articulos').find('option[value="'+nom_articulo+'"]').attr('data-id');
    var unidad = $('#articulos').find('option[value="'+nom_articulo+'"]').attr('unidad');

	$.ajax({
		data: "id_producto="+id_articulo,
		type: "POST",
		url: "php/datosProducto.php",
		success: function(data) {
            if(datos = JSON.parse(data)) {
                if(unidad != "KG") {
                    $('#divUnidades').show();
                    $('#unds').focus();
                }
                else {
                    $('#divUnidades').hide();
                }

                $('#precio').val(datos[3]);
                // $('#unidades').focus();
            }
		}
	});
}

function selecArticulo2() { //Cuando se selecciona un articulo del listado, se trae su precio de la base de datos y se muestra.
    $('#precio').val("");
    $('#undades').val("");
    var nom_articulo = $('#nombreArticulo').val();
    var id_articulo = $('#articulos').find('option[value="'+nom_articulo+'"]').attr('data-id');
    var unidad = $('#articulos').find('option[value="'+nom_articulo+'"]').attr('unidad');

    $.ajax({
        data: "id_producto="+id_articulo,
        type: "POST",
        url: "php/datosProducto.php",
        success: function(data) {
            if(datos = JSON.parse(data)) {
                if(unidad != "KG") {
                    $('#divUnidades').show();
                    $('#unds').focus();
                }
                else {
                    $('#divUnidades').hide();
                    $('#undades').focus();
                }

                $('#precio').val(datos[3]);
                // $('#unidades').focus();
            }
        }
    });
}

/*function muestracapturakg(){ // permite capturar el peso manual
    $('#divUnidades2').show();
    $('#divUnidades2').unblock();
    $('#unidades2').focus();
    $('#divpeso').block();
    $('#btnocultar').show();
    $('#btnmostrar').hide();
}

function ocultacapturakg(){ // permite ocultar el peso manual
    $('#divUnidades2').hide();
    $('#divUnidades2').block();
    $('#divpeso').unblock();
    $('#btnocultar').hide();
    $('#btnmostrar').show();
}*/

function disponibilidad() { //NO SE UTILIZA. Verifica que exista en el inventario los kilos suficientes a los que se piden.
    var nom_articulo = $('#nombreArticulo').val();
    var id_articulo = $('#articulos').find('option[value="'+nom_articulo+'"]').attr('data-id');
    var cantidad = $('#unidades').text();

    $.ajax({
        data: "id_materiaP="+id_articulo+"&consulta=2",
        type: "POST",
        url: "php/datosMateriaP.php",
        success: function(data) {
            if(datos = JSON.parse(data)) {
                var stock = Number(datos[1]);

                if(stock < cantidad) {
                    alert("La cantidad requerida es mayor al inventario.");
                }
            }
        }
    });
}

function agregarArticulo() { //Agrega un articulo a la lista, se toma el precio y se suma al total.
    var nom_articulo = $('#nombreArticulo').val();
    var id_articulo = $('#articulos').find('option[value="'+nom_articulo+'"]').attr('data-id');
    var unidad = $('#articulos').find('option[value="'+nom_articulo+'"]').attr('unidad');
    var precio = $('#precio').val();

    if(unidad != "KG"){
        var cantidad = $('#unds').val();
    }
    else {
        var cantidad = $('#unidades').html();
    }
    var total_art = cantidad * precio;

    if(id_articulo == undefined) {
        alert("Artículo no encontrado");
    }
    else if(cantidad == "" || cantidad < 0) {
        alert("Escriba un número de unidades valido.");
        // $('#unidades').focus();
    }
    else {
        $('#nombreArticulo').val("");
        $('#unds').val("");
        $('#divUnidades').hide();
        $('#precio').val("");
        total = total + total_art;

        $('#detalles').append("<tr id='tr"+indArt+"'><td><a href='#' onclick='quitarArticulo("+indArt+")'><i class='fa fa-minus-square fa-fw'></i></a></td><td>"+cantidad+"</td><td>"+nom_articulo+"</td><td>"+precio+"</td><td>"+total_art.toFixed(2)+"</td><td style='display:none;'>"+id_articulo+"</td><td style='display:none;'>"+unidad+"</td></tr>");
        $('tbody#detalles tr:last td:first input').focus();
        $('#totalArticulos').html($('#detalles tr').length);
        $('#total').val("$" + total.formatMoney(2));
        //otro inputa agregado
        $('#totalFinal').val("$" + total.formatMoney(2));
        $('#nombreArticulo').focus();
        indArt++;
    }
}

function agregarArticulo2() { //Agrega un articulo a la lista, se toma el precio y se suma al total, se utiliza para el peso manual.
    var nom_articulo = $('#nombreArticulo').val();
    var id_articulo = $('#articulos').find('option[value="'+nom_articulo+'"]').attr('data-id');
    var unidad = $('#articulos').find('option[value="'+nom_articulo+'"]').attr('unidad');
    var precio = $('#precio').val();

    if(unidad != "KG"){
        var cantidad = $('#unds').val();
    }
    else {
        var cantidad = $('#undades').val();
    }
    var total_art = cantidad * precio;

    if(id_articulo == undefined) {
        alert("Artículo no encontrado");
    }
    else if(cantidad == "" || cantidad < 0) {
        alert("Escriba un número de unidades valido.");
        // $('#unidades').focus();
    }
    else {
        $('#nombreArticulo').val("");
        $('#unds').val("");
        $('#divUnidades').hide();
        $('#precio').val("");
        total = total + total_art;

        $('#detalles').append("<tr id='tr"+indArt+"'><td><a href='#' onclick='quitarArticulo("+indArt+")'><i class='fa fa-minus-square fa-fw'></i></a></td><td>"+cantidad+"</td><td>"+nom_articulo+"</td><td>"+precio+"</td><td>"+total_art.toFixed(2)+"</td><td style='display:none;'>"+id_articulo+"</td><td style='display:none;'>"+unidad+"</td></tr>");
        $('tbody#detalles tr:last td:first input').focus();
        $('#totalArticulos').html($('#detalles tr').length);
        $('#total').val("$" + total.formatMoney(2));
        //otro inputa agregado
        $('#totalFinal').val("$" + total.formatMoney(2));
        $('#nombreArticulo').focus();
        indArt++;
    }
}


function quitarArticulo(indArtic) { //Se pregunta si se quiere quitar el artiulo y lo remueve de la tabla, resta su precio del total.
    $('#n_articulo').val(indArtic);
    $('#code').val('');

    var pregunta=confirm("¿Seguro que desea quitar el producto?");
        if (pregunta)
        {
            $('#modal_codigo').modal({
                show:true,
                backdrop:'static'
            });
        }
}

function quitarArt()
{
    var n_articulo = $('#n_articulo').val();
    var code = $('#code').val();

    $.ajax({
        data: "code="+code,
        type: "POST",
        url: "php/traer_pass.php",
            success: function(data) {
                if(datos = JSON.parse(data)) {
                var codigo=datos;
                if (codigo==1)
                {
                    //alert("Pass correcto");
                    //var confirmacion = confirm("¿Seguro que quieres remover este artículo?");
                    //if (confirmacion) {
                        var num_total = $('#tr'+n_articulo).find("td").eq(4).html().replace(',','');
                        total = total - num_total;
                        $('#total').val("$" + total.formatMoney(2));
                        $('#inDescuento').val(0.00);//caja de descuento
                        $('#totalFinal').val("$" + total.formatMoney(2));//caja de total final
                        $('#tr'+n_articulo).remove();
                        $('#nombreArticulo').focus();
                        $('#totalArticulos').html($('#detalles tr').length);

                        $('#modal_codigo').modal('hide');
                    //}
                }
                else
                {
                    alert("Código de seguridad incorrecto");
                }

                }
            }
    });
}

function cambio() { //Segun el total va realizando la resta de la cantidad recibida que se introduzca. EFECTIVO

    var forma_pago = $('#forma_pago').val();//select para saber cual es el metodo de pago y ver cual es la condicion

    if (forma_pago=="01")// si la forma seleccionada es en efectivo
    {
        //limpiamos la variable de caja de recibido con tarjeta
        $('#recibidoT').val('');
        //tomamos la varible de de solo en efectivo
        var recibido = $('#recibido').val();//caja de efectivo
        //tomamos la varibable del total con descuento
        var totalFinal = $('#totalFinal').val();//caja con el total ya descontado

        var total_sinpesos = totalFinal.replace('$', '');//quitamos el sino de pesos
        var total_sincoma = total_sinpesos.replace(',', '');//quitamos el sino de pesos
        //hacemos la operacion y ponemos el descontado en la caja de cambio
        var cambio_ = parseFloat(recibido) - parseFloat(total_sincoma);//la variable cambio guarda el resultado

        //alert("RECIBIDO: "+recibido+" TOTAL FINAL CON SIGNOS: "+totalFinal+" CAMBIO: "+cambio_+" TOTAL SIN SIGNOS: "+total_sincoma+" total: "+total);
        $('#cambio_devolver').val(cambio_.formatMoney(2));//la devolvemos a la caja
        // $('#cambio').focus();
    }
    else if (forma_pago=="001" || forma_pago=="002") // si el pago es Efectivo - Tarjeta Debito o Efectivo - Tarjeta Crédito,
        //aqui se le resta a cambio escondido
    {
        var caja_tarjeta = $('#recibidoT').val(); //variable de recibido con tarjeta
        if (caja_tarjeta=='' || caja_tarjeta==null)
        {
            alert("Especifique lo recibido con tarjeta.");
        }
        else
        {
          //tomamos la varible de de solo en efectivo
          var recibido = $('#recibido').val();//caja de efectivo
          //tomamos la varibable del total con descuento
          var totalFinal = $('#cambioEscondido').val();//caja con el total ya descontado
          //hacemos la operacion y ponemos el descontado en la caja de cambio
          var cambio_T = parseFloat(recibido) + parseFloat(totalFinal);//la variable cambio guarda el resultado
          //alert("RECIBIDO: "+recibido+" TOTAL FINAL: "+totalFinal+" CAMBIO: "+cambio_T);
          $('#cambio_devolver').val(cambio_T.formatMoney(2));//la devolvemos a la caja
          // $('#cambio').focus();
        }
    }
}

function cambio2() { //Segun el total va realizando la resta de la cantidad recibida que se introduzca. PAGO CON TARJETA

    var forma_pago = $('#forma_pago').val();//select para saber cual es el metodo de pago
    if (forma_pago != "001" && forma_pago != "002")
    {
        $('#recibidoT').val('');
        $('#recibido').val('');
    }

    else
    {
        $('#recibido').val('');
        document.getElementById("recibido").disabled = true;

        var totalFinal = $('#totalFinal').val();
        var recibido = $('#recibidoT').val();
        //Quitamos los signos
        var total_sinpesos = totalFinal.replace('$', '');//quitamos el sino de pesos
        var total_sincoma = total_sinpesos.replace(',', '');//quitamos el sino de pesos

        var cambio = recibido - total_sincoma;
        //alert("RECIBIDO: "+recibido+" TOTAL FINAL: "+totalFinal+" CAMBIO: "+cambio);
        $('#cambio_devolver').val(cambio.formatMoney(2));
        $('#cambioEscondido').val(cambio.formatMoney(2));
       // document.getElementById("recibido").disabled = false;
    }
}

function pagar() { //Funcion que guardara la venta, verifica que haya articulos agregados, y que se introduzca una cantidad en caso de que sea pago en efectivo.
    var id_cliente = $('#id_cliente').val();
    var nom_cliente = $('#clientes').find('option[value="'+id_cliente+'"]').attr('nom-cl');
    var forma_pago = $('#forma_pago option:selected').val();
    var recibido = $('#recibido').val();
    var recibidoT = $('#recibidoT').val();//recibido de la tarjeta
    var totalFinal = $('#totalFinal').val();//totalFinal con descuento o no
    var nro_mov = $('#nro_mov').val();
    var tipo_tarjeta="";
    var cambio = recibido - totalFinal;
    var suma_recibidos = recibido + recibidoT;



    var rowCount = $('#detalles tr').length;

    if(rowCount == 0) {
        alert("No se han agregado articulos.");
    }
    else {
        if(id_cliente != "" && nom_cliente == undefined) { //En caso que se teclee un cliente que no coincida se mostrara este alert.
            alert("Cliente no encontrado");
        }
        else {
            if(nom_cliente == undefined)
                id_cliente = 0;

            if(forma_pago == "0") {
                alert("Seleccione la forma de pago.");
            }
            else if(forma_pago == "01") {
                if(recibido == "") {
                    alert("Escriba la cantidad recibida.");
                    $('#recibido').focus();
                }
                else {
                    if(parseFloat(recibido) < parseFloat(totalFinal)) {
                        alert("La cantidad recibida es menor que el total.");
                        $('#recibido').focus();
                    }
                    else {

                        factura_confirm(id_cliente, forma_pago);
                    }
                }
            }
            else if (forma_pago == "001") // if si es efectivo con tarjeta de credito
            {
                tipo_tarjeta="04";
                if(nro_mov == "") { // si el numero de movimiento esta vacio
                    alert("Introduce los ultimos 4 digitos de la cuenta o movimiento.");
                    $('#nro_mov').focus();
                }
                else if (recibidoT == "")
                {
                    alert("Escribe la cantidad a pagar con tarjeta y definela.");
                    $('#recibidoT').focus();
                }
                else if (recibido == "")
                {
                    alert("Escribe la cantidad a pagar con efectivo, si la compra solo es con tarjeta elige otro tipo de pago.");
                    $('#recibido').focus();
                }
                else if(parseFloat(suma_recibidos) < parseFloat(totalFinal))
                {
                    alert("La cantidad recibida es menor que el total.");
                    $('#recibido').focus();
                }
                else {
                   factura_confirm(id_cliente, forma_pago);
                   //alert("Vendido!");
                }
            }
            else if (forma_pago == "002") // if si es efectivo con tarjeta de debito
            {
                tipo_tarjeta="28";
                if(nro_mov == "") { // si el numero de movimiento esta vacio
                    alert("Introduce los ultimos 4 digitos de la cuenta o movimiento.");
                    $('#nro_mov').focus();
                }
                else if (recibidoT == "")
                {
                    alert("Escribe la cantidad a pagar con tarjeta y definela.");
                    $('#recibidoT').focus();
                }
                else if (recibido == "")
                {
                    alert("Escribe la cantidad a pagar con efectivo, si la compra solo es con tarjeta elige otro tipo de pago.");
                    $('#recibido').focus();
                }
                else if(parseFloat(suma_recibidos) < parseFloat(totalFinal))
                {
                    alert("La cantidad recibida es menor que el total.");
                    $('#recibido').focus();
                }
                else {
                   factura_confirm(id_cliente, forma_pago);
                   //alert("Vendido!");
                }
            }
            else if(forma_pago != "01") {
                if(nro_mov == "") {
                    alert("Introduce los ultimos 4 digitos de la cuenta o movimiento.");
                    $('#nro_mov').focus();
                }
                else {
                    factura_confirm(id_cliente, forma_pago);
                }
            }
        }
    }
}

function ElimMateriaPrima()
{
    var id_articuloMATPRIM = $('#id_articuloMATPRIM').val();
    var code_MATPRIM = $('#code_MATPRIM').val();
    //alert("Id Articulo: "+id_articuloMATPRIM+" Codigo Seguridad: "+code_MATPRIM);
    var confirmacion = confirm('¿Seguro de eliminar este producto de Materia Prima?');
    if (confirmacion)
    {
        var confirmacion2 =  confirm('¡¡¡ADVERTENCIA!!! Al eliminar este producto de Materia Prima se eliminaran todos los sub-productos que pertenezcan a ella. Si esta seguro presione Aceptar.');
        if (confirmacion2)
        {
            $.ajax({
              data: "code="+code_MATPRIM+"&id_articuloMATPRIM="+id_articuloMATPRIM,
              type: "POST",
              url: "php/eliminarMatPrim.php",
                success: function(data) {
                  if(datos = JSON.parse(data)) {
                    var codigo=datos;
                    if (codigo==1)
                    {
                      alert("Código de seguridad correcto");
                      $('#modal_eliminar').modal('hide');
                      inventario();
                    }
                    else
                    {
                      alert("Código de seguridad incorrecto");
                    }
                  }
                }
            });
        }
    }
}


function ElimProductoHijo()
{
    var id_articuloMATPRIM = $('#id_articuloMATPRIM').val();
    var code_MATPRIM = $('#code_MATPRIM').val();
    //alert("Id Articulo: "+id_articuloMATPRIM+" Codigo Seguridad: "+code_MATPRIM);
    var confirmacion = confirm('¿Seguro de eliminar este producto de Materia Prima?');
    if (confirmacion)
    {
        var confirmacion2 =  confirm('¡¡¡ADVERTENCIA!!! Al eliminar este producto de Materia Prima se eliminaran todos los sub-productos que pertenezcan a ella. Si esta seguro presione Aceptar.');
        if (confirmacion2)
        {
            $.ajax({
              data: "code="+code_MATPRIM+"&id_articuloMATPRIM="+id_articuloMATPRIM,
              type: "POST",
              url: "php/eliminarProducto.php",
                success: function(data) {
                  if(datos = JSON.parse(data)) {
                    var codigo=datos;
                    if (codigo==1)
                    {
                      alert("Código de seguridad correcto");
                      $('#modal_eliminar').modal('hide');
                      productos();
                    }
                    else
                    {
                      alert("Código de seguridad incorrecto");
                    }
                  }
                }
            });
        }
    }
}

function elimProducto(id_articulo)
{
    //alert("Hola articulo: "+id_articulo);
    //$('#myModalLabel').text("Registro Materia Prima");
    $('#id_articuloMATPRIM').val(id_articulo);
    $('#code_MATPRIM').val('');

    $('#modal_eliminar').modal({
        show: true,
        backdrop: 'static'
    });
}

function elimArticulo(id_articulo)
{
    //alert("Hola articulo: "+id_articulo);
    //$('#myModalLabel').text("Registro Materia Prima");
    $('#id_articuloMATPRIM').val(id_articulo);
    $('#code_MATPRIM').val('');

    $('#modal_eliminar').modal({
        show: true,
        backdrop: 'static'
    });
}

function factura_confirm(id_cliente, forma_pago) { //Se reciben datos de la venta y pregunta si se quiere facturar, en caso de que si se verifica si un cliente fue seleccionado, de lo contrario se muestra un formulario para que registre uno nuevo.
    if(id_cliente == 0) {
        var confirmacion = confirm("¿Desea facturar la venta?");
        if (confirmacion) {
            $('#modal_cliente').modal({
                show:true,
                backdrop:'static'
            });
        } else {
            guarda_venta(id_cliente, forma_pago);//el cliente es 0 y forma de pago 01
        }
    }
    else {
        guarda_venta(id_cliente, forma_pago);
    }
}

function definir()
{
    //alert("Definir");
    document.getElementById("recibidoT").disabled = true;
    document.getElementById("recibido").disabled = false;
    $('#div_botonD').hide();// escondemos cantidad de la tarjeta
    $('#div_botonC').show();// escondemos cantidad de la tarjeta
}

function cambiar()
{
    //alert("cambiar");
    document.getElementById("recibidoT").disabled = false;
    $('#recibido').val('');
    document.getElementById("recibido").disabled = true;
    $('#div_botonC').hide();// escondemos cantidad de la tarjeta
    $('#div_botonD').show();// escondemos cantidad de la tarjeta
}

function muestra_recibido() { //Muestra u oculta el input para introducir la cantidad recibida, segun el tipo de pago seleccionado.
    var opcion = $('#forma_pago option:selected').val();
    if(opcion == "01") {
        document.getElementById("recibido").disabled = false;//activamos la casilla de efectivo
        $('#recibido').val('');
        $('#recibidoT').val('');
        $('#div_recibido').show();
        $('#div_nroMovimiento').hide();
        $('#div_recibidoT').hide();// escondemos cantidad de la tarjeta
        $('#div_botonD').hide();// escondemos cantidad de la tarjeta
        $('#div_botonC').hide();// escondemos cantidad de la tarjeta
    }
    else if(opcion == "001" || opcion == "002") {
        document.getElementById("recibido").disabled = true;//desactivamos la casilla de efectivo
        $('#recibido').val('');
        $('#recibidoT').val('');
        $('#div_nroMovimiento').show();
        $('#div_recibidoT').show();// mostramos cantidad de la tarjeta
        $('#div_botonD').show();// escondemos cantidad de la tarjeta
        $('#div_botonC').hide();// escondemos cantidad de la tarjeta
        $('#div_recibido').show();
        document.getElementById("recibidoT").disabled = false;//activamos la casilla de efectivo
    }
    else if(opcion != "01" && opcion != "0" && opcion != "001" && opcion != "002") {
        document.getElementById("recibido").disabled = false;//activamos la casilla de efectivo
        $('#recibido').val('');
        $('#recibidoT').val('');
        $('#div_nroMovimiento').show();
        $('#div_recibido').hide();
        $('#div_recibidoT').hide();// escondemos cantidad de la tarjeta
        $('#div_botonD').hide();// escondemos cantidad de la tarjeta
        $('#div_botonC').hide();// escondemos cantidad de la tarjeta
    }
    else {
        document.getElementById("recibido").disabled = false;//activamos la casilla de efectivo
        $('#recibido').val('');
        $('#recibidoT').val('');
        $('#div_recibido').hide();
        $('#div_nroMovimiento').hide();
        $('#div_recibidoT').hide();// escondemos cantidad de la tarjeta
        $('#div_botonD').hide();// escondemos cantidad de la tarjeta
        $('#div_botonC').hide();// escondemos cantidad de la tarjeta
    }
}

function guarda_venta(id_cliente, forma_pago) { //Llegan los datos de la funcion Factura, y guarda la venta.
    var venta = [];
    var indVenta = 0;
    var id_vendedor = $('#Vendedor').attr('data');


    $('#detalles tr').each(function () { //Lee todos los productos que fueron agregados a la tabla y los guarda en un arreglo.
        var id_articulo = $(this).find("td").eq(5).html();
        var cantidad = $(this).find("td").eq(1).html();
        var nom_articulo = $(this).find("td").eq(2).html();
        var precio = $(this).find("td").eq(3).html();
        var total_art = $(this).find("td").eq(4).html();
        var unidad = $(this).find("td").eq(6).html();

        venta[indVenta] = [id_articulo, precio, cantidad, total_art, unidad, nom_articulo];
        indVenta++;
    });

    var ventaJSON = JSON.stringify(venta);

    if (forma_pago=="001" || forma_pago=="002")
    {
        var nro_mov = $('#nro_mov').val();
        var recibido = $('#recibido').val();
        var recibidoT = $('#recibidoT').val();
        var cambio = $('#cambio_devolver').val();
        var total_descontado = parseFloat(recibido) -  parseFloat(cambio);

        var totalFinal = $('#totalFinal').val();//total descontado
        var total_sinpesos = totalFinal.replace('$', '');//quitamos el sino de pesos
        var total_sincoma = total_sinpesos.replace(',', '');//quitamos el sino de pesos
        var descuento = $('#descuento').val();
        var inDescuento = $('#inDescuento').val();

        //alert("inDescuento: "+inDescuento+" descuento: "+descuento+"venta="+ventaJSON+"&total="+total+"&Total final: "+total_sincoma+"&id_cliente="+id_cliente+"&forma_pago="+forma_pago+"&vendedor="+id_vendedor+"&nro_mov="+nro_mov+"&recibido="+total_descontado+"&recibidoT="+recibidoT);
        $.ajax({ //Se envia el arreglo mas algunos datos adicionales.
        data: "venta="+ventaJSON+"&total="+total_sincoma+"&subtotal="+total+"&porcentaje="+descuento+"&inDescuento="+inDescuento+"&id_cliente="+id_cliente+"&forma_pago="+forma_pago+"&vendedor="+id_vendedor+"&nro_mov="+nro_mov+"&recibido="+total_descontado+"&recibidoT="+recibidoT,
        type: "POST",
        url: "php/guardar_venta_2.php",
        beforeSend: function() {
            $.blockUI({
                message: '<h3>Se esta guardando la venta...</h3><img src="img/loader.gif">',
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .6,
                    color: '#fff',
                    cursor:'default',
                }
            });
        },
        success: function(data) { //Se recibe el mensaje y dependiendo de este se llama a una funcion que genera el ticket. Luego se redireccion al historial de ventas.
            $.unblockUI();
            // alert(data);
            var datos = JSON.parse(data);
            alert(datos.mens);
            if(datos.id_venta != undefined)
                imprimirTicket(datos.id_venta);//imrpimimos el ticjet con la venta que regresa el array

            //window.location = "./ventas_vendedor.php";
            //location.reload();
        }
        });

    }

    else
    {
        var totalFinal = $('#totalFinal').val();//total descontado
        var total_sinpesos = totalFinal.replace('$', '');//quitamos el sino de pesos
        var total_sincoma = total_sinpesos.replace(',', '');//quitamos el sino de pesos
        var porcentaje_descuento = $('#totalFinal').val();//quitamos el sino de pesos
        var recibido = $('#recibido').val();//recibido
        var nro_mov = $('#nro_mov').val();
        var descuento = $('#descuento').val();
        var inDescuento = $('#inDescuento').val();

        //alert("venta: " +ventaJSON+" total= "+total+" Total final: "+total_sincoma+" id_cliente: "+id_cliente+" forma_pago: "+forma_pago+" vendedor: "+id_vendedor+" nro_mov: "+nro_mov+" recibido: "+recibido);

        $.ajax({ //Se envia el arreglo mas algunos datos adicionales.
            data: "venta="+ventaJSON+"&subtotal="+total+"&porcentaje="+descuento+"&inDescuento="+inDescuento+"&total="+total_sincoma+"&id_cliente="+id_cliente+"&forma_pago="+forma_pago+"&vendedor="+id_vendedor+"&nro_mov="+nro_mov,
            type: "POST",
            url: "php/guardar_venta.php",
            beforeSend: function() {
                $.blockUI({
                    message: '<h3>Se esta guardando la venta...</h3><img src="img/loader.gif">',
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .6,
                        color: '#fff',
                        cursor:'default',
                    }
                });
            },
            success: function(data) { //Se recibe el mensaje y dependiendo de este se llama a una funcion que genera el ticket. Luego se redireccion al historial de ventas.
                $.unblockUI();
                //alert(data);
                var datos = JSON.parse(data);
                //alert(datos.mens);
                if(datos.id_venta != undefined)
                    imprimirTicket(datos.id_venta);//imrpimimos el ticjet con la venta que regresa el array

                //window.location = "./ventas_vendedor.php";
                //location.reload();
            }
        });

    }
}

function imprimirTicket(id_venta) { //Se envia el id de la venta a un php que crea el pdf y lo manda a imprimir en automatico.
    // if($('#forma_pago option:selected').val() == "01") {
    //     var recibido = $('#recibido').val();
    //     var cambio = recibido - total;
    // }
    // else {
    //     var recibido = total;
    //     var cambio = 0;
    // }
    var totalFinal = $('#totalFinal').val();//total descontado
    var total_sinpesos = totalFinal.replace('$', '');//quitamos el sino de pesos
    var total_sincoma = total_sinpesos.replace(',', '');//quitamos el sino de pesos
    var ventanaActual= window.location.pathname; //se captura el nombre de la ruta

    if($('#forma_pago option:selected').val() == "01") {
        var recibido = $('#recibido').val();
        var cambio = parseFloat(recibido) -  parseFloat(total_sincoma);
    }
    else if ($('#forma_pago option:selected').val() == "001" || $('#forma_pago option:selected').val() == "002")
    {
        var recibidoE = $('#recibido').val();
        var recibidoT = $('#recibidoT').val();
        var recibido = parseFloat(recibidoT) + parseFloat(recibidoE);
        var cambio = parseFloat(recibido) - parseFloat(total_sincoma);
    }
    else {
        var recibido = total;
        var cambio = 0;
    }

     //alert("id_venta: "+id_venta+" recibido: "+recibido+" cambio: "+cambio+" total descuento: "+total_sincoma);
    window.open("./imprime.php?id_venta="+id_venta+"&recibido="+recibido+"&cambio="+cambio,'','width=600,height=400,left=50,top=50,toolbar=yes');
    if (ventanaActual == "/Punto_Venta%20v3/punto_venta2.php") {
        window.location="./punto_venta2.php";
    }
    else{
        window.location="./punto_venta.php";
    }
    // $.ajax({
    //     data: "id_venta="+id_venta+"&recibido="+recibido+"&cambio="+cambio,
    //     type: "GET",
    //     url: "imprime.php",
    //     success: function(data) {
    //         window.location = "./punto_venta.php";
    //     }
    // });

}

function clientes(tipo_consulta) { //Trae todos los clientes existentes en la base de datos.
    $.ajax({
        data: "tipo_consulta="+tipo_consulta,
        type: "POST",
        url: "php/buscaClientes.php",
        success: function(data) {
            $('#divClientes').html(data);
            $('#tabla').DataTable({ responsive: true });
        }
    });
}

function modificarCliente(id_cliente) { 
        datos_cliente(id_cliente);
        $('#modal_cliente').modal({
            show:true,
            backdrop:'static'
        });
}

function datos_cliente(id_cliente) { //Trae los datos del cliente el se mando su id.
    $.ajax({
        data: "id_cliente="+id_cliente,
        type: "POST",
        url: "php/datosCliente.php",
        success: function(data) {
            if(datos = JSON.parse(data)) {
                $('#id_cliente').val(id_cliente);
                $('#rfc_cliente').val(datos[0]);
                $('#nom_cliente').val(datos[1]);
                $('#calle_cliente').val(datos[2]);
                $('#noExt_cliente').val(datos[3]);
                $('#col_cliente').val(datos[4]);
                $('#municipio_cliente').val(datos[5]);
                $('#edo_cliente').val(datos[6]);
                $('#pais_cliente').val(datos[7]);
                $('#cp_cliente').val(datos[8]);
            }
        }
    });
}

function actualizaCliente() { //Funcion que guarda los datos actualizados de un cliente, se verifica que no se manden datos vacios.
    var id_cliente = $('#id_cliente').val();
    var rfc_cliente = $('#rfc_cliente').val();
    var nom_cliente = $('#nom_cliente').val();
    var calle_cliente = $('#calle_cliente').val();
    var noExt_cliente = $('#noExt_cliente').val();
    var col_cliente = $('#col_cliente').val();
    var municipio_cliente = $('#municipio_cliente').val();
    var edo_cliente = $('#edo_cliente').val();
    var pais_cliente = $('#pais_cliente').val();
    var cp_cliente = $('#cp_cliente').val();
    var forma_pago = $('#forma_pago option:selected').val();

    if(rfc_cliente == "") {
        alert("Debe introducir el RFC.");
        $('#rfc_cliente').focus();
    }
    else if(nom_cliente == "") {
        alert("Debe introducir el nombre.");
        $('#nom_cliente').focus();
    }
    else if(calle_cliente == "") {
        alert("Debe introducir la calle.");
        $('#calle_cliente').focus();
    }
    else if(noExt_cliente == "") {
        alert("Debe introducir el número exterior.");
        $('#noExt_cliente').focus();
    }
    else if(col_cliente == "") {
        alert("Debe introducir la colonia.");
        $('#col_cliente').focus();
    }
    else if(municipio_cliente == "") {
        alert("Debe introducir el municipio.");
        $('#municipio_cliente').focus();
    }
    else if(edo_cliente == "") {
        alert("Debe introducir el Estado.");
        $('#edo_cliente').focus();
    }
    else if(pais_cliente == "") {
        alert("Debe introducir el país.");
        $('#pais_cliente').focus();
    }
    else if(cp_cliente == "") {
        alert("Debe introducir el código postal.");
        $('#cp_cliente').focus();
    }
    else {
        $.ajax({
            data: "id_cliente="+id_cliente+"&rfc_cliente="+rfc_cliente+"&nom_cliente="+nom_cliente+"&calle_cliente="+calle_cliente+"&noExt_cliente="+noExt_cliente+"&col_cliente="+col_cliente+"&municipio_cliente="+municipio_cliente+"&edo_cliente="+edo_cliente+"&pais_cliente="+pais_cliente+"&cp_cliente="+cp_cliente,
            type: "POST",
            url: "php/guardar_cliente.php",
            success: function(data) {
                alert(data);
                $('#modal_cliente').modal('hide');
                clientes(2);
            }
        });
    }
}

function eliminarCliente() { //Funcion que lee los ids de los clientes seleccionados y los elimina.
    var id_clientes = [], i = 0;

    $("input:checkbox[class='cbSelect']:checked").each(function() {
        id_clientes[i] = $(this).val();
        i++;
    });

    if(i == 0) {
        alert("Seleccione minimo un cliente de la lista.")
    }
    else {
        var confirmacion = confirm("¿Está seguro de eliminar el cliente seleccionado?");
        if (confirmacion) {
            $.ajax({
                data: {id_clientes: id_clientes},
                type: "POST",
                url: "php/eliminarCliente.php",
                success: function(data) {
                    alert(data);
                    clientes(2);
                }
            });
        }
    }
}

function guardarCliente(tipo_guardar) { //Funcion para guardar un nuevo cliente, lee todos los datos correspondientes y verifica que no se dejen datos vacios.
    var id_cliente = $('#id_cliente').val();
    var rfc_cliente = $('#rfc_cliente').val();
    var nom_cliente = $('#nom_cliente').val();
    var calle_cliente = $('#calle_cliente').val();
    var noExt_cliente = $('#noExt_cliente').val();
    var col_cliente = $('#col_cliente').val();
    var municipio_cliente = $('#municipio_cliente').val();
    var edo_cliente = $('#edo_cliente').val();
    var pais_cliente = $('#pais_cliente').val();
    var cp_cliente = $('#cp_cliente').val();
    var forma_pago = $('#forma_pago option:selected').val();

    if(id_cliente == "") {
        if(rfc_cliente == "") {
            alert("Debe introducir el RFC.");
            $('#rfc_cliente').focus();
        }
        else if(nom_cliente == "") {
            alert("Debe introducir el nombre.");
            $('#nom_cliente').focus();
        }
        else if(calle_cliente == "") {
            alert("Debe introducir la calle.");
            $('#calle_cliente').focus();
        }
        else if(noExt_cliente == "") {
            alert("Debe introducir el número exterior.");
            $('#noExt_cliente').focus();
        }
        else if(col_cliente == "") {
            alert("Debe introducir la colonia.");
            $('#col_cliente').focus();
        }
        else if(municipio_cliente == "") {
            alert("Debe introducir el municipio.");
            $('#municipio_cliente').focus();
        }
        else if(edo_cliente == "") {
            alert("Debe introducir el Estado.");
            $('#edo_cliente').focus();
        }
        else if(pais_cliente == "") {
            alert("Debe introducir el país.");
            $('#pais_cliente').focus();
        }
        else if(cp_cliente == "") {
            alert("Debe introducir el código postal.");
            $('#cp_cliente').focus();
        }
        else {
            $.ajax({
                data: "id_cliente="+id_cliente+"&rfc_cliente="+rfc_cliente+"&nom_cliente="+nom_cliente+"&calle_cliente="+calle_cliente+"&noExt_cliente="+noExt_cliente+"&col_cliente="+col_cliente+"&municipio_cliente="+municipio_cliente+"&edo_cliente="+edo_cliente+"&pais_cliente="+pais_cliente+"&cp_cliente="+cp_cliente,
                type: "POST",
                url: "php/guardar_cliente.php",
                success: function(data) {
                    var datos = JSON.parse(data);
                    if(tipo_guardar == 1) {
                        if(datos.status) {
                            $('#modal_cliente').modal('hide');
                            guarda_venta(datos.id_cliente, forma_pago);
                        }
                        else {
                            alert(datos.res);
                        }
                    }
                    else if(tipo_guardar == 2) {
                        if(datos.status) {
                            var id_venta = $('#id_venta').val();
                            facturar(id_venta, datos.id_cliente);
                        }
                        else {
                            alert(datos.res);
                        }
                    }
                }
            });
        }
    }
    else {
        var id_venta = $('#id_venta').val();
        facturar(id_venta, id_cliente);
    }
}

function corte() { //Funcion para realizar el corte del dia o de un rango de fecha establecido
    var desde = $('#fechaDesde').val();
    var hasta = $('#fechaHasta').val();
    var id_user = $('#vendedores option:selected').val();
    var tipo_corte = 1;
    var tipo_corte = $('#cortePor option:selected').val();

    if(hasta < desde)
        alert("El rango de fecha no es valido.")
    else {
        if(id_user != 0) {
            if(tipo_corte == 2) {
                $.ajax({
                    data: "desde="+desde+"&hasta="+hasta+"&id_user="+id_user,
                    type: "POST",
                    url: "php/corteDeCaja.php",
                    success: function(data) {
                        // alert(data);
                        $("#divTablas").html(data);
                    }
                });
            }
            else if(tipo_corte == 1) {
                $.ajax({
                    data: "desde="+desde+"&hasta="+hasta+"&id_user="+id_user+"&tipo_corte="+tipo_corte,
                    type: "POST",
                    url: "php/corteDeCajaT.php",
                    success: function(data) {
                        // alert(data);
                        $("#divTablas").html(data);
                    }
                });
            }
            else {
                alert("Seleccione un tipo");
                $('#cortePor').focus();
            }
        }
        else {
            alert("Seleccione un vendedor");
            $('#vendedores').focus();
        }
    }
}

function terminarcorte() { //Funcion para realizar el corte del dia o de un rango de fecha establecido
    var desde = $('#fechaDesde').val();
    var hasta = $('#fechaHasta').val();
    var id_user = $('#vendedores option:selected').val();
    var tipo_corte = 1;
    var tipo_corte = $('#cortePor option:selected').val();

    if(hasta < desde)
        alert("El rango de fecha no es valido.")
    else {
        if(id_user != 0) {
            if(tipo_corte == 2) {
                $.ajax({
                    data: "desde="+desde+"&hasta="+hasta+"&id_user="+id_user,
                    type: "POST",
                    url: "php/finalizarCorte.php",
                    success: function(data) {
                        // alert(data);
                        $("#divTablas").html(data);
                    }
                });
            }
            else if(tipo_corte == 1) {
                $.ajax({
                    data: "desde="+desde+"&hasta="+hasta+"&id_user="+id_user+"&tipo_corte="+tipo_corte,
                    type: "POST",
                    url: "php/finalizarCorteT.php",
                    success: function(data) {
                        // alert(data);
                        $("#divTablas").html(data);
                    }
                });
            }
            else {
                alert("Seleccione un tipo");
                $('#cortePor').focus();
            }
        }
        else {
            alert("Seleccione un vendedor");
            $('#vendedores').focus();
        }
    }
}


function usuarios(tipo_consulta, id_user) { //Funcion para traer todos los usuarios existentes en la base de datos o los datos de un usuario en especifico.
    $.ajax({
        data: "tipo_consulta="+tipo_consulta+"&id_user="+id_user,
        type: "POST",
        url: "php/buscaUsuarios.php",
        success: function(data) {
            if(tipo_consulta == 3) {
                var datos = JSON.parse(data);
                $('#id_user').val(datos[0]);
                $('#nom_user').val(datos[1]);
                $('#direc_user').val(datos[2]);
                $('#tel_user').val(datos[3]);
                $('#email_user').val(datos[4]);
                $('#user_user').val(datos[5]);
                $('#tipo_user').val(datos[7]);
                $('#sucursal').val(datos[8]);
            }
            else {
                $('#divUsuarios').html(data);
                $('#tabla').DataTable({ responsive: true });
            }
        }
    });
}

function guardarUsuario() { //Funcion para guardar un nuevo usuario, lee todos los datos de los registros y verifica que se introduzcan todos los datos importantes.
    var id_user = $('#id_user').val();
    var user_user = $('#user_user').val();
    var pass_user = $('#pass_user').val();
    var tipo_user = $('#tipo_user option:selected').val();
    var nom_user = $('#nom_user').val();
    var direc_user = $('#direc_user').val();
    var tel_user = $('#tel_user').val();
    var email_user = $('#email_user').val();
    var sucursal = $('#sucursal').val();

    if(user_user == "") {
        alert("Debe introducir un nombre de usuario.");
        $('#user_user').focus();
    }
    else if(id_user == "" && pass_user == "") {
        alert("Debe introducir una contraseña.");
        $('#pass_user').focus();
    }
    else if(tipo_user == "0") {
        alert("Debe seleccionar un tipo de usuario.");
        $('#tipo_user').focus();
    }
    else if(nom_user == "") {
        alert("Debe introducir un nombre.");
        $('#nom_user').focus();
    }
    else if(tel_user == "") {
        alert("Debe introducir un numero de teléfono.");
        $('#tel_user').focus();
    }
    else {
        $.ajax({
            data: "id_user="+id_user+"&user_user="+user_user+"&pass_user="+pass_user+"&tipo_user="+tipo_user+"&nom_user="+nom_user+"&direc_user="+direc_user+"&tel_user="+tel_user+"&email_user="+email_user+"&sucursal="+sucursal,
            type: "POST",
            url: "php/guardar_usuario.php",
            success: function(data) {
                if(data == "Usuario actualizado correctamente." || data == "Usuario insertado correctamente.") {
                    alert("Guardado correctamente");
                    location.reload();
                } else {
                    alert("Usuario no guardado");
                }
            }
        });
    }
}

function modificarUsuario(id_usuarios) { //Lee el id de un cliente que se haya seleccionado, trae sus datos y los muestra en una modal.
    document.getElementById("formuser").reset();
 
    if (id_usuarios == "") {
        $('#modal_user').modal({
            show:true,
            backdrop:'static'
        });
     } else {   
        usuarios(3, id_usuarios);

        $('#modal_user').modal({
            show:true,
            backdrop:'static'
        });
     }
}

function eliminarUsuario(id_usuarios) {

    var confirmacion = confirm("¿Está seguro de eliminar el usuario seleccionado?");
    if (confirmacion) {

        $.ajax({
            data: {id_users: id_usuarios},
            type: "POST",
            url: "php/eliminarUser.php",
            success: function(data) {
                alert(data);
                location.reload();
            }
        });
    }
}



function devolucion() {
    $('#modal_devolucion').modal({
        show:true,
        backdrop:'static'
    });
    $('#nro_venta').focus();
}

function buscaVenta() {
    var nro_venta = $('#nro_venta').val();

    if(nro_venta != "") {
        // alert(nro_venta);
        $.ajax({
            data: "id_venta="+nro_venta,
            type: "POST",
            url: "php/buscaVenta.php",
            success: function(data) {
                $('#detallesDevolucion').html(data);
                var totalVenta = 0;
                $('#detallesDevolucion tr').each(function () {
                    var total_art = $(this).find("td").eq(4).html() * 1;
                    totalVenta = totalVenta + total_art;
                });
                totalDev = totalVenta;
                $('#totalDevolucion').val("$" + totalDev.formatMoney(2));


                // $('#modal_devolucion').modal('hide');
            }
        });
    }
}

function quitarArticuloDev(indArtic) { //Se pregunta si se quiere quitar el artiulo y lo remueve de la tabla, resta su precio del total.
    var confirmacion = confirm("¿Seguro que quieres remover este artículo?");
    if (confirmacion) {
        var num_total = $('#trDev'+indArtic).find("td").eq(4).html().replace(',','');
        totalDev = totalDev - num_total;
        $('#totalDevolucion').val("$" + totalDev.formatMoney(2));
        $('#trDev'+indArtic).remove();
    }
}

function devolver() {
    if(totalDev == 0) {
        alert("No puede generar una nota de credito por un total de 0.");
    }
    else {
        var conceptos = [];
        var indVenta = 0;
        var idVenta = $('#nro_venta').val();

        $('#detallesDevolucion tr').each(function () { //Lee todos los productos que fueron agregados a la tabla y los guarda en un arreglo.
            var id_articulo = $(this).find("td").eq(5).html();
            var cantidad = $(this).find("td").eq(1).html();
            var nom_articulo = $(this).find("td").eq(2).html();
            var precio = $(this).find("td").eq(3).html();
            var total_art = $(this).find("td").eq(4).html();
            var unidad = $(this).find("td").eq(6).html();

            conceptos[indVenta] = [id_articulo, precio, cantidad, total_art, unidad, nom_articulo];
            indVenta++;
        });

        var conceptosJSON = JSON.stringify(conceptos);

        $.ajax({
            data: "conceptos="+conceptosJSON+"&total="+totalDev+"&idVenta="+idVenta,
            type: "POST",
            url: "php/guardar_notaCredito.php",
            beforeSend: function() {
                $('#modal_devolucion').modal('hide');
                $.blockUI({
                    message: '<h3>Se esta guardando la nota...</h3><img src="img/loader.gif">',
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .6,
                        color: '#fff',
                        cursor:'default',
                    }
                });
            },
            success: function(data) {
                $.unblockUI();
                // alert(data);
                var datos = JSON.parse(data);
                alert(datos.mens);
                if(datos.mens == "Guardado correctamente") {
                    $('#detallesDevolucion').html("");
                    $('#totalDevolucion').val("");
                    $('#nro_venta').val("");
                }
                // else {
                //     $('#modal_devolucion').modal({
                //         show:true,
                //         backdrop:'static'
                //     });
                // }
            }
        });
    }
}

function notasCredito() {
    $.ajax({
        data: "tipo_consulta=1",
        type: "POST",
        url: "php/buscaNotasC.php",
        success: function(data) {
            $('#divNC').html(data);
            $('#tabla').DataTable({ responsive: true, order: [[ 0, "desc" ]] });
        }
    });
}

function filtroFecha_NC() {
    var desde = $('#fechaNCDesde').val();
    var hasta = $('#fechaNCHasta').val();

    if(hasta < desde)
        alert("El rango de fecha no es valido.");
    else {
        $.ajax({
            data: "tipo_consulta=2&desde="+desde+"&hasta="+hasta,
            type: "POST",
            url: "php/buscaNotasC.php",
            success: function(data) {
                $('#divNC').html(data);
                $('#tabla').DataTable({ responsive: true, order: [[ 0, "desc" ]] });
            }
        });
    }
}

function GenerarXMLNC(id_xml) {
    window.location = "php/crearXMLNC.php?id_xml="+id_xml;
}

function GenerarPDFNC(id_xml) {
    window.location = "php/crearPDFNC.php?id_xml="+id_xml;
}

function retirar() {
    $('#cant_retirar').val("");
    $('#codigo_aut').val("");

    $('#modal_retiro').modal({
        show:true,
        backdrop:'static'
    });
}

function realiza_retiro() {
    var cant_retirar = $('#cant_retirar').val();
    var codigo_aut = $('#codigo_aut').val();

    if(cant_retirar == "" || cant_retirar <= 0) {
        alert("Introduzca una cantidad valida");
    }
    else {
        $.ajax({
            data: "cant_retirar="+cant_retirar+"&codigo_aut="+codigo_aut,
            type: "POST",
            url: "php/retiro.php",
            success: function(data) {
                alert(data);

                if(data == "Se ha realizado el retiro correctamente") {
                    $('#modal_retiro').modal('hide');
                    window.open("./imprime_retiros.php?cant_retirar="+cant_retirar,'','width=600,height=400,left=50,top=50,toolbar=yes');
                    window.location="./modulos.php";
                }
            }
        });
    }
}

function nueva_caja()
{
    //alert("Hola");
    $('#usuarios').val(0);
    $('#limite_caja2').val('');
    $('#minimo_caja2').val('');

    $('#modal_caja_nueva').modal({
        show:true,
        backdrop:'static'
    });
}

function cajas() {
    $.ajax({
        data: "",
        type: "POST",
        url: "php/buscaCajas.php",
        success: function(data) {
            $('#divCajas').html(data);
            $('#tabla').DataTable({ responsive: true });
        }
    });
}

function guardar_caja()
{
    var usuarios=document.getElementById('usuarios').value;
    var limite=document.getElementById('limite_caja2').value;
    var minimo=document.getElementById('minimo_caja2').value;

    if (usuarios==0 || usuarios=="0")
    {
        alert("Seleccione a un usuario para asignar a la nueva caja.");
        $('#usuarios').focus();
    }
    else if (limite==0 || limite=='' || limite=="0")
    {
        alert("Debe escribir la cantidad limite de la caja"),
         $('#limite_caja2').focus();
    }
    else if (minimo==0 || minimo=='' || minimo=="0")
    {
        alert("Debe escribir la cantidad minima de la caja"),
        $('#minimo_caja2').focus();
    }
    else
    {
        var confirmacion=confirm("¿Seguro de guardar la información?");
        if (confirmacion)
        {
            $.ajax({
              data: "usuarios="+usuarios+"&limite="+limite+"&minimo="+minimo,
              type: "POST",
              url: "php/guardar_caja.php",
              success: function(data) {
                alert(data);
                if(data == "Se han guardado correctamente los datos") {
                location.reload();
                }
              }
            });
        }
    }
}

function editarCaja(id_caja, limite, minimo) {
    $('#id_caja').val(id_caja);
    $('#limite_caja').val(limite);
    $('#minimo_caja').val(minimo);

    $('#modal_caja').modal({
        show:true,
        backdrop:'static'
    });
}

function edit_caja() {
    var id_caja = $('#id_caja').val();
    var limite_caja = $('#limite_caja').val();
    var minimo_caja = $('#minimo_caja').val();

    $.ajax({
        data: "id_caja="+id_caja+"&limite_caja="+limite_caja+"&minimo_caja="+minimo_caja,
        type: "POST",
        url: "php/modifica_caja.php",
        success: function(data) {
            alert(data);

            if(data == "Se han modificado correctamente los datos") {
                $('#modal_caja').modal('hide');

                cajas();
            }
        }
    });
}

/************************************** OTRAS FUNCIONES **************************************/
function GenerarXML(id_xml) {
    window.location = "php/crearXML.php?id_xml="+id_xml;
}

function GenerarPDF(id_xml) {
    window.location = "php/crearPDF.php?id_xml="+id_xml;
}

function verVMenudeo() {
    if($('#detMenudeo').text() == "Ver Detalles") {
        $('#tbVMenudeo').show();
        $('#detMenudeo').text("Ocultar Detalles");
    }
    else {
        $('#tbVMenudeo').hide();
        $('#detMenudeo').text("Ver Detalles");
    }
}

function verVTC() {
    if($('#detTC').text() == "Ver Detalles") {
        $('#tbVTC').show();
        $('#detTC').text("Ocultar Detalles");
    }
    else {
        $('#tbVTC').hide();
        $('#detTC').text("Ver Detalles");
    }
}

function verVTD() {
    if($('#detTD').text() == "Ver Detalles") {
        $('#tbVTD').show();
        $('#detTD').text("Ocultar Detalles");
    }
    else {
        $('#tbVTD').hide();
        $('#detTD').text("Ver Detalles");
    }
}

function verVTrans() {
    if($('#detTrans').text() == "Ver Detalles") {
        $('#tbVTrans').show();
        $('#detTrans').text("Ocultar Detalles");
    }
    else {
        $('#tbVTrans').hide();
        $('#detTrans').text("Ver Detalles");
    }
}

function verVCheque() {
    if($('#detCheque').text() == "Ver Detalles") {
        $('#tbVCheque').show();
        $('#detCheque').text("Ocultar Detalles");
    }
    else {
        $('#tbVCheque').hide();
        $('#detCheque').text("Ver Detalles");
    }
}

function verVMayoreo() {
    if($('#detMayoreo').text() == "Ver Detalles") {
        $('#tbVMayoreo').show();
        $('#detMayoreo').text("Ocultar Detalles");
    }
    else {
        $('#tbVMayoreo').hide();
        $('#detMayoreo').text("Ver Detalles");
    }
}

function verAbonos() {
    if($('#detAbonos').text() == "Ver Detalles") {
        $('#tbAbonos').show();
        $('#detAbonos').text("Ocultar Detalles");
    }
    else {
        $('#tbAbonos').hide();
        $('#detAbonos').text("Ver Detalles");
    }
}

function limpiaModal() { //Limpia o nullifica los input
    $('#id_materiaP').val("");
    $('#nom_materiaP').val("");
    $('#stock_materiaP').val("");
    $('#reorden_materiaP').val("");

    $('#id_producto').val("");
    $('#nom_producto').val("");
    $('#clave_producto').val("");
    $('#precio_producto').val("");
    $('#id_matP').val(0);
}

function seleccionatodo()//Funcion para marcar todos los checkbox
{
    var selectall = document.getElementById("cbSelectAll");//Se lee el checkbox que accionara a los demas.
    var checkboxes = document.getElementsByClassName("cbSelect");//Se leen todos los checkbox que se marcaran.

    selectall.addEventListener("change", function(e){ //Si se lee un cambio en el checkbox principal todos los demas checkbox se marcaran o desmarcaran segun este el principal.
        for (i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = selectall.checked;
        }
    });

    for (var i = 0; i < checkboxes.length; i++) {//Se hace un recorrido por todos los checkbox, si alguno no esta marcado se desmarca el principal.
        checkboxes[i].addEventListener('change', function(e){
            if(this.checked == false) {
                selectall.checked = false;
            }
            //Si se marcaron individualmente todos los checkbox el principal tambien se marcara.
            if(document.querySelectorAll('.cbSelect:checked').length == checkboxes.length) {
                selectall.checked = true;
            }
        });
    }
}

Number.prototype.formatMoney = function(c, d, t) { //Esta funcion devuelve una formato de dinero Ejemplo: 1000.00
    var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "." : d,
    t = t == undefined ? "," : t, s = n < 0 ? "-" : "", i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), j = (j = i.length) > 3 ? j % 3 : 0;

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}
