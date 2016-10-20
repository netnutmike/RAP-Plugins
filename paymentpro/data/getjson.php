
<? 
	require_once("../../../../settings.php");  

	//before we send any data we need to verify that the request is coming from a valid and active session
	
//	$query = "SELECT * FROM admin limit 1";
//	$request = mysql_query($query);
//	$rs = mysql_fetch_array($request);
		
//	if (md5($rs['password']) == $_REQUEST['SessionID'] && $rs['CurrentSessionIP'] == $_SERVER['REMOTE_ADDR'])
		$ds = $_REQUEST['dataset'];
//	else
//		$ds = "Invalid Session";
	

	$flname = "jsons/" . $ds . ".php";
	include($flname);
		
?>