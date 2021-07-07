<?php
  include 'php/conexion.php';
  require('../fpdf/fpdf.php');

  date_default_timezone_set('America/Mexico_City');
  $fechaHoy = date("d/m/Y H:i:s");

  $id_venta = $_GET['id_venta'];
  $recibido = $_GET['recibido'];
  $cambio = $_GET['cambio'];

  $query = "Select datos_usuarios.nombre as nom, nombre_cliente, venta.total, venta_detalle.total as totalA, cantidad, precio_unitario, producto.nombre as art from venta inner join venta_detalle on venta_detalle.id_venta = venta.id_venta inner join producto on producto.id_producto = venta_detalle.id_articulo inner join usuarios on usuarios.id = venta.id_user inner join datos_usuarios on datos_usuarios.id_user = usuarios.id_user left join cliente on cliente.id_cliente = venta.id_cliente where venta.id_venta = $id_venta";

  $venta = mysqli_query($con, $query);
  if($ventaDet = mysqli_fetch_array($venta)) {
    $nom_cliente = $ventaDet['nombre_cliente'];
    $vendedor = $ventaDet['nom'];
    $total = $ventaDet['total'];

    if($nom_cliente == null)
      $nom_cliente = "Publico en General";
  }
  //$pdf = new PDF_AutoPrint();
  //$pdf->AddPage();
  $pdf = new FPDF(); 
  $pdf->AddPage('P');
  $pdf->SetFont('Arial', '', 29);
  $pdf->Cell(200,12,$pdf->Image('img/scnlogo2.png',55, 10, 100, 30),0,0,'L');

  $pdf->SetXY(30, 44);
  $pdf->Cell(150, 10, utf8_decode('VIVIANA PATRICIA HERNANDEZ HUIZAR'), 0, 1, 'C', 0);
  $pdf->SetXY(30, 58);
  $pdf->Cell(150, 10, utf8_decode('Calle Rio Conchos 1460'), 0, 1, 'C', 0);
  $pdf->SetXY(30, 71);
  $pdf->Cell(150, 10, utf8_decode('Col. Magdalenas, Torreon, Coahuila.'), 0, 1, 'C', 0);
  $pdf->SetXY(30, 83);
  $pdf->Cell(150, 10, utf8_decode('Ofic. 018714553988'), 0, 1, 'C', 0);
  $pdf->SetXY(30, 96);
  $pdf->Cell(150, 10, utf8_decode('RFC: HEHV920512FX6'), 0, 1, 'C', 0);
  $pdf->SetXY(30, 110);
  $pdf->Cell(150, 10, utf8_decode($fechaHoy.' Venta: '.$id_venta), 0, 1, 'C', 0);
  $pdf->SetXY(30, 123);
  $pdf->Cell(150, 10, utf8_decode('Le atendio: '.$vendedor), 0, 1, 'C', 0);
  $pdf->SetXY(30, 135);
  $pdf->Cell(150, 10, utf8_decode('Cliente: '.$nom_cliente), 0, 1, 'C', 0);
  $pdf->SetXY(30, 145);
  $pdf->Cell(150, 10, utf8_decode('-----------------------------------------------------------------'), 0, 1, 'C', 0);
   $pdf->SetXY(30, 147);
  $pdf->Cell(150, 10, utf8_decode('-----------------------------------------------------------------'), 0, 1, 'C', 0);
  $valorY = 147;
  $contador = 1;
  $limite = 8;
  $pdf->SetFont('Arial', '', 29);
  $articulos = mysqli_query($con, $query);

  while($articulosDet = mysqli_fetch_array($articulos)) {
    $articulo = $articulosDet['art'];
    $cantidad = $articulosDet['cantidad'];
    $precio_unitario = $articulosDet['precio_unitario'];
    $totalA = $articulosDet['totalA'];
    $valorY = $valorY + 15;

    $pdf->SetXY(10, $valorY);
    $pdf->Cell(60, 9, utf8_decode(substr($articulo, 0, 20)), 0, 1, 'L', 0);
    $pdf->SetXY(90, $valorY);
    $pdf->Cell(22, 9, utf8_decode($cantidad." x"), 0, 1, 'R', 0);
    $pdf->SetXY(130, $valorY);
    $pdf->Cell(20, 9, utf8_decode("$".$precio_unitario), 0, 1, 'R', 0);
    $pdf->SetXY(165, $valorY);
    $pdf->Cell(30, 9, utf8_decode("$".$totalA), 0, 1, 'R', 0);

    $contador++;

    if($contador == $limite) {
      $pdf->SetXY(10, 282);
      $pdf->Cell(60, 9, '', 0, 1, 'R', 0);
      $valorY = 0;
      $contador = 1;
      $limite = 10;
    }
  }

  $valorY = 7;

  $pdf->SetFont('Arial', '', 33);
  $pdf->SetXY(30, $valorY + 8);
  $pdf->Cell(150, 11, utf8_decode('-----------------------------------------------------------------'), 0, 1, 'C', 0);
  $pdf->SetXY(30, $valorY + 10);
  $pdf->Cell(150, 11, utf8_decode('-----------------------------------------------------------------'), 0, 1, 'C', 0);
  $pdf->SetXY(85, $valorY + 20);
  $pdf->Cell(40, 11, utf8_decode("Total: ", 0, 1, 'L', 0);
  $pdf->SetXY(125, $valorY + 20);
  $pdf->Cell(45, 11, utf8_decode("$"), 0, 1, 'R', 0);
  $pdf->SetXY(80, $valorY + 36);
  $pdf->Cell(45, 11, utf8_decode("Recibido:  "), 0, 1, 'R', 0);
  $pdf->SetXY(125, $valorY + 36);
  $pdf->Cell(45, 11, utf8_decode("$".number_format($recibido, 2, '.', '')), 0, 1, 'R', 0);
  $pdf->SetXY(80, $valorY + 50);
  $pdf->Cell(45, 11, utf8_decode("Su cambio:  "), 0, 1, 'R', 0);
  $pdf->SetXY(125, $valorY + 50);
  $pdf->Cell(45, 11, utf8_decode("$".number_format($cambio, 2, '.', '')), 0, 1, 'R', 0);
  $pdf->SetFont('Arial', '', 27);
  $pdf->SetXY(30, $valorY + 65);
  $pdf->Cell(150, 11, utf8_decode('¡GRACIAS POR SU COMPRA!'), 0, 1, 'C', 0);
  $pdf->SetFont('Arial', '', 20);
  $pdf->SetXY(30, $valorY + 73);
  $pdf->Cell(150, 11, utf8_decode('No se hacen cambios ni devoluciones'), 0, 1, 'C', 0);

  //$pdf->AutoPrint(true);
  $pdf->Output();
?>