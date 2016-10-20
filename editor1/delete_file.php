<?
//==============================================================================================
//
//	Filename:	delete_file.php
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
//	Description:	This file is called when the user wants to delete a file and confirms 
//	the delete request.
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/23/09 - Initial Version (JMM)
//
//==============================================================================================
?>

<script language="JavaScript">

function aDeleteCancel() {

	var pathv =	jQuery("#fl-path").html();
	jQuery.post("addons/GIS/editor/file_list.php", { oath: pathv },
					function(data){
						jQuery('#fl-mgmt-dis').html(data);
				  	}
				);
}

function aDeleteDelete() {

	var pathv =	jQuery("#pathv").val();
	var orfl =	jQuery("#orfl").val();
	var toname =	jQuery("#toname").val();
	jQuery.post("addons/GIS/editor/delete_file.php", { toname: toname, pathv: pathv, orfl: orfl },
					function(data){
						jQuery('#fl-mgmt-dis').html(data);
				  	}
				);
}

</script>

<? if ($_POST['pathv'] != "" && $_POST['orfl'] != "") {
	$sourcefile = $_POST['pathv'] . $_POST['orfl'];
	if (!unlink($sourcefile)){
		$errormessage="Unable To Delete File!";
		$message="";
	} else {
		$message="File Deleted Successfully!";
		$errormessage="";
	}
	echo "<script language=\"JavaScript\"> 
	var pathv =	\"" . $_POST['pathv'] . "\"; 
	var message =	\"" . $message . "\"; 
	var errormessage =	\"" . $errormessage . "\"; 
	jQuery.post(\"addons/GIS/editor/file_list.php\", { oath: pathv, message: message, errormessage: errormessage }, 
					function(data){ 
						jQuery('#fl-mgmt-dis').html(data); 
				  	} 
				); 
		</script>";
} else { ?>

file: <? echo $_POST['flnm']; ?>

<table>
<tr><td>
 
     <input type="hidden" name="pathv" id="pathv" value="<?php  echo $_POST['oath']; ?>">
    <input type="hidden" name="orfl" id="orfl" value="<?php  echo $_POST['flnm']; ?>">
  </td></tr>
  <tr><td>
  
  <table><tr><td>
<input type="button" name="submit" id="submit" value="Don't Do It" onClick="javascript:aDeleteCancel();"/>
</td><td>
<input type="button" name="cancel" id="cancel" value="Yes, I Am Sure, Delete" onClick="javascript:aDeleteDelete();" />
</td></tr></table>
</td></tr></table>

<? } ?>