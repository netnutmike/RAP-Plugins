<?
	include_once("functions.php");

	$tr = new remSQL;
	$tr->Connect("http://www.rapdevarea.com/rap_admin/addons/GIS/remote/dbqry.php");
	$tr->Query("select * from sales");
	while ($rs = $tr->fetch_row() ) {
	
		echo "Item Name: " . $rs->item_name . "<br>";
		echo "Payer Email: " . $rs->payer_email . "<br>";
		echo "num_rows: " . $tr->num_rows() . "<BR>";
		echo "<BR>";
	}
	
	
	

?>