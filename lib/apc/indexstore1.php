<?php 
	include("config.php");
	
	$storedata = $apc->store_apc("all", 200); //store 200 latest article (look for store_apc function on apc.class.php)
	$storeid = $apc->store_apc("allid", 200); //store 200 latest article ID (look for store_apc function on apc.class.php)
	
	if ($storedata) echo "TRANSFER SUCCESS";
	else echo "TRANSFER FAILED";
	
?>