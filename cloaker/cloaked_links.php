<?
//==============================================================================================
//
//	Filename:	global_options.php
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
//	Description:	This file is called to display the global options and to save the global 
// 					options. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/29/09 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php");

?>
<script src="addons/GIS/cloaker/js/rapcloaker.js"></script>


<script language="JavaScript">

function aAdd() {

	UnTip();
	jQuery('#cl-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/cloaker/add_link.php", { },
					function(data){
						jQuery('#cl-opt-disp').html(data);
				  	}
				);
}

function aEdit(uid) {

	UnTip();
	jQuery('#cl-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/cloaker/edit_link.php", { uid: uid },
					function(data){
						jQuery('#cl-opt-disp').html(data);
				  	}
				);
}

function aStats(uid) {

	UnTip();
	jQuery('#ls-opt-disp').html(loadingimage);
	jQuery('#ls-opt-disp').show();
	jQuery.post("addons/GIS/cloaker/cloaked_stats.php", { uid: uid },
					function(data){
						jQuery('#ls-opt-disp').html(data);
				  	}
				);
}

function aDelete(uid, name) {

	UnTip();
	jQuery('#cl-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/cloaker/delete_link.php", { uid: uid, Name: name },
					function(data){
						jQuery('#cl-opt-disp').html(data);
				  	}
				);
}

function aReset(uid) {

	UnTip();
	jQuery('#cl-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/cloaker/cloaked_links.php", { uid: uid, action: "Reset" },
					function(data){
						jQuery('#cl-opt-disp').html(data);
				  	}
				);
}
</script>


<? if ($_POST['action'] == "Create" ) {

	$sql = "insert into g_cloakerOptions (Name, DestinationURL, FriendlyName, CloakType, CloakedTitle, UniqueClicks, RawClicks) VALUES ('" . $_POST['Name'] . "', '" . $_POST['DestinationURL'] . "', '" . $_POST['FriendlyName'] . "', '" . $_POST['CloakType'] . "', '" . $_POST['CloakedTitle'] . "', '0', '0')";

	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        		New Cloaked Link Inserted!
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} else if ($_POST['action'] == "Delete" ) {
		$sql = "DELETE from g_cloakerOptions where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql); ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        		Link Deleted!
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
		
<? 	} else if ($_POST['action'] == "Reset" ) {
		$sql = "UPDATE g_cloakerOptions set UniqueClicks='0', RawClicks='0' where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql); 
		
 	} else if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_cloakerOptions set Name='" . $_POST['Name'] . "', DestinationURL='" . $_POST['DestinationURL'] . "', FriendlyName='" . $_POST['FriendlyName'] . "', CloakType='" . $_POST['CloakType'] . "', CloakedTitle='" . $_POST['CloakedTitle'] . "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        		Link Updated!
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} else { 

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
<?	}

	}?>


<table>
<tr><td colspan="9" align="right"><a href="javascript:aAdd();" onmouseover="Tip('Click this icon to add a new link')" onmouseout="UnTip()"><img src="addons/GIS/cloaker/images/add32x32.png" border="0"></a></td>
<tr class="Prompts"><td class="Prompts"><strong>Link Name</strong></td><td></td><td align="center"><strong>Type</strong></td><td></td><td><strong>Unique Clicks</strong></td><td></td><td><strong>Raw Clicks</strong></td><td></td><td align="center"><strong>Options</strong></td></tr>
<?
 	$sql = "select * from g_cloakerOptions";
	$gid=mysql_query($sql);
	while ($grow = mysql_fetch_array($gid)) { ?>
		<tr class="Prompts"><td><?= $grow['Name']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><? if ($grow['CloakType'] == '1') { echo "Cloak"; } else { echo "Forward"; } ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['UniqueClicks']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['RawClicks']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><a href="javascript:aEdit('<?= $grow['uid']; ?>')" onmouseover="Tip('Click this icon to edit this link')" onmouseout="UnTip()"><img src="addons/GIS/cloaker/images/edit32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aDelete('<?= $grow['uid']; ?>', '<?= $grow['Name']; ?>')"  onmouseover="Tip('Click this icon to delete this link')" onmouseout="UnTip()"><img src="addons/GIS/cloaker/images/delete32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aStats('<?= $grow['uid']; ?>')" onmouseover="Tip('Click this icon to view the stats for this link')" onmouseout="UnTip()" alt="View Stats for this Link"><img src="addons/GIS/cloaker/images/chart_pie32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aReset('<?= $grow['uid']; ?>')" onmouseover="Tip('Click this icon to reset the raw and unique clicks to 0 (zero)')" onmouseout="UnTip()"><img src="addons/GIS/cloaker/images/refresh32x32.png" border="0"></a>&nbsp;</td>
   
  		</tr>
<? } ?>  
  <tr><td>
  
</td></tr></table>

