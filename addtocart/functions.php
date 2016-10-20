<?
//==============================================================================================
//
//	Filename:	delete_addToCart.php
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
//	Description:	This file is called when the user wants to delete a add-to-cart entry 
//
//	Version:	1.0.0 (April 28th, 2009)
//
//	Change Log:
//				04/28/10 - Initial Version (JMM)
//
//==============================================================================================

//require_once("../../../../../settings.php"); 

		
    // Read atc info based on atc id passed
    if ($_REQUEST['atc'] != "" && $_REQUEST['action'] == "order") {
    
    	
    	$sql="select * from g_addToCart where uid='" . $_REQUEST['atc'] . "'";
    	//echo $sql;
		$gid=mysql_query($sql);
		$grow = mysql_fetch_array($gid);
		
		//update the view count for the add-to-cart item
		$sqlu="update g_addToCart set ClickCount = '" . ($grow['ClickCount'] + 1) . "' where uid='" . $_REQUEST['atc'] . "'";
		$upd=mysql_query($sqlu);
	
		//Loop through the bumps (there has to be at least one) to see what the maxsales is
		// ?????  Should this be the max sales at the currently available price or max sales for all bumps defined?
		$sqlbump="select * from g_addToCartBumps where buttonID='" . $grow['uid'] . "' and status='1' order by Copies";
		$gidbump=mysql_query($sqlbump);
		$todayprice = "";
		while ($growbump = mysql_fetch_array($gidbump)) {
			if ($growbump['Copies'] > $grow['CopiesPurchased']) {
				if ($todayprice == "") {
					$todayprice = $growbump['todaysPrice'];
					
					//update the view count for the bump item
					$sqlu="update g_addToCartBumps set ClickCount = '" . ($growbump['ClickCount'] + 1) . "' where uid='" . $growbump['uid'] . "'";
					$upd=mysql_query($sqlu);
				}

			}
		}
	
		if ($todayprice != "") {
			$sys_item_price = $todayprice;
			$item_price = $todayprice;
			$discount = "~~~" . $_REQUEST['atc'];
			$atc = $_REQUEST['atc'];	
		}
			
		//echo "new sys_item_price: " . $sys_item_price . "<br><br>";
    } else {
    	
    	
    	if ($_REQUEST['action'] == "" && $_REQUEST['atc'] == "" && strpos($_SERVER['REQUEST_URI'],"rap_admin") === false  && strpos($_SERVER['REQUEST_URI'],"reseller") === false) {
	    	// check to see if we are to forward this product somewhere and if so, output it
			$sql = "select * from g_addToCartOptions where OptionName='ForwardActive' and productID='" . $productID . "'";
			$gid=mysql_query($sql);
			$grow = mysql_fetch_array($gid);
	
			if ($grow['Value'] == "1") {
				//forwarding is active, Lookup the address to forward to
				$sql = "select * from g_addToCartOptions where OptionName='ForwardURL' and productID='" . $productID . "'";
				$gid=mysql_query($sql);
				$grow = mysql_fetch_array($gid);
		
				//verify http:// first
				if (substr($grow['Value'],0,7) == "http://" || substr($grow['Value'],0,8) == "https://") {
					header( 'Location: ' . $grow['Value'] );
				}
			}
    	}
    }
    

?>