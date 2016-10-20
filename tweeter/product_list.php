<?
//==============================================================================================
//
//	Filename:	product_list.php
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
//	Description:	This file is called when the Files accordian is opened. 
//
//	Version:	1.0.0 (February 16th, 2010)
//
//	Change Log:
//				02/16/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); ?>

<script type="text/javascript">

function ProductSelected(form) {
		
	jQuery('#Productname').html(jQuery('#products option:selected').text());
	var pid = jQuery('#products').val();

	jQuery.post("addons/GIS/testimonials/product_description.php", { pid: pid},
			function(data){
				jQuery('#ProductDescription').html(data);
		  	}
		);

	jQuery.post("addons/GIS/testimonials/templates.php", { pid: pid},
			function(data){
				jQuery('#ProductTemplate').html(data);
		  	}
		);
	jQuery('#pr-opt-disp').show();
	jQuery('#ProductTemplate').show();
	jQuery('#pr-opt-disp').html(loadingimage);

	jQuery.post("addons/GIS/testimonials/testimonials.php", { pid: pid},
			function(data){
				jQuery('#pr-opt-disp').html(data);
		  	}
		);
}


function aNewTestimonials() {

	jQuery('#pr-opt-disp').html(loadingimage);
	jQuery('#pr-opt-disp').show();
	jQuery.post("addons/GIS/testimonials/new_testimonials.php", {  },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

</script>

<script type="text/javascript" src="addons/GIS/testimonials/js/rap-tools.js"></script>

<?
	//If an error message was passed in then display the error message in a red box.
	if ($_POST['errormessage'] != "") { ?>
		<div class="rounded-box-red" id="error-box">
    	    <div class="box-contents">
        <? echo $_POST['errormessage']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#error-box').effect("pulsate", { times:3 }, 2000);
			jQuery('#error-box').fadeOut(10000);
		</script>
<?	} 

	//If a message was passed in display the message in a green box.
	if ($_POST['message'] != "") { ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        <? echo $_POST['message']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">

			jQuery('#message-box').fadeOut(20000);

		</script>
<?	} ?>

<table valign="top"><tr valign="top"><td valign="top">
<div id='productslist'>


<select name="products" size="10" id="products" class="productslist" onClick="ProductSelected(this.form)">
   
<?php 
	//Build a list of products in the select list 
	$query = "select * from products order by item_name;";		
	$request = mysql_query($query);
	while ($rs = mysql_fetch_array($request)){	
		echo "<option value=\"" . $rs['id'] . "\">" . $rs['item_name'] . "</option>";
	}

?>
 </select><br></br>
 
</div></td><td valign="top">

<div id='Productdetails'>
<table align="top" valign="top" ><tr valign="top"><td valign="top">
	<div id="Productname">
	Select A Product
	</div></td></tr>
	<tr><td>
	<div id="ProductDescription">
	<---- Select a product on the left to set options, Copy or Delete
	</div>
	</td></tr>
	<tr><td>
	<div id="ProductTemplate" style='display:none;'>
</div>
	</td></tr></table>
</div>
</td>
<td><table><tr><td>
<?
$sql="select * from g_testimonials where Status='2'";
	$gid=mysql_query($sql);
	$g_numrws = mysql_num_rows($gid);
	if ($g_numrws > 0) {
		echo "<a href=\"javascript:aNewTestimonials()\"><font style=\"font-size:16px;\"><strong>You have " . $g_numrws . " new testimonials!</strong></font></a>";
	}
		
	?>
	</td></tr>
	<tr><td><div id="tmp-preview"></div>
	
	</td></tr>
	</table>
</td>
</tr></table>

