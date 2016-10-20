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

//==============================================================================================
//
//  Function: gGravatar
//
//  Parameters:
//     	gravatarType - Specifies which gravatar type(s) to be output as per the values below:
//			OWNER (DEFAULT) - 	Displays only the site owner gravatar
//			AFFILIATE		-	Displays on the affiliates gravatar.  If no affiliate is set
//								then no gravatar is displayed
//			AFFILIATE-OWNER - 	Will diplay the affiiate first if one is set, if no affiliate then
//								it will display the owner gravatar.
//			AFFIIATE+OWNER 	-	Will Display the affiliate gravatar if an affiliate is set and
//								display the site owner gravatar below the affiliates
//			AFFILAITE+OWNERSS - Will Display the affiliate gravatar if an affiliate is set and
//								display the site owner gravatar side by side
//
//  TODO:
//		Add the option for JV Partners only so that hosted reseller is only way to override the
//		site owners image.
//
//==============================================================================================
function gGravatar($gravatarType = "Owner") { 
	global $affiliate, $sys_paypal; 
	
	switch (strtoupper($gravatarType)) {
		
		case "AFFILIATE":			//Only display Affiliate, if no affiliate do not display gravatar
			if ($affiliate){
				$agrav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $affiliate ) ) ) . "?d=mm&s=80";
				echo "<img src=\"".$agrav_url."\" alt=\"\" /> <br /> <br />";
			} 
			break;
			
		case "AFFILIATE-OWNER":		//Priority is to display the affiliate first then owner if no affiliate
			
			if ($affiliate){
				$agrav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $affiliate ) ) ) . "?d=mm&s=80";
			} else {
				$mgrav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $sys_paypal ) ) ) . "?d=mm&s=80";
			}
			echo "<img src=\"". $mgrav_url ."\" alt=\"\" /><br /><br />";
			break;
			
		case "AFFILIATE+OWNER":		//Display affiliate if they exist and the owner one on top of the other
			if ($affiliate){
				$agrav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $affiliate ) ) ) . "?d=mm&s=80";
				echo "<img src=\"".$agrav_url."\" alt=\"\" /> <br /> and <br />";
			} 
			
			$mgrav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $sys_paypal ) ) ) . "?d=mm&s=80";
			echo "<img src=\"". $mgrav_url ."\" alt=\"\" /><br /><br />";
			break;
			
		case "AFFILIATE+OWNERSS":	//Display affiliate if they exist and the owner side by side
			if ($affiliate){
				$agrav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $affiliate ) ) ) . "?d=mm&s=80";
				echo "<img src=\"".$agrav_url."\" alt=\"\" />  and ";
			} 
			
			$mgrav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $sys_paypal ) ) ) . "?d=mm&s=80";
			echo "<img src=\"". $mgrav_url ."\" alt=\"\" /><br /><br />";
			break;			
			
		default:  // Site Owner Only
			$mgrav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $sys_paypal ) ) ) . "?d=mm&s=80";
			echo "<img src=\"". $mgrav_url ."\" alt=\"\" /><br /><br />";
			break;	
	}

}