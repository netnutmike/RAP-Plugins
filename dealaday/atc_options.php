<?php 

//==============================================================================================
//
//	Filename:	addtocart.php
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
//	Description:	This file is called to provide a file description from the database. 
//
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				02/17/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); ?>

<script language="JavaScript">

function aAddatc() {

	
	var pid = "<?= $_POST['atcid']; ?>";
	jQuery('#atc-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/addtocart/add_bumps.php", { pid: pid, productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-opt-disp').html(data);
				  	}
				);
}

function aEditatc(uid) {

	jQuery('#atc-opt-disp').html(loadingimage);
	var atcid = "<?= $_POST['atcid']; ?>";
	jQuery.post("addons/GIS/addtocart/edit_bumps.php", { uid: uid, atcid: atcid, productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-opt-disp').html(data);
				  	}
				);
}

function aDeleteatc(uid) {

	jQuery('#atc-opt-disp').html(loadingimage);
	var atcid = "<?= $_POST['atcid']; ?>";
	jQuery.post("addons/GIS/addtocart/delete_bumps.php", { uid: uid, atcid: atcid, productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-opt-disp').html(data);
				  	}
				);
}

function aToggleItematc(uid, status, type) {

	jQuery('#atc-opt-disp').html(loadingimage);
	var atcid = "<?= $_POST['atcid']; ?>";
	jQuery.post("addons/GIS/addtocart/atc_options.php", { uid: uid, action: 'toggle', status: status, atcid: atcid, productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-opt-disp').html(data);
				  	}
				);
}

</script>

<? if ($_POST['action'] == "Create" ) {

	$sql = "insert into g_addToCartBumps (buttonID, todaysPrice, Copies, status) VALUES ('" .  $_POST['atcid'] . "', '" . $_POST['todaysPrice'] . "', '" . $_POST['Copies'] . "', '1')";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/addtocart/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		New Add-To-Cart Bump Entry Inserted! 
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#atc-preview-disp').html(loadingimage);
			jQuery.post("addons/GIS/addtocart/atc_preview.php", { atcid: '<?= $_POST['atcid']; ?>', productID: "<?= $_REQUEST['productID']; ?>" },
						function(data){
							jQuery('#atc-preview-disp').html(data);
					  	}
					);	
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} else if ($_POST['action'] == "Delete" ) {
		$sql = "DELETE from g_addToCartBumps where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql); 
		 ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/addtocart/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Add-To-Cart Bump Entry Deleted!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#atc-preview-disp').html(loadingimage);
			jQuery.post("addons/GIS/addtocart/atc_preview.php", { atcid: '<?= $_POST['atcid']; ?>', productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-preview-disp').html(data);
				  	}
				);	
			jQuery('#message-box').fadeOut(10000);
		</script>
		
<? 	} else if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_addToCartBumps set Copies='" . $_POST['Copies'] . "', todaysPrice='" . $_POST['todaysPrice'] . "', status='" . $_POST['status'] .  "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/addtocart/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Add-To-Cart Bump entry Updated!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#atc-preview-disp').html(loadingimage);
			jQuery.post("addons/GIS/addtocart/atc_preview.php", { atcid: '<?= $_POST['atcid']; ?>', productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#atc-preview-disp').html(data);
				  	}
				);	
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} else if ($_POST['action'] == "toggle") {

	$sql = "UPDATE g_addToCartBumps set status='" . $_POST['status'] . "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	
 	} else { 

	//If a message was passed in display the message in a green box.
	if ($_POST['message'] != "") { ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/addtocart/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		<? echo $_POST['message']; ?>
        		</i><br>&nbsp;
        
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);

		</script>
<?	}

	}?>
		
		<!-- This seems weird but to combine php and JS I am putting a blank span with data so I can read it in js, only way I can get to work reliably -->
		<span class=pid style='display:none;' id="atcid"><? echo $_POST['atcid']; ?></span>
		<table width="700">
		<tr bgcolor="#fd9423"><td colspan="9" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Price Changes</p>";
		
?>

</font></td></tr>
<tr><td colspan="9" align="right" bgcolor="#dac8b6" class="Prompts"><a href="javascript:aAddatc();"><img src="addons/GIS/addtocart/images/add48x48.png" border="0"></a><br>Add&nbsp;&nbsp;&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>

<tr class="Prompts"><td class="Prompts"><strong>Copies</strong></td><td></td><td align="center"><strong>Todays Price</strong></td><td></td><td align="center"><strong>Views / Clicks</strong></td><td></td><td><strong>Status</strong></td><td></td><td><strong>Options</strong></td></tr>
<?
 	$sql="select * from g_addToCartBumps where buttonID='" . $_POST['atcid'] . "' ORDER BY Copies";
	$gid=mysql_query($sql);
	if ( mysql_num_rows($gid) < 1 ) {
		echo "<tr><td colspan=\"9\"><i>No Add-To-Cart Bump options for this product.  Click the add button above to add one</i></td></tr>";
	} else {
		while ($grow = mysql_fetch_array($gid)) { 
			switch ($grow['status']) {
				case '0':
					$ststxt = "Disabled";
					$stsbg = " bgcolor=\"#FFEEEE\"";
					$imgpth = "/rap_admin/addons/GIS/addtocart/images/red_button32x32.png";
					$toggleaction = "javascript:aToggleItematc('" . $grow['uid'] . "', '1', '2')";
					break;
				case '1':
					$ststxt = "Enabled";
					$stsbg = "";
					$imgpth = "/rap_admin/addons/GIS/addtocart/images/green_button32x32.png";
					$toggleaction = "javascript:aToggleItematc('" . $grow['uid'] . "', '0', '2')";
					break;
				case '2':
					$ststxt = "Active";
					$stsbg = "";
					$imgpth = "/rap_admin/addons/GIS/addtocart/images/green_button32x32.png";
					$toggleaction = "javascript:aToggleItematc('" . $grow['uid'] . "', '0', '2')";
					break;
				} ?>
			<tr class="Prompts"><td><?= $grow['Copies']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['todaysPrice']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['ViewCount']; ?> / <?= $grow['ClickCount']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"<?= $stsbg;?>><a href="#" onClick="<?= $toggleaction;?>"><img src="<?=$imgpth;?>" border="0" width="24" height="24"></a><?= $ststxt; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><a href="javascript:aEditatc('<?= $grow['uid']; ?>')"><img src="addons/GIS/addtocart/images/edit32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aDeleteatc('<?= $grow['uid']; ?>')"><img src="addons/GIS/addtocart/images/delete32x32.png" border="0"></a>&nbsp;</td>
  			</tr>
<? 			}
	} ?>  
  <tr><td>
  
</td></tr></table>
		
		




