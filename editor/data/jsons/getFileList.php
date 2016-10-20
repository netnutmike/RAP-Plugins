<?php 

function php4_scandir($dir,$listDirectories=false, $skipDots=false) {
    $dirArray = array();
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if (($file != "." && $file != "..") || $skipDots == true) {
                if($listDirectories == false) { if(is_dir($file)) { continue; } }
                array_push($dirArray,basename($file));
            }
        }
        closedir($handle);
    }
    return $dirArray;
}

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

	$templateFolder = get_template_folder($_POST['productid']);
	
	//if (phpversion() < "5.0.0")
		$filelist = php4_scandir($templateFolder);
	//else
		//$filelist = scandir($templateFolder);
	
	sort($filelist);
	
	echo "{\"totalCount\":[" .count($filelist) . "],\"filelist\":[";
	
	$beenhere = false;
	
	foreach ($filelist as $filename){
		if ($beenhere)
			echo ",";
			
		$beenhere = true;
				
		echo "{";
		echo "\"fileName\":\"" . $filename . "\"";
		echo "}";
		}
		
	echo "]}";
?>