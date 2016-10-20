<?
//==============================================================================================
//
//	Filename:	bld_ctrl_fls.php
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
//	Description:	This is a stand alone script that when ran will generate a robots.txt file
//					and sitemap files based upon the settings in the options.  This can be called
//					by any cron method or manually. 
//
//	Version:	1.0.0 (February 12th, 2010)
//
//	Change Log:
//				02/12/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php");

function gOpenSitemap() {

	global $gSitemapxml;
	global $gSitemaptext1;
	global $gSitemaptext2;
		
	$gFlhndl = fopen($gSitemapxml, "w");
	
	fwrite($gFlhndl, "<?xml version='1.0' encoding='UTF-8'?>");
	fwrite($gFlhndl, "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
	xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
	xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
			    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">");

	fclose($gFlhndl);
	$gFlhndl = fopen($gSitemaptext1, "w");
	fclose($gFlhndl);
	$gFlhndl = fopen($gSitemaptext2, "w");
	fclose($gFlhndl);
	
}

function gInsertSitemapEntry($pth) {

	global $gSitemapxml;
	global $gSitemaptext1;
	global $gSitemaptext2;
	global $gBsURL;
	
	//normalize the files is / in front and back
	if (substr($pth, 0, 1) != '/') 
		$pth = "/" . $pth;
		
	if (substr($pth, -1, 1) != '/') 
		$pth .= "/";	
		
	$gFlURL = $gBsURL . $pth;
		
	$gFlhndl = fopen($gSitemapxml, "a");
	
	fwrite($gFlhndl, "<url>");
	fwrite($gFlhndl, "<loc>");
	fwrite($gFlhndl, $gFlURL);
	fwrite($gFlhndl, "</loc>");
	fwrite($gFlhndl, "</url>\n");
	fclose($gFlhndl);
	
	$gFlhndl = fopen($gSitemaptext1, "a");
	fwrite($gFlhndl, $gFlURL . "\n");
	fclose($gFlhndl);
	
	$gFlhndl = fopen($gSitemaptext2, "a");
	fwrite($gFlhndl, $gFlURL . "\n");
	fclose($gFlhndl);
	
}

function gCloseSitemap() {

	global $gSitemapxml;
		
	$gFlhndl = fopen($gSitemapxml, "a");
	
	fwrite($gFlhndl, "</urlset>");

	fclose($gFlhndl);
	
}

function gBuildSitemaps() {

	//First, check the options to make sure we are supposed to be building sitmaps.
	$gDoSiteMap = gGetOptionInt("SiteMap", '0', '0');
	
	if ($gDoSiteMap == '1') {

		//setup the sitemap files
		gOpenSitemap();
		
		//First step is to loop through all products and build sitemap links to them
		$sql="SELECT * FROM products WHERE disabled = '0'";
	
		$gid=mysql_query($sql);
		while ( $grow=mysql_fetch_array($gid) ) {
			if (gGetOptionInt("SiteMap", $grow['id'], '1') == '1') {
				gInsertSitemapEntry($grow['install_folder']);
			}
		}
	
		//Now include the manual sitemap entries that were added
		$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = 'MANUALMAP'";
	
		$gid=mysql_query($sql);
		while ( $grow=mysql_fetch_array($gid) ) {
			gInsertSitemapEntry($grow['ValueChar']);
			}
			
		//close out the sitemap files
		gCloseSitemap();
		
	}
}

function gOpenRobots() {

	global $gRobotPath;
	global $gBsURL;

	$gFlhndl = fopen($gRobotPath, "w");
	
	fwrite($gFlhndl, "User-agent: *\n");
	
	if ( gGetOptionInt("SiteMap", '0', '1') == '1') {
		fwrite($gFlhndl, "Sitemap: " . $gBsURL . "/sitemap.xml\n");
	}
	
	if ( gGetOptionInt("RobotsRAP", $productID, '0') == '1') {
		fwrite($gFlhndl, "Disallow: /rap_admin/\n");
	}
	
	fclose($gFlhndl);
	
}

function gInsertRobotsEntry($pth) {

	global $gRobotPath;
	
	//normalize the files is / in front and back
	if (substr($pth, 0, 1) != '/') 
		$pth = "/" . $pth;
		
	if (substr($pth, -1, 1) != '/') 
		$pth .= "/";	
		
	$gFlURL = $gBsURL . $pth;
		
	$gFlhndl = fopen($gRobotPath, "a");
	
	fwrite($gFlhndl, "Disallow: " . $pth . "\n");

	fclose($gFlhndl);
	
}

function gBuildRobotsTxt() {

	//First, check the options to make sure we are supposed to be building sitmaps.
	$gDoRobots = gGetOptionInt("Robots", $productID, '0');
	
	if ($gDoRobots == '1') {

		//read the options for the robots.txt file
		$grobots_templates = gGetOptionInt("RobotsTemplates", '0', '1');
	 	$grobots_downloads = gGetOptionInt("RobotsDownloads", '0', '1');
	 	$grobots_manual = gGetOptionInt("RobotsManual", '0', '0');
		
		//setup the sitemap files
		gOpenRobots();
		
		//First step is to loop through all products and build sitemap links to them
		$sql="SELECT * FROM products WHERE disabled = '0'";
	
		$gid=mysql_query($sql);
		while ( $grow=mysql_fetch_array($gid) ) {
			if (gGetOptionInt("AllowRobots", $grow['id'], '0') == '0') 
				gInsertRobotsEntry($grow['install_folder']);
			
			if ($grobots_templates == '1')
				gInsertRobotsEntry($grow['install_folder'] . $grow['tmpl_folder']);
				
			if ($grobots_downloads == '1') {
				$gdnldfldr = substr($grow['item_download'],0,strpos($grow['item_download'],"/"));
				gInsertRobotsEntry($grow['install_folder'] . $gdnldfldr);
			}	
		}
	
		//check to see if we are supposed to add manual entries
		if ($grobots_manual == '1') {
			//Now include the manual sitemap entries that were added
			$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = 'DISALLOW'";
	
			$gid=mysql_query($sql);
			while ( $grow=mysql_fetch_array($gid) ) {
				gInsertRobotsEntry($grow['ValueChar']);
				}
		}
		
	}

}

//=========================================================================
// M A I N   P R O G R A M   S T A R T S   H E R E 
//=========================================================================

//setup the correct file paths

//look backward until we find the rap admin folder, then prepend the previous directories to the path for the templates folder
	$emcnt = 0;
	$prpnd = "";
	do
	{
		if (!file_exists($prpnd . "rap_admin"))
			$prpnd .= "../";
			
	} while (!file_exists($prpnd . "rap_admin") || ++$emcnt < 9);
	
	$gSitemapxml = $prpnd . "sitemap.xml";
	$gSitemaptext1 = $prpnd . "sitemap.txt";
	$gSitemaptext2 = $prpnd . "urllist.txt";
	$gRobotPath = $prpnd . "robots.txt";
	
	
	if ($_SERVER[SERVER_PORT] == "443")
		$gBsURL = "https://" . $_SERVER['HTTP_HOST'];
	else
		$gBsURL = "http://" . $_SERVER['HTTP_HOST'];


	gBuildSitemaps();
	
	gBuildRobotsTxt();

?>
