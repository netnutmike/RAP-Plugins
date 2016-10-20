<?
//==============================================================================================
//
//	Filename:	functions.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2010(c), Genius Idea Studio, LLC
//
//	Product Is Available For Download From www.rap-tools.com
//
//	Description:	This is a global functions file.
//
//	Version:	1.0.0 (July 29th, 2010)
//
//	Change Log:
//				07/29/10 - Initial Version (JMM)
//
//==============================================================================================

function g_CandyBar() {

	//this function outputs the divs and java script for the cool pop popover.
	
	//Read the config record for this product
	session_start();

	$productID=$_SESSION[product];
	
	//check to see if there are specific options for the product first
	$query = "SELECT * FROM g_CandyBar WHERE productID = '" . $productID . "'"; 
	$result = mysql_query($query);
	$rows = mysql_num_rows($result);
	if ($rows > 0)
	{
		$grow=mysql_fetch_array($result);
		if ($grow['Status'] == '1') {
?>	
	
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js' type='text/javascript'></script>

<script>
	jQuery.noConflict();
</script>
<script src="http://jqueryui.com/latest/ui/effects.pulsate.js"></script>
<script src="http://jqueryui.com/latest/ui/effects.core.js"></script>
<script src="http://jqueryui.com/latest/ui/effects.pulsate.js"></script>

<style type='text/css'>
#slideup {
 
 //background:white;
 color:black;
 display:none;
}
 
#cbos_CloseIcon {
 position: absolute;
 width: 32px;
 height: 32px;
 top: 5px;
 left: 50;
 opacity: 0.2;
}
 
 <?= $grow['cssoverride']?>
</style>

<DIV ID="slideupfx"><div id="slideup"  style="overflow:visible; width:100%; height:50px;" class="" style="background-color:transparent">
       <?php echo $grow['offerText']; ?>
       <input type="image" src="wp-content/plugins/candybar/images/closebutton.png" name="cbos_CloseIcon" id="cbos_CloseIcon" onMouseOver="cbos.onHover()" onMouseOut="cbos.onHoverOut()" onclick="cbos.onClose()" width=32 height=32 style="opacity: 0">
  
    <?php if ($grow['butNoThanks'] == '1' || $grow['butAskLater'] == '1') { ?>
    <p id="cbos_buttons">
    
    	<?php if ($grow['butNoThanks'] == '1') { ?>
      		<button onclick="cbos.onNoThanks()" id="buttonNoThanks">
        	<?php echo $grow['noThanksText']; ?>
      		</button>
      	<?php } ?>
      	<?php if ($grow['butAskLater'] == '1') { ?>
      		<button onclick="cbos.onAskMeLater()" id="buttonAskLater">
        	<?php echo $grow['askMeLaterText']; ?>
      		</button>
      	<?php } ?>
    </p>
    <?php } ?>
     </div></div>
     
<script type="text/javascript">

var closeButton = '<p><button onclick="cbos.onClose()">close</button></p>';

jQuery.fn.slideup = function(options) {
	this.settings = {
		closeLink: 'none',
		animation: 'slide',
		height: '50' ,
        delay: 400
	}

	if(options)
		jQuery.extend(this.settings, options);

	//alert('height: ' + this.settings.height);
	//alert('delay: ' + this.settings.delay);
	if ( this.settings.animation != 'slide' && this.settings.animation != 'none' && this.settings.animation != 'fade' ) {
		alert('animation can only be set to \'slide\', \'none\' or \'fade\'');
	}
	
	var id = this.attr('id');
	settings = this.settings;

	jQuery(this).css('padding', '0').css('height', this.settings.height + 'px').css('margin', '0').css('width', '100%');
	jQuery('html').css('padding', '0 0 ' + ( this.settings.height * 1 + 50 ) + 'px 0');
	if ( typeof document.body.style.maxHeight != "undefined" ) {
		jQuery(this).css('position', 'fixed').css('bottom', '0').css('left', '0').css('z-index','99999');
	}

	//set position of close button
	jQuery("#cbos_CloseIcon").css('position', 'fixed').css('bottom', this.settings.height + 'px').css('right','0').css('height','32').css('width','32').css('z-index','999999');
	<?php if ($grow['butNoThanks'] == '1') { ?>
		jQuery("#buttonNoThanks").css('position', 'fixed').css('bottom', (this.settings.height - (this.settings.height/3)) + 'px').css('right','0').css('z-index','999999');
	<?php } ?>
	<?php if ($grow['butAskLater'] == '1') { ?>
		jQuery("#buttonAskLater").css('position', 'fixed').css('bottom', (this.settings.height - ((this.settings.height/3) *2)) + 'px').css('right','0').css('z-index','999999');
	<?php } ?>
	
	if ( this.settings.animation == 'slide' ) {
		//alert("sliding");
		jQuery(this).slideDown(this.settings.delay);
	}
	else if ( this.settings.animation == 'fade' ) {
		jQuery(this).fadeIn(this.settings.delay);
	}
	else {
		jQuery(this).show();
	}
	if ( this.settings.closeLink != 'none' ) {
		jQuery(this.settings.closeLink).click(function(){
			jQuery.closeslideup(id);
			return false;
		});
	}
	
	// Return jQuery to complete the chain
	return this;
};

jQuery.closeslideup = function(id) {
	this.slideup = jQuery('#' + id);
	jQuery(this.slideup).hide();
	jQuery('html').css('padding', '0');
	jQuery('body').css('overflow', 'visible'); // Change IE6 hack back
};// Open Slide Up

var cbos = 
{
  show: function() 
  {
     // only show if the cookie is NOT present
     if (! this.suppressed())
     {
		//jQuery("#cbos").slideUp('slow');
    	this.settings= {closeLink: 'none',animation: 'slide',height: <?= $grow['height']; ?>,delay: (<?= $grow['initialDelay']; ?> * 200)  };
 	    jQuery('#slideup').slideup(this.settings);

 	    this.onHoverOut();
     }
  },

  onNoThanks: function()
  {
     // suppress for 10 years
     this.suppress(365 * 24 * 10, 'h');
     jQuery.closeslideup("slideup");
  },
  
  onAskMeLater: function()
  {
     
	jQuery("#slideup").closeslideup("slideup");
  },



  onClose: function()
  {
	  jQuery.closeslideup("slideup");
  },

  onHover: function()
  {
	  jQuery("#cbos_CloseIcon").css("opacity", 1);
  },

  onHoverOut: function()
  {
	  jQuery("#cbos_CloseIcon").css("opacity", .2);
  },


  suppress: function(delay, unit)
  {
     // now set cookie:

     var h = (unit == 'h') ? delay : 0;
     var m = (unit == 'm') ? delay : 0;
     var s = (unit == 's') ? delay : 0;
     var now = new Date().getTime();

     var date1 = new Date(now + (h*60*60*1000) + (m*60*1000) + (s*1000));
     var newCookie = "cbos_suppress=true; expires=" + date1.toGMTString() + "; path=/";
     document.cookie = newCookie;

     // second cookie (10 years)
     // because the initial and subsequent delays may be different
     var date2 = new Date(now + (10*365*24*60*60*1000));
     var newCookie2 = "cbos_seen=true; expires=" + date2.toGMTString() + "; path=/";
     document.cookie = newCookie2;
  },

  suppressed: function()
  {
     return document.cookie.indexOf("cbos_suppress=true") > -1;
  },

  // debug function:
  eraseCookie: function()
  {
     this.suppress(-1,0); // expire 1 day ago
     alert("cookie expired. hit refresh");
  }
};

setTimeout('cbos.show()', (<?php echo $grow['initialDelay']; ?> * 1000) );
</script>

<?php 		}
		}
} ?>