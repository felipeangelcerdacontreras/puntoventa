<!-- <?php
	session_start();

	if(!empty($_SESSION)) {
		if($_SESSION['logged'] == "OK" && ($_SESSION['tipo'] == "empresas" || $_SESSION['tipo'] == "administradores"))
			header("Location: ./modulos.php");
		else if($_SESSION['logged'] == "OK" && $_SESSION['tipo'] == "clientes")
			header("Location: ./modulos_cliente.php");
	}
?> -->
<!DOCTYPE html>
<html>
<head>
	<title>Vendedores</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="html/img/vendedores.png">
	<link href="html/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="html/css/sb-admin-2.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="html/js/jquery.min.js"></script>
	<script src="html/js/bootstrap.min.js"></script>
    <script src="html/js/punto_venta_vende.js"></script>
    <!--<script src="html/js/bloqueo.js"></script>-->
	<script src="html/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="html/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		function bloquearCaracteres(event) { // esta funcion sirve para no permitir la escritura de caracteres especiales identificandolos mediante codigo ascii
			var letra = event.which || event.keyCode;
		    if((letra == 08) || (letra >= 48 && letra <= 57) || (letra >= 65 && letra <= 90) || (letra == 95) || (letra >= 97 && letra <= 122) || (letra == 127)) {
		        return letra;
		    } else {
		    	return false;
			}
		}

		function validar(e) {
			tecla = (document.all) ? e.keyCode : e.which;
			 if (tecla == 13){
				login();
			}
	 	}
	</script>
</head>
<body>
<div id="wrapper">
	<div id="page-wrapper" style="margin-left: 0px;">
		<div class="row">
			<div class="col-md-4 col-md-offset-4"><center><br>
				<img class="img-responsive" src="html/img/vendedores.png" width="200" height="80" title="SAX">
				<h3 class="box-title">Portal de Vendedores</h3></center>
			</div>
<br><br>
    		<div class="col-md-4 col-md-offset-4 " style="text-align: center">
    			<form class="form-horizontal">
    				<div class="box-body">
    					<div class="form-group">
    						<label for="login_user" class="col-sm-3 control-label">Usuario</label>
	            			<div class="col-sm-9">
	            				<input type="text" class="form-control" id="vendedor_user" required placeholder="Usuario" >
	            			</div>
			        	</div>
				        <div class="form-group">
				        	<label for="login_pass" class="col-sm-3 control-label">Contraseña</label>
				        	<div class="col-sm-9">
				        		<input type="password" class="form-control" required id="vendedor_pass" placeholder="Contraseña" onkeyup="validar(event)">
				        	</div>
			        	</div>
				        <input type="button" id="Entrar" class="btn btn-primary" value="Entrar" onclick="login()">
								<input type="button" value="Regresar" class="btn btn-danger" onclick="location.href='../index.php'">
			    	</div>
			    </form>
            </div>
	    </div>
	</div>
</div>
</body>
</html>
