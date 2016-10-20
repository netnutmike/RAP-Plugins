<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js' type='text/javascript'></script>

<script>
	jQuery.noConflict();
</script>
<script src="http://jqueryui.com/latest/ui/effects.pulsate.js"></script>
<script src="http://jqueryui.com/latest/ui/effects.core.js"></script>
<script src="http://jqueryui.com/latest/ui/effects.pulsate.js"></script>

<style type='text/css'>
#wpos {
 position: absolute;
 left: <?php echo $grow['x']; ?>px;
 top:  <?php echo $grow['y']; ?>px;

 width: <?php echo $grow['width']; ?>px;
 height: <?php echo $grow['height']; ?>px;

 padding:20px;
 margin:auto;
 background:white;
 color:black;
 display:none;
 border: solid black 1px;
}

#wpos h1 {
 color:black;
 }
 
#wpos_CloseIcon {
 position: absolute;
 width: 32px;
 height: 32px;
 top: 5px;
 left: 50;
 opacity: 0.2;
}
 
 <?= $grow['cssoverride']?>
</style>

<div id="wpos_position">
  <div id="wpos">
    <p id="wpos_offer">
       <?php echo $grow['offerText']; ?>
    </p>
    <?php if ($grow['butNoThanks'] == '1' || $grow['butAskLater'] == '1') { ?>
    <p id="wpos_buttons">
    
    	<?php if ($grow['butNoThanks'] == '1') { ?>
      		<button onclick="wpos.onNoThanks()">
        	<?php echo $grow['noThanksText']; ?>
      		</button>
      	<?php } ?>
      	<?php if ($grow['butAskLater'] == '1') { ?>
      		<button onclick="wpos.onAskMeLater()">
        	<?php echo $grow['askMeLaterText']; ?>
      		</button>
      	<?php } ?>
    </p>
    <?php } ?>
    <input type="image" src="/rap_admin/addons/GIS/coolpop/images/closebutton.png" name="wpos_CloseIcon" id="wpos_CloseIcon" onMouseOver="wpos.onHover()" onMouseOut="wpos.onHoverOut()" onclick="wpos.onClose()" width=32 height=32>
  </div>
</div>

<script type="text/javascript">

function wpos_setPosition() {
	//locate the box where they want it

	var posHAlign = '<?= $grow['horAlign'] ?>';
	var posVAlign = '<?= $grow['vertAlign'] ?>';
	var posBuffer = <?= $grow['posBuffer'] ?>;
	var posWidth = <?= $grow['width'] ?>;
	var posHeight = <?= $grow['height'] ?>;

	var winW = 630, winH = 460;

	//find the window height and width (works with all browsers)
	if (parseInt(navigator.appVersion)>3) {
	 	if (navigator.appName.indexOf("Microsoft")!=-1) {
	  		winW = document.body.offsetWidth;
	  		winH = document.body.offsetHeight;
	 	} else {
			winW = window.innerWidth;
			winH = window.innerHeight;
		 }
	}
	

	if (posHAlign == "l") {
		jQuery("#wpos").css("left",posBuffer);
	}

	//alert(posBuffer + "\r\n" + posWidth + "\r\n" + ((posBuffer + posWidth) / 2));
	if (posHAlign == "c") {
		jQuery("#wpos").css("left",(winW / 2) - ((posBuffer + posWidth) / 2));
	}

	if (posHAlign == "r") {
		jQuery("#wpos").css("left",winW - (posBuffer + posWidth + 45));
	}

	if (posVAlign == "t") {
		jQuery("#wpos").css("top",posBuffer);
	}

	//alert(posBuffer + "\r\n" + posWidth + "\r\n" + ((posBuffer + posWidth) / 2));
	if (posVAlign == "c") {
		jQuery("#wpos").css("top",(winH / 2) - ((posBuffer + posHeight) / 2));
	}

	if (posVAlign == "b") {
		jQuery("#wpos").css("top",winH - (posBuffer + posHeight + 45));
	}
		
	

	jQuery("#wpos_CloseIcon").css("top", 5);
	var posLeftButton = jQuery("#wpos").css("left").replace("px","");
	jQuery("#wpos_CloseIcon").css("left", posWidth);
	}
	
var closeButton = '<p><button onclick="wpos.onClose()">close</button></p>';

var wpos = 
{
  show: function() 
  {

     // only show if the cookie is NOT present
     if (this.isOkToShow() && (! this.suppressed()))
     {
    	 wpos_setPosition();
		jQuery("#wpos").slideDown('slow');
     }
  },

  onNoThanks: function()
  {
     // suppress for 10 years
     this.suppress(365 * 24 * 10, 'h');
     if ('<?php echo $grow['noThanksResponse']; ?>' == '') {
    	 jQuery("#wpos").fadeOut();
     } else {
     	jQuery("#wpos")
  			.html('<?php echo $grow['noThanksResponse']; ?>')
       		.append(closeButton);
     }
  },
  
  onAskMeLater: function()
  {
     
	this.suppress(<?php echo $grow['subsequentDelay']; ?>, 
		      '<?php echo $grow['subsequentUnit']; ?>');

	jQuery("#wpos").fadeOut();
  },



  onClose: function()
  {
	  jQuery("#wpos").fadeOut();
	  this.incrementViewCount();
  },

  onHover: function()
  {
	  jQuery("#wpos_CloseIcon").css("opacity", 1);
  },

  onHoverOut: function()
  {
	  jQuery("#wpos_CloseIcon").css("opacity", .2);
  },


  suppress: function(delay, unit)
  {
     // now set cookie:

     var h = (unit == 'h') ? delay : 0;
     var m = (unit == 'm') ? delay : 0;
     var s = (unit == 's') ? delay : 0;
     this.setCookie("wpos_suppress", "true", (h*60*60*1000) + (m*60*1000) + (s*1000));
     
     //var now = new Date().getTime();

     //var date1 = new Date(now + (h*60*60*1000) + (m*60*1000) + (s*1000));
     //var newCookie = "wpos_suppress=true; expires=" + date1.toGMTString() + "; path=/";
     //document.cookie = newCookie;

     // second cookie (10 years)
     // because the initial and subsequent delays may be different
     //var date2 = new Date(now + (10*365*24*60*60*1000));
     //var newCookie2 = "wpos_seen=true; expires=" + date2.toGMTString() + "; path=/";
     //document.cookie = newCookie2;
  },

  suppressed: function()
  {
     return document.cookie.indexOf("wpos_suppress=true") > -1;
  },

  isOkToShow: function()
  {
	var displayCount = this.getCookie("wpos_displayCount");

	if (parseInt(displayCount) > parseInt('<?php echo $grow['redisplayMaxCount']; ?>'))
		return false;
	else
		return true;
	
  },

  incrementViewCount: function()
  {
	  var displayCount = this.getCookie("wpos_displayCount");

	  if (displayCount == "")
		  displayCount = 1;
	  else
		  displayCount = parseInt(displayCount) + 1;

	  this.setCookie("wpos_displayCount", displayCount, (10*365*24*60*60*1000));
	  this.suppress(<?php echo $grow['redisplayDelay']; ?>, 
		      '<?php echo $grow['redisplayUnit']; ?>');
	  
     return;
  },

  checkPopoverID: function()
  {
	  var popOverID = this.getCookie("wpos_popOverID");

	  if (popOverID != '<?php echo $grow['popOverID']; ?>') {
		  this.setCookie("wpos_displayCount", '0', -(24*60*60*1000));
		  this.setCookie("wpos_suppress", '0', -(24*60*60*1000));
		  this.setCookie("wpos_popOverID", '<?php echo $grow['popOverID']; ?>', (10*365*24*60*60*1000));
	  }
	  
     return;
  },

  // debug function:
  eraseCookie: function()
  {
     this.suppress(-1,0); // expire 1 day ago
     alert("cookie expired. hit refresh");
  },

  setCookie: function (c_name,value,expireminutes)
  {
	var now = new Date().getTime();
  	var exdate=new Date(now + expireminutes);
  	
  	document.cookie=c_name+ "=" +escape(value)+
  	((expireminutes==null) ? "" : ";expires="+exdate.toUTCString());
  },
  
  getCookie: function (c_name)
  {
  	if (document.cookie.length>0)
    	{
    	c_start=document.cookie.indexOf(c_name + "=");
    	if (c_start!=-1)
     		{
     		c_start=c_start + c_name.length+1;
      		c_end=document.cookie.indexOf(";",c_start);
      		if (c_end==-1) c_end=document.cookie.length;
      		return unescape(document.cookie.substring(c_start,c_end));
      		}
    	}
  	return "";
  }
};

wpos.checkPopoverID();

setTimeout('wpos.show()', <?php echo $grow['initialDelay']; ?> * 1000);

wpos.onHoverOut();
</script>