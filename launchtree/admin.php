<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.1
| Copyright ©2008 Rapid Action Profits. 
| All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Rapid Action 
| Profits regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.   
|
| ================================================================
| Rapid Action Profits Multi-Download Extension
| ================================================================
+---------------------------------------------------------------------
*/

define(version,'1.0.1');
require_once("ClassVersion.php");

#--------------------------------------------------------------------------
# Display Configuration Page for Product
#--------------------------------------------------------------------------

function configure_md($msg)
{
	$productID=$_SESSION[product];

	#--------------------------------------------------------------------------
	# File types (extensions) eligible for display/download.
	# Files with extentions that are not listed here... are ignored
	#--------------------------------------------------------------------------

	$RAPmde_dldtypes = "ace avi bmp doc exe gif jpg mid mp3 mpg pdf png ppt rar txt ttf wav xls zip";

	#--------------------------------------------------------------------------
	# $thumbsize is the horizontal size of the icon in pixels.
	#--------------------------------------------------------------------------

	$thumbsize = "50";

	#--------------------------------------------------------------------------
	# Background Color set - Alternates background color of download entries.
	#--------------------------------------------------------------------------
	
	$RAPmde_color1 = "#efefef";
	$RAPmde_color2 = "#ffffff";

	#--------------------------------------------------------------------------
	# Width of download table  
	# Can be expressed as percentage (95%)
	# or in pixels (800)
	#--------------------------------------------------------------------------

	$RAPmde_tblwidth = "80%";

	#--------------------------------------------------------------------------
	# "File Name" attributes:
	#--------------------------------------------------------------------------

	$display_filename = 1;  #------------------- Display the "File Name" link? 0 = no 1 = yes
	$display_filename_tag = "<b>";  #----------- html on tags for "File Name"
	$display_filename_tag_end = "</b>";  #------ html "off" tags for "File Name"
	$display_filename_font = "tahoma";  #------- Font for "File Name"
	$display_filename_size = "2";  #------------ Font size for "File Name"

	#--------------------------------------------------------------------------
	# "File Type" attributes:
	#--------------------------------------------------------------------------

	$display_filetype = 1;  #------------------- Display the "File Type"? 0 = no 1 = yes
	$display_filetype_tag = "<b><i>";  #-------- html on tags for "File Type"
	$display_filetype_tag_end = "</i></b>";  #-- html "off" tags for "File Type"
	$display_filetype_font = "tahoma";  #------- Font for "File Type"
	$display_filetype_size = "1";  #------------ Font size for "File Type"
	$display_filetype_color = "black";  #------ Font Color for "File type"

	#--------------------------------------------------------------------------
	# "File Size" attributes:
	#--------------------------------------------------------------------------

	$display_filesize = 1;  #------------------- Display the "File Size"? 0 = no 1 = yes
	$display_filesize_tag = "<b>";  #----------- html on tags for "File Size"
	$display_filesize_tag_end = "</b>";  #------ html "off" tags for "File Size"
	$display_filesize_font = "tahoma";  #------- Font for "File Size"
	$display_filesize_size = "1";  #------------ Font size for "File Size"

	#---------------------------------------------------------------------------

	$q = "SELECT * FROM products WHERE id = '$productID'";
	$result = mysql_query ($q);
	$row = mysql_fetch_assoc ($result);
	mysql_free_result ($result);

	$pname = $row['item_name'];

	$itemname = $row['item_name'];
	$itemdownload = $row['item_download'];
	
	$install_folder = $row['install_folder'];
	$otoflag = $row['oto_flag'];
	$otoname = $row['oto_name'];
	$otodownload = $row['oto_download'];
	
	if(($_POST[frontend] != '1') && ($_POST[backend] != '1') && ($_POST[delprod] != '1'))
	{
		//get addons from the updates file
		$title = title;
		$doversion = new ModVersion;
		$vrs=$doversion->versioninfo();
	
		$delprod= <<< delbutton

		<form method='post'>
			<input type='hidden' name='_submit_check' value='1' />
			<input type='hidden' name='delprod' value='1' />

			<p align='center'>
			<input name=submit type=submit value='Delete Add On For This Product'>
			</p>
		</form>
	
delbutton;

		$addtmpr= <<< addmain

		<form method='post'>
			<input type='hidden' name='_submit_check' value='1' />
			<input type='hidden' name='frontend' value='1' />

			<p align='center'>
			<input name=submit type=submit value='Edit Downloads For Front End'>
			</p>
		</form>
	
addmain;

		$addotopr = '';
		if($otoflag)
		{
			$addotopr= <<< addoto
			<table><tr>
				<td colspan=2 class=style1>
					<form method='post'>
						<input type='hidden' name='_submit_check' value='1'/>
						<input type='hidden' name='backend' value='1' />

						<p align='center'>
						<input name=submit type=submit value='Edit Downloads For Back End'>
						</p>
					</form>
				</td>
			</tr>
			</table>
addoto;
		}
		
	} else if ($_POST[delprod] == '1'){
	
	} else {
		if($_POST[frontend] == '1')
		{
			$otoflag = '0';
		} else {
			$otoflag = '1';
		}
		
		$q = "SELECT * FROM RAPmde_files 
			WHERE productID = '$productID'
			ORDER BY item_download";
		
		$result = mysql_query ($q);
		$row = mysql_fetch_assoc ($result);
		mysql_free_result ($result);
	
		$id_used = $row['id'];

		if(!$id_used)
		{
			$subval	= "Add";
		} else {
			$subval	= "Update";
		}

		$q = "SELECT * FROM RAPmde_layout 
			WHERE productID = '$productID' 
			AND otoflag = '$otoflag'";
		$result = mysql_query ($q);
		$row = mysql_fetch_assoc ($result);
		mysql_free_result ($result);

		$tblwidth = $row['width'];
		$RAPmde_color1=$row['color1'];
		$RAPmde_color2=$row['color2'];

		$title = title;
	
		$addonid=$_REQUEST[id];
		$backtomain="index.php?action=addon&id=$addonid";

		# Read current directory.
		#------------------------
	
		if($otoflag == 1) 
		{
			$itemname = $otoname;
			$itemdownload = $otodownload;
		}
		
		$tmp = strrchr("$itemdownload",'.');
		if ($tmp=="")
		{
			$dldparts = explode("/",$itemdownload);
			$rootparts = explode("/",$_SERVER[DOCUMENT_ROOT]);
			if( (!$dldparts[0]==$rootparts[0]) && (!$dldparts[1]==$rootparts[1]) )
			{
				$path =  $_SERVER[DOCUMENT_ROOT].$install_folder.$itemdownload;
			} else {
				$path = $itemdownload;
			}
			
			$d = dir($path);
		
			while (false !== ($file = $d->read())) 
			{
				if ($file != "." && $file != "..") 
				{
					# Get file attributes.
					#---------------------
					$size = filesize("$path$file");
		 			$type = filetype("$path$file");
		 			$ext = strrchr("$path$file",'.');
					$modified = stat("$path$file");
					$displayname = str_replace (strrchr ($file, "."), "", $file);

					# If the file extension is in $display_list...
					#--------------------------------------------
					if (($type == file) && (preg_match ("/$ext/i", $RAPmde_dldtypes)))
					{
						# Format the Dispayed filename. 
						# Replace underscores with a space
						# and capitalize each word 
						#---------------------------------
						$displayname = str_replace("_"," ",$displayname);
						$displayname = strtolower($displayname);
						$displayname = ucwords($displayname);
						$filedate = date("m-d-y",$modified[9]);
			
						# Format the output.
						#-------------------
						$filename[$totalfiles] = "$displayname|$displayname|$file|$ext|$size|$filedate|$content|$upload_date";

						$totalbytes = $totalbytes + $size;
						$totalfiles++;
					}
				}
			}
			sort ($filename);
		}

		# Build input form for download details
		#--------------------------------------

		$maintable ='';
	
		$addotopr='';
		$addtmpr='';
		if($otoflag == 1) 
		{
			$itemname = $otoname;
			$itemdownload = $otodownload;
		}
		
		$maintable= <<< mt
			<table style='width: 400px' align='center'>
				<form method='post'>
					<input type='hidden' name='_submit_check' value='1'/>
					<input type='hidden' name='otoflag' value='$otoflag'>
				<tr>
					<td class='styleds2' colspan=2>
						<p>&nbsp;</p>
						<p style='text-align: center'><b><u>Edit $itemname Downloads</u></b></p>
						<p>&nbsp;</p>						
					</td>
				</tr>
				<tr>
					<td class='styleds2'>
						<p style='text-align: left'><b>Download Location :</b><br />
						(from Product Setup)</p>
						<p>&nbsp;</p>
					</td>
					<td valign='top'>
						<input name='itemdownload' type='text' value='$itemdownload' />
					</td>
				</tr>
				<tr>
					<td class='styleds2'>
						<p style='text-align: left'><b>Width of Download Table</b>
					</td>
					<td valign='top'>
						<input name='tblwidth' type='text' value='$tblwidth' />
					</td>
				</tr>
				<tr>
					<td class='styleds2'>
						<p style='text-align: left'><b>Row 1 Color </b>
					</td>
					<td valign='top'>
						<input name='RAPmde_color1' type='text' value='$RAPmde_color1' />
					</td>
				</tr>
				<tr>
					<td class='styleds2'>
						<p style='text-align: left'><b>Row 2 Color </b>
					</td>
					<td valign='top'>
						<input name='RAPmde_color2' type='text' value='$RAPmde_color2' />
					</td>
				</tr>
mt;
		if ($tmp=="")
		{
			$maintable.="
				<tr>
					<td colspan=2>
			<table cellSpacing='0' cellPadding='3' width='$table_width' bgColor='$color' border='0' align='center'>
	 		<tbody>
	    		<tr>
	    			<td colspan=3>&nbsp;</td>
	    		</tr>
	    		<tr valign='top'>
	    			<td align='left'><b>File Name</b></td>
	    			<td align='right'><b>Size</b></td>
	    			<td align='center'><b>Selected</b></td>
	    		</tr>
	    		<tr>
	    			<td colspan=3><hr /></td>
	    		</tr>";

			while (list ($key, $val) = each ($filename)) 
			{
				$fileattr = explode("|", $val);
	
				# Fix and format Byte Length
				#---------------------------
				if ($fileattr[4] < pow(2,10)){
					$size = "$fileattr[4] B";
				}
				if ($fileattr[4] >= pow(2,10) && $fileattr[4] < pow(2,20)) {
					$size = round($fileattr[4] / pow(2,10), 2)." KB";
				}
				if ($fileattr[4] >= pow(2,20) && $fileattr[4] < pow(2,30)) {
					$size = round($fileattr[4] / pow(2,20), 2)." MB";
				}
				if ($fileattr[4] > pow(2,30)) {
					$size = round($fileattr[4] / pow(2,30), 2)." GB";
				}

				# Alternate colors on table rows.
				#--------------------------------
				if ($color == $RAPmde_color1){
					$color = $RAPmde_color2;
				}ELSE{
					$color = $RAPmde_color1;
				}
			
				$q = "SELECT * FROM RAPmde_files 
					WHERE productID = $productID
						AND otoflag = $otoflag
						AND item_download = '$fileattr[2]'
					ORDER BY item_download";
			
				$result = mysql_query ($q);
				$row = mysql_fetch_assoc ($result);

				$checked = "";
				if($fileattr[2] == $row[item_download])	
					$checked = " checked=true";			

				# Display the Download Folder.
				#-----------------------------
				$maintable.="
			        <tr>
				        <td width='50%' valign='top' align='left'>
							$display_filename_tag<font size='$display_filename_size' face='$display_filename_font'>
					        $fileattr[2]$display_filename_tag_end</td>
				        <td align='right' width='25%' valign='top'><font size='$display_filesize_size' face='$display_filesize_font'>$display_filesize_tag$size</font>$display_filesize_tag_end</td>
				        <td align='center' width='25%' valign='top'>$display_filesize_tag$addfile</font>
							<input name='addfile.$fileattr[1]' type='checkbox' id='addfile.$fileattr[1]' value='$fileattr[2]' $checked />$display_filesize_tag_end</td>
					</tr> ";
			}
			$maintable.="
					</tbody></table>
				</td>
			</tr>";
		}
		
		$maintable.="
			<tr>
				<td colspan='2' class='style1'><br>
					<p align='center'>
					<input name='submit' type='submit' value='{{subval}} Settings' />
				</td>
			</tr>
			</form>
			<tr>
				<td colspan=2 class=style1><br>
					<form action ='$backtomain' method='post'>
						<input type='hidden' name='type' value='home'>
						<input name='submit' type='submit' value='Back To Main'>
					</form>
				</td>
			</tr>
		</table>
		";
	}

	$dashboard='';

	$dashboard = <<< ds
	<style type='text/css'>
		.styleds1 
		{
			text-align: center;
			font-size: x-large;
			color: #008080;
		}
		.styleds2 
		{
			text-align: center;
		}
	</style>
	<table style='width: 600px' align='center' border=0>
		<tr>
			<td colspan='3' class='styleds1'>
				<strong>$title Admin<br /></strong>
			</td>
		</tr>
		<tr><td colspan='3'>$vrs</td></tr>
		<tr>
			<td colspan='3' class='styleds2'>
				<strong><hr width='80%'></strong>
			</td>
		</tr>
		<tr>
			<td colspan='3' class='styleds2'><strong>$msg</strong></td>
		</tr>
		<tr>
			<td colspan='3' class='styleds2'>
				Configure $title for <b><u>$pname</u></b><br>
				$maintable
				<tr><td>
					<table border='0' align='center'>
						<tr>
							<td align='center'>$addtmpr</td>
							<td align='center'>$addotopr</td>
						</tr>
						<tr>
							<td colspan=2 align='center'>$delprod</td>
						</tr>
					</table>
				</td></tr>
				</table>
ds;

	$dashboard = preg_replace("/{{(.*?)}}/e","$$1",$dashboard) ;

	echo $dashboard;
}

#--------------------------------------------------------------------------
# Main Process
#--------------------------------------------------------------------------

$addonid=$_REQUEST[id];

$productID=$_SESSION[product];

$sql = "SELECT title FROM addons 
	WHERE id = '$addonid'";

$result = mysql_query ($sql);
$r3 = mysql_fetch_assoc ($result);

mysql_free_result ($result);

define(title,$r3['title']);

#--------------------------------------------------------------------------
# Process form submission
#--------------------------------------------------------------------------

if (array_key_exists('_submit_check', $_POST)) 
{	
	// find selected files
	$input=($_POST);
	foreach($input as $key => $value)
	{
		$pos = strpos($key, 'addfile');
		if($pos !== false)
	    	$fileschecked[]=$value;
	}
	unset ($value);
		
	$otoflag = $_POST[otoflag];

	if(trim($_POST['itemdownload']) == "/")
	{
		$itemdownload="/";
	} else {
		$itemdownload=trim($_POST['itemdownload']);
	}
	
	// process layout variable input
	
	if($_POST[tblwidth]<>"")
	{
		$tblwidth = $_POST[tblwidth];
	} else {
		$tblwidth = $RAPmde_tblwidth;
	}
	
	if($_POST[RAPmde_color1])
	{
		$color1 = $_POST[RAPmde_color1];
	} else {
		$color1 = $RAPmde_color1;
	}
		
	if($_POST[RAPmde_color2])
	{
		$color2 = $_POST[RAPmde_color2];
	} else {
		$color2 = $RAPmde_color2;
	}
		
	if($_POST['addfile'])
	{ 
		$addfile=1; 
	} else {
		$addfile=0; 
	}
	
	if(($_POST[frontend] == '1') || ($_POST[backend] == '1'))
	{
		if($_POST[frontend] == '1')
			$otoflag = "0";
		if($_POST[backend] == '1')
			$otoflag = "1";
	} else if ($_POST[delprod] == '1') {
	
		$q = "DELETE FROM RAPmde_layout 
			WHERE productID = $productID";
		mysql_query ($q);
		
		$sql="DELETE FROM RAPmde_files 
			WHERE productID = $productID";
		mysql_query($sql);
		
	} else {

		if($otoflag=='0')
		{
			$sql="UPDATE products SET item_download = '$itemdownload'
				WHERE id = $productID";

			mysql_query ($sql);
		} else {
			$sql="UPDATE products SET oto_download = '$itemdownload'
				WHERE id = $productID";
				
			mysql_query ($sql);
		}
		
		$query = "SELECT * FROM RAPmde_layout 
			WHERE productID = $productID 
			AND otoflag = $otoflag";
			
		$result = mysql_query($query);
		$rows = mysql_num_rows($result);
		
		if (!($rows > 0) )
		{
			$q = "INSERT INTO RAPmde_layout
				(productID, otoflag)
				VALUES ($productID,$otoflag)";
			mysql_query($q);
		}
		
		$q = "UPDATE RAPmde_layout 
			SET width='$tblwidth',color1='$color1',color2='$color2'	
			WHERE productID = $productID
			AND otoflag = $otoflag";
		mysql_query ($q);
		
		$sql="DELETE FROM RAPmde_files 
			WHERE productID = '$productID' 
			AND otoflag = $otoflag";
		
		mysql_query($sql);

		if ($fileschecked[0]!="")
		{
			foreach($fileschecked as $key => $value)
			{
				$q = "INSERT INTO RAPmde_files 
					(productID, otoflag, item_download)
					VALUES ($productID,$otoflag,'$value')";
				mysql_query($q);			
			}
		}
	}

}

#--------------------------------------------------------------------------
# Display form
#--------------------------------------------------------------------------

configure_md($msg);
?>