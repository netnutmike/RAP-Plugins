<?
//==============================================================================================
//
//	Filename:	product_options.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2009(c), Genius Idea Studio, LLC
//
//	Product Is Available For Download From www.rap-tools.com
//
//	Description:	This file is called to display the product options and to save the product 
// 					options. 
//
//	Version:	1.0.0 (December 29rd, 2009)
//
//	Change Log:
//				12/29/09 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php");
$productID = $_POST['productID'];
//echo "Product ID:" . $productID;
?>


<table>
<tr><td><font size="3" color="gray" face=tahoma style="letter-spacing: -1px;">The Wishlist Member addon can easily be integrated with the Paypal Subscription Addon from rap-extras.  To integrate the Wishlist Member addon with the Paypal Subscription, you simply copy the values in the 2 fields below into the Extra Options Red area for Cancellation Notofication Parameters.</font><br><br>
   <table>
   <tr><td><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Base URL:</font></td><td> <input type="text" name="PostURL" id="PostURL" value="<?php echo $_SERVER[SERVER_NAME]; ?>"></td></tr>
   <tr><td><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Path to the file:</font></td><td> <input type="text" name="SecretKey" id="SecretKey" value="/rap_admin/addons/GIS/WishlistMember/integration.php"> </td></tr>
   </table>
  </td></tr>
  <tr><td>
  
</td></tr></table>

<? //} ?>