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
//	Description:	This file is placed in the header of all files
//
//	Version:	1.0.0 (April 28th, 2009)
//
//	Change Log:
//				04/28/10 - Initial Version (JMM)
//
//==============================================================================================

//==============================================================================================
//
// == How many ways can we be called? ==
//
//  1. Not a clickbank product so it follows the same old RAP way
//  2. Product is setup as optional and a regular person comes in and goes through the same old
//     RAP way.
//  3. Product is setup as optional but has a cb= tag from an affiliate.  Setup the transaction
//     as a clickbank transaction
//  4. Product is setup as optional or dedicated and the traffic was referred from clickbank, 
//     Setup the transaction as a clickbank transaction
//  5. Product is setup as a dedicated clickbank product, if there is a cb= forward to the
//     clickbank hoplink for the affiliate.  Should be returned as #4
//  6. Product is setup as a dedicated clickbank product and there is no cb= then just show the
//     sales page but process the payment as a clickbank payment.
//
//
//==============================================================================================
//require_once("../../../../../settings.php"); 

    // Read atc info based on atc id passed
    if ($_REQUEST['cb'] != "") {
    
    	
    	$sql="select * from g_Clickbank where productID='" . $productID . "'";
    	//echo $sql;
		$gid=mysql_query($sql);
		$grow = mysql_fetch_array($gid);
	
		if ($grow['status'] == '1' || $grow['status'] == '2')
		{
			header( 'Location: http://' . $_REQUEST['cb'] . "/" . $grow['hopLink'] );
		}
			
//		echo "new sys_item_price: " . $sys_item_price . "<br><br>";
    } else {
    	$sql="select * from g_Clickbank where productID='" . $productID . "'";
    	//echo $sql;
		$gid=mysql_query($sql);
		if (mysql_num_rows($gid)) {
			$grow = mysql_fetch_array($gid);
		
    		if ($grow['status'] == '3') {
    			header( 'Location: http://' . $_REQUEST['cb'] . "/" . $grow['hopLink'] );
    		}
		}
		
    }
    
?>