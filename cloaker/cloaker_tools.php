<?
//==============================================================================================
//
//	Filename:	cloaker_tools.php
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
//	Version:	1.0.0 (February 5th, 2010)
//
//	Change Log:
//				02/05/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); ?>

<script language="JavaScript">

function aCopy() {

	var base =		jQuery("#base").val();
	
	jQuery.post("addons/GIS/cloaker/cloaker_tools.php", { base: base },
					function(data){
						jQuery('#tool-disp').html(data);
				  	}
				);

}

function aContinue() {

	jQuery('#tool-disp').hide();
	jQuery.post("addons/GIS/cloaker/cloaker_tools.php", {  },
			function(data){
				jQuery('#tool-disp').html(data);
			  	}
			);	
}

</script>



<? if ($_POST['base'] != "" ) {

	$basepath = substr(getcwd(),0,strrpos(getcwd(), "/rap_admin"));
	$g_friendly = $basepath . "/" . $_POST['base'];
	
	if (!file_exists($g_friendly)) 
		mkdir($g_friendly);
		
	//place the php handler in the new directory as the default action
	copy($basepath . "/rap_admin/addons/GIS/cloaker/friendly.php", $g_friendly . "/index.php");
	
	//write the .htaccess file
	echo $g_friendly . "/.htaccess";
	if (!($g_flhndl = fopen($g_friendly . "/.htaccess", "w"))) {
		fwrite($g_flhndl, "RewriteEngine On\n");
		fwrite($g_flhndl, "RewriteCond %{REQUEST_URI} !index.php$\n");
		fwrite($g_flhndl, "RewriteRule (.*) index.php?l=$1 [NC]\n");
		fclose($g_flhndl);

	} else { ?>
	<div class="rounded-box-red width-500" id="message-box">
    	    <div class="box-contents width-500">
        The .htaccess file could not be created.  This is probably caused by a permissions problem.  Follow the steps in the manual to complete this step manually.<br><br>
        In the directory <?= $g_friendly; ?> create a file called .htaccess (yes the period goes there) and paste the following 3 lines into the file:<br><br>
        <strong>RewriteEngine On<br>
		RewriteCond %{REQUEST_URI} !index.php$<br>
		RewriteRule (.*) index.php?l=$1 [NC]</strong>
    		</div> 
		</div>
		<br><br>
<?	}
		
	?>
	<table><tr><td>
<div class="rounded-box-green width-500" id="message-box">
    	    <div class="box-contents width-500">
        The setup operation has been completed.  If there were errors they will be above this message.  Click the Continue button below to exit the tools section.
    		</div> 
		</div></td></tr><tr><td>
		<div style='clear:both;'></div><br><br>&nbsp;
		<input type="button" name="submit" id="submit" value="Continue..." onClick="javascript:aContinue();"/>
		</td></tr></table>
<?		
} else { ?>


<table>
<tr class="georgia-medium"><td>
  <table width="600">
 <? 
 	
?>

 <tr class="georgia-small"><td colspan="3">This section is designed to help you make the most out of the Cloaker utility.  Immediately after install you 
 can access the cloaker by going to www.yourdomain.com/rap_admin/addons/GIS/cloaker/friendly.php?l=FRIENDLYNAME.  But that is not very
 friendly is it.  <br><Br>
 I am sure you have seen others doing it something like like www.youdomain.com/recommends/friendlyname.  That is much easier to remember
 for both you and your customers.  You can do the same thing with Cloaker but it requires that you create a folder called recommends and copy
 the friendly.php file into that directory as index.php and then modify the .htaccess file.<br><br>
 If that all sounded like a foreign language, do not worry.  We have created this section to install it for you.  All we need to know 
 is what directory name you would like to use after your domain name.  In the examples above we used recommends for this directory.<br><br>
 After you enter the directory name and click the GO button will attempt to install everything for you.  This process does require some 
 permissions on your web site install to function correctly.  If we cannot install due to permissions, there are easy to follow step
 by step instructions in the manual for Cloaker.</td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td width="200">Base Directory:</td><td><input type="text" name="base" id="base" value="recommends"></td><td></td></tr>
 
</table>
</td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td align="right">
<input type="button" name="submit" id="submit" value="GO" onClick="javascript:aCopy();"/>
</td><td align="right">

</td></tr>
 </table>
  </td></tr>
  <tr><td>
  
</td></tr></table>

<? } ?>

