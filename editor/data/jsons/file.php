<?php 

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

	if ($_POST['productid'] != "" && $_POST['filename'] != "") {
	
		$sourcefile = get_template_folder($_POST['productid']) . "/" . $_POST['filename'];
		$filecontents = file_get_contents($sourcefile); 
		$lookfor = chr(60) . "?";
		$filecontents = str_replace($lookfor, "&lt;.?",$filecontents);
		//echo htmlentities($filecontents);
		echo $filecontents;
	}
?>