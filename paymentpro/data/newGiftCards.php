<?
	require_once("../../../../settings.php"); 
	//include('validateSession.php');
	
	function generateRandomID($length = "9") {
		$sendback = "";
		for ($l=0; $l < $length; ++$l)
			$sendback .= rand(0,9);
		
		return $sendback;
	}
	
	
	function getNewID() {
		do {
			$newid = generateRandomID();
			
			$querytext = "select * from g_PaymentProGifts where giftID='" . $newid . "'";		
			$result = mysql_query($querytext) or   die(mysql_error());
		} while (mysql_num_rows($result));
		
		return $newid;
	}
	
	
	if ($ds != "Invalid Session") {
	
		for ($l=0; $l < ($_POST['Count']+0); ++$l){

			$querytext = "insert into g_PaymentProGifts (giftID, dateCreated, Status, Balance, initialBalance) VALUES ('" . 
			getNewID() . "', '" . date("Y-m-d H:i:s") . "', '1', '" . $_POST['Balance'] . "', '" . $_POST['Balance'] . "')";
						
			$result3 = mysql_query($querytext) or   die(mysql_error());
		}
	
		//echo $querytext;
		echo '{"success" : true}';
	} else {
		echo '{"success" : false}';
	}

?>