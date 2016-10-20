function my_kwicks(){
    jQuery('.kwicks').kwicks({
        duration: 300,
        max: 200,
        spacing:  0
    });
}  

 jQuery(document).ready(function(){
	my_kwicks();
});