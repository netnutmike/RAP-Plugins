<?
//==============================================================================================
//
//	Filename:	add_testimonial.php
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
//	Description:	This file is called when the user wants to copy a file. 
//
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				02/17/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); 

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
<script src='/rap_admin/datetimepicker.js' type='text/javascript'></script>
<script language="JavaScript">

function aSaveCancel() {

	
	jQuery('#pr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/addtocart/product_options.php", { productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aSave(uid) {

	var Name =	jQuery("#Name").val();
	var regularPrice =	jQuery("#regularPrice").val();
	var endDate =	jQuery("#endDate").val();
	var status =	jQuery("#status:checked").val();
	var end_action 		=	jQuery("#endaction:checked").val();
	var template = jQuery('#template').val();
	var soldoutTemplate = jQuery('#soldouttemplate').val();
	var CopiesLeftText = jQuery('#CopiesLeftText').val();

	jQuery('#pr-opt-disp').html(loadingimage);
	
	jQuery.post("addons/GIS/addtocart/product_options.php", { Name: Name, regularPrice: regularPrice, endDate: endDate,  status: status, endAction: end_action, template: template, soldoutTemplate: soldoutTemplate, CopiesLeftText: CopiesLeftText, uid: uid, action: "Update", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function FileSelected(form) {
		
	
	var fln = jQuery('#template').val();

	jQuery('#tmpreview').html(loadingimage);

	jQuery.post("addons/GIS/addtocart/previewtemplate.php", { tmpname: fln },
			function(data){
				jQuery('#tmpreview').html(data);
		  	}
		);
	
}

function SoldOutFileSelected(form) {
		
	
	var fln = jQuery('#soldouttemplate').val();

	jQuery('#soldouttmpreview').html(loadingimage);

	jQuery.post("addons/GIS/addtocart/previewtemplate.php", { tmpname: fln },
			function(data){
				jQuery('#soldouttmpreview').html(data);
		  	}
		);
	
}
</script>

<?
	$sql="select * from g_addToCart where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
?>
<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Edit Add-To-Cart Entry</p>";
		
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts" valign="center">

 	<input type="image" src="/rap_admin/addons/GIS/addtocart/images/save.png" name="submit" value="Save" onClick="javascript:aSave('<?= $_REQUEST['uid']; ?>');"/><br>&nbsp; Save
 	</td><td></td><td align="right" class="Prompts" valign="center"><input type="image" src="/rap_admin/addons/GIS/addtocart/images/delete48x48.png" name="submit" value="Save" onClick="javascript:aSaveCancel();"/><br>Cancel</td></tr>
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table>
 	<tr><td class="Prompts">Name:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="Name" id="Name" value="<?= $grow['Name'];?>"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Regular Price:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="regularPrice" id="regularPrice" value="<?= $grow['regularPrice'];?>"></td><td>(Leave Blank To Use Product Price, 0 = $0)</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Copies Left Text:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="CopiesLeftText" id="CopiesLeftText" value="<?= $grow['CopiesLeftText'];?>"></td><td>(Defaults to: "Only [COPIES] Copies Left" if blank)</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">End Date:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="endDate" id="endDate" size="11" value="<?= $grow['endDate'];?>"></td><td><a href="javascript:NewCal('endDate','MMDDYYYY',false,24)">
				<img src="addons/GIS/addtocart/images/calendar.png" width="48" height="48" border="0" alt="Pick a date"></a>
 	</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">End Action:</td><td></td></td><td colspan="2"><ul class="checklist-toggle">
<li>
<input id="endaction" name="endaction" value="1" type="checkbox" <? if ($grow['endAction'] == 1) echo "checked"; ?>>
					<table><tr height="35"><td width="200"><a class="checkbox-toggle-select Prompts" href="#">&nbsp;&nbsp;Show Sold Out</a></td><td width="40"></td><td width="200"><a class="checkbox-toggle-deselect Prompts" href="#">&nbsp;&nbsp;Show Regular Price</a></td></tr></table>
                   
                    
                    
                    </li>
</ul></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td class="Prompts">Button Template:</td><td></td><td>
<select name="template" size="4" id="template" class="fileslist" onClick="FileSelected(this.form)">
   
<?php 
	//Build a list of files in the select list by looping through all the files in the directory.
	
	if (phpversion() < "5.0.0")
		$files1 = php4_scandir("templates");
	else
		$files1 = scandir("templates");

	foreach ( $files1 as $file ) {
 		if ($file != "." && $file != ".." && substr($file,0,1) == 'b' && strpos($file, ".png") !== false )
			echo "<option value=\"" . $file . "\"";
			if ($file == $grow['template'])
				echo " SELECTED";
			echo ">" . $file . "</option>";
		}

?>
 </select>
</td><td><div id="tmpreview"></div></td></tr><TR><TD colspan="4">
<div id="soldoutoption"><table>
<tr><td class="Prompts">Sold-Out Template:</td><td></td><td>
<select name="soldouttemplate" size="4" id="soldouttemplate" class="fileslist" onClick="SoldOutFileSelected(this.form)">
   
<?php 
	//Build a list of files in the select list by looping through all the files in the directory.
	
	if (phpversion() < "5.0.0")
		$files1 = php4_scandir("templates");
	else
		$files1 = scandir("templates");

	foreach ( $files1 as $file ) {
 		if ($file != "." && $file != ".." && substr($file,0,1) == 's' && strpos($file, ".png") !== false )
			echo "<option value=\"" . $file . "\"";
			if ($file == $grow['soldoutTemplate'])
				echo " SELECTED";
			echo ">" . $file . "</option>";
		}

?>
 </select>
</td><td><div id="soldouttmpreview"></div></td></tr></table>
</div></TD></TR>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td colspan="4">
 		<ul class="checklist">
						<li>
							<input id="status" name="status" value="1" type="checkbox" <? if ($grow['status'] == '1' || $grow['status'] == '2') { echo "checked"; } ?>>
                    		<label for="status">Active Add-To-Cart Entry</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
 		</td></tr>
 		<tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td colspan="3">
  
 

</td></tr></table>
<div class='gis-content padding-rl-20' id="atc-opt-disp"></div>

<div class='gis-content padding-rl-20' id="atc-preview-disp"></div>

<script type='text/javascript'>


/* see if anything is previously checked and reflect that in the view*/
jQuery(".checklist input:checked").parent().addClass("selected");

/* handle the user selections */
jQuery(".checklist .checkbox-select").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().addClass("selected");
        jQuery(this).parent().find(":checkbox").attr("checked","checked");
        
    }
    
);

jQuery(".checklist .checkbox-deselect").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().removeClass("selected");
        jQuery(this).parent().find(":checkbox").removeAttr("checked");
        
    }
    
);

/* see if anything is previously checked and reflect that in the view*/
jQuery(".checklist-toggle input:checked").parent().addClass("selected");

if (jQuery("#endaction:checked").val() != 1)
	jQuery("#soldoutoption").hide();

/* handle the user selections */
jQuery(".checklist-toggle .checkbox-toggle-select").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().parent().parent().parent().parent().addClass("selected");
        jQuery(this).parent().parent().parent().parent().parent().find(":checkbox").attr("checked","checked");
        jQuery("#soldoutoption").show();
    }
);

jQuery(".checklist-toggle .checkbox-toggle-deselect").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().parent().parent().parent().parent().removeClass("selected");
        jQuery(this).parent().parent().parent().parent().parent().find(":checkbox").removeAttr("checked");
        jQuery("#soldoutoption").hide();
    }
);

	jQuery('#atc-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/addtocart/atc_options.php", { atcid: '<?= $_POST['uid']; ?>', action: "View", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-opt-disp').html(data);
				  	}
				);

	jQuery('#atc-preview-disp').html(loadingimage);
	jQuery.post("addons/GIS/addtocart/atc_preview.php", { atcid: '<?= $_POST['uid']; ?>', productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-preview-disp').html(data);
				  	}
				);	
	FileSelected();
	SoldOutFileSelected();

</script>