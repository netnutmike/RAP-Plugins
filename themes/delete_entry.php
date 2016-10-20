<?
//==============================================================================================
//
//	Filename:	delete_link.php
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
//	Description:	This file is called when the user wants to delete a file and confirms 
//	the delete request.
//
//	Version:	1.0.0 (February 16th, 2009)
//
//	Change Log:
//				02/16/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); 

if ($_POST['returnto'] != "")
	$g_returnto = $_POST['returnto'];
else
	$g_returnto = "testimonials.php";
?>

<script language="JavaScript">

function aDeleteCancel() {

	jQuery.post("addons/GIS/themes/global_options_edit.php", { type: '1' },
					function(data){
						jQuery('#gl-opt-disp-set').html(data);
				  	}
				);
}


function aDeleteDelete(uid, type) {
	
	jQuery.post("addons/GIS/themes/global_options_edit.php", { uid: uid, action: "delete", type: type },
					function(data){
						jQuery('#gl-opt-disp-set').html(data);
				  	}
				);
}

</script>

<?
	$sql="select * from g_testimonials where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
?>
<br><br>
		<div class="rounded-box-red" id="message-box">
    	    <div class="box-contents">
        		<br><font style="font-size: 24px;"><strong>WARNING!!</strong></font><img src="/rap_admin/addons/GIS/themes/images/warning64x64.png" align="right">
        <br><br><font style="font-size: 14px;"><i>
        		<p class="georgia-medium">You are about to delete an entry from the themes schedule.</strong>.</p>

<br><p class="georgia-medium">If you are sure you want to continue to delete this theme schedule entry click the <strong>Yes, I Am Sure</strong> button below.</p><br></i><br>&nbsp;
    		</div> 
		</div>
<br> 
<table width="100%">
  <tr><td>
  
  <table width="100%"><tr valign="center"><td valign="center">
<input type="image" name="submit" src="/rap_admin/addons/GIS/themes/images/block64x64.png" value="Don't Do It" onClick="javascript:aDeleteCancel();"/> <font style="font-size: 18px;">NO, Don't Do It!</font>
</td><td align="right">
<font style="font-size: 18px;">Yes, I am Sure, Delete: </font><input type="image" name="cancel" src="/rap_admin/addons/GIS/themes/images/delete48x48.png" value="Yes, I Am Sure, Delete" onClick="javascript:aDeleteDelete('<?= $_REQUEST['uid']; ?>','<?= $_REQUEST['type']; ?>');" />
</td></tr></table>
</td></tr></table>

