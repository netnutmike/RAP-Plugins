<?

function gis_log_debug_info($g_logCookies, $g_logRequest, $g_logServer, $g_logType) {
	
	global $salesletter, $productID, $action, $dc, $header, $footer, $filename, $rightnow;

	# Open Logfile
	$g_flhndl = fopen("g_debug_log", "a");
	
	# Log Basics
	switch ($g_logType) {
		case 1:
			$g_outputString = "\"" . $rightnow . "\", \"" . $action . "\", \"" . $productID . "\", \"" . $_COOKIE['aff'] . "\", \"" . $dc . "\", \"" . $header . "\", \"" . $footer . "\", \"" . $filename . "\"\r\n";
			break;
		default:
			$g_outputString = "\r\n" . $rightnow . ": action=" . $action . ", Product ID=" . $productID . ", Affiliate=" . $_COOKIE['aff'] . ", Discount Code=" . $dc . ", Header File=" . $header . ", Footer=" . $footer . ", Filename=" . $filename . "\r\n";	
			break;
	}
	fwrite($g_flhndl, $g_outputString);
	
	if ($g_logRequest) {
		foreach ($_REQUEST as $key => $value) {
			switch ($g_logType) {
				case 1:
					$g_outputString = "\"_REQUEST\", \"" . $key . "\", \"" . $value . "\"\r\n";
					break;
				default:
					$g_outputString = "REQUEST: Key=" . $key . ", Value=" . $value . "\r\n";	
					break;
				}
			fwrite($g_flhndl, $g_outputString);
  			}	
		}
	 
	if ($g_logCookies) {
		foreach ($_COOKIE as $key => $value) {
			switch ($g_logType) {
				case 1:
					$g_outputString = "\"_COOKIE\", \"" . $key . "\", \"" . $value . "\"\r\n";
					break;
				default:
					$g_outputString = "COOKIE: Key=" . $key . ", Value=" . $value . "\r\n";	
					break;
				}
			fwrite($g_flhndl, $g_outputString);
  			}	
		}
		
	if ($g_logServer) {
		foreach ($_SERVER as $key => $value) {
			switch ($g_logType) {
				case 1:
					$g_outputString = "\"_SERVER\", \"" . $key . "\", \"" . $value . "\"\r\n";
					break;
				default:
					$g_outputString = "SERVER: Key=" . $key . ", Value=" . $value . "\r\n";	
					break;
				}
			fwrite($g_flhndl, $g_outputString);
  			}	
		}
		

	
	fclose($g_flhndl);
}

function day_match($newtime, $days) {
	$daycode = Array("SU", "MO", "TU", "WE", "TH", "FR", "SA");
	
	if (stripos(" " . $days,$daycode[date("w", $newtime)]) > 0) 
		return true;
	else
		return false;
}

function doCron() {
	//check for any cron jobs that need to be serviced
	$qry = "Select * from g_cron where Status='1' and (NextRun < '" . date("YmdHi") . "' or NextRun is NULL)";
	//echo $qry . "<br>";
	$gid=mysql_query($qry);
	
	if (mysql_num_rows($gid) > 0) {
		while ($grow=mysql_fetch_array($gid)) {
			switch ($grow['Type']) {
				case '1':		//internal 
					$return = fopen( "http://" . $_SERVER['HTTP_HOST'] . "/rap_admin/addons/GIS/raptools/bld_ctrl_fls.php","r");
					break;
				case '2':		//Web 
					$return = fopen($grow['Action'],"r");
					break;
				case '3':		//command 
					$return = exec($grow['Action']);
					break;
			}
			
			
			//set next run date/time and last run date/time
			//add time
			if (strpos($grow['Time'], ":") > 0) {
				//has to be hour and minutes
				$TimeAdjust = "+1 day";
			} else if (substr($grow['Time'],0,1) == ":") {
				//Time is in minutes of every hour
				$TimeAdjust = "+1 hour";
			} else if (substr($grow['Time'],0,1) == "#") {
				//Time is every # minutes
				$TimeAdjust = "+" . substr($grow['Time'],1) . " minutes";
			} else {
				$TimeAdjust = "+1 day";
			}
			
			if (strlen($grow['NextRun']) < 11)
				$newtime = time();
			else
				$newtime = mktime(substr($grow['NextRun'],8,2),substr($grow['NextRun'],10,2),0,substr($grow['NextRun'],4,2), substr($grow['NextRun'],6,2), substr($grow['NextRun'],0,4));
				
			do {
				$newtime = strtotime( $TimeAdjust, $newtime );
			} while (!day_match($newtime, $grow['Days']));
			
			$updtqry = "update g_cron set NextRun='" . date("YmdHi", $newtime) . "', LastRun='" . date("YmdHis") . "' where uid='" . $grow['uid'] . "'";
			//echo "update query: " . $updtqry . "<br>";
			$upgid=mysql_query($updtqry);
		}
	}
}

function gGetReferrerName($pretext, $posttext)
{
	if(isset($_COOKIE['aff']) || $_REQUEST['e'] != "")
		{   
		if (!isset($_COOKIE['aff']))
			$g_nick = $_REQUEST['e'];
		else
			$g_nick = $_COOKIE['aff'];
			
		$sql="SELECT * FROM nicknames WHERE nickname = '".$g_nick."' or email = '" . $g_nick . "'";
		$gid=mysql_query($sql);
		$grow=mysql_fetch_array($gid);
		
		echo $pretext . " " . $grow['firstname'] . " " . $grow['lastname'] . " " . $posttext;
		}

}


function gGetReferrerEmail()
{
	if(isset($_COOKIE['aff']) || $_REQUEST['e'] != "")
		{   
		if (!isset($_COOKIE['aff']))
			$g_nick = $_REQUEST['e'];
		else
			$g_nick = $_COOKIE['aff'];
			
		$sql="SELECT * FROM nicknames WHERE nickname = '".$g_nick."' or email = '" . $g_nick . "'";
		$gid=mysql_query($sql);
		$grow=mysql_fetch_array($gid);
		
		echo $grow['pref_email'];
		}

}

function gGotoCustomPage($pagename) {
	echo "index.php?action=a&fn=GIS/raptools/custom_file&template=" . $pagename;
}

function gGotoStandardPage($pagename) {
	echo "index.php?action=a&fn=GIS/raptools/std_file&page=" . $pagename;
}
function recursive_remove_directory($directory, $empty=FALSE)
 {
     // if the path has a slash at the end we remove it here
     if(substr($directory,-1) == '/')
     {
         $directory = substr($directory,0,-1);
     }
  
     // if the path is not valid or is not a directory ...
     if(!file_exists($directory) || !is_dir($directory))
     {
         // ... we return false and exit the function
         return FALSE;
  
     // ... if the path is not readable
     }elseif(!is_readable($directory))
     {
         // ... we return false and exit the function
         return FALSE;
  
     // ... else if the path is readable
     }else{
  
         // we open the directory
         $handle = opendir($directory);
  
         // and scan through the items inside
         while (FALSE !== ($item = readdir($handle)))
         {
             // if the filepointer is not the current directory
             // or the parent directory
             if($item != '.' && $item != '..')
             {
                 // we build the new path to delete
                 $path = $directory.'/'.$item;
  
                 // if the new path is a directory
                 if(is_dir($path)) 
                 {
                     // we call this function with the new path
                     recursive_remove_directory($path);
  
                 // if the new path is a file
                 }else{
                     // we remove the file
                     unlink($path);
                 }
             }
         }
         // close the directory
         closedir($handle);
  
         // if the option to empty is not set to true
         if($empty == FALSE)
         {
             // try to delete the now empty directory
             if(!rmdir($directory))
             {
                 // return false if not possible
                 return FALSE;
             }
         }
         // return success
         return TRUE;
     }
 }
 
 
 function g_getAddonXML($g_filename, $g_tokenval) {
	$filecontents = file_get_contents($g_filename);
	$p = xml_parser_create();
	xml_parse_into_struct($p, $filecontents, $vals, $index);
	xml_parser_free($p);
	foreach ($vals as $g_val) {
		if ($g_val['tag'] == $g_tokenval) {
			return $g_val['value'];
		}
	} 
}

function recursive_search($directory, $fl2lk4)
 {
 
     // if the path has a slash at the end we remove it here
     if(substr($directory,-1) == '/')
     {
         $directory = substr($directory,0,-1);
     }
  
     // if the path is not valid or is not a directory ...
     if(!file_exists($directory) || !is_dir($directory))
     {
         // ... we return false and exit the function
         return FALSE;
  
     // ... if the path is not readable
     }elseif(!is_readable($directory))
     {
         // ... we return false and exit the function
         return FALSE;
  
     // ... else if the path is readable
     }else{
  
         // we open the directory
         $handle = opendir($directory);
  
         // and scan through the items inside
         while (FALSE !== ($item = readdir($handle)))
         {
             if($item != '.' && $item != '..')
             {
                 $path = $directory.'/'.$item;
                 // if the new path is a directory
                 if(is_dir($path)) 
                 {
                     // we call this function with the new path
                     $result = recursive_search($path, $fl2lk4);
                     if ($result != FALSE) {
                     	closedir($handle);
         				return $result;
                     }
                 } else {
                     // is this our file?
                     if (strcmp(trim($fl2lk4), trim($item)) == 0) {
                     	return $path;
                     }
                 }
             }
         }
         // close the directory
         closedir($handle);
  
         return FALSE;
     }
 }
 
 
 function gGetOptionChar($g_optionID, $pid, $defaultval) {
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = '" . $g_optionID . "'";
	if ($pid != "") 
		$sql .= " AND productID='" . $pid . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['ValueChar'];
	} else {
		return $defaultval;
	}
}

function gGetOptionInt($g_optionID, $pid, $defaultval) {
	$sql="SELECT * FROM g_raptoolsOptions WHERE OptionID = '" . $g_optionID . "'";
	if ($pid != "") 
		$sql .= " AND productID='" . $pid . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) > 0) {
		$grow=mysql_fetch_array($gid);
		return $grow['ValueInt'];
	} else {
		return $defaultval;
	}
}

function gInsertOptionInt($g_optionID, $pid, $g_value) {
	$sql="INSERT into g_raptoolsOptions (OptionID, productID, ValueInt) VALUES ( '" . $g_optionID . "', '" . $pid . "', '" . $g_value . "')";
	$gid=mysql_query($sql);
}

function gInsertOptionChar($g_optionID, $pid, $g_value) {
	$sql="INSERT into g_raptoolsOptions (OptionID, productID, ValueChar) VALUES ( '" . $g_optionID . "', '" . $pid . "', '" . $g_value . "')";
	$gid=mysql_query($sql);
}
 

function gUpdateOptionInt($g_optionID, $pid, $g_value) {
	$sql = "Select * from g_raptoolsOptions where OptionID='" . $g_optionID . "' AND productID='" . $pid . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) < 1) {
		$sql="INSERT into g_raptoolsOptions (OptionID, productID, ValueInt) VALUES ( '" . $g_optionID . "', '" . $pid . "', '" . $g_value . "')";
		$gid=mysql_query($sql);
	} else {
		$grow=mysql_fetch_array($gid);
		$sql="UPDATE g_raptoolsOptions set ValueInt = '" . $g_value . "' where uid = '" . $grow['uid'] . "'";
		$gid=mysql_query($sql);
	}
}

function gUpdateOptionChar($g_optionID, $pid, $g_value) {
	$sql = "Select * from g_raptoolsOptions where OptionID='" . $g_optionID . "' AND productID='" . $pid . "'";
	$gid=mysql_query($sql);
	if (mysql_num_rows($gid) < 1) {
		$sql="INSERT into g_raptoolsOptions (OptionID, productID, ValueChar) VALUES ( '" . $g_optionID . "', '" . $pid . "', '" . $g_value . "')";
		$gid=mysql_query($sql);
	} else {
		$grow=mysql_fetch_array($gid);
		$sql="UPDATE g_raptoolsOptions set ValueChar = '" . $g_value . "' where uid = '" . $grow['uid'] . "'";
		$gid=mysql_query($sql);
	}
}

function gGetTimeLeft()
{
	global $productID;
	global $sys_item_price;
	
	$g_CountdownActive = gGetOptionInt("PriceCountdown",$productID);

	
	if ($g_CountdownActive == 1) {
		$end_date = gGetOptionChar("EndDate", $productID, "");
	 	$pre_text = gGetOptionChar("PreText", $productID, "");
	 	$post_text = gGetOptionChar("PostText", $productID, "");
	 	$after_text = gGetOptionChar("AfterText", $productID, "");
	 	$end_price = gGetOptionChar("EndPrice", $productID, "");
	 	$count_format = gGetOptionChar("CountFormat", $productID, "");
	 	$end_action = gGetOptionInt("EndAction", $productID, '0');
	 	
	 	if (strlen(trim($end_date)) > 10) 
	 		$g_unx_end_date = mktime(substr($end_date,11,2),substr($end_date, 14,2),0,substr($end_date,0,2),substr($end_date,3,2),substr($end_date,6,4));
	 	else
	 		$g_unx_end_date = mktime(0,0,0,substr($end_date,0,2),substr($end_date,3,2),substr($end_date,6,4));
	 	
	 	if (time() >= $g_unx_end_date)  {
	 		echo $after_text;
	 		
	 		$sql="SELECT * FROM products WHERE id = '" . $productID . "'";
			$gid=mysql_query($sql);
			$grow=mysql_fetch_array($gid);
			
	 		if ($end_action == '1') {
	 			if ($grow['item_price'] != $end_price) {
	 				$sql="UPDATE products set item_price = '" . $end_price . "' WHERE id = '" . $productID . "'";
					$gid=mysql_query($sql);
	 			}
	 		} else {
	 			if ($grow['disabled'] != '1') {
	 				$sql="UPDATE products set disabled = '1' WHERE id = '" . $productID . "'";
					$gid=mysql_query($sql);
	 			}
	 		}
	 		
	 		gUpdateOptionInt("PriceCountdown", $productID, "0");
	 	} else {

			$dateDiff = $g_unx_end_date - time();
			$fullDays = floor($dateDiff/(60*60*24));
			$totalHours = floor($dateDiff/(60*60));
			$fullHours = (24*$fullDays);
			$hours = $totalHours - $fullHours;
			$minutes = floor((($dateDiff/60) - ($totalHours * 60)));
			
	 		$g_cntOutput = trim($pre_text) . " " . trim($count_format) . " " . trim($post_text);
	 		
	 		$g_cntOutput = str_replace("[DAYS]", $fullDays, $g_cntOutput);
			$g_cntOutput = str_replace("[HOURS]", $hours, $g_cntOutput);
			$g_cntOutput = str_replace("[MINUTES]", $minutes, $g_cntOutput);
			$g_cntOutput = str_replace("[TOTALHOURS]", $totalHours, $g_cntOutput);
			$g_cntOutput = str_replace("[TOTALDAYS]", $fullDays+1, $g_cntOutput);
			$g_cntOutput = str_replace("[NEWPRICE]", $end_price, $g_cntOutput);
			$g_cntOutput = str_replace("[PRICE]", $sys_item_price, $g_cntOutput);

	 		echo " " . trim($g_cntOutput);
	 	}
	}
}

function gGetSalesLeft()
{

}
 
 ?>