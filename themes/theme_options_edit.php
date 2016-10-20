<?php 

//==============================================================================================
//
//	Filename:	theme_options_edit.php
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
//	Version:	1.0.0 (March 20th, 2010)
//
//	Change Log:
//				03/20/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); ?>

<script language="JavaScript">

function editTemplateSelected(form) {
	
	var tmpname = jQuery('#templates').val();
	jQuery('#file-list').html(loadingimage);

	jQuery.post("addons/GIS/themes/filelist.php", { tmpname: tmpname},
			function(data){
				jQuery('#file-list').html(data);
		  	}
		);

	jQuery('#grnarrow').show();
}


</script>

<? 

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
<?	
}
	
	if ($_POST['type'] == '2') {
		// This is the edit option
		
		  ?>
		
		<table width="700"><tr valign="top" align="left"><td valign="top" align="left" width="30"><br><font size="4" color="black" face=tahoma >Theme: </font></td><td>&nbsp;&nbsp;</td><td align="left">
		<table><tr><td>
		<br><select name="templates" size="10" id="templates" class="productslist" onClick="editTemplateSelected(this.form)">
<?   
		$files1 = scandir("themes");

	
		foreach ( $files1 as $file ) {
 			if ($file != "." && $file != ".." ) {
 				if ($file == $g_glbrec['template']) { $selected = "SELECTED"; } else { $selected = ""; }
					echo "<option value=\"" . $file . "\" " . $selected . ">" . $file . "</option>";
				}
			}
		?>
 	</select>
	</td><td align="left" width="15" valign="middle"><div id="grnarrow" style='display:none;'><img src="/rap_admin/addons/GIS/themes/images/next64x64.png"></div></td><td align="left"><br><div id="file-list"></div></td></tr></table></td></tr>
	<tr><td>&nbsp;</td><td></td><td></td></tr>
	</table>
	<div id="fl-edit-content" style='display:none;'></div>
	<script type='text/javascript'>
	jQuery(document).ready(function() {
	TemplateSelected();
});
</script>
		
<?		
	} else if ($_POST['type'] == '1') {
		// This is the Upload Setting
		   ?>
		   <iframe src="/rap_admin/addons/GIS/themes/uploadtheme.php" width="100%" height="300" frameborder="0"></iframe>
		
	
<? 	} else  {
		// This is the default get themes area
		
		$flnm = fopen("http://www.rapthemes.com/themesaddon/inprod.php","r");
		$contents = "";
		
		while (!feof($flnm)) {
  			$contents .= fread($flnm, 8192);
		}
		echo $contents;
		
		fclose($flnm);
	}
		?>

