<?php
	include 'php/conn.php';
    session_start();
    
    if($_SESSION['logged'] != "OK") die("Accesso No Autorizado");
    
    $nom_user = $_SESSION['nombre'];
    $id_user = $_SESSION['id'];

	$mes = date("m");
	$anio = date("Y");
	$anio2 = date("y");
	$dia = date("d");

	function diferenciaDias($inicio, $fin)
	{
	    $inicio = strtotime($inicio);
	    $fin = strtotime($fin);
	    $dif = $fin - $inicio;
	    $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
	    return ceil($diasFalt);
	}
	$inicio = "$anio/01/00";
	$fin = "$anio/$mes/$dia";
	$fecha = diferenciaDias($inicio, $fin);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Venta al Mayoreo</title>
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
	<!-- <script src="js/bascula.js" type="text/javascript"></script> -->
	<script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		function traerPrecios()
		{
			var nombreArt = document.getElementById('productos_venta').value;
			var id = $('#productos').find('option[value="'+nombreArt+'"]').attr('id');
			//alert("id: "+id);
			if (id == "undefined" || id == undefined) {
				alert("Producto no encontrado");
				// document.getElementById("precios").style.display = "none";
			}
			else
			{
				document.getElementById("precios").style.display = "block";
			  	if (window.XMLHttpRequest)
			    {// code for IE7+, Firefox, Chrome, Opera, Safari
			    xmlhttp=new XMLHttpRequest();
			    }
			    else
			    {// code for IE6, IE5
			    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			    }
			    xmlhttp.onreadystatechange=function()
			    {
			    if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    document.getElementById("precios").innerHTML=xmlhttp.responseText;

			    }else{ 
			    document.getElementById("precios").innerHTML='Cargando...';
			    }
			    }
			    xmlhttp.open("POST","php/traer_precios.php",true);
			    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			    xmlhttp.send("id="+id);
			}
		}

		function generarlote() { //Generamos el numero de lote
			var fecha= document.getElementById("fecha").value;
			var fechav= document.getElementById("fechav").value;
			var juliano= document.getElementById("juliano").value;
			var fechaanio = fecha.substring(0, 4); // año
			var fechaanioLote = fecha.substring(2, 4); // año
			var fechames = fecha.substring(5, 7); // mes
			var fechadia = fecha.substring(8, 11); // dia

			var fFecha1 = Date.UTC(fechaanio,fechames-1,fechadia); 
			var fFecha2 = Date.UTC(fechaanio,01-1,01); 
			var dif = fFecha1 - fFecha2;
			var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
			var diasB=dias+1;
			var Lote=fechaanioLote+diasB;

			$('#lote').val(Lote);
			$('#fechaz').val(fechav);
		}

		var total = 0;
		var indArt = 0;
		var totalK = 0;
		function generarcodigo() {
			var tipopago= document.getElementById("tipopago").value;
			var almacen= document.getElementById("almacen").value;
			var clave= document.getElementById("clave").value;
			var lote= document.getElementById("lote").value;
			var nombreArt = document.getElementById('productos_venta').value;
			var id_art = $('#productos').find('option[value="'+nombreArt+'"]').attr('id');
			var peso= document.getElementById("kilo1").value;
			var juliano= document.getElementById("juliano").value;
			//var cajaogranel= document.getElementById("cajaogranel").value;
			
			var fechav= document.getElementById("fechav").value;
			var fechaz= document.getElementById("fechaz").value;
			var fechaLote = document.getElementById("fecha").value;
			var precio= document.getElementById("precios_venta").value;
			var nuevodia= lote.substr(2,4);

			if(fechav == "") {
				alert("Seleccione una fecha");
				document.getElementById("fechav").focus();
			}
			else if (peso === "" || peso === null) {
				alert("Lo sentimos, no podemos generar el codigo porque no capturo el peso.");
				document.getElementById("kilo1").focus();
			}
			else if (fechaLote == "") {
				alert("Lo sentimos, no podemos generar el codigo porque no especifico la fecha del Lote.");
				document.getElementById("fecha").focus();
			}
			else if(id_art == undefined) {
				alert("Seleccione un producto");
				document.getElementById("productos_venta").focus();
			}
			else {
				var codigodebarras = almacen+lote+"0"+id_art+"0"+peso+juliano+clave;
				var importe = peso * precio;

				$('#detalles').append("<tr id='tr"+indArt+"'><td>"+codigodebarras+"</td><td>"+nombreArt+"</td><td>"+peso+"</td><td>"+precio+"</td><td>"+importe.toFixed(2)+"</td><td><a href='#' onclick='quitarArticulo("+indArt+")'><i class='fa fa-minus-square fa-fw'></i></a></td><td style='display:none;'>"+almacen+"</td><td style='display:none;'>"+lote+"</td><td style='display:none;'>"+juliano+"</td><td style='display:none;'>"+numventa+"</td><td style='display:none;'>"+fechaz+"</td><td style='display:none;'>"+clave+"</td><td style='display:none;'>"+id_art+"</td></tr>");
				$('tbody#detalles tr:last td:first input').focus();
				total = total + importe;
				totalK = totalK + (peso * 1);
				$('#subtotal').val("$" + total.toFixed(2));
				$('#total').val("$" + total.toFixed(2));

				document.getElementById("kilo1").value = "";
				document.getElementById("precios_venta").value = "";
				document.getElementById('productos_venta').value = "";
				document.getElementById("inDescuento").value = "$0.00";

				indArt++;
			}
		}

		function quitarArticulo(indArtic) {
			$('#n_articulo').val(indArtic);
            $('#code2').val('');
		    var confirmacion = confirm("¿Seguro que quieres remover este producto?");
		    if (confirmacion) {
		    	$('#modal_codigo2').modal({
                show:true,
                backdrop:'static'
            })
		        
		    }
		}

		function quitarArt()
        {
          var n_articulo = $('#n_articulo').val();
          var code = $('#code2').val();

          $.ajax({
            data: "code="+code,
            type: "POST",
            url: "php/traer_pass.php",
            success: function(data) {
                if(datos = JSON.parse(data)) {
                var codigo=datos; 
                if (codigo==1) 
                {
                    var num_total = $('#tr'+n_articulo).find("td").eq(4).html().replace(',','');
		            var peso = $('#tr'+n_articulo).find("td").eq(2).html();
		            total = total - num_total;
		            totalK = totalK - peso;
		            $('#subtotal').val("$" + total.toFixed(2));
		            $('#total').val("$" + total.toFixed(2));
		            document.getElementById("inDescuento").value = "$0.00";

		            $('#tr'+n_articulo).remove();
		            $('#productos_venta').focus();
		            // $('#totalArticulos').html($('#detalles tr').length);
		            $('#modal_codigo2').modal('hide');
                }
                else
                {
                    alert("Código de seguridad incorrecto");
                }

                }
            }
          });
        }


		function habilitar(value)
		{ 
			if(value=="Sin Pago" || value==true)
			{
				$('#comentario').removeAttr('disabled').focus();
			}
			else if(value=="Efectivo" || value==false) {
				$('#comentario').val("");
				$('#comentario').attr('disabled','disabled'); 
			}
			else if(value=="Credito" || value==false) {
				$('#comentario').val("");
				$('#comentario').attr('disabled','disabled');
			}
		}

		function descuento() {
            $('#code').val('');
            var pregunta=confirm("¿Seguro que desea aplicar el descuento?");
            var descuento= document.getElementById('descuento').value;

            if (descuento==0||descuento=="0") 
            {
            	alert("Debe seleccionar un porcentaje.");
            }
            else
            {
            	if (pregunta) 
                {
            	  $('#modal_codigo').modal({
                      show:true,
					  backdrop:'static'
				  });
                }
            }
		}

		function enviarCod()
		{
			var code= document.getElementById("code").value;
			//alert(pass);
            $.ajax({
            	data: "code="+code,
                type: "POST",
                url: "php/traer_pass.php",
                success: function(data) {
        	      if(datos = JSON.parse(data)) {
                  var codigo=datos; 
                  if (codigo==1) 
                  {
                  	var descuento = document.getElementById("descuento").value;
			        var porcentaje = 1 - (descuento*0.01);
			        var totalDesc = total * porcentaje;
			        var dif = total - totalDesc;
         			document.getElementById("inDescuento").value = dif.toFixed(2);
		        	document.getElementById("total").value = totalDesc.toFixed(2);

		        	$('#modal_codigo').modal('hide');

                  }
                  else
                  {
                    alert("Código de seguridad incorrecto");
                  }

                  }

        	      }
            });
		}

		function generareporte(){
			$('#abono').attr('disabled','disabled');  
			$('#btnabonar').attr('disabled','disabled');  

			var numventa= document.getElementById("numventa").value;
			var fechaz= document.getElementById("fechaz").value;

			var envio="php/reporte-venta-mostrador.php?numventa="+ numventa + "&fechaz="+fechaz;
			var r=document.getElementById("impresion");
			r.src=envio;
			location.reload();
		}

		function abonar(){
			$('#divabonos').show();
			$('#divBtnAbono').hide();
		}

		function registrarAbono() {
			var numventa = document.getElementById("numventa").value;
			var abono = document.getElementById("abono").value;

			$.ajax({
				data: "numventa="+numventa+"&abono=" + abono,
			    type: "POST",
			    url: "php/cuentas_pcDesdeventa.php",
			    success: function (datos) {
			    	$('#modal_abono').modal('hide');
					$.ajax({
						data: "numventa="+numventa+"&abono="+abono+"&id_user="+"<?=$id_user;?>",
					    type: "POST",
					    url: "php/guardar_abono.php",
					    success: function (datos) {
					    	alert("Se abonarón $ " + abono +  " a esta cuenta.");
					    	$('#modal_abonar').modal('hide');
					    }
					});
			    }
			});
		}

		function cerrarvnt() {
			var indTb = 1;
			var cliente = document.getElementById("cliente").value;
			var nomcliente = $('#cliente option:selected').text();
			var numventa = document.getElementById("numventa").value;
			var fechaz = document.getElementById("fechaz").value;
			var comentario = document.getElementById("comentario").value;
			var tipodepago = document.getElementById("tipopago").value;
			var descuento = document.getElementById("descuento").value;

			var a = confirm("¿Seguro de cerrar venta?");
			if (a) {
				if($('#detalles tr').length == 0) alert("No se han agregado articulos");
				else {
					$.ajax({
						data: "cliente="+cliente+"&tipodepago=" + tipodepago+"&numventa2=" + numventa+"&fechaz=" + fechaz+"&comentario=" + comentario,
						type: "POST",
						url: "php/venta_insert.php",
						success: function (datos) {
						    $('#detalles tr').each(function () {
						        var codigodebarras = $(this).find("td").eq(0).html();
						        var id_art = $(this).find("td").eq(12).html();
						        var peso = $(this).find("td").eq(2).html();
						        var precio = $(this).find("td").eq(3).html();
						        var importe = $(this).find("td").eq(4).html();
						        var almacen = $(this).find("td").eq(6).html();
						        var lote = $(this).find("td").eq(7).html();
						        var juliano = $(this).find("td").eq(8).html();
						        var clave = $(this).find("td").eq(11).html();

						        $.ajax({
						        	type: "POST",
						        	data: "almacen="+almacen+"&lote=" + lote+"&productos_venta=" + id_art+"&peso=" + peso+"&juliano=" + juliano+"&clave=" + clave+"&codigodebarras=" + codigodebarras+"&cliente="+cliente+"&numventa="+numventa+"&fechaz="+fechaz+"&precio="+precio+"&importe="+importe+"&totalK="+totalK+"&totall="+total+"&descuento="+descuento,
						        	url: "php/ventaDetalle_Sincodigo2.php",
						        	success: function (data) {
						        		if(indTb == $('#detalles tr').length) {
								    		$.ajax({
										    	type: 'POST',
										    	data: 'numventa='+numventa+"&nomcliente="+nomcliente+"&tipodepago="+tipodepago+"&fecha="+fechaz+"&kilos="+totalK+"&total="+total+"&id_user="+"<?=$id_user;?>",
										    	url: 'php/guardar_ventaMayoreo.php',
										    	success: function(data){
										    		alert(data);

										    		if(data == "Se ha registrado correctamente la venta") {
													    if(tipodepago == 'Credito' ) {
														    $.ajax({
														    	type: 'POST',
														    	data: 'numventa=' + numventa,
														    	url: 'php/cuentas_porcobrar.php',
														    	success: function(data){
														    		var envio="php/reporte-venta-mostrador.php?numventa="+ numventa +"&fechaz="+ fechaz;
														    		var r=document.getElementById("impresion");
														    		r.src=envio;
														    	}
														    });
														}
														else {
															var envio="imprimeVMayoreo.php?id_venta="+ numventa;
															var r=document.getElementById("impresion");
															r.src=envio;
														}
													}
										    	}
										    });
						        		}
						        		indTb++
						        	}
						        });
						    });
						}
					});
				}
			}
		}

		function regAbonoNota() {
			$('#modal_abonar').modal({
				show:true,
				backdrop:'static'
			});
		}

		function registrarAbonoNota() {
			var idCliente = $('#clienteAbono option:selected').val();
			var idVenta = $('#ventas').val();
			var abono = $('#cantidad').val() * 1;
			var restante = $('#inRestante').val() * 1;

			if(idVenta == "") {
				alert("Seleccione una venta.");
				$('#ventas').focus();
			}
			else if(abono == "" || abono == 0) {
				alert("Introduzca una cantidad");
				$('#cantidad').focus();
			}
			else if(abono > restante) {
				alert("La cantidad recibida es mayor al adeudo.");
				$('#cantidad').focus();
			}
			else {
				$.ajax({
					data: "numventa="+idVenta+"&abono=" + abono,
				    type: "POST",
				    url: "php/cuentas_pcDesdeventa.php",
				    success: function (datos) {
						$.ajax({
							data: "numventa="+idVenta+"&abono="+abono+"&id_user="+"<?=$id_user;?>",
						    type: "POST",
						    url: "php/guardar_abono.php",
						    success: function (datos) {
						    	alert(datos);
						    	alert("Se abonarón $ " + abono +  " a esta cuenta.");
						    	$('#modal_abonar').modal('hide');
						    }
						});
				    }
				});
			}
		}

		function traeVentas() {
			var idCliente = $('#clienteAbono option:selected').val();
			$('#ventas').val("");

    		$.ajax({
		    	type: 'POST',
		    	data: 'idCliente=' + idCliente,
		    	url: 'php/ventas_cliente.php',
		    	success: function(data){
		    		$('#nro_venta').html(data);
		    		$("#rowVenta").show();
		    	}
		    });
		}

		function traeRestante() {
			var num_venta = $('#ventas').val();
			var idCuentaspc = $('#nro_venta').find('option[value="'+num_venta+'"]').attr('data');

    		$.ajax({
		    	type: 'POST',
		    	data: 'idCuentaspc=' + idCuentaspc,
		    	url: 'php/traer_restante.php',
		    	success: function(data){
		    		$('#inRestante').val(parseFloat(data));
		    		$("#rowAbono").show();
		    	}
		    });
		}
	</script>
</head>
<body>
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
		<div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Venta a Mayoreo</a>
        </div>
        <form id="perfil" method="POST">
        	<ul class="nav navbar-top-links navbar-right">
        		<li class="dropdown">
                    <a href="#" style="color:white;" onclick="regAbonoNota()"><img src="./img/give-money.png" style="width: 20px;"></img> Abonar Nota</a>
                </li>
                <li class="dropdown">
                    <a href="./modulos.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
            </ul>
    	</form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
		<?php 				
			$sql2=("SELECT *, Max(idVenta) as id FROM ventas ");
			$result2= mysql_query($sql2) or die(mysql_error());
			while($row2=mysql_fetch_array($result2)){
				$id= $row2['id'];
				$numventa= $id+1;
		    }
		?>
		<div class="row">
			<div class="col-md-2">
				<label><b>N.Venta</b>&nbsp;</label>
		    	<input type="text" class="form-control" id="numventa" name="numventa"  value="<?=$numventa;?>" readonly="true">
		    	<input type="hidden" class="form-control" id="numventa2" name="numventa2"  value="<?=$numventa;?>">
			</div>
			<div class="col-md-3">
				<label><b>Cliente</b>&nbsp;</label>
		    	<?php
		    		$cliente=("SELECT * FROM clientes Order by Nombre Asc");
		    		$resultcliente= mysql_query($cliente) or die(mysql_error());
		    	?> 
		    	<select name='cliente' id='cliente' class="form-control"> 
		    	<?php
		    	while($row2=mysql_fetch_array($resultcliente)){
		    		echo'<OPTION VALUE="'.$row2['id'].'">'.$row2['nombre'].'</OPTION>';
		    	}
		    	?>
		    	</select>
			</div>
			<div class="col-md-2">
				<label>Fecha</label>
				<input type="date" id="fechav" name="fechav" onchange="javascript:generarlote();" class="form-control">
				<input type="hidden" id="fechaz" name="fechaz" class="form-control">
			</div>
			<div class="col-md-2">
				<label>Tipo de Pago</label>
				<select class="form-control" id="tipopago" name="tipopago" onchange="habilitar(this.value);">
			      	<option value="Sin Pago">Sin Pago</option>
			      	<option value="Efectivo">Efectivo</option>
			      	<option value="Credito">Credito</option>
		      	</select>
			</div>
			<div class="col-md-3">
				<label>Comentario</label>
				<textarea class="form-control" rows="2" name="comentario" id="comentario" style="resize: none;"></textarea> 
			</div>
		</div>
		<br>
		<center><label><b>Ingresar datos:</b></label></center>
		<div class="row">
		    <div class="col-md-2">
		    	<label><b>Peso:</b></label><input type="text" placeholder="Escribe el peso..." id="kilo1" name="kilo1" class="form-control" >
		    </div>
		    <div class="col-md-4">
		    	<label><b>Productos:</b>&nbsp;</label>
		    	<input type="text" name='productos_venta' id="productos_venta" class="form-control" list="productos" placeholder="Seleccione un producto" onchange="javascript:traerPrecios();">
		    	<datalist id="productos">
			    <?php
			    	$productos_venta = ("SELECT * FROM productos_venta order by nombrepv");
			    	$resultProdcutosVenta = mysql_query($productos_venta) or die(mysql_error());
				    while($row3 = mysql_fetch_array($resultProdcutosVenta)){

				    	echo'<OPTION VALUE="'.$row3['nombrepv'].'" id="'.$row3['idProductosventa'].'" ></OPTION>';
				    }
			    ?>
			    </datalist>
		    </div>
		    <div id="precios" class="col-md-3">
		    	<label><b>Precios:</b>&nbsp;</label>
		    	<select name='precios_venta' id='precios_venta' class="form-control"></select>
		    </div>
		    <div class="col-md-3">
			    <label><b>Almacen:</b></label>
			    <?php   
				    $almacen=("SELECT * FROM almacen ");          
				    $resultalmacen= mysql_query($almacen) or die(mysql_error());
				?> 
			    <select name='almacen' id='almacen'  class="form-control" > 
			    <?php
				    while($row2=mysql_fetch_array($resultalmacen)){
				    	echo'<OPTION VALUE="'.$row2['clave'].'">'.$row2['descripcion'].'</OPTION>';
				    }
			    ?>
			    </select>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3 col-md-offset-2">
				<center><label><b>Vendedor:</b></label></center>
				<input type="hidden" id="clave" name="clave" readonly="true"  value="<?=$id_user;?>">
				<input type="text" id="empacador" name="empacador" value="<?=$nom_user;?>" class="form-control" readonly>
			</div>
			<div class="col-md-3">
				<center><label><b>Generar Lote:</b></label></center>
		    	<input type="date" id="fecha" name="fecha" onchange="javascript:generarlote();" class="form-control">
		    	<input type="hidden" id="juliano" name="juliano" value="<?=$fecha;?>" readonly>
			</div>
			<div class="col-md-2">
				<label>&nbsp;</label>
				<input type="text" name='lote' id='lote' class="form-control" readonly>
			</div>
			<div class="col-md-2">
				<br>
				<input type="button" value="Agregar" onclick="javascript:generarcodigo();" class="btn btn-primary">
			</div>
		</div>

		<center>
		    <input type="hidden" id="id_inventario" name="id_inventario" />
		    <input type="hidden" id="codigo_barras" name="codigo_barras" />
		    <input type="hidden" id="lote" name="lote" />
		    <input type="hidden" id="fecha_ingreso" name="fecha_ingreso" />
		    <input type="hidden" id="tipo_producto" name="tipo_producto" />
		    <input type="hidden" id="almacen" name="almacen" />
		    <input type="hidden" id="caja_granel" name="caja_granel" />
		    <input type="hidden" id="kilos" name="kilos" />
		    <input type="hidden" id="empacador" name="empacador" />
		    <input type="hidden" id="estatus" name="estatus" />
		    <input type="hidden" id="e_s" name="e_s" />
	    </center>

	    <div class="row">
	    	<div class="col-md-12"><center><h3>Detalle de la Venta</h3></center></div>
			<div class="col-md-8" style="overflow-y:auto; height:269px; background-color:#e5e5dd;">
			    <div style="overflow-y:auto; height:100%;">
				    <table class="table table-bordered">
				    	<thead>
						<tr class="warning">
							<th style="width: 250px;">Codigo</th>
							<th style="width: 350px;">Producto</th>
							<th style="width: 220px;">Kilos</th>
							<th style="width: 220px;">Precio Unitario</th>
							<th style="width: 220px;">Importe</th>
							<th > </th>
						</tr>
						</thead>
						<tbody id="detalles"></tbody>
				    </table>
			    </div>
			</div>
			<div class="col-md-4">
				<center><label><b>Descuento:</b>&nbsp;</label></center>  
				<select class="form-control" id="descuento" name="descuento" >
					<option value="0">Sin descuento.</option>
					<option value="5">5%</option>
					<option value="10">10%</option>
					<option value="15">15%</option>
				</select>
				<center><input id="aplicarDescuento" type="button" class="btn btn-success" value="Aplicar Descuento" style="width: 200px; margin-top: 5px;" onclick="javascript:descuento();"></center>
				<center><input id="cerrarventa" type="button" class="btn btn-success" value="Cerrar Venta" style="width: 150px; margin-top: 5px;" onclick="javascript:cerrarvnt();"></center>
				<br>
				<div class="row">
					<div class="col-md-3"><label style="font-size: 24px;">Subtotal</label></div>
					<div class="col-md-9"><input type="text" id="subtotal" class="form-control" value="$0.00" style="font-size: 22px; text-align: right; color: blue;" readonly ></div>
				</div>
				<div class="row">
					<div class="col-md-3"><label style="font-size: 20px;">Descuento</label></div>
					<div class="col-md-9"><input type="text" id="inDescuento" class="form-control" value="$0.00" style="font-size: 22px; text-align: right; color: blue;" readonly ></div>
				</div>
				<div class="row">
					<div class="col-md-3"><label style="font-size: 24px;">Total</label></div>
					<div class="col-md-9"><input type="text" id="total" class="form-control" value="$0.00" style="font-size: 22px; text-align: right; color: blue;" readonly ></div>
				</div>
			</div>
	    </div>
    </div>
</div>
<div id="reporte" hidden>
	<iframe id="impresion" style="width: 500px; height: 400px; display:none;">
	</iframe>
</div> 

<div class="modal fade" id="modal_abono" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4  align="center" class="modal-title" id="myModalLabel">Registrar Abono</h4>
            </div>
            <div class="modal-body">
            	<div class="row" id="divBtnAbono">
            		<div class="col-md-2 col-md-offset-4">
            			<input type="button" id="regCodigo" class="btn btn-info" value="Si" onclick="javascript:abonar();"/>
            		</div>
            		<div class="col-md-6">
            			<input type="button" id="regCodigo" class="btn btn-danger" value="No" onclick="javascript:generareporte();"/>
            		</div>
	            </div>
	            <br>
	            <div class="row">
	            	<div name="divabonos" id="divabonos" align="center" hidden>
	            		<label>Abono</label>
	            		<input type="text" class="form-control"  style="width: 200px;" id="abono" class="abono">
	            		<br>
	            		<input type="button" id="btnabonar" name="btnabonar" value="Abonar" onclick="javascript:registrarAbono();" class="btn btn-warning" />
	            	</div>
	            </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_codigo" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4  align="center" class="modal-title" id="myModalLabel">Aplicar Descuento</h4>
            </div>
            <div class="modal-body">
            	<div class="row" style="text-align: center;">
            		<div class="col-md-12" >
            			<br>
            			<h4>Escribe el codigo de seguridad</h4>
            			<input type="password" id="code">
			    	</div>
	            </div>
            </div>
            <div class="modal-footer">
            	<input type="button" class="btn btn-primary" value="Aplicar" onclick="enviarCod()">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_codigo2" role="dialog" aria-hidden="true">
            <div class="modal-dialog" >
              <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4  align="center" class="modal-title" id="myModalLabel">Quitar Articulo de Lista</h4>
              </div>
              <div class="modal-body">
                <div class="row" style="text-align: center;">
                    <div class="col-md-12" >
                        <br>
                        <h4>Escribe el codigo de seguridad</h4>
                        <input type="hidden" id="n_articulo">
                        <input type="password" id="code2">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" value="Quitar" onclick="quitarArt()">
            </div>
          </div>
         </div>
        </div>

</body>
</html>