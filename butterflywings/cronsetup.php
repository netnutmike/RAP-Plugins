<?
//==============================================================================================
//
//	Filename:	cronsetup.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2009(c), Genius Idea Studio, LLC
//
//	Product Is Available For Download From www.rap-tools.com
//
//	Description:	This file is called when the user wants to setup the cron options. 
//
//	Version:	1.0.0 (February 5th, 2009)
//
//	Change Log:
//				02/05/10 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); 



?>

<script language="JavaScript">

function aAdd() {

	jQuery('#cr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/raptools/cronsetup.php", { action: 'Add' },
					function(data){
						jQuery('#cr-opt-disp').html(data);
				  	}
				);
}

function aEdit(uid) {

	jQuery('#cr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/raptools/cronsetup.php", { action: 'Edit', uid: uid },
					function(data){
						jQuery('#cr-opt-disp').html(data);
				  	}
				);
}

function aCancel() {

	jQuery('#cr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/raptools/cronsetup.php", { },
					function(data){
						jQuery('#cr-opt-disp').html(data);
				  	}
				);
}

function aDelete(uid, Name) {

	jQuery('#cr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/raptools/cronsetup.php", { action: 'Delete', uid: uid, Name: Name },
					function(data){
						jQuery('#cr-opt-disp').html(data);
				  	}
				);
}

function aDeleteDelete(uid) {

	jQuery('#cr-opt-disp').html(loadingimage);
	jQuery.post("addons/GIS/raptools/cronsetup.php", { action: 'DoDelete', uid: uid},
					function(data){
						jQuery('#cr-opt-disp').html(data);
				  	}
				);
}

function aSave(uid) {
	
	var Name 			=	jQuery("#Name").val();
	var Status			=	jQuery("#cron_enabled:checked").val();
	var Time			=	jQuery("#Time").val();
	var Action			=	jQuery("#Action").val();
	var Type			=	jQuery("#Type").val();
	var sunday			=	jQuery("#sunday_enabled:checked").val();
	var monday			=	jQuery("#monday_enabled:checked").val();
	var tuesday			=	jQuery("#tuesday_enabled:checked").val();
	var wednesday		=	jQuery("#wednesday_enabled:checked").val();
	var thursday		=	jQuery("#thursday_enabled:checked").val();
	var friday			=	jQuery("#friday_enabled:checked").val();
	var saturday		=	jQuery("#saturday_enabled:checked").val();
	
	jQuery('#cr-opt-disp').html(loadingimage);

	jQuery.post("addons/GIS/raptools/cronsetup.php", {uid: uid, Name: Name, Status: Status, Time: Time, Type: Type, Actionvar: Action,
		sunday: sunday, monday: monday, tuesday: tuesday, wednesday: wednesday, thursday: thursday, friday: friday, saturday: saturday , action: 'Save' },
					function(data){
						jQuery('#cr-opt-disp').html(data);
				  	}
				);
}

function aCreate() {
	
	var Name 			=	jQuery("#Name").val();
	var Status			=	jQuery("#cron_enabled:checked").val();
	var Time			=	jQuery("#Time").val();
	var Action			=	jQuery("#Action").val();
	var Type			=	jQuery("#Type").val();
	var sunday			=	jQuery("#sunday_enabled:checked").val();
	var monday			=	jQuery("#monday_enabled:checked").val();
	var tuesday			=	jQuery("#tuesday_enabled:checked").val();
	var wednesday		=	jQuery("#wednesday_enabled:checked").val();
	var thursday		=	jQuery("#thursday_enabled:checked").val();
	var friday			=	jQuery("#friday_enabled:checked").val();
	var saturday		=	jQuery("#saturday_enabled:checked").val();
	
	jQuery('#cr-opt-disp').html(loadingimage);

	jQuery.post("addons/GIS/raptools/cronsetup.php", { Name: Name, Status: Status, Time: Time, Type: Type, Actionvar: Action,
		sunday: sunday, monday: monday, tuesday: tuesday, wednesday: wednesday, thursday: thursday, friday: friday, saturday: saturday , action: 'Create' },
					function(data){
						jQuery('#cr-opt-disp').html(data);
				  	}
				);
}

</script>

<script type="text/javascript" src="addons/GIS/raptools/js/rap-tools.js"></script>

<?	if ($_POST['action'] == "Delete") { ?>
		<table>
			<tr><td>
 			You are about to Delete cron job <strong>"<?=$_REQUEST['Name']?>"</strong>.  Please verify by selecting clicking the delete button below:<br>&nbsp;
 
 			<table>

 			<tr><td>&nbsp;</td></tr>
 			<tr><td><div class="rounded-box-red" id="error-box">
    	    <div class="box-contents">
        WARNING!  You are about to delete this cron entry.  <strong>THIS CANNOT BE UNDONE</strong> so be sure it is what you want to do before you click the delete button below!
    		</div> 
		</div></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td align="right">
<input type="button" name="submit" id="submit" value="DELETE" onClick="javascript:aDeleteDelete('<?= $_REQUEST['uid']; ?>');"/>
</td><td align="right">
<input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:aCancel();" />
</td></tr>
 </table>
 
 <? }

 if ($_POST['action'] == "DoDelete") {

	$query = "Delete from g_cron where uid='" . $_REQUEST['uid'] . "'";
	//echo $query . "<br>";
	$gid = mysql_query($query);
		
	echo "<script language=\"JavaScript\">";
	echo "jQuery.post(\"addons/GIS/raptools/cronsetup.php\", {  },
					function(data){
						jQuery('#cr-opt-disp').html(data);
				  	}
				);";
	echo "</script>";
}



 	if ($_POST['action'] == "Save") {

	$dayvar="";
	
	if ($_POST['sunday'] != "undefined" && $_POST['sunday'] != "")
		$dayvar .= " SU";
		
	if ($_POST['monday'] != "" && $_POST['monday'] != "undefined")
		$dayvar .= " MO";
		
	if ($_POST['tueday'] != "" && $_POST['tueday'] != "undefined")
		$dayvar .= " TU";
		
	if ($_POST['wednesday'] != "" && $_POST['wednesday'] != "undefined")
		$dayvar .= " WE";
		
	if ($_POST['thursday'] != "" && $_POST['thursday'] != "undefined")
		$dayvar .= " TH";

	if ($_POST['friday'] != "" && $_POST['friday'] != "undefined")
		$dayvar .= " FR";
		
	if ($_POST['saturday'] != "" && $_POST['saturday'] != "undefined")
		$dayvar .= " SA";
		
	$query = "Update g_cron set Name='" . $_REQUEST['Name'] . "', Status='" . $_REQUEST['Status'] . "', Time='" . $_REQUEST['Time'] . 
	"', Action='" . $_REQUEST['Actionvar'] . "', Days='" . $dayvar . "', Type='" . $_REQUEST['Type'] . "' where uid='" . $_REQUEST['uid'] . "'";
	//echo $query . "<br>";
	$gid = mysql_query($query);
		
	echo "<script language=\"JavaScript\">";
	echo "jQuery.post(\"addons/GIS/raptools/cronsetup.php\", {  },
					function(data){
						jQuery('#cr-opt-disp').html(data);
				  	}
				);";
	echo "</script>";
}
	
 if ($_POST['action'] == "Create") {

	$dayvar="";
	
	if ($_POST['sunday'] != "undefined" && $_POST['sunday'] != "")
		$dayvar .= " SU";
		
	if ($_POST['monday'] != "" && $_POST['monday'] != "undefined")
		$dayvar .= " MO";
		
	if ($_POST['tueday'] != "" && $_POST['tueday'] != "undefined")
		$dayvar .= " TU";
		
	if ($_POST['wednesday'] != "" && $_POST['wednesday'] != "undefined")
		$dayvar .= " WE";
		
	if ($_POST['thursday'] != "" && $_POST['thursday'] != "undefined")
		$dayvar .= " TH";

	if ($_POST['friday'] != "" && $_POST['friday'] != "undefined")
		$dayvar .= " FR";
		
	if ($_POST['saturday'] != "" && $_POST['saturday'] != "undefined")
		$dayvar .= " SA";
		
	$query = "insert into g_cron (Name, Status, Time, Action, Days, Type) VALUES ('" . $_REQUEST['Name'] . "', '" . $_REQUEST['Status'] . "', '" . $_REQUEST['Time'] . 
	"', '" . $_REQUEST['Actionvar'] . "', '" . $dayvar . "', '" . $_REQUEST['Type'] . "')";
	//echo $query . "<br>";
	$gid = mysql_query($query);
		
	echo "<script language=\"JavaScript\">";
	echo "jQuery.post(\"addons/GIS/raptools/cronsetup.php\", {  },
					function(data){
						jQuery('#cr-opt-disp').html(data);
				  	}
				);";
	echo "</script>";
 }
	?>


 <? if (trim($_REQUEST['action']) == "") { ?>
<table>
<tr><td colspan="13" align="right"><a href="javascript:aAdd();"><img src="addons/GIS/raptools/images/add32x32.png" border="0"></a></td></tr>
<tr class="Prompts"><td class="Prompts"><strong>Name</strong></td><td></td><td align="center"><strong>Days</strong></td><td></td><td align="center"><strong>Time</strong></td><td></td><td align="center"><strong>Type</strong></td><td></td><td align="center"><strong>Status</strong></td><td></td><td><strong>Last Run</strong></td><td></td><td align="center"><strong>Options</strong></td></tr>

<?php 
	$query = "select * from g_cron";		
	$gid = mysql_query($query);
	
	if ( mysql_num_rows($gid) < 1 ) {
		echo "<tr><td colspan=\"9\"><i>No Cron Jobs have been setup.  Click the add button above to add one</i></td></tr>";
	} else {
		while ($grow = mysql_fetch_array($gid)) { 
			switch ($grow['Status']) {
				case '0':
					$ststxt = "Disabled";
					$stsbg = " bgcolor=\"#ee0000\"";
					break;
				case '1':
					$ststxt = "Enabled";
					$stsbg = "";
					break;
				} 
				
				switch ($grow['Type']) {
					case '1':
						$typevar = "Internal";
						break;
					case '2':
						$typevar = "Web";
						break;
					case '3':
						$typevar = "Command";
						break;
				}
				
			$glastRunDate = substr($grow['LastRun'],4,2) . "/" . substr($grow['LastRun'],6,2) . "/" . substr($grow['LastRun'],0,4) . " " . substr($grow['LastRun'],8,2) . ":" . substr($grow['LastRun'],10,2) . ":" . substr($grow['LastRun'],12,2)?>
			<tr class="Prompts"><td><?= $grow['Name']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><?= $grow['Days']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $grow['Time']; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $typevar; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"<?= $stsbg;?>><?= $ststxt; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td align="center"><?= $glastRunDate; ?></td><td>&nbsp;&nbsp;&nbsp;</td><td><a href="javascript:aEdit('<?= $grow['uid']; ?>')"><img src="addons/GIS/raptools/images/edit32x32.png" border="0"></a>&nbsp;&nbsp;<a href="javascript:aDelete('<?= $grow['uid']; ?>', '<?= $grow['Name']; ?>')"><img src="addons/GIS/raptools/images/delete32x32.png" border="0"></a>&nbsp;</td>
  			</tr>
<? 			}
	} ?>  
  <tr><td>
  
</td></tr></table>
<? } 

 if ($_REQUEST['action'] == "Edit") { ?>
	<table>
		<tr><td>
 
 			<table>
 <? 
	 
	//load options
	$query = "select * from g_cron where uid='" . $_REQUEST['uid'] . "'";		
	$gid = mysql_query($query);
	$grow = mysql_fetch_array($gid);
	 
 ?>
 
 <tr><td><strong>Cron Options:</strong></td><td></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td colspan="2">
 	<table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="5">
 		<ul class="checklist">
			<li>
				<input id="cron_enabled" name="cron_enabled" value="1" type="checkbox" <? if ($grow['Status'] == '1') echo "checked"; ?>>
				<a href="javascript:void(0);" id="aseti"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
				<label for=""cron_enabled"">Cron Entry Enabled</label>
            	<a class="checkbox-select" href="#">Select</a>
            	<a class="checkbox-deselect" href="#">Cancel</a>
            </li>
		</ul>
		<tr><td colspan="1"></td><td colspan="2"><div class='gis-content padding-rl-20 width-465' style="display:none" id="aseti-desc">If this option is checked, this cron entry will be activated at the defined time.</div></td></tr>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Name:</td><td align="left"><input type="text" name="Name" id="Name" value="<? echo $grow['Name']; ?>">
		</td><td><a href="javascript:void(0);" id="namei"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
		</td></tr>
		<tr><td colspan="2"></td><td><div class='gis-content padding-rl-20 width-465' style="display:none" id="namei-desc">This is the friendly name of this cron entry and it to help you identify it.</div></td></tr>

		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Days:</td><td align="left">
		
		</td><td><a href="javascript:void(0);" id="daysi"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
		</td></tr>
		<tr><td colspan="2"></td><td><div class='gis-content padding-rl-20 width-465' style="display:none" id="daysi-desc">In this area ou select the days of the week you want this cron action to run.</div></td></tr>
		<tr><td></td><td></td><td>
		
			<ul class="checklist">
				<li>
					<input id="sunday_enabled" name="sunday_enabled" value="1" type="checkbox" <? if (strpos(" " . $grow['Days'], "SU") > 0 ) echo "checked"; ?>>
					<label for=""sunday_enabled"">Sunday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="monday_enabled" name="monday_enabled" value="1" type="checkbox" <? if (strpos(" " . $grow['Days'], "MO") > 0 ) echo "checked"; ?>>
					<label for=""sunday_enabled"">Monday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="tuesday_enabled" name="tuesday_enabled" value="1" type="checkbox" <? if (strpos(" " . $grow['Days'], "TU") > 0 ) echo "checked"; ?>>
					<label for=""tuesday_enabled"">Tuesday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="wednesday_enabled" name="wednesday_enabled" value="1" type="checkbox" <? if (strpos(" " . $grow['Days'], "WE") > 0 ) echo "checked"; ?>>
					<label for=""wednesday_enabled"">Wednesday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="thursday_enabled" name="thursday_enabled" value="1" type="checkbox" <? if (strpos(" " . $grow['Days'], "TH") > 0 ) echo "checked"; ?>>
					<label for=""thursday_enabled"">Thursday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="friday_enabled" name="friday_enabled" value="1" type="checkbox" <? if (strpos(" " . $grow['Days'], "FR") > 0 ) echo "checked"; ?>>
					<label for=""friday_enabled"">Friday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="saturday_enabled" name="saturday_enabled" value="1" type="checkbox" <? if (strpos(" " . $grow['Days'], "SA") > 0 ) echo "checked"; ?>>
					<label for=""saturday_enabled"">Saturday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
		
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Time:</td><td align="left"><input type="text" name="Time" id="Time" value="<? echo $grow['Time']; ?>">
		</td><td><a href="javascript:void(0);" id="timei"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
		</td></tr>
		<tr><td colspan="2"></td><td><div class='gis-content padding-rl-20 width-465' style="display:none" id="timei-desc">This is the time in 24 hours format hh:mm that this cron entry should run.</div></td></tr>

		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Type:</td><td align="left"><select name="Type" size="1" id="Type" onClick="javascript:showHideCronOptionsSections()">
    		<option value="1" <? if ($grow['Type'] == '1') echo "selected"; ?>>Internal Maintenance</option>
    		<option value="2" <? if ($grow['Type'] == '2') echo "selected"; ?>>Web Call</option>
    		<option value="3" <? if ($grow['Type'] == '3') echo "selected"; ?>>Command Execute</option>
  		</select>
		</td><td><a href="javascript:void(0);" id="typei"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
		</td></tr>
		<tr><td colspan="2"></td><td><div class='gis-content padding-rl-20 width-465' style="display:none" id="typei-desc">This is the time in 24 hours format hh:mm that this cron entry should run.</div></td></tr>

		
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Action:</td><td align="left"><div id="actiondiv" style="display:none"><input type="text" name="Action" id="Action" value="<? echo $grow['Action']; ?>"></div>
		</td><td><a href="javascript:void(0);" id="actioni"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
		</td></tr>
		
		<tr><td colspan="2"></td><td><div class='gis-content padding-rl-20 width-465' style="display:none" id="actioni-desc">This is the action (web or cmd depending on selection) that is to executed when this cron item is run.</div></td></tr>

	</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td align="right">
		<input type="button" name="submit" id="submit" value="Save" onClick="javascript:aSave('<?= $grow['uid']; ?>');"/>
		</form>
	</td><td align="right"><input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:aCancel();"/></td></tr>
 </table>
</td></tr>
</table>


<script type='text/javascript'>
jQuery(document).ready(function() {

	
    /* see if anything is previously checked and reflect that in the view*/
    jQuery(".checklist input:checked").parent().addClass("selected");
 
    /* handle the user selections */
    jQuery(".checklist .checkbox-select").click(
        function(event) {
            event.preventDefault();
            jQuery(this).parent().addClass("selected");
            jQuery(this).parent().find(":checkbox").attr("checked","checked");
            showHideCronOptionsSections();
        }
    );
 
    jQuery(".checklist .checkbox-deselect").click(
        function(event) {
            event.preventDefault();
            jQuery(this).parent().removeClass("selected");
            jQuery(this).parent().find(":checkbox").removeAttr("checked");
            showHideCronOptionsSections();
        }
    );

    
    showHideCronOptionsSections();

	jQuery("#aseti").click(function() {
		
		jQuery("#aseti-desc").toggle();

	});

	jQuery("#namei").click(function() {
		
		jQuery("#namei-desc").toggle();

	});

	jQuery("#daysi").click(function() {
		
		jQuery("#daysi-desc").toggle();

	});

	jQuery("#timei").click(function() {
		
		jQuery("#timei-desc").toggle();

	});

	jQuery("#actioni").click(function() {
		
		jQuery("#actioni-desc").toggle();

	});

	jQuery("#typei").click(function() {
		
		jQuery("#typei-desc").toggle();

	});	


});

</script>

<? } 



if ($_REQUEST['action'] == "Add") { ?>
	<table>
		<tr><td>
 
 			<table>

 
 <tr><td><strong>New Cron Options:</strong></td><td></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td colspan="2">
 	<table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="5">
 		<ul class="checklist">
			<li>
				<input id="cron_enabled" name="cron_enabled" value="1" type="checkbox" checked>
				<a href="javascript:void(0);" id="aseti"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
				<label for=""cron_enabled"">Cron Entry Enabled</label>
            	<a class="checkbox-select" href="#">Select</a>
            	<a class="checkbox-deselect" href="#">Cancel</a>
            </li>
		</ul>
		<tr><td colspan="1"></td><td colspan="2"><div class='gis-content padding-rl-20 width-465' style="display:none" id="aseti-desc">If this option is checked, this cron entry will be activated at the defined time.</div></td></tr>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Name:</td><td align="left"><input type="text" name="Name" id="Name" >
		</td><td><a href="javascript:void(0);" id="namei"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
		</td></tr>
		<tr><td colspan="2"></td><td><div class='gis-content padding-rl-20 width-465' style="display:none" id="namei-desc">This is the friendly name of this cron entry and it to help you identify it.</div></td></tr>

		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Days:</td><td align="left">
		
		</td><td><a href="javascript:void(0);" id="daysi"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
		</td></tr>
		<tr><td colspan="2"></td><td><div class='gis-content padding-rl-20 width-465' style="display:none" id="daysi-desc">In this area you select the days of the week you want this cron action to run.</div></td></tr>
		<tr><td></td><td></td><td>
		
			<ul class="checklist">
				<li>
					<input id="sunday_enabled" name="sunday_enabled" value="1" type="checkbox" checked>
					<label for=""sunday_enabled"">Sunday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="monday_enabled" name="monday_enabled" value="1" type="checkbox" checked>
					<label for=""sunday_enabled"">Monday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="tuesday_enabled" name="tuesday_enabled" value="1" type="checkbox" checked>
					<label for=""tuesday_enabled"">Tuesday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="wednesday_enabled" name="wednesday_enabled" value="1" type="checkbox" checked>
					<label for=""wednesday_enabled"">Wednesday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="thursday_enabled" name="thursday_enabled" value="1" type="checkbox" checked>
					<label for=""thursday_enabled"">Thursday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="friday_enabled" name="friday_enabled" value="1" type="checkbox" checked>
					<label for=""friday_enabled"">Friday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
			
			<ul class="checklist">
				<li>
					<input id="saturday_enabled" name="saturday_enabled" value="1" type="checkbox" checked>
					<label for=""saturday_enabled"">Saturday</label>
            		<a class="checkbox-select" href="#">Select</a>
            		<a class="checkbox-deselect" href="#">Cancel</a>
           	 	</li>
			</ul>
		
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Time:</td><td align="left"><input type="text" name="Time" id="Time" value="0000">
		</td><td><a href="javascript:void(0);" id="timei"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
		</td></tr>
		<tr><td colspan="2"></td><td><div class='gis-content padding-rl-20 width-465' style="display:none" id="timei-desc">This is the time in 24 hours format hh:mm that this cron entry should run.</div></td></tr>

		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Type:</td><td align="left"><select name="Type" size="1" id="Type" onClick="javascript:showHideCronOptionsSections()">
    		<option value="1" selected>Internal Maintenance</option>
    		<option value="2">Web Call</option>
    		<option value="3">Command Execute</option>
  		</select>
		</td><td><a href="javascript:void(0);" id="typei"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
		</td></tr>
		<tr><td colspan="2"></td><td><div class='gis-content padding-rl-20 width-465' style="display:none" id="typei-desc">This is the time in 24 hours format hh:mm that this cron entry should run.</div></td></tr>

		
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Action:</td><td align="left"><div id="actiondiv" style="display:none"><input type="text" name="Action" id="Action"></div>
		</td><td><a href="javascript:void(0);" id="actioni"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
		</td></tr>
		
		<tr><td colspan="2"></td><td><div class='gis-content padding-rl-20 width-465' style="display:none" id="actioni-desc">This is the action (web or cmd depending on selection) that is to executed when this cron item is run.</div></td></tr>

	</td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td align="right">
		<input type="button" name="submit" id="submit" value="Save" onClick="javascript:aCreate();"/>
		</form>
	</td><td align="right"><input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:aCancel();"/></td></tr>
 </table>
</td></tr>
</table>


<script type='text/javascript'>
jQuery(document).ready(function() {

	
    /* see if anything is previously checked and reflect that in the view*/
    jQuery(".checklist input:checked").parent().addClass("selected");
 
    /* handle the user selections */
    jQuery(".checklist .checkbox-select").click(
        function(event) {
            event.preventDefault();
            jQuery(this).parent().addClass("selected");
            jQuery(this).parent().find(":checkbox").attr("checked","checked");
            showHideCronOptionsSections();
        }
    );
 
    jQuery(".checklist .checkbox-deselect").click(
        function(event) {
            event.preventDefault();
            jQuery(this).parent().removeClass("selected");
            jQuery(this).parent().find(":checkbox").removeAttr("checked");
            showHideCronOptionsSections();
        }
    );

    
    showHideCronOptionsSections();

	jQuery("#aseti").click(function() {
		
		jQuery("#aseti-desc").toggle();

	});

	jQuery("#namei").click(function() {
		
		jQuery("#namei-desc").toggle();

	});

	jQuery("#daysi").click(function() {
		
		jQuery("#daysi-desc").toggle();

	});

	jQuery("#timei").click(function() {
		
		jQuery("#timei-desc").toggle();

	});

	jQuery("#actioni").click(function() {
		
		jQuery("#actioni-desc").toggle();

	});

	jQuery("#typei").click(function() {
		
		jQuery("#typei-desc").toggle();

	});	


});

</script>

<? } ?>