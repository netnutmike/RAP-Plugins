<?
//==============================================================================================
//
//	Filename:	module_options_edit.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2010(c), Genius Idea Studio, LLC
//
//	Module Is Available For Download From www.rap-tools.com
//
//	Description:	This file is called when the Module Options Accordian is opened 
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


function ModuleSelected(form) {
		
	jQuery('#Modulename').html(jQuery('#modules option:selected').text());
	var uid = jQuery('#modules').val();

	jQuery('#ModuleDescription').html(loadingimage);

	jQuery.post("addons/GIS/frontpage/module_custom_edit.php", { uid: uid },
			function(data){
				jQuery('#ModuleDescription').html(data);
		  	}
		);
}

function aCopyModule() {
	
	var pid = jQuery('#modules').val();
	jQuery('#Modulename').html("Copy Selected Module To New Module:");

	jQuery('#module-options-dis').hide();
	jQuery('#ModuleDescription').html(loadingimage);
	jQuery.post("addons/GIS/frontpage/copy_module.php", { pid: pid },
			function(data){
				jQuery('#ModuleDescription').html(data);
			  }
		);
}

function aDeleteModule() {
	
	var pid = jQuery('#modules').val();
	jQuery('#Modulename').html("Delete Selected Module.");

	jQuery('#module-options-dis').hide();
	jQuery('#ModuleDescription').html(loadingimage);
	jQuery.post("addons/GIS/frontpage/delete_module.php", { pid: pid },
			function(data){
				jQuery('#ModuleDescription').html(data);
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
        Using the Module Editor is very simple, in the box below you will see a list of modules that are currently defined.  Select a module then on the right you will have options for the module.
    </div> <!-- end div.box-contents -->
</div> <!-- end div.rounded-box -->
<br><br>  -->

<table valign="top"><tr valign="top"><td valign="top">
<div id='moduleslist'>

<div class='gis-content' style="display:none" id="module-functions">
<a href="javascript:aCopyModule();" id="copypackage" alt="Copy Module To a New Module"><img src="addons/GIS/frontpage/images/copypackage.png" alt="Copy a Module to a new Module." border="0" width="32" height="32" align="right"></a>
<a href="javascript:aDeleteModule();" id="deletepackage"><img src="addons/GIS/frontpage/images/deletepackage.png" alt="Delete a Module." border="0" width="32" height="32" align="right"></a><br></div>
<div><a href="javascript:aNewModule();" id="copypackage" alt="Copy Module To a New Module"><img src="addons/GIS/frontpage/images/copypackage.png" alt="Create a New Custom Module." border="0" width="32" height="32" align="right"></a></div>
<select name="modules" size="5" id="modules" class="moduleslist" onClick="ModuleSelected(this.form)">
   
<?php 
	//Build a list of modules in the select list 
	$query = "select * from g_FPModules where Type='999' order by Name;";		
	$request = mysql_query($query);
	while ($rs = mysql_fetch_array($request)){	
		echo "<option value=\"" . $rs['uid'] . "\">" . $rs['Name'] . "</option>";
	}

?>
 </select><br></br>
 
</div></td><td valign="top">

<div id='Moduledetails'><br>&nbsp;
<table><tr><td>
	<div id="Modulename">
	Select A Module
	</div></td></tr>
	<tr><td>
	<div id="ModuleDescription">
	<---- Select a module on the left to set options, Copy or Delete
	</div>
	</td></tr>
	<tr><td>
	
	</td></tr></table>
</div>
</td></tr></table>

<div style='clear:both;'></div>
<div class='gis-content padding-rl-20' style="display:none" id="module-options-dis">xxxxxxxxxxxxxx</div>

