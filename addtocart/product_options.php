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

function aAdd() {

	jQuery('#pr-opt-disp').html(loadingimage);
	var pid = jQuery('#products').val();
	jQuery.post("addons/GIS/addtocart/add_addToCart.php", { productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aEdit(uid) {

	jQuery('#pr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/addtocart/edit_addToCart.php", { uid: uid, productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aDelete(uid) {

	jQuery('#pr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/addtocart/delete_addToCart.php", { uid: uid, productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aToggleItem(uid, status, type) {

	var template =	jQuery("#templates").val();
	jQuery('#pr-opt-disp').html(loadingimage);
	
	jQuery.post("addons/GIS/addtocart/product_options.php", { uid: uid, action: 'toggle', status: status, productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

</script>

<? if ($_POST['action'] == "Create" ) {

	$sql = "insert into g_addToCart (Name, productID, regularPrice, copiesPurchased, endDate, endAction, Status, template, soldoutTemplate, CopiesLeftText ) VALUES ('" . $_POST['Name'] . "', '" . $_POST['productID'] . "', '" . $_POST['regularPrice'] . "', '0', '" . $_POST['EndDate'] . "', '" . $_POST['endAction'] . "', '1', '" . $_POST['template'] . "', '" . $_POST['soldoutTemplate'] . "', '" . $_POST['CopiesLeftText'] . "')";
	$gid=mysql_query($sql);
	
	$newid = mysql_insert_id();
	$sql = "insert into g_addToCartBumps (buttonID, todaysPrice, Copies, status) VALUES ('" . $newid . "', '" . $_POST['todaysPrice'] . "', '" . $_POST['Copies'] . "', '1')";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/addtocart/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		New Add-To-Cart Entry Inserted!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
			aEdit(<?= $newid; ?>);
		</script>
<?	} else if ($_POST['action'] == "Delete" ) {
		$sql = "DELETE from g_addToCartBumps where buttonID='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql); 
		$sql = "DELETE from g_addToCart where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql); ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/addtocart/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Add-To-Cart Entry Deleted!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
		
<? 	} else if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_addToCart set Name='" . $_POST['Name'] . "', productID='" . $_POST['productID'] . "', regularPrice='" . $_POST['regularPrice'] . "', endDate='" . $_POST['endDate'] . "', endAction='" . $_POST['endAction'] . "', status='" . $_POST['status'] .  "', template='" . $_POST['template'] . "', soldoutTemplate='" . $_POST['soldoutTemplate'] . "', CopiesLeftText='" . $_POST['CopiesLeftText'] . "', SlashDirection='" . $_POST['SlashDirection'] . "', SlashColor='" . $_POST['SlashColor'] . "', RegularColor='" . $_POST['RegularColor'] . "', TodayColor='" . $_POST['TodayColor'] . "', MoneySymbol='" . $_POST['MoneySymbol'] . "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/addtocart/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Add-To-Cart entry Updated!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} else if ($_POST['action'] == "toggle") {

	$sql = "UPDATE g_addToCart set status='" . $_POST['status'] . "' where uid='" . $_POST['uid'] . "'";
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
		
		<table width="700">
<tr><td colspan="11" align="right" bgcolor="#dac8b6" class="Prompts"><a href="javascript:aAdd();"><img src="addons/GIS/addtocart/images/add48x48.png" border="0"></a><br>Add&nbsp;&nbsp;&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>

<tr class="Prompts"><td class="Prompts"><strong>Name</strong></td><td></td><td align="center"><strong>Regular Price</strong></td><td></td><td align="center"><strong>End Date</strong></td><td></td><td><strong>Views / Clicks / Sold</strong></td><td></td><td><strong>Status</strong></td><td></td><td><strong>Options</strong></td></tr>
<?
 	$sql="select * from g_addToCart where productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	if ( mysql_num_rows($gid) < 1 ) {
		echo "<tr><td colspan=\"9\"><i>No Add-To-Cart options for this product.  Click the add button above to add one</i></td></tr>";
	} else {
		while ($grow = mysql_fetch_array($gid)) { 
			switch ($grow['status']) {
				case '0':
					$ststxt = "Disabled";
					$stsbg = " bgcolor=\"#FFEEEE\"";
					$imgpth = "/rap_admin/addons/GIS/addtocart/images/red_button32x32.png";
					$toggleaction = "javascript:aToggleItem('" . $grow['uid'] . "', '1', '2')";
					break;
				case '1':
					$ststxt = "Enabled";
					$stsbg = "";
					$imgpth = "/rap_admin/addons/GIS/addtocart/images/green_button32x32.png";
					$toggleaction = "javascript:aToggleItem('" . $grow['uid'] . "', '0', '2')";
					break;
				case '2':
					$ststxt = "Active";
					$stsbg = "";
					$imgpth = "/rap_admin/addons/GIS/addtocart/images/green_button32x32.png";
					$toggleaction = "javascript:aToggleItem('" . $grow['uid'] . "', '0', '2')";
					break;
				} ?>
			<tr class="Prompts"><td><?= $grow['Name']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['regularPrice']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['endDate']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['ViewCount']; ?> / <?= $grow['ClickCount']; ?> / <?= $grow['CopiesPurchased']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"<?= $stsbg;?>><a href="#" onClick="<?= $toggleaction;?>"><img src="<?=$imgpth;?>" border="0" width="24" height="24"></a><?= $ststxt; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><a href="javascript:aEdit('<?= $grow['uid']; ?>')"><img src="addons/GIS/addtocart/images/edit32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aDelete('<?= $grow['uid']; ?>')"><img src="addons/GIS/addtocart/images/delete32x32.png" border="0"></a>&nbsp;</td>
  			</tr>
<? 			}
	} ?>  
  <tr><td>
  
</td></tr></table>
		
		




