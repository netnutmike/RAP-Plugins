<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright &#169;2009 Genius Idea Studio, LLC. All Rights Reserved
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
| RAP-tools Editor
| ================================================================
+--------------------------------------------------------------------------
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

		$html="<table width='700' cellpadding='2' cellspacing='0' border='0'>
	<tr>
		<td align='center' valign='top' class='admin_index_news_border'>
			<table width='100%' cellpadding='2' cellspacing='0' border='0'>
				<tr>

					<td style=\"width: 170px face: georgia\">Your Version: $version</td>
					<td style=\"width: 170px face georgia\">Current Version: $currentv</td>
					<td ><center>$upgrade</center></td>
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