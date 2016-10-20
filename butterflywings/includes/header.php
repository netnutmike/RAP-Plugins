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



function g_GetOptionChar($g_optionID, $productID) {
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = '" . $g_optionID . "' and productID='" . $productID . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['ValueChar'];
	} else {
		return false;
	}
}

function g_GetOptionInt($g_optionID, $productID) {
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = '" . $g_optionID . "' and productID='" . $productID . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['ValueInt'];
	} else {
		return false;
	}
}




?>