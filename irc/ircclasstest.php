<?php 

require_once("IRC_Class.php");

$ec = new gEncrypt();

$msgtxt = "This is a long Hello World message";
$coded = $ec->Encrypt($msgtxt);
$decoded = $ec->Decrypt($coded);

echo "message:  " . $msgtxt . "<br>";
echo "encrypted:" . $coded . "<br>";
echo "unencrypted:" . $decoded . "<br>";
echo "last error:" . $ec->LastError . "<br>";

echo "<BR><BR><BR><BR>Message Class Test<br><br>";

$mc = new gIRCMessages("testdev", "testapp", "1.1.1");
$mc->debugLevel = true;


if ($mc->status == false)
	echo "Failure code: " . $mc->lastError . "<br>";
else {
	
	echo "Message Build Test:<br>";
	$tstar['A'] = "valuea";
	$tstar['b'] = "valueB";
	$tstar['c'] = "valueC";
	
	$newmsg = $mc->BuildMessage($tstar);
	echo "New Message: " . $newmsg . "<br>";
	
	$newmsgarr = $mc->ExtractMessage($newmsg);
	
	echo "New Array from made Array:<br>";
	print_r($newmsgarr);
	
	echo "<br><br><br>Send Message Test:<br>";
	$mc->SendMessage("http://www.rapdevarea.com/rap_admin/addons/GIS/irc/messagereceivertest.php", "Hello There");

}


?>