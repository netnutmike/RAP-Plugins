<?
//==============================================================================================
//
//	Filename:	layout_options_edit.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2010(c), Genius Idea Studio, LLC
//
//	Section Is Available For Download From www.rap-tools.com
//
//	Description:	This file is called when the Section Options Accordian is opened 
//
//	Version:	1.0.0 (February 23rd, 2010)
//
//	Change Log:
//				2.23.10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php");
?>

<script type="text/javascript">


function SectionSelected(form) {
		
	//jQuery('#Sectionname').html(jQuery('#layouts option:selected').text());
	jQuery('#Sectionname').hide();
	var uid = jQuery('#layouts').val();

	jQuery.post("addons/GIS/frontpage/section_edit.php", { uid: uid },
			function(data){
				jQuery('#SectionDescription').html(data);
		  	}
		);
}

function aCopySection() {
	
	var pid = jQuery('#layouts').val();
	jQuery('#Sectionname').html("Copy Selected Section To New Section:");

	jQuery('#layout-options-dis').hide();
	jQuery('#SectionDescription').html(loadingimage);
	jQuery.post("addons/GIS/frontpage/copy_section.php", { pid: pid},
			function(data){
				jQuery('#SectionDescription').html(data);
			  }
		);
}

function aDeleteSection() {
	
	var pid = jQuery('#layouts').val();
	jQuery('#Sectionname').html("Delete Selected Section.");

	jQuery('#layout-options-dis').hide();
	jQuery('#SectionDescription').html(loadingimage);
	jQuery.post("addons/GIS/frontpage/delete_section.php", { pid: pid },
			function(data){
				jQuery('#SectionDescription').html(data);
			  }
		);
}
</script>

<?
	//If an error message was passed in then display the error message in a red box.
	if ($_POST['errormessage'] != "") { ?>
		<div class="rounded-box-red" id="error-box">
    	    <div class="box-contents">
        <? echo $_POST['errormessage']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#error-box').effect("pulsate", { times:3 }, 2000);
			jQuery('#error-box').fadeOut(10000);
		</script>
<?	} 

	//If a message was passed in display the message in a green box.
	if ($_POST['message'] != "") { ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        <? echo $_POST['message']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">

			jQuery('#message-box').fadeOut(20000);

		</script>
<?	} ?>

<!-- <div class="rounded-box">
    <!-- Content -->
    <div class="box-contents">
        Using the Section Editor is very simple, in the box below you will see a list of sections that are currently defined.  Select a section then on the right you will have options for the layout.
    </div> <!-- end div.box-contents -->
</div> <!-- end div.rounded-box -->
<br><br>  -->


<table valign="top" width="100" cellspacing="0">
<tr ><td bgcolor="#fd9423" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Sections:</p>";
		
?>

</font></td>
<td rowspan="3" valign="top">

<div id='Sectiondetails'>
<table width="300" cellspacing="0"><tr><td>
	<div id="Sectionname">
	<br><br>&nbsp;
	Select A Section
	</div></td></tr>
	<tr><td>
	<div id="SectionDescription">
	<---- Select a section on the left to set options, Copy or Delete
	</div>
	</td></tr>
	<tr><td>
	
	</td></tr></table>
</div>
</td></tr>
<tr bgcolor="#dac8b6"><td align="left" class="Prompts">&nbsp;
 	</td></tr>
<tr valign="top"><td valign="top">
<div id='layoutslist'>

<div class='gis-content' style="display:none" id="layout-functions">

<a href="javascript:aDeleteSection();" id="deletesection"><img src="addons/GIS/frontpage/images/delete_computer.png" alt="Delete a Section." border="0" width="32" height="32" align="right"></a><br></div>
<div><a href="javascript:aNewSection();" id="copysection" alt="Copy Section To a New Section"><img src="addons/GIS/frontpage/images/computer_add.png" alt="Create a New Custom Section." border="0" width="32" height="32" align="right"></a></div>
<select name="layouts" size="8" id="layouts" class="layoutslist" onClick="SectionSelected(this.form)">
   
<?php 
	//Build a list of layouts in the select list 
	$query = "select * from g_FPSections order by SectionName;";		
	$request = mysql_query($query);
	while ($rs = mysql_fetch_array($request)){	
		echo "<option value=\"" . $rs['uid'] . "\">" . $rs['SectionName'] . "</option>";
	}

?>
 </select><br></br>
 
</div></td></tr></table>

<div style='clear:both;'></div>
<div class='gis-content padding-rl-20' style="display:none" id="layout-options-dis">xxxxxxxxxxxxxx</div>

