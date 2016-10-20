<?
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright 2009, 2010 Genius Idea Studio, LLC,  All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Genius Idea
| Studio, LLC regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.   
|
| ================================================================
| rap-tools.com Tell A Friend Tab
| ================================================================
+---------------------------------------------------------------------
*/

session_start();

	$productID=$_SESSION[product];
	
	
function gTAFHeader() {
	
	global $sys_tmpl_folder, $sys_install_folder, $sys_item_price, $gpos, $gposTwitter;
	
	    $prpnd = "";
	do
	{
		if (!file_exists($prpnd . "rap_admin"))
			$prpnd .= "../";
			
	} while (!file_exists($prpnd . "rap_admin") || ++$emcnt < 9);
	
	$gimgURL = $prpnd . $sys_install_folder . "images/taftab.png";
	
	if ($gpos == "")
		$gpos = "100";
		
	if ($gposTwitter == "")
		$gposTwitter = "200";
	
	if (!file_exists($gimgURL)) {
		$gimgURL = $prpnd . "rap_admin/addons/GIS/taf/images/taftab.png";
		$gimgURLTweet = $prpnd . "rap_admin/addons/GIS/taf/images/tweettab.png";
	}
		
	echo "<style type=\"text/css\">
.taf-panel {
    padding:20px;
    width: 500px;
    border: #29216d 1px solid;
    background: inherit;
    position:absolute;
    top:" . $gpos . "px;
    left:-541px;
}
 
.taf-panel a.taf-tab {
    background:transparent url(" . $gimgURL . ") no-repeat scroll 0 0;
    border-width: 1px 1px 1px 0;
    display:block;
    height:99px;
    left:51px;
    bottom:21px;
    position:relative;
    float:right;
    text-indent:-9999px;
    width:30px;
    outline:none;
    zIndex: 5000;
}

.tweet-panel {
    padding:20px;
    width: 300px;
    border: #29216d 1px solid;
    background: inherit;
    position:absolute;
    top:" . $gposTwitter . "px;
    left:-341px;
}
 
.tweet-panel a.tweet-tab {
    background:transparent url(" . $gimgURLTweet . ") no-repeat scroll 0 0;
    border-width: 1px 1px 1px 0;
    display:block;
    height:99px;
    left:51px;
    bottom:21px;
    position:relative;
    float:right;
    text-indent:-9999px;
    width:30px;
    outline:none;
    zIndex: 5000;
}
 
textarea {
    width:90%;
    padding:5px;
}
 
#response-message {
    background: #ccc;
    border: 1px solid #999;
    padding:50px;
}
</style>

<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js' type='text/javascript'></script>

<script type='text/javascript'>
	jQuery.noConflict();
</script>

<script type='text/javascript'>
function rePos() {
	var ScrollTop = document.body.scrollTop;

	if (ScrollTop == 0)
		{
	    if (window.pageYOffset)
        	ScrollTop = window.pageYOffset;
	    else
	        ScrollTop = (document.body.parentElement) ? document.body.parentElement.scrollTop : 0;
		}
		
		ScrollTop = ScrollTop + " . $gpos . ";
		
		jQuery(\".taf-panel\").css( { 
                top: ScrollTop,
                zIndex: 5000
        } );
		
}

function rePosTweet() {
	var ScrollTop = document.body.scrollTop;

	if (ScrollTop == 0)
		{
	    if (window.pageYOffset)
        	ScrollTop = window.pageYOffset;
	    else
	        ScrollTop = (document.body.parentElement) ? document.body.parentElement.scrollTop : 0;
		}
		
		ScrollTop = ScrollTop + " . $gposTwitter . ";
		
		jQuery(\".tweet-panel\").css( { 
                top: ScrollTop,
                zIndex: 5000
        } );
		
}

function aSend() {

	var sendername =	jQuery(\"#sendername\").val();
	var senderpaypal =	jQuery(\"#senderpaypal\").val();
	
	senderemail = new Array;
    senderemail.push(jQuery(\"#senderemail\").val());
    senderemail.push(jQuery(\"#senderemail2\").val());
    senderemail.push(jQuery(\"#senderemail3\").val());
     
	
	
	jQuery.post(\"index.php\", { action: \"taf\", sendername: sendername, senderpaypal: senderpaypal, 'senderemail[]': senderemail },
					function(data){
						jQuery('.taf-panel')
                		.animate({left:'-' + tafTab.containerWidth}, tafTab.speed)
                		.removeClass('open');
				  	}
				);
}

function aTwittSend() {

	var TwitName =	jQuery(\"#TwitName\").val();
	var TwitPass =	jQuery(\"#TwitPass\").val();
	var Senderpaypal =	jQuery(\"#Senderpaypal\").val();
	
	jQuery.post(\"/rap_admin/addons/GIS/taf/tweet.php\", { TwitName: TwitName, senderpaypal: Senderpaypal, TwitPass: TwitPass,  TwitStatus: statustext, shrnklnk: shrnklnk},
					function(data){
						jQuery('.tweet-panel')
                		.animate({left:'-' + tweetTab.containerWidth}, tweetTab.speed)
                		.removeClass('open');
                		//alert(data);
				  	}
				);
}
</script>
";
	
}

function gTAFBody() {
		
	global $sys_tmpl_folder, $sys_install_folder, $sys_item_price;
	
	echo "<div class=\"taf-panel\" >
    <a class=\"taf-tab\" href=\"/\">Tell-A-Friend</a>
 
    <h3>Tell-A-Friend</h3>
    <div id=\"form-wrap\">";
 
    
    $prpnd = "";
	do
	{
		if (!file_exists($prpnd . "rap_admin"))
			$prpnd .= "../";
			
	} while (!file_exists($prpnd . "rap_admin") || ++$emcnt < 9);
	
	$g_template_file = $prpnd . $sys_install_folder . $sys_tmpl_folder . "taftab.html";
	
	if (!file_exists($g_template_file))
		$g_template_file = $prpnd . "rap_admin/addons/GIS/taf/templates/taftab.html";

	$g_filecontents = file_get_contents($g_template_file); 
		
	echo $g_filecontents;
	
	echo " 
    </div>    
</div>

<script type='text/javascript'>
var tafTab = {
 
    speed:300,
    containerWidth: jQuery('.taf-panel').outerWidth(),
    containerHeight: jQuery('.taf-panel').outerHeight(),
    tabWidth: jQuery('.taf-tab').outerWidth(),
 
 
    init:function(){
        jQuery('.taf-panel').css('height',tafTab.containerHeight + 'px');
 
        jQuery('a.taf-tab').click(function(event){
            if (jQuery('.taf-panel').hasClass('open')) {
                jQuery('.taf-panel')
                .animate({left:'-' + tafTab.containerWidth}, tafTab.speed)
                .removeClass('open');
            } else {
                jQuery('.taf-panel')
                .animate({left:'0'},  tafTab.speed)
                .addClass('open');
            }
            event.preventDefault();
        });
        setInterval(\"rePos()\", 250);
    }
};
 
tafTab.init();
	
	</script>";
}

function gTweetBody($Statustxt = "", $shrnklnk = "0") {
		
	global $sys_tmpl_folder, $sys_install_folder, $sys_item_price;
	
	echo "<div class=\"tweet-panel\" >
    <a class=\"tweet-tab\" href=\"/\">Tweet-Your-Friends</a>
 
    <h3>Tweet-Your-Friends</h3>
    <div id=\"form-wrap\">";
 
    
    $prpnd = "";
	do
	{
		if (!file_exists($prpnd . "rap_admin"))
			$prpnd .= "../";
			
	} while (!file_exists($prpnd . "rap_admin") || ++$emcnt < 9);
	
	$g_template_file = $prpnd . $sys_install_folder . $sys_tmpl_folder . "tweettab.html";
	
	if (!file_exists($g_template_file))
		$g_template_file = $prpnd . "rap_admin/addons/GIS/taf/templates/tweettab.html";

	$g_filecontents = file_get_contents($g_template_file); 
		
	echo $g_filecontents;
	
	echo " 
    </div>    
</div>

<script type='text/javascript'>
var tweetTab = {
 
    speed:300,
    containerWidth: jQuery('.tweet-panel').outerWidth(),
    containerHeight: jQuery('.tweet-panel').outerHeight(),
    tabWidth: jQuery('.tweet-tab').outerWidth(),
 
 
    init:function(){
        jQuery('.tweet-panel').css('height',tweetTab.containerHeight + 'px');
 
        jQuery('a.tweet-tab').click(function(event){
            if (jQuery('.tweet-panel').hasClass('open')) {
                jQuery('.tweet-panel')
                .animate({left:'-' + tweetTab.containerWidth}, tweetTab.speed)
                .removeClass('open');
            } else {
                jQuery('.tweet-panel')
                .animate({left:'0'},  tweetTab.speed)
                .addClass('open');
            }
            event.preventDefault();
        });
        setInterval(\"rePosTweet()\", 250);
    }
};
";
	
	if ($Statustxt == "") 
 		echo "var statustext=\"Hey, Check Out This Cool Product: \";";
 	else
		echo "var statustext=\"" . $Statustxt . "\";";
		
	echo " 
	var shrnklnk=\"" . $shrnklnk . "\"
	tweetTab.init();
	
	</script>";
}
	

