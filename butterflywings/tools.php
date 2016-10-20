<table>
	<tr>
		<td valign=bottom width=100%>
			
			<div style='clear:both;'></div>

			<div class='gis-container-global'>
				<div class='gis-container-admin padding-rl-10'>
	
					<!-- Product Option -->
					<div class=gis-section id="cron-options">
						<a href="javascript:void(0);" class=cron>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_cron left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>CRON (Timed Automation)</span>
								<div style='clear:both;'></div>
							</div>
						</div>
						</a>
						<div class='gis-content padding-rl-20 ' style='display:none;' id="cr-opt-disp"></div>
					</div>
					<div style='clear:both;'></div>
				</td></tr>
	

<!-- 	<tr>
		<td valign=bottom width=100%>
			<div style='clear:both;'></div>

			<div class='gis-container-global'>
				<div class='gis-container-admin padding-rl-10'>
					<div class=gis-titlebar>
						<div class='subheading-large left'></div>
						<div style='clear:both;'></div>
					</div>
	
					
					<div class=gis-section id="backup-options">

						<a href="javascript:void(0);" class=backup>
						<div class=gis-buttons>
							<div class='buttons'>
								<div class='admin_backup left padding-rl-10'>&nbsp;</div>
								<span class='subheading-section left titles-big'>Backup / Restore</span>
								<div style='clear:both;'></div>

							</div>
						</div>
						</a>

						<div class='gis-content padding-rl-20' style='display:none;' id="bu-opt-disp"></div>
						
						<span class=pid style='display:none;' id="prodid"><?php echo $productID ?></span>
					</div>

					<div style='clear:both;'></div>

	</td></tr> -->
	</table>
	
<script type='text/javascript'>
jQuery(document).ready(function(){

	jQuery("a.cron").click(function() {
	
		var cont = jQuery(this).parent().find('.gis-content');
//		var path	=	jQuery(this).parent().find('.path').html();
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
			jQuery.post("addons/GIS/raptools/cronsetup.php", {  },
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});

	jQuery("a.global").click(function() {
		
		var cont = jQuery(this).parent().find('.gis-content');
		var prodid = jQuery('#prodid').html();
//		var fln = jQuery('#files').val();

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
			jQuery.post("addons/GIS/raptools/backup.php", { productID: prodid},
					function(data){
						cont.html(data);
	
				  	}
				);
	
	
		}
	});


	  

})

</script>