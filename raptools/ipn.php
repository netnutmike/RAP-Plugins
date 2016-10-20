<?php
//==============================================================================================
//
//	Filename:	ipn.php
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
//	Description:	This file is called when someone makes a purchase.  It does the email send
// 					and updates the sales count if setup in the product countdown option 
//
//	Version:	1.0.0 (February 5th, 2009)
//
//	Change Log:
//				02/05/10 - Initial Version (JMM)
//
//==============================================================================================

include "functions.php";

function ReplaceTokens($Incoming, $values) {

	$TierDescription = Array("Site Owner", "Affiliate", "Affiliate Sponsor");
	$TierName = Array("Tier 0", "Tier 1", "Tier 2");
	$TransType = Array("Sale", "Refund");
	$ProductType = Array("Product", "OTO");
	
	//build array of tokens to replace
	$gTokenArray = array('[PRODUCT_OTO]', '[AFFPCT]', '[AFFPCT2]', '[JVPCT]', '[JVPCT2]', '[STATUS]',
							'[TRANSTYPE]', '[BUYER_FNAME]', '[BUYER_LNAME]', '[BUYER_FULLNAME]', 
							'[BUYER_EMAIL]', '[TIER]', '[TIER_DESC]', '[ITEM_NUM]', '[ITEM_NAME]',
							'[PROD_ID]', '[SUPPORT]', '[AFF_PAYPAL]', '[AFF_FNAME]', '[AFF_LNAME]', '[AFF_NICK]',
							'[AFF_FULLNAME]', '[AFF_EMAIL]', '[SPO_PAYPAL]', '[SPO_FNAME]', '[SPO_LNAME]',
							'[SPO_FULLNAME]', '[SPO_EMAIL]', '[SPO_NICK]', '[RECEIVER_EMAIL]' );
	$gTokenValues = array( $ProductType[$values['productType']-1], $values['affPercent'], $values['affPercent2'], $values['jvPercent'], $values['jvPercent2'], $values['Status'],
	 	$TransType[$values['transType']-1], $values['FirstName'], $values['LastName'], $values['FullName'],
	 	$values['PayerEmail'], $TierName[$values['Tier']], $TierDescription[$values['Tier']], $values['ItemNumber'], $values['ItemName'],
	 	$values['ProductID'], $values['SystemSupport'], $values['AffiliatePaypal'], $values['AffiliateFirstName'], $values['AffiliateLastName'], $values['AffiliateNickName'],
	 	$values['AffiliateFullName'], $values['AffiliateEmail'], $values['SponsorPaypal'], $values['SponsorFirstName'], $values['SponsorLastName'],
	 	$values['SponsorFullName'], $values['SponsorEmail'], $values['SponsorNickName'], $values['ReceiverEmail']);
	
	$gNewText = str_replace( $gTokenArray, $gTokenValues, $Incoming);
	
	return $gNewText;
}

function gIPN()
{
	global $sys_adminmail, $prow, $eaddress, $tier, $payment_status, $payment_amount, $affiliate, $eaddress;
	global $payer_email, $receiver_email, $firstname, $lastname, $fullname, $subscr_id_flag, $item_number;
	global $productID, $item_name, $sys_glbaff, $sys_support, $sys_item_name;
	global $sys_item_number, $sys_item_price, $sys_oto_number, $sys_oto_price;
	
	//determine if the purchase was a product or OTO purchase and set values in the array for later
	$gInfo["productType"] 		= ( $item_number == $sys_item_number ) ? 1 : 2;
	$gInfo["affPercent"] 		= ( $item_number == $sys_item_number ) ? $prow['item_pct'] : $prow['oto_pct'];
	$gInfo["affPercent2"] 		= ( $item_number == $sys_item_number ) ? $prow['item_pct2'] : $prow['oto_pct2'];
	$gInfo["jvPercent"] 		= ( $item_number == $sys_item_number ) ? $prow['jv_item_pct'] : $prow['jv_oto_pct'];
	$gInfo["jvPercent2"] 		= ( $item_number == $sys_item_number ) ? $prow['jv_item_pct2'] : $prow['jv_oto_pct2'];
	$gInfo["equityPaypal1"] 	= $prow['eq1_paypal'];
	$gInfo["equityPercent1"] 	= $prow['eq1_pct'];
	$gInfo["equityPaypal2"] 	= $prow['eq2_paypal'];
	$gInfo["equityPercent2"] 	= $prow['eq2_pct'];
	$gInfo["transType"] 		= ( $payment_status == "Refunded" ) ? 2 : 1;		//1 = sale,  2 = refund
	$gInfo["FirstName"]			= $firstname;
	$gInfo["LastName"]			= $lastname;
	$gInfo["FullName"]			= $fullname;
	$gInfo["PayerEmail"]		= $payer_email;
	$gInfo["Tier"]				= $tier;
	$gInfo["ReceiverEmail"]		= $receiver_email;
	$gInfo["ItemNumber"]		= $item_number;
	$gInfo["ItemName"]			= $item_name;
	$gInfo["ProductID"]			= $productID;
	$gInfo["SystemSupport"]		= $sys_support;
	$gInfo['Status']			= $payment_status;
	
	$gInfo["emailNotify"] 		= gGetOptionInt("EmailNotify", '0', '0');
	
	if ($gInfo["emailNotify"] == 1 ) {
		$gInfo["siteOwnerNotify"] 	= gGetOptionInt("EmailNotifyOwner", '0', '1');
		$gInfo["affiliateNotify"] 	= gGetOptionInt("EmailNotifyAffiliate", '0', '1');
		$gInfo["jvNotify"] 			= gGetOptionInt("EmailNotifyJV", '0', '1');
		$gInfo["epNotify"] 			= gGetOptionInt("EmailNotifyEP", '0', '1');

		if ($gInfo["siteOwnerNotify"] == 1 ) {
			$gInfo["siteOwnerNotifyEverySale"] 	= gGetOptionInt("EmailNotifyOwnerEverySale", '0', '1');
			$gInfo["siteOwnerNotifyRefund"] 	= gGetOptionInt("EmailNotifyOwnerRefund", '0', '1');
		}
		
		if ($gInfo["affiliateNotify"] == 1 ) {
			$gInfo["affiliateNotifyEverySale"] 	= gGetOptionInt("EmailNotifyAffiliateEverySale", '0', '1');
			$gInfo["affiliateNotifyTier2Sale"] 	= gGetOptionInt("EmailNotifyAffiliateTier2Sale", '0', '1');
			$gInfo["affiliateNotifyRefund"] 	= gGetOptionInt("EmailNotifyAffiliateRefund", '0', '1');
		}
		
		if ($gInfo["jvNotify"] == 1 ) {
			$gInfo["jvNotifyEverySale"] 		= gGetOptionInt("EmailNotifyJVEverySale", '0', '1');
			$gInfo["jvNotifyTier2Sale"] 		= gGetOptionInt("EmailNotifyJVTier2Sale", '0', '1');
			$gInfo["jvNotifyRefund"] 			= gGetOptionInt("EmailNotifyJVRefund", '0', '1');
		}		
		
		if ($gInfo["epNotify"] == 1 ) {
			$gInfo["epNotifyEverySale"] 		= gGetOptionInt("EmailNotifyEPEverySale", '0', '1');
			$gInfo["epNotifyRefund"] 			= gGetOptionInt("EmailNotifyEPRefund", '0', '1');
		}
	}
	
	
	if ($gInfo["emailNotify"] == '1') {

		if( !$subscr_id_flag && (($payment_status == "Completed" && ( ($item_number == $sys_item_number && $payment_amount >= $sys_item_price) || ($item_number == $sys_oto_number && $payment_amount >= $sys_oto_price))) || $payment_status == "Refunded") )
		{
		
			//check to see if there is an affilate to the order
			if( !empty($affiliate) && strtolower($receiver_email) != strtolower($affiliate) )
			{		
			
				//check to see if the gobal affiliates is enabled.  If it is not we have to make sure that we only lookup affilaite for the product purchased
				if( !$sys_glbaff )
					$gprodSQL = " AND productID = $productID";
				else
					$gprodSQL = "";
				
				// lookup affiliate, check if they are a JV and also see if they have a sponser for a tier 2 notification
				$gnickSQL = "SELECT * from nicknames WHERE email = '" . $affiliate. "'" . $gprodSQL;
			
				
				$gnickRS = mysql_query( $gnickSQL );
				if( mysql_num_rows($gnickRS) > 0 )
				{
					$gnickRow 	= mysql_fetch_array( $gnickRS );
					$gsponsor 	= $gnickRow['sponsor'];
					$gInfo["AffiliatePaypal"] = $affiliate;
					$gInfo["AffiliateFirstName"] = $gnickRow['firstname'];
					$gInfo["AffiliateLastName"] = $gnickRow['lastname'];
					$gInfo["AffiliateNickName"] = $gnickRow['nickname'];
					$gInfo["AffiliateFullName"] = $gnickRow['firstname'] . " " . $gnickRow['lastname'];

					//override the affiliate email with the preferred email vs the paypal email
					if( !empty($gnickRow['pref_email']) )
						$affiliate = $gnickRow['pref_email'];
						
					$gInfo["AffiliateEmail"] = $affiliate;
				}
				
			
				//if there is a sponsor look them up so we can use it later when we wend tier 2 emails
				if( !empty($gnickRow['sponsor']) )
				{
					
					if( !$sys_glbaff )
						$gprodSQL = " AND productID = $productID";
					else
						$gprodSQL = "";
					
					// determine if sponsor is registered and active, get thier preferred email
					$gsponsorSQL = "SELECT * from nicknames WHERE email = '" . $gnickRow['sponsor']. "'" . $gprodSQL;
				
					$gsponsorRS = mysql_query( $gsponsorSQL );			
					if( mysql_num_rows($gsponsorRS) > 0 )
					{
						$gsponsorRow = mysql_fetch_array( $g_res );
						$gInfo["SponsorPaypal"] = $gsponsorRow['email'];
						$gInfo["SponsorFirstName"] = $gsponsorRow['firstname'];
						$gInfo["SponsorLastName"] = $gsponsorRow['lastname'];
						$gInfo["SponsorNickName"] = $gsponsorRow['nickname'];
						$gInfo["SponsorFullName"] = $gsponsorRow['firstname'] . " " . $gsponsorRow['lastname'];
						// If the sponsor has a preferred email replace the paypal email address with the preferred email address
						if( !empty($gsponsorRow['pref_email']) )
							$gsponsor = $gsponsorRow['pref_email'];
							
						$gInfo["SponsorEmail"] = $affiliate;

					}
				}
			}
			
		
			if ($gInfo["siteOwnerNotify"] == 1 ) {
			
				//check to see if the site owner(s) got paid or the option is set to get all sales					
				if ($tier == '0' || $gInfo["siteOwnerNotifyEverySale"] == '1') {
				
					//determine if this is a sales or refund
					if ($payment_status == "Completed") {
						$gsubject = "New Sale Notice for " . $item_name;
						$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyOwnerEverySaleText", '0', ''), $gInfo);
						@mail( $sys_adminmail, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
					} else {
						//must be refunded
						if ($gInfo["siteOwnerNotifyRefund"] == 1 ) {
							$gsubject = "Refund Notice for " . $item_name;
							$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyOwnerRefundText", '0', ''), $gInfo);
							@mail( $sys_adminmail, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
						}						
					}
				}
			}
				
				
			if ($gInfo["affiliateNotify"] == 1 ) {
			
				//check to see if the affiliate got paid or the option is set to get all sales
				if ($tier == '1' || $gInfo["affiliateNotifyEverySale"] == '1') {
				
					//determine if this is a sales or refund
					if ($payment_status == "Completed") {
						$gsubject = "New Sale Notice for " . $item_name;
						$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyAffiliateEverySaleText", '0', ''), $gInfo);
						@mail( $affiliate, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
							
						if ( $gInfo["affiliateNotifyTier2Sale"] == '1' && trim($gsponsor) <> "") {
							$gsubject = "New Sale Notice for " . $item_name;
							$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyAffiliateEverySaleText", '0', ''), $gInfo);
							@mail( $gsponsor, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
						}
					} else {
						//must be refunded
						if ($gInfo["affiliateNotifyRefund"] == '1' ) {
							$gsubject = "Refund Notice for " . $item_name;
							$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyAffiliateRefundText", '0', ''), $gInfo);
							@mail( $affiliate, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
						}
							
						if ( $gInfo["affiliateNotifyTier2Sale"] == '1' && trim($gsponsor) <> "") {
							$gsubject = "Refund Notice for " . $item_name;
							$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyAffiliateRefundText", '0', ''), $gInfo);
							@mail( $gsponsor, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
						}
					}
				}
			}
				
				
			if ($gInfo["jvNotify"] == 1 ) {
				//check to see if the affiliate got paid or the option is set to get all sales
				if ($tier == '1' || $gInfo["jvNotifyEverySale"] == '1') {
					//determine if this is a sales or refund
					if ($payment_status == "Completed") {
						$gsubject = "New Sale Notice for " . $item_name;
						$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyJVEverySaleText", '0', ''), $gInfo);
						@mail( $affiliate, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
							
						if ( $gInfo["jvNotifyTier2Sale"] == '1' && trim($gsponsor) <> "") {
							$gsubject = "New Sale Notice for " . $item_name;
							$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyJVEverySaleText", '0', ''), $gInfo);
							@mail( $gsponsor, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
						}
					} else {
						//must be refunded
						if ($gInfo["jvNotifyRefund"] == '1' ) {
							$gsubject = "Refund Notice for " . $item_name;
							$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyJVRefundText", '0', ''), $gInfo);
							@mail( $affiliate, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
						}
							
						if ( $gInfo["jvNotifyTier2Sale"] == '1' && trim($gsponsor) <> "") {
							$gsubject = "Refund Notice for " . $item_name;
							$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyJVRefundText", '0', ''), $gInfo);
							@mail( $gsponsor, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
						}
					}
				}
			}
				
			if ($gInfo["epNotify"] == 1 ) {
				//check to see if the site owner(s) got paid or the option is set to get all sales
				if ($tier == '0' || $gInfo["epNotifyEverySale"] == '1') {
					//determine if this is a sales or refund
					if ($payment_status == "Completed") {
						$gsubject = "New Sale Notice for " . $item_name;
						$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyOwnerEverySaleText", '0', ''), $gInfo);
						@mail( $sys_adminmail, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
							
						if (strpos(trim($prow['eq1_paypal']),"@") !==false) 
							@mail( trim($prow['eq1_paypal']), $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
								
						if (strpos(trim($prow['eq2_paypal']),"@") !==false) 
							@mail( trim($prow['eq2_paypal']), $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
								
					} else {
						//must be refunded
						if ($gInfo["epNotifyRefund"] == 1 ) {
							$gsubject = "Refund Notice for " . $item_name;
							$gmessage = ReplaceTokens(gGetOptionChar("EmailNotifyOwnerRefundText", '0', ''), $gInfo);
							@mail( $sys_adminmail, $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
								
							if (strpos(trim($prow['eq1_paypal']),"@") !==false) 
								@mail( trim($prow['eq1_paypal']), $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );
								
							if (strpos(trim($prow['eq2_paypal']),"@") !==false) 
								@mail( trim($prow['eq2_paypal']), $gsubject, $gmessage, "From: $sys_item_name <$eaddress>\r\nReply-To: $eaddress\r\nX-Mailer: PHP" . phpversion() );	
						}
					}
				}
			}
							
		}
	}
}

gIPN();
?>