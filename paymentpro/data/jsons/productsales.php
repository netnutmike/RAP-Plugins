<?php 

			$query = "SELECT * from sales where productID = '" . $_REQUEST['ProductID'] . "'";
			//echo $query . "<BR><BR>";
			
			if (trim($_REQUEST['Refunded']) != "" and trim($_REQUEST['Refunded']) != "999")
				$query .= " AND refunded = '" . $_REQUEST['refunded'] . "'";
			
		
			$query .= " ORDER BY purchased DESC";
			
			//echo $query;
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . mysql_num_rows($request) . "],\"productsales\":[";
			
			if ($_REQUEST['start'] != "" && $_REQUEST['limit'] != "")
				$query .= " LIMIT " . $_REQUEST['start'] . "," . $_REQUEST['limit'];
			
			//echo $query;
			$request = mysql_query($query);
	
			$beenhere = false;
	
			while ($rs = mysql_fetch_array($request)){
				if ($beenhere)
					echo ",";
			
				$beenhere = true;
				
				echo "{";
				echo "\"uid\":\"" . $rs["uid"] . "\",";
				echo "\"TransactionID\":" . json_encode($rs['TransactionID']) . ",";
				echo "\"Refunded\":\"" . $rs["refunded"] . "\",";
				//echo "\"RefundedName\":\"" . GetListDescription('8', $rs["Refunded"]) . "\",";
				echo "\"ReceiverEmail\":\"" . $rs["ReceiverEmail"] . "\",";
				echo "\"PayerEmail\":\"" . $rs["PayerEmail"] . "\",";
				echo "\"PaidToDescription\":\"";
				if (trim($rs["ReceiverEmail"]) == trim($sorc['PaypalEmailAddress']))
					echo "Vendor";
				else
					echo "Affiliate";
				echo "\",";
				echo "\"Firstname\":\"" . $rs["FirstName"] .  "\",";
				echo "\"Lastname\":\"" . $rs["LastName"] . "\",";
				echo "\"Fullname\":\"" . $rs["FirstName"] . " " . $rs["LastName"] . "\",";
				echo "\"Business\":\"" . $rs["Business"] . "\",";
				echo "\"Purchased\":\"" . $rs["purchased"] . "\",";
				echo "\"PaymentAmount\":\"" . $rs["PaymentAmount"] . "\",";
				echo "\"DiscountCode\":\"" . $rs["DiscountCode"] . "\",";
				echo "\"Expires\":\"" . $rs["Expires"] . "\",";
				echo "\"AffiliateID\":\"" . $rs["AffiliateID"] . "\"";
				echo "}";
				}
			echo "]}";
			
			?>