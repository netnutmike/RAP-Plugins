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

function cbos_textInput(&$opts, $name, $size=50)
{
   global $cbos;
   echo "<input type=\"text\" size=\"$size\" name=\"" . $cbos->postPrefix . "$name\"\n";
   echo "   value=\"";
   echo $opts[$name];
   echo "\" id=\"" . $cbos->postPrefix . $name . "\" />\n";
}


function cbos_textArea(&$opts, $name, $rows)
{
   global $cbos;
   echo '<textarea name="' . $cbos->postPrefix . $name . '" cols="60" rows="' . $rows . '" id="' . $cbos->postPrefix . $name . '">';
   echo $opts[$name];
   echo '</textarea>';
}


function cbos_hms(&$opts, $name)
{
   global $cbos;
   $hms = array('h' => 'hour(s)', 'm'=>'minute(s)', 's'=>'second(s)');

   echo '<select name="' . $cbos->postPrefix . $name . '" id="' . $cbos->postPrefix . $name . '">';
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

function cbos_pos(&$opts, $name)
{
   global $cbos;
   $hms = array('a' => 'Position Control', 'c'=>'With Content');

   echo '<select name="' . $cbos->postPrefix . $name . '" id="' . $cbos->postPrefix . $name . '"  onchange="PositionChanged()">';
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

function cbos_valign(&$opts, $name)
{
   global $cbos;
   $hms = array('t' => 'Top', 'c'=>'Center', 'b'=>'Bottom', 'a'=>'Absolute');

   echo '<select name="' . $cbos->postPrefix . $name . '" id="' . $cbos->postPrefix . $name . '"  onchange="yTypeChanged()">';
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

function cbos_halign(&$opts, $name)
{
   global $cbos;
   $hms = array('l' => 'Left', 'c'=>'Center', 'r'=>'Right', 'a'=>'Absolute');

   echo '<select name="' . $cbos->postPrefix . $name . '" id="' . $cbos->postPrefix . $name . '"  onchange="xTypeChanged()">';
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

function cbos_radio(&$opts, $name, $value, $label)
{
   global $cbos;
   echo '<input type="radio" name="' . $cbos->postPrefix . $name . '" size="20" id="' . $cbos->postPrefix . $name . '"';
   if ($opts[$name]==$value)
   {
      echo 'checked="checked" ';
   }
   echo 'value="' . $value . '"/>';
   echo $label;
}

function cbos_checkbox(&$opts, $name, $value, $label)
{
   global $cbos;
   
   //echo $opts[$name] . " - " . $value . "<BR>"; 
   echo '<input type="checkbox" name="' . $cbos->postPrefix . $name . '" id="' . $cbos->postPrefix . $name . '" ';
   if ($opts[$name]==$value)
   {
      echo 'checked="checked" ';
   }
   echo 'value="' . $value . '" onchange="buttonChanged()"/>';
   echo $label;
}

if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_CandyBar set offerText='" . $_POST['offerText'] . "', initialDelay='" . $_POST['initialDelay'] . "', height='" . $_POST['height'] . 
	"', askMeLaterText='" . $_POST['askMeLaterText'] . "', noThanksText='" . $_POST['noThanksText'] . "', butNoThanks='" . $_POST['butNoThanks'] . "', butAskLater='" . $_POST['butAskLater'] . 
	"', cssoverride='" . $_POST['cssoverride'] . "', Status='" . $_POST['Status']. "' where productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Good News!</strong></font><img src="/rap_admin/addons/GIS/candybar/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Candy Bar Product Options Updated!
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
	var initialDelay =	jQuery("#initialDelay").val();
	var height =	jQuery("#height").val();
	var askMeLaterText =	jQuery("#askMeLaterText").val();
	var noThanksText =	jQuery("#noThanksText").val();
	var butNoThanks =	jQuery("#butNoThanks:checked").val();
	var butAskLater =	jQuery("#butAskLater:checked").val();
	var cssoverride =	jQuery("#cssoverride").val();
	var status =	jQuery("#status:checked").val();

	jQuery('#pr-opt-disp').html(loadingimage);
	
	jQuery.post("addons/GIS/candybar/product_options.php", { offerText: offerText, initialDelay: initialDelay, height: height, 
		askMeLaterText: askMeLaterText, noThanksText: noThanksText, butNoThanks: butNoThanks, butAskLater: butAskLater, 
		cssoverride: cssoverride, Status: status, action: "Update", productID: "<?= $_REQUEST['productID']; ?>" },
					function(data){
						jQuery('#pr-opt-disp').html(data);
				  	}
				);
}

</script>

<?
	$sql="select * from g_CandyBar where productID='" . $_POST['productID'] . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) == 0) {
		$sql="insert into g_CandyBar (productID, offerText, Status) VALUES ('" . $_POST['productID'] . "', 'Your code for the Slide-up ad Goes Here.  It can include HTML, images, etc', '0')";
		$gid=mysql_query($sql);
		$sql="select * from g_CandyBar where productID='" . $_POST['productID'] . "'";
		$gid=mysql_query($sql);
	}
	$grow = mysql_fetch_array($gid);
?>
<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Edit Candy Bar Setup </p>";
		
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts">

 	<input type="image" src="/rap_admin/addons/GIS/candybar/images/save.png" name="submit" value="Save" onClick="javascript:aSaveatc();"/><br>&nbsp;&nbsp;Save
 	</td><td></td><td align="right" class="Prompts"></td></tr>
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table>
 	<tr><td class="Prompts" >Offer Text:</td><td>&nbsp;&nbsp;</td><td><?php cbos_textArea($grow, "offerText", 10); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	

 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Initial Delay:</td><td>&nbsp;&nbsp;</td><td><?php cbos_textInput($grow, "initialDelay", 4); ?> Seconds</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >Height:</td><td>&nbsp;&nbsp;</td><td><?php cbos_textInput($grow, "height", 4); ?></td></tr>
 	 	
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" >"No Thank You" Button:</td><td>&nbsp;&nbsp;</td><td><?php cbos_checkbox($grow, "butNoThanks", 1, "Active"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" colspan="3"><div id="nothankstextbox"><table><tr><td>Button Text:</td><td>&nbsp;&nbsp;</td><td><?php cbos_textInput($grow, "noThanksText", 20); ?></td></tr></table></div></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td class="Prompts" >"Ask Me Later" Button:</td><td>&nbsp;&nbsp;</td><td><?php cbos_checkbox($grow, "butAskLater", 1, "Active"); ?></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td class="Prompts" colspan="3"><div id="asklatertextbox"><table><tr><td>Button Text:</td><td>&nbsp;&nbsp;</td><td><?php cbos_textInput($grow, "askMeLaterText", 20); ?></td></tr></table></div></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
 	<tr><td class="Prompts" colspan="3">CSS Override:</td></tr>
 	<tr><td class="Prompts" colspan="3"><?php cbos_textArea($grow, "cssoverride", 5); ?></td></tr>
 	<tr><td colspan="3"><p><label>The following are the classes that can be overridden:</label><br><br>
  
  <b>slideup</b>: The style of the contents of the window and the border of the window<br><br>
  <b>cbos_buttons</b>: The style of the paragraph that the buttons are in<br><br>
  <b>cbos_NoThanksButton</b>: The Style of the No Thanks Button<br><br>
  <b>cbos_LaterButton</b>: The Style of the Later Button<br><br>
  <b>cbos_CloseButton</b>: The Style of the Close Button<br><br>
  <b>cbos_CloseIcon</b>: The style for the Close Icon in the upper right of the offer box<br><br>
  <b><i>Examples:</i></b><br>
  <pre>
  //set border to big red dashed line
  #slideup {
   border: dashed red 5px;
}

  //Set border to big red line with yellow background
  #slideup {
   border: solid red 5px;
   background: yellow;
}

  //Black box with yellow border
  #slideup {
   border: solid yellow 5px;
   background: black;
}

  //change the close button image to an alternate image
  #cbos_CloseIcon {
   background:url(wp-content/plugins/candybar/images/closebutton2.png) no-repeat;
}</pre><br><br>
  </p></td></tr>
 	
 	
 	<tr><td colspan="4">
 		<ul class="checklist">
						<li>
							<input id="status" name="status" value="1" type="checkbox" <? if ($grow['Status'] == '1' ) { echo "checked"; } ?>>
                    		<label for="status">Active Slide-Up Ad</label>
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