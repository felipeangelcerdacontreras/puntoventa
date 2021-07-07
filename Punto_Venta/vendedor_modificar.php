<?php
    session_start();
    
    if($_SESSION['logged'] != "OK" || $_SESSION['tipo'] != 1) die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modificar Usuarios</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon.png">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sb-admin-2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            cargarVendedores(1);
        });

        function cargarVendedores(consulta) { // trae todos los vendedores registrados en la base de datos con un radio button
            $.ajax({
                data: "consulta=" + consulta,
                type: "POST",
                url: "php/buscaVendedores.php",
                success: function(data) {
                    $('#divVendedores').html(data);
                    $('#tabla').DataTable({ responsive: true });
                }
            });
        }

        function modificarVendedor() { //Lee el id del vendedor seleccionado, trae sus datos y los muestra en una modal.
            var id_vendedor      = $("input:radio[class='cbSelect']:checked").val();
            var nombre           = $('#nombre').val();
            var apellido_paterno = $('#apellido_paterno').val();
            var apellido_materno = $('#apellido_materno').val();
            var fecha_nacimiento = $('#fecha_nacimiento').val();                        
            var telefono         = $('#telefono').val();
            var celular          = $('#celular').val();
            
            $.ajax({
                data: "accion=" + 2 + "&id=" + id_vendedor + "&nombre=" + nombre + "&apellidoPaterno=" + apellido_paterno + "&apellidoMaterno=" + apellido_materno + "&fechaNacimiento=" + fecha_nacimiento + "&telefono=" + telefono + "&celular=" + celular,
                type: "POST",
                url: "php/guardarVendedor.php",
                success: function(data) {
                    alert(data);
                    if(data == 'Vendedor actualizado correctamente.') {                        
                        cargarVendedores(1);
                        $('#modal_user').modal('hide');
                    }
                }
            }); 
        }

        function modificar() {  // Manda el id del radio button seleccionado para poder actualizar en la base de datos
            var id_vendedor = $("input:radio[class='cbSelect']:checked").val();

            if(id_vendedor != undefined) {
                $.ajax({
                    data: "accion=" + 3 + "&id=" + id_vendedor,
                    type: "POST",
                    url: "php/guardarVendedor.php",
                    success: function(data) {
                        var datos = JSON.parse(data);
                        $('#nombre').val(datos[0]);
                        $('#apellido_paterno').val(datos[1]);
                        $('#apellido_materno').val(datos[2]);
                        $('#fecha_nacimiento').val(datos[3]);                        
                        $('#telefono').val(datos[4]);
                        $('#celular').val(datos[5]);

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
                <a class="navbar-brand" style="color:white;">Modificar Vendedores</a>
            </div>
            <form id="perfil" method="POST">
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a href="./vendedores.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                    </li>
                    <li class="dropdown">
                        <a href="./admin.php" style="color:white;"><i class="fa fa-home fa-fw"></i> Inicio</a>
                    </li>
                </ul>
            </form>
        </nav>

        <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="page-header">Vendedores Registrados</h3>
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
                            <div class="dataTable_wrapper" id="divVendedores"></div>
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
                                <div class="col-md-9"><input type="text" id="nombre" class="form-control" placeholder="Nombre" onkeypress="return soloLetras(event)"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3" style="text-align: right;"><h4><label>Apellido paterno:</label></h4></div>
                                <div class="col-md-9"><input type="text" id="apellido_paterno" class="form-control" placeholder="Apellido paterno" onkeypress="return soloLetras(event)"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3" style="text-align: right;"><h4><label>Apellido materno:</label></h4></div>
                                <div class="col-md-9"><input type="text" id="apellido_materno" class="form-control" placeholder="Apellido materno" onkeypress="return soloLetras(event)"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3" style="text-align: right;"><h4><label>Fecha de nacimiento:</label></h4></div>
                                <div class="col-md-9"><input type="date" id="fecha_nacimiento" class="form-control" placeholder="Fecha de nacimiento"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3" style="text-align: right;"><h4><label>Telefono:</label></h4></div>
                                <div class="col-md-9"><input type="text" id="telefono" class="form-control" placeholder="Telefono" onkeypress="return justNumbers(event);"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3" style="text-align: right;"><h4><label>Celular:</label></h4></div>
                                <div class="col-md-9"><input type="text" id="celular" class="form-control" placeholder="Celular" onkeypress="return justNumbers(event);"></div>
                            </div>
                            <div align="center">
                                <input type="button" class="btn btn-primary" value="Modificar" onclick="modificarVendedor()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>