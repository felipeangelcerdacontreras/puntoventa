<?php
    session_start();

    if($_SESSION['logged'] != "OK") die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de clientes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../html/img/favicon.png">
    <link href="../../html/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../../html/css/sb-admin-2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="../../html/js/jquery.min.js"></script>
    <script src="../../html/js/bootstrap.min.js"></script>
    <script src="../../html/js/punto_venta_vende.js"></script>
    <script src="../../html/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../../html/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            clientes(2);
        });

        function clientes(tipo_consulta) { //Trae todos los clientes existentes en la base de datos.
            $.ajax({
                data: "tipo_consulta="+tipo_consulta,
                type: "POST",
                url: "../../models/clientesRegistrados.php",
                success: function(data) {
                    $('#divClientes').html(data);
                    $('#tabla').DataTable({ responsive: true });
                }
            });
        }

        function modificarCliente() { //Lee el id del vendedor seleccionado, trae sus datos y los muestra en una modal.

            var id_cliente     = $("input:radio[class='cbSelect']:checked").val();
            var nombre          = $('#nombre').val();
            var calle           = $('#calle').val();
            var colonia         = $('#colonia').val();
            var codigo_postal   = $('#codigo_postal').val();
            var telefono        = $('#telefono').val();
            var celular         = $('#celular').val();
            var rfc             = $('#rfc').val();
            var no_exterior     = $('#no_exterior').val();
            var no_interior     = $('#no_interior').val();
            var municipio       = $('#municipio').val();
            var estado          = $('#estado').val();

            $.ajax({
                data: "id_cliente=" + id_cliente + "&nombre=" + nombre + "&calle=" + calle + "&colonia=" + colonia + "&codigo_postal=" + codigo_postal + "&telefono=" + telefono + "&celular=" + celular + "&rfc=" + rfc + "&no_exterior=" + no_exterior + "&no_interior=" + no_interior + "&municipio=" + municipio + "&estado=" + estado + "&accion=" +2,
                type: "POST",
                url: "../../models/clientesGuardar.php",
                success: function(data) {
                    alert(data);
                    if(data == 'Cliente actualizado correctamente.') {
                        clientes(2);
                        $('#modal_user').modal('hide');
                    }
                }
            });
        }

        function modificar() {  // Manda el id del radio button seleccionado para poder actualizar en la base de datos
            var id_cliente = $("input:radio[class='cbSelect']:checked").val();
            //alert(id_cliente);
            if(id_cliente != undefined) {
              //alert("cliente seleccionado");
                $.ajax({
                    data:  "accion=" + 3 + "&id_cliente=" + id_cliente,
                    type: "POST",
                    url: "../../models/clientesGuardar.php",
                    success: function(data) {
                        var datos = JSON.parse(data);
                        $('#nombre').val(datos[0]);
                        $('#calle').val(datos[1]);
                        $('#colonia').val(datos[2]);
                        $('#codigo_postal').val(datos[3]);
                        $('#telefono').val(datos[4]);
                        $('#celular').val(datos[5]);
                        $('#rfc').val(datos[6]);
                        $('#no_exterior').val(datos[7]);
                        $('#no_interior').val(datos[8]);
                        $('#municipio').val(datos[9]);
                        $('#estado').val(datos[10]);

                        $('#modal_user').modal({
                            show:true,
                            backdrop:'static'
                        });
                    }
                });
            }
            else
                alert('Seleccione un vendedor para modificar.');
        }

        function justNumbers(e) { // impide que se escriban letras y caracteres especiales
           var keynum = window.event ? window.event.keyCode : e.which;
           if ((keynum == 8) || (keynum == 46))
                return true;
            return /\d/.test(String.fromCharCode(keynum));
        }

        function soloLetras(e){ // impide que se escriban numeros y algunos caracteres especiales
           key = e.keyCode || e.which;
           tecla = String.fromCharCode(key).toLowerCase();
           letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
           especiales = "8-37-39-46";
           tecla_especial = false;

           for(var i in especiales){
                if(key == especiales[i]){
                    tecla_especial = true;
                    break;
                }
            }
            if(letras.indexOf(tecla)==-1 && !tecla_especial){
                return false;
            }
        }
    </script>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
            <div class="navbar-header">
                <a class="navbar-brand" style="color:white;">Modificar Clientes</a>
            </div>
            <form id="perfil" method="POST">
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a href="clientes_menu.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                    </li>
                    <li class="dropdown">
                        <a href="../../views/principal.php" style="color:white;"><i class="fa fa-home fa-fw"></i> Inicio</a>
                    </li>
                </ul>
            </form>
        </nav>

        <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="page-header">Clientes Registrados</h3>
                </div>
                <div class="col-md-2">
                    <br>
                    <a href="#" class="btn btn-primary" style="font-size: 18px;" onclick="modificar()">Modificar</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body" >
                            <div class="dataTable_wrapper" id="divClientes"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_user" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4  align="center" class="modal-title" id="myModalLabel">Modificar Vendedor</h4>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                              <div class="col-md-3" style="text-align: right;"><h4><label>Nombre:</label></h4></div>
                              <div class="col-md-9"><input type="text" id="nombre" class="form-control" placeholder="Nombre empresa"></div>
                          </div>
                          <div class="row">
                              <div class="col-md-3" style="text-align: right;"><h4><label>Calle:</label></h4></div>
                              <div class="col-md-9"><input type="text" id="calle" class="form-control" placeholder="Calle"></div>
                          </div>
                          <div class="row">
                              <div class="col-md-3" style="text-align: right;"><h4><label>Colonia:</label></h4></div>
                              <div class="col-md-9"><input type="text" id="colonia" class="form-control" placeholder="Colonia"></div>
                          </div>
                          <div class="row">
                              <div class="col-md-3" style="text-align: right;"><h4><label>Codigo Postal:</label></h4></div>
                              <div class="col-md-9"><input type="text" id="codigo_postal" class="form-control" placeholder="Codigo Postal"></div>
                          </div>
                          <div class="row">
                              <div class="col-md-3" style="text-align: right;"><h4><label>Telefono:</label></h4></div>
                              <div class="col-md-9"><input type="text" id="telefono" class="form-control" placeholder="Telefono"></div>
                          </div>
                          <div class="row">
                              <div class="col-md-3" style="text-align: right;"><h4><label>Celular:</label></h4></div>
                              <div class="col-md-9"><input type="text" id="celular" class="form-control" placeholder="Celular"></div>
                          </div>
                          <div class="row">
                              <div class="col-md-3" style="text-align: right;"><h4><label>RFC:</label></h4></div>
                              <div class="col-md-9"><input type="text" id="rfc" class="form-control" placeholder="RFC"></div>
                          </div>
                          <div class="row">
                              <div class="col-md-3" style="text-align: right;"><h4><label>No Exterior:</label></h4></div>
                              <div class="col-md-9"><input type="text" id="no_exterior" class="form-control" placeholder="No Exterior" style="margin-top: 10px" pattern="\d*" maxlength=""></div>
                          </div>
                          <div class="row">
                              <div class="col-md-3" style="text-align: right;"><h4><label>No Interior:</label></h4></div>
                              <div class="col-md-9"><input type="text" id="no_interior" class="form-control" placeholder="No Interior" style="margin-top: 10px" pattern="\d*" maxlength=""></div>
                          </div>
                          <div class="row">
                              <div class="col-md-3" style="text-align: right;"><h4><label>Municipio:</label></h4></div>
                              <div class="col-md-9"><input type="text" id="municipio" class="form-control" placeholder="Municipio" style="margin-top: 10px" pattern="\d*" maxlength=""></div>
                          </div>
                          <div class="row">
                              <div class="col-md-3" style="text-align: right;"><h4><label>Estado:</label></h4></div>
                              <div class="col-md-9"><input type="text" id="estado" class="form-control" placeholder="Estado" style="margin-top: 10px" pattern="\d*" maxlength=""></div>
                          </div>
                            <div align="center">
                                <input type="button" class="btn btn-primary" value="Modificar" onclick="modificarCliente()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
