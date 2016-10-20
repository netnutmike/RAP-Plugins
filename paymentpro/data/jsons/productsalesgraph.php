<?php 
			$query = "SELECT count(*), MONTH(purchased) as Month, YEAR(purchased) as Year from sales where productID='" . $_REQUEST['ProductID'] . "'";
			//echo $query . "<BR><BR>";
			
			//if (trim($_REQUEST['Status']) != "")
				//$query .= " AND ProductRatings.Status = '" . $_REQUEST['Status'] . "'";
			
			$month['1'] = "Jan";
			$month['2'] = "Feb";
			$month['3'] = "Mar";
			$month['4'] = "Apr";
			$month['5'] = "May";
			$month['6'] = "Jun";
			$month['7'] = "Jul";
			$month['8'] = "Aug";
			$month['9'] = "Sep";
			$month['10'] = "Oct";
			$month['11'] = "Nov";
			$month['12'] = "Dec";
			
			
			$query .= " group by Year, Month Order by purchased";
			//echo $query;
			
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . mysql_num_rows($request) . "],\"graphdata\":[";
	
			$beenhere = false;
	
			while ($rs = mysql_fetch_array($request)){
				if ($beenhere)
					echo ",";
			
				$beenhere = true;
		
				echo "{";
				echo "\"Name\":\"" . $month[$rs["Month"]] . "/" . substr($rs["Year"],-2) . "\",";
				echo "\"Value1\":\"" . $rs["count(*)"] . "\",";
				echo "\"Value2\":\"" . "" . "\"";
				echo "}";
				
				}
			echo "]}";
?>