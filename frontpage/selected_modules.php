<?php 

//==============================================================================================
//
//	Filename:	module_custom_edit.php
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
//	Description:	This file is called to edit the custom module code
//
//	Version:	1.0.0 (February 17th, 2010)
//
//	Change Log:
//				02/17/10 - Initial Version (JMM)
//
//==============================================================================================


require_once("../../../settings.php"); 

if ($_POST['action'] == "Append" ) {

	$sql = "select * from g_FPSectionModules where SectionID='" . $_POST['SectionID'] . "' order by Orderid Desc";
	$gid=mysql_query($sql);
	$grs = mysql_fetch_array($gid);
	
	$nextnum = $grs['Orderid'] + 1;
	
	$sql = "insert into g_FPSectionModules (SectionID, ModuleID, Orderid) VALUES ('" . $_POST['SectionID'] . "', '" . $_POST['ModuleID'] . "', '" . $nextnum . "')";
	$gid=mysql_query($sql);
	} 
	
if ($_POST['action'] == "Delete" ) {

	$sql = "select * from g_FPSectionModules where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	$grs = mysql_fetch_array($gid);
	$section = $grs['SectionID'];
	$orderid = $grs['Orderid'];
	
	$sql = "delete from g_FPSectionModules where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	
	$sql = "select * from g_FPSectionModules where Orderid >= '" . $orderid . "' AND SectionID='" . $section . "' order by Orderid";
	$gid=mysql_query($sql);
	while ($grow = mysql_fetch_array($gid)){
		$sql2 = "update g_FPSectionModules set Orderid = '" . $orderid . "' where uid='" . $grow['uid'] . "'";
		$gid2=mysql_query($sql2);
		++$orderid;
		}	
	} 

	if ($_POST['action'] == "Up" ) {

		$sql = "select * from g_FPSectionModules where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql);
		$grs = mysql_fetch_array($gid);
		$orderid = $grs['Orderid'];
	
		$sql = "select * from g_FPSectionModules where Orderid <'" . $orderid . "' and SectionID='" . $_REQUEST['SectionID'] . "' order by Orderid DESC";
		$gid=mysql_query($sql);
		
		//if my buttons are working correctly, we should never receive an up for the top item, but just in case....
		if (mysql_num_rows($gid) > 0) {
		
			$grs = mysql_fetch_array($gid);
			$orderid2 = $grs['Orderid'];
	
			$sql = "Update g_FPSectionModules set Orderid='" . $orderid . "' where uid='" . $grs['uid'] . "'";
			$gid=mysql_query($sql);
	
			$sql = "Update g_FPSectionModules set Orderid='" . $orderid2 . "' where uid='" . $_POST['uid'] . "'";
			$gid=mysql_query($sql);
		}
	
	}
	
	if ($_POST['action'] == "Down" ) {

		$sql = "select * from g_FPSectionModules where uid='" . $_POST['uid'] . "'";
		$gid=mysql_query($sql);
		$grs = mysql_fetch_array($gid);
		$orderid = $grs['Orderid'];
	
		$sql = "select * from g_FPSectionModules where Orderid >'" . $orderid . "' and SectionID='" . $_REQUEST['SectionID'] . "' order by Orderid";
		$gid=mysql_query($sql);
	
		//if my buttons are working correctly, we should never receive a down for the bottom item, but just in case....
		if (mysql_num_rows($gid) > 0) {
			$grs = mysql_fetch_array($gid);
			$orderid2 = $grs['Orderid'];
	
			$sql = "Update g_FPSectionModules set Orderid='" . $orderid . "' where uid='" . $grs['uid'] . "'";
			$gid=mysql_query($sql);
	
			$sql = "Update g_FPSectionModules set Orderid='" . $orderid2 . "' where uid='" . $_POST['uid'] . "'";
			$gid=mysql_query($sql);
		}
	
	}
	
?>
<script language="JavaScript">
function RightSelected(form) {
	
	jQuery('#leftbutton').show();

	var elSel = document.getElementById('selectmodules');
	if (elSel.options[0].selected) {
		jQuery('#upbutton').hide();
		jQuery('#downbutton').show();
	} else if (elSel.options[(elSel.length - 1)].selected) {
		jQuery('#upbutton').show();
		jQuery('#downbutton').hide();
	} else {
		jQuery('#upbutton').show();
		jQuery('#downbutton').show();
	}

	jQuery('#ModuleOptions').html(loadingimage);

	var uid = jQuery('#selectmodules').val();
	jQuery.post("addons/GIS/frontpage/section_module_options.php", { uid: uid },
				function(data){
					jQuery('#ModuleOptions').html(data);
			  	}
			);
	
}
</script>

<select name="selectmodules" size="8" style="width:225px" id="selectmodules" class="layoutslist" onClick="RightSelected(this.form)">
   
<?php 
	//Build a list of layouts in the select list 
	$query = "select g_FPSectionModules.*, g_FPModules.Name  from g_FPModules, g_FPSectionModules where g_FPSectionModules.SectionID='" . $_REQUEST['SectionID'] . "' AND g_FPSectionModules.ModuleID=g_FPModules.uid order by Orderid;";		
	$request = mysql_query($query);
	while ($rs = mysql_fetch_array($request)){	
		echo "<option value=\"" . $rs['uid'] . "\">" . $rs['Name'] . "</option>";
	}

?>
 </select>
 
 <script type='text/javascript'>

jQuery(document).ready(function(){

	jQuery('#leftbutton').hide();
	jQuery('#upbutton').hide();
	jQuery('#downbutton').hide();
	
})
</script>

