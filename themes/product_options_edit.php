<?php 

//==============================================================================================
//
//	Filename:	global_options_edit.php
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
//	Description:	This file is called to provide either the global settings or tables of info
//					depending on the type 
//
//	Version:	1.0.0 (March 11th, 2010)
//
//	Change Log:
//				03/11/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); 

$productID = $_REQUEST['pid'];
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

function aDayAdd(pid) {

	jQuery('#pr-opt-disp-set').html(loadingimage);

	jQuery.post("addons/GIS/themes/prod_edit_day.php", { action: 'new', pid: pid },
					function(data){
						jQuery('#pr-opt-disp-set').html(data);
				  	}
				);
}

function aDateAdd(pid) {

	jQuery('#pr-opt-disp-set').html(loadingimage);

	jQuery.post("addons/GIS/themes/prod_edit_date.php", { action: 'new', pid: pid },
					function(data){
						jQuery('#pr-opt-disp-set').html(data);
				  	}
				);
}

function aEdit(uid) {

	jQuery('#pr-opt-disp-set').html(loadingimage);
	jQuery.post("addons/GIS/themes/prod_edit_day.php", { uid: uid, action: 'edit' },
					function(data){
						jQuery('#pr-opt-disp-set').html(data);
				  	}
				);
}

function aEditDate(uid) {

	jQuery('#pr-opt-disp-set').html(loadingimage);
	jQuery.post("addons/GIS/themes/prod_edit_date.php", { uid: uid, action: 'edit' },
					function(data){
						jQuery('#pr-opt-disp-set').html(data);
				  	}
				);
}

function aSave(pid) {

	var template =	jQuery("#templates").val();
	jQuery('#pr-opt-disp-set').html(loadingimage);
	
	jQuery.post("addons/GIS/themes/product_options_edit.php", { type: '0', action: 'update', template: template, pid: pid },
					function(data){
						jQuery('#pr-opt-disp-set').html(data);
				  	}
				);
}

function aToggleProdItem(uid, status, type, pid) {

	var template =	jQuery("#templates").val();
	jQuery('#pr-opt-disp-set').html(loadingimage);
	
	jQuery.post("addons/GIS/themes/product_options_edit.php", { uid: uid, action: 'toggle', status: status, type: type, pid: pid },
					function(data){
						jQuery('#pr-opt-disp-set').html(data);
				  	}
				);
}

function aDelete(uid) {

	jQuery('#pr-opt-disp-set').html(loadingimage);
	jQuery.post("addons/GIS/themes/delete_entry.php", { uid: uid, type: '1' },
					function(data){
						jQuery('#pr-opt-disp-set').html(data);
				  	}
				);
}
</script>

<? if ($_POST['action'] == "insert" && ($_POST['type'] == '1' || $_POST['type'] == '2')) {
	if ($_POST['type'] == '1')
		$g_clndtime = str_replace(":", "", $_POST['time']);

	if ($_POST['type'] == '2')
		if (strlen($_POST['time']) == 16)
			$g_clndtime = substr($_POST['time'],6,4) . substr($_POST['time'],0,2) . substr($_POST['time'],3,2) . substr($_POST['time'],11,2) . substr($_POST['time'],14,2);
		else
			$g_clndtime = substr($_POST['time'],6,4) . substr($_POST['time'],0,2) . substr($_POST['time'],3,2) . "0000";
		
	$sql = "insert into g_themeOptions (productid, template, timeType, time, status) VALUES ('" . $_POST['pid'] . "','" . $_POST['template'] . "', '" . $_POST['type'] . "', '" . $g_clndtime . "', '1')";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        		<br><font style="font-size: 18px;"><strong>Good News!!</strong></font><img src="/rap_admin/addons/GIS/themes/images/info48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		New Record for the Product Theme Options Has Been Inserted...
        		</i><br>&nbsp;
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} else if ($_POST['action'] == "delete") {
		$sql = "DELETE from g_themeOptions where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql); ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        		<br><font style="font-size: 18px;"><strong>Success!!</strong></font><img src="/rap_admin/addons/GIS/themes/images/info48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		The Record Has Been Deleted...</i><br>&nbsp;
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
		
<? 	} else if ($_POST['action'] == "update" && ($_POST['type'] == '1' || $_POST['type'] == '2')) {
	if ($_POST['type'] == '1')
		$g_clndtime = str_replace(":", "", $_POST['time']);

	if ($_POST['type'] == '2')
		if (strlen($_POST['time']) == 16)
			$g_clndtime = substr($_POST['time'],6,4) . substr($_POST['time'],0,2) . substr($_POST['time'],3,2) . substr($_POST['time'],11,2) . substr($_POST['time'],14,2);
		else
			$g_clndtime = substr($_POST['time'],6,4) . substr($_POST['time'],0,2) . substr($_POST['time'],3,2) . "0000";

	$sql = "UPDATE g_themeOptions set template='" . $_POST['template'] . "', timeType='" . $_POST['type'] . "', time='" . $g_clndtime . "', status='" . $_POST['status'] . "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents"><br><font style="font-size: 18px;"><strong>Success!!</strong></font><img src="/rap_admin/addons/GIS/themes/images/info48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		Product Theme Options Updated!</i><br>&nbsp;
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} else if ($_POST['action'] == "update" && $_POST['type'] == '0') {

	$sql = "UPDATE g_themeOptions set template='" . $_POST['template'] . "' where productid='" . $_POST['pid'] . "' AND timeType='999'";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents"><br><font style="font-size: 18px;"><strong>Success!!</strong></font><img src="/rap_admin/addons/GIS/themes/images/info48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		Product Theme Options Updated!</i><br>&nbsp;
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} else if ($_POST['action'] == "toggle") {

	$sql = "UPDATE g_themeOptions set status='" . $_POST['status'] . "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	
 	} else { 

	//If a message was passed in display the message in a green box.
	if ($_POST['message'] != "") { ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!!</strong></font>
        <br><font style="font-size: 14px;"><i>
        		<? echo $_POST['message']; ?></i><br>&nbsp;
        
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);

		</script>
<?	}

	}

	//load the global options
	$sql = "select * from g_themeOptions where productid='" . $_POST['pid'] . "' and timeType='999'";
	$g_glbrs=mysql_query($sql);
	if (mysql_num_rows($g_glbrs) == 0)
		{
		$sql = "insert into g_themeOptions (productid, timeType, status, template) VALUES ('" . $_POST['pid'] . "', '999', '0', 'default')";
		$g_glbrs=mysql_query($sql);
		$sql = "select * from g_themeOptions where productid='" . $_POST['pid'] . "' and timeType='999'";
		$g_glbrs=mysql_query($sql);
		}
		
	$g_glbrec = mysql_fetch_array($g_glbrs);
	
	if ($_POST['type'] == '0' && $_POST['action'] != 'savetype') {
		// This is teh fixed option, show template list and be done with it
		$g_globalType = 0;  ?>
		
		<table width="700"><tr bgcolor="#dac8b6" width="700"><td colspan="5"><input type="image" src="/rap_admin/addons/GIS/themes/images/save.png" name="submit" value="Save" onClick="javascript:aSave('<?= $productID; ?>');"/></td></tr><tr valign="top" align="left"><td valign="top" align="left"><br><font size="4" color="black" face=tahoma >Theme: </font></td><td>&nbsp;&nbsp;</td><td align="left">
		<br><select name="templates" size="10" id="templates" class="productslist" onClick="TemplateSelected(this.form)">
<?   
		$files1 = scandir("themes");

	
		foreach ( $files1 as $file ) {
 			if ($file != "." && $file != ".." ) {
 				if ($file == $g_glbrec['template']) { $selected = "SELECTED"; } else { $selected = ""; }
					echo "<option value=\"" . $file . "\" " . $selected . ">" . $file . "</option>";
				}
			}
		?>
 </select>
	</td><td></td><td><br><div id="tmp-preview"></div></td></tr>
	<tr><td>&nbsp;</td><td></td><td></td></tr>
	</table>
	
	<script type='text/javascript'>
	jQuery(document).ready(function() {
	TemplateSelected();
});
</script>
		
<?	} else if ($_POST['type'] == '1' && $_POST['action'] != 'savetype') {
		// This is the time of day setting, show list of time transitions
		$g_globalType = 1;   ?>
		
		<table width="700">
<tr><td colspan="9" align="right" bgcolor="#dac8b6"><a href="javascript:aDayAdd('<?= $productID; ?>');"><img src="addons/GIS/themes/images/add48x48.png" border="0"></a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr class="Prompts"><td class="Prompts"><strong>Time</strong></td><td></td><td align="left"><strong>Theme</strong></td><td></td><td><strong>Status</strong></td><td></td><td align="left"><strong>Options</strong></td></tr>
<?
 	$sql="select * from g_themeOptions where productID='" . $_POST['pid'] . "' and timeType='1' order by time";
	$gid=mysql_query($sql);
	if ( mysql_num_rows($gid) < 1 ) {
		echo "<tr><td colspan=\"9\"><div class=\"rounded-box-yellow\" id=\"message-box\">
    	    <div class=\"box-contents\">
    	    <br><font style=\"font-size: 18px;\"><strong>Not To Worry...</strong></font><img src=\"/rap_admin/addons/GIS/themes/images/info48x48.png\" align=\"right\"><br>
        <br><font style=\"font-size: 14px;\"><i>The are No Daily Time Entries for the Global Configuration.  Click the add button above to add one.
        		</i><br>&nbsp;
        
    		</div> 
		</div></td></tr>";
	} else {
		while ($grow = mysql_fetch_array($gid)) { 
			$g_timeFormatted = substr($grow['time'],0,2) . ":" . substr($grow['time'],2,2);
			switch ($grow['status']) {
				case '0':
					$ststxt = "Disabled";
					$stsbg = " bgcolor=\"#ee0000\"";
					$imgpth = "/rap_admin/addons/GIS/themes/images/red_button32x32.png";
					$toggleaction = "javascript:aToggleProdItem('" . $grow['uid'] . "', '1', '1', '" . $productID . "')";
					break;
				case '1':
					$ststxt = "Enabled";
					$stsbg = "";
					$imgpth = "/rap_admin/addons/GIS/themes/images/green_button32x32.png";
					$toggleaction = "javascript:aToggleProdItem('" . $grow['uid'] . "', '0', '1', '" . $productID . "')";
					break;
				case '2':
					$ststxt = "Active";
					$stsbg = " bgcolor=\"#00ee00\"";
					$imgpth = "/rap_admin/addons/GIS/themes/images/green_button32x32.png";
					$toggleaction = "javascript:aToggleProdItem('" . $grow['uid'] . "', '0', '1', '" . $productID . "')";
					break;
				} ?>
			<tr class="Prompts"><td><?= $g_timeFormatted ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><?= $grow['template']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="left"<?= $stsbg;?>><a href="#" onClick="<?= $toggleaction;?>"><img src="<?=$imgpth;?>" border="0" width="24" height="24"></a><?= $ststxt; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><a href="javascript:aEdit('<?= $grow['uid']; ?>')"><img src="addons/GIS/themes/images/edit32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aDelete('<?= $grow['uid']; ?>')"><img src="addons/GIS/themes/images/delete32x32.png" border="0"></a>&nbsp;</td>
  			</tr>
<? 			}
	} ?>  
  <tr><td>
  
</td></tr></table>
	
<? 	} else if ($_POST['type'] == '2' && $_POST['action'] != 'savetype') {
		// This is the date/time setting, show list of date/time transitions
		$g_globalType = 2; ?>
		
		<table width="700">
<tr><td colspan="9" align="right" bgcolor="#dac8b6"><a href="javascript:aDateAdd('<?= $productID; ?>');"><img src="addons/GIS/themes/images/add48x48.png" border="0"></a></td></tr>
<tr><td>&nbsp;</td></tr>

<tr class="Prompts"><td class="Prompts"><strong>Date / Time</strong></td><td></td><td align="left"><strong>Theme</strong></td><td></td><td><strong>Status</strong></td><td></td><td align="left"><strong>Options</strong></td></tr>
<?
 	$sql="select * from g_themeOptions where productID='" . $_POST['pid'] . "' and timeType='2' order by time";
	$gid=mysql_query($sql);
	if ( mysql_num_rows($gid) < 1 ) {
		echo "<tr><td colspan=\"9\"><div class=\"rounded-box-yellow\" id=\"message-box\">
    	    <div class=\"box-contents\">
    	    <br><font style=\"font-size: 18px;\"><strong>Not To Worry...</strong></font><img src=\"/rap_admin/addons/GIS/themes/images/info48x48.png\" align=\"right\"><br>
        <br><font style=\"font-size: 14px;\"><i>No Date / Time Entries were found for the Global Configuration.  Click the add button above to add one.
        		</i><br>&nbsp;
        
    		</div> 
		</div></td></tr>";
	} else {
		while ($grow = mysql_fetch_array($gid)) {
			if (strlen($grow['time']) == 12) 
				$g_timeFormatted = substr($grow['time'],4,2) . "/" . substr($grow['time'],6,2) . "/" . substr($grow['time'],0,4) . " " . substr($grow['time'],8,2) . ":" . substr($grow['time'],10,2);
			else
				$g_timeFormatted = substr($grow['time'],4,2) . "/" . substr($grow['time'],6,2) . "/" . substr($grow['time'],0,4);
				
			switch ($grow['status']) {
				case '0':
					$ststxt = "Disabled";
					$stsbg = " bgcolor=\"#ee0000\"";
					$imgpth = "/rap_admin/addons/GIS/themes/images/red_button32x32.png";
					$toggleaction = "javascript:aToggleProdItem('" . $grow['uid'] . "', '1', '2', '" . $productID . "')";
					break;
				case '1':
					$ststxt = "Enabled";
					$stsbg = "";
					$imgpth = "/rap_admin/addons/GIS/themes/images/green_button32x32.png";
					$toggleaction = "javascript:aToggleProdItem('" . $grow['uid'] . "', '0', '2', '" . $productID . "')";
					break;
				case '2':
					$ststxt = "Active";
					$stsbg = " bgcolor=\"#00ee00\"";
					$imgpth = "/rap_admin/addons/GIS/themes/images/green_button32x32.png";
					$toggleaction = "javascript:aToggleProdItem('" . $grow['uid'] . "', '0', '2', '" . $productID . "')";
					break;
				} ?>
			<tr class="Prompts"><td><?= $g_timeFormatted ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><?= $grow['template']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="left"<?= $stsbg;?>><a href="#" onClick="<?= $toggleaction;?>"><img src="<?=$imgpth;?>" border="0" width="24" height="24"></a><?= $ststxt; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><a href="javascript:aEditDate('<?= $grow['uid']; ?>')"><img src="addons/GIS/themes/images/edit32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aDelete('<?= $grow['uid']; ?>')"><img src="addons/GIS/themes/images/delete32x32.png" border="0"></a>&nbsp;</td>
  			</tr>
<? 			}
	} ?>  
  <tr><td>
  
</td></tr></table>

<?	} else if ($_POST['action'] != 'savetype' ) {
	$g_globalType = 999; ?>
	<div class="rounded-box-green" id="message-box">
    	<div class="box-contents">
        <br><font style="font-size: 18px;"><strong>It's All Good...</strong></font>
        <br><font style="font-size: 14px;"><i>
       	When using the Global Option, there are no additional settings that need to be completed.  Everything comes from the Global Options.</i><br>&nbsp;
        
    		</div> 
		</div>
<?
} else if ($_POST['action'] == 'savetype') {
	
	//also update the global type 
	$sql = "UPDATE g_themeOptions set status='" . $_POST['type'] . "' where uid='" . $g_glbrec['uid'] . "'";
	$gid=mysql_query($sql);
	echo "<input type=\"image\" src=\"/rap_admin/addons/GIS/themes/images/save.png\" name=\"submit\" value=\"Save\" onClick=\"javascript:aprTypeSave('" .  $productID . "');\"/>";
	}
		?>
		
		




