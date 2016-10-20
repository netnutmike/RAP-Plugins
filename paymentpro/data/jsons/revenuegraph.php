<?php 
			$query = "SELECT sum(PaymentAmount) as Total, MONTH(Purchased) as Month from Sales";
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
			
			
			$query .= " group by Month Order by Purchased";
			//echo $query;
			
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . mysql_num_rows($request) . "],\"graphdata\":[";
	
			$beenhere = false;
	
			while ($rs = mysql_fetch_array($request)){
				if ($beenhere)
					echo ",";
			
				$beenhere = true;
		
				echo "{";
				echo "\"Name\":\"" . $month[$rs["Month"]] . "\",";
				echo "\"Value1\":\"" . round($rs["Total"]) . "\",";
				echo "\"Value2\":\"" . "" . "\"";
				echo "}";
				
				}
			echo "]}";
?>