<?
	require_once("../../../../settings.php"); 
	//include('validateSession.php');
	
	if ($ds != "Invalid Session") {
	
		$querytext = "insert into g_PaymentProUpsells (productID, Name, Description, Status, Price, AttachedProduct, AttachedAction, Amount) VALUES ('" . 
		$_POST['ProductID'] . "', '" . $_POST['Name'] . "', '" . $_POST['Description'] . "', '1', '" . $_POST['Price'] . "', '" . $_POST['AttachedProduct'] . "', '" .  
		$_POST['AttachedAction'] . "', '" . $_POST['Amount'] . "')";
					
		$result3 = mysql_query($querytext) or   die(mysql_error());
	
		//echo $querytext;
		echo '{"success" : true}';
	} else {
		echo '{"success" : false}';
	}

?>