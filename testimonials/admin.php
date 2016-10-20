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
| RAP-tools.com Testimonials
| ================================================================
+--------------------------------------------------------------------------
*/


define(version,'1.1.2');
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

<script src="/rap_admin/addons/GIS/testimonials/js/jquery.effects.core.js"></script>
<script src="/rap_admin/addons/GIS/testimonials/js/jquery.effects.pulsate.js"></script>



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
	addCssLink('./addons/GIS/testimonials/css/styles.css');

	var loadingimage = '<img src="addons/GIS/testimonials//images/loading.gif" alt="" border="">';
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
				<b>Testimonials - Easily Manage Your Testimonials from within RAP</b>
			</font><a href="http://www.rapusersgroup.com" target="_blank"><img src="addons/GIS/testimonials/images/rap-users-group-button.jpg" height="30" width="126" border="0" align="right"></a>&nbsp;
		<a href="http://www.rap-tutorials.com" target="_blank"><img src="addons/GIS/testimonials/images/rap-tutorials-button.png" height="30" width="126" border="0" align="right"></a>&nbsp;</div>
			<div align="left"><?php  //get addons from the updates file
		$title = title;
		$doversion = new ModVersion;
		$vrs=$doversion->versioninfo($arow['paypal']);
		echo $vrs;
		
		if (strpos($vrs, "Registered to:") > 0 ) {
		?></div>
			
			<div align="right">

				<div class='clearfix'>
				&nbsp;<a href='addons/GIS/testimonials/testimonials_manual.pdf' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/testimonials/images/document.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Testimonials<br>Manual</div></div></a>&nbsp;
			&nbsp;<a href='http://askmikemyers.com' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/testimonials/images/help_64.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Testimonials Addon<br>Support</div></div></a>&nbsp;
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

						<div class='subhead-big addon-title left'>Testimonials</div>

						<div style='clear:both;'></div>

					</div>

	
	
					<!-- Product Option -->
					<div class=gis-section id="global-options">

						<a href="javascript:void(0);" class=products>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='product_list left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section addon-title left titles-big'>Select Products<br>
								
								<font style="font-size: 14px;"><i>Select a Product to set template and manage testimonials</i></font></span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="gl-opt-disp"></div>
					</div>

					<div style='clear:both;'></div>

				</td></tr>
	
	<tr>
		<td valign=bottom width=100%>
			
			<div style='clear:both;'></div>

	
			<div class='gis-container-global'>
				<div class='gis-container-admin padding-rl-10'>

					<div class=gis-titlebar>

						<div class='subhead-big addon-title left'></div>

						<div style='clear:both;'></div>

					</div>

	
	
					<!-- Product Option -->
					<div class=gis-section id="product-options">

						<a href="javascript:void(0);" class=product>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='testimonials left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section addon-title left titles-big'>Manage Testimonials<br>
								
								<font style="font-size: 14px;"><i>Manage the testimonials for the currently selected product</i></font></span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="pr-opt-disp"></div>
						<!-- hidden but necessary options -->
						<span class=pid style='display:none;' id="prodid"><?php echo $productID ?></span>
					</div>

					<div style='clear:both;'></div>

				</td></tr>
				
	<tr>
		<td valign=bottom width=100%>
			
			<div style='clear:both;'></div>

	
			<div class='gis-container-global'>
				<div class='gis-container-admin padding-rl-10'>

					<div class=gis-titlebar>

						<div class='subhead-big addon-title left'></div>

						<div style='clear:both;'></div>

					</div>

	
	
					<!-- Product Option -->
					<div class=gis-section id="product-options">

						<a href="javascript:void(0);" class=templates>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='templates left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section addon-title left titles-big'>More Templates<br>
								
								<font style="font-size: 14px;"><i>Find new testimonial templates</i></font></span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="tmp-opt-disp"></div>
						
					</div>

					<div style='clear:both;'></div>

				</td></tr>				

				<div style='clear:both;'></div>
	
			</div>
	
		

			<div style='clear:both;'></div>


	
			</div>
		

			<div style='clear:both;'></div>
			
	<? } ?>

<script type='text/javascript'>
jQuery(document).ready(function(){

	jQuery("a.products").click(function() {
	
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
			jQuery.post("addons/GIS/testimonials/product_list.php", {  },
					function(data){
						cont.html(data);
	
				  	}
				);
		}
	});

	jQuery("a.product").click(function() {
		
		var cont = jQuery(this).parent().find('.gis-content');
		var prodid = jQuery('#prodid').html();
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
			var pid = jQuery('#products').val();
			jQuery.post("addons/GIS/testimonials/testimonials.php", { pid: pid },
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});


	jQuery("a.templates").click(function() {
		
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
			jQuery.post("addons/GIS/testimonials/templatedownload.php", { },
					function(data){
						cont.html(data);
				  	}
				);
		}
	});

})

</script>
