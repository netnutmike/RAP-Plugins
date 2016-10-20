<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright ©2010 Genius Idea Studio, LLC. All Rights Reserved
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
| RAP-tools Deal-a-Day
| ================================================================
+--------------------------------------------------------------------------
*/

$title="Deal-a-Day";
$description="A Deal-a-Day for RAP";
$folders=explode("/",$_GET['path']);
$groupfolder=$folders[0];
$addonfolder=$folders[1];

?>
<td align=center>
	<table align=center cellpadding=3 cellspacing=0>
		<tr><td colspan=2><font style="font-size: 22px;" color="gray" face=tahoma >
				<br><br><b>Installing <?=$title?> Addon</b></font><br><br>&nbsp;</td></tr>
		<tr ><td colspan=2><font style="font-size: 18px;" color="gray" face=tahoma >Creating Add To Cart Tables...
		<?php
			/* Create any additional tables needed in the mySQL database for this Addon */
			/* ___________ Table structure for RAP_mde ________________________ */
			$querystr = "Create table if not exists g_dealaDay (uid int auto_increment, productID int, Title varchar(200), ProductName varchar(200), Date varchar(10), MaxQuantity int, Price decimal(7,2), Shipping decimal(7,2), RetailPrice decimal(7,2), Gifting int, GiftingCost decimal(7,2), Condition varchar(250), PaymentEmail varchar(250), Percentage tinyint(3), AllowRerun int, DateLastRun varchar(10), SalesDescription text, Details text, ProductOwner int, Image1 varchar(250), Image2 varchar(250), ThumbImage varchar(250), GetPhysicalAddress int, CopiesPurchased int, ViewCount int, ClickCount int, status int, options text, template varchar(50), soldoutTemplate varchar(25), CopiesLeftText varchar(100), MaxQuantity int, FirstPurchaseTime varchar(20), FirstPurchaseUser int, MinutesToFirstSale int, primary key(uid))";
			@mysql_query($querystr);
			
			$querystr = "Create table if not exists g_dealaDayOptions (uid int auto_increment, productID int, RunOnDays varchar(7), StartTime varchar(4), RunHours int, CountdownStyle int, CopiesStyle int, DirectoryActive int, primary key(uid))";
			@mysql_query($querystr);
			
			$querystr = "Create table if not exists g_statsTracker ((uid int auto_increment, Date varchar(8), Time varchar(6), PID int, Affiliate varchar(50), Page varchar(50), Referrer text, IPAddress varchar(100), Returning int, Tracking varchar(200), Type int, Disposition int, DayOfWeek int, Hour int, RetailPrice decimal(7,2), SoldPrice decimal(7,2), Savings decimal(7,2), Quantity int, primary key(uid))";
			@mysql_query($querystr);
			
		?>
		<b>...Done...</b></font></td></tr>
		
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
		<tr><td><div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        		<br><font style="font-size: 18px;"><strong><?=$title?> Installed!</strong></font><img src="/rap_admin/addons/GIS/addtocart/images/info48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		The Addon <?=$title?> has been installed.  You can start using it immediately by clicking on the "Go To <?=$title?> Admin below.
        		</i><br>&nbsp;
    		</div> 
		</div>
		<br></td>
			
		</tr>
		<form method=post action="<?=$_SERVER[PHP_SELF]?>?action=addon&id=<?=$id?>">
		<tr align=center>
			<td colspan=2 align=center>
				<input type=submit name="submit" value="Go to <?=$title?> Admin">
			</td>
		</tr>
		</form>
	</table>
</td>