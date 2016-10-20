<?php 

//==============================================================================================
//
//	Filename:	filelist.php
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

function editFileSelected(form) {
	
	var tmpname = jQuery('#templates').val();
	var filename = jQuery('#filelist2').val();

	jQuery("#fl-edit-content").html(loadingimage);

	jQuery.post("addons/GIS/themes/editfile.php", { tmpname: tmpname, filename: filename},
			function(data){
				jQuery('#fl-edit-content').html(data);
		  	}
		);

	jQuery("#fl-edit-content").show();
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
		}  ?>
	

		
		<select name="templatefiles" size="10" id="filelist2" class="productslist" onClick="editFileSelected(this.form)">
<?   
		$files1 = scandir("themes/" . $_POST['tmpname'] );

	
		foreach ( $files1 as $file ) {
 			if ($file != "." && $file != ".." ) {
 				if ($file == $g_glbrec['template']) { $selected = "SELECTED"; } else { $selected = ""; }
					echo "<option value=\"" . $file . "\" " . $selected . ">" . $file . "</option>";
				}
			}
		?>
 	</select>
		
