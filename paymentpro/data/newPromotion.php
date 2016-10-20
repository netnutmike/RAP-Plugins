<?
	require_once("../../../../settings.php"); 
	//include('validateSession.php');
	
	if ($ds != "Invalid Session") {
	
		$querytext = "insert into g_PaymentProPromoCodes (promoCode, promoDescription, productID, Status, maxCount, Price) VALUES ('" . 
		$_POST['promoCode'] . "', '" . $_POST['promoDescription'] . "', '" . $_POST['productID'] . "', '1', '" . $_POST['maxCount'] . "', '" .  
		$_POST['Price'] . "')";
					
		$result3 = mysql_query($querytext) or   die(mysql_error());
	
		//echo $querytext;
		echo '{"success" : true}';
	} else {
		echo '{"success" : false}';
	}

?>