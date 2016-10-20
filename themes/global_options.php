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

?>

<script language="JavaScript">

function aOptionPage(type) {

	jQuery("#gl-opt-disp-set").html(loadingimage);
	jQuery("#gl-opt-disp-set").show();
	jQuery.post("addons/GIS/themes/global_options_edit.php", { type: type },
					function(data){
						jQuery('#gl-opt-disp-set').html(data);
				  	}
				);

	jQuery("#gl-sel-opt").html(type);

	if (type != jQuery("#gl-cur-opt").html() ) {
		jQuery("#gl-opt-save").show();
	} else {
		jQuery("#gl-opt-save").hide();
	}
}

function aglTypeSave() {

	jQuery("#gl-opt-save").html(loadingimage);
	type = jQuery("#gl-sel-opt").html();
	
	jQuery.post("addons/GIS/themes/global_options_edit.php", { type: type, action: 'savetype' },
					function(data){
						jQuery('#gl-opt-save').html(data);
				  	}
				);

	jQuery("#gl-opt-save").hide();
	jQuery("#gl-cur-opt").html(jQuery("#gl-sel-opt").html());
}

</script>

<script type="text/javascript">
    jQuery(function() { jQuery(".lavaLamp").lavaLamp({ fx: "backout", speed: 700 })});
</script>

<table>
<tr><td>
 <?php 
 	$sql = "select * from g_themeOptions where productid='0' and timeType='999'";
	$gid=mysql_query($sql);
	$grow=mysql_fetch_array($gid);?>
	<font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Theme Type:</font>
	<ul class="lavaLamp">
            <li id="li1"><a href="#" onClick="javascript:aOptionPage('0')">Static Theme</a></li>
            <li id="li2"><a href="#" onClick="javascript:aOptionPage('1')">Daily Schedule</a></li>
            <li id="li3"><a href="#" onClick="javascript:aOptionPage('2')">Date/Time</a></li>
            
        </ul>
	
   
  </td>
  <td><div style='display:none;' id='gl-cur-opt'><?= $grow['status'];?></div><div style='display:none;' id='gl-sel-opt'></div><div class='gis-content padding-rl-20' style='display:none;' id='gl-opt-save'><input type="image" src="/rap_admin/addons/GIS/themes/images/save.png" name="submit" value="Save" onClick="javascript:aglTypeSave();"/></div></td>
  </tr>
  <tr><td>
  
</td></tr></table>

<div class='gis-content padding-rl-20 ' style='display:none;' id="gl-opt-disp-set"></div>

<script type="text/javascript">
	//fire('li1','hover');
	<? if ($grow['status'] == 0) { ?>
		jQuery("#li1").trigger("click");
		aOptionPage('0');
	<?  } else if ($grow['status'] == 1) {?>
		jQuery("#li2").trigger("click");
		aOptionPage('1');
	<?  } else if ($grow['status'] == 2) {?>
		jQuery("#li3").trigger("click");
		aOptionPage('2');
	<?  }?>
</script> 