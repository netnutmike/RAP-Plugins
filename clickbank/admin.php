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
| RAP-tools.com Clickbank
| ================================================================
+--------------------------------------------------------------------------
*/


define(version,'1.0.2');
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

<script src="/rap_admin/addons/GIS/clickbank/js/jquery.effects.core.js"></script>
<script src="/rap_admin/addons/GIS/clickbank/js/jquery.effects.pulsate.js"></script>

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
	addCssLink('./addons/GIS/clickbank/css/styles.css');

	var loadingimage = '<img src="addons/GIS/clickbank//images/loading.gif" alt="" border="">';
	//window.onload = myPageLoad;
</script>

<script type="text/javascript" src="addons/GIS/clickbank/js/jquery.lavalamp.min.js"></script>
<script type="text/javascript" src="addons/GIS/clickbank/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="addons/GIS/clickbank/js/tiny_mce.js"></script>

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
				<b>Clickbank - Interface RAP with Clickbank.</b>
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
				&nbsp;<a href='addons/GIS/clickbank/addtocart_manual.pdf' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/clickbank/images/document.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Clickbank<br>Manual</div></div></a>&nbsp;
			&nbsp;<a href='http://askmikemyers.com' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/clickbank/images/help_64.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Clickbank Addon<br>Support</div></div></a>&nbsp;
			<div class=left style='margin-right:20px;'> </div>

			<div class='clearfix'></div>
		</div>
		
			</div>
			</font>		</td>
	</tr>
	

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
								<span class='subheading-section left titles-big'>Front End Product Setup<br>
								
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
					
					<!-- OTO Option -->
<?					if ($sys_oto_flag == "1") { ?>
						<div class=gis-section id="product-options">

							<a href="javascript:void(0);" class=oto>
							<div class=gis-buttons>
								<div class='buttons'>
									<div class='admin_product left padding-rl-10'>&nbsp;</div>
									<span class='subheading-section left titles-big'>OTO Product Setup<br>
								
									<font style="font-size: 14px;"><i>for <?= $sys_oto_name; ?></i></font></span>
									<div style='clear:both;'></div>

								</div>
							</div>
							</a>

							<div class='gis-content padding-rl-20' style='display:none;' id="pr-oto-disp"></div>
						</div>
<?						} ?>

					<div style='clear:both;'></div>
					
					<!-- Video Tutorials -->
					<div class=gis-section id="product-options">

						<a href="javascript:void(0);" class=video>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_product left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>Video Tutorials<br>
								
								<font style="font-size: 14px;"><i>Like a Million Words...</i></font></span>
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
        <br><font style="font-size: 14px;"><i>To set the Add-To-Cart options you must first select a product from the Select Product Menu.</i><br>&nbsp;
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
			jQuery.post("addons/GIS/clickbank/product_options.php", { productID: "<?= $productID; ?>"},
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});

	jQuery("a.oto").click(function() {
		
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
			jQuery.post("addons/GIS/clickbank/oto_options.php", { productID: "<?= $productID; ?>"},
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});

jQuery("a.video").click(function() {
		
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
			jQuery.post("addons/GIS/clickbank/videos.php", { productID: "<?= $productID; ?>"},
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});

})

</script>
