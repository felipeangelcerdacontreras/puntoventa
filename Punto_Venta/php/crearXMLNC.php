<?php
  include 'conexion.php';

  date_default_timezone_set('America/Mexico_City');

  $id_xml = $_GET['id_xml'];
  $fechaNom = date("dmY_His");

  $facturaXML = mysqli_query($con, "Select * from xmlNC where id = $id_xml");
  while ($datosFactura = mysqli_fetch_array($facturaXML)) {

    $nvoXML = new DOMDocument('1.0', 'UTF-8');
    $nvoXML -> preserveWhiteSpace = false;  
    $nvoXML -> formatOutput = true;

    $comprobante = $nvoXML -> createElement('cfdi:Comprobante','');
    $comprobante = $nvoXML -> appendChild($comprobante);
    $comprobante -> setAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
    $comprobante -> setAttribute('xmlns:cfdi', "http://www.sat.gob.mx/cfd/3");
    $comprobante -> setAttribute('xsi:schemaLocation', "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd");
    $comprobante -> setAttribute('version', $datosFactura['version']);
    $comprobante -> setAttribute('folio', $datosFactura['folio']);
    $comprobante -> setAttribute('fecha', str_replace(" ", "T", $datosFactura['fecha']));
    $comprobante -> setAttribute('sello', $datosFactura['sello']);
    $comprobante -> setAttribute('formaDePago', $datosFactura['forma_pago']);
    $comprobante -> setAttribute('noCertificado', $datosFactura['no_certificado']);
    $comprobante -> setAttribute('certificado', $datosFactura['certificado']);
    $comprobante -> setAttribute('subTotal', $datosFactura['subtotal']);
    $comprobante -> setAttribute('TipoCambio', $datosFactura['tipo_cambio']);
    $comprobante -> setAttribute('Moneda', $datosFactura['moneda']);
    $comprobante -> setAttribute('total', $datosFactura['total']);
    $comprobante -> setAttribute('metodoDePago', $datosFactura['metodo_pago']);
    $comprobante -> setAttribute('condicionesDePago', $datosFactura['condiciones_pago']);
    $comprobante -> setAttribute('LugarExpedicion', $datosFactura['lugar_expedicion']);
    $comprobante -> setAttribute('tipoDeComprobante', $datosFactura['tipo_comprobante']);

    $emisor = $nvoXML -> createElement('cfdi:Emisor','');
    $comprobante -> appendChild($emisor);
    $emisor -> setAttribute('rfc', $datosFactura['rfc_emisor']);
    $emisor -> setAttribute('nombre', $datosFactura['nombre_emisor']);

    $emiDomicFiscal = $nvoXML -> createElement('cfdi:DomicilioFiscal','');
    $emisor -> appendChild($emiDomicFiscal);
    $emiDomicFiscal -> setAttribute('calle', $datosFactura['calle_emisor']);
    $emiDomicFiscal -> setAttribute('noExterior', $datosFactura['noext_emisor']);
    $emiDomicFiscal -> setAttribute('colonia', $datosFactura['colonia_emisor']);
    $emiDomicFiscal -> setAttribute('municipio', $datosFactura['municipio_emisor']);
    $emiDomicFiscal -> setAttribute('estado', $datosFactura['estado_emisor']);
    $emiDomicFiscal -> setAttribute('pais', $datosFactura['pais_emisor']);
    $emiDomicFiscal -> setAttribute('codigoPostal', $datosFactura['cp_emisor']);

    $emiRegFiscal = $nvoXML -> createElement('cfdi:RegimenFiscal','');
    $emisor -> appendChild($emiRegFiscal);
    $emiRegFiscal -> setAttribute('Regimen', $datosFactura['regimen_emisor']);

    $receptor = $nvoXML -> createElement('cfdi:Receptor','');
    $comprobante -> appendChild($receptor);
    $receptor -> setAttribute('rfc', $datosFactura['rfc_receptor']);
    $receptor -> setAttribute('nombre', $datosFactura['nombre_receptor']);

    $recepDom = $nvoXML -> createElement('cfdi:Domicilio','');
    $receptor -> appendChild($recepDom);
    $recepDom -> setAttribute('calle', $datosFactura['calle_receptor']);
    $recepDom -> setAttribute('noExterior', $datosFactura['noext_receptor']);
    $recepDom -> setAttribute('colonia', $datosFactura['colonia_receptor']);
    $recepDom -> setAttribute('municipio', $datosFactura['municipio_receptor']);
    $recepDom -> setAttribute('estado', $datosFactura['estado_receptor']);
    $recepDom -> setAttribute('pais', $datosFactura['pais_receptor']);
    $recepDom -> setAttribute('codigoPostal', $datosFactura['cp_receptor']);

    $conceptos = $nvoXML -> createElement('cfdi:Conceptos', '');
    $comprobante -> appendChild($conceptos);

    $sqlConceptos = mysqli_query($con, "Select conceptosNC.* from conceptosNC where id_xml = $id_xml");
    while($datosConcepto = mysqli_fetch_array($sqlConceptos)) {
        $concepto = $nvoXML -> createElement('cfdi:Concepto', '');
        $conceptos -> appendChild($concepto);
        $concepto -> setAttribute('valorUnitario', $datosConcepto['valorUnitario']);
        $concepto -> setAttribute('descripcion', $datosConcepto['descripcion']);
        $concepto -> setAttribute('cantidad', $datosConcepto['cantidad']);
        $concepto -> setAttribute('importe', $datosConcepto['importe']); 
        $concepto -> setAttribute('unidad', $datosConcepto['unidad']); 
    }

    $impuestos = $nvoXML -> createElement('cfdi:Impuestos', '');
    $comprobante -> appendChild($impuestos);

    $complemento = $nvoXML -> createElement('cfdi:Complemento', '');
    $comprobante -> appendChild($complemento);
    $timbreFiscal = $nvoXML -> createElement('tfd:TimbreFiscalDigital', '');
    $complemento -> appendChild($timbreFiscal);
    $timbreFiscal -> setAttribute('xmlns:tfd', "http://www.sat.gob.mx/TimbreFiscalDigital");
    $timbreFiscal -> setAttribute('xsi:schemaLocation', "http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/TimbreFiscalDigital/TimbreFiscalDigital.xsd");
    $timbreFiscal -> setAttribute('version', $datosFactura['version_timbre']);
    $timbreFiscal -> setAttribute('UUID', $datosFactura['uuid']);
    $timbreFiscal -> setAttribute('FechaTimbrado', str_replace(" ", "T", $datosFactura['fecha_timbrado']));
    $timbreFiscal -> setAttribute('selloCFD', $datosFactura['sello_cfd']);
    $timbreFiscal -> setAttribute('noCertificadoSAT', $datosFactura['nocertificado_sat']);
    $timbreFiscal -> setAttribute('selloSAT', $datosFactura['sello_sat']);


    $nombre = "Factura_".$datosFactura['rfc_receptor']."_".$datosFactura['folio']."_".$fechaNom.".xml";

    header("Content-Type: text/xml; charset=utf-8");
    header("Content-disposition: attachment; filename=$nombre");

    echo $nvoXML -> saveXML();
    mysqli_close($con);
  }