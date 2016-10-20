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
| RAP-tools.com Add-To-Cart
| ================================================================
+--------------------------------------------------------------------------
*/


define(version,'1.1.4');
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

function g_ATCcheckFields()
{
	$sql = "show columns from g_addToCart where Field = 'template'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
	
	if ($grow['Type'] == "varchar(25)") {
		$sql = "ALTER TABLE `g_addToCart` CHANGE `template` `template` VARCHAR( 50 ) ";
		$gid=mysql_query($sql);
	}
	
	$sql = "show columns from g_addToCart where Field = 'soldoutTemplate'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
	
	if ($grow['Type'] == "varchar(25)") {
		$sql = "ALTER TABLE `g_addToCart` CHANGE `soldoutTemplate` `soldoutTemplate` VARCHAR( 50 ) ";
		$gid=mysql_query($sql);
	}
	
	$q = "show columns FROM g_addToCart like 'MoneySymbol'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) == 0 ) {
		$q = "alter table g_addToCart add (MoneySymbol varchar(10) default '$')";
		$result = mysql_query ($q);
	}
	
	$q = "show columns FROM g_addToCart like 'SlashDirection'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) == 0 ) {
		$q = "alter table g_addToCart add (SlashDirection int default '1')";
		$result = mysql_query ($q);
	}
	
	$q = "show columns FROM g_addToCart like 'SlashColor'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) == 0 ) {
		$q = "alter table g_addToCart add (SlashColor varchar(12) default '255/29/132')";
		$result = mysql_query ($q);
	}
	
	$q = "show columns FROM g_addToCart like 'RegularColor'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) == 0 ) {
		$q = "alter table g_addToCart add (RegularColor varchar(12) default '33/29/132')";
		$result = mysql_query ($q);
	}
	
	$q = "show columns FROM g_addToCart like 'TodayColor'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) == 0 ) {
		$q = "alter table g_addToCart add (TodayColor varchar(12) default '33/29/132')";
		$result = mysql_query ($q);
	}

}

function checkversion() {

	$q = "show columns FROM g_addToCart like 'CopiesLeftText'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) > 0 )
		return true;
	else
		return false;
}

function updatetable() {
	$q = "show columns FROM g_addToCart like 'ClickCount'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) == 0 ) {
		$q = "alter table g_addToCart add (ClickCount int default '0')";
		$result = mysql_query ($q);
	}
	
	$q = "show columns FROM g_addToCart like 'ViewCount'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) == 0 ) {
		$q = "alter table g_addToCart add (ViewCount int default '0')";
		$result = mysql_query ($q);
	}
	
	$q = "show columns FROM g_addToCart like 'CopiesLeftText'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) == 0 ) {
		$q = "alter table g_addToCart add (CopiesLeftText varchar(100) default '')";
		$result = mysql_query ($q);
	}
	
	$q = "show columns FROM g_addToCartBumps like 'ClickCount'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) == 0 ) {
		$q = "alter table g_addToCartBumps add (ClickCount int default '0')";
		$result = mysql_query ($q);
	}
	
	$q = "show columns FROM g_addToCartBumps like 'ViewCount'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) == 0 ) {
		$q = "alter table g_addToCartBumps add (ViewCount int default '0')";
		$result = mysql_query ($q);
	}
	
	$q = "show tables like 'g_addToCartOptions'";
	$result = mysql_query ($q);
	if (mysql_num_rows($result) == 0 ) {
		$q = "Create table if not exists g_addToCartOptions (uid int auto_increment, productID int, OptionName varchar(50), Value varchar(250), primary key(uid))";
		$result = mysql_query ($q);
	}
	
	
	
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

<script src="/rap_admin/addons/GIS/addtocart/js/jquery.effects.core.js"></script>
<script src="/rap_admin/addons/GIS/addtocart/js/jquery.effects.pulsate.js"></script>

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
	addCssLink('./addons/GIS/addtocart/css/styles.css');

	var loadingimage = '<img src="addons/GIS/addtocart//images/loading.gif" alt="" border="">';
	//window.onload = myPageLoad;
</script>

<script type="text/javascript" src="addons/GIS/addtocart/js/jquery.lavalamp.min.js"></script>
<script type="text/javascript" src="addons/GIS/addtocart/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="addons/GIS/addtocart/js/tiny_mce.js"></script>

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
				<b><img src="addons/GIS/addtocart/images/DynamicATC-Logo-44.png"> - Graphic Belcher Buttons for easy posts in forums and emails.</b>
			</font><a href="http://www.rapusersgroup.com" target="_blank"><img src="addons/GIS/addtocart/images/rap-users-group-button.jpg" height="30" width="126" border="0" align="right"></a>&nbsp;
		<a href="http://www.rap-tutorials.com" target="_blank"><img src="addons/GIS/addtocart/images/rap-tutorials-button.png" height="30" width="126" border="0" align="right"></a>&nbsp;</div>
			<div align="left"><?php  //get addons from the updates file
		$title = title;
		$doversion = new ModVersion;
		$vrs=$doversion->versioninfo($arow['paypal']);
		echo $vrs;
		
		if (strpos($vrs, "Registered to:") > 0 ) {
			if (!checkversion()) {
				//if we are here then they need to upgrade
				updatetable();
			} 
			g_ATCcheckFields();
		?></div>
			
			<div align="right">

				<div class='clearfix'>
				&nbsp;<a href='addons/GIS/addtocart/addtocart_manual.pdf' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/addtocart/images/document.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Add-To-Cart<br>Manual</div></div></a>&nbsp;
			&nbsp;<a href='http://askmikemyers.com' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/addtocart/images/help_64.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Add-To-Cart Addon<br>Support</div></div></a>&nbsp;
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
								<span class='subheading-section left titles-big'>Add-To-Cart Buttons<br>
								
								<font style="font-size: 14px;"><i>for <?= $sys_item_name; ?></i></font></span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="pr-opt-disp"></div>
						<!-- This seems weird but to combine php and JS I am putting a blank span with data so I can read it in js, only way I can get to work reliably -->
						<span class=pid style='display:none;' id="prodid"><?php echo $productID ?></span>
					</div>
					
					<div class=gis-section id="product-adv-options">

						<a href="javascript:void(0);" class=advanced>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_advanced left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>Advanced Options<br>
								
								<font style="font-size: 14px;"><i>for <?= $sys_item_name; ?></i></font></span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="ad-opt-disp"></div>
						
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
			jQuery.post("addons/GIS/addtocart/product_options.php", { productID: "<?= $productID; ?>"},
					function(data){
						cont.html(data);
	
				  	}
				);
		}
	});

	jQuery("a.advanced").click(function() {
		
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
			jQuery.post("addons/GIS/addtocart/advanced_options.php", { productID: "<?= $productID; ?>"},
					function(data){
						cont.html(data);
	
				  	}
				);
		}
	});

})

</script>
