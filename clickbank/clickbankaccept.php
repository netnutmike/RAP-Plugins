<?php

$secret = md5($sys_secret.$ip.$item_number);

echo <<< END

	<form action="$sys_paypal_URL" method="post" id="paymentform">
		
		<input type="hidden" name="custom" 
				value="RAP|$ip|$productID|$sys_item_name|$salesletter|$_COOKIE[ref]|$secret">
	</form>
END;

?>