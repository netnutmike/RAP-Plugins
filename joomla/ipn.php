<?php
//==============================================================================================
//
//	Filename:	ipn.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2010(c), Genius Idea Studio, LLC
//
//	Product Is Available For Download From www.rap-tools.com
//
//	Description:	This file is called when someone makes a purchase or requests a refund.  
// 					if a refund is requested, the wishlist subscription is deactivate
//
//	Version:	1.0.0 (February 5th, 2009)
//
//	Change Log:
//				02/05/10 - Initial Version (JMM)
//
//==============================================================================================

include "functions.php";

function Wishlist_Deactivate($txn_id, $productID)
{
	
	// load this products details
	$sql = "select * from wishlistmember_options where productid='" . $productID . "' AND oto<>'1'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
	
		// the post URL
		$postURL = $grow['post_url'];

		// the Secret Key
		$secretKey = $grow['secret_key'];

		// prepare the data
		$data = array ();
		$data['cmd'] = 'DEACTIVATE';
		$data['transaction_id'] = $txn_id;

		// generate the hash
		$delimiteddata = strtoupper (implode ('|', $data));
		$hash = md5 ($data['cmd'] . '__' . $secretKey . '__' . $delimiteddata);

		// include the hash to the data to be sent
		$data['hash'] = $hash;

		// send data to post URL
		$ch = curl_init ($postURL);
		curl_setopt ($ch, CURLOPT_POST, true);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$returnValue = curl_exec ($ch);

		// process return value
		list ($cmd, $url) = explode ("\n", $returnValue);

		// check if the returned command is the same as what we passed
		if ($cmd == 'DEACTIVATE') 
			return true;
		else 
			return false;
		
	}

}

function gIPN()
{
	global $payment_status, $parent_txn;
	global $productID;
	
	
	if ($payment_status == "Refunded") {
		Wishlist_Deactivate($parent_txn, $productID);
	}
}

gIPN();
?>

