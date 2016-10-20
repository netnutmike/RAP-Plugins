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
	jQuery.post("addons/GIS/ganalytics/global_options.php", { gid: gid },
					function(data){
						jQuery('#gl-opt-disp').html(data);
				  	}
				);
}

</script>

<? if ($_POST['gid'] != "" ) {

	$sql = "Update ganalytics_options set gid='". $_POST['gid'] . "' where uid=1;";
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
		 	jQuery('#message-box').effect("pulsate", { times:3 }, 2000);
			jQuery('#message-box').fadeOut(10000);

		</script>
<?	} ?>

<form id="copyfile" name="copyfile" method="post" action="addons/GIS/ganalytics/global_options.php">
<table>
<tr><td>
 <?php 
 	$sql = "select * from ganalytics_options where uid=1;";
	$gid=mysql_query($sql);
	$grow=mysql_fetch_array($gid);?>
   <font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Google ID:</font> <input type="text" name="gid" id="gid" value="<?php echo $grow['gid']; ?>"> <font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">(example: UA-11223344-1)</font>
  </td></tr>
  <tr><td>
  
 
</form>
<Table><tr><td>
<input type="button" name="submit" id="submit" value="Save" onClick="javascript:aSave();"/>
</td><td>

</td></tr></table>
</td></tr></table>

<? } ?>