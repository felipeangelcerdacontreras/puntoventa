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
                    $('#divUsuarios').html(data);
                    $('#tabla').DataTable({ responsive: true });
                }
            });
        }


        function cliente(tipo_consulta) { //Funcion para traer todos los usuarios existentes en la base de datos o los datos de un usuario en especifico.
            $.ajax({
                data: "consulta="+'1',
                type: "POST",
                url: "../../models/clientesRegistrados.php",
                success: function(data) {
                    if(tipo_consulta != 1) {
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
                      }
                      else {
                          $('#divUsuarios').html(data);
                          $('#tabla').DataTable({ responsive: true });
                        }
                      }
                });
        }
        function eliminarCliente() { //Lee los id de los usuarios seleccionados y los elimina.
            var id_cliente = $("input:radio[class='cbSelect']:checked").val();

            if(id_cliente == undefined || 0)
                alert("Seleccione un cliente.");
            else {
                var confirmacion = confirm("¿Está seguro de eliminar el cliente seleccionado?");
                if (confirmacion) {
                    $.ajax({
                        data: {id_cliente: id_cliente},
                        type: "POST",
                        url: "../../models/clientesEliminar.php",
                        success: function(data) {
                            if (data == 1) {
                              alert("Cliente Eliminado Correctamente");
                              clientes(2);
                            }
                            else if(data == 2){
                                alert("No Se Pudo Eliminar Al Cliente");
                            }
                        }
                    });
                }
            }
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
                <a class="navbar-brand" style="color:white;">Eliminar Cliente</a>
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
                    <a href="#" class="btn btn-primary" style="font-size: 18px;" onclick="eliminarCliente()">Eliminar</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body" >
                            <div class="dataTable_wrapper" id="divUsuarios"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
