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
| RAP-tools Themes for RAP
| ================================================================
+--------------------------------------------------------------------------
*/

$title="Auto Opt-in";
$description="Expand Your Auto Opt-in Options In RAP";
$folders=explode("/",$_GET['path']);
$groupfolder=$folders[0];
$addonfolder=$folders[1];

?>
<td align=center>
	<table align=center cellpadding=3 cellspacing=0>
		<tr><td colspan=2><font style="font-size: 22px;" color="gray" face=tahoma >
				<br><br><b>Installing <?=$title?> Addon</b></font><br><br>&nbsp;</td></tr>
		<tr ><td colspan=2><font style="font-size: 18px;" color="gray" face=tahoma >Creating Auto Opt-in Tables...
		<?php
			/* Create any additional tables needed in the mySQL database for this Addon */
			/* ___________ Table structure for RAP_mde ________________________ */
			$querystr = "Create table if not exists g_autoResponderOptions (uid int auto_increment, productid int, status int, Name varchar(50), GroupCode varchar(15), optionText text, primary key(uid))";
			@mysql_query($querystr);
			
			$querystr = "Create table if not exists g_autoResponderGroups (uid int auto_increment, GroupName varchar(25), GroupCode varchar(15), primary key(uid))";
			@mysql_query($querystr);
			
			//insert the 4 default values
			$querystr = "insert into g_autoResponderGroups (GroupName, GroupCode) VALUES ('Front End Product', 'FE')";
			@mysql_query($querystr);
			
			$querystr = "insert into g_autoResponderGroups (GroupName, GroupCode) VALUES ('OTO Product', 'OTO')";
			@mysql_query($querystr);
			
			$querystr = "insert into g_autoResponderGroups (GroupName, GroupCode) VALUES ('Affiliate Signup', 'AFF')";
			@mysql_query($querystr);
			
			$querystr = "insert into g_autoResponderGroups (GroupName, GroupCode) VALUES ('JV Signup', 'JV')";
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
        		<br><font style="font-size: 18px;"><strong><?=$title?> Installed!</strong></font><img src="/rap_admin/addons/GIS/autooptin/images/info48x48.png" align="right">
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