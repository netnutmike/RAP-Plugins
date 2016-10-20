<?
//==============================================================================================
//
//	Filename:	functions.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2010(c), Genius Idea Studio, LLC
//
//	Product Is Available For Download From www.rap-tools.com
//
//	Description:	This is a global functions file.
//
//	Version:	1.0.0 (March 29th, 2010)
//
//	Change Log:
//				03/29/10 - Initial Version (JMM)
//
//==============================================================================================

function gAutoOptin($grpcode = "", $startcount = 1) { 
	global $firstname, $lastname, $fullname, $email, $affiliate, $awreturnurl; 
	global $sys_cust_fname,$sys_cust_lname,$sys_cust_fullname,$sys_cust_email; 
	global $productID;
	
	//if no group code then do nothing
	if ($grpcode == "")
		return;
		
	//if -- then output all groups
	if ($grpcode == "--")
		$grpcode = "";
		
	//$g_flhndl = fopen("gAutoOptin.log", "a");
	//fwrite($g_flhndl, "Group Code: " . $grpcode . "\r\n");
	//fclose($g_flhndl);
	
	if(!isset($_REQUEST['rx']) && !isset($_REQUEST["ardone"])) 
	{ 
		$a1=array('%firstname%','%lastname%','%fullname%','%email%','%affiliate%','%redirect%'); 
		$a2=array(_decode($sys_cust_fname), _decode($lastname),_decode($sys_cust_fullname), _decode($sys_cust_email), _decode($affiliate),_decode($awreturnurl));

		//loop through all options for this product and globally
		//set count for name to 1
		$lpcnt=$startcount;
		$sql="select * from g_autoResponderOptions where (productID='" . $productID . "' or productID='0') and status='1'";
		//echo sql;
		
		if (trim($grpcode) != "")
			$sql .= " and GroupCode='" . $grpcode . "'";
			
		$gid=mysql_query($sql);
		while ($grow = mysql_fetch_array($gid)) {
			$optin_form=str_replace($a1, $a2, $grow['optionText']);
			$optin_form=str_replace("id=\"optin\"", "id=\"optin" . $lpcnt . "\"", $optin_form);
			$optin_form=str_replace("name=\"optin\"", "name=\"optin" . $lpcnt . "\"", $optin_form);
			$optin_form=str_replace("target=\"iframe\"", "target=\"iframe" . $lpcnt . "\"", $optin_form);

			$optin_form.=" 
			<script language=javascript> 
				document.getElementById('optin" . $lpcnt . "').submit(); 
			</script>"; 
			$auto_optin="<iframe name=\"iframe" . $lpcnt . "\" style=\"display:none\"></iframe>$optin_form"; 
			echo $auto_optin;
			++$lpcnt;
		} 
	} 
}