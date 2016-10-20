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
	global $productID;
	
	echo "<style type=\"text/css\">
.feedback-panel {
    padding:20px;
    width: 250px;
    background: #bab6d8;
    border: #29216d 1px solid;
    position:absolute;
    top:200px;
    left:-291px;
}
 
.feedback-panel a.feedback-tab {
    background:transparent url(feedbacktab.gif) no-repeat scroll 0 0;
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

<script type='text/javascript'>
var feedbackTab = {
 
    speed:300,
    containerWidth:$('.feedback-panel').outerWidth(),
    containerHeight:$('.feedback-panel').outerHeight(),
    tabWidth:$('.feedback-tab').outerWidth(),
 
 
    init:function(){
        $('.feedback-panel').css('height',feedbackTab.containerHeight + 'px');
 
        $('a.feedback-tab').click(function(event){
            if ($('.feedback-panel').hasClass('open')) {
                $('.feedback-panel')
                .animate({left:'-' + feedbackTab.containerWidth}, feedbackTab.speed)
                .removeClass('open');
            } else {
                $('.feedback-panel')
                .animate({left:'0'},  feedbackTab.speed)
                .addClass('open');
            }
            event.preventDefault();
        });
    }
};
 
feedbackTab.init();
	
	</script>";
	
}

function gTAFBody() {
		
	echo "<div class=\"feedback-panel\">
    <a class=\"feedback-tab\" href=\"http://www.static-formpage.com\">Feedback</a>
 
    <h3>Send Us Feedback</h3>
    <div id=\"form-wrap\">
 
    <form action='index.php' method=post>
      <input type=hidden name=action value=taf>
      <p align=center>
        <table width=500px style='border: 1px solid black;'>
          <tr><td align=center  bgcolor=\"#36648B\"><b><font color=white>Tell A Friend And 
          Earn $" . $sys_item_price . "</font></b></td></tr>
          <tr><td>
            <p>
            Your Name:<br>
            <input type=text name=sendername size=30 maxlength=60>
            </p>
            <p>
            Your PayPal Email Address:<br>
            <input type=text name=senderpaypal size=40 >
            </p>
            <p>
            Email Address #1:<br>
            <input type=text name=\"senderemail[]\" size=40>
            </p>
            <p>
            Email Address #2:<br>
            <input type=text name=\"senderemail[]\" size=40>
            </p>
            <p>
            Email Address #3:<br>
            <input type=text name=\"senderemail[]\" size=40>
            </p>
            
            <p align=center>
              <b>You will not leave this page when you click the button.</b>
            </p>
            <p align=center>
              <input type=submit value='Email Them And Make Me Some Money!'>
            </p>
            <p align=center>
              <font color=red><b>NOTICE:</b></font> We <b>HATE</b> SPAM, and will not 
				reuse your friends email addresses for any other purpose.&nbsp; 
				We won't even keep them on file.&nbsp; They will only receive 
				this single email from us on your behalf.
            </p>
          </td></tr>
        </table>
      </form>
 
    </div>    
</div>";
}
	

