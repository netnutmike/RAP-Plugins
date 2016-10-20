<?php
	
	//Load Add To Cart Image
	function LoadPNG($imgname)
	{
    /* Attempt to open */
    $im = @imagecreatefrompng($imgname);
	
	// Get Database details
	include("/home/adinsert/public_html/rap_admin/config.php");

	// Connects to Database 
	mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error()); 
	mysql_select_db($dbname) or die(mysql_error()); 

	// Collects data from MySQL "Products" table 
 	$data = mysql_query("SELECT * FROM products") 
 	or die(mysql_error()); 
	
 	$info = mysql_fetch_array( $data );
	  
 	$itemprice = $info['item_price'];
	$maxsales = $info['max_sales'];
	
	//Removes ".00" in item_price
	$regularprice = substr($itemprice, 0, -3);
	
	// Gets Total (Front-End) Sales (Front end sales only).
	
	$data2 = mysql_query('SELECT COUNT(`item_number`) AS num FROM `sales`') or die(mysql_error());

	// The COUNT query will always return 1 row
	$row = mysql_fetch_assoc($data2);

	// Get the number of uses from the array
	// 'num' is what we aliased the column as above
	$salesmade = $row['num'];
	
	// "Copies Left" = "Max Sales" - "Sales Made"
	$copiesleft = $maxsales - $salesmade;
	
	// Get variables from xml?
	if (file_exists('details.xml')) {
    $xml = simplexml_load_file('details.xml');
 
		$todprice = $xml->todayprice;
		
			} else {
    			exit('Failed to open details.xml.');
		}
	
	//Add colors to text
	$textcolor = imagecolorallocate($im, 33, 29, 132);
	$textcolor2 = imagecolorallocate($im, 33, 29, 132);
	
	//Selling price text
	$text = "Regular Price $" . $regularprice . " Today " . $todprice;
	$text2 = "Only " . $copiesleft . " Copies Left";
	
	// Text font path
	$font = 'arial.ttf';

	// Adding the text with strikethroughs
	imagettftext($im, 20, 0, 28, 35, $textcolor, $font, $text);
	imagettftext($im, 14, 0, 112, 155, $textcolor2, $font, $text2);
	
	//Position of strike through
	$x1 = '210';
	$y1 = '25';
	$x2 = '241';
	$y2 = '25';
	
	imagesetthickness($im, 2);
	imageline($im, $x1, $y1, $x2, $y2, $textcolor);

    /* See if it failed */
    if(!$im)
    {
        /* Add Error Code Here */
    }

    return $im;
}


header('Content-Type: image/png');

$img = LoadPNG('AddToCart.png');

imagepng($img);
imagedestroy($img);
?>