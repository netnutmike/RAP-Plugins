<?
//==============================================================================================
//
//	Filename:	friendly.php
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
//	Description:	This file is called when the user wants to go to a cloaked link. 
//
//	Version:	1.0.0 (Feb 3rd, 2010)
//
//	Change Log:
//				02/03/10 - Initial Version (JMM)
//
//==============================================================================================

function g_getRapAdminFolder() {

	$g_prepnd = "";
	$g_sftycnt = 0;
	do {
		$g_prepnd .= "../";
		++$g_sftycnt;
	} while (!file_exists($g_prepnd . "rap_admin") && $g_sftycnt <= 10);
	$g_rap_admin_path = $g_prepnd . "rap_admin";

	return $g_rap_admin_path;

}

require_once(g_getRapAdminFolder() . "/settings.php"); 

function g_getRealIpAddr()
{
     $ip = false;
     if(!empty($_SERVER['HTTP_CLIENT_IP']))
     {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
     }
     if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
     {
          $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
          if($ip)
          {
               array_unshift($ips, $ip);
               $ip = false;
          }
          for($i = 0; $i < count($ips); $i++)
          {
               if(!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i]))
               {
                    if(version_compare(phpversion(), "5.0.0", ">="))
                    {
                         if(ip2long($ips[$i]) != false)
                         {
                              $ip = $ips[$i];
                              break;
                         }
                    }
                    else
                    {
                         if(ip2long($ips[$i]) != - 1)
                         {
                              $ip = $ips[$i];
                              break;
                         }
                    }
               }
          }
     }
     return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}  

function gis_log_visit($gis_CloakedID) {

	# Log visit
	$gis_revisit = 0;
	$gis_ipaddy = g_getRealIpAddr();
	$gis_referringpage = $_SERVER["HTTP_REFERER"];
	
	# Have they been here before?
	if ($_COOKIE['gis_LnkPrevVisit'] == '1') {
		$gis_revisit = 1;
	}
			
	# add click detail
	$query = "insert into g_CloakerTracks (Date, Time, Referrer, IPAddress, Returning, CloakedID, DayOfWeek, Hour) VALUES('" . date('Ymd') . "', '" . date('His') . "',  '$gis_referringpage', '$gis_ipaddy', '$gis_revisit',  '$gis_CloakedID', '" . date('N') . "', '" . date('H') . "')";
	$result = mysql_query($query);
	
	#Add to unique and raw clicks
	$sql2 = "select * from g_cloakerOptions where uid='" . $gis_CloakedID . "'";
	$gid2=mysql_query($sql2);
	$grow2 = mysql_fetch_array($gid2);
	
	$g_newRawClicks = $grow2['RawClicks'] + 1;
	if ( $gis_revisit == 1)
		$g_uniqueClicks = $grow2['UniqueClicks'];
	else
		$g_uniqueClicks = $grow2['UniqueClicks'] + 1;
	
	$sql2 = "update g_cloakerOptions set UniqueClicks='" . $g_uniqueClicks . "', RawClicks='" . $g_newRawClicks . "' where uid='" . $gis_CloakedID . "'";
	$gid2=mysql_query($sql2);
	
	setcookie("gis_LnkPrevVisit", "1", time()+(60*60*24));
}

//=======================================================
//  M A I N   P R O G R A M   S T A R T S   H E R E
//=======================================================

	//check to make sure a Friendly Name was passed.  If not, go to the main page for this site
	if ( $_REQUEST['l'] == "")
		header( 'Location: /');
	
	//lookup the link options
	$sql = "select * from g_cloakerOptions where FriendlyName='" . $_REQUEST['l'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid); 

	//log the link visit
	gis_log_visit($grow['uid']);
	
	//do what the link is supposed to do
	if ( $grow['CloakType'] == 1) { ?>
	<html>
	<head>
	<title><?= $grow['CloakedTitle']?></title>
	</head>

	<frameset border="0" frameborder="0" marginleft="0" margintop="0" marginright="0" marginbottom="0" rows="100%",*>

	<frame src="<?= $grow['DestinationURL']; ?>" scrolling="auto" frameborder="no" border="0" noresize>

	<noframes>
	<body>
	This page requires a browser that support frames.
	</body>
	</noframes>
	</frameset>
	
	</html>
	
<? 	} else {
		//this is just a simple forward
		$g_dest = "Location: " . $grow['DestinationURL'];
		header( $g_dest ) ;
	}

?>