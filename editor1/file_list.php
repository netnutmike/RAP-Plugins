<?
//==============================================================================================
//
//	Filename:	file_list.php
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
//	Description:	This file is called when the Files accordian is opened. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/23/09 - Initial Version (JMM)
//
//==============================================================================================

function php4_scandir($dir,$listDirectories=false, $skipDots=true) {
    $dirArray = array();
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if (($file != "." && $file != "..") || $skipDots == true) {
                if($listDirectories == false) { if(is_dir($file)) { continue; } }
                array_push($dirArray,basename($file));
            }
        }
        closedir($handle);
    }
    return $dirArray;
}

?>

<script type="text/javascript">

function FileSelected(form) {

	if( jQuery('#fl-edit-content').is(':visible') ) {
	    // it's visible, do something
	    var answer = confirm ("You have a file open in the editor.  If you continue you will lose any changes you made in the editor.  If you are sure you want to continue, Click OK!")
			if (!answer)
				return;
	}
		
	jQuery('#Filename').html(jQuery('#files').val());
	var fln = jQuery('#files').val();

	jQuery.post("addons/GIS/editor/file_description.php", { flnm: fln},
			function(data){
				jQuery('#FileDescription').html(data);
		  	}
		);
	jQuery('#buttonrow').show();
	jQuery('#fl-edit-content').hide();
}

function aCopyFile() {
	
	var path = jQuery('#filepath').html();
	var fln = jQuery('#files').val();
	jQuery('#buttonrow').hide();
	jQuery('#Filename').html("Enter Name To Copy To Below:");
	
	jQuery.post("addons/GIS/editor/copy_file.php", { oath: path, flnm: fln},
			function(data){
				jQuery('#FileDescription').html(data);
			  }
		);
}

function aNewFile() {
	
	var path = jQuery('#filepath').html();
	var fln = jQuery('#files').val();
	jQuery('#buttonrow').hide();
	jQuery('#Filename').html("Enter Name Of New File Below:");
	
	jQuery.post("addons/GIS/editor/new_file.php", { oath: path, flnm: fln},
			function(data){
				jQuery('#FileDescription').html(data);
			  }
		);
}

function aEditFile() {
	
	var path = jQuery('#filepath').html();
	var fln = jQuery('#files').val();
	jQuery('#fl-edit-content').show();
	jQuery('#fl-edit-content').html(loadingimage);
	jQuery.post("addons/GIS/editor/file_edit.php", { oath: path, flnm: fln},
			function(data){
				jQuery('#fl-edit-content').html(data);
			  	}
			);
}

function aDeleteFile() {
	
	var path = jQuery('#filepath').html();
	var fln = jQuery('#files').val();
	jQuery('#buttonrow').hide();
	jQuery('#Filename').html("Are You Sure You Want To Delete This File?  This CANNOT Be Undone.");
	
	jQuery.post("addons/GIS/editor/delete_file.php", { oath: path, flnm: fln},
			function(data){
				jQuery('#FileDescription').html(data);
			  }
		);
}
</script>

<?
	//If an error message was passed in then display the error message in a red box.
	if ($_POST['errormessage'] != "") { ?>
		<div class="rounded-box-red" id="error-box">
    	    <div class="box-contents">
        <? echo $_POST['errormessage']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#error-box').effect("pulsate", { times:3 }, 2000);
			jQuery('#error-box').fadeOut(10000);
		</script>
<?	} 

	//If a message was passed in display the message in a green box.
	if ($_POST['message'] != "") { ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        <? echo $_POST['message']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">

			jQuery('#message-box').fadeOut(20000);

		</script>
<?	} ?>

<div class="rounded-box">
    <!-- Content -->
    <div class="box-contents">
        Using the Editor is very simple, in the box below you will see a list of files that are currently in your templates folder.  Select a file then on the right you will have options to perform on the file.
    </div> <!-- end div.box-contents -->
</div> <!-- end div.rounded-box -->
<br><br>

<table><tr><td>
<div id='filelist'>

<select name="files" size="10" id="files" class="fileslist" onClick="FileSelected(this.form)">
   
<?php 
	//Build a list of files in the select list by looping through all the files in the directory.
	
	if (phpversion() < "5.0.0")
		$files1 = php4_scandir($_POST['oath']);
	else
		$files1 = scandir($_POST['oath']);

	foreach ( $files1 as $file ) {
 		if ($file != "." && $file != ".." )
			echo "<option value=\"" . $file . "\">" . $file . "</option>";
		}

?>
 </select><br></br>
 <a href="javascript:aNewFile();" id="newfile"><img src="addons/GIS/editor/images/add.png" alt="Create a new blank file." border="0"></a>
</div></td><td valign="top">

<div id='filedetails'>
<table><tr><td>
	<div id="Filename">
	Select A File
	</div></td></tr>
	<tr><td>
	<div id="FileDescription">
	<---- Select a file on the left to edit, copy or delete it.
	</div>
	</td></tr>
	<tr><td>
	<div id="buttonrow" style="display:none">
	<a href="javascript:aEditFile();" id="editfile"><img src="addons/GIS/editor/images/edit.png" alt="Edit the Selected File With the HTML Editor" border="0"></a><a href="javascript:aCopyFile();" id="copyfile"><img src="addons/GIS/editor/images/copy.png" alt="Copy the selected file to a new file" border="0"></a><a href="javascript:aDeleteFile();" id="copyfile"><img src="addons/GIS/editor/images/delete.png" alt="Delete the selected file, This cannot be undone" border="0">
	</div>
	</td></tr></table>
</div>
</td></tr></table>

<!-- Used so that I can read the file path later, this will never get displayed -->
<div id="filepath" style="display:none"><?php echo $_POST['oath']; ?></div>

