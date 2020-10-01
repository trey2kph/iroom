<?php 
	include("config.php");
	
	$storefeeddata = $apc->store_apc("feed", 10); //store 10 latest feed articles (look for store_apc function on apc.class.php)
	
	$storeflashbox = $apc->store_apc("flashbox"); //store 5 articles for flashbox (look for store_apc function on apc.class.php)
	$top1 = $apc->store_apc("strip1"); //store 3 random articles published last 3-6 months for strip above flashbox (look for store_apc function on apc.class.php)
	$top2 = $apc->store_apc("strip2"); //store 3 random articles published last 6 months and oldest for strip above flashbox (look for store_apc function on apc.class.php)
	$side1 = $apc->store_apc("side1"); //store 10 top most read articles (look for store_apc function on apc.class.php)
	$side2 = $apc->store_apc("side2"); //store 10 top most shared articles (look for store_apc function on apc.class.php)
	
	$blog = $apc->store_apc("blog"); //store 6 latest blog articles (look for store_apc function on apc.class.php)
	
	if ($storefeeddata) echo "TRANSFER SUCCESS";
	else echo "TRANSFER FAILED";
	
?>