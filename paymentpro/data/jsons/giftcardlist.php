<?php 			

			$query = "SELECT * from g_PaymentProGifts where uid <> '0'";
			//echo $query . "<BR><BR>";
			
			if (trim($_REQUEST['Status']) != "" and trim($_REQUEST['Status']) != "999")
				$query .= " AND Status = '" . $_REQUEST['Status'] . "'";
				
			if (trim($_REQUEST['Value']) != "" and trim($_REQUEST['Value']) != "______")
				$query .= " AND InitialBalance = '" . $_REQUEST['Value'] . "'";
				
			if (trim($_REQUEST['Limit']) != "")
				$query .= " LIMIT " . $_REQUEST['Limit'];
		
			//echo $query;
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . mysql_num_rows($request) . "],\"giftcards\":[";
	
			$beenhere = false;
	
			while ($rs = mysql_fetch_array($request)){
				if ($beenhere)
					echo ",";
			
				$beenhere = true;
				
				//$query3 = "SELECT count(*) from sales where productID ='" . $rs['id'] . "'";
				//$request3 = mysql_query($query3);
				//$rs3 = mysql_fetch_array($request3);
				
		
				echo "{";
				echo "\"uid\":\"" . $rs["uid"] . "\",";
				echo "\"giftID\":\"" . $rs['giftID'] . "\",";
				echo "\"dateCreated\":\"" . $rs['dateCreated'] . "\",";
				echo "\"dateIssued\":\"" . $rs['dateIssued'] . "\",";
				echo "\"issuedToName\":\"" . $rs['issuedToName'] . "\",";
				echo "\"status\":\"" . $rs['status'] . "\",";
				echo "\"statusName\":\"";
				switch ($rs['status']) {
					case '1':		
						echo "Not Issued";
						break;
						
					case '2':		
						echo "Issued";
						break;
						
					case '3':		
						echo "Empty";
						break;
						
					default:		
						echo "Disabled";
						break;
				}
				echo "\",";
				echo "\"balance\":\"" . $rs['Balance'] . "\",";
				echo "\"sales\":\"" . $rs['Balance'] . "\",";
				echo "\"dateCompleted\":\"" . $rs["datecompleted"] . "\",";
				echo "\"initialBalance\":\"" . $rs["initialBalance"] . "\"";
				
				echo "}";
				}
			echo "]}";
			
			?>