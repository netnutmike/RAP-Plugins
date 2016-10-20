<?php 

	include('../common.inc');
	include('../functions.php'); 

	if ($_POST['authenticity_token'] == "KG4us46gpY8iuhDuuS/bLPC1yQ/uwBw9SHHr8w93oKA=") {
	
		$query = "SELECT * FROM Customers where PaypalEmail='" . $_REQUEST['UserName'] . "'";
		$request = mysql_query($query);
		
		if (mysql_num_rows($request) > 0) {
			$rs = mysql_fetch_array($request);
			
			if ($rs['Password'] == md5($_REQUEST['UserPassword'])) {
				if ($rs['Status'] == '1') {
					setcookie("ValidLogin", $_REQUEST['UserName'], time() + 10800);
					setcookie("RealName", $rs['Name'], time() + (60*60*24*280), "/");
					setcookie("wli", $rs['uid'], time() + (60*60*24*280), "/");
					//setcookie("AffID", $rs['uid'], time() + 10800);
					$sessionstring = $rs['PaypalEmailAddress'] . $rs['Password'] . $rs['Name'] . $rs['ContactEmail'] . date('Ymdhis');
					$sessionid = md5($sessionstring);
					setcookie("SessionID", $sessionid, time() + 10800);
				
					if ($_REQUEST['RememberEmail'] == '1') {
						setcookie("RememberUserName", $_REQUEST['UserName'], (time() + (60*60*24*28)));
						setcookie("RememberEmail", $_REQUEST['RememberEmail'], (time() + (60*60*24*28)));
					} else {
						setcookie("RememberUserName", "", time() - 3600);
						setcookie("RememberEmail", "", time() - 3600);
					}
					
					$query = "update Customers set LastLogin='" . date("Y-m-d h:i:s") . "', CurrentSessionID='" . $sessionid . "', CurrentSessionIP='" . $_SERVER['REMOTE_ADDR'] . "' where PaypalEmail='" . $_REQUEST['UserName'] . "'";
					$request = mysql_query($query);
			
					header( 'Location: /account');
				} else if ($rs['Status'] == '0') {
					$msgtxt = "Your Account has been disabled, please contact customer support.";
					$msgtype = "error-box";
				}
			
			} else {
				$msgtxt = "Please Re-check your Password";
				$msgtype = "error-box";
			}
		} else {
				$msgtxt = "Invalid Username or Password";
				$msgtype = "error-box";
			}
		
	
	} else if (trim($_REQUEST['authenticity_token']) != "") {
	
		//sign out
		setcookie("ValidLogin", "", time() - 3600);
		
		$msgtxt = "Logout Successful!";
		$msgtype = "success-box";
	}
	


?>
<!DOCTYPE HTML>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
 
  
    <meta charset="utf-8">
    <meta name="author" content="iDavi">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <title>iDavi Account Info / Preferences - Login Required</title>
    
    <style type="text/css">
		.error-box {
			
			text-align: center;
    		background-color: #ffbbbb;
    		margin: 3px;
			font-family: Georgia;
			font-family: Arial;
			font-size: 14pt;
			word-spacing: -1px;
			letter-spacing: -1px;
			}
			
		.success-box {
			
			text-align: center;
    		background-color: #bbffbb;
    		margin: 3px;
			font-family: Georgia;
			font-family: Arial;
			font-size: 14pt;
			word-spacing: -1px;
			letter-spacing: -1px;
			}
			
		.DataRed {
			background-color: #FF8383;
			color: #000000;
		}

	</style>
	
<link href="login_files/login.css" media="screen" rel="stylesheet" type="text/css">
<link href="/css/styles.css" media="screen" rel="stylesheet" type="text/css">
    <title>iDavi - Customer Login</title>

    <!-- ** CSS ** -->
    <!-- base library -->
       
    <link rel="stylesheet" type="text/css" href="../ext/resources/css/ext-all.css" />
    

    <!-- overrides to base library -->
    <link rel="stylesheet" type="text/css" href="../ext/resources/css/xtheme-gray.css" />


	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js' type='text/javascript'></script>
	<script src="http://jqueryui.com/latest/ui/effects.core.js"></script>
	<script src="http://jqueryui.com/latest/ui/effects.pulsate.js"></script>   
	
   <!-- ExtJS library: base/adapter -->
    <script type="text/javascript" src="/ext/adapter/ext/ext-base.js"></script>

    <!-- ExtJS library: all widgets -->
    <script type="text/javascript" src="/ext/ext-all.js"></script>

	<script type="text/javascript" src="js/lostPassword.js"></script>
	<script type="text/javascript" src="js/setMeUp.js"></script>

<script language="JavaScript">

var loadingimage = '<img src="login_files/loading.gif" alt="" border="">';

function aLogin() {

	jQuery('#loginformrotate').html(loadingimage);
	
	//jQuery('#loginform').hide();
	jQuery('#infoarea').hide();
	
	document.getElementById('lgin').submit();
	
}
</script>
<link rel="icon" type="image/png" href="/idaviico.png">
</head>
<body class="login">
    <div id="wrapper">
      <div class="grid_8">
<div class="Content">
<div style="clear: both;"></div>
<div style="clear: both;"></div>

<p align="center"><h1><img alt="iDavi" src="/images/idavi-logo-medium.png"></h1></p>
<h1 class="ItemBoxTop StopTop" style="margin-top: 0px;"><b class="ItemLineHeight">Idavi Customer Login</b></h1>

<div class="ItemBox StopTop" id="infoarea"><div class="inner"><div id="message_container"><div id="msgtext" class="<?= $msgtype?>" style="width: 700px;">
        		<font style="font-size: 18px;"><?= $msgtxt?></font>
    		</div>
    	<?php if (trim($msgtxt) != "") { ?>
    	<script type="text/javascript">
			$('#message_container').fadeOut(25000);
		</script>
    	<?php } else {?>
    	<script type="text/javascript">
			$('#message_container').fadeOut(1);
		</script>
    	<?php } ?></div>
    	
    	<div style="float: left; width: 350px;">
<div id="loginform"><img src="/images/welcomeback.jpg" alt="Welcome Back">
      <form id="lgin" action="login.php" method="post"><div style="margin: 0pt; padding: 0pt; display: inline;"><input id="authenticity_token" name="authenticity_token" value="KG4us46gpY8iuhDuuS/bLPC1yQ/uwBw9SHHr8w93oKA=" type="hidden"></div>
  
  <p>
    <label for="eid">Email:</label>
    
    <input class="text" id="UserName" name="UserName" tabindex="1" type="text" value="<?= $_COOKIE['RememberUserName']?>">
  </p>
  <p>
    <label for="user_password">Password:</label>
    <input class="text" id="UserPassword" name="UserPassword" size="30" tabindex="2" type="password">
  </p>
  <p class="actions">
    <input class="chk" id="RememberEmail" name="RememberEmail" tabindex="3" value="1" type="checkbox" <?php if (trim($_COOKIE['RememberEmail']) != "") {echo CHECKED;}?>>
    <label for="RememberEmail">Remember Email Address</label>
    <p align="center">
    <input data-value="login" name="btn" tabindex="4" type="image" align="center" value="login" src="/images/signin.png" onClick="javascript:aLogin();"></p>
    <p align="center">
    <a href="#" onClick="javascript:LostPasswordWindow();">Uh-oh, I forgot something important</a></p>
  </p>
</form></div>
</div>
<div style="float: left; width: 350px;"><img src="/images/customernewhere.png" alt="register"><br>
<table width="90%" align="center"><tr><td>
<p align="center">If you have ever purchased anything through iDavi or any merchant that iDavi supports, then you already have an account.  You probably just need to set your password.  <br><br>Click the <b>Set Me Up</b> button below to get started.<br><br></p>
<p align="center"><input data-value="login" name="btn" tabindex="4" type="image" align="center" value="login" src="/images/setmeup.png" onClick="javascript:SetMeUpWindow();"></p><br></br>

</td></tr></table></div>
<div style="clear: both;">

</div> </div></div></div></div></div>

      <center>
 <div id="footer">
 <table width="600" align="center">
 
 <td class="footerHeader" width="20%">Products</td>
 <td class="footerHeader" width="20%">Affiliates</td>
 <td class="footerHeader" width="20%">About Idavi</td>
 <td class="footerHeader" width="20%">About You</td>
 <td class="footerHeader" width="20%">Customer Service</td>
 </tr>
 <tr>
 <td class="footerItems" width="20%"><a href="/?newest=1">New Products</a><br><a href="/?popular=1">Popular Products</a><br><a href="/?dotd=1">Deal Of The Day</a></td>
 <td class="footerItems" width="20%"><a href="/affiliates">Login</a><br><a href="/affiliates">Register</a><br><a href="http://info.idavi.com/index.php?option=com_content&view=category&id=10&Itemid=118" target="_blank">FAQ</a><br><a href="/affiliates/login.php#">Forgot Password</a><br><a href="http://info.idavi.com/index.php?option=com_content&view=article&id=37&Itemid=124" target="_blank">Sell Your Products</a><br><a href="/training" target="_blank">Training</a><br><a href="/feed">RSS Product Feed</a></td>
 <td class="footerItems" width="20%"><a href="http://info.idavi.com/index.php?option=com_content&view=article&id=1&Itemid=110" target="_blank">What is iDavi?</a><br><a href="http://info.idavi.com/index.php?option=com_content&view=article&id=6&Itemid=116" target="_blank">About Us</a><br><a href="http://info.idavi.com/index.php?option=com_content&view=category&id=11&Itemid=123" target="_blank">Merchant FAQ</a><br><a href="http://info.idavi.com/index.php?option=com_content&view=article&id=38:privacy-policy&catid=13:literature" target="_blank">Privacy Policy</a><br><a href="http://www.facebook.com/idavillc" target="_blank">Facebook</a><br><a href="http://info.idavi.com/index.php?option=com_content&view=category&layout=blog&id=14&Itemid=115" target="_blank">News</a><br><a href="http://info.idavi.com/index.php?option=com_content&view=category&layout=blog&id=12&Itemid=114" target="_blank">Blog</a></td>
 <td class="footerItems" width="20%"><a href="/account">Account / Preferences</a><br><a href="/account">Forgot Password</a><br></td>
 <td class="footerItems" width="20%"><A href="http://info.idavi.com/index.php?option=com_content&view=article&id=40:terms-of-service&catid=13:literature" target="_blank">Terms of Service</a><br><A href="http://info.idavi.com/index.php?option=com_content&view=article&id=6&Itemid=117" target="_blank">Contact Us</a><br><a href="http://info.idavi.com/index.php?option=com_content&view=article&id=39:refunds&catid=13:literature">Refunds</a></td>
 </tr></table>
<br><br>
 <table width = "600" align="center"><tr><td>
<p id="copyrightBar">
	Copyright © 2011 iDavi, LLC - 
	<a href="http://idavi.com/terms.php">  Terms </a> 
	 |  <a href="http://idavi.com/privacy.php">Privacy Policy</a> 
</p>
</td><td align="right"><font color="grey">Version <?= $version?>&nbsp;&nbsp;</font></td></tr></table>
 </div>          </center> 
      
 
    </div>
  </body></html>

