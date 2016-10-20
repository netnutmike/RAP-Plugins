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
//	Description:	This file is called to display the global options and to save the global 
// 					options. 
//
//	Version:	1.0.0 (December 23rd, 2009)
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

	var gid 	=	jQuery("#pgid").val();
	var prodid 	=	jQuery("#prodid").val();
	var Goals 	=	jQuery("#pGoals:checked").val();
	var eCommerce = jQuery("#eCommerce:checked").val();
	jQuery.post("addons/GIS/ganalytics/product_options.php", { gid: gid, productID: prodid, Goals: Goals, eCommerce: eCommerce },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aDelete() {

	var gid 	=	"DELETE";
	var prodid 	=	jQuery("#prodid").val();
	jQuery.post("addons/GIS/ganalytics/product_options.php", { gid: gid, productID: prodid },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

</script>

<? if ($_POST['gid'] != "" ) {
	echo "productid: " . $productID . "<br>";
	if ($_POST['gid'] == "DELETE") {
		$sql = "delete from ganalytics_options where productid='" . $productID . "'";
		$gid=mysql_query($sql);
		
		echo "<script language=\"JavaScript\"> 
	var message =	\"You Product Options Have Been Removed!\";
	var prodid = \"" . $productID . "\"
	jQuery.post(\"addons/GIS/ganalytics/product_options.php\", { message: message, productID: prodid }, 
					function(data){ 
						jQuery('#pr-opt-disp').html(data); 
				  	} 
				); 
		</script>";
	} else {
		//check to see if record exists first, if not insert it and if so update it
		$sql = "select * from ganalytics_options where productid='" . $productID . "'";
		$gid=mysql_query($sql);
		$optionstr = $_POST['Goals'] . $_POST['eCommerce'];

		if (mysql_num_rows($gid) > 0) {
			$sql = "Update ganalytics_options set gid='". $_POST['gid'] . "', Options='" . $optionstr . "' where productid='" . $productID . "'";
			echo $sql . "<br>";
			$gid=mysql_query($sql);
		} else {
			$sql = "insert into ganalytics_options (gid, productid, Options) values ('" . $_POST['gid'] . "', '" . $productID . "', '" . $optionstr . "')";
			$gid=mysql_query($sql);
		}
	
		echo "<script language=\"JavaScript\"> 
	var message =	\"You Product Options Have Been Saved!\";
	var prodid = \"" . $productID . "\"
	jQuery.post(\"addons/GIS/ganalytics/product_options.php\", { message: message, productID: " . $productID . " }, 
					function(data){ 
						jQuery('#pr-opt-disp').html(data); 
				  	} 
				); 
		</script>";
	}
} else { 

	//If a message was passed in display the message in a green box.
	if ($_POST['message'] != "") { ?>
		<div class="rounded-box-green" id="pmessage-box">
    	    <div class="box-contents">
        <? echo $_POST['message']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#pmessage-box').fadeOut(10000);

		</script>
<?	} ?>

<br><br>
<div class="rounded-box">
    <!-- Content -->
    <div class="box-contents">
        Product options are optional.  If you leave the Google ID for the product blank, the global Google ID will be used.  The product option is available for you if you have multiple Google Analytics IDs for your products.
    </div> <!-- end div.box-contents -->
</div>
<br>

<form id="copyfile" name="copyfile" method="post" action="addons/GIS/ganalytics/product_options.php">
<table>
<tr><td>
 <?php 
 	$sql = "select * from ganalytics_options where productid='" . $productID . "'";
	$gid=mysql_query($sql);
	$grow=mysql_fetch_array($gid);?>
   <font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Google ID:</font> <input type="text" name="pgid" id="pgid" value="<?php echo $grow['gid']; ?>"> <font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">(example: UA-11223344-1)</font>
  <input type="hidden" name="prodid" id="prodid" value="<?php echo $productID; ?>">
  </td></tr><tr><td>&nbsp;</td></tr>
    <tr><td>
  	<ul class="checklist">
		<li>
			<input id="pGoals" name="pGoals" value="1" type="checkbox" <? if (substr($grow['Options'],0,1) == '1') { echo "checked"; } ?>>
       		<label for="pGoals">Goal Tracking Enabled</label>
       		<a class="checkbox-select" href="#">Select</a>
       		<a class="checkbox-deselect" href="#">Cancel</a>
       	</li>
	</ul>
  </td></tr>
  <tr><td>
  	<ul class="checklist">
		<li>
			<input id="eCommerce" name="eCommerce" value="1" type="checkbox" <? if (substr($grow['Options'],1,1) == '1') { echo "checked"; } ?>>
       		<label for="eCommerce">E-commerce Tracking Enabled</label>
       		<a class="checkbox-select" href="#">Select</a>
       		<a class="checkbox-deselect" href="#">Cancel</a>
       	</li>
	</ul>
  </td></tr>
  <tr><td>
  
 
</form>
<Table><tr><td>
<input type="button" name="submit" id="submit" value="Save" onClick="javascript:aSave();"/>
<input type="button" name="submit" id="cancel" value="Remove" onClick="javascript:aDelete();"/>
</td><td>

</td></tr></table>
</td></tr></table>

<? } ?>

<script>
/* see if anything is previously checked and reflect that in the view*/
jQuery(".checklist input:checked").parent().addClass("selected");

/* handle the user selections */
jQuery(".checklist .checkbox-select").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().addClass("selected");
        jQuery(this).parent().find(":checkbox").attr("checked","checked");
    }
);

jQuery(".checklist .checkbox-deselect").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().removeClass("selected");
        jQuery(this).parent().find(":checkbox").removeAttr("checked");
    }
    
);
</script>