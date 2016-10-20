<?
//==============================================================================================
//
//	Filename:	file_edit.php
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
//	Description:	This file is called when the edit button is pressed or the editor 
//					accordion is opened. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/23/09 - Initial Version (JMM)
//
//==============================================================================================
?>

<?php  require_once("../../../settings.php"); ?>

<script language="JavaScript">

function TagSelected(form) {

	var tt = (jQuery('#tags :selected').text());
		
	jQuery('#Tagname').html(tt.replace("<","&lt;"));
	var fln = jQuery('#tags').val();

	jQuery.post("addons/GIS/editor/token_description.php", { tag: fln},
			function(data){
				jQuery('#TagDescription').html(data);
		  	}
		);
	jQuery('#TagbRow').show();

}

function aInsertTag() {
	
	var tt = (jQuery('#tags :selected').text());
	var tt = tt.replace("\x3C?", "&lt;.?");
	//var tt = tt.replace("?>", "...)");

	tinyMCE.execCommand('mceInsertRawHTML',false,tt);
	
}

function aCancel() {
	jQuery('#fl-edit-content').hide();
}

function aSave() {

	tinyMCE.activeEditor.save();
	var tmpname =	"<? echo $_POST['tmpname']; ?>";
	var filename =	"<? echo $_POST['filename']; ?>";
	var data =	jQuery("#elm1").val();
	var data = data.replace(/&lt;.\?/g, "\x3C?");
	var data = data.replace(/\?&gt;/g, "?\x3E");
	var action = "1";
	jQuery.post("addons/GIS/themes/editfile.php", { tmpname: tmpname, filename: filename, data: data, action: action },
					function(data){
						jQuery('#fl-edit-content').html(data);
				  	}
				);
}


</script>

<script type="text/javascript">
	 tinyMCE.init({
		// General options
		mode : "exact",
		theme : "advanced",
		elements : "elm1",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,fullpage",

		// Theme options
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak|fullpage",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		valid_elements : ""
			+"a[accesskey|charset|class|coords|dir<ltr?rtl|href|hreflang|id|lang|name"
			  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
			  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rel|rev"
			  +"|shape<circle?default?poly?rect|style|tabindex|title|target|type],"
			+"abbr[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"acronym[class|dir<ltr?rtl|id|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"address[class|align|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
			  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
			  +"|onmouseup|style|title],"
			+"applet[align<bottom?left?middle?right?top|alt|archive|class|code|codebase"
			  +"|height|hspace|id|name|object|style|title|vspace|width],"
			+"area[accesskey|alt|class|coords|dir<ltr?rtl|href|id|lang|nohref<nohref"
			  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
			  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup"
			  +"|shape<circle?default?poly?rect|style|tabindex|title|target],"
			+"base[href|target],"
			+"basefont[color|face|id|size],"
			+"bdo[class|dir<ltr?rtl|id|lang|style|title],"
			+"big[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"blockquote[cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick"
			  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
			  +"|onmouseover|onmouseup|style|title],"
			+"body[alink|background|bgcolor|class|dir<ltr?rtl|id|lang|link|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onload|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|onunload|style|title|text|vlink],"
			+"br[class|clear<all?left?none?right|id|style|title],"
			+"button[accesskey|class|dir<ltr?rtl|disabled<disabled|id|lang|name|onblur"
			  +"|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup|onmousedown"
			  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|tabindex|title|type"
			  +"|value],"
			+"caption[align<bottom?left?right?top|class|dir<ltr?rtl|id|lang|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|style|title],"
			+"center[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"cite[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"code[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"col[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
			  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
			  +"|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title"
			  +"|valign<baseline?bottom?middle?top|width],"
			+"colgroup[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl"
			  +"|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
			  +"|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title"
			  +"|valign<baseline?bottom?middle?top|width],"
			+"dd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
			  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
			+"del[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
			  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
			  +"|onmouseup|style|title],"
			+"dfn[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"dir[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
			  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
			  +"|onmouseup|style|title],"
			+"div[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|style|title],"
			+"dl[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
			  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
			  +"|onmouseup|style|title],"
			+"dt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
			  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
			+"em/i[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"fieldset[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"font[class|color|dir<ltr?rtl|face|id|lang|size|style|title],"
			+"form[accept|accept-charset|action|class|dir<ltr?rtl|enctype|id|lang"
			  +"|method<get?post|name|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
			  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onreset|onsubmit"
			  +"|style|title|target],"
			+"frame[class|frameborder|id|longdesc|marginheight|marginwidth|name"
			  +"|noresize<noresize|scrolling<auto?no?yes|src|style|title],"
			+"frameset[class|cols|id|onload|onunload|rows|style|title],"
			+"h1[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|style|title],"
			+"h2[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|style|title],"
			+"h3[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|style|title],"
			+"h4[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|style|title],"
			+"h5[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|style|title],"
			+"h6[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|style|title],"
			+"head[dir<ltr?rtl|lang|profile],"
			+"hr[align<center?left?right|class|dir<ltr?rtl|id|lang|noshade<noshade|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|size|style|title|width],"
			+"html[dir<ltr?rtl|lang|version],"
			+"iframe[align<bottom?left?middle?right?top|class|frameborder|height|id"
			  +"|longdesc|marginheight|marginwidth|name|scrolling<auto?no?yes|src|style"
			  +"|title|width],"
			+"img[align<bottom?left?middle?right?top|alt|border|class|dir<ltr?rtl|height"
			  +"|hspace|id|ismap<ismap|lang|longdesc|name|onclick|ondblclick|onkeydown"
			  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
			  +"|onmouseup|src|style|title|usemap|vspace|width],"
			+"input[accept|accesskey|align<bottom?left?middle?right?top|alt"
			  +"|checked<checked|class|dir<ltr?rtl|disabled<disabled|id|ismap<ismap|lang"
			  +"|maxlength|name|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect"
			  +"|readonly<readonly|size|src|style|tabindex|title"
			  +"|type<button?checkbox?file?hidden?image?password?radio?reset?submit?text"
			  +"|usemap|value],"
			+"ins[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
			  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
			  +"|onmouseup|style|title],"
			+"isindex[class|dir<ltr?rtl|id|lang|prompt|style|title],"
			+"kbd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"label[accesskey|class|dir<ltr?rtl|for|id|lang|onblur|onclick|ondblclick"
			  +"|onfocus|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
			  +"|onmouseover|onmouseup|style|title],"
			+"legend[align<bottom?left?right?top|accesskey|class|dir<ltr?rtl|id|lang"
			  +"|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|style|title],"
			+"li[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
			  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title|type"
			  +"|value],"
			+"link[charset|class|dir<ltr?rtl|href|hreflang|id|lang|media|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|rel|rev|style|title|target|type],"
			+"map[class|dir<ltr?rtl|id|lang|name|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"menu[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
			  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
			  +"|onmouseup|style|title],"
			+"meta[content|dir<ltr?rtl|http-equiv|lang|name|scheme],"
			+"noframes[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"noscript[class|dir<ltr?rtl|id|lang|style|title],"
			+"object[align<bottom?left?middle?right?top|archive|border|class|classid"
			  +"|codebase|codetype|data|declare|dir<ltr?rtl|height|hspace|id|lang|name"
			  +"|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|standby|style|tabindex|title|type|usemap"
			  +"|vspace|width],"
			+"ol[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
			  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
			  +"|onmouseup|start|style|title|type],"
			+"optgroup[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|style|title],"
			+"option[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick|ondblclick"
			  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
			  +"|onmouseover|onmouseup|selected<selected|style|title|value],"
			+"p[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|style|title],"
			+"param[id|name|type|value|valuetype<DATA?OBJECT?REF],"
			+"pre/listing/plaintext/xmp[align|class|dir<ltr?rtl|id|lang|onclick|ondblclick"
			  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
			  +"|onmouseover|onmouseup|style|title|width],"
			+"q[cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"s[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
			  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
			+"samp[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"script[charset|defer|language|src|type],"
			+"select[class|dir<ltr?rtl|disabled<disabled|id|lang|multiple<multiple|name"
			  +"|onblur|onchange|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
			  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|size|style"
			  +"|tabindex|title],"
			+"small[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"span[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
			  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
			  +"|onmouseup|style|title],"
			+"strike[class|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
			  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
			  +"|onmouseup|style|title],"
			+"strong/b[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"style[dir<ltr?rtl|lang|media|title|type],"
			+"sub[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"sup[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title],"
			+"table[align<center?left?right|bgcolor|border|cellpadding|cellspacing|class"
			  +"|dir<ltr?rtl|frame|height|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rules"
			  +"|style|summary|title|width],"
			+"tbody[align<center?char?justify?left?right|char|class|charoff|dir<ltr?rtl|id"
			  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
			  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
			  +"|valign<baseline?bottom?middle?top],"
			+"td[abbr|align<center?char?justify?left?right|axis|bgcolor|char|charoff|class"
			  +"|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup"
			  +"|style|title|valign<baseline?bottom?middle?top|width],"
			+"textarea[accesskey|class|cols|dir<ltr?rtl|disabled<disabled|id|lang|name"
			  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
			  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect"
			  +"|readonly<readonly|rows|style|tabindex|title],"
			+"tfoot[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
			  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
			  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
			  +"|valign<baseline?bottom?middle?top],"
			+"th[abbr|align<center?char?justify?left?right|axis|bgcolor|char|charoff|class"
			  +"|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick"
			  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
			  +"|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup"
			  +"|style|title|valign<baseline?bottom?middle?top|width],"
			+"thead[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
			  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
			  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
			  +"|valign<baseline?bottom?middle?top],"
			+"title[dir<ltr?rtl|lang],"
			+"tr[abbr|align<center?char?justify?left?right|bgcolor|char|charoff|class"
			  +"|rowspan|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title|valign<baseline?bottom?middle?top],"
			+"tt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
			  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
			+"u[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
			  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
			+"ul[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
			  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
			  +"|onmouseup|style|title|type],"
			+"var[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
			  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
			  +"|title]",
		

		// Example content CSS (should be your site CSS)
		content_css : "addons/GIS/themes/css/content.css",
		
		height : 600,
		width  : 700

	});
</script>




		
<? 	if ($_POST['tmpname'] != "" && $_POST['filename'] != ""  && $_POST['filename'] != "undefined") {
	
	$sourcefile = "themes/" . $_POST['tmpname'] . "/" . $_POST['filename'];
	
 	if ($_POST['action'] == 1 ) {
		// save file
		$filecontents = str_replace("/rap_admin/addons/GIS/themes/themes/" . $_POST['tmpname'] . "/images/", "images/", $_POST['data']);
		$filecontents = str_replace("addons/GIS/themes/themes/" . $_POST['tmpname'] . "/images/", "images/", $filecontents);
		$g_flwrstatus = file_put_contents($sourcefile,stripslashes($filecontents));
		 
		if ($g_flwrstatus !== false) {?>
		<div class="rounded-box-green" id="fil-sav-msg">
    	    <div class="box-contents"><strong>Good News!!</strong></font>
        <br><font style="font-size: 14px;"><i>
        		Your file was saved!
    		</div> 
		</div>
		<script type="text/javascript">
			
			jQuery('#fil-sav-msg').fadeOut(20000);
		</script>
<?		} else { ?>
		<div class="rounded-box-red" id="fil-sav-msg">
    	    <div class="box-contents"><strong>Uh Oh... Something Went Wrong</strong></font>
        <br><font style="font-size: 14px;"><i>
        		We could not save your file.
    		</div> 
		</div>
		<script type="text/javascript">
			
			jQuery('#fil-sav-msg').fadeOut(20000);
		</script>
<?		}
	} ?>
	


<textarea id="elm1" name="elm1">
<? 
	$filecontents = file_get_contents($sourcefile); 
	$filecontents = str_replace("images/", "/rap_admin/addons/GIS/themes/themes/" . $_POST['tmpname'] . "/images/", $filecontents);
	$lookfor = chr(60) . "?";
	$filecontents = str_replace($lookfor, "&lt;.?",$filecontents);
	echo htmlentities($filecontents); 
?>
</textarea>
<br>
<table width="700"><tr><td>
<input type="image" name="submit" src="/rap_admin/addons/GIS/themes/images/save.png" value="Save" onClick="javascript:aSave();"/></td><td align="right">
<input type="image" name="cancel" src="/rap_admin/addons/GIS/themes/images/delete48x48.png" value="Don't Save" onClick="javascript:aCancel();" /></td></tr></table>
<br><br>
<div class="rounded-box">
    <!-- Content -->
    <div class="box-contents">
        Insert common tokens into your template from the list below.
    </div> <!-- end div.box-contents -->
</div>
<table><tr><td>
<div id='taglist'>
<select name="tags" size="10" id="tags" class="fileslist" onClick="TagSelected(this.form)">
   
<?php 
	$sqlt="select * from tokens";
	$tokn=mysql_query($sqlt);
	while ($trow=mysql_fetch_array($tokn)) {
		echo "<option value=\"" . $trow['uid'] . "\">" . str_replace("<", "&lt;",$trow['tag']) . "</option>";
		}

?>
 </select>
</div></td><td valign="top">

<div id='tagdetails'>
<table><tr><td>
	<div id="Tagname">
	Select A Token
	</div></td></tr>
	<tr><td>
	<div id="TagDescription">
	<---- Select a token on the left to insert it into your text.  Place the cursor where you want to insert it first, then select the token and click the insert button below.  Please note that tokens when inserted into the editor will have <.? in the beginning but when saved are saved properly.
	</div>
	</td></tr>
	<tr><td>
	<div id="TagbRow" style="display:none">
	<a href="javascript:aInsertTag();" id="inserttag"><img src="addons/GIS/editor/images/add.png" alt="Insert the Selected Tag/Token into the current location of the editor." border="0"></a>
	</div>
	</td></tr></table>
</div>
</td></tr></table>
<? } else { ?>


Before you can edit a file you need to select a file from the file list above.

<? } ?>