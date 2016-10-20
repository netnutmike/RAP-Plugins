<?
/*
+--------------------------------------------------------------------------
|
| v1.0.1
| Copyright (c) 2009, 2010 Genius Idea Studio, LLC. All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Genius Idea Studio, LLC.
| regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script and hold harmless from any harm or damage
| Genius Idea Studio, LLC.   
|
| ================================================================
| rap-tools.com RAP Tracker add-on
| ================================================================
+--------------------------------------------------------------------------
*/

session_start();

function gis_log_visit($gis_type) {
	
	global $salesletter, $productID;

	# Log visit
	$gis_revisit = 0;
	$gis_ipaddy = getRealIpAddr();
	$gis_referringpage = $_SERVER["HTTP_REFERER"];
	
	$gis_nickname = $_COOKIE['aff'];
	
	# Have they been here before?
	if ($_COOKIE['gis_PrevVisit'] == '1') {
		$gis_revisit = 1;
	}
			
	# add click detail
	$query = "insert into GIS_HitTracking (Date, Time, PID, Affiliate, Page, Referrer, IPAddress, Returning, Tracking, Type, Disposition, DayOfWeek, Hour) VALUES('" . date('Ymd') . "', '" . date('His') . "', '$productID', '$gis_nickname', '$salesletter', '$gis_referringpage', '$gis_ipaddy', '$gis_revisit', '" . $_REQUEST['tr'] . "', '$gis_type', '$gis_disposition', '" . date('N') . "', '" . date('H') . "')";

	$result = mysql_query($query);
}

function gis_update_disposition($gis_disposition) {
	
	global $salesletter, $productID;

	# Log visit
	$gis_revisit = 0;
	$gis_ipaddy = getRealIpAddr();
	$gis_referringpage = $_SERVER["HTTP_REFERER"];
	
	$gis_nickname = $_COOKIE['aff'];
	
	# Have they been here before?
	if ($_COOKIE['gis_PrevVisit'] == '1') {
		$gis_revisit = 1;
	}
			
	$query = "select uid from GIS_HitTracking where PID='" . $productID . "' and Date='" . date('Ymd') . "' and IPAddress='" . $gis_ipaddy . "' and Affiliate='" . $gis_nickname . "'";
	$result = mysql_query($query);
	$resultrow = mysql_fetch_array($result);
	
	# add new disposition detail
	$query = "update GIS_HitTracking set Disposition='" . $gis_disposition . "' where uid='" . $resultrow["uid"] . "'";
	$result = mysql_query($query);
}


	global $salesletter;
	global $action;
	global $filename;
			
	// Set type and disposition based on the action
	switch ($action) {
		case "download":
			
			if((strpos($filename,"download.html") >= 1) || (strpos($filename,"taf.html") >= 1)) {
				//purchase Frontend offer
				gis_update_disposition('1');
			} 
			
			if((strpos($filename,"otodownload.html") >= 1) || (strpos($filename,"ototaf.html") >= 1)) {
				//purchase OTO
				gis_update_disposition('2');
			} 

			if(strpos($filename,"squeeze.html") >= 1) {
				//Squeeze Page
				gis_update_disposition('3');
			} 
			
			
			break;
			
		case "comp":
			gis_log_visit('2');
			break;
					
		case "jvsignup":
			gis_log_visit('3');
			break;

		case "affsignup":
			gis_log_visit('4');
			break;
						
		case "none":
			gis_log_visit('1');
			break;
	}
			

		
	?>