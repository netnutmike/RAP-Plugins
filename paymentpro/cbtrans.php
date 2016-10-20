<?php


include "settings.php";

function cust_email($type)
{
	global $sys_domain, $sys_install_folder, $sys_item_name, $sys_support, $sys_expire;
	global $firstname, $lastname, $fullname, $item_name;
	global $productID, $eaddress, $expires, $purchased, $txn_id, $payer_email;
	
	$sql = "SELECT * FROM emails WHERE productID=$productID AND type='$type'";
	$record=@mysql_fetch_assoc(mysql_query($sql));

	$subject = $record['subject'];
	$body = $record['body'];
	$a1=array('%firstname%','%lastname%','%fullname%','%itemname%','%download%','%expire%','%contact%');
	$a2=array(_decode($firstname), _decode($lastname),_decode($fullname), _decode($item_name), 
		_decode("http://$sys_domain" . $sys_install_folder . "?action=download&rx=1&id=$txn_id"),
		_decode($sys_expire), _decode($sys_support));
	$subject=str_replace($a1, $a2, $subject);
	$body=str_replace($a1, $a2, $body);
	@mail($payer_email, $subject, $body, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion());
}
# ___________________________________

# ___________________________________

// assign posted variables to local variables

$payment_date 		= $db->escape($_POST['payment_date']);
$txn_id 			= $db->escape($_POST['cbreceipt']);
$payer_email 		= $db->escape($_POST['cemail']);
$payer_firstname 	= $db->escape(trim(substr($_REQUEST['cname'],0,strpos($_REQUEST['cname'], " "))));
$payer_lastname 	= $db->escape(trim(substr($_REQUEST['cname'],strpos($_REQUEST['cname'], " "))));
$payer_country 		= $db->escape($_POST['ccountry']);
$affiliate	 		= $db->escape($_POST['cbaffi']);
$zip			 	= $db->escape($_POST['czip']);
$payment_status 	= $db->escape($_POST['payment_status']);
$custom 			= $db->escape(urldecode($_POST['vvar']));

$customfield=explode("|",$custom);
$ip					= $customfield[1];
$item_number 		= $customfield[2];
$item_name 			= $customfield[3];
$salesletter		= $customfield[4];
$referrer			= $customfield[5];
$secret				= $customfield[6];

$firstname=$payer_firstname;
$lastname=$payer_lastname;
$fullname=$firstname." ".$lastname;

$sql = "SELECT * FROM products WHERE item_number = '".$item_number."' OR oto_number = '".$item_number."'";
$pres = @mysql_query($sql);
$prow = @mysql_fetch_array($pres);

$sys_install_folder = $prow['install_folder'];
$sys_ipn_email = $prow['ipn_email'];
$sys_item_name = $prow['item_name'];
$sys_item_price = $prow['item_price'];
$sys_item_number = $prow['item_number'];
$sys_oto_name = $prow['oto_name'];
$sys_oto_price = $prow['oto_price'];
$sys_oto_number = $prow['oto_number'];
$sys_expire = $prow['expire'];
$sys_aw_flag = $prow['aw_flag'];
$sys_pending_email = $prow['ipn_pending_email'];

$productID = $prow['id'];

$expires = date('Y-m-d H:i:s',(time() + (3600 * $sys_expire)));
$purchased = date('Y-m-d H:i:s');



# List of email provider extensions to ignore when looking for duplicate email domains.
$validisps = array($myhost,"@yahoo.com","@aol.com","@hotmail.com","@gmail.com","@yahoo.co.uk",
	"@comcast.net","@netscape.com","@netscape.net","@juno.com","@verizon.net");

	$eaddress = $sys_adminmail;

    // send a notification email
    if($sys_ipnlog)
    {
	    $subject = '[ClickBank] Sale/Refund Notification Log';

	    $to = $sys_adminmail;    //  your email
	    $body =  "A new sale/refund was processed\n";
	    $body .= "for customer ".$payer_email." on ".date('m/d/Y');
	    $body .= " at ".date('g:i A')."\n\nDetails:\n\n";
			    
	    if(strtolower($_POST['receiver_email']) != $sys_paypal &&
	    	strtolower($_POST['receiver_email']) != strtolower($affiliate))
	    {
	    	
		}
             
		foreach ($_POST as $key => $value) 
		{
			$value = urlencode(stripslashes($value));
			$body .= $key.": ".urldecode($value)."\n"; 
		}		

		@mail($to, $subject, $body, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion());
	}

		
	// check if the payment_status is Refunded
	if($payment_status=="Refunded") {
		$expires = date('Y-m-d H:i:s',(time()));
		@mysql_query("UPDATE sales SET refunded=true, expires='".$expires."' WHERE txn_id ='".$parent_txn."'");
		}

	// check if the payment_status is Completed
	if($payment_status=="Completed")
	{
		$response_secret = md5($sys_secret.$ip.$item_number);
		if(!$subscr_id_flag && $secret && ($response_secret != $secret)) {
			# A dishonest person tried to cheat and buy the product for less than its cost.  
			# Send them an email notifying them that they will not be receiving the download 
			# and that they will be reported to PayPal for fraud.
	
			# Write payment info to fraud table
			$sql="INSERT INTO fraud (productID,txn_id,item_name,item_number,payer_email,firstname,lastname,expires,purchased,referrer,affiliate,ip_address,country,state,zip,salesletter)
				VALUES('".$productID."','".$txn_id."','".$item_name."','".$item_number."','".$payer_email."','".$payer_firstname."','".$payer_lastname."','".$expires."','".$purchased."','".$referrer."','".$affiliate."','".$ip."','".$country."','".$state."','".$zip."','".$salesletter."')";
			$result=@mysql_query($sql);		

		    $subject = '[Clickbank] Fraud Notification';
		    $body =  "A fraudulent sale/refund was processed\n";
		    $body .= "for customer ".$payer_email." on ".date('m/d/Y');
		    $body .= " at ".date('g:i A')."\n\nDetails:\n\n";
	    	$body .= "It was determined that the customer altered one of the following values:\n";
	    	$body .= "    1. the amount of the transaction,\n";
	    	$body .= "    2. the item_number, or\n";
	    	$body .= "    3. the payee information\n\n";
			$body .= "The customer was NOT delivered to your Download Page,\n";
			$body .= "and the transaction was recorded in the Fraud Report.\n\n";
			
			$body .= "Item Number   = ".$item_number."\n"; 
			$body .= "IP Address    = ".$ip."\n\n";
	             
			$body .= "Also, it is suggested that you report this person to Clickbank's fraud department.\n\n";
			$body .= "The person's information is as follows:\n\n";
			$body .= "Email Address: $payer_email\n";
			$body .= "First Name: $payer_firstname\n";
			$body .= "Last Name: $payer_lastname\n";
			$body .= "Country: $payer_country\n\n";
		    @mail($sys_fraud, $subject, $body, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion());
			}
			
		if(($item_number == $sys_item_number) || ($item_number == $sys_oto_number)) {
			// process payment
			# Write payment info to sales table
			$sql="INSERT INTO sales (productID,txn_id,item_name,item_number,payer_email,firstname,lastname,expires,purchased,referrer,affiliate,ip_address,country,state,zip,salesletter)
				VALUES('".$productID."','".$txn_id."','".$item_name."','".$item_number."','".$payer_email."','".$payer_firstname."','".$payer_lastname."','".$expires."','".$purchased."','".$referrer."','".$affiliate."','".$ip."','".$country."','".$state."','".$zip."','".$salesletter."')";
					$result=@mysql_query($sql);
			if($sys_ipn_email){
				# Send download notification to purchaser
				cust_email('download');
			}
			
		}
	}


	// perform Add On ipn processing - if any
	
	$sql="SELECT * FROM addons";
	$addres=@mysql_query($sql);
	while($addrec=@mysql_fetch_assoc($addres)) 
	{
		$filename = "addons/".$addrec['groupfolder']."/".$addrec['addonfolder']."/ipn.php";
		@include $filename;
	}
}
?>