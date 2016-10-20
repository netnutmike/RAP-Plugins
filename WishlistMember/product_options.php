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

<script language="JavaScript">

function aSave() {

	var posturl 	=	jQuery("#PostURL").val();
	var secretkey 	=	jQuery("#SecretKey").val();
	var sku 	=	jQuery("#SKU").val();
	var prodid 	=	jQuery("#prodid").val();
	jQuery.post("addons/GIS/WishlistMember/product_options.php", { PostURL: posturl, productID: prodid, SKU: sku, SecretKey: secretkey },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

</script>

<? if ($_POST['PostURL'] != "" ) {

	//check to see if record exists first, if not insert it and if so update it
	$sql = "select * from wishlistmember_options where productid='" . $productID . "' AND oto<>'1'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$sql = "Update wishlistmember_options set post_url='". $_POST['PostURL'] . "', secret_key='" . $_POST['SecretKey'] . "', SKU='" . $_POST['SKU'] . "' where productid='" . $productID . "' and oto<>'1'";
		$gid=mysql_query($sql);
	} else {
		$sql = "insert into wishlistmember_options (post_url, productid, secret_key, SKU, oto) values ('" . $_POST['PostURL'] . "', '" . $productID . "', '" . $_POST['SecretKey'] . "', '" . $_POST['SKU'] . "', '0')";
		$gid=mysql_query($sql);
	}
	
	$errormessage = "";
	if ($_POST['PostURL'] == "" || $_POST['SecretKey'] == "" || $_POST['SKU'] == "")
	{
		$errormessage = "For Wishlist Member add-on to work you must fill out all 3 fields.";
	}
	echo "<script language=\"JavaScript\"> 
	var message =	\"Your Product Options for Wishlist Member Have Been Saved!\";
	var errormessage =	\"" . $errormessage . "\";
	var prodid = \"" . $productID . "\"
	jQuery.post(\"addons/GIS/WishlistMember/product_options.php\", { message: message, productID: prodid, errormessage: errormessage }, 
					function(data){ 
						jQuery('#pr-opt-disp').html(data); 
				  	} 
				); 
		</script>";
} else { 

	//If an error message was passed in then display the error message in a red box.
	if ($_POST['errormessage'] != "") { ?>
		<div class="rounded-box-red" id="error-box">
    	    <div class="box-contents"><strong>Uh Oh!!</strong></font><img src="/rap_admin/addons/GIS/themes/images/warning48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		<? echo $_POST['errormessage']; ?>
        		</i><br>&nbsp;
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#error-box').effect("pulsate", { times:6 }, 1000);
			jQuery('#error-box').fadeOut(10000);
		</script>
<?	}

	//If a message was passed in display the message in a green box.
	if ($_POST['message'] != "") { ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
       <strong>Good News!!</strong></font><img src="/rap_admin/addons/GIS/themes/images/info48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		<? echo $_POST['message']; ?>
        		</i><br>&nbsp;
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
		 	
			jQuery('#message-box').fadeOut(10000);

		</script>
<?	} ?>




<table>
<tr><td>
 <?php 
 	$sql = "select * from wishlistmember_options where productid='" . $productID . "' AND oto<>'1'";
 	//echo $sql . "<br>";
	$gid=mysql_query($sql);
	$grow=mysql_fetch_array($gid);?>
	<table>
   <tr><td><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Post URL:</font></td><td> <input type="text" name="PostURL" id="PostURL" value="<?php echo $grow['post_url']; ?>"></td></tr>
   <tr><td><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Secret Word:</font></td><td> <input type="text" name="SecretKey" id="SecretKey" value="<?php echo $grow['secret_key']; ?>"> </td></tr>
   <tr><td><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">SKU:</font></td><td> <input type="text" name="SKU" id="SKU" value="<?php echo $grow['SKU']; ?>"> </td></tr>
   </table>
   <input type="hidden" name="prodid" id="prodid" value="<?php echo $productID; ?>"></form>
  </td></tr>
  <tr><td>
  
 

<Table align="left"><tr valign="middle"><td valign="middle">
<input type="image" name="submit" src="/rap_admin/addons/GIS/WishlistMember/images/save.png" value="Save" onClick="javascript:aSave();"/> 
</td><td valign="middle">
<font style="font-size: 14px;"><b>Save</b></font>
</td></tr></table>
</td></tr><tr><td colspan="2"><div class="rounded-box">
    <!-- Content -->
    <div class="box-contents">
        Here is how to get the information for the fields above:<br>
        1) Login to the wordpress admin for your Wishlist Membership site.<br>
        2) Go to the WishList Member Section and click on the Integration Tab at the Top.<br>
        3) After you are in the Integration tab, be sure you are on the Shopping Cart and not AutoResponder integration section.<br>
        4) Select "Generic System" in the "Select System" Dropdown box.<br>
        5) After you select Generic System you will see a section titled Post URL.  Highlight and copy this URL into the Post URL field above.<br>
        6) Look for the Secret Word Section, highlight and copy the text in the secret word field and paste it into the Secret Word Field Above.<br>
        7) Now you need to find in the list of Membership Level SKU's the membership level that is associated with this product.  To the right of the membership level is a number called a sku.  Highlight the sku for the membership level for this product, copy it and then paste it into the SKU field above.<br>
        8) That completes the setup for this product.  You need to add the proper tag to the download page so that the purchaser is transfered and added to the Wishlist Member System.
    </div> <!-- end div.box-contents -->
</div></td></tr></table>

<? } ?>