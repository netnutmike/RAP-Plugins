<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.1
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
| rap-tools.com RAP Tracker add-on
| ================================================================
+--------------------------------------------------------------------------
*/


define(version,'1.0.4');
require_once("ClassVersion.php");

$TodaysDate = date("m/d/Y",time());
$timstr = "14 days ago";
$DefaultStartDate = date("m/d/Y", strtotime($timstr));

#--------------------------------------------------------------------------
# Display Configuration Page for Product
#--------------------------------------------------------------------------

function show_files($msg)
{
	$productID=$_SESSION[product];
	
}

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

<script src="/rap_admin/addons/GIS/raptracker/js/jquery.effects.core.js"></script>
<script src="/rap_admin/addons/GIS/raptracker/js/jquery.effects.pulsate.js"></script>
<script type="text/javascript" src="addons/GIS/raptracker/toolbar/codebase/dhtmlxcommon.js"></script>
<script type="text/javascript" src="addons/GIS/raptracker/toolbar/codebase/dhtmlxtoolbar.js"></script>
<link rel="stylesheet" type="text/css" href="addons/GIS/raptracker/toolbar/codebase/skins/dhtmlxtoolbar_dhx_skyblue.css"></link>
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

function LoadGraph( report ) {

	var cont = jQuery('#graph-content');
	var start = toolbar.getValue(3);
	var end = toolbar.getValue(5);
	//var report = jQuery('#files').val();
	var dateval = toolbar.getListOptionSelected(2);
	var prodid = "<? echo $productID; ?>";

	cont.show();
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptracker/grapher.php", { dateval: dateval, start: start, end: end, report: report, prodid: prodid},
		function(data){
			cont.html(data);
		}
	);
}
</script>



<script type='text/javascript'>
	//+ load css/js stuff
	addCssLink('./addons/GIS/raptracker/css/styles.css');

	var loadingimage = '<img src="addons/GIS/raptracker//images/loader-small.gif" alt="" border="">';
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
				<b>RAP Tracker - Advanced Tracking Tool For RAP</b>
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
				&nbsp;<a href='addons/GIS/raptracker/tracker_manual.pdf' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/raptracker/images/document.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Rap Tracker<br>Manual</div></div></a>&nbsp;
			&nbsp;<a href='http://askmikemyers.com' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/raptracker/images/help_64.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Rap Tracker Addon<br>Support</div></div></a>&nbsp;
			<div class=left style='margin-right:20px;'> </div>

			<div class='clearfix'></div>
		</div>
		
			</div>
			</font>		</td>
	</tr>
	<tr>
	<td>
	<div id="toolbarObj"></div>
	
	<script type='text/javascript'>
		var sel = document.getElementById("sel");
		var toolbar = new dhtmlXToolbarObject("toolbarObj");
		id=2;
		//toolbar.setIconsPath("../common/imgs/");
		//toolbar.loadXML("addons/GIS/raptracker/toolbar/samples/common/dhxtoolbar_buttonselect.xml", function(){});
		toolbar.addText(1, 1, "Date Range: ");
		var opts = Array(Array(id+'id1', 'obj', 'Last 14 Days'), Array(id+'id2', 'obj', 'Last 7 Days'), Array(id+'id3', 'obj', 'Last 30 Days'), Array(id+'id4', 'obj', 'Yesterday'), Array(id+'id5', 'obj', 'Today'), Array(id+'id6', 'obj', 'Custom'));
		toolbar.addButtonSelect(2, 2, "Last 14 Days", opts, null, null);
		toolbar.addInput(3, 3, '<?php echo $DefaultStartDate; ?>', 105);
		toolbar.addText(4, 4, " - ");
		toolbar.addInput(5, 5, '<?php echo $TodaysDate; ?>', 105);
		toolbar.addSeparator(6, 6);
		var opts = Array(Array('3id1', 'obj', 'Top Affiliates'));
		toolbar.addButtonSelect(7, 7, "Affiliates", opts, null, null);
		var opts2 = Array(Array('4id1', 'obj', 'Product Performance'), Array('4id2', 'obj', 'Product Comparisons'), Array('4id3', 'obj', 'Sales Page Performance'), Array('4id4', 'obj', 'OTO Performance'), Array('4id5', 'obj', 'Referrers'));
		toolbar.addButtonSelect(8, 8, "Products", opts2, null, null);
		var opts3 = Array(Array('5id1', 'obj', 'Site Performance (all traffic)'), Array('5id12', 'obj', 'Site Performance (non Affiliate)'), Array('5id2', 'obj', 'Tracking'), Array('5id3', 'obj', 'Referrers'));
		toolbar.addButtonSelect(9, 9, "Site", opts3, null, null);
		
		//
		toolbar.hideItem(3);
		toolbar.hideItem(4);
		toolbar.hideItem(5);

		function doOnClick(itemId){
			//alert(itemId);
			switch(itemId)
			{
			case '2id6':
				toolbar.showItem(3);
				toolbar.showItem(4);
				toolbar.showItem(5);
				itmtxt = toolbar.getListOptionText(2,toolbar.getListOptionSelected(2));
				toolbar.setItemText(2,itmtxt);
			  	break;
			  	
			case '2id1':
			case '2id2':
			case '2id3':
			case '2id4':
			case '2id5':
				toolbar.hideItem(3);
				toolbar.hideItem(4);
				toolbar.hideItem(5);	
				itmtxt = toolbar.getListOptionText(2,toolbar.getListOptionSelected(2));
				toolbar.setItemText(2,itmtxt);
				break;
				
			case '3id1':
				LoadGraph('TA');
				break;

			case '3id2':
				LoadGraph('TCA');
				break;	

			case '3id3':
				LoadGraph('DBA');
				break;

			case '3id4':
				LoadGraph('ASPP');
				break;

			case '3id5':
				LoadGraph('AR');
				break;

			case '4id1':
				LoadGraph('PP');
				break;

			case '4id2':
				LoadGraph('PC');
				break;

			case '4id3':
				LoadGraph('SPP');
				break;

			case '4id4':
				LoadGraph('OTOP');
				break;

			case '4id5':
				LoadGraph('PREF');
				break;

			case '4id6':
				LoadGraph('PV');
				break;

			case '4id7':
				LoadGraph('NVU');
				break;

			case '5id1':
				LoadGraph('SPA');
				break;
				
			case '5id12':
				LoadGraph('SP');
				break;


			case '5id2':
				LoadGraph('TRK');
				break;

			case '5id3':
				LoadGraph('REF');
				break;
			
			}
	    }
	    toolbar.attachEvent("onClick", doOnClick);
		
	</script>
	</td>
	</tr>
	
	<tr>
		<td valign=bottom width=100%>
			
			<div style='clear:both;'></div>

	
			<div class='gis-container-global'>
				<div class='gis-container-admin padding-rl-10'>

					<!-- Graphs show up here -->
					<div class=gis-section>

						<a href="javascript:void(0);" class=editor>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section  left titles-big'>Statistics</span>
								<div style='clear:both;'></div>
							</div>
						</div>
						</a>
						<div class='gis-content padding-rl-20 mtb15' style='display:none;' id='graph-content'></div>
					</div>
					<div style='clear:both;'></div>
				</div>
				</td></tr>


</td></tr>
		<?php }?>
				<div style='clear:both;'></div>
			</div>
			<div style='clear:both;'></div>
			</div>
			<div style='clear:both;'></div>

<script type='text/javascript'>
jQuery(document).ready(function(){

	jQuery("a.editor").click(function() {
		
		var cont = jQuery(this).parent().find('.gis-content');
		var path = jQuery('#fl-path').html();
		var fln = jQuery('#files').val();

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
			jQuery.post("addons/GIS/raptracker/grapher.php", { oath: path, flnm: fln},
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