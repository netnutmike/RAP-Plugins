<? 
	require_once("../../../../settings.php"); 
	
//	$query = "SELECT * FROM admin limit 1";
//	$request = mysql_query($query);
//	$rs = mysql_fetch_array($request);
		
//	if (md5($rs['password']) == $_REQUEST['SessionID'] && $rs['CurrentSessionIP'] == $_SERVER['REMOTE_ADDR'])
		$ds = $_REQUEST['dataset'];
//	else
//		$ds = "Invalid Session";

function get_template_folder($productID) {

	$q = "SELECT * FROM products WHERE id = '$productID'";
	$result = mysql_query ($q);
	$row = mysql_fetch_assoc ($result);
	mysql_free_result ($result);

	$pname = $row['item_name'];

	$itemname = $row['item_name'];
	$itemdownload = $row['item_download'];
	
	$install_folder = $row['install_folder'];
	$tmpl_folder = $row['tmpl_folder'];

	$template_path = $install_folder . $tmpl_folder;
	
	return $_SERVER['DOCUMENT_ROOT'] . "/" . $template_path;
	}

	if ($_POST['productid'] != "" && $_POST['filename'] != "" && $_POST['EditText'] != "") {
	
		$sourcefile = get_template_folder($_POST['productid']) . "/" . $_POST['filename'];
		$flp = fopen($sourcefile, "w");
		echo urldecode($_POST['EditText']);
		//fwrite($flp, $_POST['EditText']);

	}
	?>