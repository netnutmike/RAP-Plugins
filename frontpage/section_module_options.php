<?php 

//==============================================================================================
//
//	Filename:	section_module_options.php
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
//	Description:	This file is called to allow editing of the options for a specific module 
//					in a specific section. 
//
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				02/17/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); 

function getOptionValue($lookingFor,$optionList) {

	$gOptionsa=explode("|", $optionList);

	$counta = count($gOptionsa);
	for ($i = 0; $i < $counta; $i++) {
		$gOptionsb=explode("=", $gOptionsa[$i]);
		if ($gOptionsb[0] == $lookingFor)
			return $gOptionsb[1];
	}
	
	return;
}

if ($_POST['action'] == "Update" ) {

	$sql = "UPDATE g_FPSectionModules set Options='" . $_POST['optionString'] . "' where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	
	?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
    	    <br><font style="font-size: 18px;"><strong>Excellent!</strong></font><img src="/rap_admin/addons/GIS/frontpage/images/info48x48.png" align="right">
        	<br><font style="font-size: 14px;"><i>
        		Module Options for this Section have been updated!
        		</i><br>&nbsp;
        		
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#message-box').fadeOut(10000);
		</script>
<?	} ?>

<script language="JavaScript">

function aSaveOptions() {

	var option_string = ''; 
	cnt=0;
	//jQuery("#optionValue").each(
	jQuery("input:text").each( 
	//jQuery("input[@type='text'][@name^='optionValue']").each( 
	    function() 
	    { 
		    if (cnt > 0) {
		    	option_string += "|";
		    }
		    
	    	option_string += jQuery("input:hidden").eq(cnt).val()+"=" + this.value; 
	    	++cnt; 
	    	alert("In Loop");
	    }); 

	jQuery('#ModuleOptions').html(loadingimage);
	
	jQuery.post("addons/GIS/frontpage/section_module_options.php", { optionString: option_string, action: "Update", uid: "<?= $_REQUEST['uid']; ?>" },
					function(data){
						jQuery('#ModuleOptions').html(data);
				  	}
				);
}

</script>

<?
	$sql="select * from g_FPSectionModules where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
	
	$sql2="select * from g_FPModules where uid='" . $grow['ModuleID'] . "'";
	$gid2=mysql_query($sql2);
	$grow2 = mysql_fetch_array($gid2);
?>
<table width="700" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Options for Selected Module...</p>";
		
?>

</font></td></tr>
<? if (trim($grow2['CustomCode']) == "" || $grow2['CustomCode'] == NULL || $grow2['Type'] == '999') {?>
<tr bgcolor="#dac8b6"><td align="left" class="Prompts">
<B><I>There are no options for the selected module.</I></B>
 	</td>
</tr>
 	
<? } else { ?>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts">

 	<input type="image" src="/rap_admin/addons/GIS/frontpage/images/save.png" name="submit" value="Save" onClick="javascript:aSaveOptions();"/><br>&nbsp;&nbsp;Save
 	</td><td></td><td align="right" class="Prompts"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	
<tr><td>
 	<table>
<?
$gOptions=explode("|", $grow2['CustomCode']);

$count = count($gOptions);
for ($i = 0; $i < $count; $i++) {
	$gOptionValue=explode("=", $gOptions[$i]);
	
?> 
 	<tr><td class="Prompts" ><?= $gOptionValue[0]?>:</td><td>&nbsp;&nbsp;</td><td><input type="hidden" name="optionName" id="optionName" value="<?= $gOptionValue[0]?>"></input>
<?	switch ($gOptionValue[1]) {
		case 'N': 	//numbers only ?>
			<input type="text" name="optionValue[]" id="optionValue[]" size="35" value="<? echo getOptionValue($gOptionValue[0],$grow['Options']); ?>"></td></tr>
			
<?			break;
		case 'P': 	//standard text input for anything else ?>
			<input type="text" name="optionValue[]" id="optionValue[]" size="35" value="<? echo getOptionValue($gOptionValue[0],$grow['Options']); ?>"></td></tr>

<?			break;
		case 'PL': 	//standard text input for anything else ?>
			


<?		default: 	//standard text input for anything else ?>
			<input type="text" name="optionValue[]" id="optionValue[]" size="35" value="<? echo getOptionValue($gOptionValue[0],$grow['Options']); ?>"></td></tr>
<?		}
?> 	
 	
 	<tr><td>&nbsp;</td></tr>
 	
<? } ?> 	
 	

  <tr><td>&nbsp;</td></tr>
  <tr><td colspan="3">
  
 

</td></tr>

<? } ?>
</table>
<div class='gis-content padding-rl-20' id="atc-opt-disp"></div>

