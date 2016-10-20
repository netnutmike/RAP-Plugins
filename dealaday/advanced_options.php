<?php 

//==============================================================================================
//
//	Filename:	advanced_options.php
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
//	Description:	This file is called to set advanced options. 
//
//	Version:	1.0.0 (July 1st, 2010)
//
//	Change Log:
//				07/01/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); ?>

<script language="JavaScript">

function aSave() {

	var Active = jQuery('#Active:checked').val();
	var URL = jQuery('#URL').val();
	jQuery('#ad-opt-disp').html(loadingimage);
	
	jQuery.post("addons/GIS/addtocart/advanced_options.php", { productID: "<?= $_REQUEST['productID']; ?>", Active: Active, URL: URL, action: "Update" },
		function(data){
			jQuery('#ad-opt-disp').html(data);
			}
		);
}

</script>

<? if  ($_POST['action'] == "Update" ) {

	$sql = "SELECT * from g_addToCartOptions where OptionName='ForwardURL' AND productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0)
		$sql = "UPDATE g_addToCartOptions set Value='" . $_POST['URL'] . "' where OptionName='ForwardURL' AND productID='" . $_POST['productID'] . "'";
	else
		$sql = "INSERT INTO g_addToCartOptions (productID, OptionName, Value) VALUES ('" . $_POST['productID'] . "', 'ForwardURL', '" . $_POST['URL'] . "')";
		
	$gid=mysql_query($sql);
	
	$sql = "SELECT * from g_addToCartOptions where OptionName='ForwardActive' AND productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0)
		$sql = "UPDATE g_addToCartOptions set Value='" . $_POST['Active'] . "' where OptionName='ForwardActive' AND productID='" . $_POST['productID'] . "'";
	else
		$sql = "INSERT INTO g_addToCartOptions (productID, OptionName, Value) VALUES ('" . $_POST['productID'] . "', 'ForwardActive', '" . $_POST['Active'] . "')";

	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/addtocart/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Advanced Options Updated!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} else { 

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
		
		
	<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Edit Advanced Options</p>";
		
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts" valign="center">

 	<input type="image" src="/rap_admin/addons/GIS/addtocart/images/save.png" name="submit" value="Save" onClick="javascript:aSave('<?= $_REQUEST['uid']; ?>');"/><br>&nbsp; Save
 	</td><td></td><td align="right" class="Prompts" valign="center"></td></tr>
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table>
 	<? 
 	$sql = "select * from g_addToCartOptions where OptionName='ForwardURL' and productID='" . $_REQUEST['productID'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
	?>
 	<tr><td class="Prompts">Forward To URL:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="URL" id="URL" value="<?= $grow['Value'];?>"></td><td><strong>
 	<? if (substr($grow['Value'],0,7)!= "http://" && substr($grow['Value'],0,8)!= "https://") echo "<font color=\"red\">"; ?>
 	Must be in <i>http://xxxx.com</i> format
 	<? if (substr($grow['Value'],0,7)!= "http://" && substr($grow['Value'],0,8)!= "https://") echo "</font>"; ?>
 	</strong></td></tr>
 	<tr><td>&nbsp;</td></tr></table></td></tr>
		<tr><td>&nbsp;</td></tr>
 	
 	<tr><td colspan="4">
 		<ul class="checklist">
						<li>
						<? 
 						$sql = "select * from g_addToCartOptions where OptionName='ForwardActive' and productID='" . $_REQUEST['productID'] . "'";
						$gid=mysql_query($sql);
						$grow = mysql_fetch_array($gid);
						?>
							<input id="Active" name="Active" value="1" type="checkbox" <? if ($grow['Value'] == '1' || $grow['Value'] == '2') { echo "checked"; } ?>>
                    		<label for="status">Active URL Forwarding</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
 		</td></tr>
 		<tr><td>&nbsp;</td></tr>
 		</table>

<script type='text/javascript'>


/* see if anything is previously checked and reflect that in the view*/
jQuery(".checklist input:checked").parent().addClass("selected");

/* handle the user selections */
jQuery(".checklist .checkbox-select").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().addClass("selected");
        jQuery(this).parent().find(":checkbox").attr("checked","checked");
        
    }
    
);

jQuery(".checklist .checkbox-deselect").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().removeClass("selected");
        jQuery(this).parent().find(":checkbox").removeAttr("checked");
        
    }
    
);

</script>


