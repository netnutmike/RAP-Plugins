<?php 			

			$query = "SELECT * from g_PaymentProUpsells where productID = '" . $_REQUEST['ProductID'] . "'";
			//echo $query . "<BR><BR>";
			
			if (trim($_REQUEST['Status']) != "" and trim($_REQUEST['Status']) != "999")
				$query .= " AND Status = '" . $_REQUEST['Status'] . "'";
				
			if (trim($_REQUEST['Limit']) != "")
				$query .= " LIMIT " . $_REQUEST['Limit'];
		
			//echo $query;
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . mysql_num_rows($request) . "],\"upsells\":[";
	
			$beenhere = false;
	
			while ($rs = mysql_fetch_array($request)){
				if ($beenhere)
					echo ",";
			
				$beenhere = true;
				
				$query3 = "SELECT item_name from products where id ='" . $rs['AttachedProduct'] . "'";
				$request3 = mysql_query($query3);
				$rs3 = mysql_fetch_array($request3);
				
		
				echo "{";
				echo "\"uid\":\"" . $rs["uid"] . "\",";
				echo "\"Name\":\"" . $rs['Name'] . "\",";
				echo "\"productID\":\"" . $rs['productID'] . "\",";
				echo "\"Status\":\"" . $rs['Status'] . "\",";
				echo "\"Price\":\"" . $rs['Price'] . "\",";
				echo "\"AttachedProduct\":\"" . $rs['AttachedProduct'] . "\",";
				echo "\"AttachedProductName\":\"" . $rs3['item_name'] . "\",";
				echo "\"StatusName\":\"";
				switch ($rs['Status']) {
					case '1':		
						echo "Enabled";
						break;
						
					default:		
						echo "Disabled";
						break;
				}
				echo "\",";
				echo "\"AttachedAction\":\"";
				switch ($rs['AttachedAction']) {
					case '2':		
						echo "Extend Download";
						break;
						
					case '3':		
						echo "Give Membership Period";
						break;
						
					default:		
						echo "Product Access";
						break;
				}
				
				echo "\",";
				echo "\"Amount\":\"" . $rs['Amount'] . "\"";
				
				echo "}";
				}
			echo "]}";
			
			?>