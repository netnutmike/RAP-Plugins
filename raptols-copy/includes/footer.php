<?
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright (c) 2009, 2010 Genius Idea Studio, LLC. All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Genius Idea Studio, LLC.
| regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script and hold harmless from any harm or damage
| Genius Idea Studio, LLC.   
|
| ================================================================
| rap-tools.com Rap Tools add-on
| ================================================================
+--------------------------------------------------------------------------

Log Information:
Date, Time, Action, Product, Affiliate, Discount Code, header, footer, file
*/

session_start();


// Check to see if debugging is turned on and if so, call the debug log
	$g_loggingOptions = gGetOptionChar("DebugLogging");
	if (substr($g_loggingOptions, 0, 1) == '1') {
		gis_log_debug_info(substr($g_loggingOptions, 1, 1), substr($g_loggingOptions, 2, 1), substr($g_loggingOptions, 3, 1), substr($g_loggingOptions, 4, 1));		
	}
	
		
	
	?>
	
	