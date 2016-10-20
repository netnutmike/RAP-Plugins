<?
//==============================================================================================
//
//	Filename:	copy_product.php
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
//	Description:	This file is called when the user wants to copy a product. 
//
//	Version:	1.0.0 (February 5rd, 2009)
//
//	Change Log:
//				02/05/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); ?>

<script language="JavaScript">

function aCopyCancel() {

	jQuery.post("addons/GIS/raptools/products.php", { },
					function(data){
						jQuery('#main-dis').html(data);
				  	}
				);
}

function aContinue() {

	var cont = jQuery('#main-dis');
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/products.php", { },
		function(data){
			cont.html(data);
		  	}
		);
}

function aCopyCopy() {

	var toname =		jQuery("#toname").val();
	var tofolder =		jQuery("#tofolder").val();
	var copy_product =	jQuery("#copy_product:checked").val();
	var copy_salesltr =	jQuery("#copy_salesltr:checked").val();
	var copy_coupons =	jQuery("#copy_coupons:checked").val();
	var copy_email =	jQuery("#copy_email:checked").val();
	var copy_asetting =	jQuery("#copy_asetting:checked").val();
	var copy_files =	jQuery("#copy_files:checked").val();
	var pid =	jQuery("#pid").html();
	jQuery.post("addons/GIS/raptools/copy_product.php", { toname: toname, tofolder: tofolder, copy_product: copy_product, copy_salesltr: copy_salesltr, copy_coupons: copy_coupons, copy_email: copy_email, copy_asetting: copy_asetting, copy_files: copy_files, pid: pid },
					function(data){
						jQuery('#ProductDescription').html(data);
				  	}
				);
}

</script>

<? 
// Creates a new product inserts the name and path information and returns the new product ID
function new_product($name, $path)
{
	$g_insertquery = "insert into products (item_name, install_folder) VALUES ('" . $name . "', '" . $path . "')";
	echo $g_insertquery;
//	mysql_query($g_insertquery);
	
//	$g_newProductID = mysql_insert_id();
	
	return $g_newProductID;
}

// Copies settings from one product to another by copying each field and creating a new record then returns the new product ID
function copy_product($fromid, $name, $path)
{
	$result = mysql_query("SHOW COLUMNS FROM products");
	if (!$result) {
    	return false;
		}

	$g_tablenames = "";
	if (mysql_num_rows($result) > 0) {
    	while ($row = mysql_fetch_assoc($result)) {
    		if ($g_tablenames != "")
    			$g_tablenames .= ", ";
    			
    		if ($row['Field'] != "id")
    			$g_tablenames .= $row['Field'];
    	}
	}
	
	$g_insertquery = "insert into products (" . $g_tablenames . ") SELECT " . $g_tablenames . " from products where id='" . $fromid . "'";
	mysql_query($g_insertquery);
	
	$g_newProductID = mysql_insert_id();
	
	$g_insertquery = "update products SET item_name='" . $name . "', install_folder='" . $path . "' where id = '" . $g_newProductID . "'";
	mysql_query($g_insertquery);
	
	return $g_newProductID;
	
}

// Copies sales letter settings from one product to another
function copy_slsltr($fromid, $toid)
{
	$query = "select * from salesletters where productID='" . $fromid . "'";		
	$request = mysql_query($query);
	while ($rs = mysql_fetch_array($request)){	
		$g_insertquery = "insert into salesletters (productID, template, hits, disabled) VALUES ('" . $toid . "', '" . $rs['template'] . "', '0', '" . $rs['disabled'] . "')"; 
		mysql_query($g_insertquery);
	}
		
}

// Copies coupon settings from one product to another
function copy_coupons($fromid, $toid)
{
	$query = "select * from coupons where productID='" . $fromid . "'";		
	$request = mysql_query($query);
	while ($rs = mysql_fetch_array($request)){	
		$g_insertquery = "insert into coupons (productID, code, price, expires) VALUES ('" . $toid . "', '" . $rs['code'] . "', '" . $rs['price'] . "', '" . $rs['expires'] . "')"; 
		mysql_query($g_insertquery);
	}

}

// Copies email settings from one product to another
function copy_email($fromid, $toid)
{
	$query = "select * from emails where productID='" . $fromid . "'";		
	$request = mysql_query($query);
	while ($rs = mysql_fetch_array($request)){	
		$g_insertquery = "insert into emails (productID, type, subject, body) VALUES ('" . $toid . "', '" . $rs['type'] . "', '" . $rs['subject'] . "', '" . $rs['body'] . "')"; 
		mysql_query($g_insertquery);
	}		
}

// Copies rap tools settings from one product to another
function copy_raptools_options($fromid, $toid)
{
	$query = "select * from g_raptoolsOptions where productID='" . $fromid . "'";		
	$request = mysql_query($query);
	while ($rs = mysql_fetch_array($request)){	
		$g_insertquery = "insert into g_raptoolsOptions (productID, OptionID, ValueChar, ValueInt) VALUES ('" . $toid . "', '" . $rs['OptionID'] . "', '" . $rs['ValueChar'] . "', '" . $rs['ValueInt'] . "')"; 
		mysql_query($g_insertquery);
	}		

}

function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
} 

// Copies files from one product to another
function copy_files($fromid, $tofolder)
{
	
	$query = "select * from products where id='" . $fromid . "'";		
	$request = mysql_query($query);
	$rs = mysql_fetch_array($request);
	$basepath = substr(getcwd(),0,strrpos(getcwd(), "/rap_admin"));

	if (file_exists($basepath . $rs['install_folder'])) {
		//echo "copy from: " . $basepath . $rs['install_folder'] . " to: " . $basepath . $tofolder;
		recurse_copy($basepath . $rs['install_folder'],$basepath . $tofolder);
	} else { ?>
	
	<div class="rounded-box-red width-500" id="error-box">
    	    <div class="box-contents width-500">
        WARNING!  The product you are copying does not have any physical folder at the location the product is configured for.  The copying of files for the product has failed but the other copy functions unless otherwise noted completed successfully.
    		</div> 
		</div>
	
	<? }

		
}
?>

<? if ($_POST['toname'] != "" && $_POST['tofolder'] != "") {
	$toname = $_POST['toname'];
	$tofolder = $_POST['tofolder'];
	
	//make sure that the destination folder is formatted with leading / and trailing /
	if (substr($tofolder,0,1) != "/")
		$tofolder = "/" . $tofolder;
		
	if (substr($tofolder,-1,1) != "/")
		$tofolder .= "/";
		
	//time to make the donuts..... I mean copy the stuff
	if ($_POST['copy_product'] == 1) {
		$g_npid = copy_product($_POST['pid'], $toname, $tofolder);
	} else {
		$g_npid = new_product($toname, $tofolder);
	}
	
	if ($_POST['copy_salesltr'] == 1) {
		$status = copy_slsltr($_POST['pid'], $g_npid);
	}
	
	if ($_POST['copy_coupons'] == 1) {
		$status = copy_coupons($_POST['pid'], $g_npid);
	}	
	
	if ($_POST['copy_email'] == 1) {
		$status = copy_email($_POST['pid'], $g_npid);
	}	
	
	if ($_POST['copy_asetting'] == 1) {
		$status = copy_raptools_options($_POST['pid'], $g_npid);
	}	
	
	if ($_POST['copy_files'] == 1) {
		$status = copy_files($_POST['pid'], $tofolder);
	}	
		
	?>
	<table><tr><td>
<div class="rounded-box-green width-500" id="message-box">
    	    <div class="box-contents width-500">
        The copy action has been completed.  If there were errors they will be above this message.  Please note that the product you just copied will not show up in RAP until you go to another menu option or refresh the page.  Click the Continue button below to return to the products page in Rap Tools.
    		</div> 
		</div></td></tr><tr><td>
		<div style='clear:both;'></div><br><br>&nbsp;
		<input type="button" name="submit" id="submit" value="Continue..." onClick="javascript:aContinue();"/>
		</td></tr></table>
<?		
} else { ?>

<form id="copyprod" name="copyprod" method="post" action="addons/GIS/raptools/copy_product.php">
<?php 
	$query = "select * from products where id='" . $_REQUEST["pid"] . "'";		
	$request = mysql_query($query);
	$prs = mysql_fetch_array($request); ?>
<table>
<tr><td>
 You are about to copy <strong>"<?=$prs['item_name']?>"</strong> to a new product.  Please complete the following information:<br>&nbsp;
 <div class='gis-content padding-rl-20 width-465' style="display:none" id="pid"><? echo $_REQUEST["pid"]; ?></div>
 <table>
 <? 
 	$basepath = substr(getcwd(),0,strrpos(getcwd(), "/rap_admin"));

	if (!file_exists($basepath . $prs['install_folder'])) { ?>
	<tr><td colspan="3">
 	<div class="rounded-box-red width-500" id="error-box">
    	    <div class="box-contents width-500">
        WARNING!  The product you are copying does not have any physical folder at the location the product is configured for.  Therefore the option to copy the files will not be available.
    		</div> 
		</div>
		<div style='clear:both;'></div>
		</td></tr>
	<script type='text/javascript'>
	jQuery("#copy_files").removeAttr("checked");
	jQuery("#copy_files_div").hide();
	</script>
	
 <?
 	
	 }
 ?>
 <tr><td>New Product Name:</td><td><input type="text" name="toname" id="toname"></td><td></td></tr>
 <tr><td>New Product Install Folder:</td><td><input type="text" name="tofolder" id="tofolder"></td><td></td></tr>
 <tr><td>Copy Options:</td><td></td></tr>
 <r><td>&nbsp;</td></tr>
 <tr><td colspan="2">
 <table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><ul class="checklist">
<li>
<input id="copy_product" name="copy_product" value="1" type="checkbox" checked>
					<a href="javascript:void(0);" id="capoif"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="copy_product">Copy RAP Product Setup</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="capoif-desc">If this option is selected then all of the settings for the product you are copying
will be copied to the new product.  These options include all of the settings that are defined in the RAP product Mgmt menu -> Edit options.  See the additional
options below to copy the sales letter and coupon information.</div>
<p>&nbsp;</p>
<ul class="checklist">
<li>
<input id="copy_salesltr" name="copy_salesltr" value="1" type="checkbox" checked>
					<a href="javascript:void(0);" id="capsif"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="copy_salesltr">Copy RAP Product Sales Letter Settings</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="capsif-desc">If this option is selected then the sales letter settings for the product being copied will be
copied to the new product.</div>
<p>&nbsp;</p>
<ul class="checklist">
<li>
<input id="copy_coupons" name="copy_coupons" value="1" type="checkbox" checked>
					<a href="javascript:void(0);" id="capcif"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="copy_coupons">Copy RAP Product Coupon Settings</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="capcif-desc">If this option is selected then the coupons that are defined for the product being copied will be copied to the new product.</div>
<p>&nbsp;</p>
<ul class="checklist">
<li>
<input id="copy_email" name="copy_email" value="1" type="checkbox" checked>
					<a href="javascript:void(0);" id="capeif"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="copy_email">Copy RAP Product Email Settings</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="capeif-desc">If this option is selected then the email settings that are defined for the product being copied will be copied to the new product.</div>
<p>&nbsp;</p>
<ul class="checklist">
<li>
<input id="copy_asetting" name="copy_asetting" value="1" type="checkbox" checked>
					<a href="javascript:void(0);" id="capaif"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="copy_asetting">Copy Rap Tools Advanced Settings</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="capaif-desc">If this option is selected then the advanced settings that are setup in rap-tools will be copied to the new product that is created.</div>
<p>&nbsp;</p>
<div id="copy_files_div">
<ul class="checklist">
<li>
<input id="copy_files" name="jqdemo" value="1" type="checkbox" checked>
					<a href="javascript:void(0);" id="capfif"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label  for="copy_files">Copy All Product Files In Install Folder</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a>
                    </li>
</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="capfif-desc">When this option is selected all of the files in the product folder will be copied to the new specified folder.  This will copy anything that is in the folder and not just the template files.<br><br><strong><i>Note:</i>For this feature to work you must have write permission to the directory where you are copying to.</strong></br></div>
</div>
</td></tr></table>
</td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td align="right">
<input type="button" name="submit" id="submit" value="Copy" onClick="javascript:aCopyCopy();"/>
</td><td align="right">
<input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:aCopyCancel();" />
</td></tr>
 </table>
  </td></tr>
  <tr><td>
  
 
</form>

</td></tr></table>

<? } ?>

<script type='text/javascript'>
jQuery(document).ready(function() {
	 
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

	jQuery("#capfif").click(function() {
		
		jQuery("#capfif-desc").toggle();

	});

	jQuery("#capoif").click(function() {
		
		jQuery("#capoif-desc").toggle();

	});

	jQuery("#capcif").click(function() {
		
		jQuery("#capcif-desc").toggle();

	});

	jQuery("#capsif").click(function() {
		
		jQuery("#capsif-desc").toggle();

	});

	jQuery("#capeif").click(function() {
		
		jQuery("#capeif-desc").toggle();

	});

	jQuery("#capaif").click(function() {
		
		jQuery("#capaif-desc").toggle();

	});	
});

</script>