<?php 			

			$query = "SELECT * from g_PaymentProGifts where uid = '" . $_REQUEST['uid'] . "'";
					
			//echo $query;
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . mysql_num_rows($request) . "],\"giftcard\":[";
	
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
				echo "\"GiftID\":\"" . $rs['giftID'] . "\",";
				echo "\"DateCreated\":\"" . $rs['dateCreated'] . "\",";
				echo "\"DateIssued\":\"" . $rs['dateIssued'] . "\",";
				echo "\"IssuedToName\":\"" . $rs['issuedToName'] . "\",";
				echo "\"Status\":\"" . $rs['status'] . "\",";
				echo "\"StatusName\":\"";
				switch ($rs['status']) {
					case '1':		
						echo "Enabled";
						break;
						
					default:		
						echo "Disabled";
						break;
				}
				echo "\",";
				echo "\"Balance\":\"" . $rs['Balance'] . "\",";
				echo "\"Sales\":\"" . $rs['Balance'] . "\",";
				echo "\"DateCompleted\":\"" . $rs["datecompleted"] . "\"";
				
				echo "}";
				}
			echo "]}";
			
			?>