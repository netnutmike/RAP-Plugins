
var loadingimage = '<img src="addons/GIS/raptools//images/loading.gif" alt="" border="">';

function showWelcome() {

	var cont = jQuery('#main-dis');
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/welcome.php", { },
		function(data){
			cont.html(data);
		  	}
		);

}

function showProductOptions() {

	var cont = jQuery('#product-options-dis');
	var pid = jQuery('#products').val();
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/product_options.php", { pid: pid },
		function(data){
			cont.html(data);
		  	}
		);

}

function showHideCronOptionsSections() {
	if ( jQuery("#Type").val() == 1 ) {
		jQuery('#actiondiv').hide();
	} else {
		jQuery('#actiondiv').show();
	}
}
	
function showHideProductOptionsSections() {
	if ( jQuery("#endaction:checked").val() == 1 ) {
		jQuery('#end-price-div').show();
	} else {
		jQuery('#end-price-div').hide();
	}
	
	if ( jQuery("#price_countdown:checked").val() == 1 ) {
		jQuery('#price_countdown_div').show();
	} else {
		jQuery('#price_countdown_div').hide();
		jQuery('#end-price-div').hide();
	}
	
	if ( jQuery("#debug_option:checked").val() == 1 ) {
		jQuery('#debug_div').show();
	} else {
		jQuery('#debug_div').hide();
	}
	
	if ( jQuery("#g_email_not_options:checked").val() == 1 ) {
		jQuery('#email_div').show();
	} else {
		jQuery('#email_div').hide();
	}
	
	if ( jQuery("#Owner_Notify:checked").val() == 1 ) {
		jQuery('#owner_div').show();
	} else {
		jQuery('#owner_div').hide();
	}

	if ( jQuery("#Owner_Refunds:checked").val() == 1 ) {
		jQuery('#owner_refund_email').show();
	} else {
		jQuery('#owner_refund_email').hide();
	}
	
	if ( jQuery("#Affiliate_Notify:checked").val() == 1 ) {
		jQuery('#affiliate_div').show();
	} else {
		jQuery('#affiliate_div').hide();
	}

	if ( jQuery("#Affiliate_Refunds:checked").val() == 1 ) {
		jQuery('#affiliate_refund_email').show();
	} else {
		jQuery('#affiliate_refund_email').hide();
	}

	if ( jQuery("#JV_Notify:checked").val() == 1 ) {
		jQuery('#jv_div').show();
	} else {
		jQuery('#jv_div').hide();
	}

	if ( jQuery("#jv_Refunds:checked").val() == 1 ) {
		jQuery('#jv_refund_email').show();
	} else {
		jQuery('#jv_refund_email').hide();
	}
	
	if ( jQuery("#Equity_Notify:checked").val() == 1 ) {
		jQuery('#equity_div').show();
	} else {
		jQuery('#equity_div').hide();
	}

	if ( jQuery("#Equity_Refunds:checked").val() == 1 ) {
		jQuery('#equity_refund_email').show();
	} else {
		jQuery('#equity_refund_email').hide();
	}
	
	if ( jQuery("#robots_option:checked").val() == 1 ) {
		jQuery('#robots_div').show();
	} else {
		jQuery('#robots_div').hide();
	}
	
	if ( jQuery("#Block_manual:checked").val() == 1 ) {
		jQuery('#block_manual_div').show();
	} else {
		jQuery('#block_manual_div').hide();
	}
	
	if ( jQuery("#sitemap_option:checked").val() == 1 ) {
		jQuery('#sitemap_div').show();
	} else {
		jQuery('#sitemap_div').hide();
	}
	
	if ( jQuery("#rss_option:checked").val() == 1 ) {
		jQuery('#rss_div').show();
	} else {
		jQuery('#rss_div').hide();
	}
}

function LoadProducts() {
	
	var cont = jQuery('#main-dis');
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/products.php", { },
		function(data){
			cont.html(data);
		  	}
		);
	
}

function LoadFiles() {
	
	var cont = jQuery('#main-dis');
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/explorer.php", { },
		function(data){
			cont.html(data);
		  	}
		);
	
}

function LoadAddons() {
	
	var cont = jQuery('#main-dis');
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/addons.php", { },
		function(data){
			cont.html(data);
		  	}
		);
	
}

function LoadPages() {
	
	var cont = jQuery('#main-dis');
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/pages.php", { },
		function(data){
			cont.html(data);
		  	}
		);
	
}

function LoadOptions() {
	
	var cont = jQuery('#main-dis');
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/options.php", { },
		function(data){
			cont.html(data);
		  	}
		);
	
}

function LoadTools() {
	
	var cont = jQuery('#main-dis');
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/tools.php", { },
		function(data){
			cont.html(data);
		  	}
		);
	
}