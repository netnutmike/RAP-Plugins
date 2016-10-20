<?
//==============================================================================================
//
//	Filename:	edit_auto_prod.php
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
//	Description:	This file is called when the user wants to create or edit a date based
//					theme change. 
//
//	Version:	1.0.0 (March 29th, 2010)
//
//	Change Log:
//				03/29/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); 

?>

<script language="JavaScript">

function aSaveCancelProd() {

	jQuery.post("addons/GIS/autooptin/product_options_edit.php", { productID: '<?= $_POST['productID'];?>' },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aSaveNewProd() {

	var Name =	jQuery("#Name").val();
	var optionText =	jQuery("#optionText").val();
	var GroupCode =	jQuery("#GroupCode").val();
	var NewGroupShort =	jQuery("#NewGroupShort").val();
	var NewGroup =	jQuery("#NewGroup").val();
	
	jQuery.post("addons/GIS/autooptin/product_options_edit.php", { action: 'insert', Name: Name, optionText: optionText, productID: '<?= $_POST['productID'];?>', GroupCode: GroupCode, NewGroupShort: NewGroupShort, NewGroup: NewGroup },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aSaveProd(uid) {

	var Name =	jQuery("#Name").val();
	var optionText =	jQuery("#optionText").val();
	var status = jQuery("#status:checked").val();
	var GroupCode =	jQuery("#GroupCode").val();
	var NewGroupShort =	jQuery("#NewGroupShort").val();
	var NewGroup =	jQuery("#NewGroup").val();
	jQuery.post("addons/GIS/autooptin/product_options_edit.php", { action: 'update', productID: '<?= $_POST['productID'];?>', Name: Name, optionText: optionText, uid: uid, status: status, GroupCode: GroupCode, NewGroupShort: NewGroupShort, NewGroup: NewGroup },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function GroupSelected() {

	var GroupCode =	jQuery("#GroupCode").val();
	
	if ( GroupCode == '0' )
	{
		jQuery("#newGroup").show();
	}
	else
	{
		jQuery("#newGroup").hide();
	}
}
</script>

<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 	if ($_POST['action'] == "edit") {
		$sql="select * from g_autoResponderOptions where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql);
		$grow = mysql_fetch_array($gid);
		
		echo "<p class=\"georgia-medium\">Edit Auto Opt-in Entry</p>";
		} else if ($_POST['action'] == "new") {
			echo "<p class=\"georgia-medium\">Add New Auto Opt-in Entry</p>";
		}
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left">
 	<? if ($_POST['action'] == "new") {?>
 	<input type="image" src="/rap_admin/addons/GIS/autooptin/images/save.png" name="submit" value="Save" onClick="javascript:aSaveNewProd();"/>
 	<? } else {?>
 	<input type="image" src="/rap_admin/addons/GIS/autooptin/images/save.png" name="submit" value="Save" onClick="javascript:aSaveProd('<?= $grow['uid'];?>');"/>
 	<?  } ?></td><td></td><td align="right"><input type="image" src="/rap_admin/addons/GIS/autooptin/images/delete48x48.png" name="submit" value="Save" onClick="javascript:aSaveCancelProd();"/></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<? if ($_POST['action'] == "edit") {?>
 		<tr><td colspan="3">
 		<ul class="checklist">
						<li>
							<input id="status" name="status" value="1" type="checkbox" <? if ($grow['status'] == '1' || $grow['status'] == '2') { echo "checked"; } ?>>
                    		<label for="status">Active Auto Opt-in Entry</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
 		</td></tr>
 		<tr><td>&nbsp;</td></tr>
 	<? } ?>
 	<tr><td class="Prompts">Name:</td><td colspan="2"><input type="text" name="Name" id="Name" value="<?= trim($grow['Name']); ?>" size="35"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Group:</td><td colspan="2">
 	<select name="GroupCode" id="GroupCode" onChange="javascript:GroupSelected()">
 	<option value="0">Add New</option>
 	<? 	$sql="select * from g_autoResponderGroups";
		$ors=mysql_query($sql);
		while ($orow = mysql_fetch_array($ors)) { ?>
  			<option value="<?= $orow["GroupCode"]; ?>"<? if ($orow["GroupCode"] == $grow["GroupCode"] ) { echo " SELECTED"; } ?>><?= $orow["GroupName"]; ?> (<?= $orow["GroupCode"]; ?>) </option>
  			
  		<? } ?>
</select></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td></td><td colspan="2" class="Prompts"><div id="newGroup" style='display:none;'>Short Name: <input type="text" name="NewGroupShort" id="NewGroupShort" size="5"> <br><br>New Group Name: <input type="text" name="NewGroup" id="NewGroup" size="20"></div></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" valign="top">Auto Opt-in Link:</td><td valign="top"><textarea name="optionText" rows="10" cols="70" id="optionText" ><?= trim($grow['optionText']);?></textarea>
</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
  <tr><td>
  
</td></tr></table>

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
