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

function aSaveOTO() {

	var posturl 	=	jQuery("#PostURLO").val();
	var secretkey 	=	jQuery("#SecretKeyO").val();
	var sku 	=	jQuery("#SKUO").val();
	var prodid 	=	jQuery("#prodid").val();
	jQuery('#ot-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/joomla/oto_options.php", { PostURL: posturl, productID: prodid, SKU: sku, SecretKey: secretkey },
					function(data){
						jQuery('#ot-opt-disp').html(data);
				  	}
				);
}

</script>

<? if ($_POST['PostURL'] != "" ) {

	//check to see if record exists first, if not insert it and if so update it
	$sql = "select * from g_joomlaOptions where productid='" . $productID . "' AND oto='1'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$sql = "Update g_joomlaOptions set post_url='". $_POST['PostURL'] . "', secret_key='" . $_POST['SecretKey'] . "', SKU='" . $_POST['SKU'] . "' where productid='" . $productID . "' and oto='1'";
		$gid=mysql_query($sql);
	} else {
		$sql = "insert into g_joomlaOptions (post_url, productid, secret_key, SKU, oto) values ('" . $_POST['PostURL'] . "', '" . $productID . "', '" . $_POST['SecretKey'] . "', '" . $_POST['SKU'] . "', '1')";
		$gid=mysql_query($sql);
	}
	
	$errormessage = "";
	if ($_POST['PostURL'] == "" || $_POST['SecretKey'] == "" || $_POST['SKU'] == "")
	{
		$errormessage = "For the Joomla add-on to work you must fill out both fields.";
	}
	echo "<script language=\"JavaScript\"> 
	var message =	\"Your OTO Options for Joomla Have Been Saved!\";
	var errormessage =	\"" . $errormessage . "\";
	var prodid = \"" . $productID . "\"
	jQuery.post(\"addons/GIS/joomla/oto_options.php\", { message: message, productID: prodid, errormessage: errormessage }, 
					function(data){ 
						jQuery('#ot-opt-disp').html(data); 
				  	} 
				); 
		</script>";
} else { 

	//If an error message was passed in then display the error message in a red box.
	if ($_POST['errormessage'] != "") { ?>
		<div class="rounded-box-red" id="error-box">
    	    <div class="box-contents"><strong>Uh Oh!!</strong></font><img src="/rap_admin/addons/GIS/joomla/images/warning48x48.png" align="right">
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
    	    <strong>Good News!!</strong></font><img src="/rap_admin/addons/GIS/joomla/images/info48x48.png" align="right">
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
 	$sql = "select * from g_joomlaOptions where productid='" . $productID . "' AND oto='1'";
	$gid=mysql_query($sql);
	$grow=mysql_fetch_array($gid);?>
	<table>
   <tr><td><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Post URL:</font></td><td> <input type="text" name="PostURLO" id="PostURLO" value="<?php echo $grow['post_url']; ?>"></td></tr>
   <tr><td><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Secret Word:</font></td><td> <input type="text" name="SecretKeyO" id="SecretKeyO" value="<?php echo $grow['secret_key']; ?>"> </td></tr>
   
   </table>
   <input type="hidden" name="prodid" id="prodid" value="<?php echo $productID; ?>"></form>
  </td></tr>
  <tr><td>
  
 

<Table align="left"><tr valign="middle"><td valign="middle">
<input type="image" name="submit" src="/rap_admin/addons/GIS/joomla/images/save.png" value="Save" onClick="javascript:aSaveOTO();"/> 
</td><td valign="middle">
<font style="font-size: 14px;"><b>Save</b></font>
</td></tr></table>
</td></tr><tr><td colspan="2"><div class="rounded-box">
    <!-- Content -->
    <div class="box-contents">
        Here is how to get the information for the fields above:<br>
        1) Login to the Joomla admin for your Joomla site.<br>
        
    </div> <!-- end div.box-contents -->
</div></td></tr></table>

<? } ?>