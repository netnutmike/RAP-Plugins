<?
	require_once("../../../../settings.php"); 
	//include('validateSession.php');
	
	if ($ds != "Invalid Session") {
	
		$querytext = "update products Set item_name='" . $_POST['item_name'] . "', item_price='" . $_POST['item_price'] . "', item_pct='" . $_POST['item_pct'] . 
		"', item_pct2='" . $_POST['item_pct2'] . "', two_tier='" . $_POST['two_tier'] . "', jvcode='" . $_POST['jvcode'] . 
		"', jv_item_pct='" . $_POST['jv_item_pct'] . "', a1='" . $_POST['a1'] . "', p1='" . $_POST['p1'] . "', t1='" . 
		$_POST['t1'] . "', a2='" . $_POST['a2'] . "', p2='" . $_POST['p2'] . "', t2='" . $_POST['t2'] . "', a3='" . 
		$_POST['a3'] . "', p3='" . $_POST['p3'] . "', t3='" . $_POST['t3'] . "', signpmt_subscr_url='" . $_POST['signpmt_subscr_url'] . "', cancel_subscr_url='" .
		$_POST['cancel_subscr_url'] . 
		"' where id='" . $_POST['id'] . "'";
					
		$result3 = mysql_query($querytext) or   die(mysql_error());
		
		$querytext = "update g_PaymentPro Set PaymentProcessor='" . $_POST['PaymentProcessor'] . "', paymentType='" . $_POST['PaymentType'] . "', AutoClickbank='" . $_POST['AutoClickbank'] . 
		"', SignupNotify='" . $_POST['SignupNotify'] . "', SignupParameters='" . $_POST['SignupParameters'] . "', CancellationNotify='" . $_POST['CancellationNotify'] . 
		"', CancellationParameters='" . $_POST['CancellationParameters'] . "', PaymentMethod='" . $_POST['PaymentMethod'] . 
		"' where productID='" . $_POST['id'] . "'";
					
		$result3 = mysql_query($querytext) or   die(mysql_error());
	
		//echo $querytext;
		echo '{"success" : true}';
	} else {
		echo '{"success" : false}';
	}

?>