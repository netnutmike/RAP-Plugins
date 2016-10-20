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

function dlTemplateSelected(form) {
	
	var tmpname = jQuery('#dltemplates').val();

	jQuery.post("addons/GIS/themes/tmp_preview.php", { tmpname: tmpname},
			function(data){
				jQuery('#dl-tmp-preview').html(data);
		  	}
		);
}

function otoTemplateSelected(form) {
	
	var tmpname = jQuery('#ototemplates').val();

	jQuery.post("addons/GIS/themes/tmp_preview.php", { tmpname: tmpname},
			function(data){
				jQuery('#oto-tmp-preview').html(data);
		  	}
		);
}

function otodlTemplateSelected(form) {
	
	var tmpname = jQuery('#otodltemplates').val();

	jQuery.post("addons/GIS/themes/tmp_preview.php", { tmpname: tmpname},
			function(data){
				jQuery('#otodl-tmp-preview').html(data);
		  	}
		);
}

function gdlTemplateSelected(form) {
	
	var tmpname = jQuery('#gdltemplates').val();

	jQuery.post("addons/GIS/themes/tmp_preview.php", { tmpname: tmpname},
			function(data){
				jQuery('#gdl-tmp-preview').html(data);
		  	}
		);
}

function gotoTemplateSelected(form) {
	
	var tmpname = jQuery('#gototemplates').val();

	jQuery.post("addons/GIS/themes/tmp_preview.php", { tmpname: tmpname},
			function(data){
				jQuery('#goto-tmp-preview').html(data);
		  	}
		);
}

function gotodlTemplateSelected(form) {
	
	var tmpname = jQuery('#gotodltemplates').val();

	jQuery.post("addons/GIS/themes/tmp_preview.php", { tmpname: tmpname},
			function(data){
				jQuery('#gotodl-tmp-preview').html(data);
		  	}
		);
}

function aAdvCancel(type) {

	jQuery("#ad-opt-disp").html(loadingimage);
	jQuery.post("addons/GIS/themes/advanced_options.php", {  },
					function(data){
						jQuery('#ad-opt-disp').html(data);
				  	}
				);

}

function aAdvSave(pid) {

	
	var time = jQuery("#time").val();
	var gex1 = jQuery("#gex1").val();
	var gex2 = jQuery("#gex2").val();
	var gex3 = jQuery("#gex3").val();
	var gex4 = jQuery("#gex4").val();
	var gex5 = jQuery("#gex5").val();
	var gex6 = jQuery("#gex6").val();
	var gex7 = jQuery("#gex7").val();
	var gex8 = jQuery("#gex8").val();
	var pex1 = jQuery("#pex1").val();
	var pex2 = jQuery("#pex2").val();
	var pex3 = jQuery("#pex3").val();
	var pex4 = jQuery("#pex4").val();
	var pex5 = jQuery("#pex5").val();
	var pex6 = jQuery("#pex6").val();
	var pex7 = jQuery("#pex7").val();
	var pex8 = jQuery("#pex8").val();
	var gsfdo = jQuery("#gdltemplates").val();
	var gsfoo = jQuery("#gototemplates").val();
	var gsfod = jQuery("#gotodltemplates").val();
	var sfdo = jQuery("#dltemplates").val();
	var sfoo = jQuery("#ototemplates").val();
	var sfod = jQuery("#otodltemplates").val();
	jQuery("#ad-opt-disp").html(loadingimage);
	
	jQuery.post("addons/GIS/themes/advanced_options.php", { gex1: gex1, gex2: gex2, gex3: gex3, gex4: gex4, gex5: gex5, gex6: gex6, gex7: gex7, gex8: gex8,
															pex1: pex1, pex2: pex2, pex3: pex3, pex4: pex4, pex5: pex5, pex6: pex6, pex7: pex7, pex8: pex8,
															gsfdo: gsfdo, gsfoo: gsfoo, gsfod: gsfod, sfdo: sfdo, sfoo: sfoo, sfod: sfod,
															pid: pid, time: time, action: 'save' },
					function(data){
						jQuery('#ad-opt-disp').html(data);
				  	}
				);
}

</script>

<? if ($_POST['action'] == "save") {

	$sql="update g_themeOptions set options='" . $_POST['time'] . "' where timeType='998' and productid='0'";
	$g_goptds=mysql_query($sql);
	
	$g_gOpt = $_POST['gex1'] . " ~~~ " . $_POST['gex2'] . " ~~~ " . $_POST['gex3'] . " ~~~ " . $_POST['gex4'] . " ~~~ " . $_POST['gex5'] . " ~~~ " . $_POST['gex6'] . " ~~~ " . $_POST['gex7'] . " ~~~ " . $_POST['gex8']; 
	$sql="update g_themeOptions set options='" . $g_gOpt . "' where timeType='997' and productid='0'";
	$g_goptds=mysql_query($sql);
	
	if ($_POST['pid'] > 0 ) {
		$g_pOpt = $_POST['pex1'] . " ~~~ " . $_POST['pex2'] . " ~~~ " . $_POST['pex3'] . " ~~~ " . $_POST['pex4'] . " ~~~ " . $_POST['pex5'] . " ~~~ " . $_POST['pex6'] . " ~~~ " . $_POST['pex7'] . " ~~~ " . $_POST['pex8']; 
		$sql="update g_themeOptions set options='" . $g_pOpt . "' where timeType='997' and productid='" . $_POST['pid'] . "'";
		$g_goptds=mysql_query($sql);
	}
	
	$g_gOpt = $_POST['gsfdo'] . " ~~~ " . $_POST['gsfoo'] . " ~~~ " . $_POST['gsfod']; 
	$sql="update g_themeOptions set options='" . $g_gOpt . "' where timeType='996' and productid='0'";
	$g_goptds=mysql_query($sql);
	
	if ($_POST['pid'] > 0 ) {
		$g_pOpt2 = $_POST['sfdo'] . " ~~~ " . $_POST['sfoo'] . " ~~~ " . $_POST['sfod']; 
		$sql="update g_themeOptions set options='" . $g_pOpt2 . "' where timeType='996' and productid='" . $_POST['pid'] . "'";
		$g_goptds=mysql_query($sql);
	}

}?>

<table width="700" cellspacing="0">

<? 	

		//we have 3 different things we need to load: time offset and any other global variables, global extra field names and if product is select the product extra field names
		$sql="select * from g_themeOptions where timeType='998' and productid='0'";
		$g_goptds=mysql_query($sql);
		if (mysql_num_rows($g_goptds) > 0) {
			$g_goptrow = mysql_fetch_array($g_goptds);
			$timeval = $g_goptrow['options'];
		} else {
			$timeval="";
			$sql="insert into g_themeOptions (timeType, productid, options) VALUES ('998', '0', ' ')";
			$g_goptds=mysql_query($sql);
		}
		
		$sql="select * from g_themeOptions where timeType='997' and productid='0'";
		$g_gfldds=mysql_query($sql);
		if (mysql_num_rows($g_gfldds) > 0) {
			$g_gfldrow = mysql_fetch_array($g_gfldds);
			$g_gflds = explode("~~~", $g_gfldrow['options']);
		} else {
			$g_optdef = " ~~~ ~~~ ~~~ ~~~ ~~~ ~~~ ~~~ ";
			$g_gflds = explode("~~~", $g_optdef);
			$sql="insert into g_themeOptions (timeType, productid, options) VALUES ('997', '0', '" . $g_optdef . "')";
			$g_goptds=mysql_query($sql);
		}
		
		$sql="select * from g_themeOptions where timeType='996' and productid='0'";
		$g_gfldds=mysql_query($sql);
		if (mysql_num_rows($g_gfldds) > 0) {
			$g_gfldrow = mysql_fetch_array($g_gfldds);
			$g_gsfo = explode("~~~", $g_gfldrow['options']);
		} else {
			$g_optdef = " ~~~ ~~~ ";
			$g_gsfo = explode("~~~", $g_optdef);
			$sql="insert into g_themeOptions (timeType, productid, options) VALUES ('996', '0', '" . $g_optdef . "')";
			$g_goptds=mysql_query($sql);
		}
		
		
		if ($productID > 0) {
			$sql="select * from g_themeOptions where timeType='997' and productid='" . $productID . "'";
			$g_pfldds=mysql_query($sql);
			if (mysql_num_rows($g_pfldds) > 0) {
				$g_pfldrow = mysql_fetch_array($g_pfldds);
				$g_pflds = explode("~~~", $g_pfldrow['options']);
			} else {
				$g_optdef = " ~~~ ~~~ ~~~ ~~~ ~~~ ~~~ ~~~ ";
				$g_pflds = explode("~~~", $g_optdef);
				$sql="insert into g_themeOptions (timeType, productid, options) VALUES ('997', '" . $productID . "', '" . $g_optdef . "')";
				$g_goptds=mysql_query($sql);
			}
			
			$sql="select * from g_themeOptions where timeType='996' and productid='" . $productID . "'";
			$g_pfldds=mysql_query($sql);
			if (mysql_num_rows($g_pfldds) > 0) {
				$g_pfldrow = mysql_fetch_array($g_pfldds);
				$g_psfo = explode("~~~", $g_pfldrow['options']);
			} else {
				$g_optdef = " ~~~ ~~~ ";
				$g_psfo = explode("~~~", $g_optdef);
				$sql="insert into g_themeOptions (timeType, productid, options) VALUES ('996', '" . $productID . "', '" . $g_optdef . "')";
				$g_goptds=mysql_query($sql);
			}
		}

		
?>


<tr><td colspan="2"><br><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Global Advanced Options:</font><br>&nbsp;</td></tr>
 	
 	<tr bgcolor="#dac8b6"><td align="left">

 	<input type="image" src="/rap_admin/addons/GIS/themes/images/save.png" name="submit" value="Save" onClick="javascript:aAdvSave(<?=$productID;?>);"/>
 	</td><td></td><td align="right"><input type="image" src="/rap_admin/addons/GIS/themes/images/delete48x48.png" name="submit" value="Save" onClick="javascript:aAdvCancel();"/></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts">Time Offset:</td><td><input type="text" name="time" id="time" value="<?= $timeval ?>" size="3"> Hours</td><td>Current Server Time: <?=date("m/d/Y H:i:s")?><br>Current Offset Time: <?=date("m/d/Y H:i:s",strtotime($timeval . " hours"))?></br></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td colspan="2"><br><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Global Extra Field Values:</font><br>&nbsp;</td></tr>
 	
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts">Extra Field 1:</td><td colspan="2"><input type="text" name="gex1" id="gex1" value="<?= trim($g_gflds[0]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 2:</td><td colspan="2"><input type="text" name="gex2" id="gex2" value="<?= trim($g_gflds[1]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 3:</td><td colspan="2"><input type="text" name="gex3" id="gex3" value="<?= trim($g_gflds[2]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 4:</td><td colspan="2"><input type="text" name="gex4" id="gex4" value="<?= trim($g_gflds[3]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 5:</td><td colspan="2"><input type="text" name="gex5" id="gex5" value="<?= trim($g_gflds[4]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 6:</td><td colspan="2"><input type="text" name="gex6" id="gex6" value="<?= trim($g_gflds[5]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 7:</td><td colspan="2"><input type="text" name="gex7" id="gex7" value="<?= trim($g_gflds[6]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 8:</td><td colspan="2"><input type="text" name="gex8" id="gex8" value="<?= trim($g_gflds[7]) ?>" size="40"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td>&nbsp;</td></tr>
 	
 	<? if ($productID > 0) { ?>
 	<tr><td colspan="2"><br><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Product Extra Field Values:</font><br>&nbsp;</td></tr>
 	
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts">Extra Field 1:</td><td colspan="2"><input type="text" name="pex1" id="pex1" value="<?= trim($g_pflds[0]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 2:</td><td colspan="2"><input type="text" name="pex2" id="pex2" value="<?= trim($g_pflds[1]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 3:</td><td colspan="2"><input type="text" name="pex3" id="pex3" value="<?= trim($g_pflds[2]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 4:</td><td colspan="2"><input type="text" name="pex4" id="pex4" value="<?= trim($g_pflds[3]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 5:</td><td colspan="2"><input type="text" name="pex5" id="pex5" value="<?= trim($g_pflds[4]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 6:</td><td colspan="2"><input type="text" name="pex6" id="pex6" value="<?= trim($g_pflds[5]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 7:</td><td colspan="2"><input type="text" name="pex7" id="pex7" value="<?= trim($g_pflds[6]) ?>" size="40"></td></tr>
 	<tr><td class="Prompts">Extra Field 8:</td><td colspan="2"><input type="text" name="pex8" id="pex8" value="<?= trim($g_pflds[7]) ?>" size="40"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td colspan="3"><br><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Global Sales Funnel Theme Overrides:</font><br>&nbsp;</td></tr>
 	
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" valign="top">Download Override:</td><td valign="top"><select name="gdltemplates" size="5" id="gdltemplates" class="productslist" onClick="gdlTemplateSelected(this.form)">
 	<option value=" " <? if (trim($g_gsfo[0]) == "") { echo "SELECTED"; } ?>>No Override</option>
<?   
		$files1 = scandir("themes");

	
		foreach ( $files1 as $file ) {
 			if ($file != "." && $file != ".." ) {
 				if ($file == trim($g_gsfo[0])) { $selected = "SELECTED"; } else { $selected = ""; }
					echo "<option value=\"" . $file . "\" " . $selected . ">" . $file . "</option>";
				}
			}
		?>
 </select></td><td colspan="2"><div id="gdl-tmp-preview"></div></td></tr>
 <tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" valign="top">OTO Override:</td><td valign="top"><select name="gototemplates" size="5" id="gototemplates" class="productslist" onClick="gotoTemplateSelected(this.form)">
 	<option value=" " <? if (trim($g_gsfo[1]) == "") { echo "SELECTED"; } ?>>No Override</option>
<?   
		$files1 = scandir("themes");

	
		foreach ( $files1 as $file ) {
 			if ($file != "." && $file != ".." ) {
 				if ($file == trim($g_gsfo[1])) { $selected = "SELECTED"; } else { $selected = ""; }
					echo "<option value=\"" . $file . "\" " . $selected . ">" . $file . "</option>";
				}
			}
		?>
 </select></td><td colspan="2"><div id="goto-tmp-preview"></div></td></tr>
 <tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" valign="top">OTO Download Override:</td><td valign="top"><select name="gotodltemplates" size="5" id="gotodltemplates" class="productslist" onClick="gotodlTemplateSelected(this.form)">
 	<option value=" " <? if (trim($g_gsfo[2]) == "") { echo "SELECTED"; } ?>>No Override</option>
<?   
		$files1 = scandir("themes");

	
		foreach ( $files1 as $file ) {
 			if ($file != "." && $file != ".." ) {
 				if ($file == trim($g_gsfo[2])) { $selected = "SELECTED"; } else { $selected = ""; }
					echo "<option value=\"" . $file . "\" " . $selected . ">" . $file . "</option>";
				}
			}
		?>
 </select></td><td colspan="2"><div id="gotodl-tmp-preview"></div></td></tr>
 
 
  	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td colspan="3"><br><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Product Sales Funnel Theme Overrides:</font><br>&nbsp;</td></tr>
 	
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" valign="top">Download Override:</td><td valign="top"><select name="dltemplates" size="5" id="dltemplates" class="productslist" onClick="dlTemplateSelected(this.form)">
 	<option value=" " <? if (trim($g_psfo[0]) == "") { echo "SELECTED"; } ?>>No Override</option>
<?   
		$files1 = scandir("themes");

	
		foreach ( $files1 as $file ) {
 			if ($file != "." && $file != ".." ) {
 				if ($file == trim($g_psfo[0])) { $selected = "SELECTED"; } else { $selected = ""; }
					echo "<option value=\"" . $file . "\" " . $selected . ">" . $file . "</option>";
				}
			}
		?>
 </select></td><td colspan="2"><div id="dl-tmp-preview"></div></td></tr>
 <tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" valign="top">OTO Override:</td><td valign="top"><select name="ototemplates" size="5" id="ototemplates" class="productslist" onClick="otoTemplateSelected(this.form)">
 	<option value=" " <? if (trim($g_psfo[1]) == "") { echo "SELECTED"; } ?>>No Override</option>
<?   
		$files1 = scandir("themes");

	
		foreach ( $files1 as $file ) {
 			if ($file != "." && $file != ".." ) {
 				if ($file == trim($g_psfo[1])) { $selected = "SELECTED"; } else { $selected = ""; }
					echo "<option value=\"" . $file . "\" " . $selected . ">" . $file . "</option>";
				}
			}
		?>
 </select></td><td colspan="2"><div id="oto-tmp-preview"></div></td></tr>
 <tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" valign="top">OTO Download Override:</td><td valign="top"><select name="otodltemplates" size="5" id="otodltemplates" class="productslist" onClick="otodlTemplateSelected(this.form)">
 	<option value=" " <? if (trim($g_psfo[3]) == "") { echo "SELECTED"; } ?>>No Override</option>
<?   
		$files1 = scandir("themes");

	
		foreach ( $files1 as $file ) {
 			if ($file != "." && $file != ".." ) {
 				if ($file == trim($g_psfo[2])) { $selected = "SELECTED"; } else { $selected = ""; }
					echo "<option value=\"" . $file . "\" " . $selected . ">" . $file . "</option>";
				}
			}
		?>
 </select></td><td colspan="2"><div id="otodl-tmp-preview"></div></td></tr>
 	
 	<tr><td>&nbsp;</td></tr>
 	<? } ?>
 	
  </table>
  
  
<script language="JavaScript">
	gdlTemplateSelected();
	gotoTemplateSelected();
	gotodlTemplateSelected();

	dlTemplateSelected();
	otoTemplateSelected();
	otodlTemplateSelected();
</script>



