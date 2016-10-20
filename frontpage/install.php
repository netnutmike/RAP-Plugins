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
| RAP-tools Frontpage for RAP
| ================================================================
+--------------------------------------------------------------------------
*/

$title="Frontpage";
$description="A Flexible Frontpage for your RAP site.";
$folders=explode("/",$_GET['path']);
$groupfolder=$folders[0];
$addonfolder=$folders[1];

?>
<td align=center>
	<table align=center cellpadding=3 cellspacing=0>
		<tr><td colspan=2><font style="font-size: 22px;" color="gray" face=tahoma >
				<br><br><b>Installing <?=$title?> Addon</b></font><br><br>&nbsp;</td></tr>
		<tr ><td colspan=2><font style="font-size: 18px;" color="gray" face=tahoma >Creating Frontpage Tables...
		<?php
			/* Create any additional tables needed in the mySQL database for this Addon */
			/* ___________ Table structure for RAP_mde ________________________ */
			$querystr = "Create table if not exists g_FPModules (uid int auto_increment, Name varchar(50), Type varchar(50), CustomCode text, primary key(uid))";
			@mysql_query($querystr);
			
			$querystr = "Create table if not exists g_FPSections (uid int auto_increment, SectionName varchar(25), primary key(uid))";
			@mysql_query($querystr);
			
			$querystr = "Create table if not exists g_FPSectionModules (uid int auto_increment, SectionID int, ModuleID int, Orderid int, Options text, primary key(uid))";
			@mysql_query($querystr);
			
			$querystr = "Create table if not exists g_FPCategories (uid int auto_increment, CategoryName varchar(50), primary key(uid))";
			@mysql_query($querystr);
			
			$querystr = "Create table if not exists g_FPCategoryMembers (uid int auto_increment, CategoryID int, productID int, primary key(uid))";
			@mysql_query($querystr);	

			$querystr = "Create table if not exists g_FPAdGroups (uid int auto_increment, GroupName varchar(50), AdSize varchar(15), primary key(uid))";
			@mysql_query($querystr);

			$querystr = "Create table if not exists g_FPAds (uid int auto_increment, GroupID int, AdName varchar(50), AdImageURL varchar(50), AdDestinationURL varchar(250), DestinationType int, primary key(uid))";
			@mysql_query($querystr);			
			
		?>
		<b>...Done...</b></font></td></tr>
		
<?		$querystr = "select * from g_FPModules";
			$modrs = mysql_query($querystr);
			if (mysql_num_rows($modrs) == 0) {
?>
		<tr ><td colspan=2><font style="font-size: 18px;" color="gray" face=tahoma >Inserting default modules...
		<?php
			/* if there are no records in the table (new table) insert the default module definitions*/
			
			
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Adsense Ad','1','Adsense ID=x|Ad Width=N|Ad Height=N|Title=x')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Adbright Ad','2','AdBright ID=x|Title=x')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Custom','999','')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Top Grossing Products','3','Limit=N|ListType=T|Days=N|Title=x')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Top Moving Products','4','Limit=N|ListType=T|Days=N|Title=x')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Products By Search','5','Limit=N|ListType=T|Title=x')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Most Popular Products','6','Limit=N|ListType=T|Days=N|Title=x')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Search','7','Title=x')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Category List','8','Title=x')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Product Category','9','Category=C|ListType=T|Title=x')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Products By Keyword','10','Keywords=x|ListType=T|Title=x')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Product Showcase','11','Product=P|Title=x|ListType=T')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Random Product','12','Title=x|ListType=T')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('PayDotCom','13','Username=x|Categories=x')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Clickbank','14','ID=x')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('Product Price Range','15','Minimum=N|Maximum=N|ListType=T|Title=x')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPModules (Name, Type, CustomCode) VALUES ('New Products','16','Maximum Sales=N|Limit=N|ListType=T|Title=x')";
				@mysql_query($querystr);
			
		?>
		<b>...Done...</b></font></td></tr>
		<?php } ?>
		
		<?		$querystr = "select * from g_FPSections";
			$modrs = mysql_query($querystr);
			if (mysql_num_rows($modrs) == 0) {
?>
		<tr ><td colspan=2><font style="font-size: 18px;" color="gray" face=tahoma >Inserting default sections...
		<?php
			/* if there are no records in teh table (new table) insert the default module definitions*/
			
			
				$querystr = "insert into g_FPSections (SectionName) VALUES ('TOP')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPSections (SectionName) VALUES ('BOTTOM')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPSections (SectionName) VALUES ('LEFT')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPSections (SectionName) VALUES ('CENTERTOP')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPSections (SectionName) VALUES ('WELCOME')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPSections (SectionName) VALUES ('CENTER')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPSections (SectionName) VALUES ('SEARCH')";
				@mysql_query($querystr);
			
				$querystr = "insert into g_FPSections (SectionName) VALUES ('COPYRIGHT')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPSections (SectionName) VALUES ('MAIN')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPSections (SectionName) VALUES ('RIGHT')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPSections (SectionName) VALUES ('EXTRA1')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPSections (SectionName) VALUES ('EXTRA2')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPSections (SectionName) VALUES ('EXTRA3')";
				@mysql_query($querystr);
				
				$querystr = "insert into g_FPSections (SectionName) VALUES ('EXTRA4')";
				@mysql_query($querystr);
			
			
		?>
		<b>...Done...</b></font></td></tr>
		<?php } ?>
		
		<?		$querystr = "select * from g_FPCategories";
			$modrs = mysql_query($querystr);
			if (mysql_num_rows($modrs) == 0) {
?>
		<tr ><td colspan=2><font style="font-size: 18px;" color="gray" face=tahoma >Inserting default Categories...
		<?php
			/* if there are no records in the table (new table) insert the default module definitions*/
			
			
				$querystr = "insert into g_FPCategories (CategoryName) VALUES ('Random Products')";
				@mysql_query($querystr);
			
		?>
		<b>...Done...</b></font></td></tr>
		<?php } ?>
		
	<?		$querystr = "select * from g_FPAdGroups";
			$modrs = mysql_query($querystr);
			if (mysql_num_rows($modrs) == 0) {
?>
		<tr ><td colspan=2><font style="font-size: 18px;" color="gray" face=tahoma >Inserting default Ad Groups...
		<?php
			/* if there are no records in the table (new table) insert the default module definitions*/
			
			
				$querystr = "insert into g_FPAdGroups (GroupName) VALUES ('Default')";
				@mysql_query($querystr);
			
		?>
		<b>...Done...</b></font></td></tr>
		<?php } ?>
		
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
        		<br><font style="font-size: 18px;"><strong><?=$title?> Installed!</strong></font><img src="/rap_admin/addons/GIS/themes/images/info48x48.png" align="right">
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