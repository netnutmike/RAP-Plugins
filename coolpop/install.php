<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.1
| Copyright (c) 2009, 2010 Genius Idea Studio, LLC. All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Genius Idea Studio, LLC.
| regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script and hold harmless from any harm or damage
| Genius Idea Studio, LLC.   
|
| ================================================================
| RAP-tools Cool-Pop
| ================================================================
+--------------------------------------------------------------------------
*/

$title="Cool-Pop";
$description="Easy Pop-Overs in RAP";
$folders=explode("/",$_GET['path']);
$groupfolder=$folders[0];
$addonfolder=$folders[1];

?>
<td align=center>
	<table align=center cellpadding=3 cellspacing=0>
		<tr><td colspan=2><font style="font-size: 22px;" color="gray" face=tahoma >
				<br><br><b>Installing <?=$title?> Addon</b></font><br><br>&nbsp;</td></tr>
		<tr ><td colspan=2><font style="font-size: 18px;" color="gray" face=tahoma >Creating Cool-Pop Tables...
		<?php
			/* Create any additional tables needed in the mySQL database for this Addon */
			/* ___________ Table structure for RAP_mde ________________________ */
			$querystr = "CREATE TABLE IF NOT EXISTS `g_CoolPop` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `productID` int(11) DEFAULT NULL,
  `popOverType` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'o',
  `popOverID` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `initialPopup` text COLLATE utf8_unicode_ci,
  `continuePopup` text COLLATE utf8_unicode_ci,
  `offerText` text COLLATE utf8_unicode_ci,
  `initialDelay` int(11) DEFAULT '1',
  `width` int(11) DEFAULT '300',
  `height` int(11) DEFAULT '400',
  `x` int(11) DEFAULT '0',
  `y` int(11) DEFAULT '0',
  `position` int(11) DEFAULT NULL,
  `horAlign` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'c',
  `vertAlign` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'c',
  `redisplayDelay` int(11) DEFAULT '24',
  `redisplayUnit` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'h',
  `redisplayMaxCount` int(11) DEFAULT '2',
  `subsequentDelay` int(11) DEFAULT '1',
  `subsequentUnit` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'h',
  `askMeLaterText` varchar(250) COLLATE utf8_unicode_ci DEFAULT 'Remind Me',
  `noThanksText` varchar(250) COLLATE utf8_unicode_ci DEFAULT 'No Thank You',
  `butNoThanks` int(11) DEFAULT '0',
  `butAskLater` int(11) DEFAULT '0',
  `thankYouMessage` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `noThanksResponse` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `posBuffer` int(11) DEFAULT NULL,
  `cssoverride` text COLLATE utf8_unicode_ci,
  `stayAction` varchar(1) DEFAULT 'p',
  `forwardURL` varchar(250),
  `Status` int,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
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
				<input type=submit name="submit" value="Go to <?=$title?> Admin">
			</td>
		</tr>
		</form>
	</table>
</td>