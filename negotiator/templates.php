<?php 

//==============================================================================================
//
//	Filename:	templates.php
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
//	Description:	This file is called to provide a file description from the database. 
//
//	Version:	1.0.0 (February 18th, 2010)
//
//	Change Log:
//				02/18/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); ?>

<script language="JavaScript">
function aSave(uid) {

	var Template = jQuery("#templates").val();
	var pid = jQuery('#products').val();
	jQuery.post("addons/GIS/testimonials/templates.php", { pid: pid, Template: Template, action: "Update" },
					function(data){
						jQuery('#ProductTemplate').html(data);
				  	}
				);
}

function TemplateSelected(form) {
	
	var tmpname = jQuery('#templates').val();

	jQuery.post("addons/GIS/testimonials/tmp_preview.php", { tmpname: tmpname},
			function(data){
				jQuery('#tmp-preview').html(data);
		  	}
		);
}
</script>

<?

	$sql="select * from g_testimonialOptions where productID='" . $_POST['pid'] . "'";
	$flnm=mysql_query($sql);
	if (mysql_num_rows($flnm) < 1) {
		$sql="insert into g_testimonialOptions (productID) VALUES ('" . $_POST['pid'] . "')";
		$flnm=mysql_query($sql);
		$sql="select * from g_testimonialOptions where productID='" . $_POST['pid'] . "'";
		$flnm=mysql_query($sql);
	}
	$frow=mysql_fetch_array($flnm);
	
	if ($_POST['action'] == "Update" ) {

		$sql = "UPDATE g_testimonialOptions set Template='" . $_POST['Template'] . "' where productID='" . $_POST['pid'] . "'";
		$gid=mysql_query($sql);
		$sql="select * from g_testimonialOptions where productID='" . $_POST['pid'] . "'";
		$flnm=mysql_query($sql);
		$frow=mysql_fetch_array($flnm);
	?>
		
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        		Updated!
    		</div> 
		</div>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
		
<?	}
	 ?>



<table><tr><td valing="top">Template: </td><td>&nbsp;&nbsp;</td><td>
	<select name="templates" size="5" id="templates" class="productslist" onClick="TemplateSelected(this.form)">
<?   
$files1 = scandir("templates");

	
	foreach ( $files1 as $file ) {
 		if ($file != "." && $file != ".." ) {
 			if ($file == $frow['Template']) { $selected = "SELECTED"; } else { $selected = ""; }
 		
			echo "<option value=\"" . $file . "\" " . $selected . ">" . $file . "</option>";
		}
	}
		?>
 </select>
	</td></tr>
	<tr><td>&nbsp;</td><td></td><td><input type="button" name="submit" id="submit" value="Save" onClick="javascript:aSave();"/></td></tr>
	</table>
	
	<script type='text/javascript'>
	jQuery(document).ready(function() {
	TemplateSelected();
});
</script>
