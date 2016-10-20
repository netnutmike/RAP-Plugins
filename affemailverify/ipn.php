<?



function g_verifyPrimaryEmail()
{
	global $productID, $receiver_email, $affiliate, $tier, $sys_paypal;
	
	//if it is system paypal we are good
	if ($receiver_email == $sys_paypal) 
		return;

	//if it is affiliate paypal we are good
	if ($receiver_email == $affiliate) 
		return;
		
	//check equity partners for this product
	
		
	//if we make it here it is not found and we should probably reset the affiliate email to the receiver_email
	//it could be an EP did not use his Primary too.
		
}

g_verifyPrimaryEmail();


?>