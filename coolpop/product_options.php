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
//	Description:	This file is called to provide the options for cool-pop. 
//
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				06/17/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); 


if ($_POST['action'] == "TypeUpdate" ) {

	$sql = "UPDATE g_CoolPop set popOverType='" . $_POST['popOverType'] . "' where productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);	
	} 
	
function wpos_cptype(&$opts, $name)
{
	global $wpos;
   	$hms = array('o' => 'Pop-Over', 's'=>'Slide-Up', 'e'=>'Exit Pop', 'p'=>'Predictive Exit Pop-Over');

   	echo '<select name="' . $wpos->postPrefix . $name . '" id="' . $wpos->postPrefix . $name . '"  onchange="aSavePopOverType()">';
   	foreach ($hms as $k=>$v)
   		{
      	echo '   <option value="' . $k . '"';
      	if ($k == $opts[$name]) 
	 		echo ' selected="selected"';
      	echo '>';
     	echo $v;
      	echo '</option>';
   		}
   	echo '</select>';
}
	
	
	
	
	?>

<script language="JavaScript">

function aSavePopOverType() {

	var popOverType =	jQuery("#popOverType").val();
	
	jQuery('#pr-opt-disp').html(loadingimage);
	
	jQuery.post("addons/GIS/coolpop/product_options.php", { popOverType: popOverType, action: "TypeUpdate", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

</script>

<?
	$sql="select * from g_CoolPop where productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) == 0) {
		$sql="insert into g_CoolPop (productID, offerText, Status, ) VALUES ('" . $_POST['productID'] . "', 'Your Text for the Pop Over Goes Here.  It can include HTML, images, etc', '0')";
		$gid=mysql_query($sql);
		$sql="select * from g_CoolPop where productID='" . $_POST['productID'] . "'";
		$gid=mysql_query($sql);
	}
	$grow = mysql_fetch_array($gid);
?>
<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Edit Cool-Pop Setup </p>";
		
?>

</font></td></tr>
<tr><td>
 	
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table>
 	 	
 	<tr><td class="Prompts" >Popover Type:</td><td>&nbsp;&nbsp;</td><td><?php wpos_cptype($grow, "popOverType"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td colspan="3">
  <div id="cp-options">
  <?php 
  switch ($grow['popOverType']) {
  	case 's':
  		@include("product_options_candybar.php");
  		break;
  	case 'e':
  		@include("product_options_exitramp.php");
  		break;
  	case 'p':
  		@include("product_options_exitlane.php");
  		break;
  	default:
  		@include("product_options_coolpop.php");
  		break;
  }
  ?>
  </div>
 

</td></tr></table>
