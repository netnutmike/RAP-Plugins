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
    if ($_REQUEST['atc'] != "") {
    
    	
    	$sql="select * from g_addToCart where uid='" . $_REQUEST['atc'] . "'";
    	//echo $sql;
		$gid=mysql_query($sql);
		$grow = mysql_fetch_array($gid);
	
		//Loop through the bumps (there has to be at least one) to see what the maxsales is
		// ?????  Should this be the max sales at the currently available price or max sales for all bumps defined?
		$sqlbump="select * from g_addToCartBumps where buttonID='" . $grow['uid'] . "' and status='1' order by Copies";
		$gidbump=mysql_query($sqlbump);
		$todayprice = "";
		while ($growbump = mysql_fetch_array($gidbump)) {
			if ($growbump['Copies'] > $grow['CopiesPurchased']) {
				if ($todayprice == "") 
					$todayprice = $growbump['todaysPrice'];

			}
		}
	
		if ($todayprice != "") {
			$sys_item_price = $todayprice;
			$item_price = $todayprice;
		}
			
//		echo "new sys_item_price: " . $sys_item_price . "<br><br>";
    }
?>