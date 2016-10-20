<?
//==============================================================================================
//
//	Filename:	delete_link.php
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
//	Description:	This file is called when the user wants to delete a file and confirms 
//	the delete request.
//
//	Version:	1.0.0 (February 16th, 2009)
//
//	Change Log:
//				02/16/10 - Initial Version (JMM)
//
//==============================================================================================
?>

<script language="JavaScript">

function aDeleteCancel() {

	jQuery.post("addons/GIS/cloaker/cloaked_links.php", {  },
			function(data){
				jQuery('#cl-opt-disp').html(data);
		  	}
		);
}

function aDeleteDelete(uid) {

	jQuery.post("addons/GIS/cloaker/cloaked_links.php", { uid: uid, action: "Delete" },
					function(data){
						jQuery('#cl-opt-disp').html(data);
				  	}
				);
}

</script>



Link: <? echo $_REQUEST['Name']; ?>

<table>
  <tr><td>
  
  <table><tr><td>
<input type="button" name="submit" id="submit" value="Don't Do It" onClick="javascript:aDeleteCancel();"/>
</td><td>
<input type="button" name="cancel" id="cancel" value="Yes, I Am Sure, Delete" onClick="javascript:aDeleteDelete('<?= $_REQUEST['uid']; ?>');" />
</td></tr></table>
</td></tr></table>

