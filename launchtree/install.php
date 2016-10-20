<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright �2008 Rapid Action Profits. All Rights Reserved
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
| Rapid Action Profits Multi-Download Extension
| ================================================================
+---------------------------------------------------------------------
*/

$title="Launchtree";
$description="Creates an Upsell / Downsell Path";
$folders=explode("/",$_GET['path']);
$groupfolder=$folders[0];
$addonfolder=$folders[1];

?>
<td align=center>
	<table align=center cellpadding=3 cellspacing=0>
		<tr align=center><td colspan=2><h2>Installing <?=$title?> Addon</h2></td></tr>
		<?php
			/* Create any additional tables needed in the mySQL database for this Addon */
			/* ___________ Table structure for RAP_mde ________________________ */
			
//			@mysql_query("CREATE TABLE IF NOT EXISTS `RAPmde_layout` (`id` int(11) NOT NULL auto_increment, PRIMARY KEY (`id`))");
//			@mysql_query("ALTER TABLE `RAPmde_layout` ADD `productID` int(11) NOT NULL default '0'");
//			@mysql_query("ALTER TABLE `RAPmde_layout` ADD `otoflag` BINARY NOT NULL DEFAULT '0'"); 
//			@mysql_query("ALTER TABLE `RAPmde_layout` ADD `width` varchar(5) NOT NULL default '95%'");
//			@mysql_query("ALTER TABLE `RAPmde_layout` ADD `rpp` int(3) NOT NULL default '10'");
//			@mysql_query("ALTER TABLE `RAPmde_layout` ADD `color1` varchar(7) NOT NULL default '#efefef'");
//			@mysql_query("ALTER TABLE `RAPmde_layout` ADD `color2` varchar(7) NOT NULL default '#ffffff'");

		?>
		<tr align=center>
			<td align=right><div align="center">
				<img src="tick.jpg" width="15" height="15" /></div></td>
			<td align=left nowrap="nowrap">
				<font size="2" face="Verdana, Arial, Helvetica, sans-serif">RAPmde_layout - Table Added</font></td>
		</tr>
		<?php


//			@mysql_query("CREATE TABLE IF NOT EXISTS `RAPmde_files` (`id` int(11) NOT NULL auto_increment, PRIMARY KEY (`id`))");
//			@mysql_query("ALTER TABLE `RAPmde_files` ADD `productID` int(11) NOT NULL default '0'");
//			@mysql_query("ALTER TABLE `RAPmde_files` ADD `otoflag` BINARY NOT NULL DEFAULT '0'"); 
//			@mysql_query("ALTER TABLE `RAPmde_files` ADD `item_download` varchar(200) NOT NULL default ''");
//			@mysql_query("ALTER TABLE `RAPmde_files` ADD `oto_download` varchar(200) NOT NULL default ''");
			
			/*_________________________________________________________________________*/
		?>
		<tr align=center>
			<td align=right><div align="center">
				<img src="tick.jpg" width="15" height="15" /></div></td>
			<td align=left nowrap="nowrap">
				<font size="2" face="Verdana, Arial, Helvetica, sans-serif">RAPmde_files - Table Added</font></td>
		</tr>
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