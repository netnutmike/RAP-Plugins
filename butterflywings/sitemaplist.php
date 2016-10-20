<?
//==============================================================================================
//
//	Filename:	sitemaplist.php
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
//	Description:	This file is called when the robots manual list is opened. 
//
//	Version:	1.0.0 (February 10th, 2010)
//
//	Change Log:
//				02/12/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php");

?>

<script type="text/javascript">

function MapSelected(form) {
	
	jQuery('#MapText').html(jQuery('#maps option:selected').text());
	var fln = jQuery('#maps').val();

	jQuery('#buttonrowm').show();
}

function aAddMap() {
	
	var map = jQuery('#map').val();
	jQuery('#buttonrowm').hide();
	jQuery('#MapText').html("");
	
	jQuery.post("addons/GIS/raptools/sitemaplist.php", { map: map},
			function(data){
				jQuery('#sitemap_div').html(data);
			  }
		);
}

function aDeleteMap() {
	
	var map = jQuery('#maps').val();
	jQuery('#buttonrowm').hide();
	jQuery('#MapText').html("");
	
	jQuery.post("addons/GIS/raptools/sitemaplist.php", { map: map, action: "delete" },
			function(data){
				jQuery('#sitemap_div').html(data);
			  }
		);
}
</script>

<?

	if ($_POST['map'] != "") {
		if ($_POST['action'] == "delete") {
			$sql="DELETE FROM g_raptoolsOptions WHERE uid = '" . $_POST['map'] . "'";
			$gid=mysql_query($sql);
		} else {
			gInsertOptionChar("MANUALMAP", 0, $_POST['map']);
		}
		
	}
	
	//If an error message was passed in then display the error message in a red box.
	if ($_POST['errormessage'] != "") { ?>
		<div class="rounded-box-red" id="error-box">
    	    <div class="box-contents">
        <? echo $_POST['errormessage']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#error-box').effect("pulsate", { times:3 }, 2000);
			jQuery('#error-box').fadeOut(10000);
		</script>
<?	} 

	//If a message was passed in display the message in a green box.
	if ($_POST['message'] != "") { ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        <? echo $_POST['message']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);

		</script>
<?	} ?>

<div class="rounded-box">
    <!-- Content -->
    <div class="box-contents width-465">
        Adding and Deleting manual sitemap entries is very easy.  To add a new entry simply add the map text into the blank field and click the Add (plus) button.  To delete a mapping, select the mapping and click the delete (X) button.
    </div> <!-- end div.box-contents -->
</div> <!-- end div.rounded-box -->
<br><br>

<table><tr><td>
<div id='filelist'>
<select name="maps" size="10" id="maps" class="fileslist" onClick="MapSelected(this.form)">
   
<?php 
	//Build a list of blocks in the select list by looping through all the blocks in the options table
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = 'MANUALMAP'";
	
	$gid=mysql_query($sql);
	while ( $grow=mysql_fetch_array($gid) ) {
			echo "<option value=\"" . $grow['uid'] . "\">" .  $grow['ValueChar'] . "</option>";
		}

?>
 </select>
</div></td><td valign="top">

<div id='mapdetails'>
<table><tr><td>
	<div id="MapText">
	<---- Select a mapping on the left to delete it.
	</div></td></tr>
	<tr><td>
	<div id="buttonrowm" style="display:none">
	<a href="javascript:aDeleteMap();" id="deletemap"><img src="addons/GIS/raptools/images/delete32x32.png" alt="Delete the selected mapping, This cannot be undone" border="0"></a>
	</div>
	</td></tr>
	<tr><td>
	<div id="MappingText">
	<table>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Mapping Text:</td><td><input type="text" name="map" id="map">
		</td><td><a href="javascript:aAddMap();" id="addmap"><img src="addons/GIS/raptools/images/add.png" alt="Add the new Map" border="0" align="right"></td></tr>
	</table>
	</div>
	</td></tr>
	</table>
</div>
</td></tr></table>

