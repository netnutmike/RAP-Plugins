<?php 

//==============================================================================================
//
//	Filename:	product_options.php
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
//	Description:	This file is called to provide a file description from the database. 
//
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				02/17/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); 

function wpos_textInput(&$opts, $name, $size=50)
{
   global $wpos;
   echo "<input type=\"text\" size=\"$size\" name=\"" . $wpos->postPrefix . "$name\"\n";
   echo "   value=\"";
   echo $opts[$name];
   echo "\" id=\"" . $wpos->postPrefix . $name . "\" />\n";
}


function wpos_textArea(&$opts, $name, $rows)
{
   global $wpos;
   echo '<textarea name="' . $wpos->postPrefix . $name . '" cols="60" rows="' . $rows . '" id="' . $wpos->postPrefix . $name . '">';
   echo $opts[$name];
   echo '</textarea>';
}


function wpos_hms(&$opts, $name)
{
   global $wpos;
   $hms = array('h' => 'hour(s)', 'm'=>'minute(s)', 's'=>'second(s)');

   echo '<select name="' . $wpos->postPrefix . $name . '" id="' . $wpos->postPrefix . $name . '">';
   foreach ($hms as $k=>$v)
   {
      echo '   <option value="' . $k . '"';
      if ($k == $opts[$name]) 
      {
	 echo ' selected="selected"';
      }
      echo '>';
      echo $v;
      echo '</option>';
   }
   echo '</select>';
}

function wpos_pos(&$opts, $name)
{
   global $wpos;
   $hms = array('a' => 'Position Control', 'c'=>'With Content');

   echo '<select name="' . $wpos->postPrefix . $name . '" id="' . $wpos->postPrefix . $name . '"  onchange="PositionChanged()">';
   foreach ($hms as $k=>$v)
   {
      echo '   <option value="' . $k . '"';
      if ($k == $opts[$name]) 
      {
	 echo ' selected="selected"';
      }
      echo '>';
      echo $v;
      echo '</option>';
   }
   echo '</select>';
}

function wpos_valign(&$opts, $name)
{
   global $wpos;
   $hms = array('t' => 'Top', 'c'=>'Center', 'b'=>'Bottom', 'a'=>'Absolute');

   echo '<select name="' . $wpos->postPrefix . $name . '" id="' . $wpos->postPrefix . $name . '"  onchange="yTypeChanged()">';
   foreach ($hms as $k=>$v)
   {
      echo '   <option value="' . $k . '"';
      if ($k == $opts[$name]) 
      {
	 echo ' selected="selected"';
      }
      echo '>';
      echo $v;
      echo '</option>';
   }
   echo '</select>';
}

function wpos_halign(&$opts, $name)
{
   global $wpos;
   $hms = array('l' => 'Left', 'c'=>'Center', 'r'=>'Right', 'a'=>'Absolute');

   echo '<select name="' . $wpos->postPrefix . $name . '" id="' . $wpos->postPrefix . $name . '"  onchange="xTypeChanged()">';
   foreach ($hms as $k=>$v)
   {
      echo '   <option value="' . $k . '"';
      if ($k == $opts[$name]) 
      {
	 echo ' selected="selected"';
      }
      echo '>';
      echo $v;
      echo '</option>';
   }
   echo '</select>';
}

function wpos_radio(&$opts, $name, $value, $label)
{
   global $wpos;
   echo '<input type="radio" name="' . $wpos->postPrefix . $name . '" size="20" id="' . $wpos->postPrefix . $name . '"';
   if ($opts[$name]==$value)
   {
      echo 'checked="checked" ';
   }
   echo 'value="' . $value . '"/>';
   echo $label;
}

function wpos_checkbox(&$opts, $name, $value, $label)
{
   global $wpos;
   
   //echo $opts[$name] . " - " . $value . "<BR>"; 
   echo '<input type="checkbox" name="' . $wpos->postPrefix . $name . '" id="' . $wpos->postPrefix . $name . '" ';
   if ($opts[$name]==$value)
   {
      echo 'checked="checked" ';
   }
   echo 'value="' . $value . '" onchange="buttonChanged()"/>';
   echo $label;
}

if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_CoolPop set popOverID='" . $_POST['popOverID'] . "', offerText='" . $_POST['offerText'] . "', initialDelay='" . $_POST['initialDelay'] . "', width='" . $_POST['width'] . "', height='" . $_POST['height'] . 
	"', x='" . $_POST['x'] . "', y='" . $_POST['y'] . "', position='" . $_POST['position'] . "', horAlign='" . $_POST['horAlign'] . "', vertAlign='" . $_POST['vertAlign'] . 
	"', redisplayDelay='" . $_POST['redisplayDelay'] . "', redisplayUnit='" . $_POST['redisplayUnit'] . "', redisplayMaxCount='" . $_POST['redisplayMaxCount'] . "', subsequentDelay='" . $_POST['subsequentDelay'] . "', subsequentUnit='" . $_POST['subsequentUnit'] .
	"', askMeLaterText='" . $_POST['askMeLaterText'] . "', noThanksText='" . $_POST['noThanksText'] . "', butNoThanks='" . $_POST['butNoThanks'] . "', butAskLater='" . $_POST['butAskLater'] . "', thankYouMessage='" . $_POST['thankYouMessage'] .
	"', noThanksResponse='" . $_POST['noThanksResponse'] . "', posBuffer='" . $_POST['posBuffer'] . "', cssoverride='" . $_POST['cssoverride'] . "', Status='" . $_POST['Status']. "' where productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/coolpop/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Cool-Pop Product Options Updated!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} ?>

<script language="JavaScript">

function aSaveatc() {

	var popOverID =	jQuery("#popOverID").val();
	var offerText =	jQuery("#offerText").val();
	var initialDelay =	jQuery("#initialDelay").val();
	var width =	jQuery("#width").val();
	var height =	jQuery("#height").val();
	var x =	jQuery("#x").val();
	var y =	jQuery("#y").val();
	var position =	jQuery("#position").val();
	var horAlign =	jQuery("#horAlign").val();
	var vertAlign =	jQuery("#vertAlign").val();
	var redisplayDelay =	jQuery("#redisplayDelay").val();
	var redisplayUnit =	jQuery("#redisplayUnit").val();
	var redisplayMaxCount =	jQuery("#redisplayMaxCount").val();
	var subsequentDelay =	jQuery("#subsequentDelay").val();
	var subsequentUnit =	jQuery("#subsequentUnit").val();
	var askMeLaterText =	jQuery("#askMeLaterText").val();
	var noThanksText =	jQuery("#noThanksText").val();
	var butNoThanks =	jQuery("#butNoThanks:checked").val();
	var butAskLater =	jQuery("#butAskLater:checked").val();
	var thankYouMessage =	jQuery("#thankYouMessage").val();
	var noThanksResponse =	jQuery("#noThanksResponse").val();
	var posBuffer =	jQuery("#posBuffer").val();
	var cssoverride =	jQuery("#cssoverride").val();
	var status =	jQuery("#status:checked").val();

	jQuery('#cp-options').html(loadingimage);
	
	jQuery.post("addons/GIS/coolpop/product_options_coolpop.php", { popOverID: popOverID, offerText: offerText, initialDelay: initialDelay, width: width, height: height, x: x, y: y, position: position, horAlign: horAlign,
		vertAlign: vertAlign, redisplayDelay: redisplayDelay, redisplayUnit: redisplayUnit, redisplayMaxCount: redisplayMaxCount, subsequentDelay: subsequentDelay, subsequentUnit: subsequentUnit, 
		askMeLaterText: askMeLaterText, noThanksText: noThanksText, butNoThanks: butNoThanks, butAskLater: butAskLater, thankYouMessage: thankYouMessage, noThanksResponse: noThanksResponse,
		posBuffer: posBuffer, cssoverride: cssoverride, Status: status, action: "Update", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#cp-options').html(data);
				  	}
				);
}

</script>

<?
	$sql="select * from g_CoolPop where productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) == 0) {
		$sql="insert into g_CoolPop (productID, offerText, Status) VALUES ('" . $_POST['productID'] . "', 'Your Text for the Pop Over Goes Here.  It can include HTML, images, etc', '0')";
		$gid=mysql_query($sql);
		$sql="select * from g_CoolPop where productID='" . $_POST['productID'] . "' AND entryType='1'";
		$gid=mysql_query($sql);
	}
	$grow = mysql_fetch_array($gid);
?>
<table width="700" cellspacing="0">

<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts">

 	<input type="image" src="/rap_admin/addons/GIS/coolpop/images/save.png" name="submit" value="Save" onClick="javascript:aSaveatc();"/><br>&nbsp;&nbsp;Save
 	</td><td></td><td align="right" class="Prompts"></td></tr>
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table>
 	<tr><td class="Prompts" >Offer Text:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textArea($grow, "offerText", 10); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
  <tr><td colspan="3"><b>Note:</b>&nbsp;<i>You can optionally display a box if the user selects the No Thanks Button.  If there is any value in the box below it will be displayed when the No Thanks button is pressed.  If it is blank, the window will close with no additional action.</i><br><br>
   </td></tr> <tr><td><label><b>&quot;No Thanks&quot; Message (Leave Blank To Disable Feature)<b>:<br/></b></b></td><td></td><td>
      <?php wpos_textArea($grow, "noThanksResponse", 2); ?>
    </label>
  </td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Initial Delay:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "initialDelay", 4); ?> Seconds</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Redisplay Delay:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "redisplayDelay", 4);; ?>&nbsp;<?php wpos_hms($grow, "redisplayUnit"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Redisplay Max Count:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "redisplayMaxCount", 4); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Subsequent Delay:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "subsequentDelay", 4); ?>&nbsp;<?php wpos_hms($grow, "subsequentUnit"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Popover ID:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "popOverID", 8); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Width:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "width", 4); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Height:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "height", 4); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Horizontal Alignment:</td><td>&nbsp;&nbsp;</td><td><?php wpos_halign($grow, "horAlign"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td class="Prompts" colspan="3"><div id="abs-x" style="display:inline"><table><tr><td>x:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "x", 4); ?></td></tr></table></div></td></tr>
 	<tr><td>&nbsp;</td></tr>

 	
 	<tr><td class="Prompts" >Vertical Alignment:</td><td>&nbsp;&nbsp;</td><td><?php wpos_valign($grow, "vertAlign"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td class="Prompts" colspan="3"><div id="abs-y" style="display:inline"><table><tr><td>y:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "y", 4); ?></td></tr></table></div></td></tr>
 	<tr><td>&nbsp;</td></tr>
 
 	
 	<tr><td class="Prompts" >Outside Padding:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "posBuffer", 4); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >"No Thank You" Button:</td><td>&nbsp;&nbsp;</td><td><?php wpos_checkbox($grow, "butNoThanks", 1, "Active"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" colspan="3"><div id="nothankstextbox"><table><tr><td>Button Text:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "noThanksText", 20); ?></td></tr></table></div></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td class="Prompts" >"Ask Me Later" Button:</td><td>&nbsp;&nbsp;</td><td><?php wpos_checkbox($grow, "butAskLater", 1, "Active"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td class="Prompts" colspan="3"><div id="asklatertextbox"><table><tr><td>Button Text:</td><td>&nbsp;&nbsp;</td><td><?php wpos_textInput($grow, "askMeLaterText", 20); ?></td></tr></table></div></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" colspan="3">CSS Override:</td></tr>
 	<tr><td class="Prompts" colspan="3"><?php wpos_textArea($grow, "cssoverride", 5); ?></td></tr>
 	<tr><td colspan="3"><p><label>The following are the classes that can be overridden:</label><br><br>
  
  <b>wpos</b>: The style of the contents of the window and the border of the window<br><br>
  <b>wpos_offer</b>: This is the style of the paragraph that the offer is placed in<br><br>
  <b>wpos_buttons</b>: The style of the paragraph that the buttons are in<br><br>
  <b>wpos_NoThanksButton</b>: The Style of the No Thanks Button<br><br>
  <b>wpos_LaterButton</b>: The Style of the Later Button<br><br>
  <b>wpos_CloseButton</b>: The Style of the Close Button<br><br>
  <b>wpos_CloseIcon</b>: The style for the Close Icon in the upper right of the offer box<br><br>
  <b><i>Examples:</i></b><br>
  <pre>
  //set border to big red dashed line
  #wpos {
   border: dashed red 5px;
}

  //Set border to big red line with yellow background
  #wpos {
   border: solid red 5px;
   background: yellow;
}

  //Black box with yellow border
  #wpos {
   border: solid yellow 5px;
   background: black;
}

  //change the close button image to an alternate image
  #wpos_CloseIcon {
   background:url(wp-content/plugins/coolpop/images/closebutton2.png) no-repeat;
}</pre><br><br>
  </p></td></tr>
 	
 	
 	<tr><td colspan="4">
 		<ul class="checklist">
						<li>
							<input id="status" name="status" value="1" type="checkbox" <? if ($grow['Status'] == '1' ) { echo "checked"; } ?>>
                    		<label for="status">Active Pop-Over</label>
                    		<a class="checkbox-select" href="#">Select</a>
                    		<a class="checkbox-deselect" href="#">Cancel</a>
                    	</li>
					</ul>
 		</td></tr>
 		<tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td colspan="3">
  
 

</td></tr></table>
<div class='gis-content padding-rl-20' id="atc-opt-disp"></div>

<script type='text/javascript'>


/* see if anything is previously checked and reflect that in the view*/
jQuery(".checklist input:checked").parent().addClass("selected");

/* handle the user selections */
jQuery(".checklist .checkbox-select").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().addClass("selected");
        jQuery(this).parent().find(":checkbox").attr("checked","checked");
    }
);

jQuery(".checklist .checkbox-deselect").click(
    function(event) {
        event.preventDefault();
        jQuery(this).parent().removeClass("selected");
        jQuery(this).parent().find(":checkbox").removeAttr("checked");
    }
    
);



function xTypeChanged(form) {
		
	if (jQuery('#horAlign').val() == 'a') {
		jQuery('#abs-x').show();
	} else {
		jQuery('#abs-x').hide();
	}

}

function yTypeChanged(form) {
		
	if (jQuery('#vertAlign').val() == 'a') {
		jQuery('#abs-y').show();
	} else {
		jQuery('#abs-y').hide();
	}
	
	}
	
function buttonChanged(form) {
		
	if (jQuery('#butNoThanks:checked').val() == '1') {
		jQuery('#nothankstextbox').show();
	} else {
		jQuery('#nothankstextbox').hide();
	}
	
	if (jQuery('#butAskLater:checked').val() == '1') {
		jQuery('#asklatertextbox').show();
	} else {
		jQuery('#asklatertextbox').hide();
	}

}

buttonChanged();
xTypeChanged();
yTypeChanged();


</script>