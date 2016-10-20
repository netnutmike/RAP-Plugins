<?
//==============================================================================================
//
//	Filename:	add_link.php
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
//	Description:	This file is called when the user wants to copy a file. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/23/09 - Initial Version (JMM)
//
//==============================================================================================
?>

<script language="JavaScript">

function aCreateCancel() {

	jQuery.post("addons/GIS/cloaker/cloaked_links.php", {  },
					function(data){
						jQuery('#cl-opt-disp').html(data);
				  	}
				);
}

function aCreate() {

	var Name =	jQuery("#Name").val();
	var DestinationURL =	jQuery("#DestinationURL").val();
	var FriendlyName =	jQuery("#FriendlyName").val();
	var CloakType =	jQuery("#CloakType").val();
	var CloakedTitle = jQuery("#CloakedTitle").val();
	jQuery.post("addons/GIS/cloaker/cloaked_links.php", { Name: Name, DestinationURL: DestinationURL, FriendlyName: FriendlyName, CloakType: CloakType, CloakedTitle: CloakedTitle, action: "Create" },
					function(data){
						jQuery('#cl-opt-disp').html(data);
				  	}
				);
}

function showHideSections() {
	if ( jQuery("#CloakType:checked").val() == 1 ) {
		jQuery("#clkname").show();
	} else {
		jQuery("#clkname").hide();
	}	
};

</script>

<table>
<tr><td>
 	<table>
 	<tr><td class="Prompts">Link Name:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="Name" id="Name"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Destination URL:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="DestinationURL" id="DestinationURL"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Friendly Name:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="FriendlyName" id="FriendlyName"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td colspan="3">
 	<ul class="checklist">
						<li>
							<input id="CloakType" name="CloakType" value="1" type="checkbox" checked>
                    		<label for="CloakType">Cloak Friendly Link</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
 	</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;&nbsp;</td><td colspan="2"><div id="clkname" name="clkname"><table>
 	
 	<tr><td class="Prompts">Page Title:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="CloakedTitle" id="CloakedTitle"></td></tr></table></div></td></tr>
 	</table>

  </td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
  
 
<Table><tr><td>
<input type="button" name="submit" id="submit" value="Create" onClick="javascript:aCreate();"/>
</td><td>
<input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:aCreateCancel();" />
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
