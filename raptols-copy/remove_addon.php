<?
//==============================================================================================
//
//	Filename:	remove_addon.php
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
//	Description:	This file is called when the user wants to remove an addon. 
//
//	Version:	1.0.0 (February 9th, 2010)
//
//	Change Log:
//				02/09/2010 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); ?>

<script language="JavaScript">

function aDeleteCancel() {

	jQuery.post("addons/GIS/raptools/products.php", { },
					function(data){
						jQuery('#main-dis').html(data);
				  	}
				);
}

function aDeleteDelete() {

	var disable_addon =	jQuery("#disable_addon:checked").val();
	var delete_files =	jQuery("#delete_files:checked").val();
	var dodelete = "delete";
	var aid =	jQuery("#aid").html();
	jQuery.post("addons/GIS/raptools/remove_addon.php", { disable_addon: disable_addon, delete_files: delete_files, aid: aid, dodelete: dodelete },
					function(data){
						jQuery('#main-dis').html(data);
				  	}
				);
}

function aContinue() {

	var cont = jQuery('#main-dis');
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/addons.php", { },
		function(data){
			cont.html(data);
		  	}
		);
}

</script>

<? 

// Delete product settings from db
function delete_addon_from_db($aid)
{
	//delete product entry
	$g_deletequery = "delete from addons where id='" . $aid . "'";
	mysql_query($g_deletequery);
}


// Delete physical files on web serevr
function delete_files($pathnm)
{
		recursive_remove_directory($pathnm);
}

if ($_POST['aid'] != "" && $_POST['dodelete'] != "") {


	$query = "select * from addons where id='" . $_REQUEST["aid"] . "'";		
	$request = mysql_query($query);
	$prs = mysql_fetch_array($request); 
			
	//time to make the donuts..... I mean delete the stuff
	if ($_POST['disable_addon'] == 1) {
		$g_npid = delete_addon_from_db($_POST['aid']);
	} else { ?>
			<div class="rounded-box-red width-500" id="error-box">
    	    <div class="box-contents width-500">
        		NOTICE: No action was taken because you did not confirm that you wanted to remove the addon.  To remove the addon you must confirm that you want to remove the addon.
    		</div> 
		</div>	
		
<?	}
	
	
	if ($_POST['delete_files'] == 1 && $_POST['disable_addon'] == 1) {
		delete_files(substr(getcwd(),0,strrpos(getcwd(), "/rap_admin")) . "/addons/" . $prs['groupfolder'] . "/" . $prs['addonfolder']);
		
		if (file_exists(substr(getcwd(),0,strrpos(getcwd(), "/rap_admin")) . "/addons/" . $prs['groupfolder'] . "/" . $prs['addonfolder'])) { ?>
			<div class="rounded-box-red width-500" id="error-box">
    	    <div class="box-contents width-500">
        		The deletion of the files seems to have failed.  This can happen if you do not have the proper permissions for the web server to be able to delete the files.  <br><br>To Complete the deletion you will have to manually remove the files.
    		</div> 
		</div>
		<div style='clear:both;'></div><br>
		
	<?	}
	}
	?>
	<table><tr><td>
<div class="rounded-box-green width-500" id="message-box">
    	    <div class="box-contents width-500">
        The addon removal has been completed.  If there were errors they will be above this message.  Please note that the addon you just deleted will show up in the RAP addon menu until you go to another menu option or refresh the page.  Click the Continue button below to return to the addons page in Rap Tools.
    		</div> 
		</div></td></tr><tr><td>
		<div style='clear:both;'></div><br><br>&nbsp;
		<input type="button" name="submit" id="submit" value="Continue..." onClick="javascript:aContinue();"/>
		</td></tr></table>		
<?
} else { ?>

<?php 
	$query = "select * from addons where id='" . $_REQUEST["aid"] . "'";		
	$request = mysql_query($query);
	$prs = mysql_fetch_array($request); ?>
<table>
<tr><td>
 You are about to Disable/Delete <strong>"<?=$prs['title']?>"</strong>.  Please verify by selecting the following options:<br>&nbsp;
 <div class='gis-content padding-rl-20 width-465' style="display:none" id="aid"><? echo $_REQUEST["aid"]; ?></div>
 <table>

  <tr><td>Disable Options:</td><td></td></tr>
 <r><td>&nbsp;</td></tr>
 <tr><td colspan="2">
 <table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><ul class="checklist">
<li>
<input id="disable_addon" name="disable_addon" value="1" type="checkbox" >
					<a href="javascript:void(0);" id="da"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="disable_addon">Disable This Addon</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="da-desc">This option will disable this addon within RAP.</div>
<p>&nbsp;</p>
<ul class="checklist">
<li>
<input id="delete_files" name="delete_files" value="1" type="checkbox" >
					<a href="javascript:void(0);" id="daff"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="delete_files">Delete Addon Files</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="daff-desc">If you select this option all of the physical files on the web server for this addon
will be deleted.</div>
<p>&nbsp;</p>

</div>
</td></tr></table>
</td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td><div class="rounded-box-red width-500" id="error-box">
    	    <div class="box-contents width-500">
        WARNING!  You are about to disable/delete the items you selected above.  <strong>DELETING FILES CANNOT BE UNDONE</strong> so be sure it is what you want to do before you click the DISABLE button below!
    		</div> 
		</div></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td align="right">
<input type="button" name="submit" id="submit" value="DISABLE" onClick="javascript:aDeleteDelete();"/>
</td><td align="right">
<input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:aDeleteCancel();" />
</td></tr>
 </table>
  </td></tr>
  <tr><td>
  
 
</form>

</td></tr></table>

<? } ?>

<script type='text/javascript'>
jQuery(document).ready(function() {
	 
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

	jQuery("#da").click(function() {
		
		jQuery("#da-desc").toggle();

	});

	jQuery("#daff").click(function() {
		
		jQuery("#daff-desc").toggle();

	});

});

</script>