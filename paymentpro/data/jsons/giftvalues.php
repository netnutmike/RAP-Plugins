<?php 			

			$query = "SELECT initialBalance from g_PaymentProGifts grop by initialBalance";
			//echo $query . "<BR><BR>";
			
			
			//echo $query;
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . (mysql_num_rows($request) + 1) . "],\"giftcards\":[";
	
			$beenhere = false;
			echo "{";
			echo "\"Value\":\"All\",";
			echo "\"Display\":\"______\"";				
			echo "}";
				
			while ($rs = mysql_fetch_array($request)){
				if ($beenhere)
					echo ",";
			
				$beenhere = true;
		
				echo "{";
				echo "\"Value\":\"" . $rs['initialBalance'] . "\",";
				echo "\"Display\":\"" . $rs['initialBalance'] . "\"";				
				echo "}";
				}
			echo "]}";
			
			?>