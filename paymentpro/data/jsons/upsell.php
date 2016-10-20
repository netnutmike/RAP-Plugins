<?php 			

			$query = "SELECT * from g_PaymentProUpsells where uid = '" . $_REQUEST['uid'] . "'";
			$request = mysql_query($query);
			echo "{\"totalCount\":[1],\"upsell\":[";
	
			while ($rs = mysql_fetch_array($request)){
		
				echo "{";
				echo "\"uid\":\"" . $rs["uid"] . "\",";
				echo "\"Name\":\"" . $rs['Name'] . "\",";
				echo "\"productID\":\"" . $rs['productID'] . "\",";
				echo "\"Status\":\"" . $rs['Status'] . "\",";
				echo "\"Price\":\"" . $rs['Price'] . "\",";
				echo "\"AttachedProduct\":\"" . $rs['AttachedProduct'] . "\",";
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