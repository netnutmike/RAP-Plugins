<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.2
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
| RAP-tools.com Cloaker
| ================================================================
+--------------------------------------------------------------------------
*/


define(version,'1.0.4');
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

//echo "Template Path: " . $template_path;

#--------------------------------------------------------------------------
# Process form submission
#--------------------------------------------------------------------------



#--------------------------------------------------------------------------
# Display form
#--------------------------------------------------------------------------
?>

<script src="/rap_admin/addons/GIS/cloaker/js/jquery.effects.core.js"></script>
<script src="/rap_admin/addons/GIS/cloaker/js/jquery.effects.pulsate.js"></script>


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
	addCssLink('./addons/GIS/cloaker/css/styles.css');

	var loadingimage = '<img src="addons/GIS/cloaker//images/loading.gif" alt="" border="">';
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
				<b>Cloaker - Link Cloaking from within RAP</b>
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
				&nbsp;<a href='addons/GIS/cloaker/cloaker_manual.pdf' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/cloaker/images/document.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Cloaker<br>Manual</div></div></a>&nbsp;
			&nbsp;<a href='http://askmikemyers.com' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/cloaker/images/help_64.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Cloaker Addon<br>Support</div></div></a>&nbsp;
			<div class=left style='margin-right:20px;'> </div>

			<div class='clearfix'></div>
		</div>
		
			</div>
			</font>		</td>
	</tr>
	
	<tr>
		<td valign=bottom width=100%>
			
			<div style='clear:both;'></div>

			<div class='gis-container-cloaks'>
				<div class='gis-container-admin padding-rl-10'>
					<div class=gis-titlebar>
						<div class='subhead-big left'>Link Cloaker Options</div>
						<div style='clear:both;'></div>
					</div>

	
	
					<!-- Product Option -->
					<div class=gis-section id="global-options">
						<a href="javascript:void(0);" class=cloaks>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='cloaked_links left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>Cloaked Links</span>
								<div style='clear:both;'></div>
							</div>
						</div>
						</a>
						<div class='gis-content padding-rl-20 ' style='display:none;' id="cl-opt-disp"></div>
					</div>
					<div style='clear:both;'></div>
				</td></tr>
	
	
	<tr>
		<td valign=bottom width=100%>
			<div style='clear:both;'></div>

			<div class='gis-container-cloaks'>
				<div class='gis-container-admin padding-rl-10'>
	
					<!-- Product Option -->
					<div class=gis-section id="Cloak-Stats">

						<a href="javascript:void(0);" class=stats>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='statistics left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>Statistics</span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="ls-opt-disp"></div>
					</div>

					<div style='clear:both;'></div>

		</td>
	</tr>	
	
	<tr>
		<td valign=bottom width=100%>
			<div style='clear:both;'></div>

			<div class='gis-container-cloaks'>
				<div class='gis-container-admin padding-rl-10'>
	
					<!-- Product Option -->
					<div class=gis-section id="Cloak-Stats">

						<a href="javascript:void(0);" class=tools>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='cloak_tools left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>Tools</span>
								<div style='clear:both;'></div>
							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="tool-disp"></div>
					</div>

					<div style='clear:both;'></div>

		</td>
	</tr>
		
	<div style='clear:both;'></div>
			</div>
			<div style='clear:both;'></div>
			</div>
			<div style='clear:both;'></div>

<script type='text/javascript'>
jQuery(document).ready(function(){

	jQuery("a.cloaks").click(function() {
	
		var cont = jQuery(this).parent().find('.gis-content');
		if ( cont.css('display') == 'block' || cont.css('display') == '' )
		{
			// get panel, etc... and then toggle viewable.toggle();
			cont.toggle();
			cont.html('');
		}
		else
		{
			cont.toggle();
			cont.html(loadingimage);
			jQuery.post("addons/GIS/cloaker/cloaked_links.php", {  },
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});

	jQuery("a.stats").click(function() {
		
		var cont = jQuery(this).parent().find('.gis-content');
//		var fln = jQuery('#files').val();

		if ( cont.css('display') == 'block' || cont.css('display') == '' )
		{
			// get panel, etc... and then toggle viewable.toggle();
			cont.toggle();
			cont.html('');
		}
		else
		{
			cont.toggle();
			cont.html(loadingimage);
			jQuery.post("addons/GIS/cloaker/cloaked_stats.php", { },
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});

	jQuery("a.tools").click(function() {
		
		var cont = jQuery(this).parent().find('.gis-content');

		if ( cont.css('display') == 'block' || cont.css('display') == '' )
		{
			// get panel, etc... and then toggle viewable.toggle();
			cont.toggle();
			cont.html('');
		}
		else
		{
			cont.toggle();
			cont.html(loadingimage);
			jQuery.post("addons/GIS/cloaker/cloaker_tools.php", { },
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});
	

})

</script>

<? } ?>
