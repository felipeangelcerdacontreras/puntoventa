<?php
	include('conexion.php');
	include('libFactura.php');
	include('emisor.php');

	date_default_timezone_set('America/Mexico_City');

	$rutaXSL = "../documents/cadenaoriginal_3_2.xslt";

	$fecha = str_replace(" ", "T", date("Y-m-d H:i:s"));
	$hora = date("H:i:s");
	$fechaNom = date("Ymd_His");
	$error = 0;

	$conceptosArray = json_decode($_POST['conceptos']);
	$id_venta = $_POST['idVenta'];
	$total = number_format($_POST['total'], 2, '.', '');

	$cliente = mysqli_query($con, "Select * from cliente where id_cliente = (Select id_cliente from venta where id_venta = $id_venta)");
	if($datos_cliente = mysqli_fetch_array($cliente)) {
		$rfc_receptor = $datos_cliente['rfc_cliente'];
		$nombre_receptor = $datos_cliente['nombre_cliente'];
		$calle_receptor = $datos_cliente['calle_cliente'];
		$noext_receptor = $datos_cliente['noExt_cliente'];
		$colonia_receptor = $datos_cliente['col_cliente'];
		$municipio_receptor = $datos_cliente['municipio_cliente'];
		$estado_receptor = $datos_cliente['edo_cliente'];
		$pais_receptor = $datos_cliente['pais_cliente'];
		$cp_receptor = $datos_cliente['cp_cliente'];

		$linea = file_get_contents($rutaSerial) or die("Error al leer el archivo");
		$noCertificado = $linea[8].$linea[10].$linea[12].$linea[14].$linea[16].$linea[18].$linea[20].$linea[22].$linea[24].$linea[26].$linea[28].$linea[30].$linea[32].$linea[34].$linea[36].$linea[38].$linea[40].$linea[42].$linea[44].$linea[46];
		$cerCont = file_get_contents($rutaCertificado);

		$certificado = base64_encode($cerCont);

		$nomxml = '../documents/'.$rfc_receptor."_Factura_".$fechaNom.".xml";
		$xml = new DOMDocument('1.0', 'UTF-8');
		$xml->preserveWhiteSpace = false;  
		$xml->formatOutput = true;

		$comprobante = $xml->createElement('cfdi:Comprobante','');
		$comprobante = $xml->appendChild($comprobante);

		$comprobante->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
		$comprobante->setAttribute('xsi:schemaLocation', 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd');
		$comprobante->setAttribute('xmlns:cfdi', 'http://www.sat.gob.mx/cfd/3');
		$comprobante->setAttribute('version', '3.2');
		$comprobante->setAttribute('folio', '0');
		$comprobante->setAttribute('fecha', $fecha);
		$comprobante->setAttribute('sello', '');
		$comprobante->setAttribute('formaDePago', 'Pago en una sola exhibición');
		$comprobante->setAttribute('noCertificado', $noCertificado);
		$comprobante->setAttribute('certificado', $certificado);
		$comprobante->setAttribute('subTotal', $total);
		$comprobante->setAttribute('TipoCambio', '1.00');
		$comprobante->setAttribute('Moneda', 'MXN');
		$comprobante->setAttribute('total', $total);
		$comprobante->setAttribute('metodoDePago', '99');
		$comprobante->setAttribute('condicionesDePago', 'Otros');
		$comprobante->setAttribute('LugarExpedicion', 'Torreón, Coahuila');
		$comprobante->setAttribute('tipoDeComprobante', 'egreso');

		$emisor = $xml->createElement('cfdi:Emisor','');
		$comprobante->appendChild($emisor);
		$emisor->setAttribute('rfc', $rfc_emisor);
		$emisor->setAttribute('nombre', $nombre_emisor);

		$dom_fis = $xml->createElement('cfdi:DomicilioFiscal', '');
		$emisor->appendChild($dom_fis);
		$dom_fis->setAttribute('calle', $calle_emisor);
		$dom_fis->setAttribute('noExterior', $noext_emisor);
		$dom_fis->setAttribute('colonia', $colonia_emisor);
		$dom_fis->setAttribute('municipio', $municipio_emisor);
		$dom_fis->setAttribute('estado', $estado_emisor);
		$dom_fis->setAttribute('pais', $pais_emisor);
		$dom_fis->setAttribute('codigoPostal', $cp_emisor);

		$regimenfiscal = $xml->createElement('cfdi:RegimenFiscal', '');
		$emisor->appendChild($regimenfiscal);
		$regimenfiscal->setAttribute('Regimen', 'Régimen de actividades empresariales');

		$receptor = $xml->createElement('cfdi:Receptor', '');
		$comprobante->appendChild($receptor);
		$receptor->setAttribute('rfc', $rfc_receptor);
		$receptor->setAttribute('nombre', $nombre_receptor);

		$dom_recep = $xml->createElement('cfdi:Domicilio', '');
		$receptor->appendChild($dom_recep);
		$dom_recep->setAttribute('calle', $calle_receptor);
		$dom_recep->setAttribute('noExterior', $noext_receptor);
		$dom_recep->setAttribute('colonia', $colonia_receptor);
		$dom_recep->setAttribute('municipio', $municipio_receptor);
		$dom_recep->setAttribute('estado', $estado_receptor);
		$dom_recep->setAttribute('pais', $pais_receptor);
		$dom_recep->setAttribute('codigoPostal', $cp_receptor);

		$conceptos = $xml->createElement('cfdi:Conceptos', '');
		$comprobante->appendChild($conceptos);
		$impuestos = $xml->createElement('cfdi:Impuestos','');
		$comprobante->appendChild($impuestos);

		foreach ($conceptosArray as $i => $conceptoArray) {
			$concepto = $xml->createElement('cfdi:Concepto','');
			$conceptos->appendChild($concepto);
			$concepto->setAttribute('valorUnitario', number_format($conceptoArray[1], 2, '.', ''));
			$concepto->setAttribute('descripcion', $conceptoArray[5]);
			$concepto->setAttribute('cantidad', $conceptoArray[2]);
			$concepto->setAttribute('importe', number_format($conceptoArray[3], 2, '.', ''));
			$concepto->setAttribute('unidad', $conceptoArray[4]);
		}

		$xml->save($nomxml);

		error_reporting(E_ERROR);
		$xml = new DOMDocument("1.0", "UTF-8");
		$xml->load($nomxml);
		$xsl = new DOMDocument();
		$xsl->load($rutaXSL);

		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl);
		if($cadenaOriginal = $proc->transformToXML($xml)) {
			unset($proc);
			// $contKeyPEM = file_get_contents($rutaLlave);

			$contKeyPEM = file_get_contents($rutaLlave);

			if (!$privKey = openssl_get_privatekey($contKeyPEM)) {
				$res['mens'] = 'No se ha podido obtener la llave privada. ERR: '.openssl_error_string();
				echo json_encode($res);
			}
			if (!openssl_sign($cadenaOriginal, $sign, $privKey, OPENSSL_ALGO_SHA1)) {
				echo openssl_error_string();
				exit;
			}
			$sello = base64_encode($sign);

			$modXml = simplexml_load_file($nomxml);
			$modXml->attributes()->sello = $sello;
			$modXml->asXml($nomxml);

			/************** TIMBRADO **************/
			$parametros = array('emisorRFC'=>$rfc_emisor, 'UserID'=>$user_id, 'UserPass'=>$user_password);
			$opciones = null;

			$cfdi = file_get_contents($nomxml);
			$cliente = new FacturacionModerna($url_timbrado, $parametros, 0);

			if($cliente->timbrar($cfdi, $opciones)) {
				if($cliente->xml) {
					// echo "XML almacenado correctamente en $nomxml\n";
					file_put_contents($nomxml, $cliente->xml);
					InsertaXML($nomxml, $id_venta);
				}
			}
			else {
				$res['mens'] = "[".$cliente->ultimoCodigoError."] - ".$cliente->ultimoError."\n";
				echo json_encode($res);
			}
		}
		else {
			$res['mens'] =  "Problemas con la conexión, intentelo nuevamente.";
			echo json_encode($res);
		}
	}
	else {
		$res['mens'] =  "Cliente no encontrado.";
		echo json_encode($res);
	}
	mysqli_close($con);

	function InsertaXML($nombreXML, $id_venta) {
		include 'conexion.php';

		$xml = simplexml_load_file($nombreXML);
		$ns = $xml->getNamespaces(true);
		$xml->registerXPathNamespace('c', $ns['cfdi']);
		$xml->registerXPathNamespace('t', $ns['tfd']);

		foreach ($xml->xpath('//c:Comprobante') as $cfdiComprobante) {
			$version = $cfdiComprobante['version'];
			$folio = $cfdiComprobante['folio'];
		  	$fecha = $cfdiComprobante['fecha'];
			$sello = $cfdiComprobante['sello'];
			$forma_pago = $cfdiComprobante['formaDePago'];
			$no_certificado = $cfdiComprobante['noCertificado'];
			$certificado = $cfdiComprobante['certificado'];
			$subtotal = $cfdiComprobante['subTotal'];
			$moneda = $cfdiComprobante['Moneda'];
			$tipo_cambio = $cfdiComprobante['TipoCambio'];
			$total = $cfdiComprobante['total'];
			$metodo_pago = $cfdiComprobante['metodoDePago'];
			$condiciones_pago = $cfdiComprobante['condicionesDePago'];
			$lugar_expedicion = $cfdiComprobante['LugarExpedicion'];
			$tipo_comprobante = $cfdiComprobante['tipoDeComprobante'];
		}

		if($tipo_comprobante == "egreso") {
			foreach ($xml->xpath('//c:Comprobante//cfdi:Emisor') as $Emisor) {
				$rfc_emisor = $Emisor['rfc'];
				$nombre_emisor = $Emisor['nombre'];
			}

			foreach ($xml->xpath('//c:Comprobante//cfdi:Emisor//cfdi:DomicilioFiscal') as $domEmisor) {
				$calle_emisor = $domEmisor['calle'];
				$noext_emisor = $domEmisor['noExterior'];
				$colonia_emisor = $domEmisor['colonia'];
				$municipio_emisor = $domEmisor['municipio'];
				$estado_emisor = $domEmisor['estado'];
				$pais_emisor = $domEmisor['pais'];
				$cp_emisor = $domEmisor['codigoPostal'];
			}

			$expEn_calle = null; $expEn_noext = null; $expEn_colonia = null; $expEn_estado = null; 
			$expEn_pais = null; $expEn_cp = null; 
			foreach ($xml->xpath('//c:Comprobante//cfdi:Emisor//cfdi:ExpedidoEn') as $expedidoEn) {
				$expEn_calle = $expedidoEn['calle'];
				$expEn_noext = $expedidoEn['noExterior'];
				$expEn_colonia = $expedidoEn['colonia'];
				$expEn_estado = $expedidoEn['estado'];
				$expEn_pais = $expedidoEn['pais'];
				$expEn_cp = $expedidoEn['codigoPostal'];
			}

			foreach ($xml->xpath('//c:Comprobante//cfdi:Emisor//cfdi:RegimenFiscal') as $regEmisor) {
				$regimen_emisor = $regEmisor['Regimen'];
			}

			foreach ($xml->xpath('//c:Comprobante//cfdi:Receptor') as $Receptor) {
				$rfc_receptor = $Receptor['rfc'];
				$nombre_receptor = $Receptor['nombre'];
			}

			foreach ($xml->xpath('//c:Comprobante//cfdi:Receptor//cfdi:Domicilio') as $domReceptor) {
				$calle_receptor = $domReceptor['calle'];
				$noext_receptor = $domReceptor['noExterior'];
				$colonia_receptor = $domReceptor['colonia'];
				$municipio_receptor = $domReceptor['municipio'];
				$estado_receptor = $domReceptor['estado'];
				$pais_receptor = $domReceptor['pais'];
				$cp_receptor = $domReceptor['codigoPostal'];
			}

			$sello_sat = null; $nocertificado_sat = null; $sello_cfd = null; $fecha_timbrado = null;
			$uuid = null; $version_timbre = null;
			foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
				$sello_sat = $tfd['selloSAT'];
				$nocertificado_sat = $tfd['noCertificadoSAT'];
				$sello_cfd = $tfd['selloCFD'];
				$fecha_timbrado = $tfd['FechaTimbrado'];
				$uuid = $tfd['UUID'];
				$version_timbre = $tfd['version'];
			}

			$insertaXML = mysqli_query($con, "Insert into xmlNC values(null, '$version', '$folio', '$fecha', '$sello', '$forma_pago', '$no_certificado', '$certificado', '$subtotal', '$tipo_cambio', '$moneda', '$total', '$metodo_pago', '$condiciones_pago', '$lugar_expedicion', '$tipo_comprobante', null, null, null, null, '$rfc_emisor', '$nombre_emisor', '$calle_emisor', '$noext_emisor', '$colonia_emisor', '$municipio_emisor', '$estado_emisor', '$pais_emisor', '$cp_emisor', '$expEn_calle', '$expEn_noext', '$expEn_colonia', '$expEn_estado', '$expEn_pais', '$expEn_cp', '$regimen_emisor', '$rfc_receptor', '$nombre_receptor', '$calle_receptor', '$noext_receptor', '$colonia_receptor', '$municipio_receptor', '$estado_receptor', '$pais_receptor', '$cp_receptor', null, '$sello_sat', '$nocertificado_sat', '$sello_cfd', '$fecha_timbrado', '$uuid', '$version_timbre', '$id_venta', null)");
			$id_xml = mysqli_insert_id($con);
			$updateFolio = mysqli_query($con, "Update xmlNC set folio = $id_xml where id = $id_xml");

			foreach ($xml->xpath('//c:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $concepto) {
				$valor_unitario = $concepto['valorUnitario'];
				$desc_concepto = $concepto['descripcion'];
				$cantidad_concepto = $concepto['cantidad'];
				$importe_concepto = $concepto['importe'];
				$unidad_concepto = $concepto['unidad'];

				$insertaPercepcion = mysqli_query($con, "Insert into conceptosNC values(null, $id_xml, '$valor_unitario', '$desc_concepto', '$cantidad_concepto', '$importe_concepto', '$unidad_concepto')");
			}

			if(!$insertaXML) {
				$res['mens'] = "Error al guardar ".mysqli_error($con);
				echo json_encode($res);
			}
			else {
				// unlink($nombreXML);
				$res['mens'] = "Guardado correctamente";
				$res['id_venta'] = $id_venta;
				echo json_encode($res);
			}
			mysqli_close($con);
		}
	}
?>