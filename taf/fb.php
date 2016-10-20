<?

$xPost['access_token'] = "{key}";
$xPost['message'] = "Posting a message test.";

$ch = curl_init('https://graph.facebook.com/' . $_POST['FBName'] . '/feed'); 
curl_setopt($ch, CURLOPT_VERBOSE, 1); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HEADER, 1); 
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $xPost); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);  
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 

$result = curl_exec($ch); 

?>