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
	jQuery.post("addons/GIS/raptools/files.php", { },
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