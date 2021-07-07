<?php
  include 'php/conexion.php';
  //require('fpdf/fpdf.php');
  require('fpdf/pdf_js.php');

  session_start();
    $ID = $_SESSION['id'];
    $TIPO = $_SESSION['tipo'];
    $NOMBRE = $_SESSION['nombre'];

  date_default_timezone_set('America/Mexico_City');
  $fechaHoy = date("d/m/Y H:i:s");

  $cant_retirar = $_GET['cant_retirar'];

      class paperpdf extends FPDF { 
    var $javascript; 
    var $n_js; 

    function IncludeJS($script) { 
        $this->javascript=$script; 
    } 

    function _putjavascript() { 
        $this->_newobj(); 
        $this->n_js=$this->n; 
        $this->_out('<<'); 
        $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]'); 
        $this->_out('>>'); 
        $this->_out('endobj'); 
        $this->_newobj(); 
        $this->_out('<<'); 
        $this->_out('/S /JavaScript'); 
        $this->_out('/JS '.$this->_textstring($this->javascript)); 
        $this->_out('>>'); 
        $this->_out('endobj'); 
    } 

    function _putresources() { 
        parent::_putresources(); 
        if (!empty($this->javascript)) { 
            $this->_putjavascript(); 
        } 
    } 

    function _putcatalog() { 
        parent::_putcatalog(); 
        if (!empty($this->javascript)) { 
            $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>'); 
        } 
    } 
}

  
  $pdf = new paperpdf; 
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
  $pdf->Cell(150, 10, utf8_decode($fechaHoy), 0, 1, 'C', 0);
  $pdf->SetXY(30, 123);
  $pdf->Cell(150, 10, utf8_decode('Usuario: '.$NOMBRE), 0, 1, 'C', 0);
  
  $valorY = 140;
  $pdf->SetFont('Arial', '', 35);
  $pdf->SetXY(30, $valorY + 10);
  $pdf->Cell(150, 11, utf8_decode('COMPROBANTE DE RETIRO'), 0, 1, 'C', 0);

  $pdf->SetFont('Arial', '', 27);
  $pdf->SetXY(30, $valorY + 25);
  $pdf->Cell(150, 11, utf8_decode('MONTO RETIRADO: $'.number_format($cant_retirar, 2, '.', '')), 0, 1, 'C', 0);

  //$pdf->AutoPrint(true);
  $pdf->IncludeJS("print('true');"); 
  $pdf->Output();
  //$pdf->Output();


  //header('Location: ./punto_venta.php');
?>

