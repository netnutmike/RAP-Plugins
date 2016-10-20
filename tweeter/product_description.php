<?php 

//==============================================================================================
//
//	Filename:	file_description.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2009(c), Genius Idea Studio, LLC
//
//	Product Is Available For Download From www.rap-tools.com
//
//	Description:	This file is called to provide a file description from the database. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/23/09 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php");

	$sql="select * from products where id='" . $_POST['pid'] . "'";
	$flnm=mysql_query($sql);
	$frow=mysql_fetch_array($flnm);
	
?>

<table><tr><td><strong>Description:</strong></td><td><i><?=$frow['item_desc']?></i></td></tr></table>

