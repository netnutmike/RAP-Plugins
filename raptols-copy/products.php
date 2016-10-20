<?
//==============================================================================================
//
//	Filename:	file_list.php
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
//	Description:	This file is called when the Files accordian is opened. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/23/09 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); ?>

<script type="text/javascript">

function ProductSelected(form) {
		
	jQuery('#Productname').html(jQuery('#products option:selected').text());
	var pid = jQuery('#products').val();

	jQuery.post("addons/GIS/raptools/product_description.php", { pid: pid},
			function(data){
				jQuery('#ProductDescription').html(data);
		  	}
		);
	jQuery('#product-options-dis').show();
	jQuery('#product-options-dis').html(loadingimage);
	jQuery('#product-functions').show();
	showProductOptions();

	jQuery.post("addons/GIS/raptools/product_options.php", { pid: pid},
			function(data){
				jQuery('#product-options-dis').html(data);
		  	}
		);
}

function aCopyProduct() {
	
	var pid = jQuery('#products').val();
	jQuery('#Productname').html("Copy Selected Product To New Product:");

	jQuery('#product-options-dis').hide();
	jQuery('#ProductDescription').html(loadingimage);
	jQuery.post("addons/GIS/raptools/copy_product.php", { pid: pid},
			function(data){
				jQuery('#ProductDescription').html(data);
			  }
		);
}

function aDeleteProduct() {
	
	var pid = jQuery('#products').val();
	jQuery('#Productname').html("Delete Selected Product.");

	jQuery('#product-options-dis').hide();
	jQuery('#ProductDescription').html(loadingimage);
	jQuery.post("addons/GIS/raptools/delete_product.php", { pid: pid },
			function(data){
				jQuery('#ProductDescription').html(data);
			  }
		);
}
</script>

<script type="text/javascript" src="addons/GIS/raptools/js/rap-tools.js"></script>

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

<!-- <div class="rounded-box">
    <!-- Content -->
    <div class="box-contents">
        Using the Editor is very simple, in the box below you will see a list of files that are currently in your templates folder.  Select a file then on the right you will have options to perform on the file.
    </div> <!-- end div.box-contents -->
</div> <!-- end div.rounded-box -->
<br><br>  -->

<table valign="top"><tr valign="top"><td valign="top">
<div id='productslist'>

<div class='gis-content' style="display:none" id="product-functions">
<a href="javascript:aCopyProduct();" id="copypackage" alt="Copy Product To a New Product"><img src="addons/GIS/raptools/images/copypackage.png" alt="Copy a Product to a new Product." border="0" width="32" height="32" align="right"></a>
<a href="javascript:aDeleteProduct();" id="deletepackage"><img src="addons/GIS/raptools/images/deletepackage.png" alt="Delete a Product." border="0" width="32" height="32" align="right"></a><br></div>
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

<div id='Productdetails'><br>&nbsp;
<table><tr><td>
	<div id="Productname">
	Select A Product
	</div></td></tr>
	<tr><td>
	<div id="ProductDescription">
	<---- Select a product on the left to set options, Copy or Delete
	</div>
	</td></tr>
	<tr><td>
	
	</td></tr></table>
</div>
</td></tr></table>

<div style='clear:both;'></div>
<div class='gis-content padding-rl-20' style="display:none" id="product-options-dis">xxxxxxxxxxxxxx</div>

<script type='text/javascript'>

jQuery(document).ready(function(){

	showProductOptions();
	}

</script>