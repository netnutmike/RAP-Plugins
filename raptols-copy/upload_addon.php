<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js' type='text/javascript'></script>

<script>
	jQuery.noConflict();
</script>

<script language="JavaScript">

function aContinue() {

	var cont = jQuery('#main-dis');
	//cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/addons.php", { },
		function(data){
			cont.html(data);
		  	}
		);
}

function aActivate(g_path) {

	var cont = jQuery('#main-dis');
	//cont.html(loadingimage);
	jQuery.get("index.php", { action: 'addon', do: 'install', path: g_path},
		function(data){
			cont.html(data);
		  	}
		);
}

</script>

<?
	include "functions.php";
	
	//find out what our true path is
    $g_rapbasepath = substr(getcwd(),0,strrpos(getcwd(), "/rap_admin"));
?>

<link rel="stylesheet" href="css/styles.css" type="text/css" />

<div class='gis-container-global'>
				<div class='gis-container-admin padding-rl-10'>

					<div class=gis-titlebar>

						<div class='subhead-big left'>Upload Add-on</div>

						<div style='clear:both;'></div>

					</div>
					
<? 	if ($_POST['MAX_FILE_SIZE'] == "" && $_POST['action'] != "manualinstall") { ?>
<div class="paragraph-text">			
<table width="70%"><tr><td>
	<p>To upload a new addon, click the select file button, locate the zip archive file for the addon, click the upload button.</p>

	<p><form enctype="multipart/form-data" method="POST" action="upload_addon.php">
<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
<h2>Choose a file to upload:</h2><br></br> <input name="uploadedfile" type="file" /><br /><br>
<input type="submit" value="Upload File" />
</form>
</p><br></br>
</td></tr></table>	</div>

<? 	} else if ( $_POST['action'] == "manualinstall" ) {

		$g_tempparentfolder = $g_rapbasepath . "/rap_admin/addons/GIS/raptools/" . substr($g_avf,0,strrpos($g_avf,"/"));	
		$g_installPath = $g_rapbasepath . "/rap_admin/addons/" . $_POST['groupname'] . "/" . $_POST['addonname'];
		
		//echo "rename " . $g_tempparentfolder . " to " . $g_installPath . "<br>";
       	rename($g_tempparentfolder, $g_installPath);
        echo "Addon installed (not activated)...<br>Removing Temporary Files...";
         			
        recursive_remove_directory("tmpuploads/");
         			
        echo "<br><br>Install has completed but the addon has not yet been activated.  Click the continue link below.  You will be taken to the main RAP interface so that RAP can find the new addon you just uploaded.<br><br>";
        //echo "<input type=\"button\" name=\"submit\" id=\"submit\" value=\"Activate\" onClick=\"javascript:aActivate(\'" . $g_rapaddonpath . "\');\" target=\"_top\"/>&nbsp;&nbsp;&nbsp;";
        echo "<a href=\"/rap_admin/index.php\" target=\"_top\">Continue...</a> &nbsp;&nbsp;&nbsp;";

	} else { 


		$target_path = "tmpuploads/";
		
		if (!file_exists($target_path))
			mkdir($target_path);

		$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
		//echo "move " . $_FILES['uploadedfile']['tmp_name'] . " to: " . $target_path . "<br>";

		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    		echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
    		" has been uploaded...<br><br>";
    		echo "Unpacking files...";
    		
			$zip = new ZipArchive;
     		$res = $zip->open($target_path);
     		if ($res === TRUE) {
        		$zip->extractTo('tmpuploads/install');
         		$zip->close();
         		
         		
         		//echo "base path: " . $g_rapbasepath . "<br>";
         		
         		echo "  Files Unpacked...<br><br>";
         		echo "Looking for addon_version.xml...";
         		
         		$g_avf = recursive_search("tmpuploads", "addon_version.xml");
         		if ($g_avf != "") {
         			echo "  Found addon_version.xml, reading...<br><br>";
         			echo "Addon Name: <strong>" . g_getAddonXML($g_avf, "NAME") . "</strong><BR>";
         			echo "Addon Version: <strong>" . g_getAddonXML($g_avf, "VERSION") . "</strong><BR>";
         			echo "Addon Release Date: <strong>" . g_getAddonXML($g_avf, "RELEASEDATE") . "</strong><BR><BR>";
         			$g_installPath = $g_rapbasepath . "/rap_admin/addons/" . g_getAddonXML($g_avf, "COMPANYFOLDER") . "/" . g_getAddonXML($g_avf, "ADDONFOLDER");
         			$g_companyPath = $g_rapbasepath . "/rap_admin/addons/" . g_getAddonXML($g_avf, "COMPANYFOLDER");
         			$g_tempparentfolder = $g_rapbasepath . "/rap_admin/addons/GIS/raptools/" . substr($g_avf,0,strrpos($g_avf,"/"));
         			$g_rapaddonpath = g_getAddonXML($g_avf, "COMPANYFOLDER") . "/" . g_getAddonXML($g_avf, "ADDONFOLDER");

         			//check if company folder exists and if not create it
         			if (!file_exists($g_companyPath)) {
         				mkdir($g_companyPath);
         			}
         			
         			//echo "rename " . $g_tempparentfolder . " to " . $g_installPath . "<br>";
         			rename($g_tempparentfolder, $g_installPath);
         			echo "Addon installed (not activated)...<br>Removing Temporary Files...";
         			
         			recursive_remove_directory("tmpuploads/");
         			
         			echo "<br><br>Install has completed but the addon has not yet been activated.  Click the continue link below.  You will be taken to the main RAP interface so that RAP can find the new addon you just uploaded.<br><br>";
         			//echo "<input type=\"button\" name=\"submit\" id=\"submit\" value=\"Activate\" onClick=\"javascript:aActivate(\'" . $g_rapaddonpath . "\');\" target=\"_top\"/>&nbsp;&nbsp;&nbsp;";
         			echo "<a href=\"/rap_admin/index.php\" target=\"_top\">Continue...</a> &nbsp;&nbsp;&nbsp;";
         			
         		} else {
         			echo "Did not find an addon_version.xml file...<br><br>Looking for install.php file...";
         			$g_avf = recursive_search("tmpuploads", "install.php");
         			if ($g_avf != "") {
         				echo "  Found install.php, validating with admin.php...<br><br>";
         				$g_bspath = substr($g_avf,0,strrpos($g_avf,"/"));
         				if (file_exists($g_bspath . "/admin.php")) {
         					$g_addnm = substr($g_bspath, strrpos($g_bspath, "/")+1);
         					$g_grpnm = substr(substr($g_bspath, 0, strrpos($g_bspath, "/")), strrpos(substr($g_bspath, 0, strrpos($g_bspath, "/")-1), "/")+1);
         					echo "  Validated!<br><br>";
         					echo "This addon did not include a addon_version.xml file so we need some information from you and the addon creator.  This information is probably in the manual that is included with the addon.<br><br>";
         					echo "The information we need to complete the installation is where to install the addon.  If we can we will place what we think the installation folder should be.<br><br>";
         					echo "Addons are installed in /rap_admin/addons/GROUPNAME/ADDONNAME where the GROUPNAME is replaced with either a group name or company name and the ADDONNAME.  Most addons need to be installed in a specific directory and it is normally in the manual that came with the addon.<br><br>";
         					echo "Fill in the following 2 fields with the GROUPNAME and ADDONNAME.  We may have put in some suggestions if we thought we figured it out.<br><br>";
         					echo "<form method=\"POST\" action=\"upload_addon.php\">";
         					echo "<input type=\"hidden\" name=\"action\" value=\"manualinstall\">";
         					echo "Group Name:&nbsp;<input type=\"text\" name=\"groupname\" value=\"" . $g_grpnm . "\"><br><br>";
         					echo "Addon Name:&nbsp;<input type=\"text\" name=\"addonname\" value=\"" . $g_addnm . "\"><br><br>";
         					echo "<input type=\"submit\" name=\"submit\" value=\"Install\"><br>";
         					echo "</form>";
         				}
         			} else {
         				echo "  Not Found...<br><br>";
         				echo "<strong>The file uploaded does not appear to be a properly structured addon for RAP.  To install you will have to follow the instructions contained within the addon documentation.</strong>";
         			}
         		}
     		} else {
         		echo "  COULD NOT UNPACK FILES...  INSTALL FAILED!";
     		}
    		
    		
		} else{
    		echo "There was an error uploading the file, please try again!";
		}

 	} ?>
				
				</div>
</div>