<?
//==============================================================================================
//
//	Filename:	page_sources.php
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
//	Description:	This file is called when the page sources are needed
//
//	Version:	1.0.0 (February 23rd, 2010)
//
//	Change Log:
//				02/23/10 - Initial Version (JMM)
//
//==============================================================================================
require_once("../../../settings.php");

	if ($_REQUEST['updateval'] != "") {
		gUpdateOptionInt($_REQUEST['page'], $_REQUEST['pid'], $_REQUEST['updateval']);
		$g_Page = gGetOptionInt($_REQUEST['page'], $_REQUEST['pid'], '0');
	} else {
		$g_Page = gGetOptionInt($_REQUEST['page'], $_REQUEST['pid'], '0');
	}
?>
<br></br>Page Source:<br></br>
<select name="source" size="2" id="source" class="productslist" onClick="SourceSelected(this.form)">
   <option value="0" <? if ($g_Page == 0) { echo "selected"; }?>>Global</option>
   <option value="1" <? if ($g_Page == 1) { echo "selected"; }?>>Product</option>
 </select>
 
