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
//	Copyright:	Copyright, 2009(c), Genius Idea Studio, LLC
//
//	Product Is Available For Download From www.rap-tools.com
//
//	Description:	This file is called to display the global options and to save the global 
// 					options. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/29/09 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php");

?>

<script language="JavaScript">

function aSave() {

	var gid =	jQuery("#gid").val();
	var Goals =	jQuery("#Goals:checked").val();
	var eCommerce = jQuery("#eCommerce:checked").val();
	jQuery.post("addons/GIS/ganalytics/global_options.php", { gid: gid, Goals: Goals, eCommerce: eCommerce },
					function(data){
						jQuery('#gl-opt-disp').html(data);
				  	}
				);
}

</script>

<? if ($_POST['gid'] != "" ) {

	$optionstr = $_POST[Goals] . $_POST['eCommerce'];
	$sql = "Update ganalytics_options set gid='". $_POST['gid'] . "', Options='" . $optionstr . "' where uid=1;";
	$gid=mysql_query($sql);
	
	echo "<script language=\"JavaScript\"> 
	var message =	\"You Global Options Have Been Saved!\"; 
	jQuery.post(\"addons/GIS/ganalytics/global_options.php\", { message: message }, 
					function(data){ 
						jQuery('#gl-opt-disp').html(data); 
				  	} 
				); 
		</script>";
} else { 

	//If a message was passed in display the message in a green box.
	if ($_POST['message'] != "") { ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        <? echo $_POST['message']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
		 	
			jQuery('#message-box').fadeOut(10000);

		</script>
<?	} ?>

<br><br>
<form id="copyfile" name="copyfile" method="post" action="addons/GIS/ganalytics/global_options.php">
<table>
<tr><td>
 <?php 
 	$sql = "select * from ganalytics_options where uid=1;";
	$gid=mysql_query($sql);
	$grow=mysql_fetch_array($gid);?>
   <font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Google ID:</font> <input type="text" name="gid" id="gid" value="<?php echo $grow['gid']; ?>"> <font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">(example: UA-11223344-1)</font>
  </td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
  	<ul class="checklist">
		<li>
			<input id="Goals" name="Goals" value="1" type="checkbox" <? if (substr($grow['Options'],0,1) == '1') { echo "checked"; } ?>>
       		<label for="Goals">Goal Tracking Enabled</label>
       		<a class="checkbox-select" href="#">Select</a>
       		<a class="checkbox-deselect" href="#">Cancel</a>
       	</li>
	</ul>
  </td></tr>
  <tr><td>
  	<ul class="checklist">
		<li>
			<input id="eCommerce" name="eCommerce" value="1" type="checkbox" <? if (substr($grow['Options'],1,1) == '1') { echo "checked"; } ?>>
       		<label for="eCommerce">E-commerce Tracking Enabled</label>
       		<a class="checkbox-select" href="#">Select</a>
       		<a class="checkbox-deselect" href="#">Cancel</a>
       	</li>
	</ul>
  </td></tr>
  <tr><td>
  
 
</form>
<Table><tr><td>
<input type="button" name="submit" id="submit" value="Save" onClick="javascript:aSave();"/>
</td><td>

</td></tr></table>
</td></tr></table>

<? } ?>

<script>
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