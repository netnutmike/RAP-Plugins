<?php 			

			$query = "SELECT * from products where id = '" . $_REQUEST['uid'] . "'";
			//echo $query . "<BR><BR>";
				
			//echo $query;
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . mysql_num_rows($request) . "],\"product\":[";
	
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
				echo "\"item_name\":\"" . $rs['item_name'] . "\",";
				echo "\"item_price\":\"" . $rs['item_price'] . "\",";
				echo "\"two_tier\":\"" . $rs['two_tier'] . "\",";
				echo "\"item_pct\":\"" . $rs['item_pct'] . "\",";
				echo "\"item_pct2\":\"" . $rs['item_pct2'] . "\",";
				echo "\"oto_name\":\"" . $rs['oto_name'] . "\",";
				echo "\"oto_price\":\"" . $rs['oto_price'] . "\",";
				echo "\"oto_pct\":\"" . $rs['oto_pct'] . "\",";
				echo "\"oto_pct2\":\"" . $rs['oto_pct2'] . "\",";
				echo "\"jvcode\":\"" . $rs['jvcode'] . "\",";
				echo "\"jv_item_pct\":\"" . $rs['jv_item_pct'] . "\",";
				echo "\"jv_item_pct2\":\"" . $rs['jv_item_pct2'] . "\",";
				echo "\"jv_oto_pct\":\"" . $rs['jc_oto_pct'] . "\",";
				echo "\"jv_oto_pct2\":\"" . $rs['jv_oto_pct2'] . "\",";
				echo "\"a1\":\"" . $rs['a1'] . "\",";
				echo "\"p1\":\"" . $rs['p1'] . "\",";
				echo "\"t1\":\"" . $rs['t1'] . "\",";
				echo "\"a2\":\"" . $rs['a2'] . "\",";
				echo "\"p2\":\"" . $rs['p2'] . "\",";
				echo "\"t2\":\"" . $rs['t2'] . "\",";
				echo "\"a3\":\"" . $rs['a3'] . "\",";
				echo "\"p3\":\"" . $rs['p3'] . "\",";
				echo "\"t3\":\"" . $rs['t3'] . "\",";
				echo "\"src\":\"" . $rs['src'] . "\",";
				echo "\"sra\":\"" . $rs['sra'] . "\",";
				echo "\"srt\":\"" . $rs['srt'] . "\",";
				echo "\"signpmt_subscr_url\":\"" . $rs['signpmt_subscr_url'] . "\",";
				echo "\"cancel_subscr_url\":\"" . $rs['cancel_subscr_url'] . "\",";
				echo "\"a1o\":\"" . $rs['a1o'] . "\",";
				echo "\"p1o\":\"" . $rs['p1o'] . "\",";
				echo "\"t1o\":\"" . $rs['t1o'] . "\",";
				echo "\"a2o\":\"" . $rs['a2o'] . "\",";
				echo "\"p2o\":\"" . $rs['p2o'] . "\",";
				echo "\"t2o\":\"" . $rs['t2o'] . "\",";
				echo "\"a3o\":\"" . $rs['a3o'] . "\",";
				echo "\"p3o\":\"" . $rs['p3o'] . "\",";
				echo "\"t3o\":\"" . $rs['t3o'] . "\",";
				echo "\"srco\":\"" . $rs['srco'] . "\",";
				echo "\"srao\":\"" . $rs['srao'] . "\",";
				echo "\"srto\":\"" . $rs['srto'] . "\",";
				echo "\"signpmt_subscr_urlo\":\"" . $rs['signpmt_subscr_urlo'] . "\",";
				echo "\"cancel_subscr_urlo\":\"" . $rs['cancel_subscr_urlo'] . "\",";
				echo "\"CommissionType\":\"" . $rs2['CommissionType'] . "\",";
				echo "\"CommissionTypeName\":\"";
				switch ($rs2['CommissionType']) {
					case '1':		//Alert Pay
						echo "Mass Pay";
						break;
					
					case '2':		//Authorize.net
						echo "Merchant";
						break;
						
					default:		//1-paypal
						echo "Instant";
						break;

				}
				echo "\",";
				echo "\"PaymentProcessor\":\"" . $rs2['PaymentProcessor'] . "\",";
				echo "\"PaymentProcessorName\":\"";
				switch ($rs2['PaymentProcessor']) {
					case '2':		//Alert Pay
						echo "Alert Pay";
						break;
					
					case '3':		//Authorize.net
						echo "Authorize.net";
						break;
						
					case '4':		//Clickbank
						echo "Clickbank";
						break;
						
					default:		//1-paypal
						echo "Paypal";
						break;

				}
				echo "\",";
				echo "\"PaymentMethod\":\"" . $rs2['PaymentMethod'] . "\",";
				echo "\"PaymentMethodName\":\"";
				switch ($rs2['PaymentMethod']) {
					case '2':		//Clickbank
						echo "Split Payments";
						break;
					
					case '3':		//Clickbank
						echo "Chained Payments";
						break;
						
					default:		//1-paypal
						echo "Alternating Payments";
						break;

				}
				echo "\",";
				echo "\"PaymentType\":\"" . $rs2['paymentType'] . "\",";
				echo "\"PaymentTypeName\":\"";
				switch ($rs2['paymentType']) {				
					case '2':		//recurring
						echo "Recurring";
						break;
						
					default:		//1 - one time
						echo "One-Time";
						break;
				}
				echo "\",";
				echo "\"AutoClickbank\":\"" . $rs2['AutoClickbank'] . "\",";
				echo "\"AutoClickbankName\":\"";
				switch ($rs2['AutoClickbank']) {
					case '0':		
						echo "Disabled";
						break;
						
					default:		
						echo "Enabled";
						break;
				}
				echo "\",";
				echo "\"Status\":\"" . $rs2['Status'] . "\",";
				echo "\"StatusName\":\"";
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
					
				echo "\",";
				echo "\"EntryType\":\"" . $rs2['entryType'] . "\",";
				echo "\"AutoClickbank\":\"" . $rs2['AutoClickbank'] . "\",";
				echo "\"SignupNotifty\":\"" . $rs2['SignupNotifty'] . "\",";
				echo "\"SignupParameters\":\"" . $rs2['SignupParameters'] . "\",";
				echo "\"CancellationNotifty\":\"" . $rs2['CancellationNotifty'] . "\",";
				echo "\"CancellationParameters\":\"" . $rs2['CancellationParameters'] . "\"";
				
				echo "}";
				}
			echo "]}";
			
			?>