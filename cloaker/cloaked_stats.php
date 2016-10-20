<?
//==============================================================================================
//
//	Filename:	copy_file.php
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
//	Description:	This file is called when the user wants to copy a file. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/23/09 - Initial Version (JMM)
//
//==============================================================================================

	require_once("../../../settings.php"); 
?>

<script language="JavaScript">

function aReload() {

	jQuery('#ls-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/cloaker/cloaked_stats.php", {  },
					function(data){
						jQuery('#ls-opt-disp').html(data);
				  	}
				);
}

</script>
<?	$TodaysDate = date("Ymd",time());
	
	//color constants
	$color[0] = 'AFD8F8';
	$color[1] = 'F6BD0F';
	$color[2] = '8BBA00';
	$color[3] = 'FF8E46';
	$color[4] = '008E8E';
	$color[5] = 'f5d18c';
	$color[6] = 'ee704b';
	$color[7] = 'AFD8F8';
	$color[8] = '4bee70';
	$color[9] = '704bee';
	
	$timstr = "14 days ago";
	$StartDate = date("Ymd", strtotime($timstr));
 	$EndDate = $TodaysDate;
 	
 	if ($_POST['uid'] != "") {
 		$adlsql = " and CloakedID='" . $_POST['uid'] . "'";
 	} else {
 		$adlsql = "";
 	}
	
			echo "<br><p class=\"Prompts\">Link Performance For: <strong> ";
			if ($_POST['uid'] == "") 
				echo " All Links</strong><br><br></p>";
			else
				echo g_GetLinkName($_POST['uid']) . "</strong>&nbsp;&nbsp;&nbsp;<i><a href=\"javascript:aReload()\">Reset To All</a></i></p><br><br>";
			
			//Draw Graph By Day
			$strXML  = "<graph caption='Clicks By Day (new vs returning)' yAxisName='Clicks' showValues='0' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select Date, Returning, count(*) from g_CloakerTracks Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "'" . $adlsql . " Group by Date, Returning order by Date, Returning;";		
			//echo $query;
			$request = mysql_query($query);
			
			//set default values needed
			$Cat = "<categories>";
			$data1 = "<dataset seriesName='Returning Visitors' color='f5d18c' alpha='90'>";
			$data2 = "<dataset seriesName='New Visitors' color='ee704b' alpha='90'>";
			$D1written=1;
			$D2written=1;
			$lstdate="";
			
			while ($rs = mysql_fetch_array($request)){	

				if ($rs['Date'] != $lstdate) {
					$Cat .= "<category name='" . g_DateSplit($rs['Date']) . "'/>";
					$lstdate = $rs['Date'];
					if ($D1written == 0)
						$data1 .= "<set value='0'/>";
					if ($D2written == 0)
						$data2 .= "<set value='0'/>";
						
					$D1written=0;
					$D2written=0;
				}
				
				if ($rs['Returning'] == 1) {
					$data1 .= "<set value='" . $rs['count(*)'] . "'/>";
					$D1written=1;
				} else {
					$data2 .= "<set value='" . $rs['count(*)'] . "'/>";
					$D2written=1;
				}
				
				}
				
			$Cat .= "</categories>";
			$data1 .= "</dataset>";
			$data2 .= "</dataset>";
				
		
			$strXML .= $Cat . $data1 . $data2 . "</graph>";
						
			//Draw Chart for Dates
			echo g_renderChartHTML("StackedColumn3D", $strXML, "HitsByDay", 600, 400);

//Draw Graph By Day
			$strXML  = "<graph caption='Clicks By Day (Links)' yAxisName='Clicks' showValues='0' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select CloakedID, count(*) from g_CloakerTracks Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "'" . $adlsql . " Group by CloakedID order by CloakedID;";		

			$request = mysql_query($query);
			
			//set default values needed
			$Cat = "<categories>";
			$count = 0;
			
			//load up all the different products during this date range
			while ($rs = mysql_fetch_array($request)){
				$d1[$count] = "<dataset seriesName='" . g_GetLinkName($rs["CloakedID"]) . "' color='" . $color[$count] . "' alpha='90'>";
				$d2[$count] = $rs["CloakedID"];
				$dw[$count] = 1;
				$count += 1;
				}
			
			$itemcount = $count;
			$lstdate="";

			$query = "select Date, CloakedID, count(*) from g_CloakerTracks Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "'" . $adlsql . " Group by Date, CloakedID order by Date, CloakedID;";		

			$request = mysql_query($query);
			
			while ($rs = mysql_fetch_array($request)){	

//echo "Date: " . $rs['Date'] . " PID: " . $rs['PID'] . " Count: " . $rs['count(*)'] . "<BR>";
				if ($rs['Date'] != $lstdate) {
					$Cat .= "<category name='" . g_DateSplit($rs['Date']) . "'/>";
					$lstdate = $rs['Date'];
					
					for ($l=0 ; $l < $itemcount ; ++$l) {
						if ($dw[$l] == 0) {
							$d1[$l] .= "<set value='0'/>";
						}
						$dw[$l] = 0;
					}
				}
				
				for ($l=0 ; $l < $itemcount ; ++$l) {
					if ($d2[$l] == $rs['CloakedID']) {
						$d1[$l] .= "<set value='" . $rs['count(*)'] . "'/>";
						$dw[$l] = 1;
					}
				}
			}
				
			for ($l=0 ; $l < $itemcount ; ++$l) {
				if ($dw[$l] == 0) {
					$d1[$l] .= "<set value='0'/>";
				}
			}
				
			$Cat .= "</categories>";

			$strXML .= $Cat;
			for ($l=0 ; $l < $itemcount ; ++$l) {
				$d1[$l] .= "</dataset>";
				$strXML .= $d1[$l];
			}			
			$strXML .= "</graph>";		
			
						
			//Draw Chart for Dates
			echo g_renderChartHTML("StackedColumn3D", $strXML, "ProductHitsByDay", 600, 400);
			
			
			//Draw Graph By Hour
			$strXML  = "<graph caption='Average Clicks By Hour' xAxisName='Hour' yAxisName='Clicks' showValues='0' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select Hour, count(*) from g_CloakerTracks Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "'" . $adlsql . " Group by Hour order by Hour;";		
			$request = mysql_query($query);
			while ($rs = mysql_fetch_array($request)){	
				$strXML .= "<set name='" . $rs['Hour'] . "' value='" . $rs['count(*)'] . "' />";
				}
		
			$strXML .= "</graph>";
			
			
			//Draw Chart for Dates
			echo g_renderChartHTML("Column3D", $strXML, "HitsByHour", 600, 400);
	
	
			//Draw Graph By Day Of Week
			$strXML  = "<graph caption='Average Hits By Day Of Week' xAxisName='Day' yAxisName='Clicks' showValues='0' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select DayOfWeek, count(*) from g_CloakerTracks Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "'" . $adlsql . " Group by DayOfWeek order by DayOfWeek;";		
			$request = mysql_query($query);
			while ($rs = mysql_fetch_array($request)){	
				$strXML .= "<set name='" . g_DayOfWeek($rs['DayOfWeek']) . "' value='" . $rs['count(*)'] . "' />";
				}
		
			$strXML .= "</graph>";
			
			
			//Draw Chart for Dates
			echo g_renderChartHTML("Column3D", $strXML, "HitsByDayOfWeek", 600, 400);
			
			
			
			//Draw Graph By Tracking Code
			$strXML  = "<graph caption='Link Comparison' showValues='1' shownames='1' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select CloakedID, count(*) from g_CloakerTracks Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "'" . $adlsql . " Group by CloakedID order by CloakedID, count(*) DESC LIMIT 10;";		
			$request = mysql_query($query);
			while ($rs = mysql_fetch_array($request)){	
				$strXML .= "<set name='" . g_GetLinkName($rs["CloakedID"]) . "' value='" . $rs['count(*)'] . "' />";
				}
		
			$strXML .= "</graph>";
			
			
			//Draw Chart for Dates
			echo g_renderChartHTML("Pie3D", $strXML, "ProductAllTraffic", 600, 400);
			
			//Draw Graph By Tracking Code
			$strXML  = "<graph caption='Referrers' showValues='1' shownames='1' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select Referrer, count(*) from g_CloakerTracks Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "'" . $adlsql . " Group by Referrer order by Referrer, count(*) DESC LIMIT 10;";		
			$request = mysql_query($query);
			while ($rs = mysql_fetch_array($request)){	
				if ($rs['Referrer'] == "")
					$trktext="Direct Traffic";
				else
					$trktext=g_StripURL($rs['Referrer']);
			
				$strXML .= "<set name='" . $trktext . "' value='" . $rs['count(*)'] . "' />";
				}
		
			$strXML .= "</graph>";
			
			
			//Draw Chart for Dates
			echo g_renderChartHTML("Pie3D", $strXML, "ProductAllTraffic", 600, 400);
						