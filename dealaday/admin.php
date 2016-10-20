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
| RAP-tools.com Deal-a-Day
| ================================================================
+--------------------------------------------------------------------------
*/


define(version,'1.0.0');
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
	addCssLink('./addons/GIS/dealaday/css/styles.css');

	var loadingimage = '<img src="addons/GIS/dealaday//images/loading.gif" alt="" border="">';
	//window.onload = myPageLoad;
</script>

<script type="text/javascript" src="addons/GIS/dealaday/js/jquery.lavalamp.min.js"></script>
<script type="text/javascript" src="addons/GIS/dealaday/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="addons/GIS/dealaday/js/tiny_mce.js"></script>

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
				<b>Deal-A-Day - Create a Dynamic Deal-A-Day Site</b>
			</font><a href="http://www.rapusersgroup.com" target="_blank"><img src="addons/GIS/dealaday/images/rap-users-group-button.jpg" height="30" width="126" border="0" align="right"></a>&nbsp;
		<a href="http://www.rap-tutorials.com" target="_blank"><img src="addons/GIS/dealaday/images/rap-tutorials-button.png" height="30" width="126" border="0" align="right"></a>&nbsp;</div>
			<div align="left"><?php  //get addons from the updates file
		$title = title;
		$doversion = new ModVersion;
		$vrs=$doversion->versioninfo($sys_paypal);
		echo $vrs;
		
		if (strpos($vrs, "Registered to:") > 0 ) {
		?></div>
			
			<div align="right">

				<div class='clearfix'>
				&nbsp;<a href='addons/GIS/dealaday/dealaday_manual.pdf' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/dealaday/images/document.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Deal-A-Day<br>Manual</div></div></a>&nbsp;
			&nbsp;<a href='http://askmikemyers.com' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/dealaday/images/help_64.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Deal-A-Day Addon<br>Support</div></div></a>&nbsp;
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
								<span class='subheading-section left titles-big'>Site Options<br>
								
								<font style="font-size: 14px;"><i>for <?= $sys_item_name; ?></i></font></span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="pr-opt-disp"></div>
						<!-- This seems weird but to combine php and JS I am putting a blank span with data so I can read it in js, only way I can get to work reliably -->
						<span class=pid style='display:none;' id="prodid"><?php echo $productID ?></span>
					</div>
					
					<div class=gis-section id="schedule-options">

						<a href="javascript:void(0);" class=schedule>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_schedule left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>Scheduled Deals<br>
								
								<font style="font-size: 14px;"><i>for <?= $sys_item_name; ?></i></font></span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="schedule-disp"></div>
						
					</div>
					
					<div class=gis-section id="video-tutorials">

						<a href="javascript:void(0);" class=videotutorials>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_videos left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>Scheduled Deals<br>
								
								<font style="font-size: 14px;"><i>for <?= $sys_item_name; ?></i></font></span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="schedule-disp"></div>
						
					</div>

					<div style='clear:both;'></div>

				</td></tr>
<?php } else { ?>
<tr><td>
<div class="rounded-box-red">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>No Product Selected</strong></font>
        <br><font style="font-size: 14px;"><i>To set the Deal-A-Day options you must first select a product from the Select Product Menu.</i><br>&nbsp;
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
			jQuery.post("addons/GIS/dealaday/product_options.php", { productID: "<?= $productID; ?>"},
					function(data){
						cont.html(data);
	
				  	}
				);
		}
	});

	jQuery("a.schedule").click(function() {
		
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
			jQuery.post("addons/GIS/dealaday/schedule_options.php", { productID: "<?= $productID; ?>"},
					function(data){
						cont.html(data);
	
				  	}
				);
		}
	});

	jQuery("a.videotutorials").click(function() {
		
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
			jQuery.post("addons/GIS/dealaday/video_tutorials.php", { productID: "<?= $productID; ?>"},
					function(data){
						cont.html(data);
	
				  	}
				);
		}
	});	

})

</script>
