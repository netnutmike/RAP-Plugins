<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js' type='text/javascript'></script>

<script>
	jQuery.noConflict();
</script>
<script src="http://jqueryui.com/latest/ui/effects.pulsate.js"></script>
<script src="http://jqueryui.com/latest/ui/effects.core.js"></script>
<script src="http://jqueryui.com/latest/ui/effects.pulsate.js"></script>

<style type='text/css'>
#elos {
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

#elos h1 {
 color:black;
 }
 
#elos_CloseIcon {
 position: absolute;
 width: 32px;
 height: 32px;
 top: 5px;
 left: 50;
 opacity: 0.2;
}

#elos_exit {
 position: absolute;
 width: 32px;
 height: 5px;
 top: 0;
 left: 0;
 opacity: 0.0;
}
 
 <?= $grow['cssoverride']?>
</style>

<div id="elos_position">
  <div id="elos">
    <p id="elos_offer">
       <?php echo $grow['offerText']; ?>
    </p>
    
    <input type="image" src="/rap_admin/addons/GIS/exitlane/images/closebutton.png" name="elos_CloseIcon" id="elos_CloseIcon" onMouseOver="elos.onHover()" onMouseOut="elos.onHoverOut()" onclick="elos.onClose()" width=32 height=32>
  </div>
</div>
<div id="elos_exit" name="elos_exit" onMouseOver="elos.onExitHover()">
</div>

<script type="text/javascript">

function elos_setPosition() {
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
		jQuery("#elos").css("left",posBuffer);
	}

	//alert(posBuffer + "\r\n" + posWidth + "\r\n" + ((posBuffer + posWidth) / 2));
	if (posHAlign == "c") {
		jQuery("#elos").css("left",(winW / 2) - ((posBuffer + posWidth) / 2));
	}

	if (posHAlign == "r") {
		jQuery("#elos").css("left",winW - (posBuffer + posWidth + 45));
	}

	if (posVAlign == "t") {
		jQuery("#elos").css("top",posBuffer);
	}

	//alert(posBuffer + "\r\n" + posWidth + "\r\n" + ((posBuffer + posWidth) / 2));
	if (posVAlign == "c") {
		jQuery("#elos").css("top",(winH / 2) - ((posBuffer + posHeight) / 2));
	}

	if (posVAlign == "b") {
		jQuery("#elos").css("top",winH - (posBuffer + posHeight + 45));
	}
		
	
	jQuery("#elos_exit").css("top", 0).css("left", 0).css("height", 5).css("width", (winW * .40));
	jQuery("#elos_CloseIcon").css("top", 5);
	var posLeftButton = jQuery("#elos").css("left").replace("px","");
	jQuery("#elos_CloseIcon").css("left", posWidth);
	}

jQuery("#elos_exit").css("top", 0).css("left", 0).css("height", 10).css("width", 400);

var closeButton = '<p><button onclick="elos.onClose()">close</button></p>';

var elos = 
{
  show: function() 
  {
	elos_setPosition();
    jQuery("#elos").slideDown('fast');
    
  },

  onClose: function()
  {
	  jQuery("#elos").fadeOut();
  },

  onExitHover: function()
  {
	  this.show();
  },

  onHover: function()
  {
	  jQuery("#elos_CloseIcon").css("opacity", 1);
  },

  onHoverOut: function()
  {
	  jQuery("#elos_CloseIcon").css("opacity", .2);
  }
};

</script>