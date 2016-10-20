<?
//==============================================================================================
//
//	Filename:	product_options.php
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
//	Description:	This file is called when the user wants to copy a file. 
//
//	Version:	1.0.0 (February 5rd, 2009)
//
//	Change Log:
//				02/05/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); 

function gGetOptionChar($g_optionID, $pid, $defaultval) {
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = '" . $g_optionID . "'";
	if ($pid != "") 
		$sql .= " AND productID='" . $pid . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['ValueChar'];
	} else {
		return $defaultval;
	}
}

function gGetOptionInt($g_optionID, $pid, $defaultval) {
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = '" . $g_optionID . "'";
	if ($pid != "") 
		$sql .= " AND productID='" . $pid . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['ValueInt'];
	} else {
		return $defaultval;
	}
}

function gInsertOptionInt($g_optionID, $pid, $g_value) {
	$sql="INSERT into g_raptoolsOptions (OptionID, productID, ValueInt) VALUES ( '" . $g_optionID . "', '" . $pid . "', '" . $g_value . "')";
	$gid=mysql_query($sql);
}

function gInsertOptionChar($g_optionID, $pid, $g_value) {
	$sql="INSERT into g_raptoolsOptions (OptionID, productID, ValueChar) VALUES ( '" . $g_optionID . "', '" . $pid . "', '" . $g_value . "')";
	$gid=mysql_query($sql);
}

?>

<script language="JavaScript">

function aSave() {

	var robots 			=	jQuery("#robots_option:checked").val();
	var sitemap 		=	jQuery("#sitemap_option:checked").val();
	var rss 			=	jQuery("#rss_option:checked").val();
	var email_not 		=	jQuery("#email_not_options:checked").val();
	var debug 			=	jQuery("#debug_option:checked").val();
	var debug_cookies 	=	jQuery("#log_cookies:checked").val();
	var debug_request 	=	jQuery("#log_request:checked").val();
	var debug_server 	=	jQuery("#log_server:checked").val();
	var debug_type 		=	jQuery("#logtype:checked").val();
	var price_cntdn 	=	jQuery("#price_countdown:checked").val();
	var end_date 		=	jQuery("#enddate").val();
	var pre_text 		=	jQuery("#pretext").val();
	var post_text 		=	jQuery("#posttext").val();
	var after_text 		=	jQuery("#aftertext").val();
	var count_format	=	jQuery("#cformat").val();
	var end_price 		=	jQuery("#endprice").val();
	var end_action 		=	jQuery("#endaction:checked").val();
	var savetag			=	"save";
	var pid =	jQuery("#pid").html();
	jQuery.post("addons/GIS/raptools/product_options.php", { robots: robots, sitemap: sitemap, rss: rss, email_not: email_not, debug: debug, debug_cookies: debug_cookies, debug_request: debug_request, debug_server: debug_server, debug_type: debug_type, price_cntdn: price_cntdn, end_date: end_date, pre_text: pre_text, post_text: post_text, after_text: after_text, count_format: count_format, end_price: end_price, end_action: end_action, pid: pid, savetag: savetag },
					function(data){
						jQuery('#product-options-dis').html(data);
				  	}
				);
}

</script>

<script type="text/javascript" src="addons/GIS/raptools/js/rap-tools.js"></script>

<? if ($_POST['pid'] != "" && $_POST['savetag'] != "") {

	//remove all options for this product before continuing
	$query = "delete from g_raptoolsOptions where productID='" . $_POST["pid"] . "'";		
	$request = mysql_query($query);
	
	if ($_POST['robots'] == '1')
		gInsertOptionInt("AllowRobots", $_POST["pid"], '1');
		
	if ($_POST['sitemap'] == 1)
		gInsertOptionInt("SiteMap", $_POST["pid"], '1');	

	if ($_POST['rss'] == 1)
		gInsertOptionInt("RSS", $_POST["pid"], '1');	

	if ($_POST['email_not'] == 1)
		gInsertOptionInt("EmailNotify", $_POST["pid"], '1');	

	if ($_POST['debug'] == 1){
		//the debug option is a bit more complex, we have to build the option string to save
		$log_options = "1";
		if ($_POST['debug_cookies'] == 1){
			$log_options .= "1";
		} else {
			$log_options .= "0";
		}
		
		if ($_POST['debug_request'] == 1){
			$log_options .= "1";
		} else {
			$log_options .= "0";
		}
		
		if ($_POST['debug_server'] == 1){
			$log_options .= "1";
		} else {
			$log_options .= "0";
		}

		if ($_POST['debug_type'] == 1){
			$log_options .= "1";
		} else {
			$log_options .= "0";
		}
		
		gInsertOptionChar("DebugLogging", $_POST["pid"], $log_options);
	}	

	if ($_POST['end_action'] == 1)
		gInsertOptionInt("EndAction", $_POST["pid"], '1');	

	if ($_POST['price_cntdn'] == 1)
		gInsertOptionInt("PriceCountdown", $_POST["pid"], '1');		

	if (trim($_POST['end_date']) != "")
		gInsertOptionChar("EndDate", $_POST["pid"], trim($_POST['end_date']));
	
	if (trim($_POST['pre_text']) != "")
		gInsertOptionChar("PreText", $_POST["pid"], trim($_POST['pre_text']));

	if (trim($_POST['post_text']) != "")
		gInsertOptionChar("PostText", $_POST["pid"], trim($_POST['post_text']));

	if (trim($_POST['after_text']) != "")
		gInsertOptionChar("AfterText", $_POST["pid"], trim($_POST['after_text']));
		
	if (trim($_POST['count_format']) != "")
		gInsertOptionChar("CountFormat", $_POST["pid"], trim($_POST['count_format']));
		
	if (trim($_POST['end_price']) != "")
		gInsertOptionChar("EndPrice", $_POST["pid"], trim($_POST['end_price']));
	else {
		if ($_POST['price_cntdn'] == 1) { 
			gInsertOptionChar("EndPrice", $_POST["pid"], "0.00"); ?>
			<div class="rounded-box-red width-500" id="error-box">
    	    <div class="box-contents width-500">
        		Notice, you selected a price countdown but did not specify a price after the countdown ended.  A price must exist so the default of 0.00 was set automatically.  You should review the end price.
    		</div> 
		</div>
		<div style='clear:both;'></div>
		<p>&nbsp;</p>
<?php 		}
	}
		
		
	?>


 <div class="rounded-box-green width-500" id="msg-box">
    	    <div class="box-contents width-500">
        		Product Options Have Been Saved
    		</div> 
		</div>
		<br>
		<script type="text/javascript">

			jQuery('#msg-box').fadeOut(20000);

		</script>
		<div style='clear:both;'></div>
		<div style='clear:both;'></div>
		<p>&nbsp;</p>
<br>
<?		
}  ?>

<form id="copyprod" name="copyprod" method="post" action="addons/GIS/raptools/copy_product.php">
<?php 
	$query = "select * from products where id='" . $_REQUEST["pid"] . "'";		
	$request = mysql_query($query);
	$prs = mysql_fetch_array($request); ?>
<table>
<tr><td>
 <div class='gis-content padding-rl-20 width-465' style="display:none" id="pid"><? echo $_REQUEST["pid"]; $pid = $_REQUEST["pid"];?></div>
 <table>
 <? 
 	$basepath = substr(getcwd(),0,strrpos(getcwd(), "/rap_admin"));

	if (!file_exists($basepath . $prs['install_folder'])) { ?>
	<tr><td colspan="3">
 	<div class="rounded-box-red width-500" id="error-box">
    	    <div class="box-contents width-500">
        WARNING!  This product does not have any files at the location of the Install Folder.
    		</div> 
		</div>
		<div style='clear:both;'></div>
		</td></tr>
	<script type='text/javascript'>
	jQuery("#copy_files").removeAttr("checked");
	jQuery("#copy_files_div").hide();
	</script>
	
 <?
 	
	 }
	 
	 //load options
	 $robots = gGetOptionInt("AllowRobots", $pid, '1');
	 $sitemap = gGetOptionInt("SiteMap", $pid, '1');
	 $rss = gGetOptionInt("RSS", $pid, '1');
	 $email_notification = gGetOptionInt("EmailNotify", $pid, '1');
	 $debug = gGetOptionChar("DebugLogging", $pid, "");
	 if (trim($debug) != "") {
	 	$debug_cookies = substr($debug,1,1);
	 	$debug_request = substr($debug,2,1);
	 	$debug_server = substr($debug,3,1);
	 	$debug_type = substr($debug,4,1);
	 	$debug = "1";		
	 }
	 $price_cntdn = gGetOptionInt("PriceCountdown", $pid, '0');
	 $end_date = gGetOptionChar("EndDate", $pid, "");
	 $pre_text = gGetOptionChar("PreText", $pid, "");
	 $post_text = gGetOptionChar("PostText", $pid, "");
	 $after_text = gGetOptionChar("AfterText", $pid, "");
	 $end_price = gGetOptionChar("EndPrice", $pid, "");
	 $count_format = gGetOptionChar("CountFormat", $pid, "");
	 $end_action = gGetOptionInt("EndAction", $pid, '1');
 ?>
 
 <tr><td><strong>Product Options:</strong></td><td></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td colspan="2">
 <table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><ul class="checklist">
<li>
<input id="robots_option" name="copy_product" value="1" type="checkbox" <? if ($robots == 1) echo "checked"; ?>>
					<a href="javascript:void(0);" id="aseti"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for=""robots_option"">Allow Search Engines To Index This Product</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="aseti-desc">This option determines how this product is defined in the robots.txt file.  Rap-tools can create a robots.txt file dynamically
based on the options you set for each product.  If you do not want to allow search engines to index this product then turn this option off.</div>
<p>&nbsp;</p>
<ul class="checklist">
<li>
<input id="sitemap_option" name="copy_coupons" value="1" type="checkbox" <? if ($sitemap == 1) echo "checked"; ?>>
					<a href="javascript:void(0);" id="ipism"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="sitemap_option">Include This Product in Sitemap Files</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="ipism-desc">Rap Tools generates a sitemap file for your RAP site.  If you select this option then this product will be made available within the sitemap files when it is created.  If you do not want to include this product in the sitemap files then unselect this option.</div>
<p>&nbsp;</p>
<ul class="checklist">
<li>
<input id="rss_option" name="rss_option" value="1" type="checkbox" <? if ($rss == 1) echo "checked"; ?>>
					<a href="javascript:void(0);" id="ipirssf"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="rss_option">Include Product in RSS Feed</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="ipirssf-desc">Rap Tools can create an RSS feed for your products and your blog.  This option determines if this product will be published
in the RSS feed.  If this is a dummy product or a product that is not yet released then you can uncheck this option and the product will not be published in the RSS feed.</div>
<p>&nbsp;</p>
<ul class="checklist">
<li>
<input id="email_not_options" name="email_not_options" value="1" type="checkbox" <? if ($email_notification == 1) echo "checked"; ?>>
					<a href="javascript:void(0);" id="enopt"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="email_not_options">Email Notifications</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="enopt-desc">Rap Tools can send out email notifications to your affiliates and JV partners.  The options for who gets what emails is configured in the options section or Rap Tools, by selecting this option, this product will send out sales notifications based upon the options set in the options settings.</div>
<p>&nbsp;</p>
<ul class="checklist">
<li>
<input id="debug_option" name="debug_option" value="1" type="checkbox" <? if ($debug == 1) echo "checked"; ?>>
					<a href="javascript:void(0);" id="todftp"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="debug_option">Debugging Log</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="todftp-desc">When you select this option Rap Tracker will create a debugging log in the product folder.  If this option is turned on you can select the information that is logged in the logging file.</div>
<div id="debug_div">
<table>
<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
<ul class="checklist-toggle">
<li>
<input id="logtype" name="logtype" value="1" type="checkbox" <? if ($debug_type == "1") echo "checked"; ?>>
					<table><tr height="35"><td  width="200"><a class="checkbox-toggle-select" href="#">Text File</a></td><td width="40"></td><td width="200"><a class="checkbox-toggle-deselect" href="#">CSV</a></td></tr></table>
                    </li>
</ul>
</td></tr>

<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
<ul class="checklist">
<li>
<input id="log_cookies" name="log_cookies" value="1" type="checkbox" <? if ($debug_cookies == "1") echo "checked"; ?>>
					<a href="javascript:void(0);" id="logcookiesi"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="log_cookies">Log Cookies</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="logcookiesi-desc">This option when activated will log all cookie settings for a visitor.</div>
</td></tr>
<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
<ul class="checklist">
<li>
<input id="log_request" name="log_request" value="1" type="checkbox" <? if ($debug_request == "1") echo "checked"; ?>>
					<a href="javascript:void(0);" id="logrequesti"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="log_request">Log REQUEST Variables</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="logrequesti-desc">This option when activated will log all variables passed in the _REQUEST.</div>
</td></tr>

<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
<ul class="checklist">
<li>
<input id="log_server" name="log_server" value="1" type="checkbox" <? if ($debug_server == "1") echo "checked"; ?>>
					<a href="javascript:void(0);" id="logserveri"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="log_server">Log SERVER Variables</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="logserveri-desc">This option when activated will log all SERVER variables.</div>
</td></tr>


</table>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="endactioni-desc">When the end time is reached for the countdown there are 2 options.  The first is to simply disable the product.  The second is to set a new price.  This is useful if you have an introductory price on a product.  If you select the change price option you must then enter what the new price will be.  At the end time the new price will automatically be set.</strong></br></div>

</div>






<p>&nbsp;</p>
<ul class="checklist">
<li>
<input id="price_countdown" name="price_countdown" value="1" type="checkbox" <? if ($price_cntdn == 1) echo "checked"; ?>>
					<a href="javascript:void(0);" id="pcopt"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="price_countdown">Price Countdown</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="pcopt-desc">If you would like to activate a price countdown then turn on this option and complete the options below.  With this option you can set a number of days or a date when either the price changes or the product becomes inactive.  This is a quick and easy way to create a sense of urgency.  The countdown is added to your sales page by using a token.</div>
<p>&nbsp;</p>
<div id="price_countdown_div">
<table>
<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>End Date:</td><td><input type="text" name="enddate" id="enddate" value="<? echo $end_date;?>">
</td><td><a href="javascript:void(0);" id="enddti"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
</td></tr>
<tr><td></td><td colspan="3"><div class='gis-content padding-rl-20 width-465' style="display:none" id="enddti-desc">This is the date and time that the price countdown will end.  It must be in the form of xx/xx/xxxx xx:xx:xx.  Be sure to include zeros in front of single digit numbers (ex. 01/01/2010 05:05:05).</div></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Pretext (optional):</td><td><input type="text" name="pretext" id="pretext" value="<? echo $pre_text;?>">
</td><td><a href="javascript:void(0);" id="pretexti"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
</td></tr>
<tr><td></td><td colspan="3"><div class='gis-content padding-rl-20 width-465' style="display:none" id="pretexti-desc">This is an optional parameter.  Any text that is placed in this field is output before the countdown time is output.  Output goes like this:  &lt;pretext&gt; countdown &lt;posttext&gt;</div></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Post Text (optional):</td><td><input type="text" name="posttext" id="posttext" value="<? echo $post_text;?>">
</td><td><a href="javascript:void(0);" id="posttexti"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
</td></tr>
<tr><td></td><td colspan="3"><div class='gis-content padding-rl-20 width-465' style="display:none" id="posttexti-desc">This is an optional parameter.  Any text that is placed in this field is output after the countdown time is output.  Output goes like this:  &lt;pretext&gt; countdown &lt;posttext&gt;</div></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>After Date Text (optional):</td><td><input type="text" name="aftertext" id="aftertext" value="<? echo $after_text;?>">
</td><td><a href="javascript:void(0);" id="aftertexti"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
</td></tr>
<tr><td></td><td colspan="3"><div class='gis-content padding-rl-20 width-465' style="display:none" id="aftertexti-desc">This is an optional parameter.  Any text that is placed in this field is output when the countdown time has been reached.  It could be simply a message stating that they missed the special offer.  If this option is left blank, when the time has passed, the token will not output anything and it will be like the token does not even exist.</div></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Countdown Format:</td><td><input type="text" name="cformat" id="cformat" value="<? echo $count_format;?>">
</td><td><a href="javascript:void(0);" id="cformati"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
</td></tr>
<tr><td></td><td colspan="3"><div class='gis-content padding-rl-20 width-465' style="display:none" id="cformati-desc">This is the format of the countdown timer.  It can be a simple HH:MM:SS format or just a mumber of days or both.  Here are the format codes that can be used: </div></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
<ul class="checklist-toggle">
<li>
<input id="endaction" name="endaction" value="1" type="checkbox" <? if ($end_action == 1) echo "checked"; ?>>
					<table><tr height="35"><td  width="200"><a class="checkbox-toggle-select" href="#">Change Price</a></td><td width="40"></td><td width="200"><a class="checkbox-toggle-deselect" href="#">Disable Product</a></td></tr></table>
                   
                    
                    
                    </li>
</ul><a href="javascript:void(0);" id="endactioni"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
</td></tr></table>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="endactioni-desc">When the end time is reached for the countdown there are 2 options.  The first is to simply disable the product.  The second is to set a new price.  This is useful if you have an introductory price on a product.  If you select the change price option you must then enter what the new price will be.  At the end time the new price will automatically be set.</strong></br></div>

</td></tr>
<tr><td></td><td colspan="3">
<div class='gis-content padding-rl-20 width-465' style="display:none" id="end-price-div">

<table>
<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>End price:</td><td><input type="text" name="endprice" id="endprice" value="<? echo $end_price; ?>">
</td><td>
</td></tr></table></div>
</td></tr></table></div>
</td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td align="right">
<input type="button" name="submit" id="submit" value="Save" onClick="javascript:aSave();"/>
</td><td align="right">

</td></tr>
 </table>
  </td></tr>
  <tr><td>
  
 
</form>

</td></tr></table>


<script type='text/javascript'>
jQuery(document).ready(function() {
	 
    /* see if anything is previously checked and reflect that in the view*/
    jQuery(".checklist input:checked").parent().addClass("selected");
 
    /* handle the user selections */
    jQuery(".checklist .checkbox-select").click(
        function(event) {
            event.preventDefault();
            jQuery(this).parent().addClass("selected");
            jQuery(this).parent().find(":checkbox").attr("checked","checked");
            showHideProductOptionsSections();
        }
    );
 
    jQuery(".checklist .checkbox-deselect").click(
        function(event) {
            event.preventDefault();
            jQuery(this).parent().removeClass("selected");
            jQuery(this).parent().find(":checkbox").removeAttr("checked");
            showHideProductOptionsSections();
        }
    );

    
    /* see if anything is previously checked and reflect that in the view*/
    jQuery(".checklist-toggle input:checked").parent().addClass("selected");
 
    /* handle the user selections */
    jQuery(".checklist-toggle .checkbox-toggle-select").click(
        function(event) {
            event.preventDefault();
            jQuery(this).parent().parent().parent().parent().parent().addClass("selected");
            jQuery(this).parent().parent().parent().parent().parent().find(":checkbox").attr("checked","checked");
            showHideProductOptionsSections();
        }
    );
 
    jQuery(".checklist-toggle .checkbox-toggle-deselect").click(
        function(event) {
            event.preventDefault();
            jQuery(this).parent().parent().parent().parent().parent().removeClass("selected");
            jQuery(this).parent().parent().parent().parent().parent().find(":checkbox").removeAttr("checked");
            showHideProductOptionsSections();
        }
    );

    showHideProductOptionsSections();

	jQuery("#aseti").click(function() {
		
		jQuery("#aseti-desc").toggle();

	});

	jQuery("#ipism").click(function() {
		
		jQuery("#ipism-desc").toggle();

	});

	jQuery("#ipirssf").click(function() {
		
		jQuery("#ipirssf-desc").toggle();

	});

	jQuery("#enopt").click(function() {
		
		jQuery("#enopt-desc").toggle();

	});

	jQuery("#todftp").click(function() {
		
		jQuery("#todftp-desc").toggle();

	});

	jQuery("#pcopt").click(function() {
		
		jQuery("#pcopt-desc").toggle();

	});	

	jQuery("#enddti").click(function() {
		
		jQuery("#enddti-desc").toggle();

	});	

	jQuery("#pretexti").click(function() {
		
		jQuery("#pretexti-desc").toggle();

	});	

	jQuery("#posttexti").click(function() {
		
		jQuery("#posttexti-desc").toggle();

	});	

	jQuery("#aftertexti").click(function() {
		
		jQuery("#aftertexti-desc").toggle();

	});			

	jQuery("#cformati").click(function() {
		
		jQuery("#cformati-desc").toggle();

	});		

	jQuery("#endactioni").click(function() {
		
		jQuery("#endactioni-desc").toggle();

	});	

	jQuery("#logcookiesi").click(function() {
		
		jQuery("#logcookiesi-desc").toggle();

	});	

	jQuery("#logserveri").click(function() {
		
		jQuery("#logserveri-desc").toggle();

	});	

	jQuery("#logrequesti").click(function() {
		
		jQuery("#logrequesti-desc").toggle();

	});			
});

</script>