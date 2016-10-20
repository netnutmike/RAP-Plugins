<?php	
//==============================================================================================
//
//	Filename:	tweet.php
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
//	Description:	This file is called when the user wants to tweet. 
//
//	Version:	1.0.0 (April 17th, 2010)
//
//	Change Log:
//				04/17/10 - Initial Version (JMM)
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

require_once( 'twitter_class.php' );

//print_r($_POST);

//echo "senderpaypal: " . $_POST['senderpaypal'] . "\r\n";
	
	$linkurl = "http://" . get_product_url($productID) . "?e=" . $_POST['senderpaypal'];
	
	if ($_POST['shrnklnk'] == 1) {
	
	} 
	
//echo "link: " . $linkurl . "\r\n";
//echo "TwitStatus: " . $_POST['TwitStatus'] . "\r\n";

$twitter =  new MyTwitter($_POST['TwitName'], $_POST['TwitPass']);

$status = $twitter->updateStatus($_POST['TwitStatus'] . $linkurl);

//echo "Status: " . $status . "\r\n";
		
?>













