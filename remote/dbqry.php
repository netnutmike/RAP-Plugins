<?php

require_once("../../../settings.php");



function getStockQuote($symbol) {

    return 25;
}

//function decrypt($string, $key) {
//    $dec = "";
//    $string = trim(base64_decode($string));
//    $iv = mcrypt_create_iv (mcrypt_get_block_size (MCRYPT_TripleDES, MCRYPT_MODE_CBC), MCRYPT_DEV_RANDOM);
//    $dec = mcrypt_cbc (MCRYPT_TripleDES, $key, $string, MCRYPT_DECRYPT, $iv);
//  return $dec;
//}

function dbqry($sql) {
//	$key="XiTo74dOO09N48YeUmuvbL0E";
	
//	$nsql = decrypt($sql, $key);
	$xmloutput = "";
	$xmloutput .= "<?xml version=\"1.0\"?>\n";
	$xmloutput .= "<results>\n"; 
	
	$result=mysql_query($sql);
	$numfields = mysql_num_fields($result);

	for ($i=0; $i < $numfields; $i++) 
		$g_fldname[$i] = mysql_field_name($result, $i); 

	while ($row = mysql_fetch_row($result)) // Data
		{ 
		$xmloutput .= "<Record>";
		for ($i=0; $i < $numfields; $i++) 
			$xmloutput .= "<". $g_fldname[$i] . ">" . $row[$i] . "</" . $g_fldname[$i] . ">";
		$xmloutput .= "</Record>"; 
		}
		
	$xmloutput .= "</results>";
	
	$outputlog = fopen("xmllog.txt", 'a');
	fwrite ($outputlog, $sql . "\r\n");
	fclose($outputlog);
	
    return $xmloutput;
}

require('lib/nusoap.php');

$server = new soap_server();

$server->configureWSDL('stockserver', 'urn:stockquote');

$server->register("getStockQuote",
                array('symbol' => 'xsd:string'),
                array('return' => 'xsd:decimal'),
                'urn:stockquote',
                'urn:stockquote#getStockQuote');
                
                $server->register("dbqry",
                array('sql' => 'xsd:string'),
                array('return' => 'xsd:string'),
                'urn:dbqry',
                'urn:dbqry#dbqry');

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)
                      ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>