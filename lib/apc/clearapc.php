<?php 
	include("config.php");
	
	$clear = $apc->clear_apc('spotflashbox');
	$clear = $apc->clear_apc('spottop1');
	$clear = $apc->clear_apc('spottop2');
	$clear = $apc->clear_apc('spotside1');
	$clear = $apc->clear_apc('spotside2');
	$clear = $apc->clear_apc('spotarticle_all');
	$clear = $apc->clear_apc('spotid_all');
	$clear = $apc->clear_apc('spotarticle_allfeed');
	$clear = $apc->clear_apc('spot_blog');;
	
	echo "CACHE CLEAR!";
	
?>