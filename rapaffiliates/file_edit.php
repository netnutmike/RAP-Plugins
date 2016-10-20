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
//	Copyright:	Copyright, 2009(c), Genius Idea Studio, LLC
//
//	Product Is Available For Download From www.rap-tools.com
//
//	Description:	This file is called when the edit button is pressed or the editor 
//					accordion is opened. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/23/09 - Initial Version (JMM)
//
//==============================================================================================
?>

<?php  require_once("../../../settings.php"); ?>

<script language="JavaScript">

function TagSelected(form) {

	var tt = (jQuery('#tags :selected').text());
		
	jQuery('#Tagname').html(tt.replace("<","&lt;"));
	var fln = jQuery('#tags').val();

	jQuery.post("addons/GIS/editor/token_description.php", { tag: fln},
			function(data){
				jQuery('#TagDescription').html(data);
		  	}
		);
	jQuery('#TagbRow').show();

}

function aInsertTag() {
	
	var tt = (jQuery('#tags :selected').text());
	var tt = tt.replace("\x3C?", "&lt;.?");
	//var tt = tt.replace("?>", "...)");

	tinyMCE.execCommand('mceInsertRawHTML',false,tt);
	
}

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




		
<? 	if ($_POST['oath'] != "" && $_POST['flnm'] != ""  && $_POST['flnm'] != "undefined") {
	
	$sourcefile = $_POST['oath'] . $_POST['flnm'];
	//echo $sourcefile . "<br>" . $_POST['action'] . "<br>" . $_POST['data'];
	
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
			jQuery('#fil-sav-msg').effect("pulsate", { times:3 }, 2000);
			jQuery('#fil-sav-msg').fadeOut(10000);
		</script>
<?	} ?>
	


<div id="elm1" name="elm1">
<? 
	$filecontents = file_get_contents($sourcefile); 
	$lookfor = chr(60) . "?";
	$filecontents = str_replace($lookfor, "&lt;.?",$filecontents);
	//file_put_contents("testfile.html",$filecontents);
	echo $filecontents;
?>
</div>
<br>
<table><tr><td>
<input type="button" name="submit" id="submit" value="Save" onClick="javascript:aSave();"/></td><td>
<input type="button" name="submit" id="submit" value="Save/Close" onClick="javascript:aSaveClose();" style="width:250"/></td><td>
<input type="button" name="cancel" id="cancel" value="Don't Save" onClick="javascript:aCancel();" /></td></tr></table>
<br><br>
<div class="rounded-box">
    <!-- Content -->
    <div class="box-contents">
        Insert common tokens into your template from the list below.
    </div> <!-- end div.box-contents -->
</div>
<table><tr><td>
<div id='taglist'>
<select name="tags" size="10" id="tags" class="fileslist" onClick="TagSelected(this.form)">
   
<?php 
	$sqlt="select * from tokens";
	$tokn=mysql_query($sqlt);
	while ($trow=mysql_fetch_array($tokn)) {
		echo "<option value=\"" . $trow['uid'] . "\">" . str_replace("<", "&lt;",$trow['tag']) . "</option>";
		}

?>
 </select>
</div></td><td valign="top">

<div id='tagdetails'>
<table><tr><td>
	<div id="Tagname">
	Select A Token
	</div></td></tr>
	<tr><td>
	<div id="TagDescription">
	<---- Select a token on the left to insert it into your text.  Place the cursor where you want to insert it first, then select the token and click the insert button below.  Please note that tokens when inserted into the editor will have <.? in the beginning but when saved are saved properly.
	</div>
	</td></tr>
	<tr><td>
	<div id="TagbRow" style="display:none">
	<a href="javascript:aInsertTag();" id="inserttag"><img src="addons/GIS/editor/images/add.png" alt="Insert the Selected Tag/Token into the current location of the editor." border="0"></a>
	</div>
	</td></tr></table>
</div>
</td></tr></table>
<? } else { ?>


Before you can edit a file you need to select a file from the file list above.

<? } ?>