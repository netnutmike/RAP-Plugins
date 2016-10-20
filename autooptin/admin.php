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
| RAP-tools.com Auto Opt-in for RAP
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
# Display form
#--------------------------------------------------------------------------
?>

<script src="/rap_admin/addons/GIS/autooptin/js/jquery.effects.core.js"></script>
<script src="/rap_admin/addons/GIS/autooptin/js/jquery.effects.pulsate.js"></script>

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
	addCssLink('./addons/GIS/autooptin/css/styles.css');

	var loadingimage = '<img src="addons/GIS/autooptin//images/loading.gif" alt="" border="">';
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
				<b>Auto Opt-in - Advanced Auto Opt-in For RAP</b>
			</font></div>
			<div align="left"><?php  //get addons from the updates file
		$title = title;
		$doversion = new ModVersion;
		$vrs=$doversion->versioninfo($arow['paypal']);
		echo $vrs;
		
		if (strpos($vrs, "Registered to:") > 0 ) {
		?></div>
			
			<div align="right">

				<div class='clearfix'>
				&nbsp;<a href='addons/GIS/autooptin/autooptin_manual.pdf' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/autooptin/images/document.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Auto Opt-in<br>Manual</div></div></a>&nbsp;
			&nbsp;<a href='http://askmikemyers.com' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/autooptin/images/help_64.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Auto Opt-in Addon<br>Support</div></div></a>&nbsp;
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
						<div class='subhead-big left'>Auto Opt-in Options</div>
						<div style='clear:both;'></div>
					</div>

	
	
					<!-- Product Option -->
					<div class=gis-section id="global-options">
						<a href="javascript:void(0);" class=global>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_global left padding-rl-10'>&nbsp;</div>
								<div><span class='subheading-section left titles-big'>Global Auto Opt-in Options<br>
								
								<font style="font-size: 14px;"><i>Site Default Settings for All Products</i></font></span></div>
								<div style='clear:both;'></div>
							</div>
						</div>
						</a>
						<div class='gis-content padding-rl-20 ' style='display:none;' id="gl-opt-disp"></div>
					</div>
					<div style='clear:both;'></div>
				</td></tr>
	
	<?php if ($productID >= 1) { ?>
	<tr>
		<td valign=bottom width=100%>
			<div style='clear:both;'></div>

			<div class='gis-container-global'>
				<div class='gis-container-admin padding-rl-10'>
					<div class=gis-titlebar>
						<div class='subheading-large left'></div>
						<div style='clear:both;'></div>
					</div>
	
					<!-- Product Option -->
					<div class=gis-section id="product-options">

						<a href="javascript:void(0);" class=product>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_product left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>Product Auto Opt-in Options<br>
								
								<font style="font-size: 14px;"><i>for <?= $sys_item_name; ?></i></font></span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="pr-opt-disp"></div>
						<!-- This seems weird but to combine php and JS I am putting a blank span with data so I can read it in js, only way I can get to work reliably -->
						<span class=pid style='display:none;' id="prodid"><?php echo $productID ?></span>
					</div>

					<div style='clear:both;'></div>

				</td></tr>
<?php } else { ?>
<tr><td>
<div class="rounded-box-red">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>No Product Selected</strong></font>
        <br><font style="font-size: 14px;"><i>If you would like to set different options for each product, select a product then return here to set the individual product options.</i><br>&nbsp;
    		</div> 
		</div>
		<? } ?>
</td></tr>
		
<?php }?>		
				<div style='clear:both;'></div>
			</div>
			<div style='clear:both;'></div>
			</div>
			<div style='clear:both;'></div>

<script type='text/javascript'>
jQuery(document).ready(function(){

	jQuery("a.global").click(function() {
	
		var cont = jQuery(this).parent().find('.gis-content');
//		var path	=	jQuery(this).parent().find('.path').html();
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
			jQuery.post("addons/GIS/autooptin/global_options_edit.php", {  },
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});

	jQuery("a.product").click(function() {
		
		var cont = jQuery(this).parent().find('.gis-content');
		var prodid = jQuery('#prodid').html();

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
			jQuery.post("addons/GIS/autooptin/product_options_edit.php", { productID: prodid},
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});

})

</script>
