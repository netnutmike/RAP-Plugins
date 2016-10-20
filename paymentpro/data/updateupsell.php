<?
	require_once("../../../../settings.php"); 
	//include('validateSession.php');
	
	if ($ds != "Invalid Session") {
	
		$querytext = "update g_PaymentProUpsells Set Name='" . $_POST['Name'] . "', Description='" . $_POST['Description'] . "', Status='" . $_POST['Status'] . 
		"', Price='" . $_POST['Price'] . "', AttachedProduct='" . $_POST['AttachedProduct'] . "', AttachedAction='" . $_POST['AttachedAction'] . 
		"', Amount='" . $_POST['Amount'] . "' where uid='" . $_POST['uid'] . "'";
					
		$result3 = mysql_query($querytext) or   die(mysql_error());
	
		//echo $querytext;
		echo '{"success" : true}';
	} else {
		echo '{"success" : false}';
	}

?>