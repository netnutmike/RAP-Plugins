<?	
	function g_debuglog($debugtxt)
	{
		$flhndl = fopen("g_ipndebug.txt", "a");
		fwrite($flhndl, $debugtxt);
		fwrite($flhndl, "\r\n");
		fclose($flhndl);
	}
	
	//g_debuglog("in here");
	//g_debuglog("pre sys_item_price:" . $sys_item_price);
	//g_debuglog("customfield[4]" . $customfield[4]);
	//g_debuglog("customfield[5]" . $customfield[5]);
	if($customfield[9]==$sys_domain)
		$gDiscount=$customfield[5];
	else 
		$gDiscount=$customfield[4];

	//g_debuglog("discount code: " . $gDiscount );
	if (substr($gDiscount,0,3) == "~~~") {
		// Must be a discount code from addtocart

		$AddToCartID = substr($gDiscount,3);
		$sql = "select * from g_addToCart where uid='" . $AddToCartID . "'";
		$gid=mysql_query($sql);
		if (mysql_num_rows($gid) > 0) {
		
			$grow = mysql_fetch_array($gid);
			//lookup the lowest price for the button and set system price to that so it passed fraud check
			$sql = "select * from g_addToCartBumps where buttonID='" . $grow[uid] . "' ORDER BY todaysPrice LIMIT 1";
			//g_debuglog( $sql );
			$gid=mysql_query($sql);
			if (mysql_num_rows($gid) > 0) {
				$grow = mysql_fetch_array($gid);
				$sys_item_price = $grow['todaysPrice'];
			}
		}
	}
	
	//g_debuglog("sys_item_price:" . $sys_item_price);
	
?>