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

	$id = $_POST['locid'];		

	//AUDIT TRAIL
	$log = $main->log_action("DELETE_LOC", $id, $profile_id);

	$delete_loc = $main->loc_action(NULL, 'delete', $id);
?>			