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

function eros_textInput(&$opts, $name, $size=50)
{
   global $eros;
   echo "<input type=\"text\" size=\"$size\" name=\"" . $eros->postPrefix . "$name\"\n";
   echo "   value=\"";
   echo $opts[$name];
   echo "\" id=\"" . $eros->postPrefix . $name . "\" />\n";
}


function eros_textArea(&$opts, $name, $rows)
{
   global $eros;
   echo '<textarea name="' . $eros->postPrefix . $name . '" cols="60" rows="' . $rows . '" id="' . $eros->postPrefix . $name . '">';
   echo $opts[$name];
   echo '</textarea>';
}


function eros_hms(&$opts, $name)
{
   global $eros;
   $hms = array('h' => 'hour(s)', 'm'=>'minute(s)', 's'=>'second(s)');

   echo '<select name="' . $eros->postPrefix . $name . '" id="' . $eros->postPrefix . $name . '">';
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

function eros_pos(&$opts, $name)
{
   global $eros;
   $hms = array('a' => 'Position Control', 'c'=>'With Content');

   echo '<select name="' . $eros->postPrefix . $name . '" id="' . $eros->postPrefix . $name . '"  onchange="PositionChanged()">';
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

function eros_valign(&$opts, $name)
{
   global $eros;
   $hms = array('t' => 'Top', 'c'=>'Center', 'b'=>'Bottom', 'a'=>'Absolute');

   echo '<select name="' . $eros->postPrefix . $name . '" id="' . $eros->postPrefix . $name . '"  onchange="yTypeChanged()">';
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

function eros_stayaction(&$opts, $name)
{
   global $eros;
   $hms = array('p' => 'Pop-Over', 'f'=>'Forward');

   echo '<select name="' . $eros->postPrefix . $name . '" id="' . $eros->postPrefix . $name . '"  onchange="stayActionChanged()">';
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

function eros_halign(&$opts, $name)
{
   global $eros;
   $hms = array('l' => 'Left', 'c'=>'Center', 'r'=>'Right', 'a'=>'Absolute');

   echo '<select name="' . $eros->postPrefix . $name . '" id="' . $eros->postPrefix . $name . '"  onchange="xTypeChanged()">';
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

function eros_radio(&$opts, $name, $value, $label)
{
   global $eros;
   echo '<input type="radio" name="' . $eros->postPrefix . $name . '" size="20" id="' . $eros->postPrefix . $name . '"';
   if ($opts[$name]==$value)
   {
      echo 'checked="checked" ';
   }
   echo 'value="' . $value . '"/>';
   echo $label;
}

function eros_checkbox(&$opts, $name, $value, $label)
{
   global $eros;
   
   //echo $opts[$name] . " - " . $value . "<BR>"; 
   echo '<input type="checkbox" name="' . $eros->postPrefix . $name . '" id="' . $eros->postPrefix . $name . '" ';
   if ($opts[$name]==$value)
   {
      echo 'checked="checked" ';
   }
   echo 'value="' . $value . '" onchange="buttonChanged()"/>';
   echo $label;
}

if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_ExitRamp set offerText='" . $_POST['offerText'] . "', initialPopup='" . $_POST['initialPopup'] . "', continuePopup='" . $_POST['continuePopup'] . "', stayAction='" . $_POST['stayAction'] . "', width='" . $_POST['width'] . "', height='" . $_POST['height'] . 
	"', x='" . $_POST['x'] . "', y='" . $_POST['y'] . "', position='" . $_POST['position'] . "', horAlign='" . $_POST['horAlign'] . "', vertAlign='" . $_POST['vertAlign'] . 
	"', forwardURL='" . $_POST['forwardURL'] . "', posBuffer='" . $_POST['posBuffer'] . "', cssoverride='" . $_POST['cssoverride'] . "', Status='" . $_POST['Status']. "' where productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/exitramp/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Exit-Ramp Product Options Updated!
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

	var offerText =	jQuery("#offerText").val();
	var initialPopup =	jQuery("#initialPopup").val();
	var continuePopup =	jQuery("#continuePopup").val();
	var stayAction =	jQuery("#stayAction").val();
	var forwardURL =	jQuery("#forwardURL").val();
	var width =	jQuery("#width").val();
	var height =	jQuery("#height").val();
	var x =	jQuery("#x").val();
	var y =	jQuery("#y").val();
	var position =	jQuery("#position").val();
	var horAlign =	jQuery("#horAlign").val();
	var vertAlign =	jQuery("#vertAlign").val();
	var posBuffer =	jQuery("#posBuffer").val();
	var cssoverride =	jQuery("#cssoverride").val();
	var status =	jQuery("#status:checked").val();

	jQuery('#pr-opt-disp').html(loadingimage);
	
	jQuery.post("addons/GIS/exitramp/product_options.php", { offerText: offerText, initialPopup: initialPopup, continuePopup: continuePopup, stayAction: stayAction, width: width, height: height, x: x, y: y, position: position, horAlign: horAlign,
		vertAlign: vertAlign, posBuffer: posBuffer, cssoverride: cssoverride, Status: status, forwardURL: forwardURL, action: "Update", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

</script>

<?
	$sql="select * from g_ExitRamp where productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) == 0) {
		$sql="insert into g_ExitRamp (productID, initialPopup, continuePopup, Status) VALUES ('" . $_POST['productID'] . "', 'If there is text in here it will be displayed in a popup prior to the system popup', 'The text in this option is displayed in the system generated continue message',  '0')";
		$gid=mysql_query($sql);
		$sql="select * from g_ExitRamp where productID='" . $_POST['productID'] . "'";
		$gid=mysql_query($sql);
	}
	$grow = mysql_fetch_array($gid);
?>
<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Edit Exit-Ramp Setup </p>";
		
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts">

 	<input type="image" src="/rap_admin/addons/GIS/exitramp/images/save.png" name="submit" value="Save" onClick="javascript:aSaveatc();"/><br>&nbsp;&nbsp;Save
 	</td><td></td><td align="right" class="Prompts"></td></tr>
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table>
 	<tr><td class="Prompts" >Initial Popup Text:</td><td>&nbsp;&nbsp;</td><td><?php eros_textArea($grow, "initialPopup", 10); ?></td></tr>
 	<tr><td class="Prompts" >Text for Continue Popup:</td><td>&nbsp;&nbsp;</td><td><?php eros_textArea($grow, "continuePopup", 10); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" >Stay Action:</td><td>&nbsp;&nbsp;</td><td><?php eros_stayaction($grow, "stayAction"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	</table>
 	<div id="popover-setup">
 	<table>
 	<tr><td class="Prompts" >Offer Text:</td><td>&nbsp;&nbsp;</td><td><?php eros_textArea($grow, "offerText", 10); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts" >Width:</td><td>&nbsp;&nbsp;</td><td><?php eros_textInput($grow, "width", 4); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Height:</td><td>&nbsp;&nbsp;</td><td><?php eros_textInput($grow, "height", 4); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Horizontal Alignment:</td><td>&nbsp;&nbsp;</td><td><?php eros_halign($grow, "horAlign"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td class="Prompts" colspan="3"><div id="abs-x" style="display:inline"><table><tr><td>x:</td><td>&nbsp;&nbsp;</td><td><?php eros_textInput($grow, "x", 4); ?></td></tr></table></div></td></tr>
 	<tr><td>&nbsp;</td></tr>

 	
 	<tr><td class="Prompts" >Vertical Alignment:</td><td>&nbsp;&nbsp;</td><td><?php eros_valign($grow, "vertAlign"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td class="Prompts" colspan="3"><div id="abs-y" style="display:inline"><table><tr><td>y:</td><td>&nbsp;&nbsp;</td><td><?php eros_textInput($grow, "y", 4); ?></td></tr></table></div></td></tr>
 	<tr><td>&nbsp;</td></tr>
 
 	
 	<tr><td class="Prompts" >Outside Padding:</td><td>&nbsp;&nbsp;</td><td><?php eros_textInput($grow, "posBuffer", 4); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	
 	<tr><td class="Prompts" colspan="3">CSS Override:</td></tr>
 	<tr><td class="Prompts" colspan="3"><?php eros_textArea($grow, "cssoverride", 5); ?></td></tr>
 	<tr><td colspan="3"><p><label>The following are the classes that can be overridden:</label><br><br>
  
  <b>eros</b>: The style of the contents of the window and the border of the window<br><br>
  <b>eros_offer</b>: This is the style of the paragraph that the offer is placed in<br><br>
  <b>eros_buttons</b>: The style of the paragraph that the buttons are in<br><br>
  <b>eros_NoThanksButton</b>: The Style of the No Thanks Button<br><br>
  <b>eros_LaterButton</b>: The Style of the Later Button<br><br>
  <b>eros_CloseButton</b>: The Style of the Close Button<br><br>
  <b>eros_CloseIcon</b>: The style for the Close Icon in the upper right of the offer box<br><br>
  <b><i>Examples:</i></b><br>
  <pre>
  //set border to big red dashed line
  #eros {
   border: dashed red 5px;
}

  //Set border to big red line with yellow background
  #eros {
   border: solid red 5px;
   background: yellow;
}

  //Black box with yellow border
  #eros {
   border: solid yellow 5px;
   background: black;
}

  //change the close button image to an alternate image
  #eros_CloseIcon {
   background:url(wp-content/plugins/exitramp/images/closebutton2.png) no-repeat;
}</pre><br><br>
  </p></td></tr>
 	</table>
 	</div>
 	
 	<div id="forward-setup">
 	<table>
 	<tr><td class="Prompts" >Forward URL:</td><td>&nbsp;&nbsp;</td><td><?php eros_textInput($grow, "forwardURL", 30); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	</table></div>
 	<table>
 	
 	<tr><td colspan="4">
 		<ul class="checklist">
						<li>
							<input id="status" name="status" value="1" type="checkbox" <? if ($grow['Status'] == '1' ) { echo "checked"; } ?>>
                    		<label for="status">Active Exit Pop</label>
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

function stayActionChanged(form) {

	if (jQuery('#stayAction').val() == 'f') {
		jQuery('#popover-setup').hide();
		jQuery('#forward-setup').show();
	} else {
		jQuery('#forward-setup').hide();
		jQuery('#popover-setup').show();
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
stayActionChanged();


</script>