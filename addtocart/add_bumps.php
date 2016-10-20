<?
//==============================================================================================
//
//	Filename:	add_bumps.php
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
//	Description:	This file is called when the user wants to copy a file. 
//
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				02/17/10 - Initial Version (JMM)
//
//==============================================================================================
?>

<script language="JavaScript">

function aCreateCancelbumps() {

	jQuery('#atc-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/addtocart/atc_options.php", { atcid: "<?= $_REQUEST['pid'];?>", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-opt-disp').html(data);
				  	}
				);
}

function aCreatebumps() {

	var todaysPrice = jQuery("#todaysPrice").val();
	var Copies = jQuery("#Copies").val();
	jQuery('#atc-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/addtocart/atc_options.php", { todaysPrice: todaysPrice, Copies: Copies, atcid: "<?= $_REQUEST['pid'];?>", action: "Create", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-opt-disp').html(data);
				  	}
				);
}

</script>

<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">New Add-To-Cart Bump Entry</p>";
		
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts">

 	<input type="image" src="/rap_admin/addons/GIS/addtocart/images/save.png" name="submit" value="Save" onClick="javascript:aCreatebumps();"/><br>&nbsp;&nbsp;Save
 	</td><td></td><td align="right" class="Prompts"><input type="image" src="/rap_admin/addons/GIS/addtocart/images/delete48x48.png" name="submit" value="Save" onClick="javascript:aCreateCancelbumps();"/><br>Cancel&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table>
 	<tr><td class="Prompts">Copies:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="Copies" id="Copies"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Today's Price:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="todaysPrice" id="todaysPrice" ></td></tr>
 	<tr><td>&nbsp;</td></tr>

 	
  <tr><td colspan="3">
  
</td></tr></table>


