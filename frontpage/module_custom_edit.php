<?php 

//==============================================================================================
//
//	Filename:	module_custom_edit.php
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
//	Description:	This file is called to edit the custom module code
//
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				02/17/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); 

if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_FPModules set CustomCode='" . $_POST['CustomCode'] . "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/clickbank/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Custom Module Updated!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} ?>

<script language="JavaScript">

function aSaveatc() {

	var CustomCode =	jQuery("#CustomCode").val();

	jQuery('#ModuleDescription').html(loadingimage);
	
	jQuery.post("addons/GIS/frontpage/module_custom_edit.php", { uid: <?= $_REQUEST['uid']?>, CustomCode: CustomCode, action: "Update" },
					function(data){
						jQuery('#ModuleDescription').html(data);
				  	}
				);
}

</script>

<?
	$sql="select * from g_FPModules where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
	
?>
<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Edit Custom Module HTML Code</p>";
		
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts">

 	<input type="image" src="/rap_admin/addons/GIS/frontpage/images/save.png" name="submit" value="Save" onClick="javascript:aSaveatc();"/><br>&nbsp;&nbsp;Save
 	</td><td></td><td align="right" class="Prompts"></td></tr>
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table>
 	<tr><td colspan="3"><textarea name="CustomCode" id="CustomCode" rows=10 cols=80><?= $grow['CustomCode'];?></textarea></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	

 		<tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td colspan="3">
  
 

</td></tr></table>
<div class='gis-content padding-rl-20' id="atc-opt-disp"></div>

