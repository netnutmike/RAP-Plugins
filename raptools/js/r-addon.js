if(typeof addCssToPage != 'function') {
	function addCssToPage( url ) {
	    var head = document.getElementsByTagName('head')[0];
	     var link = document.createElement("link");
	                link.setAttribute("type", "text/css");
	                link.setAttribute("rel", "stylesheet");
	                link.setAttribute("href", url);
	                link.setAttribute("media", "screen");
	                head.appendChild(link);
	}
} 


//var pagerPP = 10;


// will be placed after page loads
$(document).ready(function(){

	$("a.addon_admin_sections").click(function() {

			var clickpar 	=	$(this).parent();

			var pid = clickpar.find('span.productid').html();
			var isoto = clickpar.find('span.isoto').html();
			var cont = clickpar.find('.kunki-content');
			var pa	=	clickpar.find('.panel-action').html();
			if ( cont.css('display') == 'block' || cont.css('display') == '' )
			{
				// get panel, etc... and then toggle viewable.toggle();
				cont.toggle();
				cont.html('');
			}
			else
			{
				cont.toggle();
				cont.html(loadingimage);
				$.post("addons/extrakick/kunaki/admin_content.php", { admin_action: pa, productID: pid, isoto: isoto },
						function(data){
							cont.html(data);

							if ( pa == "mapping" )
								cont.find("select.accountselect").trigger('change')

							if ( pa == "sales") {

								pagerPP = cont.find("div.sale-row-container").parent().parent().parent().find("ul.simplePagerPerPage li.currentPerPage").find("a").html();
								var pagerPPfirst = cont.find("div.sale-row-container").parent().parent().parent().find("ul.simplePagerPerPage li:first-child").find("a").html();
								var samepagerPP = (pagerPP==pagerPPfirst);

								cont.find("div.sale-row-container").parent().quickPager({
										pagerLocation:"both",
										pageSize:pagerPP,
										currentPage:"1"
									});



								var ppdiv = $("<div class='georgia small left' style='display:; text-align:right;'>page<br>no.</div>");
								var ppdivall = $("<div class='georgia small left' style='display:; text-align:right;padding-top:5px; padding-left:15px;'>All records are shown</div>");
								var ppdivtoshow = (!samepagerPP) ? ppdiv : ppdivall ;
								cont.find("div.sale-row-container").parent().parent().parent().find('.simplePagerContainer').parent().prepend(ppdivtoshow);

							}

							setupFormSubmit(cont);

					  	}
					);


			}
		});

	$("a.pagerPPset").live("click",function(){
			

			var nldr = $(this).parent().parent().parent().find(".navie-loader");
			if (nldr.html()=='')
				nldr.html(loadingimage);
			nldr.toggle();

			pagerPP = $(this).html();
			$(this).parent().parent().find("li").each(function(){
					$(this).removeClass("currentPerPage");
					if ($(this).find("a.pagerPPset").html()==pagerPP) {
						$(this).addClass("currentPerPage");
					}						
				});

			var pagerPPfirst = $(this).parent().parent().find("li:first-child").find("a").html();
			var samepagerPP = (pagerPP==pagerPPfirst);

			var ediv = $(this).parent().parent().parent().parent().find("div.entire-sales-panel");

			// remove current menu
			ediv.find("div.simplePagerContainer").find("ul.simplePagerNav").remove();
			ediv.html(ediv.find("div.simplePagerContainer").html());
			
			// remove class additions to the sub-divs
			var ppi = 1;
			ediv.find("div.sale-row-container[class*='simplePagerPage']").each(function(){
					var cna = $(this).attr('className').split(" ");
				    $(this).removeClass(cna[cna.length-1]);
				});

			ediv.find("div.sale-row-container").parent().quickPager({
					pagerLocation:"both",
					pageSize:pagerPP,
					currentPage:"1"
				});
	
			var ppdiv = $("<div class='georgia small left' style='display:; text-align:right;'>page<br>no.</div>");
			var ppdivall = $("<div class='georgia small left' style='display:; text-align:right;padding-top:5px; padding-left:15px;'>All records are shown</div>");
			var ppdivtoshow = (!samepagerPP) ? ppdiv : ppdivall ;
			ediv.find("div.sale-row-container").parent().parent().parent().find('.simplePagerContainer').parent().prepend(ppdivtoshow);

			nldr.toggle();
		});



if (1==0) {

	$("a.mapping").click(function() {

			var pid = $(this).parent().parent().parent().find('span.productid').html();
			var isoto = $(this).parent().parent().parent().find('span.isoto').html();
			var cont = $(this).parent().parent().parent().find('.kunki-content');
			var pa	=	$(this).parent().parent().find('.panel-action').html();
			if ( cont.css('display') == 'block' || cont.css('display') == '' )
			{
				// get panel, etc... and then toggle viewable.toggle();
				cont.toggle();
				cont.html('');
			}
			else
			{
				cont.toggle();
				cont.html(loadingimage);
				$.post("addons/extrakick/kunaki/admin_content.php", { admin_action: pa, productID: pid, isoto: isoto },
						function(data){
							cont.html(data);
							cont.find("select.accountselect").trigger('change')

							setupFormSubmit(cont);

					  	}
					);


			}
		});

}


	$("a.accounts").click(function() {

			var pid = $(this).parent().find('span.productid').html();
			var isoto = $(this).parent().find('span.isoto').html();
			var cont = $(this).parent().find('.kunki-content');
			var pa	=	$(this).parent().find('.panel-action').html();
			if ( cont.css('display') == 'block' || cont.css('display') == '' )
			{
				// get panel, etc... and then toggle viewable.toggle();
				cont.toggle();
				cont.html('');
			}
			else
			{
				cont.toggle();
				cont.html(loadingimage);
				$.post("addons/extrakick/kunaki/admin_content.php", { admin_action: pa, productID: pid, isoto: isoto },
						function(data){
							cont.html(data);

							setupFormSubmit(cont);

					  	}
					);


			}
		});


		
		$("div.save-new").live("click", function(){

			var auid = $(this).parent().parent().parent().find('input.userid-input').attr('value');
			var apwd = $(this).parent().parent().parent().find('input.pwd-input').attr('value');
			$.post("addons/extrakick/kunaki/admin_actions.php", { kunki_action: "insert", type: "account", userid: auid, pwd: apwd },
					function(data){

						if (data.isvalid) {
							append_new_account(data.id);
							$("form#accounts-auth-new").find('input.userid-input').attr('value','');
							$("form#accounts-auth-new").find('input.pwd-input').attr('value','');
						}
			
					//	rowObj.find("div.showonly").toggle();
					//	rowObj.find("div.inputdiv").toggle();

						alert(data.msg);

				  		}, "json"
				);
		
		});
		

		
		$("div.add-new-product").live("click", function(){

			var aid = $(this).parent().find('input.accountid').attr('value');
			var pid = $("div#new_product-"+aid).find('input.productid').attr('value');
			var desc = $("div#new_product-"+aid).find('textarea.description').attr('value');
			$.post("addons/extrakick/kunaki/admin_actions.php", { kunki_action: "insert", type: "product", productid: pid, accountid: aid, description: desc },
					function(data){

						if (data.isvalid) {
							append_new_product(pid,aid);
							$("form#accounts-products-new").find('input.productid').attr('value','');
							$("form#accounts-products-new").find('textarea.description').attr('value','');
						}

						alert(data.msg);

				  		}, "json"
				);
		
		});
		


		$("div.account-row div.manage").live("click", function(){
	
			var accountid = $(this).parent().find('input.accountid').attr('value');
			var cont = $("form#accounts-auth-"+accountid).parent().find('div.add-products');
			var pa	=	"accounts-products";
			if ( cont.css('display') == 'block' || cont.css('display') == '' )
			{
				// get panel, etc... and then toggle viewable.toggle();
				cont.toggle();
				cont.html('');
			}
			else
			{
				cont.toggle();
				cont.html(loadingimage);
				$.post("addons/extrakick/kunaki/admin_content.php", { admin_action: pa, accountid: accountid },
						function(data){
							cont.html(data);

					//		setupFormSubmit(cont);

					  	}
					);


			}
		});


		$("div.product-row div.save").live("click", function(){

			var rowObj 	= $("div#product-row-"+$(this).parent().find("div.kid").html() );
			var kid 	= rowObj.find('div.kid').html();
			var pid 	= rowObj.find('input.productid').attr('value');
			var desc 	= rowObj.find('textarea.description').attr('value');
			$.post("addons/extrakick/kunaki/admin_actions.php", { kunki_action: "update", type: "product", id: kid, productid: pid, description: desc },
					function(data){

						if ( !data.isvalid) {
							// means it's not good
						//	alert(data.msg);
						}

						update_product(pid,kid);

						alert(data.msg);

				  		}, "json"
				);
		
			$(this).parent().find("div.edit").css("display","block");
			$(this).parent().find("div.save").css("display","none");
			$(this).parent().find("div.cancel").css("display","none");

			rowObj.find("input.bub").addClass('readonlyinput').attr("readonly","readonly");
			rowObj.find("textarea.bub").addClass('readonlyinput').attr("readonly","readonly");
			rowObj.removeClass('hilite-yellow');

			rowObj.find("div.showonly").toggle();
			rowObj.find("div.inputdiv").toggle();

		});
		

		$("div.product-row div.count").live("click", function(){
			alert("This product is mapped to "+$(this).find(".count_value").text()+" RAP product(s)!");
			return false;
		});

		$("div.account-row div.count").live("click", function(){
			alert("This account has "+$(this).find(".count_value").text()+" product(s) mapped to RAP products!");
			return false;
		});


		
		$("div.account-row div.save").live("click", function(){

			var aid		=	$(this).parent().find("div.accountid").html();
			var rowObj 	= 	$("div#accounts-admin-" + aid );

			var editinputs = rowObj.find("input.bub").removeClass('readonlyinput');
			rowObj.addClass('hilite-yellow');


			var ser	=	$("form#accounts-auth-"+aid).serialize();
			$.post("addons/extrakick/kunaki/admin_content.php", ser,
					function(data){
					//	$("div.all_accounts_section").append(data);
					//	append_new_account(data.aid);
						update_account(data.retval);
		
						rowObj.find("div.edit").css("display","block");
						rowObj.find("div.save").css("display","none");
						rowObj.find("div.cancel").css("display","none");
			
						var editinputs = rowObj.find("input.bub").addClass('readonlyinput').attr("readonly","readonly");
						rowObj.removeClass('hilite-yellow');
			
					  	},"json"
					);
	
			return false;
		});


		
		$("div.account-row div.edit").live("click", function(){

			var aid		=	$(this).parent().find("div.accountid").html();
		//	var rowObj 	= 	$("div#accounts-admin-" + aid );
			var rowObj 	= 	$("form#accounts-auth-" + aid );

			var editinputs = rowObj.find("input.bub").removeClass('readonlyinput').removeAttr("readonly");
			rowObj.addClass('hilite-yellow');

			rowObj.find("div.showonly").toggle();
			rowObj.find("div.inputdiv").toggle();

			rowObj.find("div.edit").css("display","none");
			rowObj.find("div.save").css("display","block");
			rowObj.find("div.cancel").css("display","block");

		});

		$("div.product-row div.edit").live("click", function(){

			var rowObj = $("div#product-row-"+$(this).parent().find("div.kid").html() );

			rowObj.find("div.showonly").toggle();
			rowObj.find("div.inputdiv").toggle();

			var editinputs = rowObj.find("input.bub").removeClass('readonlyinput');
			editinputs.removeAttr("readonly");
			var edittas = rowObj.find("textarea.bub").removeClass('readonlyinput');
			edittas.removeAttr("readonly");
			rowObj.addClass('hilite-yellow');

			rowObj.find("div.edit").css("display","none");
			rowObj.find("div.save").css("display","block");
			rowObj.find("div.cancel").css("display","block");

		});


		$("div.account-row div.cancel").live("click", function(){

		//	var editinputs = $(this).parent().find("input.bub").addClass('readonlyinput');
		//	editinputs.attr("readonly","readonly").parent().parent().removeClass('hilite-yellow');

		//	$(this).parent().find("div.edit").css("display","block");
		//	$(this).parent().find("div.save").css("display","none");
		//	$(this).parent().find("div.cancel").css("display","none");


			var aid		=	$(this).parent().find("div.accountid").html();
		//	var rowObj 	= 	$("div#accounts-admin-" + aid );
			var rowObj 	= 	$("form#accounts-auth-" + aid );

			rowObj.find("div.showonly").toggle();
			rowObj.find("div.inputdiv").toggle();

			var editinputs = rowObj.find("input.bub").removeClass('readonlyinput');
			rowObj.addClass('hilite-yellow');

			rowObj.find("div.edit").css("display","block");
			rowObj.find("div.save").css("display","none");
			rowObj.find("div.cancel").css("display","none");

			var editinputs = rowObj.find("input.bub").addClass('readonlyinput').attr("readonly","readonly");
			rowObj.removeClass('hilite-yellow');

		});


		$("div.product-row div.cancel").live("click", function(){

			var rowObj = $("div#product-row-"+$(this).parent().find("div.kid").html() );
			var editinputs = rowObj.find("input.bub").addClass('readonlyinput');
			editinputs.attr("readonly","readonly");
			var editinputs = rowObj.find("textarea.bub").addClass('readonlyinput');
			editinputs.attr("readonly","readonly");
			rowObj.removeClass('hilite-yellow');

			rowObj.find("div.edit").css("display","block");
			rowObj.find("div.save").css("display","none");
			rowObj.find("div.cancel").css("display","none");

			rowObj.find("div.showonly").toggle();
			rowObj.find("div.inputdiv").toggle();

		});


		$("div.account-row div.delete").live("click", function(){

			var acct_id	=	$(this).parent().find("input.accountid").attr('value');
			$("div#accounts-admin-"+acct_id).find(".admindelete_confirm").toggle();
			$("div#accounts-admin-"+acct_id).find(".admindelete_cancel").toggle();

		});

		$("div.account-row div.admindelete_confirm").live("click", function(){

			var acct_id	=	$(this).parent().parent().find("input.accountid").attr('value');
			delete_account(acct_id);

		});

		$("div.account-row div.admindelete_cancel").live("click", function(){

			var acct_id	=	$(this).parent().parent().find("input.accountid").attr('value');
			$("div#accounts-admin-"+acct_id).find(".admindelete_confirm").toggle();
			$("div#accounts-admin-"+acct_id).find(".admindelete_cancel").toggle();

		});


		$("div.product-row div.delete").live("click", function(){

			var productid	=	$(this).parent().find("input.kid").attr('value');
			delete_product(productid);

		});


});

function hiliteObj(o,bgcol) {
	if (!bgcol)
		bgcol = "#ffd0d0";
	if (!o)
		o = ".hiliteme";

	o.fadeOut(500).fadeIn(500)..fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(750);

	return false;
}

function fadeNotify(o) {
	if (!o)
		o = $(".fademe");

	o.fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(750);

	return false;
}

function append_new_account(accountid) {
	var pa	=	"accounts-auth";
	$.post("addons/extrakick/kunaki/admin_content.php", { admin_action: pa, otype: "list", aid: accountid },
			function(data){
				$("div.all_accounts_section").append(data);
				$("div.all_accounts_section").find("p.noacccountswarning").remove();
				$("div#new_admin_account").slideToggle();
		  	}
		);
	return false;
}

function append_new_product(pid,aid) {
	var pa	=	"accounts-products";
	$.post("addons/extrakick/kunaki/admin_content.php", { admin_action: pa, productid: pid },
			function(data){
				var newd = $(data);
				$("form#accounts-auth-"+aid).parent().find("div.all_product_list").append(data);
				$("form#accounts-auth-"+aid).parent().find("p.nokunakiproductswarning").css('display','none');
			//	var sday = $("form#accounts-auth-"+aid).parent().find("div.all_product_list:last-child");
				fadeNotify($("form#accounts-auth-"+aid).parent().find("div#"+newd.attr('id')));
				kunki_toggle_product_new(aid,'slideme');
		  	}
		);
	return false;
}



function update_account(accountid) {
	var pa	=	"accounts-auth";
	$.post("addons/extrakick/kunaki/admin_content.php", { admin_action: pa, otype: "list", aid: accountid },
			function(data){
				var deldiv	=	$("form#accounts-auth-"+accountid).parent();
				deldiv.css("display","none").attr('class','olddata');
				$(data).insertAfter(deldiv);
				$("div.olddata").remove();
		  	}
		);
	return false;
}


function update_product(pid,kid) {
	var pa	=	"accounts-products";
	$.post("addons/extrakick/kunaki/admin_content.php", { admin_action: pa, productid: pid },
			function(data){
				$("div#product-row-"+kid).css("display","none").attr('class','olddata');
				$(data).insertAfter("div#product-row-"+kid);
				$("div.olddata").remove();
		  	}
		);
	return false;
}


function delete_account(accountid) {
	var pa	=	"delete";
	$.post("addons/extrakick/kunaki/admin_actions.php", { kunki_action: pa, type: "account", id: accountid },
			function(data){
				if ( data.isvalid == "1") {
					alert(data.msg);
					$('form#accounts-auth-'+accountid).parent().fadeOut(500);
				} else {
					alert('Failed!');
				}
		  	},"json"
		);
	return false;
}




function delete_product(productid) {
	var pa	=	"delete";
	$.post("addons/extrakick/kunaki/admin_actions.php", { kunki_action: pa, type: "product", id: productid },
			function(data){
				if ( data.isvalid == "1") {
					alert(data.msg);
					$('div#product-row-'+productid).fadeOut(500);
				} else {
					alert('Failed!');
				}
		  	},"json"
		);
	return false;
}





function kunki_toggle_product_new(nid,ts) {
	var cont = $("div#new_product-"+nid);
	if (!ts) {
		
		if ( cont.css('display') == 'block' || cont.css('display') == '' )
		{
			// get panel, etc... and then toggle viewable.toggle();
			cont.toggle();
		}
		else
		{
			cont.toggle();
	
		}

	} else {
		
		cont.slideToggle();

	}

 }


function kunki_toggle_admin_new_ajax() {
	var cont = $('div#new_admin_account');
	var pa	=	"accounts-auth";
	if ( cont.css('display') == 'block' || cont.css('display') == '' )
	{
		// get panel, etc... and then toggle viewable.toggle();
		cont.toggle();
		cont.html('');
	}
	else
	{
		cont.toggle();
		cont.html(loadingimage);
		$.post("addons/extrakick/kunaki/admin_content.php", { admin_action: pa, otype: "new" },
				function(data){
					cont.html(data);
			  	}
			);


	}

 }


function kunki_toggle_admin_new() {
	var cont = $('div#new_admin_account');
	if ( cont.css('display') == 'block' || cont.css('display') == '' )
	{
		// get panel, etc... and then toggle viewable.toggle();
		cont.toggle();
	}
	else
	{
		cont.toggle();

	}

 }

function checkboxToggle(t){
	var par = $(t).parent();
	if ( par.find("input:checked").length > 0 ) {
		par.find('input').removeAttr('checked');
		$(t).removeClass('checkbox_checked').addClass('checkbox_unchecked');
	} else {
		par.find('input').attr('checked','checked');
		$(t).removeClass('checkbox_unchecked').addClass('checkbox_checked');
	}

	return false;
	
}

$("div.checkbox").live("click",function(){
	//	var cbool = $(this).hasClass("checked");

		checkboxToggle(this);
		if ( $(this).parent().find("input.minshipping").length > 0 ) {
			if ( $(this).parent().find("input.minshipping:checked").length > 0 ) {
				// adda-boy - use free min-shipping!
				$(this).parent().parent().parent().find(".minshippingwarningbox").css("display","none");
			} else {
				// uh, make sure they know what they're doing.
				$(this).parent().parent().parent().find(".minshippingwarningbox").css("display","block");
			}
		}

		var p = $(this).parent();
		testSerial(p);
	});


$("select.accountselect").live("change",function() {

		var pisoto		=	$(this).parent().find('div.isoto').html();
		var pid			=	$(this).parent().find('div.productID').html();
		var proddiv		=	$('div.select-account-products-'+pisoto);
		var pa			=	"accounts-products";
		var accountid 	= $(this).attr('value');

		proddiv.html(loadingimage);

		$.post("addons/extrakick/kunaki/admin_content.php", { admin_action: pa, accountid: accountid, productID: pid, isoto: pisoto, assign_mapping: 1},
				function(data){
					proddiv.html(data);
			  	}
			);


	});


$("div.clearmappings").live("click",function() {
		$(this).toggle();
		$(this).parent().find("div.clearmappings-confirm").toggle();
		$(this).parent().find("div.clearmappings-cancel").toggle();
	});

$("div.clearmappings-cancel").live("click",function() {
		$(this).toggle();
		$(this).parent().find("div.clearmappings-confirm").toggle();
		$(this).parent().find("div.clearmappings").toggle();
	});

$("div.clearmappings-confirm").live("click",function() {

		var pisoto	=	$(this).find("div.isoto").html();
		var pid		=	$(this).find("div.productID").html();

		// send $POST to clear mappings for this productID/isoto combination
		if (1==1) {
			var pa		=	"delete";
			var ptype	=	"mapping";
			$.post("addons/extrakick/kunaki/admin_actions.php?", { kunki_action: pa, type: ptype, productID: pid, isoto: pisoto }  ,
					function(data){
					//	alert(data.isvalid);
					//	alert("div.account_decision_time-" + pid + "-" + pisoto);
	
						if (data.isvalid == 1) {

							// now remove the warning...
							$("div.account_decision_time-" + pid + "-" + pisoto).remove();

							// now remove the blocks and show the checkboxes...
							$("div.select-account-products-" + pisoto + " div.product-row").find("div.mapped_block").toggle();
							$("div.select-account-products-" + pisoto + " div.product-row").find("div.checkbox").toggle();

						}
	
					//	proddiv.html(data);
				  	},"json"
				);
		}

			

	});



$("div.savemapping").live("click",function() {

		var fid			=	$(this).parent().find("div.class_id").html();

		var fobj		=	$("form."+fid);

		var pisoto		=	$("form."+fid).find("div.isoto").html();
		var pid			=	$("form."+fid).find("div.productID").html();

		var fser		=	$("form."+fid).serialize();

		var pa			=	"update";
		var ptype		=	"mapping";

		var fserplus	=	fser + "&kunki_action=" + pa + "&type=" + ptype + "&save=1";

		// alert(fserplus);
		// send $POST to clear mappings for this productID/isoto combination

		$.post("addons/extrakick/kunaki/admin_actions.php?", fserplus  ,
				function(data){
					if ( data.isvalid == 1 ) {
						fobj.find("div.savemapping").css("display","none");
					} else {
						alert('Hmmm.. something happened, refresh this panel and try again!');
					}
				//	alert(data.isvalid);
				//	proddiv.html(data);
			  	},"json"
			);

	});


$("a.explanation-p").live("click",function(){
		$(this).parent().find("p").toggle();
	});


//------------------------------
//  handling sales table
//------------------------------

$("div.sale div.delsale").live("click",function() {

		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);

		did.find("div.delconfirm").toggle();
		did.find("div.delconfirm_cancel").toggle();

		return false;
	});

$("div.sale div.delconfirm_cancel").live("click",function() {

		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);

		did.find("div.delconfirm").toggle();
		did.find("div.delconfirm_cancel").toggle();

	});

$("div.sale div.delconfirm").live("click",function() {

		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);

		var sid			=	did.find("div.saleid").html();
		var tid			=	did.find("div.txn_id").html();

		var pa			=	"delete";
		var ptype		=	"sale";

		$.post("addons/extrakick/kunaki/admin_actions.php?", { kunki_action: pa, type: ptype, saleid: sid, txn_id: tid } ,
				function(data){
					if ( data.isvalid == 1 ) {
						alert(data.msg);
						did.fadeOut(500);
						if ( did.parent().parent().find('.history div.sale').length <= 1 ) {
							did.parent().parent().find('.historymessage').toggle();
						}
					} else {
						alert('Hmmm.. something happened, refresh this panel and try again!');
					}
			  	},"json"
			);

	}).addClass("pointer");


//------------------------------
//  handling sales table
//------------------------------

$("div.sale div.delentire").live("click",function() {

		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);

		did.find("div.entire_delconfirm").toggle();
		did.find("div.entire_delconfirm_cancel").toggle();

		return false;
	});

$("div.sale div.entire_delconfirm_cancel").live("click",function() {

		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);

		did.find("div.entire_delconfirm").toggle();
		did.find("div.entire_delconfirm_cancel").toggle();

	});

$("div.sale div.entire_delconfirm").live("click",function() {

		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);

		var sid			=	did.find("div.saleid").html();
		var tid			=	did.find("div.txn_id").html();

		var pa			=	"delete";
		var ptype		=	"sale";

		$.post("addons/extrakick/kunaki/admin_actions.php?", { kunki_action: pa, type: ptype, saleid: sid, txn_id: tid, history: 1 } ,
				function(data){
					if ( data.isvalid == 1 ) {
						alert(data.msg);
						did.parent().fadeOut(500);
						if ( did.parent().parent().find('.history div.sale').length <= 1 ) {
							did.parent().parent().find('.historymessage').toggle();
						}
					} else {
						alert('Hmmm.. something happened, refresh this panel and try again!');
					}
			  	},"json"
			);

	}).addClass("pointer");


function toggleLoader(o,t) {
	$(o).find('div.loading').find('span.loadingtext').html(t);
	$(o).find('div.loading').toggle();
	return false;
}

$("div.sale div.dupepre").live("click",function() {

		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);

		did.find("div.dupe_confirm").toggle();
		did.find("div.dupe_confirm_cancel").toggle();
	
	});

$("div.sale div.dupe_confirm_cancel").live("click",function() {
		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);
		did.find("div.dupe_confirm").toggle();
		did.find("div.dupe_confirm_cancel").toggle();

	});


$("div.sale div.dupe_confirm").live("click",function() {

		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);

		// toggle loading image		
		toggleLoader(did,'creating another "cloned" sale - for re-shipment');

		did.find("div.dupe_confirm").toggle();
		did.find("div.dupe_confirm_cancel").toggle();

		var sid			=	did.find("div.saleid").html();
		var tid			=	did.find("div.txn_id").html();

		var pa			=	"clone";
		var ptype		=	"sale";

		$.post("addons/extrakick/kunaki/admin_actions.php?", { kunki_action: pa, type: ptype, txn_id: tid } ,
				function(data){
					if ( data.isvalid == 1 ) {
						alert(data.msg);
						var cid_array = cid.split("-");
						cid_array[cid_array.length-1] = data.id;
						var ncid = cid_array.join("-");
						refSaleRow(cid,ncid);
					} else {
						alert('Hmmm.. something happened, refresh this panel and try again!');
					}
			  	},"json"
			);

	}).hover(
      function () {
        $(this).removeClass("colorbox_orange").css("border-width","0px");
        $(this).addClass("colorbox_green").css("border-width","0px");
      }, 
      function () {
        $(this).removeClass("colorbox_green").css("border-width","0px");
        $(this).addClass("colorbox_orange").css("border-width","0px");
      }
    );





$("div.sale div.shippre").live("click",function() {

		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);
		did.find("div.ship_confirm").toggle();
		did.find("div.ship_confirm_cancel").toggle();
		did.find("div.ship_confirm_manual").toggle();
	
	});

$("div.sale div.ship_confirm_cancel").live("click",function() {
		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);
		did.find("div.ship_confirm").toggle();
		did.find("div.ship_confirm_cancel").toggle();
		did.find("div.ship_confirm_manual").toggle();

	});


$("div.sale div.ship_confirm_manual").live("click",function() {

		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);

		did.find("div.ship_confirm").toggle();
		did.find("div.ship_confirm_cancel").toggle();
		did.find("div.ship_confirm_manual").toggle();

		// toggle loading image
		toggleLoader(did,'setting to manually fulfilled');

		var sid			=	did.find("div.saleid").html();
		var tid			=	did.find("div.txn_id").html();
		var comp		=	did.find("div.completed").html();

		var pa			=	"update";
		var ptype		=	"sale";

		$.post("addons/extrakick/kunaki/admin_actions.php?", { kunki_action: pa, type: ptype, id: sid, txn_id: tid, completed: comp} ,
				function(data){
					if ( data.isvalid == 1 ) {
					//	alert(data.msg);
						refSaleRow(cid);
					//	setTimeout('function(){$(".'+cid+'").animate({ borderLeftColor: "#ddd"})}', 1000 );
					//	setTimeout('function(){$(".'+cid+'").animate({ borderLeftColor: "#00aa00"})}', 1500 );
					//	setTimeout('function(){$(".'+cid+'").animate({ borderLeftColor: "#ddd"})}', 2000 );

					} else {
						alert('Hmmm.. something happened, refresh this panel and try again!');
					}
			  	},"json"
			);

	});

function hiliteSaleRow(cid,bgcol) {
	if (!bgcol)
		bgcol = "#ffd0d0";
	$("."+cid).parent().stop().animate({  backgroundColor: "#ffd0d0"}, 500)
		.animate({  backgroundColor: "white"},500)
		.animate({  backgroundColor: "#ffd0d0"},500)
		.animate({  backgroundColor: "white"},500)
		.animate({  backgroundColor: "#ffd0d0"},500)
		.animate({  backgroundColor: "white"},1000);
	return false;
}

$("div.sale div.ship_confirm").live("click",function() {

		var cid			=	$(this).parent().parent().find("div.class_id").html();
		var did			=	$("."+cid);

		did.find("div.ship_confirm").toggle();
		did.find("div.ship_confirm_cancel").toggle();
		did.find("div.ship_confirm_manual").toggle();

		// toggle loading image
		toggleLoader(did,'sending order to ship...');

		var sid			=	did.find("div.saleid").html();
		var tid			=	did.find("div.txn_id").html();

		var pa			=	"order";

		$.post("addons/extrakick/kunaki/actions.php?", { kunki_action: pa, manualoverride: 1, txn_id: tid } ,
				function(data){
					if ( data.indexOf("success") >= 0 ) {
						alert('Ordered for shipment!'); 
						if ( data.indexOf("<OrderId>00000</OrderId>") >= 0 ) {
							alert('Just confirming to you that this was a Test Order and that no Real Order was placed!  To change this, go to Product Shipping Options above.'); 
						}
						refSaleRow(cid);
					} else {
						alert("This was not ordered. This could be because it's already been ordered, or potential problems exist in your Kunaki Settings (Product IDs or Admin Settings)...  please make sure your account is active, kunaki product ids are correct for the account chosen, and any other parameters as they relate to sending data to Kunaki."); 
					}
			  	}
			);

	});


function refSaleRow(cid,ncid) {

	if (!ncid)
		ncid = cid;

	var did			=	$("."+cid);
	var tid			=	did.find("div.txn_id").html();

	var pid			=	did.find("div.productID").html();
	var pisoto		=	did.find("div.isoto").html();

	$.post("addons/extrakick/kunaki/admin_content.php?", { admin_action: "sales", txn_id: tid, productID: pid, isoto: pisoto} ,
			function(data){
					$("."+cid).parent().html(data);
					$("#"+ncid).localScroll();
					$("#"+ncid).find("a.sale-goto").trigger("click");
					setTimeout('hiliteSaleRow("'+ncid+'");',250);
				//	setTimeout('hiliteSaleRow("'+ncid+'");',250);
		  	}
		);


	return false;
}

$("div.sale div.detsale").live("click",function() {

		$(this).parent().parent().find("div.sale-details").toggle();

	});


$("div.sale div.save-notes").live("click",function() {
		var tc		=	$(this);
		var tcpar	=	$(this).parent();
		var cid = $(this).parent().parent().parent().find(".class_id_save").html();
		var dobj = $("." + cid);
		var sid = dobj.find("div.saleid").html();

		var fser = dobj.find(".sale-details form").serialize();
	
		var pa		=	"update";
		var ptype	=	"sale";

		var fserplus = fser + "&subaction=adminnotes&kunki_action=" + pa + "&type=" + ptype + "&id=" + sid;

		$.post("addons/extrakick/kunaki/admin_actions.php?", fserplus ,
				function(data){

					if ( data.isvalid == 1 ) {
						alert('Notes saved!');
				
						tcpar.find("div.edittable").toggle();
						tcpar.find("div.nonedittable").toggle();

						tcpar.find("div.edittable").find("textarea.adminnotes").val(data.adminnotes);
						tcpar.find("div.nonedittable").html(data.adminnotes);

						tc.css("display","none");
						
					} else {
						alert('Hmmm.. something happened, refresh this panel and try again!');
					}
	
			
				//	proddiv.html(data);
			  	},"json"
			);
 

	});


$("div.sale-details a.edit_notes").live("click",function() {
		var par = $(this).parent();

		par.find("div.edittable").toggle();
		par.find("div.save-notes").css("display",(par.find("div.save-notes").css("display")=="none")?"block":"none");
		par.find("div.nonedittable").toggle();

	});





$("div.assign_mapping input").live("keyup",function() {
		var p = $(this).parent().parent();
		testSerial(p);
	});







function testSerial(p) {
	var pc = $(p).find("div.class_id").html();
	var cs = "form."+pc+"";
	var fser = $(cs).serialize();
//	alert(fser);
//	alert('hi');

	var pa	=	"serialize";
//	$.post("addons/extrakick/kunaki/admin_actions.php?", fser + "&kunki_action=" + pa ,

	var pa		=	"checkifexists";
	var ptype	=	"mapping";
	$.post("addons/extrakick/kunaki/admin_actions.php?", fser + "&rettype=json&kunki_action=" + pa + "&type=" + ptype ,
			function(data){
				if ( data.found == 0 )
					$(p).find("div.savemapping").css("display","block");
				else
					$(p).find("div.savemapping").css("display","none");


			//	proddiv.html(data);
		  	},"json"
		// removed ",'json'"
		);


}

function setupFormSubmit(cont) {

   cont.find('form').each(function() {
      var $that = $(this);
      $(this).submit(function(){
         var submitButton = $that.find("input[type='submit']");
         btnText = $(submitButton).attr("value");
         $(submitButton).attr("value", "Please Wait...");
         $(submitButton).attr("disabled", "disabled");

          jQuery.ajax({
            data: $(this).serialize(),
			type: "POST",
            url: $(this).attr("action"),
            timeout: 1000,
            error: function() {
               $that.find("input[type='submit']").attr("value", "Failed to Submit");
               $that.find("input[type='submit']").removeAttr('disabled');
            },
            success: function(r) {
               $that.find("input[type='submit']").attr("value", "Success");
               setTimeout(function(){
                  $that.find("input[type='submit']").attr("value", btnText);
                  $that.find("input[type='submit']").removeAttr('disabled');
               }, 750);
            }
         });

         return false;
      })
   }); 

}


function showSaveDisk(extra_ext) {
	
}

function postjson(url,data,bS,s,e){
	$.ajax({type:"POST",url:url,data:data,dataType:"json",beforeSend:bS,success:s,error:e});
}

function toggleSave(dtype,extra_ext) {
	var thisCont = $('.extraoptions-container-'+extra_ext);
	thisCont.find('div.saveimage').css('display',dtype);
	return false;
}

function checkIfDiff(nv,extra_ext) {
	var thisCont = $('.extraoptions-container-'+extra_ext);
	var ov = thisCont.find('span.wppath-orig').html();
	if (nv != ov)
		thisCont.find('div.saveimage').css('display','block');
	else
		thisCont.find('div.saveimage').css('display','none');
	return false;
}


function checkFormChanges(extra_ext) {
	var thisCont = $('.extraoptions-container-'+extra_ext);
	thisCont.find('div.footprintnew').html(thisCont.find('form#wppathform').serialize());
	if ( thisCont.find('div.footprintnew').html() != thisCont.find('div.footprint').html() )
		toggleSave('block',extra_ext);
	else
		toggleSave('none',extra_ext);
	return false;
}


