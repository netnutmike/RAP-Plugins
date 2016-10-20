<?



function g_addToCartIPN()
{
	global $payment_status, $parent_txn, $gDiscount;
	global $productID;
	
	if (substr($gDiscount,0,3) == "~~~") {
		// Must be a discount code from addtocart
		
		$AddToCartID = substr($gDiscount,3);
		$sql = "select * from g_addToCart where uid='" . $AddToCartID . "'";
		$gid=mysql_query($sql);
		if (mysql_num_rows($gid) > 0) {
			//Just simply increase the sale count
			$grow=mysql_fetch_array($gid);
			
			$sql = "update g_addToCart set CopiesPurchased='" . ($grow['CopiesPurchased'] + 1) . "' where uid='" . $AddToCartID . "'";
			$gid=mysql_query($sql);
		}
	}
	
	
}

g_addToCartIPN();


?>