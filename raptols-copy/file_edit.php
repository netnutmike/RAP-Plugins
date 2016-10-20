<?
//==============================================================================================
//
//	Filename:	file_edit.php
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
//	Description:	This file is called when the user selects a page to edit
//
//	Version:	1.0.0 (February 9th, 2010)
//
//	Change Log:
//				02/09/10 - Initial Version (JMM)
//
//==============================================================================================
?>

<?php  require_once("../../../settings.php"); 

function g_getTemplateFolder($productID) {

	$q = "SELECT * FROM products WHERE id = '$productID'";
	$result = mysql_query ($q);
	$row = mysql_fetch_assoc ($result);
	mysql_free_result ($result);

	$pname = $row['item_name'];

	$itemname = $row['item_name'];
	$itemdownload = $row['item_download'];
	$install_folder = $row['install_folder'];
	$tmpl_folder = $row['tmpl_folder'];
	//assuming rap_admin is always in the root, read backward one directory at a time until we find it.  Then prepend that to 
	//the install folder to get back to the root from where we are now.
	$g_prepnd = "";
	$g_sftycnt = 0;
	do {
		$g_prepnd .= "../";
		++$g_sftycnt;
	} while (!file_exists($g_prepnd . "rap_admin") && $g_sftycnt <= 10);
	$template_path = $g_prepnd . $install_folder . $tmpl_folder;

	return $template_path;

}
?>

<script language="JavaScript">

function aCancel() {
	jQuery('#fl-edit-content').hide();
}

function aSave() {

	tinyMCE.activeEditor.save();
	var oath =	"<? echo $_POST['oath']; ?>";
	var flnm =	"<? echo $_POST['flnm']; ?>";
	var data =	jQuery("#elm1").val();
	var data = data.replace(/&lt;.\?/g, "\x3C?");
	var data = data.replace(/\?&gt;/g, "?\x3E");
	var action = "1";
	jQuery.post("addons/GIS/editor/file_edit.php", { oath: oath, flnm: flnm, data: data, action: action },
					function(data){
						jQuery('#fl-edit-content').html(data);
				  	}
				);
}

function aSaveClose() {

	tinyMCE.activeEditor.save();
	var oath =	"<? echo $_POST['oath']; ?>";
	var flnm =	"<? echo $_POST['flnm']; ?>";
	var data =	jQuery("#elm1").val();
	var data = data.replace(/&lt;.\?/g, "\x3C?");
	var data = data.replace(/\?&gt;/g, "?\x3E");
	var action = "2";
	jQuery.post("addons/GIS/editor/file_edit.php", { oath: oath, flnm: flnm, data: data, action: action },
					function(data){
						jQuery('#fl-edit-content').html(data);
				  	}
				);
	jQuery('#fl-edit-content').hide();
}

</script>

<script type="text/javascript">
	 tinyMCE.init({
		// General options
		mode : "exact",
		theme : "advanced",
		elements : "elm1",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "addons/GIS/editor/css/content.css",
		
		height : 600,
		width  : 700

	});
</script>




		
<? 	if ($_POST['pid'] != "" && $_POST['flnm'] != ""  && $_POST['flnm'] != "undefined") {
	
	$sourcefile = g_getTemplateFolder($_POST['pid']) . $_POST['flnm'];
	echo $sourcefile . "<br>" . $_POST['action'] . "<br>" . $_POST['data'];
	
 	if ($_POST['action'] == 1 || $_POST['action'] == 2) {
		// save file
		file_put_contents($sourcefile,stripslashes($_POST['data']));
		} 

	if ($_POST['action'] == 2) {
		echo "<script language=\"JavaScript\"> 
		var pathv =	\"" . $_POST['oath'] . "\"; 
		var message =	\"File Successfuly Saved\"; 
		jQuery.post(\"addons/GIS/editor/file_list.php\", { oath: pathv, message: message }, 
					function(data){ 
						jQuery('#fl-mgmt-dis').html(data); 
				  	} 
				); 
		</script>";
		} ?>	
		
<?	if ($_POST['action'] == 1) { ?>
		<div class="rounded-box-green" id="fil-sav-msg">
    	    <div class="box-contents">
        File Saved!
    		</div> 
		</div>
		<script type="text/javascript">
			
			jQuery('#fil-sav-msg').fadeOut(20000);
		</script>
<?	} ?>
	


<textarea id="elm1" name="elm1">
<? 
	$filecontents = file_get_contents($sourcefile); 
	$lookfor = chr(60) . "?";
	$filecontents = str_replace($lookfor, "&lt;.?",$filecontents);
	echo htmlentities($filecontents); 
?>
</textarea>
<br>
<table><tr><td>
<input type="button" name="submit" id="submit" value="Save" onClick="javascript:aSave();"/></td><td>
<input type="button" name="submit" id="submit" value="Save/Close" onClick="javascript:aSaveClose();" style="width:250"/></td><td>
<input type="button" name="cancel" id="cancel" value="Don't Save" onClick="javascript:aCancel();" /></td></tr></table>
<br><br>

<? } else { ?>


Before you can edit a file you need to select a file from the file list above.

<? } ?>