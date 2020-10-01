<?php 

	include("../../config.php"); 
	//**************** USER MANAGEMENT - START ****************\\

	include(LIB."/login/chklog.php");

	$profile_full = $logfname;
	$profile_name = $logname;
	$profile_id = $userid;
	$profile_level = $level;
	
	//***************** USER MANAGEMENT - END *****************\\
?>

<?php
	$id = $_POST['resid'];			

	//AUDIT TRAIL
	$log = $main->log_action("APPROVE_RESERVATION", $id, $profile_id);

	$single_reservation = $main->reserve_action(NULL, 'post', $id);
?>			