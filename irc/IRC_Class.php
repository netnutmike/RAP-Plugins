<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright 2009, 2010 Genius Idea Studio, LLC. All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Genius Idea 
| Studio, LLC regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.   
|
| ================================================================
| RAP-tools.com IRC Class Definitions
| ================================================================
+--------------------------------------------------------------------------
*/

// Class GEncrypt
class gEncrypt
{

	//=========================================================================
	//
	//  E N C R Y P T E D   M E S S A G E   F O R M A T
	//
	//	Encryption Type (1 char)
	//	Date and Time (12)
	//	Verifyer
	//	Length
	//	Payload
	//	Verifyer2
	//	MD5
	//
	//=========================================================================
	
	//declare properties
	public $LastError = "No Error";
	
	//declare functions
	public function Encrypt($estring) {
	
		$rv = $this->RandomVar();
		//echo "rv: " . $rv . "<br>";
		$vl = $this->VarList($rv);
		//echo "vl: " . $vl . "<br>";
		
		$es = "";
		for ($l=0; $l<strlen($estring); ++$l) {
			$es .= substr($vl, ord(substr($estring, $l, 1)), 1);
		}
		
		$dtm = gmdate("dHYimO");
		$ver1 = substr($dtm,2,1) . substr($vl, ord($rv), 1) . substr($dtm,3,1);
		$ver2 = substr($dtm,8,1) . substr($vl, ord(substr($ver1,1,1)), 1) . substr($dtm,9,1);
		$gl = dechex(strlen($es));
		if (strlen($gl) == 1)
			$gl = "000" . $gl;
			
		if (strlen($gl) == 2)
			$gl = "00" . $gl;
			
		if (strlen($gl) == 3)
			$gl = "0" . $gl;
		
		//echo "es: " . $es . "<br>";
		$om = $rv . $dtm . $ver1 . $gl . $es . $ver2;
		$om .= md5($om);
		
		return $om;
		
	}
	
	public function Decrypt($estring) {
	
		//extract the message
		$rv = substr($estring, 0, 1);
		$vl = $this->VarList($rv);
		$dtm = substr($estring, 1, 17);
		$ver1 = substr($estring, 18, 3);
		$gl = substr($estring, 21, 4);
		$pl = substr($estring, 25, hexdec($gl));
		$ver2 = substr($estring, (25 + hexdec($gl)), 3);
		$chksum = substr($estring, 28 + hexdec($gl));
		
		//verifications the message is tampered with
		
		//verify md5
		if (md5($rv . $dtm . $ver1 . $gl . $pl . $ver2)  != $chksum)
		{
			$this->LastError = "md5 checksum error (11)";
			return false;
		}
		
		//verify first verifyer code
		if ($ver1 != (substr($dtm,2,1) . substr($vl, ord($rv), 1) . substr($dtm,3,1)) ){
			$this->LastError = "Message Could Not Be Verified (22)";
			return false;
		}
		
		//verify second verifyer code
		if ($ver2 != (substr($dtm,8,1) . substr($vl, ord(substr($ver1,1,1)), 1) . substr($dtm,9,1)) ){
			$this->LastError = "Message Could Not Be Verified (23)";
			return false;
		}
		
		//verify the message age
		$datetime1 = time();
		$datetime2 = gmmktime(substr($dtm, 2, 2), substr($dtm, 8, 2), "00", substr($dtm, 10, 2), substr($dtm, 0, 2), substr($dtm, 4, 4));
		$interval = abs($datetime1 - $datetime2);
		
		//echo "dtstr: " . $dtm . "<br>";
		//echo "timestr: " . substr($dtm, 2, 2). substr($dtm, 10, 2). "00". substr($dtm, 8, 2). substr($dtm, 0, 2). substr($dtm, 4, 4) . "<br>";
		//echo "$datetime1: " . $datetime1 . "<br>";
		//echo "$datetime2: " . $datetime2 . "<br>";
		if ($interval > (65 * 60)){
			$this->LastError = "Message Is Too Old (33)";
			return false;
		}
		
		$es = "";
		for ($l=0; $l<strlen($pl); ++$l) {
			$es .= chr(strpos($vl, substr($pl, $l, 1)));
		}
	
		return $es;
	}
	
	//set the array based on the key
	private function VarList($arval) {
	
		$keyval['A'] = "1qaz2wsx3edc4rfv5tgb6yhn7ujm8ik,9ol.0p;/-['=]\\!QAZ@WSX#EDC\$RFV%TGB^YHN&UJM*IK<(OL>)P:?_{\"+}|`~";
		$keyval['D'] = "~!QAZ`1qaz@WSX2wsx#EDC3edc\$RFV4rfv%TGB5tgb^YHN6yhn&UJM7ujm*IK<8ik,(OL>9ol.)P:?0p;/_{\"-['+}=]|\\";
		$keyval['F'] = "`1qaz~!QAZ2wsx@WSX3edc#EDC4rfv\$RFV5tgb%TGB6yhn^YHN7ujm&UJM8ik,*IK<9ol.(OL>0p;/)P:?-['_{\"=]+}\\|";
	
		return "                                " . $keyval[$arval];
	}
	
	private function RandomVar() {
		$KeyVals = "ADF";
		
		return substr($KeyVals, rand(0, strlen($KeyVals)-1), 1 );
	}
}

class gIRCMessages
{
	//=========================================================================
	//
	//  M E S S A G E   F O R M A T
	//
	//	Developer ID
	//	Application ID
	//	Message ID
	//	Message Type
	//	Length
	//	Payload
	//	MD5
	//
	//=========================================================================
	
	//define class globals
	public $msgHandler = "";
	public $devID = "";
	public $appID = "";
	public $appVersion = "";
	public $cacheFile = "gIRCCache";
	public $lastError = "";
	public $debugLevel = false;
	public $status;
	public $returnedText;
	
	function __construct($devid = "", $appid = "", $version = "", $cachefile = "gIRCCache", $dbglvl = false) {

		// set the debug level first
		if ($dbglvl)
			$this->debugLevel = true;
			
		//set class properties
		if ($cachefile == NULL || trim($cachefile) == "")
			$cachefile = "gIRCCache";
		$this->cacheFile = $cachefile;
		$this->devID = $devid;
		$this->appID = $appid;
		$this->appVersion = $version;
		
		//verify the developer ID and application id
       
		if (!$this->VerifyApplication($devid, $appid, $version)) {
			$this->status = false;
			return false;
		}
			
		if (trim($devid) == ""){
			$this->lastError = "Developer ID is Required";
			$this->status = false;
			return false;
		}
		
		if (trim($appid) == ""){
			$this->lastError = "Application ID is Required";
			$this->status = false;
			return false;
		}
		
		if (trim($version) == ""){
			$this->lastError = "Version Number is Required";
			$this->status = false;
			return false;
		}

		$this->status = true;
   	}
   	
   	
   	// *** public functions ***
   	public function SetDebug($onoff) {
   		if ($onoff)
   			$this->debugLevel = true;
   		else
   			$this->debugLevel = false;
   	}
   	
   	//	Developer ID
	//	Application ID
	//	Message ID
	//	Message Type
	//	Length
	//	Payload
	//	MD5
	public function SendMessage($dest = "", $msgtxt = "", $msgtype = "AAA", $msgid="", $returnurl="") {
		//device needed variables and classes
		$ec = new gEncrypt();
		$pl = $ec->Encrypt($msgtxt);
		$pll = $this->FixLength(dechex(strlen($es)), 4, "0");
				
		$message = $this->NewMessageID($msgid);
		$message .= $this->FixLength($this->devID, 8);
		$message .= $this->FixLength($this->appID, 8);
		$message .= $this->FixLength($msgtype,3);
		$message .= $pll;
		$message .= $pl;
		$message .= md5($this->devID . $this->appID . $msgtype . $pll . $pl);
		
		$file = $dest . "?ms=" . $message . "&dn=" . $_SERVER['HTTP_HOST'];
		if (trim($returnurl) != "")
			$file .= "&rt=" . $returnurl;
		$file = str_replace(" ", "%20", $file);
		
		if ($this->debugLevel)
			echo "Message URL: " . $file . "<br>";
			
		$returned = "";
		$fp   = @fopen($file,"r");
		if ($fp) {
		    while($line = @fgets($fp,1024))
		    	$returned .= $line;
		 
		    fclose($fp);
		    
		    if (substr($returned,0,4) == "-OK-") {
		    	$this->returnedText = substr($returned,4);
		    	return true;
		    } else {
		    	$this->returnedText = $returned;
		    	$this->lastError="Did not receive a valid response, review the returnedText";
		    	return false;
		    }
		} else {
			$this->returnedText="";
			$this->lastError="Could not open URL";
			return false;
		}
	}
	
	public function BuildMessage($arr) {
		$msgstr="";
		foreach ($arr as $key => $value) { 
			if (trim($msgstr) != "")
				$msgstr .= "||";
    		$msgstr .= $key . "_+" . $value;
		}
		
    	return $msgstr;
	}
	
	public function ExtractMessage($payload) {
		$fields = split("\|\|", $payload);
		foreach ($fields as $value) {
			$v = split("_\+", $value);
			$rtnarr[$v[0]] = $v[1];
		}
		return $rtnarr;
	}
	
	public function ReceiveMessage() {
	
	}
	
	public function RegisterHandler() {
	
	}
	
	// *** private functions ***
	private function NewMessageID($sid) {
	
	}
	
	
	//format a string to a fixed length, if too long shorten, if too short insert in front of
	private function FixLength($str, $len, $fillwith = "x") {
	
		if (strlen($str) > $len)
			return substr($str,-$len);
			
		if (strlen($str) == $len)
			return $str;
			
		$prestr = "";
		for ($l=strlen($str); $l < $len; ++$l)
			$prestr .= $fillwith;
			
		return $prestr . $str;
	}
	
	private function QueueMessage() {
	
	}
	
	private function CheckQueue() {
	
	}
	
	private function MessageSent() {
	
	}
	
		
	private function InCache($devid, $appid){
	
		//loop through the cache entries looking for the app and developer in less than 24 hours
		$handle = @fopen($this->cacheFile, "r"); // Open file for read.
		
		if ($this->debugLevel)
			echo "cachefile: " . $this->cacheFile . "<br>";

		if ($handle) {
			$ec = new gEncrypt();
			while (!feof($handle)) // Loop til end of file.
				{
				$buffer = fgets($handle, 4096); // Read a line.
				$decrypted = $ec->Decrypt($buffer);
				if ($decrypted != false)
					{
					if ($this->debugLevel)
						echo "decrypted: " . $decrypted . "<br>";
					
					$vals = split("\|", $decrypted);
					if ($this->debugLevel) {
						echo "vals[0]: " . $vals[0] . "<br>";
						echo "devid " . $devid . "<br>";
						echo "vals[1]: " . $vals[1] . "<br>";
						echo "appid: " . $appid . "<br>";
					}
					
					if ($vals[0] == $devid && $vals[1] == $appid)
						return true;
					}
				}
			fclose($handle); // Close the file
		}
		
		return false;
	}
	
	private function AddCacheEntry($devid, $appid) {
	
		//loop through the cache entries removing old entries, append new one to the end
		if (file_exists($this->cacheFile)) {
			rename($this->cacheFile, $this->cacheFile . ".tmp");
			$handle = @fopen($this->cacheFile . ".tmp", "r"); // Open file for read.
			$handle2 = @fopen($this->cacheFile, "w"); // Open file form read.

			if ($this->debugLevel)
				echo "cachefile: " . $this->cacheFile . "<br>";
		
			if ($handle) {
				$ec = new gEncrypt();
				while (!feof($handle)) // Loop til end of file.
					{
					$buffer = fgets($handle, 4096); // Read a line.
					$decrypted = $ec->Decrypt($buffer);
					if ($decrypted != false)
						fputs($handle2, $buffer);
					}
				fclose($handle); // Close the file
			}
			unlink($this->cacheFile . ".tmp");
		} else {
			$handle2 = @fopen($this->cacheFile, "w"); // Open file form read.
		}
		
		fputs($handle2, $ec->Encrypt($devid . "|" . $appid));
		fclose($handle2);
		
		return false;
	}
	
	private function VerifyApplication($devid, $appid, $version) {
	
		//check cache first, if it is within cache time then no need to inquire again.
		if ($this->InCache($devid, $appid))
			return true;
			
		if ($this->debugLevel)
			echo "not in cache<br>";
			
		//not in cache so go lookup the app and developer
		
		$file = "http://rap-tools.com/rap_admin/addons/GIS/appmgr/verify.php?dv=" . $devid . "&ap=" . $appid . "&vr=" . $version . "&dn=" . $_SERVER['HTTP_HOST'];
		$file = str_replace(" ", "%20", $file);
		
		$fp   = @fopen($file,"r");
		if ($fp) {
		    $line = @fgets($fp,1024);
		    fclose($fp);
		}
		$line="1";
		if ($line == "1") {
			//success
			$this->AddCacheEntry($devid, $appid);
			return true;
		} else {
			//failed
			return false;
		}
	}
}

class gMessageHandler
{

}


class gIRCFunctions
{

	public $msgClass;
	
	function __construct($devid = "", $appid = "") {
       $msgClass = new gIRCMessages($devid, $appid);
       
       if ($msgClass->Status != 1)
       	return false;
   	}
   	
	public function VerifySale() {
	
	}
	
	public function AddAffiliate() {
	
	}
	
	public function LookupAffiliate() {
	
	}
	
	public function VerifyAffiliate() {
	
	}
	
	public function LookupValue() {
	
	}
	
	public function NewSale() {
	
	}
	
	public function Connect() {
	
	}
	
	public function Query() {
	
	}
	
}


class gReceiver
{

}
?>