<?php
    include "php/conexion.php";
    session_start();

    date_default_timezone_set('America/Mexico_City');

    $fecha = date("Y-m-d");
    
    if($_SESSION['logged'] != "OK") die("Accesso No Autorizado");

    $id_usuario=$_SESSION['id'];
    $nombre=$_SESSION['nombre'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Corte de Caja</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img/favicon.png">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="css/sb-admin-2.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/punto_venta.js"></script>
    <script src="js/bloqueo.js"></script>
	<!-- <script src="js/metisMenu.min.js" type="text/javascript"></script> -->
	<script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#fechaDesde").val("<?=$fecha;?>");
			$("#fechaHasta").val("<?=$fecha;?>");
		});
	</script>
	<script>
		function corte2() { //Funcion para realizar el corte del dia o de un rango de fecha establecido
          var desde = $('#fechaDesde').val();
          var hasta = $('#fechaHasta').val();
          var id_user = $('#id_usuario').val();
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
                    url: "php/corteDeCaja2.php",
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
                    url: "php/corteDeCajaT2.php",
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
	</script>
    <script>
        function corte3() { //Funcion para realizar el corte del dia o de un rango de fecha establecido
          var desde = $('#fechaDesde').val();
          var hasta = $('#fechaHasta').val();
          var id_user = $('#id_usuario').val();
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
                    url: "php/corteDeCaja2.php",
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
                    url: "php/FinalizarCorteT2.php",
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
    </script>
</head>
<body>
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
		<div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Corte de Caja</a>
        </div>
        <form id="perfil" method="POST">
        	<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="./modulos.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
            </ul>
    	</form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;"><br>
	    <div class="row" id="botones">
	    <center>
    		<div class="col-md-3">
    			<!-- <select id="vendedores" class="form-control">
    				<option value="0">Seleccione un vendedor</option>
    				<?php
    					$usuarios = mysqli_query($con, "Select nombre, usuarios.id_user from usuarios inner join datos_usuarios on datos_usuarios.id_user = usuarios.id_user");
    					while($usuario = mysqli_fetch_array($usuarios)) {
    						$nom_user = $usuario['nombre'];
    						$id_user = $usuario['id_user'];
    						echo '<option value="'.$id_user.'">'.$nom_user.'</option>';
    					}
    				?>
    			</select> -->
    			<input id="id_usuario" type="hidden" class="form-control" readonly="true" value="<?=$id_usuario;?>">
    			<input id="nombre_usuario" type="text" class="form-control" readonly="true" value="<?=$nombre;?>">
    		</div>
	        <div class="col-md-1" >
	            <h4>Desde</h4>
	        </div>
	        <div class="col-md-2" >
	            <input id="fechaDesde" type="date" class="form-control">
	        </div>
	        <div class="col-md-1">
	          <input id="filtrar" type="button" class="btn btn-primary" onclick="corte2()" value="Corte">
	        </div>
            <div class="col-md-1">
              <input id="filtrar" type="button" class="btn btn-primary" onclick="corte3()" value="Finalizar">
            </div>
	        <div class="col-md-2">
	            <input id="fechaHasta" type="date" class="form-control">
	        </div>
	        <div class="col-md-1">
	            <h4>Hasta</h4>
	        </div>
		</center>
		</div>
		<div class="row" id="select"><div class="col-md-3">
			<select id="cortePor" class="form-control">
				<option value="0">Mostrar por...</option>
				<option value="1">Corte T</option>
				<option value="2">Corte L</option>
    		</select>
    	</div></div>

    	<div class="row" id="divTablas">
	    </div>
    	
    </div>


</div>
</body>
</html>