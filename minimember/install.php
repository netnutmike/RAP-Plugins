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

$title="Mini-Member";
$description="Mini-Member";
$folders=explode("/",$_GET['path']);
$groupfolder=$folders[0];
$addonfolder=$folders[1];

?>
<td align=center>
	<table align=center cellpadding=3 cellspacing=0>
		<tr><td colspan=2><font style="font-size: 22px;" color="gray" face=tahoma >
				<br><br><b>Installing <?=$title?> Addon</b></font><br><br>&nbsp;</td></tr>
		<tr ><td colspan=2><font style="font-size: 18px;" color="gray" face=tahoma >Creating Mini-Member Tables...
		<?php
			/* Create any additional tables needed in the mySQL database for this Addon */
			/* ___________ Table structure for RAP_mde ________________________ */
			$querystr = "Create table if not exists g_MemberOptions (uid int auto_increment, optionCode varchar(25), intVal int, charVal varchar(250), primary key(uid))";
			@mysql_query($querystr);
			
			$querystr = "Create table if not exists g_Members (uid int auto_increment, email varchar(250), password varchar(50), createdDate varchar(20), lastLogin varchar(20), secretQuestion varchar(255), secretAnswer varchar(50), fullName varchar(100), Nickname varchar(100), Affiliate varchar(250), Address1 varchar(100), Address2 varchar(100), City varchar(50), State varchar(50), Zip varchar(50), BusinessName varchar(100), Phone1 varchar(20), Phone2 varchar(20), WebAddress varchar(250), Bio text, primary key(uid))";
			@mysql_query($querystr);
			
			$querystr = "Create table if not exists g_Memberships (uid int auto_increment, txn_id varchar(30), dateStart varchar(12), dateEnd varchar(12), lastBilled varchar(12), total float, paymentProcessor varchar(50), status int, primary key(uid))";
			@mysql_query($querystr);
			
			$querystr = "Create table if not exists g_MembershipTransactions (uid int auto_increment, membershipID int, txn_id varchar(30), date varchar(20), email varchar(20), amount float, primary key(uid))";
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
        		<br><font style="font-size: 18px;"><strong><?=$title?> Installed!</strong></font><img src="/rap_admin/addons/GIS/minimember/images/info48x48.png" align="right">
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