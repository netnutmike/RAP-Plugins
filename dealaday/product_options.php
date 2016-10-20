<?php 

//==============================================================================================
//
//	Filename:	product_options.php
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


require_once("../../../settings.php"); 

if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_dealaDayOptions set orderLink='" . $_POST['orderLink'] . "', hopLink='" . $_POST['hopLink'] . "', status='" . $_POST['status'] . "' where productID='" . $_POST['productID'] . "' AND entryType='1'";
	$gid=mysql_query($sql);
	
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/dealaday/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Deal-A-Day Options Updated!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} ?>

<script language="JavaScript">

function aSavedad() {

	var orderLink =	jQuery("#orderLink").val();
	var hopLink =	jQuery("#hopLink").val();
	var status =	jQuery("#status").val();

	jQuery('#pr-opt-disp').html(loadingimage);
	
	jQuery.post("addons/GIS/dealaday/product_options.php", { orderLink: orderLink, hopLink: hopLink, status: status, action: "Update", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}


function aOptionPage(type) {

	jQuery("#status").val(type);

}


</script>

<?
	$sql="select * from g_dealaDayOptions where productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) == 0) {
		$sql="insert into g_dealaDayOptions (productID, status) VALUES ('" . $_POST['productID'] . "', '0')";
		$gid=mysql_query($sql);
		$sql="select * from g_dealaDayOptions where productID='" . $_POST['productID'] . "'";
		$gid=mysql_query($sql);
	}
	$grow = mysql_fetch_array($gid);
?>
<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Edit Deal-A-Day Site Options</p>";
		
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts">

 	<input type="image" src="/rap_admin/addons/GIS/dealaday/images/save.png" name="submit" value="Save" onClick="javascript:aSaveatc();"/><br>&nbsp;&nbsp;Save
 	</td><td></td><td align="right" class="Prompts"></td></tr>
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table>
 	<tr><td class="Prompts" >Run a Deal-A-Day on:</td><td>&nbsp;&nbsp;</td><td><ul class="checklist_small">
						<li>
							<input id="Sunday" name="Sunday" value="1" type="checkbox" <? if (substr($grow['DirectoryActive'],0,1) == 'S') { echo "checked"; } ?>>
                    		<label for="Sunday">Sunday</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul><ul class="checklist_small">
						<li>
							<input id="Monday" name="Monday" value="1" type="checkbox" <? if (substr($grow['DirectoryActive'],1,1) == 'M') { echo "checked"; } ?>>
                    		<label for="Monday">Monday</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul><ul class="checklist_small">
						<li>
							<input id="Tuesday" name="Tuesday" value="1" type="checkbox" <? if (substr($grow['DirectoryActive'],2,1) == 'T') { echo "checked"; } ?>>
                    		<label for="Tuesday">Tuesday</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul><ul class="checklist_small">
						<li>
							<input id="Wednesday" name="Wednesday" value="1" type="checkbox" <? if (substr($grow['DirectoryActive'],3,1) == 'W') { echo "checked"; } ?>>
                    		<label for="Wednesday">Wednesday</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul><ul class="checklist_small">
						<li>
							<input id="Thursday" name="Thursday" value="1" type="checkbox" <? if (substr($grow['DirectoryActive'],4,1) == 'T') { echo "checked"; } ?>>
                    		<label for="Thursday">Thursday</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul><ul class="checklist_small">
						<li>
							<input id="Friday" name="Friday" value="1" type="checkbox" <? if (substr($grow['DirectoryActive'],5,1) == 'F') { echo "checked"; } ?>>
                    		<label for="Friday">Friday</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul><ul class="checklist_small">
						<li>
							<input id="Saturday" name="Saturday" value="1" type="checkbox" <? if (substr($grow['DirectoryActive'],6,1) == 'S') { echo "checked"; } ?>>
                    		<label for="Saturday">Saturday</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul></br></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" >Start Time:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="StartTime" id="StartTime" size="6" value="<?= $grow['StartTime'];?>"> (default is 00:00 or midnight)
 	</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" >Run Hours:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="RunHours" id="RunHours" size="6" value="<?= $grow['RunHours'];?>"> (default is 24 hours)
 	</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" >Countdown Style:</td><td>&nbsp;&nbsp;</td><td>
 	</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" >Copies Style:</td><td>&nbsp;&nbsp;</td><td>
 	</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" >Active In Directory:</td><td>&nbsp;&nbsp;</td><td><ul class="checklist">
						<li>
							<input id="DirectoryActive" name="DirectoryActive" value="1" type="checkbox" <? if ($grow['DirectoryActive'] == '1' || $grow['DirectoryActive'] == '2') { echo "checked"; } ?>>
                    		<label for="DirectoryActive">List In Directory</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul></td></tr>
 	 		
 		<tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td colspan="3">
  
 

</td></tr></table>
<div class='gis-content padding-rl-20' id="atc-opt-disp"></div>

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



/* see if anything is previously checked and reflect that in the view*/
jQuery(".checklist_small input:checked").parent().addClass("selected");

/* handle the user selections */
jQuery(".checklist_small .checkbox-select").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().addClass("selected");
        jQuery(this).parent().find(":checkbox").attr("checked","checked");
    }
);

jQuery(".checklist_small .checkbox-deselect").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().removeClass("selected");
        jQuery(this).parent().find(":checkbox").removeAttr("checked");
    }
    
);

</script>