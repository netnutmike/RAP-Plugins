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
?>



<div id="NewTestimonial">
<br><br><p class="georgia-medium">Add New Testimonial</p>
<form id="newtestimonial" name="newtestimonial" method="post" action="/rap_admin/addons/GIS/testimonials/save_new_testimonial.php">
<input type="hidden" name="action" value="Create">
<input type="hidden" name="pid" value="<?= $_REQUEST['pid']; ?>">
<table>
<tr><td>
 	<table>
 	<tr><td class="testimonial_text" colspan="5">Please fill out the following information to submit a new testimonial:</td></tr>
 	<tr><td class="testimonial_prompts">Name:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="Name" id="Name" class="testimonial_input"></td><td>&nbsp;&nbsp;</td><td>This is your full real name.</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="testimonial_prompts">Visual Name:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="VisualName" id="VisualName" class="testimonial_input"></td><td>&nbsp;&nbsp;</td><td>Your name as you would like it displayed on the testimonial.</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="testimonial_prompts">Email:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="Email" id="Email" size="60" class="testimonial_input"></td><td>&nbsp;&nbsp;</td><td>Your Real Email address in case we need to contact you.</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="testimonial_prompts">From(location):</td><td>&nbsp;&nbsp;</td><td><input type="text" name="FromLocation" id="FromLocation" size="40" class="testimonial_input"></td><td>&nbsp;&nbsp;</td><td>Where you would like the testimonial to say you are from.</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="testimonial_prompts">Subject:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="ShortSubject" id="ShortSubject" size="70" class="testimonial_input"></td><td>&nbsp;&nbsp;</td><td>This is your Eye Catching Tag line or subject for your Testimonial.</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="testimonial_prompts">Testimonial:</td><td>&nbsp;&nbsp;</td><td><textarea name="Testimonial" id="Testimonial" cols="50" rows="20" class="testimonial_input"></textarea></td><td>&nbsp;&nbsp;</td><td>Your Testimonial Goes here.  You can have text here and an attached video.</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="testimonial_prompts">Video Embed Code(optional):</td><td>&nbsp;&nbsp;</td><td><textarea name="VideoURL" id="VideoURL" cols="50" rows="10" class="testimonial_input"></textarea></td><td>&nbsp;&nbsp;</td><td>This should be the embed code from your favorite video site.  (This is optional)</td></tr>
 	<tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
  
 
<Table><tr><td>
<input type="submit" name="submit" id="submit" value="Save" onClick="javascript:aCreate();"/>
</td><td>
<input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:aCreateCancel();" />
</td></tr></table>
</td></tr></table>
</form>
</div>
