<? 	
	
	function renderChartHTML($chartType, $strXML, $ChartID, $width, $height) {
 	
 		$flshpath = "addons/GIS/raptracker/charts/FCF_" . $chartType . ".swf";
 		
 		$htmlcode = " 
 		<OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"" . $width . "\" height=\"" . $height . "\" id=\"" . $ChartID . "\" >
         	<param name=\"movie\" value=\"" . $flshpath . "\" />
         	<param name=\"FlashVars\" value=\"&chartWidth=" . $width . "&chartHeight=" . $height . "&dataXML=" . $strXML . "\">
         	<param name=\"quality\" value=\"high\" />
         	<embed src=\"" . $flshpath . "\" flashVars=\"&chartWidth=" . $width . "&chartHeight=" . $height . "&dataXML=" . $strXML . "\" quality=\"high\" width=\"" . $width . "\" height=\"" . $height . "\" name=\"Column3D\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />
      	</object><br><br>";

 		return $htmlcode;
 	}
 	
 	function renderChartHTMLFullPath($chartType, $strXML, $ChartID, $width, $height) {
 	
 		$flshpath = "/rap_admin/addons/GIS/raptracker/charts/FCF_" . $chartType . ".swf";
 		
 		$htmlcode = " 
 		<OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"" . $width . "\" height=\"" . $height . "\" id=\"" . $ChartID . "\" >
         	<param name=\"movie\" value=\"" . $flshpath . "\" />
         	<param name=\"FlashVars\" value=\"&chartWidth=" . $width . "&chartHeight=" . $height . "&dataXML=" . $strXML . "\">
         	<param name=\"quality\" value=\"high\" />
         	<embed src=\"" . $flshpath . "\" flashVars=\"&chartWidth=" . $width . "&chartHeight=" . $height . "&dataXML=" . $strXML . "\" quality=\"high\" width=\"" . $width . "\" height=\"" . $height . "\" name=\"Column3D\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />
      	</object><br><br>";

 		return $htmlcode;
 	}
 	
 	
 	function DayOfWeek( $daynum ) {
 	
 		switch ($daynum) {
 			case 1:
 				$daytext = "Mon";
 				break;
 				
 			case 2:
 				$daytext = "Tue";
 				break;

 			case 3:
 				$daytext = "Wed";
 				break;
 				
 			case 4:
 				$daytext = "Thu";
 				break;
 				
 			case 5:
 				$daytext = "Fri";
 				break;
 			
 			case 6:
 				$daytext = "Sat";
 				break;
 			
 			case 7:
 				$daytext = "Sun";
 				break;
  				
 		}
 		
 		return $daytext;
 	}
	
	function GetDisposition( $disposition ) {
 	
 		switch ($disposition) {
 			case 1:
 				$distext = "Download";
 				break;

 			case 2:
 				$distext = "OTODownload";
 				break;
 				
 			case 3:
 				$distext = "Squeeze";
 				break;
 				
 			case 0:
			default:
 				$distext = "No Action";
 				break;
 		}
 		
 		return $distext;
 	}
	
	function StripURL($URL) {
		//strip off http and https
		
		if (strpos($URL, "https://") !== false )
			$URL = substr($URL,8);
			
		if (strpos($URL, "http://") !== false )
			$URL = substr($URL,7);
		
		$endpos	= strpos($URL, ".", strrpos($URL, "/")) + 4;
		
		$URL = substr($URL,0,$endpos);
		
		return $URL;
	} 	
	
	function DateSplit( $dtvar) {
		return substr($dtvar,4,2) . "/" . substr($dtvar,6,2);
	}
	
	function GetProduct($pid) {
		$sql = "select * from products where id='" . $pid . "'";
		$gid = mysql_query($sql);
		$gir = mysql_fetch_array($gid);
		$prodname = $gir['item_name'];
		if ($prodname == "")
			$prodname = "Invalid Product";
		return $prodname;
	}
	


	global $sys_install_folder, $sys_domain;
			
	# set tracking cookie so we know if this machine has been here before.  Better than tracking just IP because of NAT and of laptops being taken home at night
	setcookie("gis_PrevVisit", "1", time()+(60*60*24), $sys_install_folder, "." . $sys_domain);


	?>