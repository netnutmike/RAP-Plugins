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
?>

<script language="JavaScript">

function aCreateCancel() {

	var pid = jQuery('#products').val();
	jQuery.post("addons/GIS/testimonials/testimonials.php", { pid: pid },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aCreate() {

	var Name =	jQuery("#Name").val();
	var VisualName =	jQuery("#VisualName").val();
	var Email =	jQuery("#Email").val();
	var FromLocation =	jQuery("#FromLocation").val();
	var UseWhere = jQuery("#UseWhere").val();
	var ShortSubject = jQuery("#ShortSubject").val();
	var Testimonial = jQuery("#Testimonial").val();
	var VideoURL = jQuery("#VideoURL").val();
	var pid = jQuery('#products').val();
	jQuery.post("addons/GIS/testimonials/testimonials.php", { Name: Name, VisualName: VisualName, Email: Email, FromLocation: FromLocation, UseWhere: UseWhere, ShortSubject: ShortSubject, Testimonial: Testimonial, pid: pid, VideoURL: VideoURL, action: "Create" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

</script>

<br><br><p class="georgia-medium">Add New Testimonial</p>
<table>
<tr><td>
 	<table>
 	<tr><td class="Prompts">Name:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="Name" id="Name"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Visual Name:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="VisualName" id="VisualName"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Email:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="Email" id="Email" size="60"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">From(location):</td><td>&nbsp;&nbsp;</td><td><input type="text" name="FromLocation" id="FromLocation" size="40"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Section(optional):</td><td>&nbsp;&nbsp;</td><td><input type="text" name="UseWhere" id="UseWhere"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Subject:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="ShortSubject" id="ShortSubject" size="70"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Testimonial:</td><td>&nbsp;&nbsp;</td><td><textarea name="Testimonial" id="Testimonial" cols="50" rows="20"></textarea></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Video Embed Code(optional):</td><td>&nbsp;&nbsp;</td><td><textarea name="VideoURL" id="VideoURL" cols="50" rows="10"></textarea></td></tr>
 	<tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td colspan="3">
  
 
<Table width="90%"><tr><td>
<input type="image" src="/rap_admin/addons/GIS/testimonials/images/save.png" value="Create" onClick="javascript:aCreate();"/> Save
</td><td align="right">
<input type="image" src="/rap_admin/addons/GIS/testimonials/images/delete.png" value="Cancel" onClick="javascript:aCreateCancel();" /> Cancel
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
