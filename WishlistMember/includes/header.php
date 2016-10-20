<?
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright 2009, 2010 Genius Idea Studio, LLC,  All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Genius Idea
| Studio, LLC regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.   
|
| ================================================================
| rap-tools.com Google Analytics add-on
| ================================================================
+---------------------------------------------------------------------
*/

session_start();

function Wishlist_Register()
{
	global $productID, $txn_id, $lastname, $firstname, $email, $sys_txn_id; 
	
	// load this products details
	$sql = "select * from wishlistmember_options where productid='" . $productID . "' AND oto<>'1'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		
		$grow=mysql_fetch_array($gid);
		
		$sql = "select * from sales where txn_id='" . $sys_txn_id . "'";
		$sid=mysql_query($sql);
		
		$srow=mysql_fetch_array($sid);
	
		// the post URL
		$postURL = $grow['post_url'];

		// the Secret Key
		$secretKey = $grow['secret_key'];

		// prepare the data
		$data = array ();
		$data['cmd'] = 'CREATE';
		$data['transaction_id'] = $sys_txn_id;
		$data['lastname'] = $srow['lastname'];
		$data['firstname'] = $srow['firstname'];
		$data['email'] = $srow['payer_email'];
		$data['level'] = $grow['SKU'];

		// generate the hash
		$delimiteddata = strtoupper (implode ('|', $data));
		$hash = md5 ($data['cmd'] . '__' . $secretKey . '__' . $delimiteddata);

		// include the hash to the data to be sent
		$data['hash'] = $hash;

		$flhndl = fopen("wishlist.txt", "a");
		fwrite($flhndl, "Wishlist Activation (" . date("m-d-Y H:i:s") . "): \r\n");
		foreach ($data as $rq) {
			fwrite($flhndl, $rq . " \ ");	
		} 
		fwrite($flhndl, "\n\r");
	
		fclose($flhndl);
		
		
		// send data to post URL
		$ch = curl_init ($postURL);
		curl_setopt ($ch, CURLOPT_POST, true);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$returnValue = curl_exec ($ch);

		// process return value
		list ($cmd, $url) = explode ("\n", $returnValue);

		// check if the returned command is the same as what we passed
		if ($cmd == 'CREATE') {
			$flhndl = fopen("wishlist.txt", "a");
			fwrite($flhndl, "Successful creation: " . $returnValue . "\r\n");
			fclose($flhndl);	
			echo $url;
		//echo "#";
		} else {
			$flhndl = fopen("wishlist.txt", "a");
			fwrite($flhndl, "Unsuccessful activation: " . $returnValue . "\r\n");
			fclose($flhndl);	
			echo "#";
		}

		$flhndl = fopen("wishlist.txt", "a");
		fwrite($flhndl, "\r\n\r\nEnd Of Transaction\r\n==================================================\r\n\r\n " );
		fclose($flhndl);
	}

}

function Wishlist_OTO_Register()
{
	global $productID, $sys_txn_id, $lastname, $firstname, $email;
	
	// load this products details
	$sql = "select * from wishlistmember_options where productid='" . $productID . "' AND oto='1'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
	
		$sql = "select * from sales where txn_id='" . $sys_txn_id . "'";
		$sid=mysql_query($sql);
		
		$srow=mysql_fetch_array($sid);
		
		// the post URL
		$postURL = $grow['post_url'];

		// the Secret Key
		$secretKey = $grow['secret_key'];

		// prepare the data
		$data = array ();
		$data['cmd'] = 'CREATE';
		$data['transaction_id'] = $sys_txn_id;
		$data['lastname'] = $lastname;
		$data['firstname'] = $firstname;
		$data['email'] = $srow['payer_email'];
		$data['level'] = $grow['SKU']; 

		// generate the hash
		$delimiteddata = strtoupper (implode ('|', $data));
		$hash = md5 ($data['cmd'] . '__' . $secretKey . '__' . $delimiteddata);

		// include the hash to the data to be sent
		$data['hash'] = $hash;

		$flhndl = fopen("wishlist.txt", "a");
		fwrite($flhndl, "Wishlist Activation (" . date("m-d-Y H:i:s") . "): \r\n");
		foreach ($data as $rq) {
			fwrite($flhndl, $rq . " \ ");	
		} 
		fwrite($flhndl, "\n\r");
	
		fclose($flhndl);
		// send data to post URL
		$ch = curl_init ($postURL);
		curl_setopt ($ch, CURLOPT_POST, true);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$returnValue = curl_exec ($ch);

		// process return value
		list ($cmd, $url) = explode ("\n", $returnValue);

		// check if the returned command is the same as what we passed
		if ($cmd == 'CREATE') {
			echo $url;
			$flhndl = fopen("wishlist.txt", "a");
			fwrite($flhndl, "Successful creation: " . $returnValue . "\r\n");
			fclose($flhndl);
		//echo "#";
		} else {
			echo "#";
			$flhndl = fopen("wishlist.txt", "a");
			fwrite($flhndl, "Unsuccessful activation: " . $returnValue . "\r\n");
			fclose($flhndl);
		} 
		
		$flhndl = fopen("wishlist.txt", "a");
		fwrite($flhndl, "\r\n\r\nEnd Of Transaction\r\n==================================================\r\n\r\n " );
		fclose($flhndl);
	}

}

?>