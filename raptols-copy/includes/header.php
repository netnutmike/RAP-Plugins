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

function gis_log_debug_info($g_logCookies, $g_logRequest, $g_logServer, $g_logType) {
	
	global $salesletter, $productID, $action, $dc, $header, $footer, $filename, $rightnow;

	# Open Logfile
	$g_flhndl = fopen("g_debug_log", "a");
	
	# Log Basics
	switch ($g_logType) {
		case 1:
			$g_outputString = "\"" . $rightnow . "\", \"" . $action . "\", \"" . $productID . "\", \"" . $_COOKIE['aff'] . "\", \"" . $dc . "\", \"" . $header . "\", \"" . $footer . "\", \"" . $filename . "\"\r\n";
			break;
		default:
			$g_outputString = "\r\n" . $rightnow . ": action=" . $action . ", Product ID=" . $productID . ", Affiliate=" . $_COOKIE['aff'] . ", Discount Code=" . $dc . ", Header File=" . $header . ", Footer=" . $footer . ", Filename=" . $filename . "\r\n";	
			break;
	}
	fwrite($g_flhndl, $g_outputString);
	
	if ($g_logRequest) {
		foreach ($_REQUEST as $key => $value) {
			switch ($g_logType) {
				case 1:
					$g_outputString = "\"_REQUEST\", \"" . $key . "\", \"" . $value . "\"\r\n";
					break;
				default:
					$g_outputString = "REQUEST: Key=" . $key . ", Value=" . $value . "\r\n";	
					break;
				}
			fwrite($g_flhndl, $g_outputString);
  			}	
		}
	 
	if ($g_logCookies) {
		foreach ($_COOKIE as $key => $value) {
			switch ($g_logType) {
				case 1:
					$g_outputString = "\"_COOKIE\", \"" . $key . "\", \"" . $value . "\"\r\n";
					break;
				default:
					$g_outputString = "COOKIE: Key=" . $key . ", Value=" . $value . "\r\n";	
					break;
				}
			fwrite($g_flhndl, $g_outputString);
  			}	
		}
		
	if ($g_logServer) {
		foreach ($_SERVER as $key => $value) {
			switch ($g_logType) {
				case 1:
					$g_outputString = "\"_SERVER\", \"" . $key . "\", \"" . $value . "\"\r\n";
					break;
				default:
					$g_outputString = "SERVER: Key=" . $key . ", Value=" . $value . "\r\n";	
					break;
				}
			fwrite($g_flhndl, $g_outputString);
  			}	
		}
		

	
	fclose($g_flhndl);
}

function gGetReferrerName($pretext, $posttext)
{
	if(isset($_COOKIE['aff']) || $_REQUEST['e'] != "")
		{   
		if (!isset($_COOKIE['aff']))
			$g_nick = $_REQUEST['e'];
		else
			$g_nick = $_COOKIE['aff'];
			
		$sql="SELECT * FROM nicknames WHERE nickname = '".$g_nick."' or email = '" . $g_nick . "'";
		$gid=mysql_query($sql);
		$grow=mysql_fetch_array($gid);
		
		echo $pretext . " " . $grow['firstname'] . " " . $grow['lastname'] . " " . $posttext;
		}

}


function gGetReferrerEmail()
{
	if(isset($_COOKIE['aff']) || $_REQUEST['e'] != "")
		{   
		if (!isset($_COOKIE['aff']))
			$g_nick = $_REQUEST['e'];
		else
			$g_nick = $_COOKIE['aff'];
			
		$sql="SELECT * FROM nicknames WHERE nickname = '".$g_nick."' or email = '" . $g_nick . "'";
		$gid=mysql_query($sql);
		$grow=mysql_fetch_array($gid);
		
		echo $grow['pref_email'];
		}

}

function gGotoCustomPage($pagename) {
	echo "index.php?action=a&fn=GIS/raptools/custom_file&template=" . $pagename;
}

function gGetOptionChar($g_optionID) {
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = '" . $g_optionID . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['ValueChar'];
	} else {
		return false;
	}
}

function gGetOptionInt($g_optionID) {
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = '" . $g_optionID . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['ValueInt'];
	} else {
		return false;
	}
}

function gGotoStandardPage($pagename) {
	echo "index.php?action=a&fn=GIS/raptools/std_file&page=" . $pagename;
}
?>