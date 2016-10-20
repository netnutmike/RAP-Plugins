<?
//==============================================================================================
//
//	Filename:	feed.php
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
//	Description:	This is a stand alone script that when ran will generate a RSS feed for all
//					products configured for the feed.  It will also add in other feeds and
//					combine them
//
//	Version:	1.0.0 (February 10th, 2010)
//
//	Change Log:
//				02/12/10 - Initial Version (JMM)
//
//==============================================================================================

require_once($_SERVER[DOCUMENT_ROOT] . "/rap_admin/settings.php");

function gOpenFeed() {

	global $gBsURL;
	global $gAffID;
	global $sys_domain;
	
	echo "<?xml version=\"1.0\"?>\n";
	echo "<rss version=\"2.0\">\n";
	echo "   <channel>\n";
	echo "   <language>en-us</language>\n";
	echo "   <title>" . $sys_domain . " Digital Feed</title>\n";
	echo "   <description>Up to date information from " . $sys_domain . "</description>\n";
	echo "   <link>http://" . $gBsURL . $gAffID . "</link>\n";
	
}

function gFeedEntry($gName, $gFolder, $gDescription) {

	global $gBsURL;
	global $gAffID;
	
	echo "<item>\n";
	echo "  <title>" . $gName . "</title>\n";
	if ($gAffID)
		echo "  <link>http://" . $gBsURL . $gFolder . $gAffID . "</link>\n";
	else
		echo "  <link>http://" . $gBsURL . $gFolder . "</link>\n";
		
	echo "  <description>" . $gDescription . "</description>\n";
	echo "</item>\n\n";  
	
}

function gCloseFeed() {

	echo "</channel>\n";
	echo "</rss>\n";
	
}

function gBuildProductFeed() {

		
	//Loop through all active products and build and RSS feed to them
	$sql="SELECT * FROM products WHERE disabled = '0'";
	
	$gid=mysql_query($sql);
	while ( $grow=mysql_fetch_array($gid) ) {
		if (gGetOptionInt("RSS", $grow['id'], '1') == '1') {
			gFeedEntry($grow['item_name'], $grow['install_folder'], $grow['item_desc']);
		}
	}
		
	
}

function InclcudeExtraFeed($gURL) {

	//validate that we have a valid url
	if (strpos(" " . $gURL, "http://") > 0 || strpos(" " . $gURL, "https://") > 0) {
		//open the url and read until we find the <channel>  When we do output everything until we find </channel>
		
		$gURLHandle = fopen($gURL, "r");
		$gWriting=0;
		
		while ($gLineData = fgets($gURLHandle)) {
			
			if ($gWriting == 1) {
				if (strripos(" " . $gLineData, "</channel>") > 0)
					return;
				
					echo $gLineData . "\n";
			} else {
				
				if (strripos(" " . $gLineData, "<item>") > 0) {
					echo $gLineData . "\n";
					$gWriting = 1;
				}
			}
		}
		
		fclose($gURLHandle);
	}
	
	
}


function gOutputFeed() {

	//First, check the options to make sure we are supposed to be building the RSS feed.
	$gDoFeed = gGetOptionInt("Robots", $productID, '0');
	
	if ($gDoFeed == '1') {

		//read the options for the feed
		$rss = gGetOptionInt("RSS", '0', '1');
	 	$rss_feed = gGetOptionChar("RSSFeed", '0', '');
	 	$rss_pos = gGetOptionInt("RSSPos", '0', '1');
		
		//setup the sitemap files
		gOpenFeed();
		
		if (trim($rss_feed) <> "" && $rss_pos == '1') 
			InclcudeExtraFeed(trim($rss_feed));
		
		gBuildProductFeed();
		
		if (trim($rss_feed) <> "" && $rss_pos == '0') 
			InclcudeExtraFeed(trim($rss_feed));
		
		gCloseFeed();
	}

}

//=========================================================================
// M A I N   P R O G R A M   S T A R T S   H E R E 
//=========================================================================

	//check to see if this was called by an affiliate
	if($_GET['e'])
   		$gAffID="?e=".$_GET['e'];
   		
   	//determine our base address
   	if ($_SERVER[SERVER_PORT] == "443")
		$gBsURL = "https://" . $_SERVER['HTTP_HOST'];
	else
		$gBsURL = "http://" . $_SERVER['HTTP_HOST'];
   		
	gOutputFeed();

?>
