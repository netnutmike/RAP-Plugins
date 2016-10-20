<? 
//==============================================================================================
//
//	Filename:	product_options.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2009(c), Genius Idea Studio, LLC
//
//	Product Is Available For Download From www.rap-tools.com
//
//	Description:	This file is called when the user wants to copy a file. 
//
//	Version:	1.0.0 (February 5rd, 2009)
//
//	Change Log:
//				02/05/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); 

$g_basedir = "../../../addons/";


?>

<script language="JavaScript">

function showdescription(g_aid) {
	g_section = "#in" + g_aid + "-desc";
	jQuery(g_section).toggle();
}

function showudescription(g_aid) {
	g_section = "#u" + g_aid + "-desc";
	jQuery(g_section).toggle();
}

function removeaddon(g_aid) {

	jQuery('#main-dis').html(loadingimage);
	jQuery.post("addons/GIS/raptools/remove_addon.php", { aid: g_aid},
			function(data){
				jQuery('#main-dis').html(data);
		  	}
		);
}

function uploadaddon() {

	jQuery('#main-dis').html(loadingimage);
	jQuery.post("addons/GIS/raptools/upload_addonf.php", { },
			function(data){
				jQuery('#main-dis').html(data);
		  	}
		);
}

</script>

<script type="text/javascript" src="addons/GIS/raptools/js/rap-tools.js"></script>

<table>
<tr><td>
 
 <table>

 <tr><td colspan="2">&nbsp;</td></tr>
 <tr><td colspan="2"><a href="javascript:uploadaddon();" id="upldaddon"><img src="addons/GIS/raptools/images/addaddon64x64.png" border="0" align="right"></a></td></tr>
 
 <tr><td><strong>Installed and Active Add-ons:</strong></td><td></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td colspan="2">
 <table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
 <? 
 	$query = "select * from addons order by title";		
	$request = mysql_query($query);
	while ($prs = mysql_fetch_array($request)){	

  ?>
 <ul class="checklist">
<li>
<input id="i<?= $prs['id']; ?>" name="<?= $prs['id']; ?>" value="1" type="checkbox" checked >
					<a href="javascript:showdescription(<?= $prs['id'];?>);" id="in<?= $prs['id'];?>"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
					<a href="javascript:removeaddon(<?= $prs['id'];?>);" id="rin<?= $prs['id'];?>"><img src="addons/GIS/raptools/images/remove_addon.png" border="0" align="right"></a>
				<!-- 	<a href="javascript:showupgradeinfo(<?= $prs['id'];?>);" id="in<?= $prs['id'];?>"><img src="addons/GIS/raptools/images/warning2.png" border="0" align="right"></a> -->
					
                    <label for="i<?= $prs['id']; ?>"><?= $prs['title'];?></label>
</li></ul>
<? $g_xmlFile = $g_basedir . $prs['groupfolder'] . "/" . $prs['addonfolder'] . "/addon_version.xml"; 
?>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="in<?= $prs['id'];?>-desc"><?= $prs['description']?>
<? if (file_exists($g_xmlFile)) { ?>
<br><br><strong>Version:</strong> <?= g_getAddonXML($g_xmlFile, "VERSION");?><br><strong>Release Date: </strong><?= g_getAddonXML($g_xmlFile, "RELEASEDATE");?><br><strong>Author: </strong><?= g_getAddonXML($g_xmlFile, "AUTHOR");?><br><strong>Product URL: </strong><a href="<?= g_getAddonXML($g_xmlFile, "PRODUCTURL");?>" target="_blank"><?= g_getAddonXML($g_xmlFile, "PRODUCTURL");?></a>

<?
	}
?>
</div>
<p>&nbsp;</p>
<? } ?>
</td></tr>
 </table>
  </td></tr>
<tr><td>&nbsp;</td></tr>
 <tr><td><strong>In-Active Add-ons:</strong></td><td></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td colspan="2">
 <table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
 <? 
 

 if (is_dir($g_basedir)) {
 	$g_files1 = scandir($g_basedir);
 	$g_arrcnt=0;

	foreach ( $g_files1 as $g_file ) {
 		$g_files2 = scandir($g_basedir. "/" . $g_file);
		
 		if ($g_file != "." && $g_file != ".." ) {
			foreach ( $g_files2 as $g_file2 ) {
 				if ($g_file2 != "." && $g_file2 != ".." )
 					//before we add it to the array make sure it can be installed and run after
 					if (file_exists($g_basedir . $g_file . "/" . $g_file2 . "/install.php") && file_exists($g_basedir . $g_file . "/" . $g_file2 . "/install.php")) {
 						$g_ar_name[$g_arrcnt] = $g_file2;
 						$g_ar_path[$g_arrcnt] = $g_file . "/" . $g_file2;
 						$g_ar_company[$g_arrcnt] = $g_file;
 						$g_ar_addon[$g_arrcnt] = $g_file2;
 						++$g_arrcnt;
 					}
				}
 			}
		}
 }

 	$g_ar_name_lc = array_map('strtolower', $g_ar_name);
 	
	array_multisort($g_ar_name, $g_ar_path);

	foreach($g_ar_name as $g_ar_indx => $g_addon_name) {

		//check to make sure that the addon has not already been installed
		
		//if there is an xml description file use that for the name
		$g_xmlFile = $g_basedir . $g_ar_path[$g_ar_indx] . "/addon_version.xml";
		$query = "select * from addons where groupfolder='" . $g_ar_company[$g_ar_indx] . "'
				AND addonfolder='" . $g_ar_addon[$g_ar_indx] . "'";
		
		//echo $query . "<br><br>";
		$request = mysql_query($query);
		if (mysql_num_rows($request) == 0) {
				
	
  ?>
 <ul class="checklist">
<li>
<input id="u<?= $g_ar_indx; ?>" name="u<?= $g_ar_indx; ?>" value="1" type="checkbox"  >
<?
	if (file_exists($g_xmlFile)) {
 ?>
					<a href="javascript:showudescription(<?= $g_ar_indx; ?>);" id="u<?= $prs['id'];?>"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
					
<?		$g_aName = g_getAddonXML($g_xmlFile, "NAME");
	} else { ?>		
					<img src="addons/GIS/raptools/images/blank.png" border="0" align="right">
<?		$g_aName = $g_addon_name;
 	}?>	
					<a href="/rap_admin/index.php?action=addon&path=<?= $g_ar_path[$g_ar_indx]; ?>&do=install" id="aa<?= $prs['id'];?>" target="_blank"><img src="addons/GIS/raptools/images/activate_addon.png" border="0" align="right"></a>		
                    <label for="u<?= $g_ar_indx; ?>"><?= $g_aName;?></label>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="u<?= $g_ar_indx; ?>-desc"><?= g_getAddonXML($g_xmlFile, "DESCRIPTION");?><br><br><strong>Version: </strong><?= g_getAddonXML($g_xmlFile, "VERSION");?><br><strong>Release Date: </strong><?= g_getAddonXML($g_xmlFile, "RELEASEDATE");?><br><strong>Author: </strong><?= g_getAddonXML($g_xmlFile, "AUTHOR");?><br><strong>Product URL: </strong><a href="<?= g_getAddonXML($g_xmlFile, "PRODUCTURL");?>" target="_blank"><?= g_getAddonXML($g_xmlFile, "PRODUCTURL");?></a></div>
<p>&nbsp;</p>
<?		}
 	} ?>
</td></tr>
 </table>
  </td></tr></table>


<script type='text/javascript'>
jQuery(document).ready(function() {
	 
    /* see if anything is previously checked and reflect that in the view*/
    jQuery(".checklist input:checked").parent().addClass("selected");
 
});

</script>