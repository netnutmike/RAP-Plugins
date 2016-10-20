<?
//==============================================================================================
//
//	Filename:	affstats.php
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
//	Description:	This file generates the statistics for the affiliates 
//
//	Version:	1.0.1 (January 28th, 2010)
//
//	Change Log:
//				1/7/10 - Initial Version (JMM)
//				1/28/10 - Fixed the <table><tr><td> erroneous info at the end of the graphs
//				1/28/10 - Fixed the products by day graph so only the current affiliate hits 
//							are visible, it was showing all for the site
//
//==============================================================================================
  	
	require_once("../../../settings.php"); 
		
  	//set dates for graphs
 	$StartDate = $_REQUEST['start'];
 	$EndDate = $_REQUEST['end'];
 	$Report = $_REQUEST['report']; 
 	$Dateval = $_REQUEST['dateval']; 
	$productID=$_REQUEST['prodid'];
	$Nickname = $_REQUEST['nickname'];
 
 	$TodaysDate = date("Ymd",time());
	
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
 
	require_once("functions.php");
	
	//lookup Nickname info
	$query = "select * from nicknames Where nickname = '" . $Nickname . "'";		
//echo $query;
	$request = mysql_query($query);
 	$nr = mysql_fetch_array($request);
 	$EmailAddr = $nr['email'];
	
 	if ($StartDate != "") {
		// Start Date was passed in
		if ((strlen($StartDate) == 8)){
			// Only 8 characters means only the date was sent, add midnight as starting time
			$StartDate;
		} else {
			if (strlen($StartDate) == 10)
				{
				//date passed with slashes
				$StartDate = substr($StartDate,6,4) . substr($StartDate,0,2) . substr($StartDate,3,2);
				}
		}
 	} else {
		$StartDate = $TodaysDate;		
 	}
	
	if ($EndDate != "") {
		if (strlen($EndDate) == 10)
			{
			//date passed with slashes
			$EndDate = substr($EndDate,6,4) . substr($EndDate,0,2) . substr($EndDate,3,2);
			}

		if ((strlen($EndDate) == 8)){
			$EndDate;
		} 
 	} else {
		$EndDate = $TodaysDate;		
 	}
 
	switch ($Dateval) {
		case "Exact":
			//use what was passed in
			break;
			 
 		case "Today":
 			//today
			$StartDate = date("Ymd");
 			$EndDate = date("Ymd");
 			break; 	
 			
		case "Yesterday":
			//yesterday
 			$timstr = "1 days ago";
			$StartDate = date("Ymd", strtotime($timstr));
 			$EndDate = date("Ymd", strtotime($timstr));
 			break; 	
 			
		case "30Days":
			//last 30 days
 			$timstr = "30 days ago";
			$StartDate = date("Ymd", strtotime($timstr));
 			$EndDate = $TodaysDate;
 			break; 
 				
 	 	case "7Days":
 	 		//last 7 days
 			$timstr = "7 days ago";
			$StartDate = date("Ymd", strtotime($timstr));
 			$EndDate = $TodaysDate;
 			break; 		
 			
		case "14Days":
			//last 14 days
			
 		default:
 			//default to 14 days
 			$timstr = "14 days ago";
			$StartDate = date("Ymd", strtotime($timstr));
 			$EndDate = $TodaysDate;
 			break;
 		
 	}
 	
			
		//Draw Graph By Day
		$strXML  = "<graph caption='Hits By Day' yAxisName='Clicks' showValues='0' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

		$query = "select Date, Returning, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by Date, Returning order by Date, Returning;";		
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
				$Cat .= "<category name='" . DateSplit($rs['Date']) . "'/>";
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
		echo renderChartHTMLFullPath("StackedColumn3D", $strXML, "HitsByDay", 600, 400);


		//Draw Graph By Day for type
		$strXML  = "<graph caption='Hit Types By Day' yAxisName='Clicks' showValues='0' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

		$query = "select Date, Type, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by Date, Type order by Date, Type;";		
		$request = mysql_query($query);
			
		//set default values needed
		$Cat = "<categories>";
		$data1 = "<dataset seriesName='Sales Page' color='f5d18c' alpha='90'>";
		$data2 = "<dataset seriesName='Comp' color='ee704b' alpha='90'>";
		$data3 = "<dataset seriesName='JV Signup' color='704bee' alpha='90'>";
		$data4 = "<dataset seriesName='Affiliate Signup' color='4bee70' alpha='90'>";
		$D1written=1;
		$D2written=1;
		$D3written=1;
		$D4written=1;
		$lstdate="";
			
		while ($rs = mysql_fetch_array($request)){	

			if ($rs['Date'] != $lstdate) {
				$Cat .= "<category name='" . DateSplit($rs['Date']) . "'/>";
				$lstdate = $rs['Date'];
				if ($D1written == 0)
					$data1 .= "<set value='0'/>";
				if ($D2written == 0)
					$data2 .= "<set value='0'/>";
				if ($D3written == 0)
					$data3 .= "<set value='0'/>";
				if ($D4written == 0)
					$data4 .= "<set value='0'/>";
					
				$D1written=0;
				$D2written=0;
				$D3written=0;
				$D4written=0;
			}
				
			switch ($rs['Type']) {
				case '1':
					$data1 .= "<set value='" . $rs['count(*)'] . "'/>";
					$D1written=1;
					break;
				case '2':
					$data2 .= "<set value='" . $rs['count(*)'] . "'/>";
					$D2written=1;
					break;
				case '3':
					$data3 .= "<set value='" . $rs['count(*)'] . "'/>";
					$D3written=1;
					break;
				case '4':
					$data4 .= "<set value='" . $rs['count(*)'] . "'/>";
					$D4written=1;
					break;
			}
				
		}
				
		$Cat .= "</categories>";
		$data1 .= "</dataset>";
		$data2 .= "</dataset>";
		$data3 .= "</dataset>";
		$data4 .= "</dataset>";
				
		
		$strXML .= $Cat . $data1 . $data2 . $data3 . $data4 . "</graph>";
						
		//Draw Chart for Dates
		echo renderChartHTMLFullPath("StackedColumn3D", $strXML, "HitsByDayByPage", 600, 400);
			
				
	
	
			//Draw Graph By Day Of Week
			$strXML  = "<graph caption='Disposition Of Visit' xAxisName='Day' yAxisName='Clicks' showValues='1' shownames='1' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select Disposition, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by Disposition order by Disposition;";		
			$request = mysql_query($query);
			while ($rs = mysql_fetch_array($request)){	
				$strXML .= "<set name='" . GetDisposition($rs['Disposition']) . "' value='" . $rs['count(*)'] . "' />";
				}
		
			$strXML .= "</graph>";
			
			
			//Draw Chart for Dates
			echo renderChartHTMLFullPath("Pie3D", $strXML, "Disposition", 600, 400);

			
			
			
			//Draw Graph By Tracking Code
			$strXML  = "<graph caption='Tracking Code' showValues='1' shownames='1' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select Tracking, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by Tracking order by Tracking;";		
			$request = mysql_query($query);
			while ($rs = mysql_fetch_array($request)){	
				if ($rs['Tracking'] == "")
					$trktext="No Tracking";
				else
					$trktext=$rs['Tracking'];
				$strXML .= "<set name='" . $trktext . "' value='" . $rs['count(*)'] . "' />";
				}
		
			$strXML .= "</graph>";
			
			
			//Draw Chart for Dates
			echo renderChartHTMLFullPath("Pie3D", $strXML, "TrackingNonA", 600, 400);


			
			//Draw Graph By Tracking Code
			$strXML  = "<graph caption='Referrers' showValues='1' shownames='1' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select Referrer, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by Referrer order by Referrer, count(*) DESC Limit 10;";		
			$request = mysql_query($query);
			while ($rs = mysql_fetch_array($request)){	
				if ($rs['Referrer'] == "")
					$trktext="Direct Traffic";
				else
					$trktext=StripURL($rs['Referrer']);
				$strXML .= "<set name='" . $trktext . "' value='" . $rs['count(*)'] . "' />";
				}
		
			$strXML .= "</graph>";
			
			
			//Draw Chart for Dates
			echo renderChartHTMLFullPath("Pie3D", $strXML, "ReferrerNonA", 600, 400);


			//Draw Graph By Day with disposition
			$strXML  = "<graph caption='Disposition By Day' yAxisName='Clicks' showValues='0' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select Date, Disposition, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by Date, Disposition order by Date, Disposition;";		
			$request = mysql_query($query);
			
			//set default values needed
			$Cat = "<categories>";
			$data1 = "<dataset seriesName='No Action' color='f5d18c' alpha='90'>";
			$data2 = "<dataset seriesName='Download' color='ee704b' alpha='90'>";
			$data3 = "<dataset seriesName='OTO Download' color='704bee' alpha='90'>";
			$data4 = "<dataset seriesName='Squeeze' color='4bee70' alpha='90'>";
			$D1written=1;
			$D2written=1;
			$D3written=1;
			$D4written=1;
			$lstdate="";
			
			while ($rs = mysql_fetch_array($request)){	

				if ($rs['Date'] != $lstdate) {
					$Cat .= "<category name='" . DateSplit($rs['Date']) . "'/>";
					$lstdate = $rs['Date'];
					if ($D1written == 0)
						$data1 .= "<set value='0'/>";
					if ($D2written == 0)
						$data2 .= "<set value='0'/>";
					if ($D3written == 0)
						$data3 .= "<set value='0'/>";
					if ($D4written == 0)
						$data4 .= "<set value='0'/>";
						
					$D1written=0;
					$D2written=0;
					$D3written=0;
					$D4written=0;
				}
				
				switch ($rs['Disposition']) {
					case '0':
						$data1 .= "<set value='" . $rs['count(*)'] . "'/>";
						$D1written=1;
						break;
					case '1':
						$data2 .= "<set value='" . $rs['count(*)'] . "'/>";
						$D2written=1;
						break;
					case '2':
						$data3 .= "<set value='" . $rs['count(*)'] . "'/>";
						$D3written=1;
						break;
					case '3':
						$data4 .= "<set value='" . $rs['count(*)'] . "'/>";
						$D4written=1;
						break;
				}
				
			}
				
			$Cat .= "</categories>";
			$data1 .= "</dataset>";
			$data2 .= "</dataset>";
			$data3 .= "</dataset>";
			$data4 .= "</dataset>";
				
		
			$strXML .= $Cat . $data1 . $data2 . $data3 . $data4 . "</graph>";
						
			//Draw Chart for Dates
			echo renderChartHTMLFullPath("StackedColumn3D", $strXML, "HitsByDayBydispo", 600, 400);



			//Draw disposition average per time period
			$strXML  = "<graph caption='Sales By Day' xAxisName='Day' yAxisName='Clicks' showValues='1' shownames='1' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select Date, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND Disposition <> '0'  AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by Date order by Date;";		
			$request = mysql_query($query);
			while ($rs = mysql_fetch_array($request)){	
				$strXML .= "<set name='" . DateSplit($rs['Date']) . "' value='" . $rs['count(*)'] . "' />";
				}
		
			$strXML .= "</graph>";
			
			
			//Draw Chart for Dates
			echo renderChartHTMLFullPath("Column3D", $strXML, "salesbyday", 600, 400);
			
			

			//Draw Graph By Day
			$strXML  = "<graph caption='Product Hits By Day' yAxisName='Clicks' showValues='0' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select PID, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by PID order by PID;";		
//echo $query;
			$request = mysql_query($query);
			
			//set default values needed
			$Cat = "<categories>";
			$count = 0;
			
			//load up all the different products during this date range
			while ($rs = mysql_fetch_array($request)){
				$d1[$count] = "<dataset seriesName='" . GetProduct($rs["PID"]) . "' color='" . $color[$count] . "' alpha='90'>";
				$d2[$count] = $rs["PID"];
				$dw[$count] = 1;
				$count += 1;
				}
			
			$itemcount = $count;
			$lstdate="";

			$query = "select Date, PID, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by Date, PID order by Date, PID;";		
//echo $query;
			$request = mysql_query($query);
			
			while ($rs = mysql_fetch_array($request)){	

//echo "Date: " . $rs['Date'] . " PID: " . $rs['PID'] . " Count: " . $rs['count(*)'] . "<BR>";
				if ($rs['Date'] != $lstdate) {
					$Cat .= "<category name='" . DateSplit($rs['Date']) . "'/>";
					$lstdate = $rs['Date'];
					
					for ($l=0 ; $l < $itemcount ; ++$l) {
						if ($dw[$l] == 0) {
							$d1[$l] .= "<set value='0'/>";
						}
						$dw[$l] = 0;
					}
				}
				
				for ($l=0 ; $l < $itemcount ; ++$l) {
					if ($d2[$l] == $rs['PID']) {
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
			echo renderChartHTMLFullPath("StackedColumn3D", $strXML, "ProductHitsByDay", 600, 400);




			//Draw Graph By Day
			$strXML  = "<graph caption='Product Sales By Day' yAxisName='Clicks' showValues='0' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select PID, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND Disposition <> '0'  AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by PID order by PID;";		
//echo $query;
			$request = mysql_query($query);
			
			//set default values needed
			$Cat = "<categories>";
			$count = 0;
			
			//load up all the different products during this date range
			while ($rs = mysql_fetch_array($request)){
				$d1[$count] = "<dataset seriesName='" . GetProduct($rs["PID"]) . "' color='" . $color[$count] . "' alpha='90'>";
				$d2[$count] = $rs["PID"];
				$dw[$count] = 1;
				$count += 1;
				}
			
			$itemcount = $count;
			$lstdate="";

			$query = "select Date, PID, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND Disposition <> '0' AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by Date, PID order by Date, PID;";		
//echo $query;
			$request = mysql_query($query);
			
			while ($rs = mysql_fetch_array($request)){	

//echo "Date: " . $rs['Date'] . " PID: " . $rs['PID'] . " Count: " . $rs['count(*)'] . "<BR>";
				if ($rs['Date'] != $lstdate) {
					$Cat .= "<category name='" . DateSplit($rs['Date']) . "'/>";
					$lstdate = $rs['Date'];
					
					for ($l=0 ; $l < $itemcount ; ++$l) {
						if ($dw[$l] == 0) {
							$d1[$l] .= "<set value='0'/>";
						}
						$dw[$l] = 0;
					}
				}
				
				for ($l=0 ; $l < $itemcount ; ++$l) {
					if ($d2[$l] == $rs['PID']) {
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
			echo renderChartHTMLFullPath("StackedColumn3D", $strXML, "ProductHitsByDay", 600, 400);





			//Draw product sales graph
			$strXML  = "<graph caption='Product Sales' showValues='1' shownames='1' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select PID, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND Disposition <> '0'  AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by PID order by PID;";		
			$request = mysql_query($query);
			while ($rs = mysql_fetch_array($request)){	
				$strXML .= "<set name='" . GetProduct($rs['PID']) . "' value='" . $rs['count(*)'] . "' />";
				}
		
			$strXML .= "</graph>";
			
			
			//Draw Chart for Dates
			echo renderChartHTMLFullPath("Pie3D", $strXML, "ProductSales", 600, 400);


			//Draw product OTO graph
			$strXML  = "<graph caption='OTO Sales' showValues='1' shownames='1' formatNumberScale='0' showBorder='1' decimalPrecision='0'>";

			$query = "select PID, count(*) from GIS_HitTracking Where Date >= '" . $StartDate . "' AND Date <= '" . $EndDate . "' AND Disposition = '2' AND (Affiliate='" . $Nickname . "' OR Affiliate='" . $EmailAddr . "') Group by PID order by PID;";		
			$request = mysql_query($query);
			while ($rs = mysql_fetch_array($request)){	
				$strXML .= "<set name='" . GetProduct($rs['PID']) . "' value='" . $rs['count(*)'] . "' />";
				}
		
			$strXML .= "</graph>";
			
			
			//Draw Chart for Dates
			echo renderChartHTMLFullPath("Pie3D", $strXML, "OTOSales", 600, 400);
		

?>

<br>



