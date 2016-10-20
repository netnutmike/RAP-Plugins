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

	var pid = jQuery('#products').val();
	jQuery.post("addons/GIS/testimonials/<?= $g_returnto?>", { pid: pid },
			function(data){
				jQuery('#pr-opt-disp').html(data);
		  	}
		);
}

function aDeleteDelete(uid) {
	
	var pid = jQuery('#products').val();
	jQuery.post("addons/GIS/testimonials/<?= $g_returnto?>", { uid: uid, action: "Delete", pid: pid },
					function(data){
						jQuery('#pr-opt-disp').html(data);
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
<p class="georgia-medium">You are about to delete a testimonial from <strong><?= $grow['Name']?></strong> with the subject of <strong><?= $grow['ShortSubject']?></strong>.</p>

<br><p class="georgia-medium">If you are sure you want to continue to delete this testimonial click the <strong>Yes, I Am Sure</strong> button below.</p><br><br> 
<table>
  <tr><td>
  
  <table><tr><td>
<input type="button" name="submit" id="submit" value="Don't Do It" onClick="javascript:aDeleteCancel();"/>
</td><td>
<input type="button" name="cancel" id="cancel" value="Yes, I Am Sure, Delete" onClick="javascript:aDeleteDelete('<?= $_REQUEST['uid']; ?>');" />
</td></tr></table>
</td></tr></table>

