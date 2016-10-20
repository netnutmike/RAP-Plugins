<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js' type='text/javascript'></script>

<script>
	jQuery.noConflict(); 
</script>

<script language="JavaScript">

function aContinue() {

	var cont = jQuery('#main-dis', top.document);
	jQuery.post("/rap_admin/addons/GIS/raptools/explorer.php", { dir: '<?= $_REQUEST['dir']; ?>' },
		function(data){
			cont.html(data);
		  	}
		);
}

</script>

<?
	include "functions.php";
	
	//find out what our true path is
    $g_rapbasepath = substr(getcwd(),0,strrpos(getcwd(), "/rap_admin"));
?>

<link rel="stylesheet" href="/rap_admin/addons/GIS/raptools/css/styles.css" type="text/css" />

				
					
<? 	if ( $_POST['MAX_FILE_SIZE'] == "" ) { ?>

	<p><form enctype="multipart/form-data" method="POST" action="upload_file.php">
<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
<input type="hidden" name="dir" value="<?=$_REQUEST['dir']; ?>">
<div style="font-family:Georgia; font-size: 16px;">Upload File:<br></br> <input name="uploadedfile" type="file" />
<input type="submit" id="submit" name="submit" value="Upload File" /></div>
</form>
</p>

<? 	} else { 

		$target_path = $dir . "/" . basename( $_FILES['uploadedfile']['name']);  

		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    		echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
    		" has been uploaded...<br><br>
    		
    		<script language=\"JavaScript\">
    			jQuery.post(\"/rap_admin/addons/GIS/raptools/explorer.php\", { dir: '" . $_REQUEST['dir'] . "' },
					function(data){
						jQuery(\"#main-dis\", top.document).html(data);
		  				}
					);
    		</script> ";
		} else {
    		echo "There was an error uploading the file, please try again!
    		<input type=\"button\" name=\"submit\" id=\"submit\" value=\"Continue...\" onClick=\"javascript:aContinue();\"/>";
		}

 	} ?>
				
				