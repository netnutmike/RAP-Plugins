<?
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright 2009, 2010 Genius Idea Studio, LLC,  All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Genius Idea
| Studio, LLC regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.   
|
| ================================================================
| rap-tools.com Google Analytics add-on
| ================================================================
+---------------------------------------------------------------------
*/

//session_start();


	$productID=$_SESSION[product];
	
	//check to see if there are specific options for the product first
	$query = "SELECT * FROM ganalytics_options WHERE productid = '" . $productID . "'"; 
	$result = mysql_query($query);
	$rows = mysql_num_rows($result);
	if ($rows > 0)
	{
		$grow=mysql_fetch_array($result);
		$gid = $grow["gid"];
		if (substr($grow['Options'],0,1) == '1')
			$gt = 1;
		else
			$gt = 0;
			
		if (substr($grow['Options'],1,1) == '1')
			$ec = 1;
		else
			$ec = 0;
	} else {
		$query = "SELECT * FROM ganalytics_options WHERE uid = '1'"; 
		$result = mysql_query($query);
		$grow=mysql_fetch_array($result);
		$gid = $grow["gid"];
		if (substr($grow['Options'],0,1) == '1')
			$gt = 1;
		else
			$gt = 0;
			
		if (substr($grow['Options'],1,1) == '1')
			$ec = 1;
		else
			$ec = 0;
	}
	
	if ($gt == '1') {
		$pquery = "SELECT * FROM products WHERE id = '" . $productID . "'"; 
		$presult = mysql_query($pquery);
		$prow=mysql_fetch_array($presult);
		
		$g_newfilename = substr($filename,strpos($filename,"/")+1);
	}
	//output google analytics with correct google id 
	?>
	
	<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("<? echo $gid; ?>");
<? if ($gt == '1') {?>
	pageTracker._trackPageview("<?= $prow['install_folder']; ?><?= $g_newfilename; ?>");
<? } else {?>
	pageTracker._trackPageview();
<? } ?>
} catch(err) {}</script>

<?= $sys_install_folder ?>
<?php  if ($ec == "1") {
		if (($action=="squeeze" || $action=="download") && ($_COOKIE['g_GAAction'] != '1' || ($_COOKIE['g_txnid'] != $_REQUEST['id']  && trim($_REQUEST['id']) != "" ))) { 
			$query = "SELECT * FROM sales WHERE txn_id = '" . $_REQUEST['id'] . "'"; 
			$result = mysql_query($query);
			$rows = mysql_num_rows($result);
			if ($rows > 0)
			{
				$grow=mysql_fetch_array($result);
				
		?>
		<script type="text/javascript">

		try {

		var pageTracker = _gat._getTracker("<? echo $gid; ?>");

		pageTracker._trackPageview();

		pageTracker._addTrans(
		"<?=$grow['txn_id']?>", // required
		"<?=$grow['affiliate']?>",
		"<?=$grow['payment_amount']?>",
		"",
		"",
		"",
		"",
		""
		);

		pageTracker._addItem(
		"<?=$grow['txn_id']?>", // required
		"<?=$grow['item_number']?>",
		"<?=$grow['item_name']?>",
		"<?=$grow['affiliate']?>",
		"<?=$grow['payment_amount'] ?>", // required
		"1" //required
		);

		pageTracker._trackTrans();

		} catch(err) {}
<?php 		}
			}
		} ?>