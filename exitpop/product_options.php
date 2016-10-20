<?php 

//==============================================================================================
//
//	Filename:	product_options.php
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
//	Description:	This file is called to provide a file description from the database. 
//
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				02/17/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); 

if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_Clickbank set orderLink='" . $_POST['orderLink'] . "', status='" . $_POST['status'] . "' where productID='" . $_POST['productID'] . "' AND entryType='1'";
	$gid=mysql_query($sql);
	
	if ($_POST['status'] == '1')
		$sql = "UPDATE products set item_orderbutton='clickbankaccept.php' where id='" . $_POST['productID'] . "'";
	else
		$sql = "UPDATE products set item_orderbutton='paypalwebaccept.php' where id='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/clickbank/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Clickbank Entry Updated!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} ?>

<script language="JavaScript">

function aSaveatc() {

	var orderLink =	jQuery("#orderLink").val();
	var status =	jQuery("#status:checked").val();

	jQuery('#pr-opt-disp').html(loadingimage);
	
	jQuery.post("addons/GIS/clickbank/product_options.php", { orderLink: orderLink, status: status, action: "Update", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

</script>

<?
	$sql="select * from g_Clickbank where productID='" . $_POST['productID'] . "' AND entryType='1'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) == 0) {
		$sql="insert into g_Clickbank (ProductID, entryType, status) VALUES ('" . $_POST['productID'] . "', '1', '0')";
		$gid=mysql_query($sql);
		$sql="select * from g_Clickbank where productID='" . $_POST['productID'] . "' AND entryType='1'";
		$gid=mysql_query($sql);
	}
	$grow = mysql_fetch_array($gid);
?>
<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Edit Clickbank Setup For Front End Product</p>";
		
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts">

 	<input type="image" src="/rap_admin/addons/GIS/clickbank/images/save.png" name="submit" value="Save" onClick="javascript:aSaveatc();"/><br>&nbsp;&nbsp;Save
 	</td><td></td><td align="right" class="Prompts"></td></tr>
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table>
 	<tr><td class="Prompts" >Clickbank Order URL:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="orderLink" id="orderLink" size="35" value="<?= $grow['orderLink'];?>"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td colspan="4">
 		<ul class="checklist">
						<li>
							<input id="status" name="status" value="1" type="checkbox" <? if ($grow['status'] == '1' ) { echo "checked"; } ?>>
                    		<label for="status">Active Clickbank Product</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
 		</td></tr>
 		<tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td colspan="3">
  
 

</td></tr></table>
<div class='gis-content padding-rl-20' id="atc-opt-disp"></div>

<script type='text/javascript'>


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