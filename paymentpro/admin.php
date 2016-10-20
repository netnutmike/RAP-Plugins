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
| RAP-tools.com payment pro
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


		$title = title;
		$doversion = new ModVersion;
		$vrs=$doversion->versioninfo($sys_paypal);
		echo $vrs;
		if (strpos($vrs, "Registered to:") > 0 ) { ?>
		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Rap-Tools Paypal Add-on</title>

    <!-- ** CSS ** -->
    <!-- base library -->
       
    <link rel="stylesheet" type="text/css" href="/rap_admin/addons/GIS/paymentpro/ext/ext-all.css" />
    

    <!-- overrides to base library -->
    <link rel="stylesheet" type="text/css" href="/rap_admin/addons/GIS/paymentpro/ext/xtheme-gray.css" />
    <link rel="stylesheet" type="text/css" href="/rap_admin/addons/GIS/paymentpro/css/Portal.css" />
    <link rel="stylesheet" type="text/css" href="/rap_admin/addons/GIS/paymentpro/css/GroupTab.css" />

    

    <!-- page specific -->
   <!-- <style type="text/css">
        /* styles for iconCls */
        .x-icon-new-products {
            background-image: url('/images/package_add.png');
        }
        .x-icon-new-affiliates {
            background-image: url('/images/add_business_user.png');
        }
        .x-icon-customers {
            background-image: url('/images/group.png');
        }
        .x-icon-templates {
            background-image: url('/images/templates.png');
        }
   </style> -->

    <!-- ** Javascript ** -->
    
    <script type="text/javascript">
    var version='<?= $version?>';
    var SessionID='x';
	var TimeNow;
	var DateNow;
	var stackvar;
	</script>
	
    <!-- ExtJS library: base/adapter -->
    <script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/ext/ext-base.js"></script>

    <!-- ExtJS library: all widgets -->
    <script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/ext/ext-all.js"></script>

    <!-- overrides to base library -->

	<!--  Common  -->
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/commonstores.js"></script>
	
    
    <!-- Common Interfaces -->

	
    <!-- extensions -->
    <script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/GroupTabPanel.js"></script>
    <script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/GroupTab.js"></script>

    <script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/Portal.js"></script>
    <script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/PortalColumn.js"></script>
    <script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/Portlet.js"></script>

	<!--  Grids  -->
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/productslist.js"></script>
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/giftcards.js"></script>
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/offlinepromotion.js"></script>
	
	<!--  Graphs -->
	<!-- <script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/dashboardgraphs.js"></script> -->
	
	<!--  Windows -->
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/newUpsell.js"></script>
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/upsellDetails.js"></script>
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/productDetails.js"></script>
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/giftcardDetails.js"></script>
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/newGiftCard.js"></script>
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/newGiftCards.js"></script>
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/newPromotion.js"></script>
	<script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/promoDetails.js"></script>
	
	<!--   Main Window  -->
    <script type="text/javascript" src="/rap_admin/addons/GIS/paymentpro/js/grouptabs.js"></script>

</head>
<body>
<div id="container" style="height: 100%;">
    <div id="toolbar" style="height: 100%;"></div>
	
</div>
</body>
</html>
<?php } ?>

