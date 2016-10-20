<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright &#169;2009 Genius Idea Studio, LLC. All Rights Reserved
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
| RAP-tools Editor
| ================================================================
+--------------------------------------------------------------------------
*/


define(version,'1.0.0');
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

<script type="text/javascript" src="addons/GIS/editor/js/tiny_mce.js"></script>

<script type='text/javascript'>
	//+ load css/js stuff
	addCssLink('./addons/GIS/editor/css/styles.css');

	var loadingimage = '<img src="addons/GIS/editor//images/loader-small.gif" alt="" border="">';
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
				<b>Editor - Template Editing From Within the RAP Admin Panel</b>
			</font></div>
			<div align="left"><?php  //get addons from the updates file
		$title = title;
		$doversion = new ModVersion;
		$vrs=$doversion->versioninfo();
		echo $vrs;
		?></div>
			
			<div align="right">

				<div class='clearfix'>
				&nbsp;<a href='addons/GIS/editor/editor_manual.pdf' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/editor/images/document.png) no-repeat;'>&nbsp;</div><div class=right><div class="biggeorgia">Editor<br>Manual</div></div></a>&nbsp;
			&nbsp;<a href='http://askmikemyers.com' target='_blank'><div class='right' style='height: 65px; maring-left: 15px; width: 65px; background: transparent url(addons/GIS/editor/images/help_64.png) no-repeat;'>&nbsp;</div><div class=right><div class="biggeorgia">Editor Addon<br>Support</div></div></a>&nbsp;
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

	
			<div class=' mtb15 gis-container-global'>
				<div class='gis-container-admin padlr10'>

					<div class=gis-titlebar>

						<div class='largesubheading addon-title left'>Template File Management</div>

						<div style='clear:both;'></div>

					</div>

	
	
					<!-- File mgmt -->
					<div class=gis-section id="fl-mgmt">

						<a href="javascript:void(0);" class=files>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_small left padrl-10'>&nbsp;</div>
								<span class='section-subheading addon-title left bigtitles'>Files</span>
								<div style='clear:both;'></div>

							</div>
							<span class=panel-action style='display:none;'>accounts-auth</span>
						</div>
						</a>

						<div class='gis-content gt-width-90 padlr20 mtb15' style='display:none;' id="fl-mgmt-dis">dsd</div>

						<!-- hidden but necessary options -->
						<span class=path style='display:none;' id="fl-path"><?php echo $template_path; ?></span>


					</div>

					<div style='clear:both;'></div>

					<!-- File editor -->
					<div class=gis-section>

						<a href="javascript:void(0);" class=editor>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_edit left padrl-10'>&nbsp;</div>
								<span class='section-subheading addon-title left bigtitles'>File Editor</span>
								<div style='clear:both;'></div>

							</div>
							<span class=panel-action style='display:none;'>editor</span>
						</div>
						</a>

						<div class='gis-content gt-width-90 padlr20 mtb15' style='display:none;' id='fl-edit-content'>dsd</div>

						<!-- hidden but necessary options -->
						<span class=panel-action style='display:none;'>accounts-auth</span>

						<span class=path style='display:none;'><?php echo $template_path; ?></span>



					</div>

					<div style='clear:both;'></div>
				</div>
				</td></tr>
<?php } else { ?>
<tr><td>
<div class="rounded-box-red">
    	    <div class="box-contents">
        Before you can use this addon you must select a product.
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
<?php 	}	?>
</td></tr>
		
<?php }?>		
		
				<div style='clear:both;'></div>
	
			</div>
	
		

			<div style='clear:both;'></div>


	
			</div>
		

			<div style='clear:both;'></div>

<script type='text/javascript'>
jQuery(document).ready(function(){

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
show_files($msg);
?>