<?php 

//==============================================================================================
//
//	Filename:	product_description.php
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
//	Description:	This file is called to provide a product description from the database. 
//
//	Version:	1.0.0 (February 23rd, 2010)
//
//	Change Log:
//				2/23/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php");

	$sql="select * from products where id='" . $_POST['pid'] . "'";
	$flnm=mysql_query($sql);
	$frow=mysql_fetch_array($flnm);
	
	
	if ( $frow['testmode'] == "1" ) { ?>
			<div class="rounded-box-red" id="error-box">
    	    <div class="box-contents">
        This product is in <b>Test Mode</b>
    		</div> 
		</div>
		<br>
<? 	} ?>

<table><tr><td><strong>Description:</strong></td><td><i><?=$frow['item_desc']?></i></td></tr></table>

