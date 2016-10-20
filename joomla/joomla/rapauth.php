<?php
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
 
jimport('joomla.event.plugin');
 

class plgAuthenticationMyauth extends JPlugin
{

    function plgAuthenticationMyauth(& $subject) {
        parent::__construct($subject);
    }
 
    function onAuthenticate( $username, $password, &$response )
    {
        
    	//first, query the remote site to get the latest info for the account
        $file = "http://rap-tools.com/rap_admin/addons/GIS/regmgr/verify.php?pr=" . $title . "&dn=" . $_SERVER['HTTP_HOST'];
		$file = str_replace(" ", "%20", $file);
		
		$fp   = @fopen($file,"r");
		if ($fp) {
		    while($line = @fgets($fp,1024))
		    {
		    	$fullLine .= $line;
		    }
		    fclose($fp);
		}
		
		$fullLine = ereg_replace("#.*$","",$fullLine);
	    list($rem_name, $rem_username, $rem_email, $rem_password, $remoteUserStatus) = explode("|",$fullLine);
    	
    	//lookup to see if a local user account exists
        $db =& JFactory::getDBO();
        $query = 'SELECT `id`'
            . ' FROM #__users'
            . ' WHERE username=' . $db->quote( $username );
        $db->setQuery( $query );
        $result = $db->loadResult();
 
        if (!$result) {
        	if ($remoteUserStatus == 1) {
        		//insert new user record
        		$query = "insert into #__users (name, username, email, password, usertype, block,sendEmail, gid, registerDate) VALUES ('" . $rem_name . "', '" . $rem_username . "', '" . 
        		$rem_email . "', '" . md5($password) . "', 'Registered', '0', '0', '" . $rem_gid . "', '" . date("Y-m-d H:i:s") . "'";
        		$db->setQuery( $query );
        		
        		$query = "INSERT INTO `jos_core_acl_aro` VALUES (NULL, 'users', '" . mysql_insert_id() . "', 0, '" . $rem_name . "', 0);";
        		$db->setQuery( $query );
        		
				$query = "INSERT INTO `jos_core_acl_groups_aro_map` VALUES (25, '', '" . mysql_insert_id() . "');";
				$db->setQuery( $query );
        		
        	} else if ($remoteUserStatus == 0) {
            	$response->status = JAUTHENTICATE_STATUS_FAILURE;
            	$response->error_message = 'Membership not active';
        	} else {
            	$response->status = JAUTHENTICATE_STATUS_FAILURE;
            	$response->error_message = 'User does not exist';
        	
        	}
        }
       
        if($result || $remoteUserStatus == 1)
        {
        	//set password to use (use joomla if the record existed)
        	if ($result) 
        		$passwd == $result['password'];
        	else
        		$passwd == md5($rem_password);
        		
        	if ($passwd == $password) {
            	$email = JUser::getInstance($result); // Bring this in line with the rest of the system
            	$response->email = $email->email;
            	$response->status = JAUTHENTICATE_STATUS_SUCCESS;
        	}
        	else
        	{
            	$response->status = JAUTHENTICATE_STATUS_FAILURE;
            	$response->error_message = 'Invalid username and password';
        	}
        }
    }
}
?>
