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

session_start();

	$productID=$_SESSION[product];
	
	//check to see if there are specific options for the product first
	$query = "SELECT * FROM ganalytics_options WHERE productid = '" . $productID . "'"; 
	$result = mysql_query($query);
	$rows = mysql_num_rows($result);
	if ($rows > 0)
	{
		$grow=mysql_fetch_array($result);
		$gid = $grow["gid"];
	} else {
		$query = "SELECT * FROM ganalytics_options WHERE uid = '1'"; 
		$result = mysql_query($query);
		$grow=mysql_fetch_array($result);
		$gid = $grow["gid"];
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
pageTracker._trackPageview();
} catch(err) {}</script>
		

