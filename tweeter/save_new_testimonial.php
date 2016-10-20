<?
//==============================================================================================
//
//	Filename:	add_testimonial.php
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
//	Description:	This file is called when the user wants to copy a file. 
//
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				02/17/10 - Initial Version (JMM)
//
//==============================================================================================
require_once("../../../settings.php");


if ($_POST['action'] == "Create" ) {

	$sql = "insert into g_testimonials (Name, productID, Date, Time, VisualName, FromLocation, Email, Status, ShortSubject, Testimonial, LastUsed, VideoURL) VALUES ('" . $_POST['Name'] . "', '" . $_POST['pid'] . "', '" . date("Ymd") . "', '" . date("Gis") . "', '" . $_POST['VisualName'] . "', '" . $_POST['FromLocation'] . "', '" . $_POST['Email'] . "', '2', '" . $_POST['ShortSubject'] . "', '" . $_POST['Testimonial'] . "', '0', '" . $_POST['VideoURL'] . "')";
	$gid=mysql_query($sql);
	?>
		
	<p class="Testimonial_thank_you">Thank you for submitting your testimonial.  If we have any questions we will contact you via E-mail.</p>
	
<?	$msgtext = "A new testimonial for " . $sys_item_name . "was just entered by a web visitor.  It is in the review state.  You have to manually review every testimonial and move it into active state before it will be visible on the web site.";
	@mail( $sys_eaddress, "New Testimonial for " . $sys_item_name, $msgtext, "From: $sys_item_name <$sys_eaddress>\r\nReply-To: $sys_eaddress\r\nX-Mailer: PHP" . phpversion() );
		
 } 

?>