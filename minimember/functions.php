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

//set variables used in the templates
$minimember_js = "<script language=\"javascript\" src=\"" . $sys_domain."/rap_admin/addons/GIS/minimember/templates/minimember.js" . "\"></script>";
$minimember_css = "<link href=\"" . $sys_domain . "/rap_admin/addons/GIS/minimember/templates/minimember.css\" type=\"text/css\" rel=\"stylesheet\" />";


function gInsertNewMember($emladdr, $newpwd) {

	$sql="insert into g_Members (email, password, createdDate) values ('" . $emladdr . "', '" . $newpwd . "', '" . date("Y-m-d H:i:s") . "')";
	$gid=mysql_query($sql);
	echo $sql;
}

function gSendNewMemberEmail($emladdr, $newpwd) {

}

function gGeneratePassword(){
	$passwd_length = gMMGetOptionInt("pwdlen", "7");
	
	$random_string = "abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*-+ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	
	for ($l=0; $l < $passwd_length; ++$l)
		$new_password .= substr($random_string,rand(0, strlen($random_string)),1);
		
	return $new_password;
}

function gMiniMemberSale() {
	global $sys_cust_email;
	
	//check to see if email already exists in the database
	$sql="SELECT * FROM g_Members WHERE email = '" . $sys_cust_email . "'";
	echo $sql;
	//return $sql;
	$gid=mysql_query($sql);
	echo mysql_num_rows($gid);
	if (mysql_num_rows($gid) == 0) {
		//new user, look to see how the password creation is supposed to work.
		if (gMMGetOptionInt("genpswd", "1") == '1') {
			//automatically generate password and email
			$newpwd = gGeneratePassword();
			gInsertNewMember($sys_cust_email, $newpwd);
			gSendNewMemberEmail($sys_cust_email, $newpwd);
		} else {
			//just in case the use leaves before entering password, create a blank user record
			gInsertNewMember($sys_cust_email, "");
			//present user with box to type in password
			
		}
	}
}


function gMMGetOptionChar($g_optionID, $defaultval) {
	$sql="SELECT * FROM g_MemberOptions WHERE optionCode = '" . $g_optionID . "'";
	//return $sql;
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['charVal'];
	} else {
		return $defaultval;
	}
}

function gMMGetOptionInt($g_optionID, $defaultval) {
	$sql="SELECT * FROM g_MemberOptions WHERE optionCode = '" . $g_optionID . "'";
	
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['intVal'];
	} else {
		return $defaultval;
	}
}

function gMMInsertOptionInt($g_optionID, $g_value) {
	$sql="INSERT into g_MemberOptions (optionCode, intVal) VALUES ( '" . $g_optionID . "', '" . $g_value . "')";
	$gid=mysql_query($sql);
}

function gMMInsertOptionChar($g_optionID, $g_value) {
	$sql="INSERT into g_MemberOptions (optionCode, charVal) VALUES ( '" . $g_optionID . "', '" . $g_value . "')";
	$gid=mysql_query($sql);
}
 

function gMMUpdateOptionInt($g_optionID, $g_value) {
	$sql = "Select * from g_MemberOptions where optionCode='" . $g_optionID . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) < 1) {
		$sql="INSERT into g_MemberOptions (optionCode, intVal) VALUES ( '" . $g_optionID . "', '" . $g_value . "')";
		$gid=mysql_query($sql);
	} else {
		$grow=mysql_fetch_array($gid);
		$sql="UPDATE g_MemberOptions set intVal = '" . $g_value . "' where uid = '" . $grow['uid'] . "'";
		$gid=mysql_query($sql);
	}
}

function gMMUpdateOptionChar($g_optionID, $g_value) {
	$sql = "Select * from g_MemberOptions where optionCode='" . $g_optionID . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) < 1) {
		$sql="INSERT into g_MemberOptions (optionCode, charVal) VALUES ( '" . $g_optionID . "', '" . $g_value . "')";
		$gid=mysql_query($sql);
	} else {
		$grow=mysql_fetch_array($gid);
		$sql="UPDATE g_MemberOptions set charVal = '" . $g_value . "' where uid = '" . $grow['uid'] . "'";
		$gid=mysql_query($sql);
	}
}