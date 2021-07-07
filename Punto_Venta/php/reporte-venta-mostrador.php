<?php

require('../fpdf/fpdf.php');
include "./conn.php";
$numventa = $_GET['numventa'];
$fechaz = $_GET['fechaz'];

$resultado = mysqli_query($con,"SELECT clientes.*, ventas.idVenta,ventas.idCliente FROM `ventas` INNER JOIN clientes on
ventas.idCliente= clientes.id WHERE idVenta = $numventa");
if($resultado === FALSE) {
    die(mysqli_error()); // TODO: better error handling
}

while($row = mysqli_fetch_array($resultado)){
  $nombre = $row['nombre'];
  $calle = $row['calle'];
  $noExterior = $row['noExterior'];
  $colonia = $row['colonia'];
  $municipio = $row['municipio'];
  $estado = $row['estado'];
  $pais = $row['pais'];
  $cp = $row['cp'];
  $telefono = $row ['telefono1'];

  $direccion = $calle." ".$noExterior." ".$colonia." ".$municipio." ".$estado." ".$pais;
}
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
//inserto la cabecera poniendo una imagen dentro de una celda
$pdf->Cell(200,4,$pdf->Image('../img/scnlogo.png',10,10,30),0,0,'L');
$pdf->Ln(1);
$pdf->Cell(200,4,"Viviana Patricia Hernandez Huizar",0, 0, 'C');
$pdf->Cell(-60,4,"ORDEN DE VENTA",0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,"RFC: HEHV92512FX5",0, 0, 'C');
$pdf->Cell(-60,4,$numventa,0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,"Calle Rio Conchos1460 Col. Magdalenas",0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,utf8_decode("C.P. 27010 Torreón Coah."), 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,"Ofic. 018714553988 Movil 8712696359 ", 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,"Juan Pablo Chairez Flores ", 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,"chairezf.flores@hotmail.com", 0, 0, 'C');
$pdf->Ln(7);
$pdf->Cell(100,4,"Fecha: ".$fechaz);

$pdf->Ln(5);
$pdf->Cell(100,6,"Nombre : ".$nombre);
$pdf->Ln(5);
$pdf->Cell(100,6,"Domicilio:".$direccion);
$pdf->Ln(5);
$pdf->Cell(90,6,"Telefono: ".$telefono );

$pdf->Ln(9);
$pdf->SetFont('Arial','B',8);

$detalle = mysqli_query($con,"SELECT ventas.*, productos_venta.*, ventas_intermedio.* FROM ventas INNER join `ventas_intermedio` on ventas.idVenta = ventas_intermedio.numero_compra INNER JOIN productos_venta on ventas_intermedio.tipo_producto = productos_venta.idProductosventa WHERE numero_compra= $numventa");
 if($detalle === FALSE) {
    die(mysqli_error()); // TODO: better error handling
}
//Instaciamos la clase para genrear el documento pdf
//$pdf=new FPDF();

//Agregamos la primera pagina al documento pdf
//$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles

$y_axis_initial = 25;

//Seteamos el tiupo de letra y creamos el titulo de la pagina. No es un encabezado no se repetira
$pdf->SetFont('Arial','B',10);

$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,'LISTA DE PRODUCTOS',1,0,'C');

$pdf->Ln(8);

//Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,6,'Cantidad',1,0,'C',1);

$pdf->Cell(90,6,'Concepto',1,0,'C',1);
$pdf->Cell(30,6,'P. unitario',1,0,'C',1);
$pdf->Cell(30,6,'Importe',1,0,'C',1);

$pdf->Ln(6);

//Comienzo a crear las fiulas de productos según la consulta mysql

while($fila = mysqli_fetch_array($detalle))
{

    $peso = $fila['peso'];

    $nombreP = $fila['nombrepv'];
    $precio=$fila['precio'];
    $importe=$fila['total'];
   $subtotal=$fila['total_venta'];
   $descuento=$fila['descuento_en_pesos'];
   $total=$fila['total_con_descuento'];
    $pdf->Cell(30,4,number_format($peso,2,'.','')."Kgs",1,0,'C');


       $pdf->Cell(90,4,$nombreP,1,0,'C');
    $pdf->Cell(30,4,"$"." ".number_format($precio,2,'.',''),1,0,'C',1);
    $pdf->Cell(30,4,"$"." ".number_format($importe,2,'.',''),1,0,'C',1);

//Muestro la iamgen dentro de la celda GetX y GetY dan las coordenadas actuales de la fila

    // $pdf->Cell( 30, 15, $pdf->Image($imagen, $pdf->GetX()+5, $pdf->GetY()+3, 20), 1, 0, 'C', false );

$pdf->Ln(4);

}

$pdf->Cell(120,4);

$pdf->Cell(30,4,"SUBTOTAL",1,0,'L');

$pdf->Cell(30,4,"$"." ".number_format($subtotal,2,'.',''),1,0,'R');
$pdf->Ln(4);

$pdf->Cell(120,4);

$pdf->Cell(30,4,"DESCUENTO",1,0,'L');

$pdf->Cell(30,4,"$"." ".number_format($descuento,2,'.',''),1,0,'R');
$pdf->Ln(4);

$pdf->Cell(120,4);

$pdf->Cell(30,4,"TOTAL",1,0,'L');

$pdf->Cell(30,4,"$"." ".number_format($total,2,'.',''),1,0,'R');
$pdf->Ln(8);
 $pdf->SetFont('Arial','B',6);
$pdf->Cell(15,4,"",0,0,'L');
$pdf->Multicell(160,4, "DEBO(EMOS) Y PAGARE(MOS) A LA ORDEN DE VIVIANA PATRICIA HERNANDEZ HUIZAR EL DIA  ____________DE ____________DE 20____________    LA CANTIDAD DE $ (_____________________________________________________________) VALOR RECIBIDO A MI ENTERA SATISFACCION, SINO FUERA CUBIERTA  A SU VENCIMIENTO , LA SUMA DE ESTE PAGARE EXPRESA CUBRIRE ADEMAS DE ELLA EL _____% DE INTERES MENSUAL DESDE LA FECHA DE SU VENCIMIENTO HASTA QUE SEA TOTALMENTE CUBIERTA , ME SOMETO A LOS TRIBUNALES QUE EL TENEDOR SEÑALE Y RENUNCIO AL FUERO DE MI DOMICILIO" );
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 8);
//inserto la cabecera poniendo una imagen dentro de una celda
$pdf->Cell(200,4,$pdf->Image('../img/scnlogo.png',10,130,30),0,0,'L');
$pdf->Ln(1);
$pdf->Cell(200,4,"Viviana Patricia Hernandez Huizar",0, 0, 'C');
$pdf->Cell(-60,4,"ORDEN DE VENTA",0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,"RFC: HEHV92512FX5",0, 0, 'C');
$pdf->Cell(-60,4,$numventa,0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,"Calle Rio Conchos1460 Col. Magdalenas",0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,utf8_decode("C.P. 27010 Torreón Coah."), 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,"Ofic. 018714553988 Movil 8712696359 ", 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,"Juan Pablo Chairez Flores ", 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(200,4,"chairezf.flores@hotmail.com", 0, 0, 'C');
$pdf->Ln(7);
$pdf->Cell(100,4,"Fecha: ".$fechaz);

$pdf->Ln(5);
$pdf->Cell(100,6,"Nombre : ".$nombre);
$pdf->Ln(5);
$pdf->Cell(100,6,"Domicilio:".$direccion);
$pdf->Ln(5);
$pdf->Cell(90,6,"Telefono: ".$telefono );

$pdf->Ln(9);
$pdf->SetFont('Arial','B',8);

$detalle = mysqli_query($con,"SELECT ventas.*, productos_venta.*, ventas_intermedio.* FROM ventas INNER join `ventas_intermedio` on ventas.idVenta = ventas_intermedio.numero_compra INNER JOIN productos_venta on ventas_intermedio.tipo_producto = productos_venta.idProductosventa WHERE numero_compra= $numventa");
 if($detalle === FALSE) {
    die(mysqli_error()); // TODO: better error handling
}
//Instaciamos la clase para genrear el documento pdf
//$pdf=new FPDF();

//Agregamos la primera pagina al documento pdf
//$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles

$y_axis_initial = 25;

//Seteamos el tiupo de letra y creamos el titulo de la pagina. No es un encabezado no se repetira
$pdf->SetFont('Arial','B',10);

$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,'LISTA DE PRODUCTOS',1,0,'C');

$pdf->Ln(8);

//Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,6,'Cantidad',1,0,'C',1);

$pdf->Cell(90,6,'Concepto',1,0,'C',1);
$pdf->Cell(30,6,'P. unitario',1,0,'C',1);
$pdf->Cell(30,6,'Importe',1,0,'C',1);

$pdf->Ln(6);

//Comienzo a crear las fiulas de productos según la consulta mysql

while($fila = mysqli_fetch_array($detalle))
{

    $peso = $fila['peso'];

    $nombreP = $fila['nombrepv'];
    $precio=$fila['precio'];
    $importe=$fila['total'];
   $subtotal=$fila['total_venta'];
   $descuento=$fila['descuento_en_pesos'];
   $total=$fila['total_con_descuento'];
    $pdf->Cell(30,4,number_format($peso,2,'.','')."Kgs",1,0,'C');


       $pdf->Cell(90,4,$nombreP,1,0,'C');
    $pdf->Cell(30,4,"$"." ".number_format($precio,2,'.',''),1,0,'C',1);
    $pdf->Cell(30,4,"$"." ".number_format($importe,2,'.',''),1,0,'C',1);

//Muestro la iamgen dentro de la celda GetX y GetY dan las coordenadas actuales de la fila

    // $pdf->Cell( 30, 15, $pdf->Image($imagen, $pdf->GetX()+5, $pdf->GetY()+3, 20), 1, 0, 'C', false );

$pdf->Ln(4);

}

$pdf->Cell(120,4);

$pdf->Cell(30,4,"SUBTOTAL",1,0,'L');

$pdf->Cell(30,4,"$"." ".number_format($subtotal,2,'.',''),1,0,'R');
$pdf->Ln(4);

$pdf->Cell(120,4);

$pdf->Cell(30,4,"DESCUENTO",1,0,'L');

$pdf->Cell(30,4,"$"." ".number_format($descuento,2,'.',''),1,0,'R');
$pdf->Ln(4);

$pdf->Cell(120,4);

$pdf->Cell(30,4,"TOTAL",1,0,'L');

$pdf->Cell(30,4,"$"." ".number_format($total,2,'.',''),1,0,'R');
$pdf->Ln(8);
 $pdf->SetFont('Arial','B',6);
$pdf->Cell(15,4,"",0,0,'L');
$pdf->Multicell(160,4, "DEBO(EMOS) Y PAGARE(MOS) A LA ORDEN DE VIVIANA PATRICIA HERNANDEZ HUIZAR EL DIA  ____________DE ____________DE 20____________    LA CANTIDAD DE $ (_____________________________________________________________) VALOR RECIBIDO A MI ENTERA SATISFACCION, SINO FUERA CUBIERTA  A SU VENCIMIENTO , LA SUMA DE ESTE PAGARE EXPRESA CUBRIRE ADEMAS DE ELLA EL _____% DE INTERES MENSUAL DESDE LA FECHA DE SU VENCIMIENTO HASTA QUE SEA TOTALMENTE CUBIERTA , ME SOMETO A LOS TRIBUNALES QUE EL TENEDOR SEÑALE Y RENUNCIO AL FUERO DE MI DOMICILIO" );
$fichero='orden-de-venta.pdf';

$pdfdoc = $pdf->Output($fichero,'D');
// $pdfdoc = $pdf->Output();
?>
