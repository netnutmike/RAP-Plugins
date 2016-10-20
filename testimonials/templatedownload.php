

	<?
		$flnm = fopen("http://www.raptemplates.com/testimonialaddon/inprod.php","r");
		$contents = "";
		
		while (!feof($flnm)) {
  			$contents .= fread($flnm, 8192);
}
		echo $contents;
		
		fclose($flnm);
	?>
	
	
	