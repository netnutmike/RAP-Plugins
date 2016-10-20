<?php 

	include('../rap_admin/settings.php');	
	
	if (trim($_COOKIE['ValidLogin']) == "") {
		//UserLogEntry($_COOKIE['ValidLogin'], LOG_AUTHENTICATION, "User sent to login window.  Possibly because of login timeout or not logging in first.", LOG_FIELD);
		header( 'Location: login.php');
	}
	
	$query = "SELECT * FROM g_Members where email='" . $_COOKIE['ValidLogin'] . "'";
	$request = mysql_query($query);
		
	//if (mysql_num_rows($request) > 0) {
	//	$rs = mysql_fetch_array($request);
	//	if ($rs['Status'] != '1')
	//		header( 'Location: /login.php');	
	//}
	
	
		
	$profileimage = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $_COOKIE['ValidLogin'] ) ) ) . "&d=mm";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html class="gecko win js" lang="en">
<head>

<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            
<title>Account Home</title>
<style type="text/css">
	.prodpop .themelabel {	font-size:18px;	margin:5px 0 0 10px; text-align: center; font-weight:bold;}
	.prodpop .themelabel a:link, .thumb .themelabel a:visited {	font-weight:normal;	color:#004C88;	text-align:center;}
	.popupProductDescription {	font-size:14px;	margin:5px 0 0 10px; text-align: left; font-weight:normal;}
	.popupSection {	font-size:12px;	margin:5px 0 0 10px; text-align: left; font-weight:bold;}
</style>


<link href="css/globals__user.css" media="screen" rel="stylesheet" type="text/css">
<link href="css/index__user.css" media="screen" rel="stylesheet" type="text/css">
   

	<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
	<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
	
	<?php $CustomerID=$rs['uid']; ?>
	<link rel="icon" type="image/png" href="/idaviico.png">	
</head>
<body>


<div id="bgBar"></div>





<div id="pageTitle" ><span valign="middle">&nbsp;&nbsp;<font size="+2">Customer Area</font></span></div>

<?php if (trim($msgtxt) != "") { ?>
<div id="globalAlerts">
    <!-- Global Alerts and Notifications go Here -->

  <div class="MUAW TeamUpdate">
    <h3><span class="left"><span class="icon warning-icn"> </span>Message Area</span> <a href="javascript:void(0);" class="close">[ close ]</a><br clear="all">
    </h3>
  <div class="contents"><br style="line-height: 4px;">
        <p><?php echo $msgtxt ?></p>
        <br style="line-height: 4px;">
    </div>
</div>
</div>

<?php } ?>

<div id="mainBody" class="layout2">

<div id="col1">
        <div class="dashboardModule" >
    <h2><span class="widget-title">My Purchases</span></h2>
    <div id="modFeed"><table class="tabularData"><tbody>
    <?php 
    $akws = "";
    $lastpurchase="";
    $pquery = "SELECT sales.*, products.uid as PID, products.item_name, products.item_number, products.install_folder, products.item_desc, products.keywords, " . 
    " FROM sales, products where products.id = sales.productID and payer_email='" . $rs['email'] . "' order by purchased DESC";
	$prequest = mysql_query($pquery);
		
	while ($prs = mysql_fetch_array($prequest)) {
		if ($lastpurchase == "")
			$lastpurchase = $prs['purchased'];
		
		if ($akws != "")
			$akws .= ",";
			
		$akws .= $prs['Keywords'];
		
    ?>
    
    <tr height="20" valign="top">
      <td ><?php echo substr($prs['purchased'],0,10) ?></td>
      <td class="subject" style="width: auto;"><a href=<?php echo $prs['install_folder'] ?>" id="plink<?php echo $prs['PID'] ?>">
      <?php echo $prs['ProductName']?></a>
      <script type="text/javascript">
		 new Ext.ToolTip({
       		target: 'plink<? echo $prs['uid'] ?>',
        	width: 400,
        	anchor: 'left',
        	autoLoad: {url: '/saleinfo.php?saleid=<?php echo $prs['uid'] ?>'},
        	dismissDelay: 15000 // auto hide after 15 seconds
    	});
	</script></td>
      <td ></td>
      <td height="20"><a href="http://twitter.com/share?data-url=http://idavi.com/?productid=<?php echo $prs['PID']?>&a=<?php echo $_COOKIE['aff']?>" data-text=<?php echo $prs['ProductName']?> class="twitter-share-button" data-count="horizontal" data-via="iDavillc"><img src="images/twitter_icon.jpg" width="18" height="18" /></a>&nbsp;
      <!-- <a href="#" OnClick="fbWindow(<?php echo $prs['PID'] ?>)"><img src="/images/fb.png" width="18" height="18" /></a><?php //echo "<fb:like href=\"http://idavi.com/?productid=" . $prs['uid'] . "\" layout=\"button_count\" show_faces=\"false\" width=\"100\" font=\"\"></fb:like>" ?> -->
      <g:plusone size="small" url="<?php echo $prs['install_folder'] ?>" count="false"></g:plusone></td>
      <td><a href="<?php echo $prs['install_folder'] ?>?>?action=download&id=<?php echo $prs['txn_id']?>" target="_blank"><img src="/images/download.png" width="18" height="18" /></a>&nbsp; 
      
      
      &nbsp;</td><td>$<?php echo $prs['payment_amount']?></td></tr>
    <?php } ?>
      </tbody></table>
    
    </div></div>   
    
</div>
<div id="col2">

    <div class="dashboardModule widget_team-teamroom">
      <h2><?php echo $rs['Name']?></h2>
      <div class="body"><table class="tabularData"><tbody><tr><td>&nbsp;</td><td><div align="right"><img alt="<?php echo $rs['Name'] . " (" . $profileemail . ")" ?>" src="<?php echo $profileimage ?>"></div></td></tr></tbody></table>
      <ul class="horizontalLinks alignRight"><li class="first last"></li>
        <li><a href="/account/login.php?authenticity_token=logout">Logout</a></li>
        <li><a href="#" onClick="PasswordChangeWindow();">Change Password</a></li>
        
      </ul>
      <br>Member Since: <?php echo substr($rs['DateAdded'],0,10)?><br />Last Purchase: <?php echo substr($lastpurchase,0,10) ?><br />
      </div>
    </div>    




<div class="clearb"></div>
</div>
</body></html>
