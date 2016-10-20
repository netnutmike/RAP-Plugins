<?

require_once('lib/nusoap.php');

// NOTES:
//   Random Encryption Per Message
//   each install has a random generated key that i used to initiate the tie together process
//
//   public key for affiliates (optional, can be setup to not require a key)
//   random key per affiliate (optional)
//
//   each tie has permissions they allow
//      rwxu per table
//      during negotiation, requested permission is sent and can be declined
//      can be setup to allow any sites from the same administrator to have override permissions
//      daily status checks to verify that a connection is still valid and the administrator has not changed
//
//   Never send password, this includes admin and affiliates
//   For admin table do not allow a select *
//   For nicknames table do not allow a select *
//
//   Allow Auto-Connect or verify by AppID, by Source, By Admin, by appid with certain permission, source with permission or admin with permission
//   Auto-Reject by AppID, Source, Admin, Appid with permission, Source with Permission, Admin with permission
//
//   Link Protocol
//   Requestor                                             Requestee
//    Link Request       ------>                 Recieved
//                                             /  Auto-Reject?          (DECLINE)
//    Link Response                   <--------   Auto-Connect?         (APPROVE)
//                                             \  Request-Permission?   (WFA)

// 
//   Link Approve (non auto-approve)
//   Requestor                                             Requestee
//                                                Generate Auto LinkKey
//    Link Response                   <--------   Approve Message
//    Validate Requested Permission
//      Auto-Reject        \
//      Auto-Connect        -------------->       If Approved, Done, If Rejected delete LinkKey
//      Request-Permission /

// 
//   Link Validated (non auto-approve)
//   Requestor                                             Requestee
//                                               
//    Approve Message     -------------->         Link Response


// Messages
//
//Message Variables:
//Type
//AppID
//TieKey
//Permissions
//SiteURL
//SiteAdmin
//DateTime
//LinkKey
//Reason

// Link Request
//  Type - Link (site to site bidirectional), Stats (read only by affiliate), Unlink (remove Link), Status (returns the link status)
//  AppID - Must be a valid registered APP ID or else it is rejected
//  TieKey - This is the site that is being requested TieKey.  It must be provided by the site being connected to.  After the tie is complete traffic can go bidirectional so only one site must initiate
//  Permissions - List of tables and permissions that are being requested
//  SiteURL - Url of site requestion.  It is assumed that rap can be found at url/rap_admin
//  SiteAdmin - Paypal Email address of site admin
//  REQKey - This is the requesting sites Tie Key.  This key is used to authenticate the return messages until the Link Key is Established
//  DateTime - Date and time in yyyymmddhhmmss format

// Link Response
//  Type - Approve, Waiting For Authorization, Decline
//  AppID - Must be a valid registered APP ID or else it is rejected
//  TieKey - This is the tie key of the original requesting site
//  Permissions - List of tables and permissions that are being requested
//  SiteAdmin - Paypal Email address of site admin
//  DateTime - Date and time in yyyymmddhhmmss format
//  LinkKey - This is the permanent shared key between the sites
//  Reason - Used when a decline is sent to provide a reason

// Link Status
//  Type - Status
//  Permissions - List of tables and permissions that are being requested
//  SiteAdmin - Paypal Email address of site admin
//  DateTime - Date and time in yyyymmddhhmmss format
//  LinkKey - This is the permanent shared key between the sites
//  Status - Returns the status code


//Classes
//   LinkProtocol
//   remSql
//   Site
//   RemoteControl

class RemoteControl {

	public function SendMessage() {
	
	}
	
	public function ReceivedMessage($msgtext) {
	
	}
}

class LinkProtocol {

	public function LinkRequest($url) {
	
	}
	
	public function ReceivedRequest($datastr) {
	
	}
	
	
	
}

class Product {

	public function LoadByID($prodid) {
	
	}
}

class Site {

	public function LoadByID($siteid) {
	
	}
	
	public function LoadByLinkKey($linkkey) {
	
	}
}


class remSQL {

	public $rs = "";
	public $c;
	public $url;
	public $sql;
	public $cur_rec = 0;
	public $xml;
	public $max_rec;
	
	public function Connect($curl) {
		$this->url = $curl;
		$this->c = new nusoap_client($curl);
	
		
		//return $this->c;
	}
	
	public function SiteConnectByID($id) {
		$csite = new Site;
		$csite->LoadByID($id);
		$this->url = $csite->GetURL();
		$this->c = new nusoap_client($curl);
	
		
		//return $this->c;
	}
	
	public function SiteConnectByProductID($id) {
		$this->url = $curl;
		$this->c = new nusoap_client($curl);
	
		
		//return $this->c;
	}

	function Query($csql) {
		//$key="XiTo74dOO09N48YeUmuvbL0E";
		
		$this->sql = $csql;
		
		//reset current record to 0
		$this->cur_rec = 0;

		$qryresult = $this->c->call('dbqry', array('sql' => $csql));

		$this->xml = simplexml_load_string($qryresult);
	
		$this->max_rec = count($this->xml);
	}
	
	function fetch_row() {
	
		if ($this->cur_rec >= $this->max_rec)
			return false;
			
		$rowarray = $this->xml->Record[$this->cur_rec];

		++$this->cur_rec;
		 
		return $rowarray;
	}
	
	function num_rows() {
		return $this->max_rec;
	}
	
	function get_xml() {
		return $this->xml;
	}
	
	function get_row($rownum) {
		if ($rownum > $this->max_rec)
			return false;
			
		$rowarray = $this->xml->Record[$rownum];
		 
		return $rowarray;
	}
}

$iv = mcrypt_create_iv (mcrypt_get_block_size (MCRYPT_TripleDES, MCRYPT_MODE_CBC), MCRYPT_DEV_RANDOM);
$key="XiTo74dOO09N48YeUmuvbL0E";

// Encrypting
function encrypt($string, $key) {
    $enc = "";
    global $iv;
    $enc=mcrypt_cbc (MCRYPT_TripleDES, $key, $string, MCRYPT_ENCRYPT, $iv);

  return base64_encode($enc);
}

// Decrypting
function decrypt($string, $key) {
    $dec = "";
    $string = trim(base64_decode($string));
    global $iv;
    $dec = mcrypt_cbc (MCRYPT_TripleDES, $key, $string, MCRYPT_DECRYPT, $iv);
  return $dec;
}

?>