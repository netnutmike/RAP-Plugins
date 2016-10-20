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

require_once("../../../settings.php"); 

?>

<script language="JavaScript">

function aDeleteCancel() {

	jQuery('#atc-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/addtocart/atc_options.php", { atcid: "<?= $_REQUEST['pid'];?>", productID: "<?= $_REQUEST['productID']; ?>" },
			function(data){
				jQuery('#atc-opt-disp').html(data);
		  	}
		);
}

function aDeleteDelete(uid) {

	jQuery('#atc-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/addtocart/atc_options.php", { uid: uid, action: "Delete", atcid: "<?= $_REQUEST['atcid'];?>", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-opt-disp').html(data);
				  	}
				);
}

</script>

<?
	$sql="select * from g_addToCartBumps where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
?>
<br><br>
<p class="georgia-medium">You are about to delete an Add-To-Cart Bump entry <strong>$<?= $grow['todaysPrice']?></strong> at <strong><?= $grow['Copies']?></strong> Copies.</p>

<br><p class="georgia-medium">If you are sure you want to continue to delete this Add-To-Cart Bump entry, click the <strong>Yes, I Am Sure</strong> button below.</p><br><br> 
<table>
  <tr><td>
  
  <table><tr><td>
<input type="button" name="submit" id="submit" value="Don't Do It" onClick="javascript:aDeleteCancel();"/>
</td><td>
<input type="button" name="cancel" id="cancel" value="Yes, I Am Sure, Delete" onClick="javascript:aDeleteDelete('<?= $_REQUEST['uid']; ?>');" />
</td></tr></table>
</td></tr></table>

