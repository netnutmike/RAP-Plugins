<?php

function GetActivePaymentLink()
{
	global $sys_testmode, $sys_locale, $sys_currency, $sys_cancel_url, $sys_pp_return, $sys_item_pct, $sys_two_tier, $sys_item_pct2;
	global $g_PP_AP_Username, $g_PP_AP_Pass, $g_PP_AP_Signature, $g_PP_AP_Adaptive_chained;
	
	//set destination based on product test setting
	if ($sys_testmode == "1")
		$url = trim("https://svcs.sandbox.paypal.com/AdaptivePayments/Pay");		//set PayPal Endpoint to sandbox
	else
		$url = trim("https://svcs.sandbox.paypal.com/AdaptivePayments/Pay");		//set PayPal Endpoint to production
	
	//PayPal API Credentials
	$API_UserName = $g_PP_AP_Username; 
	$API_Password = $g_PP_AP_Pass; 
	$API_Signature = $g_PP_AP_Signature; 
		
	//Default App ID for Sandbox	
	$API_AppID = "APP-80W284485P519543T";
	
	$API_RequestFormat = "NV";
	$API_ResponseFormat = "NV";
	
	
	//Create request payload with minimum required parameters
	$bodyparams = array (	"requestEnvelope.errorLanguage" => $sys_locale,
												"actionType" => "PAY",
												"currencyCode" => $sys_currency,
												"cancelUrl" => $sys_cancel_url,
												"returnUrl" => $sys_pp_return
												);
												
	//setup everyone that is to get paid and setup the payment array
	$pec = 100;
	$paynum=0;
	
	if (isset($_COOKIE['aff'])) {
		$bodyparams("receiverList.receiver(0).email") = "r_3_1266352587_biz@paypal.com";				//TODO
		$bodyparams("receiverList.receiver(0).amount") = $sys_item_pct;
		if ($g_PP_AP_Adaptive_chained)
			$bodyparams("receiverList.receiver(0).primary") = "false";
			
		$pec -= $sys_item_pct;
		++$paynum;
		
		if ($sys_two_tier) {
			$sql="SELECT * FROM nicknames WHERE email='".$affiliate."'";
			$request = mysql_query($sql);
			$rs = mysql_fetch_array($request);
			
			if ($rs['sponsor'] != "") {
				$bodyparams("receiverList.receiver(" . $paynum . ").email") = "r_3_1266352587_biz@paypal.com";		//TODO
				$bodyparams("receiverList.receiver(" . $paynum . ").amount") = $sys_item_pct2;
				if ($g_PP_AP_Adaptive_chained)
					$bodyparams("receiverList.receiver(" . $paynum . ").primary") = "false";
					
				$pec -= $sys_item_pct2;
				++$paynum;
			}
			
		}
	}
	
	//pay the equity partners now
	$sql = "SELECT * FROM equity
			WHERE productID = $product";
	
	//fianlly pay the admin
	
	
	
	$bodyparams("receiverList.receiver(" . $paynum . ").email") = "r_2_1266352427_biz@paypal.com"; //TODO
	$bodyparams("receiverList.receiver(" . $paynum . ").amount") = $pec; //TODO
	if ($g_PP_AP_Adaptive_chained)
		$bodyparams("receiverList.receiver(" . $paynum . ").primary") = "true";
	
												
	// convert payload array into url encoded query string
	$body_data = http_build_query($bodyparams, "", chr(38));
	
    //create request and add headers
    $params = array("http" => array( 
									 "method" => 	"POST",
  									 "content" => 	$body_data,
  									 "header" =>  	"X-PAYPAL-SECURITY-USERID: " . $API_UserName . "\r\n" .
               										"X-PAYPAL-SECURITY-SIGNATURE: " . $API_Signature . "\r\n" .
 							 						"X-PAYPAL-SECURITY-PASSWORD: " . $API_Password . "\r\n" .
   						 							"X-PAYPAL-APPLICATION-ID: " . $API_AppID . "\r\n" .
   						 							"X-PAYPAL-REQUEST-DATA-FORMAT: " . $API_RequestFormat . "\r\n" .
  						 							"X-PAYPAL-RESPONSE-DATA-FORMAT: " . $API_ResponseFormat . "\r\n" 
  										));


    //create stream context
     $ctx = stream_context_create($params);
    

    //open the stream and send request
     $fp = @fopen($url, "r", false, $ctx);

    //get response
  	 $response = stream_get_contents($fp);

  	//check to see if stream is open
     if ($response === false) {
        return false;
     }
           
    //close the stream
     fclose($fp);

    //parse the ap key from the response
    $keyArray = explode("&", $response);
        
    foreach ($keyArray as $rVal){
    	list($qKey, $qVal) = explode ("=", $rVal);
			$kArray[$qKey] = $qVal;
    }
       
    //set url to approve the transaction
    $payPalURL = "https://www.sandbox.paypal.com/webscr?cmd=_ap-payment&paykey=" . $kArray["payKey"];

    if ( $kArray["responseEnvelope.ack"] == "Success") 
    	return $payPalURL;
    else 
		return false;

  }
?>