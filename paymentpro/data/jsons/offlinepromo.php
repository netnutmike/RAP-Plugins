<?php 			

			$query = "SELECT g_PaymentProPromoCodes.*, products.install_folder from g_PaymentProPromoCodes, products where uid = '" . $_REQUEST['uid'] . "' and products.id = g_PaymentProPromoCodes.productID";
			//echo $query . "<BR><BR>";
		
			//echo $query;
			$request = mysql_query($query);
			echo "{\"totalCount\":[" . mysql_num_rows($request) . "],\"offlinepromo\":[";
	
			$beenhere = false;
	
			while ($rs = mysql_fetch_array($request)){
				if ($beenhere)
					echo ",";
			
				$beenhere = true;
				
				$query3 = "SELECT * from products where id ='" . $rs['productID'] . "'";
				$request3 = mysql_query($query3);
				$rs3 = mysql_fetch_array($request3);
				
		
				echo "{";
				echo "\"uid\":\"" . $rs["uid"] . "\",";
				echo "\"promoCode\":\"" . $rs['promoCode'] . "\",";
				echo "\"promoDescription\":\"" . $rs['promoDescription'] . "\",";
				echo "\"productID\":\"" . $rs['productID'] . "\",";
				echo "\"productName\":\"" . $rs3['item_name'] . "\",";
				echo "\"status\":\"" . $rs['status'] . "\",";
				echo "\"statusName\":\"";
				switch ($rs['status']) {
					case '1':		
						echo "Enabled";
						break;
						
					default:		
						echo "Disabled";
						break;
				}
				echo "\",";
				echo "\"maxCount\":\"" . $rs['maxCount'] . "\",";
				echo "\"Price\":\"" . $rs['Price'] . "\",";
				echo "\"ProdURL\":\"http://" . $sys_domain .  $rs['install_folder'] . "?pc=" . $rs['promoCode'] . "\"";
				
				echo "}";
				}
			echo "]}";
			
			?>