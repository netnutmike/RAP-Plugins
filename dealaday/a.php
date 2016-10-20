<?
//==============================================================================================
//
//	Filename:	delete_addToCart.php
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
//	Description:	This file is called when the user wants to delete a add-to-cart entry 
//
//	Version:	1.0.0 (April 28th, 2009)
//
//	Change Log:
//				04/28/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); 


	
//Load Add To Cart Image
function LoadPNG($imgname){
	
	// Set Globals
	global $sys_item_price, $productID;
	
	$soldout=false;
	
    // Read atc info based on atc id passed
    //if ($_REQUEST['atc'] == "")
    //	return;
    	
    $sql="select * from g_addToCart where uid='" . $_REQUEST['atc'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
	
	//update the view count for the add-to-cart item
	$sqlu="update g_addToCart set ViewCount = '" . ($grow['ViewCount'] + 1) . "' where uid='" . $_REQUEST['atc'] . "'";
	$upd=mysql_query($sqlu);
	
	$tmplate = $grow['template'];
	$soldoutmplate = $grow['souldoutTemplate'];
	
	if (trim($tmplate) == "")
		$tmplate = "button-default.png";
		
	if (trim($soldoutmplate) == "")
		$soldoutmplate = "soldout.png";
	
	if (trim($grow['regularPrice']) == "") {
		//lookup product for the price in the DB
		
		$sql="select * from products where id='" . $grow['productid'] . "'";
		//echo $sql;
		$prid=mysql_query($sql);
		$prow = mysql_fetch_array($prid);
		
		$itemprice = $prow['item_price'];
	} else 
		$itemprice = trim($grow['regularPrice']);

	//check the date first, if it is past the date there is no reason to loop through the bumps cuz it's over
	if (trim($grow['endDate']) != "") {
		if (strlen($grow['endDate']) == 9) 
			$dtstr = "0" . $grow['endDate'];
		else
			$dtstr = $grow['endDate'];
		
		
		//verify the date is properly formatted
		if ( (substr($dtstr,2,1) == "-" || substr($dtstr,2,1) == "/") && (substr($dtstr,5,1) == "-" || substr($dtstr,5,1) == "/") ) {
			$fmtdate = substr($dtstr,6,4) . substr($dtstr,0,2) . substr($dtstr,3,2);
			if ( $fmtdate <= date("Ymd")) {
				$soldout = true;
			}
		}
	}
		
	$maxsales = 0;
	
	if (!$soldout) {
		//Loop through the bumps (there has to be at least one) to see what the maxsales is
	
		$sqlbump="select * from g_addToCartBumps where buttonID='" . $grow['uid'] . "' and status='1' order by Copies";
		$gidbump=mysql_query($sqlbump);
		$todayprice = "";
		while ($growbump = mysql_fetch_array($gidbump)) {
			if ($growbump['Copies'] > $grow['CopiesPurchased']) {
				if ($todayprice == "") {
					$todayprice = $growbump['todaysPrice'];
					$maxsales = $growbump['Copies'];
					
					//update the view count for the bump item
					$sqlu="update g_addToCartBumps set ViewCount = '" . ($growbump['ViewCount'] + 1) . "' where uid='" . $growbump['uid'] . "'";
					$upd=mysql_query($sqlu);
				}
			} else {
				$prevmaxsales = $growbump['Copies'];
			}
		}
	}
	
	if ($todayprice == "")
		$soldout = true;
		
	//$maxsales = $growbump['Copies'];
	
	//Removes ".00" in item_price
	if (strpos($itemprice, ".00") !== false)
		$regularprice = substr($itemprice, 0, -3);
	else
		$regularprice = $itemprice;
	
	if ($soldout) {
		if ($grow['endAction'] == '1') {
			/* Attempt to open */
    		$im = @imagecreatefrompng('templates/' . $soldoutmplate);
		} else {
		
			/* Attempt to open */
    		$im = @imagecreatefrompng('templates/' . $tmplate);
    

			//	Add colors to text
			$textcolor = imagecolorallocate($im, 33, 29, 132);
	
			//Selling price text
			$text = "Get It Today For Only $" . $regularprice;
	
			// Text font path
			$font = 'arial.ttf';

			$bbox = imagettfbbox(20, 0, $font, $text);
			$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
			
			// Adding the text 
			imagettftext($im, 20, 0, $x, 35, $textcolor, $font, $text);
	
		}
	
	} else {
	

	 	/* Attempt to open */
    	$im = @imagecreatefrompng('templates/' . $tmplate);
    
		// "Copies Left" = "Max Sales" - "Sales Made"
		$copiesleft = $maxsales - ($grow['CopiesPurchased']);
	
		//	Add colors to text
		$textcolor = imagecolorallocate($im, 33, 29, 132);
		$textcolor2 = imagecolorallocate($im, 33, 29, 132);
		$linecolor = imagecolorallocate($im, 255, 29, 132);
	
		//Selling price text
		$text = "Regular Price $" . $regularprice . " Today $" . $todayprice;
		
		if (trim($grow['CopiesLeftText']) == "")
			$text2 = "Only " . $copiesleft . " Copies Left";
		else {
			$text2 = str_replace("[COPIES]", $copiesleft, $grow['CopiesLeftText']);
		}
	
		// Text font path
		$font = 'arial.ttf';
		
		// Starting Font Size + 1
		$fontsize = 21;

		// First we create our bounding box for the first text
		do {
			$fontsize = $fontsize - 1;
			$bbox = imagettfbbox($fontsize, 0, $font, $text);			
		} while ($bbox[4] >= ( imagesx($im) - 20) );
		
		// This is our cordinates for X and Y
		$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
		
		$text = "Regular Price $";
		$bbox = imagettfbbox($fontsize, 0, $font, $text);
		imagettftext($im, $fontsize, 0, $x, 35, $textcolor, $font, $text);
		
		$x = $x + $bbox[4];
		$text = $regularprice;
		$bbox = imagettfbbox($fontsize, 0, $font, $text);
		imagettftext($im, $fontsize, 0, $x, 35, $textcolor, $font, $text);
		
		//draw the line through what we just drew
		//Position of strike through
		$x1 = $x-7;
		$y1 = '34';
		$x2 = $x + $bbox[4] + 2;
		$y2 = '18';
		
		imagesetthickness($im, 3);
		imageline($im, $x1, $y1, $x2, $y2, $linecolor);
		
		//add rest of the text
		$x = $x + $bbox[4];
		$text = " Today $" . $todayprice;
		//$bbox = imagettfbbox($fontsize, 0, $font, $text);
		imagettftext($im, $fontsize, 0, $x, 35, $textcolor, $font, $text);
		
		
		// Starting Font Size + 1
		$fontsize = 15;

		// First we create our bounding box for the first text
		do {
			$fontsize = $fontsize - 1;
			$bbox = imagettfbbox($fontsize, 0, $font, $text2);			
		} while ($bbox[4] >= ( imagesx($im) - 20) );
		
		// This is our cordinates for X and Y
		$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
		imagettftext($im, $fontsize, 0, $x, 155, $textcolor2, $font, $text2);

	    /* See if it failed */
    	if(!$im)
    	{
        	/* Add Error Code Here */
    	}
	}

    return $im;
	
}


header('Content-Type: image/png'); 

//$img = LoadPNG('addons/GIS/addtocart/templates/AddToCart.png');
$img = LoadPNG('AddToCart.png');

imagepng($img);
imagedestroy($img);
?>