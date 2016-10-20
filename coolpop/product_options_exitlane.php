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

function elos_textInput(&$opts, $name, $size=50)
{
   global $elos;
   echo "<input type=\"text\" size=\"$size\" name=\"" . $elos->postPrefix . "$name\"\n";
   echo "   value=\"";
   echo $opts[$name];
   echo "\" id=\"" . $elos->postPrefix . $name . "\" />\n";
}


function elos_textArea(&$opts, $name, $rows)
{
   global $elos;
   echo '<textarea name="' . $elos->postPrefix . $name . '" cols="60" rows="' . $rows . '" id="' . $elos->postPrefix . $name . '">';
   echo $opts[$name];
   echo '</textarea>';
}


function elos_hms(&$opts, $name)
{
   global $elos;
   $hms = array('h' => 'hour(s)', 'm'=>'minute(s)', 's'=>'second(s)');

   echo '<select name="' . $elos->postPrefix . $name . '" id="' . $elos->postPrefix . $name . '">';
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

function elos_pos(&$opts, $name)
{
   global $elos;
   $hms = array('a' => 'Position Control', 'c'=>'With Content');

   echo '<select name="' . $elos->postPrefix . $name . '" id="' . $elos->postPrefix . $name . '"  onchange="PositionChanged()">';
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

function elos_valign(&$opts, $name)
{
   global $elos;
   $hms = array('t' => 'Top', 'c'=>'Center', 'b'=>'Bottom', 'a'=>'Absolute');

   echo '<select name="' . $elos->postPrefix . $name . '" id="' . $elos->postPrefix . $name . '"  onchange="yTypeChanged()">';
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

function elos_halign(&$opts, $name)
{
   global $elos;
   $hms = array('l' => 'Left', 'c'=>'Center', 'r'=>'Right', 'a'=>'Absolute');

   echo '<select name="' . $elos->postPrefix . $name . '" id="' . $elos->postPrefix . $name . '"  onchange="xTypeChanged()">';
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

function elos_radio(&$opts, $name, $value, $label)
{
   global $elos;
   echo '<input type="radio" name="' . $elos->postPrefix . $name . '" size="20" id="' . $elos->postPrefix . $name . '"';
   if ($opts[$name]==$value)
   {
      echo 'checked="checked" ';
   }
   echo 'value="' . $value . '"/>';
   echo $label;
}

function elos_checkbox(&$opts, $name, $value, $label)
{
   global $elos;
   
   //echo $opts[$name] . " - " . $value . "<BR>"; 
   echo '<input type="checkbox" name="' . $elos->postPrefix . $name . '" id="' . $elos->postPrefix . $name . '" ';
   if ($opts[$name]==$value)
   {
      echo 'checked="checked" ';
   }
   echo 'value="' . $value . '" onchange="buttonChanged()"/>';
   echo $label;
}

if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_CoolPop set offerText='" . $_POST['offerText'] . "', width='" . $_POST['width'] . "', height='" . $_POST['height'] . 
	"', x='" . $_POST['x'] . "', y='" . $_POST['y'] . "', position='" . $_POST['position'] . "', horAlign='" . $_POST['horAlign'] . "', vertAlign='" . $_POST['vertAlign'] . 
	"', posBuffer='" . $_POST['posBuffer'] . "', cssoverride='" . $_POST['cssoverride'] . "', Status='" . $_POST['Status']. "' where productID='" . $_POST['productID'] . "'";
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

	var offerText =	jQuery("#offerText").val();
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

	jQuery('#cp-options').html(loadingimage);
	
	jQuery.post("addons/GIS/coolpop/product_options_exitlane.php", { offerText: offerText, width: width, height: height, x: x, y: y, position: position, horAlign: horAlign,
		vertAlign: vertAlign, posBuffer: posBuffer, cssoverride: cssoverride, Status: status, action: "Update", productID: "<?= $_REQUEST['productID']; ?>" },
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
		$sql="select * from g_CoolPop where productID='" . $_POST['productID'] . "'";
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
 	<tr><td class="Prompts" >Offer Text:</td><td>&nbsp;&nbsp;</td><td><?php elos_textArea($grow, "offerText", 10); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
  	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Width:</td><td>&nbsp;&nbsp;</td><td><?php elos_textInput($grow, "width", 4); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Height:</td><td>&nbsp;&nbsp;</td><td><?php elos_textInput($grow, "height", 4); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Horizontal Alignment:</td><td>&nbsp;&nbsp;</td><td><?php elos_halign($grow, "horAlign"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td class="Prompts" colspan="3"><div id="abs-x" style="display:inline"><table><tr><td>x:</td><td>&nbsp;&nbsp;</td><td><?php elos_textInput($grow, "x", 4); ?></td></tr></table></div></td></tr>
 	<tr><td>&nbsp;</td></tr>

 	
 	<tr><td class="Prompts" >Vertical Alignment:</td><td>&nbsp;&nbsp;</td><td><?php elos_valign($grow, "vertAlign"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td class="Prompts" colspan="3"><div id="abs-y" style="display:inline"><table><tr><td>y:</td><td>&nbsp;&nbsp;</td><td><?php elos_textInput($grow, "y", 4); ?></td></tr></table></div></td></tr>
 	<tr><td>&nbsp;</td></tr>
 
 	
 	<tr><td class="Prompts" >Outside Padding:</td><td>&nbsp;&nbsp;</td><td><?php elos_textInput($grow, "posBuffer", 4); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td class="Prompts" colspan="3">CSS Override:</td></tr>
 	<tr><td class="Prompts" colspan="3"><?php elos_textArea($grow, "cssoverride", 5); ?></td></tr>
 	<tr><td colspan="3"><p><label>The following are the classes that can be overridden:</label><br><br>
  
  <b>elos</b>: The style of the contents of the window and the border of the window<br><br>
  <b>elos_offer</b>: This is the style of the paragraph that the offer is placed in<br><br>
  <b>elos_buttons</b>: The style of the paragraph that the buttons are in<br><br>
  <b>elos_NoThanksButton</b>: The Style of the No Thanks Button<br><br>
  <b>elos_LaterButton</b>: The Style of the Later Button<br><br>
  <b>elos_CloseButton</b>: The Style of the Close Button<br><br>
  <b>elos_CloseIcon</b>: The style for the Close Icon in the upper right of the offer box<br><br>
  <b><i>Examples:</i></b><br>
  <pre>
  //set border to big red dashed line
  #elos {
   border: dashed red 5px;
}

  //Set border to big red line with yellow background
  #elos {
   border: solid red 5px;
   background: yellow;
}

  //Black box with yellow border
  #elos {
   border: solid yellow 5px;
   background: black;
}

  //change the close button image to an alternate image
  #elos_CloseIcon {
   background:url(wp-content/plugins/coolpop/images/closebutton2.png) no-repeat;
}</pre><br><br>
  </p></td></tr>
 	
 	
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