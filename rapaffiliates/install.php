<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright ©2009 Genius Idea Studio, LLC. All Rights Reserved
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
| RAP-tools Editor
| ================================================================
+--------------------------------------------------------------------------
*/

$title="Editor";
$description="Edit Your Template Files From Within the RAP Admin Panel";
$folders=explode("/",$_GET['path']);
$groupfolder=$folders[0];
$addonfolder=$folders[1];

?>
<td align=center>
	<table align=center cellpadding=3 cellspacing=0>
		<tr align=center><td colspan=2><h2>Installing <?=$title?> Addon</h2></td></tr>
		<tr align=center><td colspan=2><h2>Creating File Descriptions Table:
		<?php
			/* Create any additional tables needed in the mySQL database for this Addon */
			/* ___________ Table structure for RAP_mde ________________________ */
			$querystr = "Create table if not exists template_files (uid int auto_increment, filename varchar(100), description text, pid int, primary key(uid))";
			@mysql_query($querystr);
		?>
		...Done...</h2></td></tr>
		
		<tr align=center><td colspan=2><h2>Inserting File Descriptions:
		<?php
			/* Create any additional tables needed in the mySQL database for this Addon */
			/* ___________ Table structure for RAP_mde ________________________ */
			$querystr = "insert into template_files (filename, description, pid) VALUES ('header.html','This optional file is Automatically inserted before each of the other templates.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('footer.html','This optional file is Automatically inserted after each of the other templates.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('salespage.html','This is the first page shown to your visitor.  You can have one or more sales page files.  This one is the default included with the default RAP install.  This file can be renamed but if you are not using the slit testing feature there is no reason to copy or rename this file.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('order_button.html','This template provides just a table with the order link.  It is inserted into the sales page (if the product is not being given away) by the GetCallToAction token.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('comp_form.html','This template is automatically inserted into the sales page as dynamic content when a zero-dollar discount is used and will display a registration form to all the system to record the comp sale in the database.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('squeeze.html','The squeeze page is built into the cycle AFTER the order so that you collect the contact information of paying customers rather than tire kickers.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('download.html','The download.html file is the template for download of the front-end product.  Your customer will see this download page if you do not have a one-time offer or if they choose not to take you up on your one-time offer.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('presale.html','This template allows you to define an alternative landing page where you or your affiliates can offer some sort of pre-sales message or generate a lead.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('giveaway.html','See comp.html.  This file is being de-implemented')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('comp.html','This template is used if you have a product you want to give away to capture a lead.  This template is an alternative to your salespage.html template.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('soldout.html','This template is used to inform the customer that you have Sold Out of a product.  You sell out of a product when you set a maximum number of sales and reach that maximum number.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('zips.html','This template is used in countries that require the collection of your customers physical locations for tax purposes.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('taf.html','This is another version of the download.html template that has the tell-a-friend script built in.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('oto.html','This is the template for your One Time Offer (OTO) if you have one.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('otodownload.html','This is the template for downloading your OTO files.  It should include both the original file for download and the OTO download information.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('ototaf.html','This is like the otodownload template but also includes the tell-a-friend script.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('expired.html','This template is shown if someone clicks on an expired download link that was sent to them in an email.  It should include instructions on how to contact support.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('invalid.html','This template is shown to a customer if the link they are trying to download is not valid.  It should include instructions on how to contact support.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('goto_paypal.html','This template is shown to a customer during the transition to PayPal.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('from_paypal.html','This template is another PayPal transition page.  It continually looks to see if the paypal transaction has been completed.  If it times out the user is sent to the payment_timeout.html template.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('payment_timeout.html','This template is shown to a customer if the PayPal payment times out.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('subscriberoptions.html','This template is shown to a customer if they want to change their email subscription options or opt-out.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('confirm_optout.html','This template is shown to a customer to confirm that they have been opted-out of a mailing list.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('offline.html','This template is shown whenever you mark a product as disabled.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('affiliates.html','This template is shown to a customer interested in your affiliate program.  It should be <b>Selling</b> them on promoting your products.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('affiliatethanks.html','This template is the thank you page for someone who signs up to be your affiliate.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('partners.html','This template is similar to the affiliates.html template above but should be used to promote super affiliates or JV partners.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('partnerthanks.html','This template is the thank you page for someone who signs up to be your partner.','1234')";
			@mysql_query($querystr);
			$querystr = "insert into template_files (filename, description, pid) VALUES ('affcenter.html','This template is the main page when a reseller logs into your site to view their stats.','1234')";
			@mysql_query($querystr);			
			$querystr = "insert into template_files (filename, description, pid) VALUES ('affiliatetools.html','This template is to provide your affiliates and resellers the tools they need to sell your products.  It could be banner ads, text ads, emails, blog posts, tweets, etc.  You can be as creative as you want.','1234')";
			@mysql_query($querystr);			
			$querystr = "insert into template_files (filename, description, pid) VALUES ('affiliatethanks.html','This template is the thank you page for someone who signs up to be your affiliate.','1234')";
			@mysql_query($querystr);
		?>
		...Done...</h2></td></tr>
		
		<tr align=center><td colspan=2><h2>Creating tokens Table:
		<?php
			/* Create any additional tables needed in the mySQL database for this Addon */
			/* ___________ Table structure for RAP_mde ________________________ */
			$querystr = "Create table if not exists tokens (uid int NOT NULL auto_increment, company_id varchar(50), plugin varchar(50), tag varchar(250), description text, pages varchar(250), primary key(uid))";
			@mysql_query($querystr);
		?>
		...Done...</h2></td></tr>
		
		<tr align=center><td colspan=2><h2>Inserting File Descriptions:
		<?php
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_download_link(0)?>','','Places the secure download link for your front-end product')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_download_link(1)?>','','Places the secure download link for your OTO product')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_max_sales?>','','This token will display the maximum number of sales for the current product.  You only need this token if you are setting a limit and want to let your visitor know what that limit is.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_item_remaining?>','','If you are limiting the number of items that can be sold, this token will display the number of items that are remaining.  If you are not limiting the number of items sold then there is no need to use this token.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_item_name?>','','This token will insert the name of your current product.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_item_price?>','','Inserting this token will insert the price of the current product.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_item_pct?>','','This token will insert the percentage an affiliate will make with the current product.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_item_pct2?>','','This token will insert the percentage a 2nd tier affiliat will make with the current product.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_jv_item_pct?>','','This token will insert the percentage that a JV partner will make with the current product.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_jv_item_pct2?>','','This token will insert the percentage a 2nd tier JV partner will make with the current product.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<a href=\"index.php?action=order&dc=<?=$dc?>\">Order Here</a>','','Inserting this token will insert a hyperlink with the text: Order Here to place an order for the current product.  You can replace the Order Here text with anything you want including an image.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=getCallToAction()?>','','This token inserts either the order_button or comp_form templates depending onif the item is for sale or a giveaway.  This is used as a replacement for the older action=order token.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_oto_name?>','','This token inserts the OTO product name into the template.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_oto_price?>','','This token inserts the OTO price into the template.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_oto_pct?>','','This token inserts the standard commission rate for your OTO product.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_oto_pct2?>','','This token will insert the percentage a 2nd tier affiliat will make with the current product.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_jv_oto_pct?>','','This token will insert the percentage that a JV partner will make with the current product.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_jv_oto_pct2?>','','This token will insert the percentage a 2nd tier JV partner will make with the current product.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<a href=\"index.php?action=order&oto=1\">Order Here</a>','','This inserts the token to place an order for your One-time Offer.  Replace the Order Here text with your own text, images, etc.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<a href=\"index.php?action=declineoto\">No Thank You</a>>','','This inserts the token to place the decline OTO link.  When you insert the token the default text will be No Thank You.  Change that text to anything you want.  It can be text, image, etc.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=quickaffiliate()?>','','This token will insert a quick affiliate form that will allow the visitor to sign up to become an affiliate right there.  A good place to put this is on your download pages.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=refstats($_SESSION[nickname])?>','','This token is used in the affcenter template and will display the affiliates statistics graph')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=catalog($_SESSION[nickname])?>','','This token is used in the affcenter template and will display a catalog of your products.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','[ITEMNAME]','affiliatetools.html','This token is used in the affiliatetools.html template to show the current product name.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','[DOMAIN]','affiliatetools.html','This token is used in affiliatetools.html template to insert the domain name.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','[INSTALLFOLDER]','affiliatetools.html','This token is used in affiliatetools.html template to insert the install folder for the current product.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','[NICKNAME]','affiliatetools.html','This token is used in affiliatetools.html template to insert the nickname or name used by the affiliate to get credit for the sale.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_support?>','','This token inserts your anchor text for your support link.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_supportlink?>','','This token inserts your URL or mailto for placement in a hyperlink to your support address.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_jv_code?>','','This token inserts the secret code that is provided to potential JV partners.')";
			@mysql_query($querystr);
			$querystr = "insert into tokens (company_id, plugin, tag, pages, description) VALUES ('RAP','RAP','<?=\$sys_expire?>','','This token inserts the number of hours from the time of purchase that a download link will be valid.')";
			@mysql_query($querystr);
		?>
		...Done...</h2></td></tr>
		<?php
			/* ____________ Define your AddOn Module to Rapid Action Profits _________________ */
			
			$sql="SELECT id FROM addons
				WHERE title='$title'";
			$addres=@mysql_query($sql);
			$addrec=@mysql_fetch_assoc($addres);
			
			if ($addrec[id]=="")
			{
				$sql="INSERT INTO addons (title, description, groupfolder, addonfolder)
					VALUES('".$title."','".$description."','".$groupfolder."','".$addonfolder."')";
				@mysql_query($sql);
				$id=@mysql_insert_id();
			}
			
			/*_________________________________________________________________________*/
			
		?>
		<tr align=center>
			<td align=right><div align="center">
				<img src="tick.jpg" width="15" height="15" /></div></td>
			<td align=left nowrap="nowrap">
				<font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?=$title?> Installed!</font></td>
		</tr>
		<form method=post action="<?=$_SERVER[PHP_SELF]?>?action=addon&id=<?=$id?>">
		<tr align=center>
			<td colspan=2 align=center>
				<input type=submit name="submit" id="submit" value="Go to <?=$title?> Admin">
			</td>
		</tr>
		</form>
	</table>
</td>