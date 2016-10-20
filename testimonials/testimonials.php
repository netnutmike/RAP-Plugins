<?php 

//==============================================================================================
//
//	Filename:	testimonials.php
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
	jQuery.post("addons/GIS/testimonials/add_testimonial.php", { pid: pid },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aEdit(uid) {

	jQuery('#pr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/testimonials/edit_testimonial.php", { uid: uid },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aDelete(uid) {

	jQuery('#pr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/testimonials/delete_testimonial.php", { uid: uid },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}
</script>

<? if ($_POST['action'] == "Create" ) {

	$sql = "insert into g_testimonials (Name, productID, Date, Time, VisualName, FromLocation, Email, Status, ShortSubject, Testimonial, UseWhere, LastUsed, VideoURL) VALUES ('" . $_POST['Name'] . "', '" . $_POST['pid'] . "', '" . date("Ymd") . "', '" . date("Gis") . "', '" . $_POST['VisualName'] . "', '" . $_POST['FromLocation'] . "', '" . $_POST['Email'] . "', '1', '" . $_POST['ShortSubject'] . "', '" . $_POST['Testimonial'] . "', '" . $_POST['UseWhere'] . "', '0', '" . $_POST['VideoURL'] . "')";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/themes/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		New Testimonial Inserted!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} else if ($_POST['action'] == "Delete" ) {
		$sql = "DELETE from g_testimonials where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql); ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/themes/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Testimonial Deleted!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
		
<? 	} else if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_testimonials set Name='" . $_POST['Name'] . "', VisualName='" . $_POST['VisualName'] . "', FromLocation='" . $_POST['FromLocation'] . "', Email='" . $_POST['Email'] . "', Status='" . $_POST['Status'] . "', ShortSubject='" . $_POST['ShortSubject'] . "', UseWhere='" . $_POST['UseWhere'] . "', Testimonial='" . $_POST['Testimonial'] . "', VideoURL='" . $_POST['VideoURL'] . "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/themes/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Testimonial Updated!
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
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/themes/images/info48x48.png" align="right">
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
		
		<table>
<tr><td colspan="9" align="right"><a href="javascript:aAdd();"><img src="addons/GIS/testimonials/images/add32x32.png" border="0"></a></td></tr>
<tr class="Prompts"><td class="Prompts"><strong>Subject</strong></td><td></td><td align="center"><strong>Author</strong></td><td></td><td><strong>Status</strong></td><td></td><td><strong>Location</strong></td><td></td><td><strong>ID</strong></td><td></td><td align="center"><strong>Options</strong></td></tr>
<?
 	$sql="select * from g_testimonials where productID='" . $_POST['pid'] . "'";
	$gid=mysql_query($sql);
	if ( mysql_num_rows($gid) < 1 ) {
		echo "<tr><td colspan=\"9\"><i>No Testimonials for this product.  Click the add button above to add one</i></td></tr>";
	} else {
		while ($grow = mysql_fetch_array($gid)) { 
			switch ($grow['Status']) {
				case '0':
					$ststxt = "Disabled";
					$stsbg = " bgcolor=\"#ee0000\"";
					break;
				case '1':
					$ststxt = "Enabled";
					$stsbg = "";
					break;
				case '2':
					$ststxt = "New";
					$stsbg = " bgcolor=\"#00eeee\"";
					break;
				} ?>
			<tr class="Prompts"><td><?= $grow['ShortSubject']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><?= $grow['VisualName']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"<?= $stsbg;?>><?= $ststxt; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['UseWhere']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['uid']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><a href="javascript:aEdit('<?= $grow['uid']; ?>')"><img src="addons/GIS/testimonials/images/edit32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aDelete('<?= $grow['uid']; ?>')"><img src="addons/GIS/testimonials/images/delete32x32.png" border="0"></a>&nbsp;</td>
  			</tr>
<? 			}
	} ?>  
  <tr><td>
  
</td></tr></table>
		
		




