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

if ($_POST['returnto'] != "")
	$g_returnto = $_POST['returnto'];
else
	$g_returnto = "testimonials.php";
?>

<script language="JavaScript">

function aSaveCancel() {

	var pid = jQuery('#products').val();
	jQuery.post("addons/GIS/testimonials/<?= $g_returnto?>", { pid: pid },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aSave(uid) {

	var Name =	jQuery("#Name").val();
	var VisualName =	jQuery("#VisualName").val();
	var Email =	jQuery("#Email").val();
	var FromLocation =	jQuery("#FromLocation").val();
	var UseWhere = jQuery("#UseWhere").val();
	var ShortSubject = jQuery("#ShortSubject").val();
	var Testimonial = jQuery("#Testimonial").val();
	var VideoURL = jQuery("#VideoURL").val();
	var Status = jQuery("#Status:checked").val();
	var pid = jQuery('#products').val();
	jQuery.post("addons/GIS/testimonials/<?= $g_returnto?>", { Name: Name, VisualName: VisualName, Email: Email, FromLocation: FromLocation, UseWhere: UseWhere, ShortSubject: ShortSubject, Testimonial: Testimonial, pid: pid, Status: Status, VideoURL: VideoURL, uid: uid, action: "Update" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

</script>

<?
	$sql="select * from g_testimonials where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
?>
<br><br><p class="georgia-medium">Edit Testimonial</p>
<table>
<tr><td>
 	<table>
 	<tr><td class="Prompts">Name:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="Name" id="Name" value="<?= $grow['Name'];?>"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Visual Name:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="VisualName" id="VisualName" value="<?= $grow['VisualName'];?>"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Email:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="Email" id="Email" size="60" value="<?= $grow['Email'];?>"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">From(location):</td><td>&nbsp;&nbsp;</td><td><input type="text" name="FromLocation" id="FromLocation" size="40" value="<?= $grow['FromLocation'];?>"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Section(optional):</td><td>&nbsp;&nbsp;</td><td><input type="text" name="UseWhere" id="UseWhere" value="<?= $grow['UseWhere'];?>"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Subject:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="ShortSubject" id="ShortSubject" size="70" value="<?= $grow['ShortSubject'];?>"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Testimonial:</td><td>&nbsp;&nbsp;</td><td><textarea name="Testimonial" id="Testimonial" cols="50" rows="20"><?= $grow['Testimonial'];?></textarea></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Video Embed Code(optional):</td><td>&nbsp;&nbsp;</td><td><textarea name="VideoURL" id="VideoURL" cols="50" rows="10"><?= $grow['VideoURL'];?></textarea></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td colspan="3">
 	<ul class="checklist">
						<li>
							<input id="Status" name="Status" value="1" type="checkbox" <? if ($grow['Status'] == '1') { echo "checked"; } ?>>
                    		<label for="Status">Active Testimonial</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
 	</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
  
 
<Table><tr><td>
<input type="button" name="submit" id="submit" value="Save" onClick="javascript:aSave('<?= $grow['uid'];?>');"/>
</td><td>
<input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:aSaveCancel();" />
</td></tr></table>
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
        showHideSections();
    }
);

jQuery(".checklist .checkbox-deselect").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().removeClass("selected");
        jQuery(this).parent().find(":checkbox").removeAttr("checked");
        showHideSections();
    }
    
);
</script>
