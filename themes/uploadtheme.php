
<link rel="stylesheet" href="/rap_admin/addons/GIS/themes/css/styles.css" type="text/css" />

<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js' type='text/javascript'></script>

<script>
	jQuery.noConflict();
</script>
<script src="http://jqueryui.com/latest/ui/effects.core.js"></script>
<script src="http://jqueryui.com/latest/ui/effects.pulsate.js"></script>

<script type='text/javascript'>

	var loadingimage = '<img src="/rap_admin/addons/GIS/themes//images/loading.gif" alt="" border="">';

</script>

<div id="spinner"></div>

<?
	if ($_POST['MAX_FILE_SIZE'] != "") {

		echo "<script type='text/javascript'> jQuery('#spinner').html(loadingimage); </script>";
		
		$target_path = "themes/";
		
		if (!file_exists($target_path))
			mkdir($target_path);

		$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    		
			$zip = new ZipArchive;
     		$res = $zip->open($target_path);
     		if ($res === TRUE) {
        		$zip->extractTo('themes');
         		$zip->close(); ?>
         		
         		<div class="rounded-box-green" id="message-box">
    	    		<div class="box-contents">
        				<br><font style="font-size: 18px;"><strong>Good News, Files Unpacked!!</strong></font><img src="/rap_admin/addons/GIS/themes/images/info48x48.png" align="right">
        				<br><font style="font-size: 14px;"><i>
        					Your new theme has been uploaded and installed and should be available immediately in the list of templates that are available for use.
        					</i><br>&nbsp;
    				</div> 
				</div>
				<br>
				<script type="text/javascript">
					jQuery('#message-box').fadeOut(10000);
				</script>
         		
 <?    		} else { ?>
         		<div class="rounded-box-red" id="message-box">
    	    		<div class="box-contents">
        				<br><font style="font-size: 18px;"><strong>Uh Oh!, Install Failed!!</strong></font><img src="/rap_admin/addons/GIS/themes/images/warning48x48.png" align="right">
        				<br><font style="font-size: 14px;"><i>
        					We could not open the archive file you uploaded.  It could be related to a permissions issue on your web host or the file you uploaded might have not been a valid zip file.  Refer to the manual installation instructions in the manual for detailed instructions on uploading new themes to your site.
        					</i><br>&nbsp;
    				</div> 
				</div>
				<br>
				<script type="text/javascript">
					jQuery('#message-box').fadeOut(10000);
				</script>
<?     		}
		}
		
		//clean up the zip file if it exists
		if (file_exists($target_path))
			unlink($target_path);
			
		echo "<script type='text/javascript'> jQuery('#spinner').hide(); </script>";
		
	} ?>

<div class="paragraph-text">			
			<table width="70%"><tr><td>
				<p>To upload a new theme, click the browse button, locate the zip archive file for the theme, click the upload button.</p>

				<p><form enctype="multipart/form-data" method="POST" action="/rap_admin/addons/GIS/themes/uploadtheme.php">
				<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
				<h2>Choose a file to upload:</h2><br></br> <input name="uploadedfile" type="file" /><br /><br>
				<input type="submit" value="Upload File" />
				</form>
				</p><br></br>
			</td></tr></table>	</div>