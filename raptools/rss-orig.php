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

function gOpenTestimonials() {

	echo "<testimonials>\n";
	
}

function gCloseTestimonials() {

	echo "</testimonials>\n";
	
}

function gTestimonialEntry($gVisualName, $gFromLocation, $gShortSubject, $gTestimonial, $gVideoURL) {
	echo "<testimonial>\n";
	echo "  <name>" . $gVisualName . "</name>\n";
	echo "  <location>" . $gFromLocation . "</location>\n";
	echo "  <subject>" . $gShortSubject . "</subject>\n";
	echo "  <testimonial>" . $gTestimonial . "</testimonial>\n";
	echo "  <videourl>" . $gVideoURL . "</videourl>\n";
	echo "</testimonial>\n";
}

function gFeedEntry($gProdID, $gOptionVals, $gName, $gFolder, $gDescription, $gImage, $gKeywords, $gMaxSales, $gExtendedDesc) {

	global $gBsURL;
	global $gAffID;
	
	echo "<item>\n";
	echo "  <title>" . $gName . "</title>\n";
	if ($gAffID)
		echo "  <link>http://" . $gBsURL . $gFolder . $gAffID . "</link>\n";
	else
		echo "  <link>http://" . $gBsURL . $gFolder . "</link>\n";
		
	echo "  <description>" . $gDescription . "</description>\n";
	//echo $gOptionsVals . "<BR>";
	
	if (strpos($gOptionVals,"rap") !== false) {
		echo "  <image>" . $gImage . "</image>\n";
		echo "  <keywords>" . $gKeywords . "</keywords>\n";
		echo "  <maxsales>" . $gMaxSales . "</maxsales>\n";
		echo "  <extendeddesc>" . $gExtendedDesc . "</extendeddesc>\n";
		
		if (strpos($gOptionVals,"Testimonials") !== false) {
			gOpenTestimonials();
			//Loop through all testimonials for the current product
			$sql="SELECT * FROM g_testimonials WHERE productID = '" . $gProdID . "' AND Status='1' Order By Date, Time DESC";
	
			$gid=mysql_query($sql);
			while ( $grow=mysql_fetch_array($gid) ) {
				gTestimonialEntry($grow['VisualName'], $grow['FromLocation'], $grow['ShortSubject'], $grow['Testimonial'], $grow['VideoURL']);
			}
			gCloseTestimonials();
		}
	}
	
	echo "</item>\n\n";  
	
}

function gCloseFeed() {

	echo "</channel>\n";
	echo "</rss>\n";
	
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

function gBuildProductFeed($gOptionVals) {

		
	//Loop through all active products and build and RSS feed to them
	$sql="SELECT * FROM products WHERE disabled = '0'";
	
	$gid=mysql_query($sql);
	while ( $grow=mysql_fetch_array($gid) ) {
		if (strpos($gOptionVals,"RapTools") !== false) {
			if (gGetOptionIntRSS("RSS", $grow['id'], '1') == '1') {
				gFeedEntry($grow['id'], $gOptionVals, $grow['item_name'], $grow['install_folder'], $grow['item_desc'], $grow['item_imgfile'], $grow['item_kw'], $grow['max_sales'], "");
			}
		} else {
			gFeedEntry($grow['id'], $gOptionVals, $grow['item_name'], $grow['install_folder'], $grow['item_desc'], $grow['item_imgfile'], $grow['item_kw'], $grow['max_sales'], "");
		}
	}
}

function gGetOptionIntRSS($g_optionID, $pid, $defaultval) {
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = '" . $g_optionID . "'";
	if ($pid != "") 
		$sql .= " AND productID='" . $pid . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['ValueInt'];
	} else {
		return $defaultval;
	}
}

function gGetOptionCharRSS($g_optionID, $pid, $defaultval) {
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = '" . $g_optionID . "'";
	if ($pid != "") 
		$sql .= " AND productID='" . $pid . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['ValueChar'];
	} else {
		return $defaultval;
	}
}

function gOutputFeed($gOptionVals) {

	// Set defaults
	$gRunFeed = true;
	$rss = "";
	$rss_feed = "";
	$rss_pos = "";
	
	//If rap-tools is installed it takes control of the options
	if (strpos($gOptionVals,"RapTools") !== false) {
		$gRunFeed = false;
	
		//First, check the options to make sure we are supposed to be building the RSS feed.
		$gDoFeed = gGetOptionIntRSS("Robots", $productID, '0');
	
		if ($gDoFeed == '1') {
			$gRunFeed = true;
			
			//read the options for the feed
			$rss = gGetOptionIntRSS("RSS", '0', '1');
	 		$rss_feed = gGetOptionCharRSS("RSSFeed", '0', '');
	 		$rss_pos = gGetOptionIntRSS("RSSPos", '0', '1');
		}
	}
	
	if ($gRunFeed) {	 	
		gOpenFeed();
		
		if (trim($rss_feed) <> "" && $rss_pos == '1') 
			InclcudeExtraFeed(trim($rss_feed));
			
		gBuildProductFeed($gOptionVals);
		
		if (trim($rss_feed) <> "" && $rss_pos == '0') 
			InclcudeExtraFeed(trim($rss_feed));
			
		gCloseFeed();
	}
}



//=========================================================================
// M A I N   P R O G R A M   S T A R T S   H E R E 
//=========================================================================

	//init variable to blank
	$goptions = "";
	
	//check to see if this was called by an affiliate
	if($_GET['e'])
   		$gAffID="?e=".$_GET['e'];
   		
   	if($_GET['opt'])
   		$goptions=$_GET['opt'];
   		
   	//check to see if testimonials addon is installed.
   	$sql="SELECT * FROM addons WHERE title = 'Testimonials'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0)
		$goptions .= "|Testimonials";
		
	//check to see if raptools addon is installed.
   	$sql="SELECT * FROM addons WHERE title = 'Rap Tools'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0)
		$goptions .= "|RapTools";
		
		
   	//determine our base address
   	if ($_SERVER[SERVER_PORT] == "443")
		$gBsURL = "https://" . $_SERVER['HTTP_HOST'];
	else
		$gBsURL = "http://" . $_SERVER['HTTP_HOST'];
   		
	gOutputFeed($goptions);

?>
