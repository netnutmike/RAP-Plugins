<?php 			

			$query = "SELECT * from g_PaymentProGiftSales where GiftID '" . $_REQUEST['uid'] . "'";
			//echo $query . "<BR><BR>";
			
			if (trim($_REQUEST['Status']) != "" and trim($_REQUEST['Status']) != "999")
				$query .= " AND Status = '" . $_REQUEST['Status'] . "'";
				
			if (trim($_REQUEST['Limit']) != "")
				$query .= " LIMIT " . $_REQUEST['Limit'];
		
			//echo $query;
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . mysql_num_rows($request) . "],\"giftcardsales\":[";
	
			$beenhere = false;
	
			while ($rs = mysql_fetch_array($request)){
				if ($beenhere)
					echo ",";
			
				$beenhere = true;
				
				$query2 = "SELECT * from sales where txn_id ='" . $rs['TransactionID'] . "'";
				$request2 = mysql_query($query2);
				$rs2 = mysql_fetch_array($request2);
				
		
				echo "{";
				echo "\"uid\":\"" . $rs["uid"] . "\",";
				echo "\"TransactionID\":\"" . $rs2['txn_id'] . "\",";
				echo "\"DateTime\":\"" . $rs2['Purchased'] . "\",";
				echo "\"ProductID\":\"" . $rs2['productID'] . "\",";
				echo "\"ProductName\":\"" . $rs2['item_name'] . "\",";
				echo "\"PurchaseAmount\":\"" . $rs['PurchaseAmount'] . "\",";
				echo "\"GiftAmount\":\"" . $rs['GiftAmount'] . "\",";
				echo "\"status\":\"" . $rs2['refunded'] . "\",";
				echo "\"statusName\":\"";
				switch ($rs['status']) {
					case '1':		
						echo "Refunded";
						break;
						
					default:		
						echo "";
						break;
				}
				echo "\"";
				echo "}";
				}
			echo "]}";
			
			?>