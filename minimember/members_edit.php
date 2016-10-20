<?php 

//==============================================================================================
//
//	Filename:	members_edit.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2010(c), Genius Idea Studio, LLC
//
//	Member Is Available For Download From www.rap-tools.com
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


function aEditMember(uid) {

	jQuery('#pr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/minimember/edit_auto_prod.php", { uid: uid, action: 'edit' },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aToggleItem(uid, status, type) {

	jQuery('#pr-opt-disp').html(loadingimage);
	
	jQuery.post("addons/GIS/minimember/Member_options_edit.php", { uid: uid, action: 'toggle', status: status },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aDeleteMember(uid) {

	jQuery('#pr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/minimember/delete_entry_prod.php", { uid: uid },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}


</script>


<?
 	if ($_POST['action'] == "update") {
			
	$sql = "UPDATE g_Members set Name='" . $_POST['Name'] . "', optionText='" . $_POST['optionText'] . "', status='" . $_POST['status'] . "', Groupcode='" . $GroupCode . "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents"><br><font style="font-size: 18px;"><strong>Success!!</strong></font><img src="/rap_admin/addons/GIS/minimember/images/info48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		Member Updated!</i><br>&nbsp;
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?
	} else if ($_POST['action'] == "delete") {
		$sql = "DELETE from g_Members where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql); ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        		<br><font style="font-size: 18px;"><strong>Success!!</strong></font><img src="/rap_admin/addons/GIS/minimember/images/info48x48.png" align="right">
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

	$sql = "UPDATE g_minimemberOptions set status='" . $_POST['status'] . "' where uid='" . $_POST['uid'] . "'";
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
<tr><td colspan="9" align="right" bgcolor="#dac8b6"></td></tr>
<tr><td>&nbsp;</td></tr>

<tr class="Prompts"><td class="Prompts"><strong>Email</strong></td><td></td><td align="center"><strong>Created</strong></td><td></td><td align="center"><strong>Last Login</strong></td><td></td><td align="left"><strong>Options</strong></td></tr>
<?
 	$sql="select * from g_Members";
	$gid=mysql_query($sql);
	if ( mysql_num_rows($gid) < 1 ) {
		echo "<tr><td colspan=\"9\"><div class=\"rounded-box-yellow\" id=\"message-box\">
    	    <div class=\"box-contents\">
    	    <br><font style=\"font-size: 18px;\"><strong>Not To Worry...</strong></font><img src=\"/rap_admin/addons/GIS/minimember/images/info48x48.png\" align=\"right\"><br>
        <br><font style=\"font-size: 14px;\"><i>No Member Entries were found.  New members will be added automatically as sales are made.
        		</i><br>&nbsp;
        
    		</div> 
		</div></td></tr>";
	} else {
		while ($grow = mysql_fetch_array($gid)) { ?>
			<tr class="Prompts"><td><?= $grow['email']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['createdDate']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['lastLogin']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><a href="javascript:aEditMember('<?= $grow['uid']; ?>')"><img src="addons/GIS/minimember/images/edit32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aDeleteMember('<?= $grow['uid']; ?>')"><img src="addons/GIS/minimember/images/delete32x32.png" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:aShowOrders('<?= $grow['uid']; ?>')"><img src="addons/GIS/minimember/images/delete32x32.png" border="0"></a>&nbsp;</td>
  			</tr>
<? 			}
	} ?>  
  <tr><td>
  
</td></tr></table>
