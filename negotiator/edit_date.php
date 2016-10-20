<?
//==============================================================================================
//
//	Filename:	edit_date.php
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
//	Version:	1.0.0 (March 11th, 2010)
//
//	Change Log:
//				03/11/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); 

if ($_POST['returnto'] != "")
	$g_returnto = $_POST['returnto'];
else
	$g_returnto = "testimonials.php";
?>

<script language="JavaScript">

function TemplateSelected(form) {
	
	var tmpname = jQuery('#templates').val();

	jQuery.post("addons/GIS/themes/tmp_preview.php", { tmpname: tmpname},
			function(data){
				jQuery('#tmp-preview').html(data);
		  	}
		);
}

function aSaveCancel() {

	jQuery.post("addons/GIS/themes/global_options_edit.php", { type: '2' },
					function(data){
						jQuery('#gl-opt-disp-set').html(data);
				  	}
				);
}

function aSaveNew() {

	var time =	jQuery("#time").val();
	var template =	jQuery("#templates").val();
	
	jQuery.post("addons/GIS/themes/global_options_edit.php", { type: '2', action: 'insert', time: time, template: template },
					function(data){
						jQuery('#gl-opt-disp-set').html(data);
				  	}
				);
}

function aSave(uid) {

	var time =	jQuery("#time").val();
	var template =	jQuery("#templates").val();
	var status = jQuery("#status:checked").val();
	jQuery.post("addons/GIS/themes/global_options_edit.php", { type: '2', action: 'update', time: time, template: template, uid: uid, status: status },
					function(data){
						jQuery('#gl-opt-disp-set').html(data);
				  	}
				);
}

</script>

<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 	if ($_POST['action'] == "edit") {
		$sql="select * from g_themeOptions where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql);
		$grow = mysql_fetch_array($gid);

		if (strlen($grow['time']) == 16)
			$timeval = substr($grow['time'],4,2) . "/" . substr($grow['time'],6,2) . "/" . substr($grow['time'],0,4) . " " . substr($grow['time'],8,2) . ":" . substr($grow['time'],10,2);
		else
			$timeval = substr($grow['time'],4,2) . "/" . substr($grow['time'],6,2) . "/" . substr($grow['time'],0,4) . " 00:00";
		
		
		$templatename = $grow['template'];
		echo "<p class=\"georgia-medium\">Edit Theme Date / Time Entry</p>";
		} else if ($_POST['action'] == "new") {
			$timeval = "00/00/0000 00:00";
			$newtime = strtotime( "+1 day", time() );
			$timeval = date("m/d/Y H:i", $newtime);
			$templatename = "default";
			echo "<p class=\"georgia-medium\">Add New Theme Date / Time Entry</p>";
		}
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left">
 	<? if ($_POST['action'] == "new") {?>
 	<input type="image" src="/rap_admin/addons/GIS/themes/images/save.png" name="submit" value="Save" onClick="javascript:aSaveNew();"/>
 	<? } else {?>
 	<input type="image" src="/rap_admin/addons/GIS/themes/images/save.png" name="submit" value="Save" onClick="javascript:aSave('<?= $grow['uid'];?>');"/>
 	<?  } ?></td><td></td><td align="right"><input type="image" src="/rap_admin/addons/GIS/themes/images/delete48x48.png" name="submit" value="Save" onClick="javascript:aSaveCancel();"/></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<? if ($_POST['action'] == "edit") {?>
 		<tr><td colspan="3">
 		<ul class="checklist">
						<li>
							<input id="status" name="status" value="1" type="checkbox" <? if ($grow['status'] == '1' || $grow['status'] == '1') { echo "checked"; } ?>>
                    		<label for="status">Active Theme Schedule Entry</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
 		</td></tr>
 		<tr><td>&nbsp;</td></tr>
 	<? } ?>
 	<tr><td class="Prompts">Date / Time:</td><td><input type="text" name="time" id="time" value="<?= $timeval ?>" size="16"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" valign="top">Template:</td><td valign="top"><select name="templates" size="10" id="templates" class="productslist" onClick="TemplateSelected(this.form)">
<?   
		$files1 = scandir("themes");

	
		foreach ( $files1 as $file ) {
 			if ($file != "." && $file != ".." ) {
 				if ($file == $templatename) { $selected = "SELECTED"; } else { $selected = ""; }
					echo "<option value=\"" . $file . "\" " . $selected . ">" . $file . "</option>";
				}
			}
		?>
 </select></td><td colspan="2"><div id="tmp-preview"></div></td></tr>
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

jQuery(document).ready(function() {
	TemplateSelected();
});
</script>
