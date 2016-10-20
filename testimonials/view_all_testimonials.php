<?php 

//==============================================================================================
//
//	Filename:	testimonials.php
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
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				02/17/10 - Initial Version (JMM)
//
//==============================================================================================




	$productID = $_REQUEST['pid'];

 	$sql="select * from g_testimonials where productID='" . $_REQUEST['pid'] . "' and Status='1'";
	$gid=mysql_query($sql);
	while ($grow = mysql_fetch_array($gid)) { 
		gTestimonial("#" . $grow['uid']);
		}
?>  
  
  

		
		




