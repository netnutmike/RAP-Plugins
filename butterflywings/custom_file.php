<?
//==============================================================================================
//
//	Filename:	custom_file.php
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
//	Description:	This file is called when the user wants to display a custom file. 
//
//	Version:	1.0.0 (Feb 3rd, 2010)
//
//	Change Log:
//				02/03/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("settings.php"); 

function g_getTemplateFolder($productID) {

	$q = "SELECT * FROM products WHERE id = '$productID'";
	$result = mysql_query ($q);
	$row = mysql_fetch_assoc ($result);
	mysql_free_result ($result);

	$pname = $row['item_name'];

	$itemname = $row['item_name'];
	$itemdownload = $row['item_download'];
	$install_folder = $row['install_folder'];
	$tmpl_folder = $row['tmpl_folder'];
	//assuming rap_admin is always in the root, read backward one directory at a time until we find it.  Then prepend that to 
	//the install folder to get back to the root from where we are now.
	$g_prepnd = "";
	$g_sftycnt = 0;
	do {
		$g_prepnd .= "../";
		++$g_sftycnt;
	} while (!file_exists($g_prepnd . "rap_admin") && $g_sftycnt <= 10);
	$template_path = $g_prepnd . $install_folder . $tmpl_folder;

	return $template_path;

}

$sourcefile = g_getTemplateFolder($productID) . $_REQUEST['template'];

$filecontents = file_get_contents($sourcefile);

echo $filecontents;
?>