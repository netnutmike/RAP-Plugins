<?
//==============================================================================================
//
//	Filename:	options.php
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
//	Description:	This file is called when the user wants to change the options
//
//	Version:	1.0.0 (February 5th, 2009)
//
//	Change Log:
//				02/05/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); 



?>

<script type="text/javascript">
	 tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "addons/GIS/raptools/css/content.css",
		
		height : 300,
		width  : 600

	});

	
</script>

<script language="JavaScript">

function aSave() {

	var robots 			=	jQuery("#robots_option:checked").val();
	var robots_b_rap	=	jQuery("#Block_rap_admin:checked").val();
	var robots_b_tmp	=	jQuery("#Block_product_templates:checked").val();
	var robots_b_dwn	=	jQuery("#Block_downloads:checked").val();
	var robots_b_man	=	jQuery("#Block_manual:checked").val();
	
	var sitemap 		=	jQuery("#sitemap_option:checked").val();
	
	var rss 			=	jQuery("#rss_option:checked").val();
	var rss_feed 		=	jQuery("#rssfeed").val();
	var rss_prepost		=	jQuery("#rssprepost:checked").val();
	
	var email_not 		=	jQuery("#g_email_not_options:checked").val();

	var own_email_not 	=	jQuery("#Owner_Notify:checked").val();
	var own_email_evr 	=	jQuery("#Owner_EverySale:checked").val();
	var own_email_txt 	=	tinyMCE.get("elm1").getContent();
	var own_email_ref 	=	jQuery("#Owner_Refunds:checked").val();
	var own_email_rxt 	=	tinyMCE.get("elm2").getContent();

	var aff_email_not 	=	jQuery("#Affiliate_Notify:checked").val();
	var aff_email_evr 	=	jQuery("#Affiliate_EverySale:checked").val();
	var aff_email_tr2 	=	jQuery("#Affiliate_2Tier:checked").val();
	var aff_email_txt 	=	tinyMCE.get("aelm1").getContent();
	var aff_email_ref 	=	jQuery("#Affiliate_Refunds:checked").val();
	var aff_email_rxt 	=	tinyMCE.get("aelm2").getContent();

	var jv_email_not 	=	jQuery("#JV_Notify:checked").val();
	var jv_email_evr 	=	jQuery("#jv_EverySale:checked").val();
	var jv_email_tr2 	=	jQuery("#jv_2Tier:checked").val();
	var jv_email_txt 	=	tinyMCE.get("jelm1").getContent();
	var jv_email_ref 	=	jQuery("#jv_Refunds:checked").val();
	var jv_email_rxt 	=	tinyMCE.get("jelm2").getContent();

	var ep_email_not 	=	jQuery("#Equity_Notify:checked").val();
	var ep_email_evr 	=	jQuery("#Equity_EverySale:checked").val();
	var ep_email_txt 	=	tinyMCE.get("eelm1").getContent();
	var ep_email_ref 	=	jQuery("#Equity_Refunds:checked").val();
	var ep_email_rxt 	=	tinyMCE.get("eelm2").getContent();

	var savetag			=	"save";

	jQuery('#main-dis').html(loadingimage);

	jQuery.post("addons/GIS/raptools/options.php", { robots: robots, robots_b_rap: robots_b_rap, robots_b_tmp: robots_b_tmp, robots_b_dwn: robots_b_dwn, robots_b_man: robots_b_man, sitemap: sitemap, rss: rss, rss_feed: rss_feed, rss_prepost: rss_prepost, email_not: email_not,
		own_email_not: own_email_not, own_email_evr: own_email_evr, own_email_txt: own_email_txt, own_email_ref: own_email_ref, own_email_rxt: own_email_rxt,
		aff_email_not: aff_email_not, aff_email_evr: aff_email_evr, aff_email_tr2: aff_email_tr2, aff_email_txt: aff_email_txt, aff_email_ref: aff_email_ref, aff_email_rxt: aff_email_rxt,
		jv_email_not: jv_email_not, jv_email_evr: jv_email_evr, jv_email_tr2: jv_email_tr2, jv_email_txt: jv_email_txt, jv_email_ref: jv_email_ref, jv_email_rxt: jv_email_rxt,
		ep_email_not: ep_email_not, ep_email_evr: ep_email_evr, ep_email_txt: ep_email_txt, ep_email_ref: ep_email_ref, ep_email_rxt: ep_email_rxt, savetag: savetag },
					function(data){
						jQuery('#main-dis').html(data);
				  	}
				);
}

</script>

<script type="text/javascript" src="addons/GIS/raptools/js/rap-tools.js"></script>

<? if ($_POST['savetag'] == "save") {
	
	if ($_POST['robots'] != "")
		gUpdateOptionInt("Robots", '0', $_POST['robots']);
		
	if ($_POST['robots_b_rap'] != "")
		gUpdateOptionInt("RobotsRAP", '0', $_POST['robots_b_rap']);
		
	if ($_POST['robots_b_tmp'] != "")
		gUpdateOptionInt("RobotsTemplates", '0', $_POST['robots_b_tmp']);
		
	if ($_POST['robots_b_dwn'] != "")
		gUpdateOptionInt("RobotsDownloads", '0', $_POST['robots_b_dwn']);
		
	if ($_POST['robots_b_man'] != "")
		gUpdateOptionInt("RobotsManual", '0', $_POST['robots_b_man']);
		
	if ($_POST['sitemap'] != "")
		gUpdateOptionInt("SiteMap", '0', $_POST['sitemap']);
		
	if ($_POST['rss'] != "")
		gUpdateOptionInt("RSS", '0', $_POST['rss']);
		
	if ($_POST['rss_feed'] != "")
		gUpdateOptionChar("RSSFeed", '0', $_POST['rss_feed']);
		
	if ($_POST['rss_prepost'] != "")
		gUpdateOptionInt("RSSPos", '0', $_POST['rss_prepost']);
		
	if ($_POST['email_not'] != "")
		gUpdateOptionInt("EmailNotify", '0', $_POST['email_not']);
		
	if ($_POST['own_email_not'] != "")
		gUpdateOptionInt("EmailNotifyOwner", '0', $_POST['own_email_not']);
		
	if ($_POST['own_email_evr'] != "")
		gUpdateOptionInt("EmailNotifyOwnerEverySale", '0', $_POST['own_email_evr']);
		
	if ($_POST['own_email_txt'] != "")
		gUpdateOptionChar("EmailNotifyOwnerEverySaleText", '0', $_POST['own_email_txt']);
		
	if ($_POST['own_email_ref'] != "")
		gUpdateOptionInt("EmailNotifyOwnerRefund", '0', $_POST['own_email_ref']);
		
	if ($_POST['own_email_rxt'] != "")
		gUpdateOptionChar("EmailNotifyOwnerRefundText", '0', $_POST['own_email_rxt']);
		
	if ($_POST['aff_email_not'] != "")
		gUpdateOptionInt("EmailNotifyAffiliate", '0', $_POST['aff_email_not']);
		
	if ($_POST['aff_email_evr'] != "")
		gUpdateOptionInt("EmailNotifyAffiliateEverySale", '0', $_POST['aff_email_evr']);
		
	if ($_POST['aff_email_tr2'] != "")
		gUpdateOptionInt("EmailNotifyAffiliateTier2Sale", '0', $_POST['aff_email_tr2']);
		
	if ($_POST['aff_email_txt'] != "")
		gUpdateOptionChar("EmailNotifyAffiliateEverySaleText", '0', $_POST['aff_email_txt']);
		
	if ($_POST['aff_email_ref'] != "")
		gUpdateOptionInt("EmailNotifyAffiliateRefund", '0', $_POST['aff_email_ref']);
		
	if ($_POST['aff_email_rxt'] != "")
		gUpdateOptionChar("EmailNotifyAffiliateRefundText", '0', $_POST['aff_email_rxt']);
		
	if ($_POST['jv_email_not'] != "")
		gUpdateOptionInt("EmailNotifyJV", '0', $_POST['jv_email_not']);
		
	if ($_POST['jv_email_evr'] != "")
		gUpdateOptionInt("EmailNotifyJVEverySale", '0', $_POST['jv_email_evr']);
		
	if ($_POST['jv_email_tr2'] != "")
		gUpdateOptionInt("EmailNotifyJVTier2Sale", '0', $_POST['jv_email_tr2']);
		
	if ($_POST['jv_email_txt'] != "")
		gUpdateOptionChar("EmailNotifyJVEverySaleText", '0', $_POST['jv_email_txt']);
		
	if ($_POST['jv_email_ref'] != "")
		gUpdateOptionInt("EmailNotifyJVRefund", '0', $_POST['jv_email_ref']);
		
	if ($_POST['jv_email_rxt'] != "")
		gUpdateOptionChar("EmailNotifyJVRefundText", '0', $_POST['jv_email_rxt']);
		
	if ($_POST['ep_email_not'] != "")
		gUpdateOptionInt("EmailNotifyEP", '0', $_POST['ep_email_not']);
		
	if ($_POST['ep_email_evr'] != "")
		gUpdateOptionInt("EmailNotifyEPEverySale", '0', $_POST['ep_email_evr']);
		
	if ($_POST['ep_email_txt'] != "")
		gUpdateOptionChar("EmailNotifyEPEverySaleText", '0', $_POST['ep_email_txt']);
		
	if ($_POST['ep_email_ref'] != "")
		gUpdateOptionInt("EmailNotifyEPRefund", '0', $_POST['ep_email_ref']);
		
	if ($_POST['ep_email_rxt'] != "")
		gUpdateOptionChar("EmailNotifyEPRefundText", '0', $_POST['ep_email_rxt']);
			
		
	?>


 <!-- <div class="rounded-box-green width-500" id="msg-box">
    	    <div class="box-contents width-500">
        		Options Have Been Saved
    		</div> 
		</div>
		<br>
		<script type="text/javascript">

			jQuery('#msg-box').fadeOut(20000);

		</script>  --> 

<? } ?>

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
	 
	 //load options
	 $robots = gGetOptionInt("Robots", '0', '1');
	 $robots_rap_admin = gGetOptionInt("RobotsRAP", '0', '1');
	 $robots_templates = gGetOptionInt("RobotsTemplates", '0', '1');
	 $robots_downloads = gGetOptionInt("RobotsDownloads", '0', '1');
	 $robots_manual = gGetOptionInt("RobotsManual", '0', '0');
	 $sitemap = gGetOptionInt("SiteMap", '0', '1');
	 $rss = gGetOptionInt("RSS", '0', '1');
	 $rss_feed = gGetOptionChar("RSSFeed", '0', '');
	 $rss_pos = gGetOptionInt("RSSPos", '0', '1');
	 
	 $email_notification = gGetOptionInt("EmailNotify", '0', '0');
	 $email_notification_Owner = gGetOptionInt("EmailNotifyOwner", '0', '1');
	 $email_notification_Owner_Every_Sale = gGetOptionInt("EmailNotifyOwnerEverySale", '0', '1');
	 $email_notification_Owner_Every_Sale_text = gGetOptionChar("EmailNotifyOwnerEverySaleText", '0', ' ');
	 $email_notification_Owner_refund = gGetOptionInt("EmailNotifyOwnerRefund", '0', '1');
	 $email_notification_Owner_refund_text = gGetOptionChar("EmailNotifyOwnerRefundText", '0', ' ');
	 
	 $email_notification_Affiliate = gGetOptionInt("EmailNotifyAffiliate", '0', '1');
	 $email_notification_Affiliate_Every_Sale = gGetOptionInt("EmailNotifyAffiliateEverySale", '0', '1');
	 $email_notification_Affiliate_Tier2_Sale = gGetOptionInt("EmailNotifyAffiliateTier2Sale", '0', '1');
	 $email_notification_Affiliate_Every_Sale_text = gGetOptionChar("EmailNotifyAffiliateEverySaleText", '0', ' ');
	 $email_notification_Affiliate_refund = gGetOptionInt("EmailNotifyAffiliateRefund", '0', '1');
	 $email_notification_Affiliate_refund_text = gGetOptionChar("EmailNotifyAffiliateRefundText", '0', ' ');
	 
	 $email_notification_JV = gGetOptionInt("EmailNotifyJV", '0', '1');
	 $email_notification_JV_Every_Sale = gGetOptionInt("EmailNotifyJVEverySale", '0', '1');
	 $email_notification_JV_Tier2_Sale = gGetOptionInt("EmailNotifyJVTier2Sale", '0', '1');
	 $email_notification_JV_Every_Sale_text = gGetOptionChar("EmailNotifyJVEverySaleText", '0', ' ');
	 $email_notification_JV_refund = gGetOptionInt("EmailNotifyJVRefund", '0', '1');
	 $email_notification_JV_refund_text = gGetOptionChar("EmailNotifyJVRefundText", '0', ' ');
	 
	 $email_notification_EP = gGetOptionInt("EmailNotifyEP", '0', '1');
	 $email_notification_EP_Every_Sale = gGetOptionInt("EmailNotifyEPEverySale", '0', '1');
	 $email_notification_EP_Every_Sale_text = gGetOptionChar("EmailNotifyEPEverySaleText", '0', ' ');
	 $email_notification_EP_refund = gGetOptionInt("EmailNotifyEPRefund", '0', '1');
	 $email_notification_EP_refund_text = gGetOptionChar("EmailNotifyEPRefundText", '0', ' ');
	 
	 
 ?>
 
 <tr><td><strong>Options:</strong></td><td></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td colspan="2">
 	<table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
 		<ul class="checklist">
			<li>
				<input id="robots_option" name="robots_option" value="1" type="checkbox" <? if ($robots == 1) echo "checked"; ?>>
				<a href="javascript:void(0);" id="aseti"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
				<label for=""robots_option"">Create a robots.txt file</label>
            	<a class="checkbox-select" href="#">Select</a>
            	<a class="checkbox-deselect" href="#">Cancel</a>
            </li>
		</ul>
		<div class='gis-content padding-rl-20 width-465' style="display:none" id="aseti-desc">If this option is checked, a robots.txt file will be created using the cron method.  A robots.txt file tells the search engines what to and not to index.</div>
		<div id="robots_div" style="display:none">
			<table>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
					<ul class="checklist">
						<li>
							<input id="Block_rap_admin" name="Block_rap_admin" value="1" type="checkbox" <? if ($robots_rap_admin == "1") echo "checked"; ?>>
							<a href="javascript:void(0);" id="blockrapadmin"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    		<label for="Block_rap_admin">Block robots from rap_admin</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
					<div class='gis-content padding-rl-20 width-465' style="display:none" id="blockrapadmin-desc">When this option is activated it will add a disallow statement for the rap_admin area.  There is no reason to have a search engine robot index your rap_admin directory.</div>
				</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
					<ul class="checklist">
						<li>
							<input id="Block_product_templates" name="Block_product_templates" value="1" type="checkbox" <? if ($robots_templates == "1") echo "checked"; ?>>
							<a href="javascript:void(0);" id="blockproducttemplates"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    		<label for="Block_product_templates">Block robots from product templates</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
					<div class='gis-content padding-rl-20 width-465' style="display:none" id="blockproducttemplates-desc">Selecting this option will disallow every template folders for all of your products so that search engines do not index your template folders.</div>
				</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
					<ul class="checklist">
						<li>
							<input id="Block_downloads" name="Block_downloads" value="1" type="checkbox" <? if ($robots_downloads == "1") echo "checked"; ?>>
							<a href="javascript:void(0);" id="blockdownloads"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    		<label for="Block_downloads">Block robots from download folders</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
					<div class='gis-content padding-rl-20 width-465' style="display:none" id="blockdownloads-desc">When this option is activated it will add a disallow statement for the download folders for your products.  You do not want your download area indexed.</div>
				</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
					<ul class="checklist">
						<li>
							<input id="Block_manual" name="Block_manual" value="1" type="checkbox" <? if ($robots_manual == "1") echo "checked"; ?>>
							<a href="javascript:void(0);" id="blockmanual"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    		<label for="Block_manual">Manually Add Disallow statements</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
					<div class='gis-content padding-rl-20 width-465' style="display:none" id="blockmanual-desc">If you would like to add some additional Disallow statements by manually entering the path select this option.</div>
				</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td></td><td colspan="3">
				<div id="block_manual_div" style="display:none">
					
				</div>
				</td></tr>
			</table>
		</div>
		<p>&nbsp;</p>
		<ul class="checklist">
			<li>
				<input id="sitemap_option" name="sitemap_option" value="1" type="checkbox" <? if ($sitemap == 1) echo "checked"; ?>>
				<a href="javascript:void(0);" id="ipism"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                <label for="sitemap_option">Generate Sitemap Files</label>
                <a class="checkbox-select" href="#">Select</a>
                <a class="checkbox-deselect" href="#">Cancel</a>
           </li>
		</ul>
		<div class='gis-content padding-rl-20 width-465' style="display:none" id="ipism-desc">If this option is activated rap-tools will generate both a plain text and xml sitemap file for the search engines to follow.  There are additional options that can be set if this option is activated.  The sitemap files are generated by the cron function.</div>
		<div id="sitemap_div" style="display:none">
			<table>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
				Loading...
				</td></tr>
			</table>
		</div>
		<p>&nbsp;</p>
		<ul class="checklist">
			<li>
				<input id="rss_option" name="rss_option" value="1" type="checkbox" <? if ($rss == 1) echo "checked"; ?>>
				<a href="javascript:void(0);" id="rssi"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                <label for="rss_option">Enable RSS Feed</label>
                <a class="checkbox-select" href="#">Select</a>
                <a class="checkbox-deselect" href="#">Cancel</a>
           	</li>
		</ul>
		<div class='gis-content padding-rl-20 width-465' style="display:none" id="rssi-desc">When this option is activated the RSS feed will be generated.  There are additional options available if this option is activated.  The RSS feed is generated real-time when someone requests the feed.</div>
		<p>&nbsp;</p>
		<div id="rss_div">
			<table>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Addon RSS Feed:</td><td><input type="text" name="rssfeed" id="rssfeed" value="<? echo $rss_feed;?>">
				</td><td><a href="javascript:void(0);" id="rssfeedi"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
				</td></tr>
				<tr><td></td><td colspan="3"><div class='gis-content padding-rl-20 width-465' style="display:none" id="rssfeedi-desc">If you are using something like blog marketing to promote your site, you can include the RSS feed from the blog or other site in with your products.  This is great if you are going to submit your RSS feed to feed directories because it keeps the RSS feed "fresh" for the indexes.</br></div></td>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">Insert Other RSS Feed:
					<ul class="checklist-toggle">
						<li>
							<input id="rssprepost" name="rssprepost" value="1" type="checkbox" <? if ($rss_pos == 1) echo "checked"; ?>>
								<table><tr height="35"><td  width="200"><a class="checkbox-toggle-select" href="#">Before The Products</a></td><td width="40"></td><td width="200"><a class="checkbox-toggle-deselect" href="#">After The Products</a></td></tr></table>
                    	</li>
					</ul>
					<a href="javascript:void(0);" id="rsspreposti"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
				</td></tr>
			</table>
		</div>
		<div class='gis-content padding-rl-20 width-465' style="display:none" id="rsspreposti-desc">This option determines where the Other RSS feed is inserted as compared to the products.  One line of thinking is to put it before the products so the RSS feed looks to be "fresh" and other say that the products should go first because they are more important.  You can decide for yourself with this option.</strong></br></div>
		<ul class="checklist">
			<li>
				<input id="g_email_not_options" name="g_email_not_options" value="1" type="checkbox" <? if ($email_notification == 1) echo "checked"; ?>>
				<a href="javascript:void(0);" id="todftp"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                <label for="g_email_not_options">Enable Email Notifications</label>
                <a class="checkbox-select" href="#">Select</a>
                <a class="checkbox-deselect" href="#">Cancel</a>
          	</li>
		</ul>
		<div class='gis-content padding-rl-20 width-465' style="display:none" id="todftp-desc">When this option is activated automatic emails will be sent when a product is purchased based upon the options set in each product setup.  Upon activation of this option there will be additional options to configure the email notifications.</div>
		<div id="email_div" style="display:none">
			<table>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
					<ul class="checklist">
						<li>
							<input id="Owner_Notify" name="Owner_Notify" value="1" type="checkbox" <? if ($email_notification_Owner == "1") echo "checked"; ?>>
							<a href="javascript:void(0);" id="ownernotify"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    		<label for="Owner_Notify">Site Owner Notify Email</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
					<div class='gis-content padding-rl-20 width-465' style="display:none" id="ownernotify-desc">This option will enable owner notification via email.</div>
				</td></tr>
				<tr><td></td><td colspan="3">
				<div id="owner_div" style="display:none">
					<table>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<ul class="checklist">
								<li>
									<input id="Owner_EverySale" name="Owner_EverySale" value="1" type="checkbox" <? if ($email_notification_Owner_Every_Sale == "1") echo "checked"; ?>>
									<a href="javascript:void(0);" id="ownereverysale"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    				<label for="Owner_EverySale">Notify Owner On Every Sale</label>
                    				<a class="checkbox-select" href="#">Select</a>
                    				<a class="checkbox-deselect" href="#">Cancel</a>
                    			</li>
							</ul>
							<div class='gis-content padding-rl-20 width-465' style="display:none" id="ownereverysale-desc">When this option is select an email will be sent to the owner on every sale, not just the ones they are receiving commission on.</div>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							Owner Email Text:<br>
							<textarea id="elm1" name="elm1">
							<?= $email_notification_Owner_Every_Sale_text; ?>
							</textarea>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<ul class="checklist">
								<li>
									<input id="Owner_Refunds" name="Owner_Refunds" value="1" type="checkbox" <? if ($email_notification_Owner_refund == "1") echo "checked"; ?>>
									<a href="javascript:void(0);" id="ownerrefunds"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    				<label for="Owner_Refunds">Notify Owner On Refunds</label>
                    				<a class="checkbox-select" href="#">Select</a>
                    				<a class="checkbox-deselect" href="#">Cancel</a>
                    			</li>
							</ul>
							<div class='gis-content padding-rl-20 width-465' style="display:none" id="ownerrefunds-desc">When this option is select an email will be sent to the owner on a refund.</div>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<div id="owner_refund_email">
								Owner Refund Email Text:<br>
								<textarea id="elm2" name="elm2">
								<?= $email_notification_Owner_refund_text; ?>
								</textarea>
							</div>
						</td></tr>
					</table>
				</div>
				</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
					<ul class="checklist">
						<li>
							<input id="Affiliate_Notify" name="Affiliate_Notify" value="1" type="checkbox" <? if ($email_notification_Affiliate == "1") echo "checked"; ?>>
							<a href="javascript:void(0);" id="affiliatenotifyi"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    		<label for="Affiliate_Notify">Affiliate Notify Email</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
					<div class='gis-content padding-rl-20 width-465' style="display:none" id="affiliatenotifyi-desc">This option enable email notifications the affiliate when they make a sale.</div>
				</td></tr>
				<tr><td></td><td colspan="3">
				<div id="affiliate_div" style="display:none">
					<table>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<ul class="checklist">
								<li>
									<input id="Affiliate_EverySale" name="Affiliate_EverySale" value="1" type="checkbox" <? if ($email_notification_Affiliate_Every_Sale == "1") echo "checked"; ?>>
									<a href="javascript:void(0);" id="affiliateeverysale"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    				<label for="Affiliate_EverySale">Notify Affiliate On Every Sale</label>
                    				<a class="checkbox-select" href="#">Select</a>
                    				<a class="checkbox-deselect" href="#">Cancel</a>
                    			</li>
							</ul>
							<div class='gis-content padding-rl-20 width-465' style="display:none" id="affiliateeverysale-desc">When this option is select an email will be sent to the affiliate on every sale referred by them, not just the ones they are receiving commission on.</div>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<ul class="checklist">
								<li>
									<input id="Affiliate_2Tier" name="Affiliate_2Tier" value="1" type="checkbox" <? if ($email_notification_Affiliate_Tier2_Sale == "1") echo "checked"; ?>>
									<a href="javascript:void(0);" id="affiliate2tier"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    				<label for="Affiliate_2Tier">Notify Affiliate On 2nd Tier Sales</label>
                    				<a class="checkbox-select" href="#">Select</a>
                    				<a class="checkbox-deselect" href="#">Cancel</a>
                    			</li>
							</ul>
							<div class='gis-content padding-rl-20 width-465' style="display:none" id="affiliate2tier-desc">When this option is select an email will be sent to the affiliate on 2nd tier sales.</div>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							Affiliate Sale Email Text:<br>
							<textarea id="aelm1" name="aelm1">
							<?= $email_notification_Affiliate_Every_Sale_text; ?>
							</textarea>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<ul class="checklist">
								<li>
									<input id="Affiliate_Refunds" name="Affiliate_Refunds" value="1" type="checkbox" <? if ($email_notification_Affiliate_refund == "1") echo "checked"; ?>>
									<a href="javascript:void(0);" id="affiliaterefunds"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    				<label for="Affiliate_Refunds">Notify Affiliate On Refunds</label>
                    				<a class="checkbox-select" href="#">Select</a>
                    				<a class="checkbox-deselect" href="#">Cancel</a>
                    			</li>
							</ul>
							<div class='gis-content padding-rl-20 width-465' style="display:none" id="affiliaterefunds-desc">When this option is select an email will be sent to the affiliate on a refund.</div>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<div id="affiliate_refund_email">
								Affiliate Refund Email Text:<br>
								<textarea id="aelm2" name="aelm2">
								<?= $email_notification_Affiliate_refund_text; ?>
								</textarea>
							</div>
						</td></tr>
					</table>
				</div>
				</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
					<ul class="checklist">
						<li>
							<input id="JV_Notify" name="JV_Notify" value="1" type="checkbox" <? if ($email_notification_JV == "1") echo "checked"; ?>>
							<a href="javascript:void(0);" id="jvnotify"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    		<label for="JV_Notify">JV Notify Email</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
					<div class='gis-content padding-rl-20 width-465' style="display:none" id="jvnotify-desc">This option when activated will notify your JV partners when a sale is made.</div>
				</td></tr>
				<tr><td></td><td colspan="3">
				<div id="jv_div" style="display:none">
					<table>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<ul class="checklist">
								<li>
									<input id="jv_EverySale" name="jv_EverySale" value="1" type="checkbox" <? if ($email_notification_JV_Every_Sale == "1") echo "checked"; ?>>
									<a href="javascript:void(0);" id="jveverysale"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    				<label for="jv_EverySale">Notify JV On Every Sale</label>
                    				<a class="checkbox-select" href="#">Select</a>
                    				<a class="checkbox-deselect" href="#">Cancel</a>
                    			</li>
							</ul>
							<div class='gis-content padding-rl-20 width-465' style="display:none" id="jveverysale-desc">When this option is selected an email will be sent to the JV on every sale, not just the ones they are receiving commission on.</div>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<ul class="checklist">
								<li>
									<input id="jv_2Tier" name="jv_2Tier" value="1" type="checkbox" <? if ($email_notification_JV_Tier2_Sale == "1") echo "checked"; ?>>
									<a href="javascript:void(0);" id="jv2tier"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    				<label for="jv_2Tier">Notify JV On 2nd Tier Sales</label>
                    				<a class="checkbox-select" href="#">Select</a>
                    				<a class="checkbox-deselect" href="#">Cancel</a>
                    			</li>
							</ul>
							<div class='gis-content padding-rl-20 width-465' style="display:none" id="jv2tier-desc">When this option is selected an email will be sent to the JV on 2nd tier sales.</div>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							JV Sales Email Text:<br>
							<textarea id="jelm1" name="jelm1">
							<?= $email_notification_JV_Every_Sale_text;?>
							</textarea>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<ul class="checklist">
								<li>
									<input id="jv_Refunds" name="jv_Refunds" value="1" type="checkbox" <? if ($email_notification_JV_refund == "1") echo "checked"; ?>>
									<a href="javascript:void(0);" id="jvrefunds"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    				<label for="jv_Refunds">Notify JV On Refunds</label>
                    				<a class="checkbox-select" href="#">Select</a>
                    				<a class="checkbox-deselect" href="#">Cancel</a>
                    			</li>
							</ul>
							<div class='gis-content padding-rl-20 width-465' style="display:none" id="jvrefunds-desc">When this option is selected an email will be sent to the JV on a refund.</div>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<div id="jv_refund_email">
								JV Refund Email Text:<br>
								<textarea id="jelm2" name="jelm2">
								<?= $email_notification_JV_refund_text; ?>
								</textarea>
							</div>
						</td></tr>
					</table>
				</div>
				</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
					<ul class="checklist">
						<li>
							<input id="Equity_Notify" name="Equity_Notify" value="1" type="checkbox" <? if ($email_notification_EP == "1") echo "checked"; ?>>
							<a href="javascript:void(0);" id="logserveri"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    		<label for="Equity_Notify">Equity Partner(s) Notify Email</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
					<div class='gis-content padding-rl-20 width-465' style="display:none" id="logserveri-desc">This option when activated will notify your Equity partners when a sale is made.</div>
				</td></tr>
				<tr><td></td><td colspan="3">
				<div id="equity_div" style="display:none">
					<table>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<ul class="checklist">
								<li>
									<input id="Equity_EverySale" name="Equity_EverySale" value="1" type="checkbox" <? if ($email_notification_EP_Every_Sale == "1") echo "checked"; ?>>
									<a href="javascript:void(0);" id="equityeverysale"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    				<label for="Equity_EverySale">Notify Equity Partner(s) On Every Sale</label>
                    				<a class="checkbox-select" href="#">Select</a>
                    				<a class="checkbox-deselect" href="#">Cancel</a>
                    			</li>
							</ul>
							<div class='gis-content padding-rl-20 width-465' style="display:none" id="equityeverysale-desc">When this option is selected an email will be sent to the equity partner on every sale, not just the ones they are receiving commission on.</div>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							Equity Partner Sale Email Text:<br>
							<textarea id="eelm1" name="eelm1">
							<?= $email_notification_EP_Every_Sale_text; ?>
							</textarea>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<ul class="checklist">
								<li>
									<input id="Equity_Refunds" name="Equity_Refunds" value="1" type="checkbox" <? if ($email_notification_EP_refund == "1") echo "checked"; ?>>
									<a href="javascript:void(0);" id="equityrefunds"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    				<label for="Equity_Refunds">Notify Equity Partner(s) On Refunds</label>
                    				<a class="checkbox-select" href="#">Select</a>
                    				<a class="checkbox-deselect" href="#">Cancel</a>
                    			</li>
							</ul>
							<div class='gis-content padding-rl-20 width-465' style="display:none" id="equityrefunds-desc">When this option is selected an email will be sent to the equity partner(s) on a refund.</div>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="3">
							<div id="equity_refund_email">
								Equity Partner Refund Email Text:<br>
								<textarea id="eelm2" name="eelm2">
								<?= $email_notification_EP_refund_text; ?>
								</textarea>
							</div>
						</td></tr>
					</table>
				</div>
				</td></tr>
			</table>
		</div> <!-- End of email_div -->

		<p>&nbsp;</p>
	</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td align="right">
		<input type="button" name="submit" id="submit" value="Save" onClick="javascript:aSave();"/>
		</form>
	</td><td align="right"></td></tr>
 </table>
</td></tr>
</table>


<script type='text/javascript'>
jQuery(document).ready(function() {

	jQuery.post("addons/GIS/raptools/robotslist.php", {  },
			function(data){
				jQuery('#block_manual_div').html(data);
		  	}
		);

	jQuery.post("addons/GIS/raptools/sitemaplist.php", {  },
			function(data){
				jQuery('#sitemap_div').html(data);
		  	}
		);
	
	
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

	jQuery("#blockrapadmin").click(function() {
		
		jQuery("#blockrapadmin-desc").toggle();

	});

	jQuery("#blockproducttemplates").click(function() {
		
		jQuery("#blockproducttemplates-desc").toggle();

	});

	jQuery("#blockdownloads").click(function() {
		
		jQuery("#blockdownloads-desc").toggle();

	});

	jQuery("#blockmanual").click(function() {
		
		jQuery("#blockmanual-desc").toggle();

	});

	jQuery("#ipism").click(function() {
		
		jQuery("#ipism-desc").toggle();

	});	

	jQuery("#rssi").click(function() {
		
		jQuery("#rssi-desc").toggle();

	});	

	jQuery("#rssfeedi").click(function() {
		
		jQuery("#rssfeedi-desc").toggle();

	});	

	jQuery("#rsspreposti").click(function() {
		
		jQuery("#rsspreposti-desc").toggle();

	});	

	jQuery("#todftp").click(function() {
		
		jQuery("#todftp-desc").toggle();

	});			

	jQuery("#ownernotify").click(function() {
		
		jQuery("#ownernotify-desc").toggle();

	});		

	jQuery("#ownereverysale").click(function() {
		
		jQuery("#ownereverysale-desc").toggle();

	});	

	jQuery("#ownerrefunds").click(function() {
		
		jQuery("#ownerrefunds-desc").toggle();

	});	

	jQuery("#affiliatenotifyi").click(function() {
		
		jQuery("#affiliatenotifyi-desc").toggle();

	});	

	jQuery("#affiliateeverysale").click(function() {
		
		jQuery("#affiliateeverysale-desc").toggle();

	});			

	jQuery("#affiliate2tier").click(function() {
		
		jQuery("#affiliate2tier-desc").toggle();

	});	

	jQuery("#affiliaterefunds").click(function() {
		
		jQuery("#affiliaterefunds-desc").toggle();

	});	

	jQuery("#logserveri").click(function() {
		
		jQuery("#logserveri-desc").toggle();

	});	

	jQuery("#jveverysale").click(function() {
		
		jQuery("#jveverysale-desc").toggle();

	});			

	jQuery("#jv2tier").click(function() {
		
		jQuery("#jv2tier-desc").toggle();

	});		

	jQuery("#jvrefunds").click(function() {
		
		jQuery("#jvrefunds-desc").toggle();

	});	

	jQuery("#jvnotify").click(function() {
		
		jQuery("#jvnotify-desc").toggle();

	});	

	jQuery("#equityeverysale").click(function() {
		
		jQuery("#equityeverysale-desc").toggle();

	});	

	jQuery("#equityrefunds").click(function() {
		
		jQuery("#equityrefunds-desc").toggle();

	});
});

</script>