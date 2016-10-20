<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright 2009, 2010 Genius Idea Studio, LLC. All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Genius Idea 
| Studio, LLC regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.   
|
| ================================================================
| RAP-tools.com Tell-A-Friend
| ================================================================
+--------------------------------------------------------------------------
*/


define(version,'1.2.2');
require_once("ClassVersion.php");

#--------------------------------------------------------------------------
# Display Configuration Page for Product
#--------------------------------------------------------------------------


function get_template_folder($productID) {

	$q = "SELECT * FROM products WHERE id = '$productID'";
	$result = mysql_query ($q);
	$row = mysql_fetch_assoc ($result);
	mysql_free_result ($result);

	$pname = $row['item_name'];

	$itemname = $row['item_name'];
	$itemdownload = $row['item_download'];
	
	$install_folder = $row['install_folder'];
	$tmpl_folder = $row['tmpl_folder'];

	$template_path = $install_folder . $tmpl_folder;
	
	return $template_path;
}

#--------------------------------------------------------------------------
# Main Process
#--------------------------------------------------------------------------

$addonid=$_REQUEST[id];

$productID=$_SESSION[product];

$sql = "SELECT title FROM addons 
	WHERE id = '$addonid'";

$result = mysql_query ($sql);
$r3 = mysql_fetch_assoc ($result);

mysql_free_result ($result);

define(title,$r3['title']);

$template_path = "../../../.." . get_template_folder($productID);

$title = title;


//echo "Template Path: " . $template_path;

#--------------------------------------------------------------------------
# Display form
#--------------------------------------------------------------------------
?>

<script src="/rap_admin/addons/GIS/taf/js/jquery.effects.core.js"></script>
<script src="/rap_admin/addons/GIS/taf/js/jquery.effects.pulsate.js"></script>



<script type='text/javascript'>
function addCssLink( url ) {
    var head = document.getElementsByTagName('head')[0];
     var link = document.createElement("link");
                link.setAttribute("type", "text/css");
                link.setAttribute("rel", "stylesheet");
                link.setAttribute("href", url);
                link.setAttribute("media", "screen");
                head.appendChild(link);
}
</script>

<script type='text/javascript'>
	//+ load css/js stuff
	addCssLink('./addons/GIS/taf/css/styles.css');

	var loadingimage = '<img src="addons/GIS/taf//images/loader-small.gif" alt="" border="">';
	//window.onload = myPageLoad;
</script>

<table align="center" width=90%>
	<tr>
		<td valign=bottom>
		&nbsp;
		</td>
	</tr>

	<tr>
		<td valign=bottom>&nbsp;
					<font face="Georgia">
			<div align="left">
			<font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">
				<b>Tell-A-Friend - Add a Tell-A-Friend tab to your products</b>
			</font></div>
			<div align="left"><?php  //get addons from the updates file
		$title = title;
		$doversion = new ModVersion;
		$vrs=$doversion->versioninfo();
		echo $vrs;
		
		if (strpos($vrs, "Registered to:") > 0 ) {
		?></div>
			
			<div align="right">

				<div class='clearfix'>
				&nbsp;<a href='addons/GIS/taf/taf_manual.pdf' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/taf/images/document.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Tell-A-Friend<br>Manual</div></div></a>&nbsp;
			&nbsp;<a href='http://askmikemyers.com' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/taf/images/help_64.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Tell-A-Friend Addon<br>Support</div></div></a>&nbsp;
			<div class=left style='margin-right:20px;'> </div>

			<div class='clearfix'></div>
		</div>
		
			</div>
			</font>		</td>
	</tr>
	
	<tr>
		<td valign=bottom width=100%>
			
			<div style='clear:both;'></div>

	
			<div class='gis-container-global'>
				<div class='gis-container-admin padding-rl-10'>

					<div class=gis-titlebar>

						<div class='subhead-big addon-title left'>Tell-A-Friend Tab</div>

						<div style='clear:both;'></div>

					</div>

	
	
					<!-- Product Option -->
					<div class=gis-section id="global-options">

						<a href="javascript:void(0);" class=products>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='product_list left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section addon-title left titles-big'>Inserting the Tell A Friend Tokens</span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' id="gl-opt-disp"><font size="3" color="black" face=tahoma >There are no adminsitrative options to setup for the Tell-A-Friend addon.  This page is here so you have access to the latest version information, the manual and support.<br><br>There are 3 tokens that need to be inserted into your template files.  One goes in the header area and the other 2 go in the body.  One adds the Tell-A-Friend button and the other the Twitter Button.<br><br>
						<strong>gTAFHeader()</strong> - This token needs to be inserted in between the &lt;head&gt; and &lt;/head&gt; tags in the header.html template.  It would look like this: &lt;? gTAFHeader(); ?&gt;<br><br><strong>gTAFBody()</strong> - This token needs to be inserted just before the &lt;/body&gt; HTML tag.  It looks like this: &lt;? gTAFBody(); ?&gt;.
						<br><br><strong>gTweetBody()</strong> - This token needs to be inserted just before the &lt;/body&gt; HTML tag.  It looks like this: &lt;? gTweetBody(); ?&gt;.<br><br>
						<b>Note:</b><i>There are some additional options that allow you to change the placement, change the colors, etc.  These options are in the user manual.</i></font></div>
					</div>

					<div style='clear:both;'></div>

				</td></tr>

				<div style='clear:both;'></div>
	
			</div>
	
		

			<div style='clear:both;'></div>


	
			</div>
		

			<div style='clear:both;'></div>
			
	<? } ?>

