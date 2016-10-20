<?php 

	// if no cookie then it is a new transaction, write status 1 and save transaction number
	// if cookie is set to 1 assume it was processed and set to 2 (sent to google)
	// if cookieis 2 do nothing unless the transaction id is different
	// if no transaction id then do nothing.
	
	if ( $_COOKIE['g_GAAction'] != '1') {
		setcookie("g_GAAction", "1", time()+(60*60*24*365));
		setcookie("g_txnid", $_REQUEST['id'], time()+(60*60*24*365*5));
	}  else if ($_COOKIE['g_GAAction'] == '1' && $_COOKIE['g_txnid'] != $_REQUEST['id']) {
		if (trim($_REQUEST['id']) <> "")
			setcookie("g_txnid", $_REQUEST['id'], time()+(60*60*24*365*5));
	} 
?>