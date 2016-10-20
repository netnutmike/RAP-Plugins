<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright &#169;2010 Genius Idea Studio, LLC. All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Rapid Action 
| Profits regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.   
|
| ================================================================
| RAP-tools Rap Tools
| ================================================================
+--------------------------------------------------------------------------
*/


define(version,'1.0.1');
require_once("ClassVersion.php");

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

<script src="/rap_admin/addons/GIS/raptools/js/jquery.effects.core.js"></script>
<script src="/rap_admin/addons/GIS/raptools/js/jquery.effects.pulsate.js"></script>

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

<script type="text/javascript" src="addons/GIS/raptools/js/tiny_mce.js"></script>

<script type='text/javascript'>
	//+ load css/js stuff
	addCssLink('./addons/GIS/raptools/css/styles.css');

	var loadingimage = '<img src="addons/GIS/raptools//images/loading.gif" alt="" border="">';
	//window.onload = myPageLoad;
</script>

<script type="text/javascript" src="addons/GIS/raptools/js/rap-tools.js"></script>



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
				<b>Rap Tools - The Swiss Army Knife For RAP</b>
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
				&nbsp;<a href='addons/GIS/raptools/raptools_manual.pdf' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/raptools/images/document.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Rap Tools<br>Manual</div></div></a>&nbsp;
			&nbsp;<a href='http://askmikemyers.com' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/raptools/images/help_64.png) no-repeat;'>&nbsp;</div><div class=right><div class="georgia-big">Rap Tools<br> Addon Support</div></div></a>&nbsp;
			<div class=left style='margin-right:20px;'> </div>

			<div class='clearfix'></div>
		</div>
		
			</div>
			</font>		</td>
	</tr>
	
	<tr>
		<td valign=bottom width=100%>
			
			<div style='clear:both;'></div>
			<ul class="rt-menu">
     			<li id="rt-menu1"><a href="javascript:LoadProducts();">Products</a></li>
     			<li id="rt-menu2"><a href="javascript:LoadFiles();">Files</a></li>
     			<li id="rt-menu3"><a href="javascript:LoadAddons();">Addons</a></li>
     			<li id="rt-menu4"><a href="javascript:LoadPages();">Pages</a></li>
     			<li id="rt-menu5"><a href="javascript:LoadOptions();">Options</a></li>
     			<li id="rt-menu6"><a href="javascript:LoadTools();">Tools</a></li>
 			</ul>
			
			<div style='clear:both;'></div>
			<div class='gis-content padding-rl-20' id="main-dis"></div>
		</td></tr>		
		</table>
		
	
<script type='text/javascript'>



jQuery(document).ready(function(){

	showWelcome();

	jQuery("a.files").click(function() {
	
		var cont = jQuery(this).parent().find('.gis-content');
		var path	=	jQuery(this).parent().find('.path').html();
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
			jQuery.post("addons/GIS/editor/file_list.php", { oath: path },
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});

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
			jQuery.post("addons/GIS/editor/file_edit.php", { oath: path, flnm: fln},
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});


	  

})

</script>

<?
		}
show_files($msg);
?>