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

function aEdit(uid) {

	jQuery('#pr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/testimonials/edit_testimonial.php", { uid: uid, returnto: 'new_testimonials.php' },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

function aDelete(uid) {

	jQuery('#pr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/testimonials/delete_testimonial.php", { uid: uid, returnto: 'new_testimonials.php' },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}
</script>

<?  if ($_POST['action'] == "Delete" ) {
		$sql = "DELETE from g_testimonials where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql); ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        		Testimonial Deleted!
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
	
	<br><p class="georgia-medium">New Testimonials</p><br><br>
		
		<table>

<tr class="Prompts"><td class="Prompts"><strong>Subject</strong></td><td></td><td align="center"><strong>Author</strong></td><td></td><td><strong>Product</strong></td><td></td><td><strong>Location</strong></td><td></td><td><strong>ID</strong></td><td></td><td align="center"><strong>Options</strong></td></tr>
<?
 	$sql="select * from g_testimonials where Status='2'";
	$gid=mysql_query($sql);
	if ( mysql_num_rows($gid) < 1 ) {
		echo "<tr><td colspan=\"9\"><i>No Testimonials for this product.  Click the add button above to add one</i></td></tr>";
	} else {
		while ($grow = mysql_fetch_array($gid)) { 
		
			$sql2 = "SELECT * from products where id='" . $grow['productID'] . "'";
			$prid=mysql_query($sql2);
			$prow = mysql_fetch_array($prid);
			?>
			<tr class="Prompts"><td><?= $grow['ShortSubject']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><?= $grow['VisualName']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $prow['item_name']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['UseWhere']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['uid']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><a href="javascript:aEdit('<?= $grow['uid']; ?>')" onmouseover="Tip('Click this icon to edit this testimonial')" onmouseout="UnTip()"><img src="addons/GIS/testimonials/images/edit32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aDelete('<?= $grow['uid']; ?>')"  onmouseover="Tip('Click this icon to delete this Testimonial')" onmouseout="UnTip()"><img src="addons/GIS/testimonials/images/delete32x32.png" border="0"></a>&nbsp;</td>
  			</tr>
<? 			}
	} ?>  
  <tr><td>
  
</td></tr></table>
		
		




