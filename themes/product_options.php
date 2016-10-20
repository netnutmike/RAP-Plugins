<?
//==============================================================================================
//
//	Filename:	global_options.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2010(c), Genius Idea Studio, LLC
//
//	Product Is Available For Download From www.rap-tools.com
//
//	Description:	This file is called to display the global options and to save the global 
// 					options. 
//
//	Version:	1.0.0 (March 11th, 2010)
//
//	Change Log:
//				03/11/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php");

$productID = $_REQUEST['productID'];

?>

<script language="JavaScript">

function aOptionPageProd(type, pid) {

	jQuery("#pr-opt-disp-set").html(loadingimage);
	jQuery("#pr-opt-disp-set").show();
	jQuery.post("addons/GIS/themes/product_options_edit.php", { type: type, pid: pid },
					function(data){
						jQuery('#pr-opt-disp-set').html(data);
				  	}
				);

	jQuery("#pr-sel-opt").html(type);

	if (type != jQuery("#pr-cur-opt").html() ) {
		jQuery("#pr-opt-save").show();
	} else {
		jQuery("#pr-opt-save").hide();
	}
}

function aprTypeSave(pid) {

	jQuery("#pr-opt-save").html(loadingimage);
	type = jQuery("#pr-sel-opt").html();
	
	jQuery.post("addons/GIS/themes/product_options_edit.php", { type: type, action: 'savetype', pid: pid },
					function(data){
						jQuery('#pr-opt-save').html(data);
				  	}
				);

	jQuery("#pr-opt-save").hide();
	jQuery("#pr-cur-opt").html(jQuery("#pr-sel-opt").html());
}

</script>

<script type="text/javascript">
    jQuery(function() { jQuery(".lavaLamp2").lavaLamp({ fx: "backout", speed: 700 })});
</script>

<table>
<tr><td>
 <?php 
 	$sql = "select * from g_themeOptions where productid='" . $productID . "' and timeType='999'";
	$gid=mysql_query($sql);
	$grow=mysql_fetch_array($gid);?>
	<font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Theme Type:</font>
	<ul class="lavaLamp2">
			<li id="li4p"><a href="#" onClick="javascript:aOptionPageProd('999', '<?= $productID; ?>')">Global Options</a></li>
            <li id="li1p"><a href="#" onClick="javascript:aOptionPageProd('0', '<?= $productID; ?>')">Static</a></li>
            <li id="li2p"><a href="#" onClick="javascript:aOptionPageProd('1', '<?= $productID; ?>')">Daily </a></li>
            <li id="li3p"><a href="#" onClick="javascript:aOptionPageProd('2', '<?= $productID; ?>')">Date/Time</a></li> 
        </ul>
  </td>
  <td><div style='display:none;' id='pr-cur-opt'><?= $grow['status'];?></div><div style='display:none;' id='pr-sel-opt'></div><div class='gis-content padding-rl-20' style='display:none;' id='pr-opt-save'><input type="image" src="/rap_admin/addons/GIS/themes/images/save.png" name="submit" value="Save" onClick="javascript:aprTypeSave('<?= $productID; ?>');"/></div></td>
  </tr>
  <tr><td>
  
</td></tr></table>

<div class='gis-content padding-rl-20 ' style='display:none;' id="pr-opt-disp-set"></div>

<script type="text/javascript">
	//fire('li1','hover');
	<? if ($grow['status'] == 0) { ?>
		jQuery("#li1p").trigger("click");
		aOptionPageProd('0', '<?= $productID; ?>');
	<?  } else if ($grow['status'] == 1) {?>
		jQuery("#li2p").trigger("click");
		aOptionPageProd('1', '<?= $productID; ?>');
	<?  } else if ($grow['status'] == 2) {?>
		jQuery("#li3p").trigger("click");
		aOptionPageProd('2', '<?= $productID; ?>');
	<?  } else if ($grow['status'] == 999) {?>
		jQuery("#li4p").trigger("click");
		aOptionPageProd('999', '<?= $productID; ?>');
	<?  }?>
</script> 