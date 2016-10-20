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

function g_ExitRamp() {

	//this function outputs the divs and java script for the cool pop popover.

	//Read the config record for this product
	session_start();

	$productID=$_SESSION[product];
	
	//check to see if there are specific options for the product first
	$query = "SELECT * FROM g_ExitRamp WHERE productID = '" . $productID . "'"; 
	$result = mysql_query($query);
	$rows = mysql_num_rows($result);
	if ($rows > 0)
	{
		$grow=mysql_fetch_array($result);
		if ($grow['Status'] == '1') {
?>	
	
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js' type='text/javascript'></script>
<script type="text/javascript" src="/rap_admin/addons/GIS/exitramp/modal.js"></script>

<script>
	jQuery.noConflict();
</script>
<script src="http://jqueryui.com/latest/ui/effects.pulsate.js"></script>
<script src="http://jqueryui.com/latest/ui/effects.core.js"></script>
<script src="http://jqueryui.com/latest/ui/effects.pulsate.js"></script>

<style type='text/css'>
#eros {
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

#eros h1 {
 color:black;
 }
 
#eros_CloseIcon {
 position: absolute;
 width: 32px;
 height: 32px;
 top: 5px;
 left: 50;
 opacity: 0.2;
}
 
 <?= $grow['cssoverride']?>
</style>

<script>
      		var eros = 
{
  show: function() 
  {
     
     jQuery("#eros").slideDown('fast');
    
  },

  onClose: function()
  {
	  jQuery("#eros").fadeOut();
	  jQuery("#eros_exit").fadeOut();
  },

  onHover: function()
  {
	  jQuery("#eros_CloseIcon").css("opacity", 1);
  },

  onHoverOut: function()
  {
	  jQuery("#eros_CloseIcon").css("opacity", .2);
  },

};			
			function UnPopIt()  { 
				jQuery("#eros_exit").hide();
				jQuery("#eros").hide();
			/* nothing to return */ } 
			
			function Quitter() {
				<?php if (trim($grow['initialPopup']) != "") { ?>
				if (confirm("<?php echo $grow['initialPopup']; ?>")) {
					return true;
				} else {
					return false;
				}
			<?php } else { ?>
				return false;
			<?php } ?>
			}
			
      		//window.onbeforeunload = PopIt();
      		var popovertimer;
      		window.onbeforeunload = function() { 
				window.onbeforeunload = UnPopIt;
				if (!Quitter()) {
      
      <?php if ( $grow['stayAction'] == "p" ) {
		echo '		wpos_setPosition();
					jQuery("#eros").modal({autoCenter: false, background: jQuery(\'#eros_exit\'), lockPosition: true});
					var popovertimer = setTimeout(\'eros.show()\', \'2000\');
					return "' . $grow['continuePopup'] . '";';
      } else {
      	echo '      location.href="' . $grow['forwardURL'] . '";
      	            return "' . $grow['continuePopup'] . '";';
      	          
      } ?>
		
			}
				 
   			}
				
			window.onunload = function() {
				//alert("onunload");
				jQuery("#eros").removeModal();
				clearTimeout(popovertimer);
			}
      		</script>

<div id="eros_position">
  <div id="eros">
    <p id="eros_offer">
       <?php echo $grow['offerText']; ?>
    </p>
    
    <input type="image" src="/rap_admin/addons/GIS/exitramp/images/closebutton.png" name="eros_CloseIcon" id="eros_CloseIcon" onMouseOver="eros.onHover()" onMouseOut="eros.onHoverOut()" onclick="eros.onClose()" width=32 height=32>
  </div>
</div>
<div id="eros_exit"></div>


<script type="text/javascript">

function wpos_setPosition() {
	//locate the box where they want it
	//locate the box where they want it
	var posType = '<?= $grow['position'] ?>';
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
		jQuery("#eros").css("left",posBuffer);
	}

	//alert(posBuffer + "\r\n" + posWidth + "\r\n" + ((posBuffer + posWidth) / 2));
	if (posHAlign == "c") {
		jQuery("#eros").css("left",(winW / 2) - ((posBuffer + posWidth) / 2));
	}

	if (posHAlign == "r") {
		jQuery("#eros").css("left",winW - (posBuffer + posWidth + 45));
	}

	if (posVAlign == "t") {
		jQuery("#eros").css("top",posBuffer);
	}

	//alert(posBuffer + "\r\n" + posWidth + "\r\n" + ((posBuffer + posWidth) / 2));
	if (posVAlign == "c") {
		jQuery("#eros").css("top",(winH / 2) - ((posBuffer + posHeight) / 2));
	}

	if (posVAlign == "b") {
		jQuery("#eros").css("top",winH - (posBuffer + posHeight + 45));
	}
		
	jQuery("#eros_CloseIcon").css("top", 5);
	var posLeftButton = jQuery("#eros").css("left").replace("px","");
	jQuery("#eros_CloseIcon").css("left", posWidth);

}

jQuery(document).ready(function() {
	jQuery("a[id!=trigger]").click(function(){ 
		window.onbeforeunload = UnPopIt; 
		}) } );
</script>
<?php 		}
		}
} ?>