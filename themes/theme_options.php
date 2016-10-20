<?
//==============================================================================================
//
//	Filename:	theme_options.php
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
//				03/20/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php");

?>

<script language="JavaScript">

function aOptionTheme(type) {

	jQuery("#th-opt-disp-set").html(loadingimage);
	jQuery("#th-opt-disp-set").show();
	jQuery.post("addons/GIS/themes/theme_options_edit.php", { type: type },
					function(data){
						jQuery('#th-opt-disp-set').html(data);
				  	}
				);
}

</script>

<script type="text/javascript">
    jQuery(function() { jQuery(".lavaLamp").lavaLamp({ fx: "backout", speed: 700 })});
</script>

<table>
<tr><td>
	<font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Action:</font>
	<ul class="lavaLamp">
            <li id="li1"><a href="#" onClick="javascript:aOptionTheme('0')">New Themes</a></li>
            <li id="li2"><a href="#" onClick="javascript:aOptionTheme('1')">Upload Theme</a></li>
            <li id="li3"><a href="#" onClick="javascript:aOptionTheme('2')">Edit Theme</a></li>
            
        </ul>
	
   
  </td>
  <td></td>
  </tr>
  <tr><td>
  
</td></tr></table>

<div class='gis-content padding-rl-20 ' style='display:none;' id="th-opt-disp-set"></div>

<script type="text/javascript">
	aOptionTheme('0');
</script> 
