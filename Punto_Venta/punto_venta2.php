<?php
	include 'php/conexion.php';
    session_start();
    print_r($_SESSION);
    $ID = $_SESSION['id_user'];
    $TIPO = $_SESSION['tipo'];
    $NOMBRE = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Punto de Venta</title>
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
	<!--<script src="js/bascula2.js" type="text/javascript"></script>-->
	<script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>

    <script>
        function descuento() {
            $('#code2').val('');
            var pregunta=confirm("¿Seguro que desea aplicar el descuento?");
            var descuento= document.getElementById('descuento').value;

            if (pregunta) 
            {
                $('#modal_codigo2').modal({
                    show:true,
                    backdrop:'static'
                });
            }
        }

        function enviarCod()
        {
            // var code= document.getElementById("code2").value;
            // //alert(pass);
            // $.ajax({
            //     data: "code="+code,
            //     type: "POST",
            //     url: "php/traer_pass.php",
            //     success: function(data) {
            //       if(datos = JSON.parse(data)) {
            //       var codigo=datos; 
            //       if (codigo==1) 
            //       {
                    var descuento = document.getElementById("descuento").value;
                    var porcentaje = 1 - (descuento*0.01);
                    var totalDesc = total * porcentaje;
                    var dif = total - totalDesc;
                    document.getElementById("inDescuento").value = dif.toFixed(2);
                    document.getElementById("totalFinal").value = totalDesc.toFixed(2);

            //         $('#modal_codigo2').modal('hide');

            //       }
            //       else
            //       {
            //         alert("Código de seguridad incorrecto");
            //       }

            //       }

            //       }
            // });
        }
    </script>
</head>
<body style="background-color:#e5e5dd;">
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:#337AB7;">
		<div class="navbar-header">
            <a class="navbar-brand" style="color:white;">Punto de Venta</a>
        </div>
        <form id="perfil" method="POST">
        	<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="#" onclick="devolucion()" style="color:white;"><img src="./img/refund.png" style="width: 20px;"></img> Devolución</a>
                </li>
                <li class="dropdown">
                    <a href="./modulos.php" style="color:white;"><i class="fa fa-reply fa-fw"></i> Regresar</a>
                </li>
            </ul>
    	</form>
    </nav>

    <div id="page-wrapper" style="margin-left: 0px; background-color:#e5e5dd;">
    	<div class="row">
    		<div class="col-md-4" style="background-color:#fdfdfd;">
                <h4>Cliente</h4>
                <input type="text" id="id_cliente" class="form-control" list="clientes" placeholder="Venta General">
                <datalist id="clientes">
                <?php
                    $clientes = mysqli_query($con, 'Select * from cliente');
                    while ($cliente = mysqli_fetch_array($clientes)) {
                        $id_clt = $cliente['id_cliente'];
                        $nom_clt = $cliente['nombre_cliente'];
                ?>
                    <option nom-cl="<?=$nom_clt;?>" value="<?=$id_clt;?>"><?=$nom_clt;?></option>
                <?php }   ?>
                </datalist>
                <br>
    		</div>
            <div class="col-md-4" style="background-color:#fdfdfd;">
                <h4>Vendedor</h4>
                <input type="text" id="Vendedor" class="form-control" value="<?php echo $NOMBRE;?>" data="<?php echo $ID; ?>" readonly>
                <br>
            </div>
            <div class="col-md-4" align="center">
                <img src="img/scnlogo2.png" class="img-responsive" style="height:93px; width: 350px" >
            </div>
    	</div>

        <div class="row">
            <br>
            <div class="col-md-8" style="overflow-y:auto; height:323px; background-color:#fdfdfd;">
                <div style="overflow-y:auto; height:100%;">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cant.</th>
                                <th>Artículo</th>
                                <th>Prec. Unit.</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="detalles">
                        </tbody>
                    </table>
                </div>
            </div>

<!--                 <div class="col-md-2" id="btnmostrar">
                    <br>
                    <input type="button" class="btn btn-success" value="Captura peso manualmente" onclick="muestracapturakg()">
                </div> -->

<!--                 <div class="col-md-2" id="btnocultar" hidden>
                    <br>
                    <input type="button" class="btn btn-success" value="Captura peso automatico" onclick="ocultacapturakg()">
                </div> -->

            <div class="col-md-4">
<!--                 <div style="height:186px; background-color:#fdfdfd; text-align: center;" id="divpeso">
                    <<label style="font-size: 40px;">Peso:</label>
                    <br>
                    <label id="unidades" style="font-size: 70px;"></label>
                    <label style="font-size: 45px;">kg</label>
                </div> -->

                <div class="row" style="color: blue;" id="divUnidades2">
                    <div class="col-md-8 col-md-offset-2"><label style="font-size: 20px; padding-top: 16px;">Peso kg:</label></div>
                    <div class="col-md-8 col-md-offset-2"><input type="number" id="undades" class="form-control" style="font-size: 42px; text-align: right; height:50px; color: blue;" ></div>
                </div>

                <div class="row">
                    <!-- <div class="col-md-4"><label style="font-size: 24px;">Unidades:</label></div> -->
                    <div class="col-md-10 col-md-offset-1" style="background-color:#fdfdfd; text-align: center;">
                    <label id="totalArt" style="font-size: 16px;">Importe: $0.00</label>
                    <!-- <input type="number" id="unds" class="form-control"> -->
                    </div>
                </div>
                <br>
                <div class="row" style="color: blue;" id="divUnidades" hidden>
                    <div class="col-md-4"><label style="font-size: 24px;">Unidades:</label></div>
                    <div class="col-md-8"><input type="number" id="unds" class="form-control"></div>
                </div>
                <div class="row">
                    <center><label><b>Descuento:</b>&nbsp;</label></center>  
                      <select class="form-control" id="descuento" name="descuento" readonly><br>
                        <!-- <option value="0">Sin descuento.</option> -->
                        <!-- <option value="5">5%</option> -->
                        <option value="10">10%</option>
                        <!-- <option value="15">15%</option> -->
                      </select>
                    <center><input id="aplicarDescuento" type="button" class="btn btn-success" value="Aplicar Descuento" style="width: 200px; margin-top: 5px;" onclick="javascript:enviarCod();"></center>
                </div>
                <div class="row" style="color: blue;">

                    <div class="col-md-2"><label style="font-size: 20px; padding-top: 16px;">Subtotal</label></div>
                    <div class="col-md-10"><input type="text" id="total" class="form-control" value="$0.00" style="font-size: 42px; text-align: right; height:50px; color: blue;" readonly ></div>
                </div>
                <div class="row">
                    <div class="col-md-2"><label style="font-size: 20px;">Desc. </label></div>
                    <div class="col-md-10"><input type="text" id="inDescuento" class="form-control" value="0.00" style="font-size: 22px; text-align: right; color: blue;" readonly ></div>
                </div>
                <div class="row">
                    <div class="col-md-2"><label style="font-size: 20px; ">Total.</label></div>
                    <div class="col-md-10"><input type="text" id="totalFinal" class="form-control" value="$0.00" style="font-size: 22px; text-align: right; color: blue;" readonly ></div>
                </div>
                <div class="row">
                    <div class="col-md-2"><label style="font-size: 20px; padding-top: 11px;">Cambio</label></div>
                    <div class="col-md-10"><input type="text" id="cambio_devolver" class="form-control" value="$0.00" style="font-size: 32px; text-align: right; height:40px;" readonly></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class=" col-md-8" style="font-size: 18px;">
                <div class="col-md-6">
                    <label>Artículo:</label>
                    <input type="text" id="nombreArticulo" class="form-control" list="articulos" placeholder="Escoge un artículo" onchange="selecArticulo2()">
                    <datalist id="articulos">
                    <?php
                        $articulos = mysqli_query($con, 'Select * from producto where eliminado is null');
                        while ($articulo = mysqli_fetch_array($articulos)) {
                            $id_art = $articulo['id_producto'];
                            $nom_art = $articulo['nombre'];
                            $clave = $articulo['clave'];
                            $unidad = $articulo['unidad_medida'];
                    ?>
                        <option data-id="<?=$id_art;?>" value="<?=$nom_art;?>" unidad="<?=$unidad;?>"><?=$clave;?></option>
                    <?php }   ?>
                    </datalist>
                </div>
                <div class="col-md-2">
                    <label>Precio:</label>
                    <input type="text" id="precio" class="form-control" style="font-size: 18px;" readonly>
                </div>
                <div class="col-md-2">
                    <br>
                    <input type="button" class="btn btn-success" value="Agregar" onclick="agregarArticulo2()">
                </div>
                <div class="col-md-2" align="center">
                    <h4>Artículos</h4>
                    <h4 id="totalArticulos">0</h4>
                </div>
        		<div class="col-md-6">
                    <h4><label>Forma de Pago:</label></h4>
                    <select id="forma_pago" class="form-control" onclick="muestra_recibido()">
                        <option value="0">Elige un método</option>
                        <option value="01">Efectivo</option>
                        <option value="02">Cheque</option>
                        <option value="03">Transferencia</option>
                        <option value="04">Tarjeta de crédito</option>
                        <option value="28">Tarjeta de debito</option>
                        <option value="001">Efectivo - Tarjeta Crédito</option>
                        <option value="002">Efectivo - Tarjeta Debito</option>
                    </select>
        		</div>
                <div class="col-md-4" id="div_recibidoT" hidden>
                    <h4><label>Pagado con Tarjeta:</label></h4><!--  pagado con tarjeta  -->
                    <input type="number" id="recibidoT" class="form-control" placeholder="$0.00" onkeyup="cambio2()">
                </div>
                <div class="col-md-2" id="div_botonD" hidden>
                    <br>
                    <input type="button" class="btn btn-success" value="Definir" onclick="definir()" style="font-size: 26px;">
                </div>
                <div class="col-md-2" id="div_botonC" hidden>
                    <br>
                    <input type="button" class="btn btn-success" value="Cambiar" onclick="cambiar()" style="font-size: 26px;">
                </div>
                <div class="col-md-4" id="div_recibido" hidden>
                    <h4><label>Recibido:</label></h4><!--  pagado con efectivo  -->
                    <input type="text" id="recibido" class="form-control" placeholder="$0.00" onkeyup="cambio()">
                    <input type="hidden" id="cambioEscondido" class="form-control" >
                </div>
                <div class="col-md-4" id="div_nroMovimiento" hidden>
                    <h4><label>Nro de Cuenta/Movimiento:</label></h4>
                    <input type="text" id="nro_mov" class="form-control" placeholder="Introduce los ultimos 4 digitos de la cuenta o movimiento">
                </div>
                <div class="col-md-2">
                    <br>
                    <input type="button" class="btn btn-success" value="Pagar" onclick="pagar()" style="font-size: 26px;">
                </div>
        	</div>
<!--             <div class="col-md-4" align="center">
                <img src="" class="img-responsive" style="height:139px; width:350px" >
            </div> -->
        </div>

        <div class="modal fade" id="modal_cliente" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4  align="center" class="modal-title" id="myModalLabel">Registro Nuevo Cliente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>RFC:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="rfc_cliente" class="form-control" placeholder="RFC" maxlength="13"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Nombre:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="nom_cliente" class="form-control" placeholder="Nombre"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Calle:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="calle_cliente" class="form-control" placeholder="Calle"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>No Exterior:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="noExt_cliente" class="form-control" placeholder="Número exterior"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Colonia:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="col_cliente" class="form-control" placeholder="Colonia"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Municipio:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="municipio_cliente" class="form-control" placeholder="Municipio"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Estado:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="edo_cliente" class="form-control" placeholder="Estado"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>País:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="pais_cliente" class="form-control" placeholder="País"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="text-align: right;"><h4><label>Código Postal:</label></h4></div>
                            <div class="col-md-9"><input type="text" id="cp_cliente" class="form-control" placeholder="Código Postal" style="margin-top: 10px" pattern="\d*" maxlength="5"></div>
                        </div>
                        <div align="center">
                            <input type="button" class="btn btn-primary" value="Guardar" onclick="guardarCliente(1)">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_devolucion" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4  align="center" class="modal-title" id="myModalLabel">Devolución</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2" style="text-align: right;"><h4><label>Nro. Venta:</label></h4></div>
                            <div class="col-md-5">
                                <input type="text" id="nro_venta" class="form-control" placeholder="Escoge una venta" list="nro_ventas" onchange="buscaVenta()">
                                <datalist id="nro_ventas">
                                    <?php
                                    $ventas = mysqli_query($con, 'Select id_venta from venta where venta_cancelada is null');
                                    while ($venta = mysqli_fetch_array($ventas)) {
                                        $id_venta = $venta['id_venta'];
                                    ?>
                                    <option value="<?=$id_venta;?>"></option>
                                    <?php } ?>
                                </datalist>
                            </div>
                        </div>
                        <h4 style="text-align: center">Detalles</h4>
                        <div class="row">
                            <div class="col-md-8" style="overflow-y:auto;">
                                <div style="overflow-y:auto;">
                                    <table class="table" >
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Cant.</th>
                                                <th>Artículo</th>
                                                <th>Prec. Unit.</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detallesDevolucion">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <br>
                                <div class="col-md-2"><label>Total</label></div>
                                <div class="col-md-10"><input type="text" id="totalDevolucion" class="form-control" value="$0.00" style="text-align: right; color: blue;" readonly ></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <input type="button" class="btn btn-primary" value="Devolver" onclick="devolver()">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_codigo" role="dialog" aria-hidden="true">
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
                        <input type="password" id="code">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" value="Quitar" onclick="quitarArt()">
            </div>
          </div>
         </div>
        </div>

        <div class="modal fade" id="modal_codigo2" role="dialog" aria-hidden="true">
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
                        <input type="password" id="code2">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" value="Aplicar" onclick="enviarCod()">
            </div>
          </div>
         </div>
        </div>

        <div class="modal fade" id="modal_aviso" role="dialog" aria-hidden="true">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h4  align="center" class="modal-title" id="aviso">Limite de caja alcanzado, realiza un corte de caja para seguir vendiendo.</h4>
                    </div>
                    <div class="modal-body">                        
                        <div class="modal-footer" style="text-align: center;">
                            <input type="button" class="btn btn-primary" data-dismiss="modal" value="Aceptar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
    <?php
        // Se le avisa al vendedor si ya llego o supero el limite de caja al terminar la venta, para realizar un corte de caja. 
        $verificarCaja = mysqli_query($con, "SELECT monto_contenido FROM caja WHERE $ID = id_caja");
        $resultado = mysqli_fetch_array($verificarCaja);
        if($resultado['monto_contenido'] >= 4000) {
            echo "<script type='text/javascript'>";
            echo "$('#modal_aviso').modal({ show:true, backdrop:'static' });";
            echo "</script>";
        }
    ?>
</body>
</html>