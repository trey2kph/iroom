<?php 
	include("../config.php"); 

	$roomid = $_GET['roomid'] ? $_GET['roomid'] : 0; 
	$reservations = $main->get_reservations(0, 0, 0, 0, 0, $roomid); 

	echo json_encode($reservations);  

?>

