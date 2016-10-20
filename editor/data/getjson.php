
<? 
	require_once("../../../../settings.php");  

function jsonClean($input) {
	$newvar = json_encode($input);//, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP);
	$newvar = str_replace("<?", "[[", $newvar);
	$newvar = str_replace("?>", "]]", $newvar);
	$newvar = str_replace("\\n", "\\n", $newvar);
	$newvar = str_replace("\\r", "", $newvar);
	
	return $newvar;
}
	//before we send any data we need to verify that the request is coming from a valid and active session
	
//	$query = "SELECT * FROM admin limit 1";
//	$request = mysql_query($query);
//	$rs = mysql_fetch_array($request);
		
//	if (md5($rs['password']) == $_REQUEST['SessionID'] && $rs['CurrentSessionIP'] == $_SERVER['REMOTE_ADDR'])
		$ds = $_REQUEST['dataset'];
//	else
//		$ds = "Invalid Session";
	

	
	switch ($ds) {
			
		case "products":
		
			include('jsons/products.php');
			
			break;

		case "filelist":
		
			include('jsons/getFileList.php');
			
			break;
			
		case "file":
		
			include('jsons/file.php');
			
			break;
			
		case "tokenlist":
		
			include('jsons/tokenlist.php');
			
			break;
			
		}
		?>

