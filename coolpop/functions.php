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
//	Version:	1.0.0 (July 29th, 2010)
//
//	Change Log:
//				07/29/10 - Initial Version (JMM)
//
//==============================================================================================


function g_CoolPop() {

	//this function outputs the divs and java script for the cool pop popover.
	
	//Read the config record for this product
	session_start();

	$productID=$_SESSION[product];
	
	//check to see if there are specific options for the product first
	$query = "SELECT * FROM g_CoolPop WHERE productID = '" . $productID . "'"; 
	$result = mysql_query($query);
	$rows = mysql_num_rows($result);
	if ($rows > 0)
	{
		$grow=mysql_fetch_array($result);
		if ($grow['Status'] == '1') {
			switch ($grow['popOverType']) {
  				case 's':
  					@include("draw_candybar.php");
  					break;
  				case 'e':
  					@include("draw_exitramp.php");
  					break;
  				case 'p':
  					@include("draw_exitlane.php");
  					break;
  				default:
  					@include("draw_coolpop.php");
  					break;
			}
		}
	}
  }
 ?>