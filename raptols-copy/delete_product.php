<?
//==============================================================================================
//
//	Filename:	copy_file.php
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
//	Description:	This file is called when the user wants to copy a file. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/23/09 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php"); ?>

<script language="JavaScript">

function aDeleteCancel() {

	jQuery.post("addons/GIS/raptools/products.php", { },
					function(data){
						jQuery('#main-dis').html(data);
				  	}
				);
}

function aDeleteDelete() {

	var delete_product =	jQuery("#delete_product:checked").val();
	var delete_files =	jQuery("#delete_files:checked").val();
	var dodelete = "delete";
	var pid =	jQuery("#pid").html();
	jQuery.post("addons/GIS/raptools/delete_product.php", { delete_product: delete_product, delete_files: delete_files, pid: pid, dodelete: dodelete },
					function(data){
						jQuery('#ProductDescription').html(data);
				  	}
				);
}

function aContinue() {

	var cont = jQuery('#main-dis');
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/products.php", { },
		function(data){
			cont.html(data);
		  	}
		);
}

</script>

<? 

// Delete product settings from db
function delete_product($pid)
{
	//delete product entry
	$g_deletequery = "delete from products where id='" . $pid . "'";
	mysql_query($g_deletequery);
	
	//delete salesletter entries
	$g_deletequery = "delete from salesletters where productID='" . $pid . "'";
	mysql_query($g_deletequery);
	
	//delete email entries
	$g_deletequery = "delete from emails where productID='" . $pid . "'";
	mysql_query($g_deletequery);
	
	//delete coupon entries
	$g_deletequery = "delete from coupons where productID='" . $pid . "'";
	mysql_query($g_deletequery);
	
	//delete rap tools entries
	$g_deletequery = "delete from g_raptoolsOptions where productID='" . $pid . "'";
	mysql_query($g_deletequery);
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
 
// Delete physical files on web serevr
function delete_files($pathnm)
{
		recursive_remove_directory($pathnm);
}

if ($_POST['pid'] != "" && $_POST['dodelete'] != "") {


	$query = "select * from products where id='" . $_REQUEST["pid"] . "'";		
	$request = mysql_query($query);
	$prs = mysql_fetch_array($request); 
			
	//time to make the donuts..... I mean copy the stuff
	if ($_POST['delete_product'] == 1) {
		$g_npid = delete_product($_POST['pid']);
	}
	
	if ($_POST['delete_files'] == 1) {
		$status = delete_files(substr(getcwd(),0,strrpos(getcwd(), "/rap_admin")) . $prs['install_folder']);
	}
	?>
	<table><tr><td>
<div class="rounded-box-green width-500" id="message-box">
    	    <div class="box-contents width-500">
        The delete action has been completed.  If there were errors they will be above this message.  Please note that the product you just deleted will show up in the RAP select product menu until you go to another menu option or refresh the page.  Click the Continue button below to return to the products page in Rap Tools.
    		</div> 
		</div></td></tr><tr><td>
		<div style='clear:both;'></div><br><br>&nbsp;
		<input type="button" name="submit" id="submit" value="Continue..." onClick="javascript:aContinue();"/>
		</td></tr></table>		
<?
} else { ?>

<form id="deleteprod" name="deleteprod" method="post" action="addons/GIS/raptools/copy_product.php">
<?php 
	$query = "select * from products where id='" . $_REQUEST["pid"] . "'";		
	$request = mysql_query($query);
	$prs = mysql_fetch_array($request); ?>
<table>
<tr><td>
 You are about to Delete <strong>"<?=$prs['item_name']?>"</strong>.  Please verify by selecting the following options:<br>&nbsp;
 <div class='gis-content padding-rl-20 width-465' style="display:none" id="pid"><? echo $_REQUEST["pid"]; ?></div>
 <table>

  <tr><td>Delete Options:</td><td></td></tr>
 <r><td>&nbsp;</td></tr>
 <tr><td colspan="2">
 <table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><ul class="checklist">
<li>
<input id="delete_product" name="delete_product" value="1" type="checkbox" >
					<a href="javascript:void(0);" id="dpcif"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="delete_product">Delete Product Setup and Options</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="dpcif-desc">This option will remove all of the product settings defined in RAP including
the sales letter configuration, coupons and emails.</div>
<p>&nbsp;</p>
<ul class="checklist">
<li>
<input id="delete_files" name="delete_files" value="1" type="checkbox" >
					<a href="javascript:void(0);" id="dpff"><img src="addons/GIS/raptools/images/info.png" border="0" align="right"></a>
                    <label for="delete_files">Delete Product Files</label>
                    <a class="checkbox-select" href="#">Select</a>
                    <a class="checkbox-deselect" href="#">Cancel</a></li>

</ul>
<div class='gis-content padding-rl-20 width-465' style="display:none" id="dpff-desc">If you select this option all of the physical files on the web server
will be deleted.  This includes but is not limited to the tmeplates files, images and downloads.</div>
<p>&nbsp;</p>

</div>
</td></tr></table>
</td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td><div class="rounded-box-red" id="error-box">
    	    <div class="box-contents">
        WARNING!  You are about to delete the items you selected above.  <strong>THIS CANNOT BE UNDONE</strong> so be sure it is what you want to do before you click the delete button below!
    		</div> 
		</div></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td align="right">
<input type="button" name="submit" id="submit" value="DELETE" onClick="javascript:aDeleteDelete();"/>
</td><td align="right">
<input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:aDeleteCancel();" />
</td></tr>
 </table>
  </td></tr>
  <tr><td>
  
 
</form>

</td></tr></table>

<? } ?>

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
 
        }
    );
 
    jQuery(".checklist .checkbox-deselect").click(
        function(event) {
            event.preventDefault();
            jQuery(this).parent().removeClass("selected");
            jQuery(this).parent().find(":checkbox").removeAttr("checked");
 
        }
    );

	jQuery("#dpcif").click(function() {
		
		jQuery("#dpcif-desc").toggle();

	});

	jQuery("#dpff").click(function() {
		
		jQuery("#dpff-desc").toggle();

	});

});

</script>