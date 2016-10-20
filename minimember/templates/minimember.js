function aSave() {
			var passwdval =	jQuery(\"#pswdemail:checked\").val();
	jQuery.post(\"/rap-admin/addons/GIS/minimember/do.php\", { action: \"Passwd\", passwdval: passwdval, passwdlen: \"" . gMMGetOptionInt("pwdlen", "7") . "\" },
					function(data){
						jQuery('#pswd-set-disp').html(data);
				  	}
				);
				}
				