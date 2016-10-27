<?php
	header('Access-Control-Allow-Origin: *');

	$facturas = isset($_POST['facturas'])?$_POST['facturas']:null;

	$wsURI = "http://sap-ides-tt7.t77secure.biz:50000/sap/bc/srt/wsdl/flv_10002A101AD1/bndg_url/sap/bc/srt/rfc/sap/zwb_rec_fe/001/zws_rec_fe/zws_rec_fe?sap-client=001";

	$header_body = array( 'login' => 'gpaoli', 'password' => 'inicio01');
	$client      = new SoapClient($wsURI, $header_body);
	
	$header      = new SoapHeader("http://www.w3.org/2003/05/soap-envelope", 'Body', $header_body);
	$client->__setSoapHeaders($header);
	

	foreach ($facturas as $key => $value) {
		#Setup input parameters (SAP Likes to Capitalise the parameter names)
		
		$params = array(
			'ItPosRecFe' => array(
				 'Mandt' => '',
	             'Xblnr' => $value['nrofactura'],
	             'Stcd1' => $value['RUC'],
	             'Buzei' => '1',
	             'Wesch' => '1',
	             'Lrmei' => 'UND',
	             'Maktx' => 'Detalle',
	             'Beinhnet' => $value['subtotal'],
			),
	        'IwCabRecFe' => array(
				'Mandt' => '',
	            'Xblnr' => $value['nrofactura'],
	            'Stcd1' => $value['RUC'],
	            'Name1' => $value['proveedor'],
	            'Fkdat' => $value['fecha2'],
	            'Waers' => $value['moneda'],
	            'Rmwwr' => $value['subtotal'],
	            'Mwsbp' => $value['igv'],
	            'Arkuen' => $value['total'],
	            'WtWithcd' => '',
	            'Blart' => '',
	            'HbExp' => '',
			)
		);

	    #Call Operation (Function). Catch and display any errors
	    try
	    {
	       $result = $client->ZmfRecFe($params);
	       
	    }
	    catch (SoapFault $exception)
	    {
	        print "***Caught Exception***\n";
	        print_r($exception);
	        print "***END Exception***\n";
	        die();
	    }
	}

	echo json_encode("ok");
?>