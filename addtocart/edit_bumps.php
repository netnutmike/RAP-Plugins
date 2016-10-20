<?
//==============================================================================================
//
//	Filename:	add_testimonial.php
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
//	Description:	This file is called when the user wants to copy a file. 
//
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				02/17/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); 

?>

<script language="JavaScript">

function aSaveCancelatc() {

	jQuery('#atc-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/addtocart/atc_options.php", { atcid: "<?= $_REQUEST['atcid'];?>", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-opt-disp').html(data);
				  	}
				);
}

function aSaveatc(uid) {

	var Copies =	jQuery("#Copies").val();
	var todaysPrice =	jQuery("#todaysPrice").val();
	var status =	jQuery("#status:checked").val();

	jQuery('#atc-opt-disp').html(loadingimage);
	
	jQuery.post("addons/GIS/addtocart/atc_options.php", { Copies: Copies, todaysPrice: todaysPrice, status: status, uid: uid, action: "Update", atcid: "<?= $_REQUEST['atcid'];?>", productID: "<?= $_REQUEST['productID']; ?>" },
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
<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Edit Add-To-Cart Bump Entry</p>";
		
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts">

 	<input type="image" src="/rap_admin/addons/GIS/addtocart/images/save.png" name="submit" value="Save" onClick="javascript:aSaveatc('<?= $_REQUEST['uid']; ?>');"/><br>&nbsp;&nbsp;Save
 	</td><td></td><td align="right" class="Prompts"><input type="image" src="/rap_admin/addons/GIS/addtocart/images/delete48x48.png" name="submit" value="Save" onClick="javascript:aSaveCancelatc();"/><br>Cancel&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table>
 	<tr><td class="Prompts">Copies:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="Copies" id="Copies" value="<?= $grow['Copies'];?>"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Today's Price:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="todaysPrice" id="todaysPrice" value="<?= $grow['todaysPrice'];?>"></td><td></td></tr>
 	<tr><td>&nbsp;</td></tr>

 	
 	<tr><td colspan="4">
 		<ul class="checklist">
						<li>
							<input id="status" name="status" value="1" type="checkbox" <? if ($grow['status'] == '1' || $grow['status'] == '2') { echo "checked"; } ?>>
                    		<label for="status">Active Add-To-Cart Bump Entry</label>
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