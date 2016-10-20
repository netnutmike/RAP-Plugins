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
//	Version:	1.0.0 (March 26th, 2010)
//
//	Change Log:
//				03/26/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); ?>

<script language="JavaScript">


function aGlobalAdd() {

	jQuery('#gl-opt-disp').html(loadingimage);

	jQuery.post("addons/GIS/autooptin/edit_auto.php", { action: 'new' },
					function(data){
						jQuery('#gl-opt-disp').html(data);
				  	}
				);
}

function aEditGlobal(uid) {

	jQuery('#gl-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/autooptin/edit_auto.php", { uid: uid, action: 'edit' },
					function(data){
						jQuery('#gl-opt-disp').html(data);
				  	}
				);
}

function aToggleItem(uid, status, type) {

	var template =	jQuery("#templates").val();
	jQuery('#gl-opt-disp').html(loadingimage);
	
	jQuery.post("addons/GIS/autooptin/global_options_edit.php", { uid: uid, action: 'toggle', status: status },
					function(data){
						jQuery('#gl-opt-disp').html(data);
				  	}
				);
}

function aDeleteGlobal(uid) {

	jQuery('#gl-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/autooptin/delete_entry.php", { uid: uid },
					function(data){
						jQuery('#gl-opt-disp').html(data);
				  	}
				);
}
</script>


<?
	if ($_POST['action'] == "insert") {
		if ($_POST['GroupCode'] == '0') {
			$sql = "insert into g_autoResponderGroups (GroupCode, GroupName) VALUES ('" . $_POST['NewGroupShort'] . "', '" . $_POST['NewGroup'] . "')";
			$gid=mysql_query($sql);
			$GroupCode = $_POST['NewGroupShort'];
		} else 
			$GroupCode = $_POST['GroupCode'];
		
		$sql = "insert into g_autoResponderOptions (productid, Name, optionText, status, GroupCode) VALUES ('0','" . $_POST['Name'] . "', '" . $_POST['optionText'] . "', '1', '" . $GroupCode . "')";
		$gid=mysql_query($sql); ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        		<br><font style="font-size: 18px;"><strong>Good News!!</strong></font><img src="/rap_admin/addons/GIS/autooptin/images/info48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		New Record for the Global Auto Opt-in Options Has Been Inserted...
        		</i><br>&nbsp;
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} else if ($_POST['action'] == "update") {

	if ($_POST['GroupCode'] == '0') {
			$sql = "insert into g_autoResponderGroups (GroupCode, GroupName) VALUES ('" . $_POST['NewGroupShort'] . "', '" . $_POST['NewGroup'] . "')";
			$gid=mysql_query($sql);
			$GroupCode = $_POST['NewGroupShort'];
		} else 
			$GroupCode = $_POST['GroupCode'];
	
	$sql = "UPDATE g_autoResponderOptions set Name='" . $_POST['Name'] . "', optionText='" . $_POST['optionText'] . "', status='" . $_POST['status'] . "', GroupCode='" . $GroupCode . "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents"><br><font style="font-size: 18px;"><strong>Success!!</strong></font><img src="/rap_admin/addons/GIS/autooptin/images/info48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		Global Auto Opt-in Options Updated!</i><br>&nbsp;
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?
	} else if ($_POST['action'] == "delete") {
		$sql = "DELETE from g_autoResponderOptions where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql); ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        		<br><font style="font-size: 18px;"><strong>Success!!</strong></font><img src="/rap_admin/addons/GIS/autooptin/images/info48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		The Record Has Been Deleted...</i><br>&nbsp;
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
		
<?
	} else if ($_POST['action'] == "toggle") {

	$sql = "UPDATE g_autoResponderOptions set status='" . $_POST['status'] . "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	
 	}
	
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
 ?>

		
		<table width="700">
<tr><td colspan="9" align="right" bgcolor="#dac8b6"><a href="javascript:aGlobalAdd();"><img src="addons/GIS/autooptin/images/add48x48.png" border="0"></a></td></tr>
<tr><td>&nbsp;</td></tr>

<tr class="Prompts"><td class="Prompts"><strong>Name</strong></td><td></td><td><strong>Status</strong></td><td></td><td align="left"><strong>Options</strong></td></tr>
<?
 	$sql="select * from g_autoResponderOptions where productID='0'";
	$gid=mysql_query($sql);
	if ( mysql_num_rows($gid) < 1 ) {
		echo "<tr><td colspan=\"9\"><div class=\"rounded-box-yellow\" id=\"message-box\">
    	    <div class=\"box-contents\">
    	    <br><font style=\"font-size: 18px;\"><strong>Not To Worry...</strong></font><img src=\"/rap_admin/addons/GIS/autooptin/images/info48x48.png\" align=\"right\"><br>
        <br><font style=\"font-size: 14px;\"><i>No Auto Opt-in Entries were found for the Global Configuration.  Click the add button above to add one.
        		</i><br>&nbsp;
        
    		</div> 
		</div></td></tr>";
	} else {
		while ($grow = mysql_fetch_array($gid)) {
			
			switch ($grow['status']) {
				case '0':
					$ststxt = "Disabled";
					$stsbg = " bgcolor=\"#FFEEEE\"";
					$imgpth = "/rap_admin/addons/GIS/autooptin/images/red_button32x32.png";
					$toggleaction = "javascript:aToggleItem('" . $grow['uid'] . "', '1', '2')";
					break;
				case '1':
					$ststxt = "Enabled";
					$stsbg = "";
					$imgpth = "/rap_admin/addons/GIS/autooptin/images/green_button32x32.png";
					$toggleaction = "javascript:aToggleItem('" . $grow['uid'] . "', '0', '2')";
					break;
				case '2':
					$ststxt = "Active";
					$stsbg = "";
					$imgpth = "/rap_admin/addons/GIS/autooptin/images/green_button32x32.png";
					$toggleaction = "javascript:aToggleItem('" . $grow['uid'] . "', '0', '2')";
					break;
				} ?>
			<tr class="Prompts"><td><?= $grow['Name']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="left"<?= $stsbg;?>><a href="#" onClick="<?= $toggleaction;?>"><img src="<?=$imgpth;?>" border="0" width="24" height="24"></a><?= $ststxt; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><a href="javascript:aEditGlobal('<?= $grow['uid']; ?>')"><img src="addons/GIS/autooptin/images/edit32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aDeleteGlobal('<?= $grow['uid']; ?>')"><img src="addons/GIS/autooptin/images/delete32x32.png" border="0"></a>&nbsp;</td>
  			</tr>
<? 			}
	} ?>  
  <tr><td>
  
</td></tr></table>
