<?
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright ©2008 Rapid Action Profits. All Rights Reserved
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

session_start();

function RAPmde_dwnld($oto)
{
	global $productID;
	global $group;
	global $addon;
	global $RAPmde_dldtypes;
	global $sys_domain;

	$RAPmde_dldtypes = "ace avi bmp doc exe gif jpg mid mp3 mpg pdf png ppt rar txt ttf wav xls zip";
	
	$sql="SELECT * FROM addons
	WHERE title='Multi-Download Extension'";
		
	$result = mysql_query ($sql);
	$rows = mysql_num_rows ($result);
	if ($rows > 0)
	{
		$row = mysql_fetch_assoc ($result);
		mysql_free_result ($result);
		
		$group = $row['groupfolder'];
		$addon = $row['addonfolder'];

		#get download folder
		#___________________
		
		$sql = "SELECT * FROM products 
			WHERE id = $productID";
			
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		
		$install_folder = $row[install_folder];
		
		if ($oto == 0)
		{
			$RAPmde_path = $row[item_download];
		} else {
			$RAPmde_path = $row[oto_download];
		}
	}

	#--------------------------------------------------------------------------
	# "File Name" attributes:
	# You can change the way the "file name" link looks
	# with the following variables.
	#--------------------------------------------------------------------------

	$display_filename = 1;  #------------------- Display the "File Name" link? 0 = no 1 = yes
	$display_filename_tag = "<b>";  #----------- html on tags for "File Name"
	$display_filename_tag_end = "</b>";  #------ html "off" tags for "File Name"
	$display_filename_font = "tahoma";  #------- Font for "File Name"
	$display_filename_size = "2";  #------------ Font size for "File Name"

	#--------------------------------------------------------------------------
	# "File Type" attributes:
	# You can change the way the "File Type" looks
	# with the following variables.
	#--------------------------------------------------------------------------

	$display_filetype = 1;  #------------------- Display the "File Type"? 0 = no 1 = yes
	$display_filetype_tag = "<b><i>";  #-------- html on tags for "File Type"
	$display_filetype_tag_end = "</i></b>";  #-- html "off" tags for "File Type"
	$display_filetype_font = "tahoma";  #------- Font for "File Type"
	$display_filetype_size = "1";  #------------ Font size for "File Type"
	$display_filetype_color = "black";  #------ Font Color for "File type"

	#--------------------------------------------------------------------------
	# "File Size" attributes:
	# You can change the way the "File Size" looks
	# with the following variables.
	#--------------------------------------------------------------------------

	$display_filesize = 1;  #------------------- Display the "File Size"? 0 = no 1 = yes
	$display_filesize_tag = "<b>";  #----------- html on tags for "File Size"
	$display_filesize_tag_end = "</b>";  #------ html "off" tags for "File Size"
	$display_filesize_font = "tahoma";  #------- Font for "File Size"
	$display_filesize_size = "1";  #------------ Font size for "File Size"

	# get table layout
	#_________________
	
	$query = "SELECT * FROM RAPmde_layout 
		WHERE productID = $productID 
		AND otoflag = $oto";
			
	$result = mysql_query($query);
	$rows = mysql_num_rows($result);
		
	if ($rows > 0)
	{
		$row = mysql_fetch_assoc ($result);
		mysql_free_result ($result);
	
		$tblwidth = $row['width'];
		$color1 = $row['color1'];
		$color2 = $row['color2'];
	
		$aFiles = array();

		$tmp = strrchr("$RAPmde_path",'.');
		if ($tmp!=false)
		{
			# we have a file name in download location
			#_________________________________________
			
			$tmp = strrchr($RAPmde_path,'/');			// /download.zip
			$path = str_replace($tmp,'/',$RAPmde_path);	// dlds/
			$aFiles[] = substr($tmp,1);					// download.zip
			$RAPmde_path =  $_SERVER[DOCUMENT_ROOT].$install_folder.$path;
			
		} else {
			# we have a folder name in download location
			#___________________________________________
			
			$query = "SELECT * FROM RAPmde_files 
				WHERE productID = $productID 
					AND otoflag = $oto
				ORDER BY item_download";

			$result = mysql_query($query);
			
			while ($row = mysql_fetch_assoc($result))
			{
				$aFiles[] = $row['item_download'];
			}
		}
	
		ob_start();
		
		foreach($aFiles as $file)
		{
			# Get all the file attributes.
			#-----------------------------
			$size = filesize("$RAPmde_path$file");
   			$type = filetype("$RAPmde_path$file");
   			$ext = strrchr("$RAPmde_path$file",'.');
			$ext = substr ($ext, 1, 3);
			$ext = (strtolower($ext));
			$modified = stat("$RAPmde_path$file");
			$displayname = str_replace (strrchr ($file, "."), "", $file);
			$iconfile = "icons/$ext.gif";
			$xtrainfo = "$ext file";

			# If it is a file (not a directory) and the file extention is in $RAPmde_dldtypes..
			#-------------------------------------------------------------------------------

			if (($type == file) && (preg_match ("/$ext/i", $RAPmde_dldtypes))) 
			{
				# Format the Dispayed filename.. replace underscore with a space
				# and Change each word to start with an upper case letter.
				#---------------------------------------------------------------
				$displayname = str_replace("_"," ",$displayname);
				$displayname = strtolower($displayname);
				$displayname = ucwords($displayname);
				$filedate = date("m-d-y",$modified[9]);

				# Fix and format Byte Length
				#---------------------------
				if ($size < pow(2,10))
					$size = "$size B";
				if ($size >= pow(2,10) && $size < pow(2,20)) 
					$size = round($size / pow(2,10), 2)." KB";
				if ($size >= pow(2,20) && $size < pow(2,30)) 
					$size = round($size / pow(2,20), 2)." MB";
				if ($size > pow(2,30)) 
					$size = round($size / pow(2,30), 2)." GB";

				# Alternate colors on table rows.
				#--------------------------------
				if ($color == $color1){
					$color = $color2;
				}else{
					$color = $color1;
				}

				echo <<< END
					<table align='center' width='$tblwidth' border="0" cellspacing="0" cellpadding="0">
				       <tr bgcolor='$color'>
				       <td width='50%' valign='top' align='left'>
				       		<br />
							$display_filename_tag<font size='$display_filename_size' face='$display_filename_font'>
							<a href='./index.php?action=mdwld&fn=$file&oto=$oto'>
			        		$displayname</a>$display_filename_tag_end<br>
							<font face='$display_filetype_font' color='$display_filetype_color' size='$display_filetype_size'>$display_filetype_tag$xtrainfo$display_filetype_tag_end</font>
						</td>
			        	<td align='right' width='12%' valign='middle'><font size='$display_filesize_size' face='$display_filesize_font'>$display_filesize_tag Size<br>$size</font>$display_filesize_tag_end</td>
						<td align='middle' width='12%'>
							<br />
							<a href='./index.php?action=mdwld&fn=$file&oto=$oto'>
				        	<img border='0' src='http://$sys_domain/rap_admin/addons/$group/$addon/$iconfile'></a>
				        	<br />&nbsp;
			        	</td>
					</tr></table>
END;
			}
		}
		$mdTable = ob_get_clean();
		$obef = ob_get_flush();
		return $mdTable;
	}
}

if ( ($_REQUEST[action]=='download') || ($_REQUEST[action]=='squeeze') || ($_REQUEST[action]=='declineoto') || ($_REQUEST[dld]==1) || ($_REQUEST[oto]==1) )
{
	$sql="select * from admin LIMIT 1";
	$arec=@mysql_query($sql);
	$arow=@mysql_fetch_array($arec);

	$sys_version = $arow['ver'];
	$sys_domain = strtolower($arow['domain']);

	$productID=$_SESSION[product];

	$query = "SELECT * FROM RAPmde_layout 
		WHERE productID = $productID"; 
			
	$result = mysql_query($query);
	$rows = mysql_num_rows($result);
		
	if ($rows > 0)
	{
		if (($_REQUEST['dld']==1) || ($_REQUEST['oto']==1))
		{
			$otoflag = 1;
		} else {
			$otoflag = 0;
		}

		$sql="SELECT * FROM addons
			WHERE title='Multi-Download Extension'";
		
		$result = mysql_query ($sql);
		$rows = mysql_num_rows ($result);
		if ($rows > 0)
		{
			$row = mysql_fetch_assoc ($result);
			mysql_free_result ($result);
		
			$group = $row['groupfolder'];
			$addon = $row['addonfolder'];

			#get download folder
			#___________________
	
			$sql = "SELECT * FROM products 
				WHERE id = $productID";
				
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result);
	
			if ($otoflag == 1)
			{
				$RAPmde_path = $row[item_download];
			} else {
				$RAPmde_path = $row[oto_download];
			}
		}

		$mdTable = RAPmde_dwnld(0);
		$contentPre = preg_replace('/<a.*?action=dwnld&oto=[0].*?>.*?<\/a>/i', $mdTable , $contentPre);
	
		$mdTable2 = RAPmde_dwnld(1);
		$contentPre = preg_replace('/<a.*?action=dwnld&oto=[1].*?>.*?<\/a>/i', $mdTable2 , $contentPre);
	}
}
?>