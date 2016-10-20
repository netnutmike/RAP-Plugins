<?
//==============================================================================================
//
//	Filename:	verify.php
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
//	Description:	This file is called to get the latest version and verify registration 
//
//	Version:	1.0.0 (Feb 3rd, 2010)
//
//	Change Log:
//				02/03/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); 

//=======================================================
//  M A I N   P R O G R A M   S T A R T S   H E R E
//=======================================================

		
	//lookup the link options
	$sql = "select * from g_addons where Name='" . $_REQUEST['pr'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid); 

	$g_rtnstr = $grow['Name'] . "|" . $grow['Version'] . "|" . $grow['DownloadURL'] . "|" . $grow['SupportURL'];
	
	//check to see if this domain is registered already for this addon
	$sql = "select * from g_addonRegistrations where Addon='" . $_REQUEST['pr'] . "' and Domain='" . $_REQUEST['pr'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid); 
	
	if (mysql_num_rows($gid) < 1)
		$g_rtnstr .= "|0";
	else
		$g_rtnstr .= "|" . $grow['Email'];
		
	echo $g_rtnstr;
	
?>