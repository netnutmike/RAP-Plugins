<?
//==============================================================================================
//
//	Filename:	robotslist.php
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

function BlockSelected(form) {
	
	jQuery('#BlockText').html(jQuery('#blocks option:selected').text());
	var fln = jQuery('#blocks').val();

	jQuery('#buttonrow').show();
}

function aAddBlock() {
	
	var block = jQuery('#block').val();
	jQuery('#buttonrow').hide();
	jQuery('#blockText').html("");
	
	jQuery.post("addons/GIS/raptools/robotslist.php", { block: block},
			function(data){
				jQuery('#block_manual_div').html(data);
			  }
		);
}

function aDeleteBlock() {
	
	var block = jQuery('#blocks').val();
	jQuery('#buttonrow').hide();
	jQuery('#blockText').html("");
	
	jQuery.post("addons/GIS/raptools/robotslist.php", { block: block, action: "delete" },
			function(data){
				jQuery('#block_manual_div').html(data);
			  }
		);
}
</script>

<?

	if ($_POST['block'] != "") {
		if ($_POST['action'] == "delete") {
			$sql="DELETE FROM g_raptoolsOptions WHERE uid = '" . $_POST['block'] . "'";
			$gid=mysql_query($sql);
		} else {
			gInsertOptionChar("DISALLOW", 0, $_POST['block']);
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
        Adding and Deleting Disallow Statements (Blocks) is very easy.  To add a new block simply add the block text into the blank field and click the Add (plus) button.  To delete a block, select the block and click the delete (X) button.
    </div> <!-- end div.box-contents -->
</div> <!-- end div.rounded-box -->
<br><br>

<table><tr><td>
<div id='filelist'>
<select name="blocks" size="10" id="blocks" class="fileslist" onClick="BlockSelected(this.form)">
   
<?php 
	//Build a list of blocks in the select list by looping through all the blocks in the options table
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = 'DISALLOW'";
	
	$gid=mysql_query($sql);
	while ( $grow=mysql_fetch_array($gid) ) {
			echo "<option value=\"" . $grow['uid'] . "\">" .  $grow['ValueChar'] . "</option>";
		}

?>
 </select>
</div></td><td valign="top">

<div id='blockdetails'>
<table><tr><td>
	<div id="BlockText">
	<---- Select a block on the left to delete it.
	</div></td></tr>
	<tr><td>
	<div id="buttonrow" style="display:none">
	<a href="javascript:aDeleteBlock();" id="deleteblock"><img src="addons/GIS/raptools/images/delete32x32.png" alt="Delete the selected block, This cannot be undone" border="0"></a>
	</div>
	</td></tr>
	<tr><td>
	<div id="DisallowText">
	<table>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Disallow Text:</td><td><input type="text" name="block" id="block">
		</td><td><a href="javascript:aAddBlock();" id="addblock"><img src="addons/GIS/raptools/images/add.png" alt="Add the new block" border="0" align="right"></td></tr>
	</table>
	</div>
	</td></tr>
	</table>
</div>
</td></tr></table>

