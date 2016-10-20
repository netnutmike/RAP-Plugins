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

 ?>

<script language="JavaScript">

function aRightArrow() {

	var ModuleID = jQuery('#modules').val();
	
	jQuery.post("addons/GIS/frontpage/selected_modules.php", { SectionID: <?= $_REQUEST['uid']?>, ModuleID: ModuleID, action: "Append" },
					function(data){
						jQuery('#selectedmodules').html(data);
				  	}
				);
}

function aLeftArrow() {

	var uid = jQuery('#selectmodules').val();
	
	jQuery.post("addons/GIS/frontpage/selected_modules.php", { SectionID: <?= $_REQUEST['uid']?>, uid: uid, action: "Delete" },
					function(data){
						jQuery('#selectedmodules').html(data);
				  	}
				);
}

function aUpArrow() {

	var uid = jQuery('#selectmodules').val();
	
	jQuery.post("addons/GIS/frontpage/selected_modules.php", { SectionID: <?= $_REQUEST['uid']?>, uid: uid, action: "Up" },
					function(data){
						jQuery('#selectedmodules').html(data);
				  	}
				);
}

function aDownArrow() {

	var uid = jQuery('#selectmodules').val();
	
	jQuery.post("addons/GIS/frontpage/selected_modules.php", { SectionID: <?= $_REQUEST['uid']?>, uid: uid, action: "Down" },
					function(data){
						jQuery('#selectedmodules').html(data);
				  	}
				);
}

function LeftSelected(form) {
	
	jQuery('#rightbutton').show();
	
}
</script>

<?
	$sql="select * from g_FPSections where uid='" . $_POST['uid'] . "'";
	$gid=mysql_query($sql);
	$grow = mysql_fetch_array($gid);
	
?>
<table width="650" cellspacing="0">
<tr bgcolor="#fd9423"><td colspan="3" align="center"><font color="#FFFFFF">
<? 		echo "<p class=\"georgia-medium\">Module Selection and Options for: " . $grow['SectionName'] . "</p>";
		
?>

</font></td></tr>
<tr><td>
 	
 	<tr bgcolor="#dac8b6"><td align="left" class="Prompts">&nbsp;
 	</td><td></td><td align="right" class="Prompts"></td></tr>
 	<tr><td>&nbsp;</td></tr>
<tr><td>
 	<table align="center">
 	<tr><td>
 	<select name="modules" size="8" style="width:225px" id="modules" class="layoutslist" onClick="LeftSelected(this.form)">
   
<?php 
	//Build a list of layouts in the select list 
	$query = "select * from g_FPModules order by Name;";		
	$request = mysql_query($query);
	while ($rs = mysql_fetch_array($request)){	
		echo "<option value=\"" . $rs['uid'] . "\">" . $rs['Name'] . "</option>";
	}

?>
 </select>
 	</td><td>&nbsp;&nbsp;</td><td width="80" align="center"><div id="rightbutton" class='gis-content ' style="display:none"><a href="javascript:aRightArrow();"><img src="addons/GIS/frontpage/images/next.png" alt="--->" border="0"></a></div><br><div id="leftbutton" class='gis-content padding-rl-20' style="display:none"><a href="javascript:aLeftArrow();"><img src="addons/GIS/frontpage/images/back.png" alt="<---" border="0"></a></div></td><td>&nbsp;&nbsp;</td><td width="310">
<div id="selectedmodules"></div> 	
 	</td><td width="75"><div id="upbutton" class='gis-content padding-rl-20' style="display:none"><a href="javascript:aUpArrow();"><img src="addons/GIS/frontpage/images/up.png" alt="^" border="0"></a></div><br>
 	<div id="downbutton" class='gis-content padding-rl-20' style="display:none"><a href="javascript:aDownArrow();"><img src="addons/GIS/frontpage/images/download.png" alt="v" border="0"></a></div></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	

 		</table>
 		</td></tr></td></tr>
 		
 		<tr><td><div id="ModuleOptions"></div></td></tr>
 		
 		</table>


<script type='text/javascript'>

jQuery(document).ready(function(){

	//jQuery('#selectedmodules').html(loadingimage);
	
	jQuery.post("addons/GIS/frontpage/selected_modules.php", { SectionID: <?= $_REQUEST['uid']?> },
				function(data){
					jQuery('#selectedmodules').html(data);
			  	}
			);
})
</script>
