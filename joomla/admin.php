<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright (c) 2009, 2010 Genius Idea Studio, LLC. All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Genius Idea Studio, LLC.
| regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script and hold harmless from any harm or damage
| Genius Idea Studio, LLC.   
|
| ================================================================
| Wishlist Member for RAP
| ================================================================
+--------------------------------------------------------------------------
*/


define(version,'1.1.0');
require_once("ClassVersion.php");

#--------------------------------------------------------------------------
# Display Configuration Page for Product
#--------------------------------------------------------------------------

function show_files($msg)
{
	$productID=$_SESSION[product];
	
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


#--------------------------------------------------------------------------
# Process form submission
#--------------------------------------------------------------------------



#--------------------------------------------------------------------------
# Display form
#--------------------------------------------------------------------------
?>

<script src="http://jqueryui.com/latest/ui/effects.core.js"></script>
<script src="http://jqueryui.com/latest/ui/effects.pulsate.js"></script>

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
	addCssLink('./addons/GIS/joomla/css/styles.css');

	var loadingimage = '<img src="addons/GIS/joomla//images/loadering.gif" alt="" border="">';
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
				<b>Joomla - Easy Integration between RAP and Joomla</b>
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
				&nbsp;<a href='addons/GIS/ganalytics/joomla_manual.pdf' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/joomla/images/document.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Joomla<br>Manual</div></div></a>&nbsp;
			&nbsp;<a href='http://askmikemyers.com' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/ganalytics/images/help_64.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Joomla Addon<br>Support</div></div></a>&nbsp;
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
								<span class='subheading-section left titles-big'>Product Options<br>
								
								<font style="font-size: 14px;"><i>Joomla Settings for your Main Product</i></font></span>
								<div style='clear:both;'></div>
							</div>
						</div>
						</a>
						<div class='gis-content padding-rl-20 ' style='display:none;' id="pr-opt-disp"></div>
						<!-- This seems weird but to combine php and JS I am putting a blank span with data so I can read it in js, only way I can get to work reliably -->
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

						<div class='subheading-large left'></div>

						<div style='clear:both;'></div>

					</div>

	
	
					<!-- Product Option -->
					<div class=gis-section id="product-options">
						<a href="javascript:void(0);" class=oto>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_oto left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>OTO Options<br>
								
								<font style="font-size: 14px;"><i>Joomla Settings for the One Time Offer</i></font></span>
								<div style='clear:both;'></div>
							</div>
						</div>
						</a>
						<div class='gis-content padding-rl-20 ' style='display:none;' id="ot-opt-disp"></div>
						<!-- This seems weird but to combine php and JS I am putting a blank span with data so I can read it in js, only way I can get to work reliably -->
						<span class=pid style='display:none;' id="prodid2"><?php echo $productID ?></span>
					</div>
					<div style='clear:both;'></div>
				</td></tr>
<?php } else { ?>
<tr><td>
<div class="rounded-box-red">
    	    <div class="box-contents">
        To set options for Joomla you need to select a product first.
    		</div> 
		</div>
		
		<?php 	foreach($products as $prod) { ?>
		<div class="rounded-box">
		<a href="index.php?product=<?php echo $prod['id']; ?>">
    	    <div class="box-contents" id="prodname">
        		<?php echo $prod['item_name']; ?>
    		</div> 
    		</a>
    		
		</div>
		
		<div style='clear:both;'></div>
<?php 	} 	?>
</td></tr>
		
<?php }?>	
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
						<a href="javascript:void(0);" class=integration>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_integration left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>Integration Options<br>
								
								<font style="font-size: 14px;"><i>Options For Integration With Other Addons</i></font></span>
								<div style='clear:both;'></div>
							</div>
						</div>
						</a>
						<div class='gis-content padding-rl-20 ' style='display:none;' id="in-opt-disp"></div>
						<!-- This seems weird but to combine php and JS I am putting a blank span with data so I can read it in js, only way I can get to work reliably -->
						<span class=pid style='display:none;' id="prodid"><?php echo $productID ?></span>
					</div>
					<div style='clear:both;'></div>
				</td></tr>
	<? } ?>
</td></tr>
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
			jQuery.post("addons/GIS/joomla/product_options.php", { productID: prodid},
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});

jQuery("a.oto").click(function() {
		
		var cont = jQuery(this).parent().find('.gis-content');
		var prodid = jQuery('#prodid2').html();
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
			jQuery.post("addons/GIS/joomla/oto_options.php", { productID: prodid},
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});

jQuery("a.integration").click(function() {
	
	var cont = jQuery(this).parent().find('.gis-content');
	var prodid = jQuery('#prodid').html();
//	var fln = jQuery('#files').val();

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
		jQuery.post("addons/GIS/joomla/integration_options.php", { productID: prodid},
				function(data){
					cont.html(data);

			  	}
			);


	}
});


	  

})

</script>

<?
show_files($msg);
?>