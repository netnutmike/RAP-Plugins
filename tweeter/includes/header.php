<?
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright 2009, 2010 Genius Idea Studio, LLC,  All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Genius Idea
| Studio, LLC regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.   
|
| ================================================================
| rap-tools.com Testimonials add-on
| ================================================================
+---------------------------------------------------------------------
*/

session_start();

	$productID=$_SESSION[product];
	
	
function gAllTestimonials() {
	global $productID;
	
	echo "index.php?action=a&fn=GIS/testimonials/view_all_testimonials&pid=" . $productID;
}

function gAddTestimonial() {
	global $productID;
	
	echo "index.php?action=a&fn=GIS/testimonials/add_new_testimonial&pid=" . $productID;
}
	
function gTestimonial($g_section = "", $g_options = "") {

	global $productID;
	
	//set default values for options
	$g_order = 0;		//0 = circle, 1 = random
	$g_template = "";	//if not set in options variable, the setting for this product will be used
	
	//set option variables based upon what options we passed
	
	$g_options = " " . $g_options . " ";
	
	if (strpos($g_options, "%RANDOM-ORDER") > 0) {
		$g_order = 1;	
	}

	if (strpos($g_options, "%TEMPLATE:") > 0) {
		$g_template = substr($g_options, strpos($g_options, "%TEMPLATE:") + 10, (strpos($g_options, " ", (strpos($g_options, "%TEMPLATE:")))) - (strpos($g_options, "%TEMPLATE:")+10)  );
	}
	
	//lookup product options for testimonials
	$sql="select * from g_testimonialOptions where productID='" . $productID . "'";
	$flnm=mysql_query($sql);
	$frow=mysql_fetch_array($flnm);
	
	//if no template sent in as override then set it based upon the product settings.
	if ($g_template == "") {
		$g_template = $frow['Template'];
	}
	
	// If a specific testimonial ID is passed, retrieve it
	if (substr($g_section, 0, 1) == '#') {
		$g_tSQL = "SELECT * from g_testimonials where uid='" . substr($g_section, 1) . "'";
	} else {
		if (trim($g_section) != "") {
			$g_tSQL = "SELECT * from g_testimonials where productID='" . $productID . "' and UseWhere='" . trim($g_section) . "' and Status='1'";
		} else {
			$g_tSQL = "SELECT * from g_testimonials where productID='" . $productID . "' and UseWhere='' and Status='1'";
		}
		
		if ($g_order == '1') {
			$g_tSQL .= " ORDER BY RAND() LIMIT 1";
		} else {
			$g_tSQL .= " ORDER BY LastUsed ";
		}
	}
	

	$g_tQ=mysql_query($g_tSQL);
	$trow=mysql_fetch_array($g_tQ);
	
	//look backward until we find the rap admin folder, then prepend the previous directories to the path for the templates folder
	$emcnt = 0;
	$prpnd = "";
	do
	{
		if (!file_exists($prpnd . "rap_admin"))
			$prpnd .= "../";
			
	} while (!file_exists($prpnd . "rap_admin") || ++$emcnt < 9);
	
	$g_template_file = $prpnd . "rap_admin/addons/GIS/testimonials/templates/" . $g_template . "/template.html";

	$g_filecontents = file_get_contents($g_template_file); 
		
	$g_filecontents = str_replace("[SUBJECT]", $trow['ShortSubject'], $g_filecontents);
	$g_filecontents = str_replace("[NAME]", $trow['Name'], $g_filecontents);
	$g_filecontents = str_replace("[VISUALNAME]", $trow['VisualName'], $g_filecontents);
	$g_filecontents = str_replace("[LOCATION]", $trow['FromLocation'], $g_filecontents);
	$g_filecontents = str_replace("[TESTIMONIAL]", $trow['Testimonial'], $g_filecontents);
	$g_filecontents = str_replace("[VIDEO]", $trow['VideoURL'], $g_filecontents);
	$g_filecontents = str_replace("images/", "/rap_admin/addons/GIS/testimonials/templates/" . $g_template . "/images/", $g_filecontents);
	
	
	echo $g_filecontents;
	
	//update the date when the testimonial was last displayed so that sorting can happen properly
	$sql="UPDATE g_testimonials set LastUsed='" . date("YmdHis") . "' where uid='" . $trow['uid'] . "'";
	$flnm=mysql_query($sql);
	
}

		

