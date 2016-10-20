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
				
				$query2 = "SELECT * from g_PaymentPro where productID ='" . $rs['id'] . "'";
				$request2 = mysql_query($query2);
				$rs2 = mysql_fetch_array($request2);
				
				$query3 = "SELECT count(*) from g_PaymentProUpsells where productID ='" . $rs['id'] . "'";
				$request3 = mysql_query($query3);
				$rs3 = mysql_fetch_array($request3);
				
		
				echo "{";
				echo "\"id\":\"" . $rs["id"] . "\",";
				echo "\"ProductName\":\"" . $rs['item_name'] . "\",";
				echo "\"PaymentProcessor\":\"";
				switch ($rs2['PaymentType']) {
					case '2':		//Clickbank
						echo "Clickbank";
						break;
						
					default:		//1-paypal
						echo "Paypal";
						break;
				}
				echo "\",";
				echo "\"PaymentType\":\"";
				switch ($rs2['PaymentType']) {				
					case '2':		//recurring
						echo "Recurring";
						break;
						
					default:		//1 - one time
						echo "One-Time";
						break;
				}
				echo "\",";
				echo "\"AutoClickbank\":\"";
				switch ($rs2['AutoClickbank']) {
					case '0':		
						echo "Disabled";
						break;
						
					default:		
						echo "Enabled";
						break;
				}
				echo "\",";
				echo "\"Status\":\"";
				switch ($rs2['Status']) {
					case '1':		
						echo "Enabled";
						break;
						
					default:		
						echo "Disabled";
						break;
				}
				echo "\",";
				echo "\"Upsells\":\"" . $rs3["count(*)"] . "\",";
				echo "\"Terms\":\"";
				if ($rs2['terms'] != '0' && $rs2['terms'] != "")
					echo "Yes";
				else
					echo "No";
					
				echo "\"";
				echo "}";
				}
			echo "]}";
			
			?>