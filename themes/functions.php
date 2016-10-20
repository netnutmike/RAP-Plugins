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
//	Version:	1.0.0 (March 11th, 2010)
//
//	Change Log:
//				03/11/10 - Initial Version (JMM)
//
//==============================================================================================

function gExtraField($fldnum) {
	global $g_gflds;
	
	echo $g_gflds[$fldnum -1];
}

function gTemplate($g_file = "") {

	global $productID, $filename, $g_gsfo;
	global $sys_version, $sys_adminuser, $sys_adminpass, $sys_domain, $sys_eaddress, $sys_support;
	global $sys_supportlink, $sys_fraud, $sys_paypal, $sys_sandbox, $sys_adminmail, $sys_glbaff;
	global $sys_secret, $sys_tmpl_folder, $sys_item_name, $sys_item_number, $sys_item_price;
	global $sys_two_tier, $sys_item_pct, $sys_item_pct2, $sys_jv_item_pct, $sys_jv_item_pct2;
	global $sys_item_download, $sys_bypass_squeeze, $sys_aw_flag, $sys_aw_meta_id, $sys_aw_unit;
	global $sys_ar_form, $sys_aw_jv_flag, $sys_aw_jv_form_id, $sys_aw_jv_unit, $sys_jv_ar_form;
	global $sys_aw_aff_flag, $sys_aw_aff_form_id, $sys_aw_aff_unit, $sys_aff_ar_form, $sys_jvcode;
	global $sys_oto_flag, $sys_oto_name, $sys_oto_number, $sys_oto_price, $sys_oto_pct, $sys_oto_pct2;
	global $sys_jv_oto_pct, $sys_jv_oto_pct2, $sys_oto_download, $sys_cancel_url, $sys_get_zips;
	global $sys_expire, $sys_taf, $sys_taf_subject, $sys_taf_body, $sys_taf_count, $sys_max_sales;
	global $sys_cust_only, $sys_otocust_only, $sys_giveaway, $sys_ipn_email, $sys_pending_email;
	global $sys_currency, $sys_locale, $sys_testmode, $sys_disabled, $sys_item_orderbutton;
	global $sys_oto_orderbutton, $sys_item_desc, $sys_item_kw, $sys_eq1_pct, $sys_eq2_pct;
	global $sys_eq1_paypal, $sys_eq2_paypal, $sys_pp_return, $sys_pp_hdrimage, $sys_pp_hdrback;
	global $sys_pp_hdrborder, $sys_pp_payflow, $sys_show_discprice, $sys_cust_fname;
	global $sys_cust_lname, $sys_cust_fullname, $sys_cust_email, $sys_txn_id, $sys_item_imgfile, $instrow;
	
	$g_useGlobal = false;
	
	//lookup options 
	$sql="select * from g_themeOptions where productid='" . $productID . "' AND timeType='999'";
	$flnm=mysql_query($sql);
	if (mysql_num_rows($flnm) > 0) {
		$frow=mysql_fetch_array($flnm);
		if ($frow['status'] == '999') {
			$g_useGlobal = true;
		} else {
			$g_templateName = $frow['template'];
		}
	} else
		$g_useGlobal = true;
		
	//if we are to use the global settings, look them up and replace the product settings
	if ($g_useGlobal) {
		$sql="select * from g_themeOptions where productid='0' AND timeType='999'";
		$flnm=mysql_query($sql);
		if (mysql_num_rows($flnm) > 0) {
			$frow=mysql_fetch_array($flnm);
			$g_templateName = $frow['template'];
		}
	}
	
	//adjust for time difference
	
	$g_dt = "";
	$g_dttm = "";
	
	$sql="select * from g_themeOptions where productid='0' AND timeType='998'";
	$tars=mysql_query($sql);
	if (mysql_num_rows($tars) > 0) {
		$tarow=mysql_fetch_array($tars);
		$g_timadj = $tarow['options'];
		if (trim($g_timadj) <> "") {
			$g_dt = date("Hi", strtotime($g_timadj . " hours"));
			$g_dttm = date("YmdHi", strtotime($g_timadj . " hours"));
		}
	}
	
	if ($g_dt == "") {
		$g_dt = date("Hi");
		$g_dttm = date("YmdHi");
	}
	
	//by this point we have the actual settings in $frow no matter if they are product or global
	if ($frow['status'] != '0') {
		//It is not static so we need to lookup active template based on the type
		
		//check for daily type first
		if ($frow['status'] == '1') {
			$sql2="select * from g_themeOptions where productid='" . $frow['productid'] . "' AND timeType='1' AND status > '0' order by time";
			$gdetrs=mysql_query($sql2);
			//loop until we find the first time that is in front of us.  The last one we passed is active then.  If we pass none, then the one marked active is active
			while ($gdetrow=mysql_fetch_array($gdetrs)) {
				if ($gdetrow['time'] <= $g_dt) {
					//time is less than or equal current time
					$g_lastTemplate = $gdetrow['template'];
					$g_lastUID = $gdetrow['uid'];
				} else {
					//time must be greater than so use the last less than time we passed
					if ($g_lastTemplate == "") {
						//this is the first record so we need to lookup the last active and use that template
					} else {
						$g_newTemplate = $g_lastTemplate;
					}
				}
			}
			//consider the possibility that there was not a template for a later time and this template is good till midnight
			if ( $g_newTemplate == "" && $g_lastTemplate != "")
				$g_newTemplate = $g_lastTemplate;
				
			//update active record
			if ( $g_newTemplate != "") {
				//clear the active record first
				$sql3="update g_themeOptions set status='1' where productid='" . $frow['productid'] . "' AND status='2'";
				$gupdtrs=mysql_query($sql3);
				
				//set new active record
				$sql3="update g_themeOptions set status='2' where uid='" . $g_lastUID . "'";
				$gupdtrs=mysql_query($sql3);
				
			}
			
			//consider the possibility that the time for the first entry has not been reached yet.  If that is the case, use the last active entry
			if ((mysql_num_rows($gdetrs) > 0) && $g_newTemplate == "") {
				//we now know that there are entries, so lookup the active one
				$sql2="select * from g_themeOptions where productid='" . $frow['productid'] . "' AND timeType='1' AND status = '2'";
				$gdetrs=mysql_query($sql2);
				$gdetrow=mysql_fetch_array($gdetrs);
				$g_newTemplate = $gdetrow['template'];
			}
			
			//consider the possibility that there is no entries but the type is set to time.  If so, use the default set
			if ( $g_newTemplate != "")
				$g_templateName = $g_newTemplate;
		}
		
		//check for date type first
		if ($frow['status'] == '2') {
		$sql2="select * from g_themeOptions where productid='" . $frow['productid'] . "' AND timeType='2' AND status > '0' order by time";
			$gdetrs=mysql_query($sql2);
			//loop until we find the first time that is in front of us.  The last one we passed is active then.  If we pass none, then the one marked active is active
			while ($gdetrow=mysql_fetch_array($gdetrs)) {
				if ($gdetrow['time'] <= $g_dttm) {
					//time is less than or equal current time
					$g_lastTemplate = $gdetrow['template'];
					$g_lastUID = $gdetrow['uid'];
				} else {
					//time must be greater than so use the last less than time we passed
					if ($g_lastTemplate == "") {
						//this is the first record so we need to lookup the last active and use that template
					} else {
						$g_newTemplate = $g_lastTemplate;
					}
				}
			}
			//consider the possibility that there was not a template for a later time and the last template was the last one
			if ( $g_newTemplate == "" && $g_lastTemplate != "")
				$g_newTemplate = $g_lastTemplate;
				
			//update active record
			if ( $g_newTemplate != "") {
				//clear the active record first
				$sql3="update g_themeOptions set status='1' where productid='" . $frow['productid'] . "' AND status='2';";
				//echo $sql3 . "<br>";
				$gupdtrs=mysql_query($sql3);
				
				//set new active record
				$sql3="update g_themeOptions set status='2' where uid='" . $g_lastUID . "';";
				//echo $sql3 . "<br>";
				$gupdtrs=mysql_query($sql3);
				
			}
			
			//consider the possibility that there is no entries but the type is set to date.  If so, use the default set
			if ( $g_newTemplate != "")
				$g_templateName = $g_newTemplate;
		}
	}
	
	//look backward until we find the rap admin folder, then prepend the previous directories to the path for the templates folder
	$emcnt = 0;
	$prpnd = "";
	do
	{
		if (!file_exists($prpnd . "rap_admin"))
			$prpnd .= "../";
			
	} while (!file_exists($prpnd . "rap_admin") || ++$emcnt < 9);
	
	//before we load up the template, check to see if this is a download, oto or otodownload, and if there is an override
	
	
	if ( ( strpos($filename, "taf.html") > 0 || strpos($filename, "download.html")  > 0 ) && trim($g_gsfo[0]) != "")
		$g_templateName = trim($g_gsfo[0]);
	
	if ( strpos($filename,"oto.html") > 0 && trim($g_gsfo[1]) != "")
		$g_templateName = trim($g_gsfo[1]);
		
	if ( ( strpos($filename, "ototaf.html") > 0 || strpos($filename, "otodownload.html") > 0 ) && trim($g_gsfo[0]) != "")
		$g_templateName = trim($g_gsfo[2]);
	
	if ($g_file == "header" || $g_file == "footer") {
		$g_template_file = $prpnd . "rap_admin/addons/GIS/themes/themes/" . $g_templateName . "/index.html";

		$g_filecontents = file_get_contents($g_template_file);
		
		if ($g_file == "header") {
			$g_filecontents = substr($g_filecontents,0,strpos($g_filecontents,"[[HEADER-END]]"));
		} else {
			$g_filecontents = substr($g_filecontents,strpos($g_filecontents,"[[FOOTER-START]]") + 16);
		}
	} else {
		$g_template_file = $prpnd . "rap_admin/addons/GIS/themes/themes/" . $g_templateName . "/" . $g_file;

		$g_filecontents = file_get_contents($g_template_file);
	} 
		
	$g_filecontents = str_replace("images/", "/rap_admin/addons/GIS/themes/themes/" . $g_templateName . "/images/", $g_filecontents);
	
	$cont = eval('?>' . $g_filecontents . '<?');

	echo $cont;
	
}