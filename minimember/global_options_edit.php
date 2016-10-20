<?php 

//==============================================================================================
//
//	Filename:	global_options_edit.php
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
//	Description:	This file is called to provide either the global settings or tables of info
//					depending on the type 
//
//	Version:	1.0.0 (March 26th, 2010)
//
//	Change Log:
//				03/26/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); ?>

<script language="JavaScript">

function aSave() {

	var columns =	jQuery("#columns").val();
	var pwdlen =	jQuery("#pwdlen").val();
	var genpswd =	jQuery("#genpswd:checked").val();
	var dnldextd =	jQuery("#dnldextd:checked").val();
	var pswdemail =	jQuery("#pswdemail:checked").val();
	jQuery.post("addons/GIS/minimember/global_options_edit.php", { action: "Update", columns: columns, pwdlen: pwdlen, genpswd: genpswd, dnldextd: dnldextd, pswdemail: pswdemail },
					function(data){
						jQuery('#gl-opt-disp').html(data);
				  	}
				);
}

</script>

<? if ($_POST['action'] == "Update" ) { 


	gMMUpdateOptionChar("columns", $_POST['columns']);
	gMMUpdateOptionChar("pwdlen", $_POST['pwdlen']);
	gMMUpdateOptionInt("genpswd", $_POST['genpswd']);
	gMMUpdateOptionInt("dnldextd", $_POST['dnldextd']);
	gMMUpdateOptionInt("pswdemail", $_POST['pswdemail']);
		
	?>
	<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents"><br><font style="font-size: 18px;"><strong>Success!!</strong></font><img src="/rap_admin/addons/GIS/minimember/images/info48x48.png" align="right">
        <br><font style="font-size: 14px;"><i>
        		Global Mini-Member Options Updated!</i><br>&nbsp;
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
		<?php 
} else { 

	//If a message was passed in display the message in a green box.
	if ($_POST['message'] != "") { ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        <? echo $_POST['message']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
		 	
			jQuery('#message-box').fadeOut(10000);

		</script>
<?	}
} ?>

<form id="copyfile" name="copyfile" method="post" action="addons/GIS/minimember/global_options.php">
<table>

  <tr><td>&nbsp;</td></tr>
  <tr><td><font size="4" color="black" face=tahoma style="letter-spacing: -1px;"><b>Item List Layout:</b></font><br><br><font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Columns:</font> <input type="text" name="columns" id="columns" value="<?php echo gMMGetOptionChar("columns", "date,txnid,productname,saleamt,status,dnldlnk") ?>" size="50"><br> <font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">(txnid, date, productcode, productname, saleamt, regamt, status, dnldlnk, affiliate)</font>
  </td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
<font size="4" color="black" face=tahoma style="letter-spacing: -1px;"><b>Password Settings:</b></font><br><br>
   <font size="4" color="gray" face=tahoma style="letter-spacing: -1px;">Minimum Password Length:</font> <input type="text" name="pwdlen" id="pwdlen" value="<?php echo gMMGetOptionChar("pwdlen", "7") ?>" size="3"> <font size="4" color="gray" face=tahoma style="letter-spacing: -1px;"></font>
  </td></tr> <tr><td>&nbsp;</td></tr>
  <tr><td>
  	<ul class="checklist">
		<li>
			<input id="genpswd" name="genpswd" value="1" type="checkbox" <? if (gMMGetOptionInt("genpswd", "1") == '1') { echo "checked"; } ?>>
       		<label for="genpswd">Automatically Generate Password</label>
       		<a class="checkbox-select" href="#">Select</a>
       		<a class="checkbox-deselect" href="#">Cancel</a>
       	</li>
	</ul>
  </td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
  	<ul class="checklist">
		<li>
			<input id="dnldextd" name="dnldextd" value="1" type="checkbox" <? if (gMMGetOptionInt("dnldextd", "1") == '1') { echo "checked"; } ?>>
       		<label for="dnldextd">Automatically Extend Download</label>
       		<a class="checkbox-select" href="#">Select</a>
       		<a class="checkbox-deselect" href="#">Cancel</a>
       	</li>
	</ul>
  </td></tr>
  <tr><td>&nbsp;</td></tr>

  <tr><td>

  	<ul class="checklist">
		<li>
			<input id="pswdemail" name="pswdemail" value="1" type="checkbox" <? if (gMMGetOptionInt("pswdemail", "1") == '1') { echo "checked"; } ?>>
       		<label for="pswdemail">Password Reset Via Email</label>
       		<a class="checkbox-select" href="#">Select</a>
       		<a class="checkbox-deselect" href="#">Cancel</a>
       	</li>
	</ul>
  </td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
  
 <input type="button" name="submit" id="submit" value="Save" onClick="javascript:aSave();"/>




</td></tr></table></form>



<script>
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
</script>