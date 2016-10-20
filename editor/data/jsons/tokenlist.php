<?php 			

			$query = "SELECT * from tokens";
			//echo $query . "<BR><BR>";
	
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . mysql_num_rows($request) . "],\"tokenlist\":[";
	
			$beenhere = false;
	
			while ($rs = mysql_fetch_array($request)){
				if ($beenhere)
					echo ",";
			
				$beenhere = true;
				
				echo "{";
				echo "\"uid\":\"" . $rs["uid"] . "\",";
				echo "\"tag\":" . jsonClean($rs['tag']) . ",";
				echo "\"description\":\"" . $rs['description'] . "\"";
				echo "}";
				}
			echo "]}";
			
			?>