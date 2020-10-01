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
	
	$id = $_POST['userid'];
			
	//AUDIT TRAIL
	$log = $main->log_action("DELETE_USER", $id, $profile_id);

	$delete_user = $main->user_action(NULL, 'delete', $id);
?>			