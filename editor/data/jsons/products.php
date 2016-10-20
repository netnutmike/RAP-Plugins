<?php 			

			$query = "SELECT * from products where id <> '0'";
			//echo $query . "<BR><BR>";
			
 			if (trim($_REQUEST['Keywords']) != "")
 				$query .= " AND Keywords like '%" . $_REQUEST['Keywords'] . "%'";
			
			if (trim($_REQUEST['Status']) != "" and trim($_REQUEST['Status']) != "999")
				$query .= " AND Status = '" . $_REQUEST['Status'] . "'";
				
			if (trim($_REQUEST['Limit']) != "")
				$query .= " LIMIT " . $_REQUEST['Limit'];
		
			//echo $query;
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . mysql_num_rows($request) . "],\"products\":[";
	
			$beenhere = false;
	
			while ($rs = mysql_fetch_array($request)){
				if ($beenhere)
					echo ",";
			
				$beenhere = true;
				
				echo "{";
				echo "\"id\":\"" . $rs["id"] . "\",";
				echo "\"ProductName\":\"" . $rs['item_name'] . "\",";
				echo "\"InstallFolder\":\"" . $rs['install_folder'] . "\"";
				echo "}";
				}
			echo "]}";
			
			?>