<?php 

//==============================================================================================
//
//	Filename:	tmp_preview.php
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
//	Description:	This file is called to provide a file description from the database. 
//
//	Version:	1.0.0 (February 19th, 2010)
//
//	Change Log:
//				02/19/10 - Initial Version (JMM)
//
//==============================================================================================

	$basepath = substr(getcwd(),0,strrpos(getcwd(), "/rap_admin"));
	$imagepath = $basepath . "/rap_admin/addons/GIS/testimonials/templates/" . $_POST['tmpname'] . "/preview.jpg";
	
	if (file_exists($imagepath)) {
		echo "<img src=\"/rap_admin/addons/GIS/testimonials/templates/" . $_POST['tmpname'] . "/preview.jpg\" width=\"250\" height=\"250\">";
	}

	
?>
