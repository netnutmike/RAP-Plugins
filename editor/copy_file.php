<?
//==============================================================================================
//
//	Filename:	copy_file.php
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
//	Description:	This file is called when the user wants to copy a file. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/23/09 - Initial Version (JMM)
//
//==============================================================================================
?>

<script language="JavaScript">

function aCopyCancel() {

	var pathv =	jQuery("#fl-path").html();
	jQuery.post("addons/GIS/editor/file_list.php", { oath: pathv },
					function(data){
						jQuery('#fl-mgmt-dis').html(data);
				  	}
				);
}

function aCopyCopy() {

	var pathv =	jQuery("#pathv").val();
	var orfl =	jQuery("#orfl").val();
	var toname =	jQuery("#toname").val();
	jQuery.post("addons/GIS/editor/copy_file.php", { toname: toname, pathv: pathv, orfl: orfl },
					function(data){
						jQuery('#fl-mgmt-dis').html(data);
				  	}
				);
}

</script>

<? if ($_POST['pathv'] != "" && $_POST['orfl'] != "") {
	$sourcefile = $_POST['pathv'] . $_POST['orfl'];
	$destfile = $_POST['pathv'] . $_POST['toname'];
	if (!copy($sourcefile, $destfile)){
		$errormessage="Unable To Copy File!";
		$message="";
	} else {
		$message="File Copied Successfully!";
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

<form id="copyfile" name="copyfile" method="post" action="addons/GIS/editor/copy_file.php">
<table>
<tr><td>
 
    <input type="text" name="toname" id="toname">
    <input type="hidden" name="pathv" id="pathv" value="<?php  echo $_POST['oath']; ?>">
    <input type="hidden" name="orfl" id="orfl" value="<?php  echo $_POST['flnm']; ?>">
  </td></tr>
  <tr><td>
  
 
</form>
<Table><tr><td>
<input type="button" name="submit" id="submit" value="Copy" onClick="javascript:aCopyCopy();"/>
</td><td>
<input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:aCopyCancel();" />
</td></tr></table>
</td></tr></table>

<? } ?>