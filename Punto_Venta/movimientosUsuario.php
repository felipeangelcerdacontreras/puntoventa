<?php
    session_start();
    
    if($_SESSION['logged'] != "OK") die("Accesso No Autorizado");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ventas</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img/favicon.png">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="css/sb-admin-2.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/jquery-ui.css" rel="stylesheet">

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/punto_venta.js"></script>
    <script src="js/bloqueo.js"></script>
	<script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
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

            var desde = $('#desde').val();
            var hasta = $('#hasta').val();
   			alert(hasta);
   			$.ajax({
		        data: { 'desde': desde, 'hasta': hasta },
		        type: "POST",
		        url: "php/buscaMovimientos.php",
		        success: function(data) {
		    		$('#divMovimientos').html(data);
		        	$('#tabla').DataTable({ responsive: true, order: [[ 0, "desc" ]] });
		    	}
		    });
        });

        function filtroMovimientos() {            
            var desde = $('#desde').val();
            var hasta = $('#hasta').val();
            if(hasta < desde) {
                alert('La fecha hasta no puede ser menor que desde');
            } else {
                alert(desde);
                $.ajax({
                    data: { desde: desde, hasta: hasta },
                    type: "POST",
                    url: "php/buscaMovimientos.php",
                    success: function(data) {
                        $('#divMovimientos').html(data);
                        $('#tabla').DataTable({ responsive: true, order: [[ 0, "desc" ]] });
                    }
                });
            }
        }
    </script>
</head>
<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
			<div class="navbar-header">
	            <a class="navbar-brand" style="color:white;">Movimientos</a>
	        </div>
	        <form id="perfil" method="POST">
	        	<ul class="nav navbar-top-links navbar-right">
	                <li class="dropdown">
	                    <a href="./ventas_vendedor.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
	                </li>
	                <li class="dropdown">
	                    <a href="./modulos.php" style="color:white;"><i class="fa fa-home fa-fw"></i> Inicio</a>
	                </li>
	            </ul>
	    	</form>
	    </nav>

	    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
	    	<div class="row">
	    		<div class="col-lg-12">
	    			<h3 class="page-header">Movimientos del usuario</h3>
	    		</div>
	    	</div>
	        <div class="row" >
	            <div class="col-md-1 col-md-offset-2">
	                <h4>Desde</h4>
	            </div>            
	            <div class="col-md-2">
	                <input id="desde" value="<?=date('Y-m-d')?>" type="date" readonly class="form-control">
	            </div>
	            <div class="col-md-1">
	              <input id="filtrar" type="button" class="btn btn-primary" onclick="filtroMovimientos()" value="Filtrar">
	            </div>
	            <div class="col-md-1">
	                <h4>Hasta</h4>
	            </div>
	            <div class="col-md-2">
	                <input id="hasta" value="<?=date('Y-m-d')?>" readonly class="form-control">
	            </div>	            
	        </div>
	    	<div class="row">
	    		<div class="col-lg-12">
	    			<div class="panel panel-default">
	    				<div class="panel-body" >
	    					<div class="dataTable_wrapper" id="divMovimientos"></div>
		    			</div>
		    		</div>
		    	</div>
		    </div>
	    </div>
	</div>
</body>