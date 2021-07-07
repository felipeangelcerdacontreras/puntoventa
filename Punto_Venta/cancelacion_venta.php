<?php
    session_start();

    if($_SESSION['logged'] != "OK") die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html >
<head>
	<title>Cancelar Venta</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img/favicon.png">
	<link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/jquery-ui.css" rel="stylesheet">
	<link rel="stylesheet" href="css/sb-admin-2.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/punto_venta.js"></script>
    <script src="js/bloqueo.js"></script>
    <script src="js/jquery-ui.js"></script>
	<script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $('document').ready(function(){
            $("#desde").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "2016:2050",
                dateFormat: "yy-mm-dd"
            });
            $("#hasta").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "2016:2050",
                dateFormat: "yy-mm-dd"
            });
            window.onload = function() {
                ventas(5);
            };
        });
    </script>
</head>
<body >
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
		<div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Cancelar Venta</a>
        </div>
        <form id="perfil" method="POST">
        	<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="./ventas.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
                <li class="dropdown">
                    <a href="./modulos.php" style="color:white;"><i class="fa fa-home fa-fw"></i> Inicio</a>
                </li>
            </ul>
    	</form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
    	<div class="row">
    		<div class="col-lg-12" align="center">
    			<h3 class="page-header">Seleccione la venta que desea cancelar.</h3>
    		</div>
    	</div>
      <div class="row" align="center">
            <div class="col-md-1 col-md-offset-2" >
                <h4>Desde</h4>
            </div>
            <div class="col-md-2" >
                <input id="desde" value="<?=date('Y-m-d', strtotime('first day of this month'))?>" type="date" readonly class="form-control">
            </div>
            <div class="col-md-1">
                <h4>Hasta</h4>
            </div>
            <div class="col-md-2">
                <input id="hasta" input value="<?=date('Y-m-d')?>" readonly class="form-control">
            </div>
            <div class="col-md-1">
                <input id="filtrar" type="button" class="btn btn-primary" onclick="ventas(5)" value="Filtrar">
            </div>
        </div><br/><br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <div class="dataTable_wrapper" id="divVentas"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_detVenta" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4  align="center" class="modal-title" id="myModalLabel">Detalles de la Venta</h4>
                </div>
                <div class="modal-body" id="body_modal">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
