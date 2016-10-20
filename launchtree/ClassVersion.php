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

class ModVersion
{
	function versioninfo()
	{
		$title = title;
		$version = version;
	
		$lv = $this->versioncheck();
		
		$latestversion = $lv[0];
		$upgradeURL = $lv[1];
		$box_image=$lv[2];
		$addonsuppt = $lv[3];

		$upgrade = (version < $latestversion) ? "<a target=_blank href=$upgradeURL><font color=Red>Download Current Release.</font></a>" : "<font color=green>You have the latest version.</font>" ;
		$currentv = $latestversion;

		$html="<table width='500' cellpadding='2' cellspacing='0' border='0' align='center'>
	<tr>
		<td align='center' valign='top' class='admin_index_news_border'>
			<table width='100%' cellpadding='2' cellspacing='0' border='0'>
				<tr>

					<td style=\"width: 100px;valign:top\" rowspan=2>
					<img src='$box_image'></td>

					<td style=\"width: 115px\">Installed Version:<br>$version</td>
					<td style=\"width: 115px\">Current Release:<br>$currentv</td>
					<td colspan=\"2\"><center>$upgrade</center></td>
				</tr>
				<tr>
					<td colspan=3 align=\"center\"><a href=\"$addonsuppt\" target=\"_blank\">$title Support</a>
					</td>
				</tr>
			</table>

		</td>
	</tr>
</table>
";
		return $html;
	}

	function versioncheck(){
		$title = title;
		//get the addons
		$theaddons = $this->readAddonsFile();
		//split them up
		$line = $this->in_array_column($title,$theaddons);
		$line = ereg_replace("#.*$","",$line);
	    list($name,$value,$url,$box,$suptlnk) = explode("|",$line);
	    $mb_info[trim($name)] = array(trim($value),trim($url),trim($box),trim($suptlnk));
	    return $mb_info[$title];    
	}

	function in_array_column($title, $theaddons)
	{
		$title = title;
	    if (!empty($theaddons) && is_array($theaddons))
	    {
	        for ($i=0; $i < count($theaddons); $i++)
	        {
    	        $r1=explode("|",$theaddons[$i]);
    	        if (preg_match("/$title/i",$r1[0]))
    	        { 
    	        	return $theaddons[$i];
    	        }
    	    }
    	}
    	return false;
	}

	function readAddonsFile()
	{
		$myaddons=array();
		$file = "http://rap-tools.com/version/addons.txt";
		$fp   = @fopen($file,"r");
		if ($fp) {
		    while($line = @fgets($fp,1024))
		    {
		    	$myaddons[]=$line;
		    }
		    fclose($fp);
		}
		return $myaddons;
	}
}
?>