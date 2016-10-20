<?
//==============================================================================================
//
//	Filename:	delete_addToCart.php
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
//	Description:	This file is called when the user wants to delete a add-to-cart entry 
//
//	Version:	1.0.0 (April 28th, 2009)
//
//	Change Log:
//				04/28/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); 

function get_product_url($productID) {
	global $_SERVER;
	
	$q = "SELECT * FROM products WHERE id = '$productID'";
	//echo $q;
	$result = mysql_query ($q);
	$row = mysql_fetch_assoc ($result);
	mysql_free_result ($result);
	
	$install_folder = $row['install_folder'];

	$prod_path = $_SERVER['SERVER_NAME'] . $install_folder;
	
	return $prod_path;
}

?>

<script language="JavaScript">


function copyToClipboard(field)
{
	//var content = jQuery(this).parent().find(field);
	var content = jQuery(field);
    //var content = eval(field)
    content.focus()
    content.select()
    content.copy()
    //range = content.createTextRange()
    //range.execCommand("Copy")
    //window.status="Contents copied to clipboard"
    //setTimeout("window.status=''",1800)
}

</script>

<?
	$sql="select * from g_addToCart where uid='" . $_POST['atcid'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
?>
<br><br>


<p class="Prompts"><strong>Preview:</strong></p><br><br>
<img src="http://<?= $_SERVER['SERVER_NAME'];?>/rap_admin/addons/GIS/addtocart/a.php?atc=<?= $_POST['atcid'];?>"><br><br><p class="Prompts"><strong>Copy and Paste The Code Below (link and image):</strong></p><br>
<form name=myform>
<textarea rows=4 cols=70><a href="http://<?= get_product_url($_REQUEST['productID']);?>?action=order&atc=<?= $_POST['atcid'];?>"><img src="http://<?= $_SERVER['SERVER_NAME'];?>/rap_admin/addons/GIS/addtocart/a.php?atc=<?= $_POST['atcid'];?>" border="0"></a></textarea><br><br>
<p class="Prompts"><strong>Copy and Paste The Code Below (Image Only):</strong></p><br><textarea rows=4 cols=70><img src="http://<?= $_SERVER['SERVER_NAME'];?>/rap_admin/addons/GIS/addtocart/a.php?atc=<?= $_POST['atcid'];?>" border="0"></textarea>
<p class="Prompts"><strong>Copy and Paste The Code Below (Order URL):</strong></p><br><textarea rows=2 cols=70><a href="http://<?= get_product_url($_REQUEST['productID']);?>?action=order&atc=<?= $_POST['atcid'];?>"></textarea><!--  <input onclick="javascript:copyToClipboard('myform.urlonly')" type="button" value="Send to Clipboard">  -->
</form>


