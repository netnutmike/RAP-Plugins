<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright ©2010 Genius Idea Studio, LLC. All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Rapid Action 
| Profits regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.   
|
| ================================================================
| RAP-tools Auto Opt-in
| ================================================================
+--------------------------------------------------------------------------
*/

	// load up the extra values, first load globals, then load product, product overrides global

	$sql="select * from g_themeOptions where productid='0' AND timeType='997'";
	$g_gfldds=mysql_query($sql);

	if (mysql_num_rows($g_gfldds) > 0) {
		$g_gfldrow = mysql_fetch_array($g_gfldds);
		$g_gflds = explode("~~~", $g_gfldrow['options']);
	} else {
		$g_optdef = " ~~~ ~~~ ~~~ ~~~ ~~~ ~~~ ~~~ ";
		$g_gflds = explode("~~~", $g_optdef);
	}
		
	$sql="select * from g_themeOptions where productid='" . $productID . "' AND timeType='997'";
	$g_pfldds=mysql_query($sql);
	
	if (mysql_num_rows($g_pfldds) > 0) {
		$g_pfldrow = mysql_fetch_array($g_pfldds);
		$g_pflds = explode("~~~", $g_pfldrow['options']);
	} else {
		$g_optdef = " ~~~ ~~~ ~~~ ~~~ ~~~ ~~~ ~~~ ";
		$g_pflds = explode("~~~", $g_optdef);
	}
	
	//if a product specific entry exists, replace the global with it
	for ($l=0; $l < 8; ++$l)
		if (trim($g_pflds[$l]) != "")
			$g_gflds[$l] = $g_pflds[$l];
			
			
	$sql="select * from g_themeOptions where productid='0' AND timeType='996'";
	$g_gsfo=mysql_query($sql);

	if (mysql_num_rows($g_gsfo) > 0) {
		$g_gsforow = mysql_fetch_array($g_gsfo);
		$g_gsfo = explode("~~~", $g_gsforow['options']);
	} else {
		$g_optdef = " ~~~ ~~~ ";
		$g_gsfo = explode("~~~", $g_optdef);
	}
		
	$sql="select * from g_themeOptions where productid='" . $productID . "' AND timeType='996'";
	$g_psfo=mysql_query($sql);
	
	if (mysql_num_rows($g_psfo) > 0) {
		$g_psforow = mysql_fetch_array($g_psfo);
		$g_psfo = explode("~~~", $g_psforow['options']);
	} else {
		$g_optdef = " ~~~ ~~~ ";
		$g_psfo = explode("~~~", $g_optdef);
	}

	//if a product specific entry exists, replace the global with it
	for ($l=0; $l < 3; ++$l)
		if (trim($g_psfo[$l]) != "")
			$g_gsfo[$l] = $g_psfo[$l];		


			
?>