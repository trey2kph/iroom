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

    if ($profile_level >= 8 && $_POST['reserve_reason'] != 1) {
        $validation->fields = array(
            "Cancel Valid Reason"	=>	$main->clean_variable($_POST['reserve_reason'])
        );
        $validation->validate_required();
        
        if(!empty($validation->message['error'])) {
            $message = $validation->message['error'];
            $err_message = "";
            foreach ($message as $key => $value) {
                $err_message .= $value.'<br>';
            }
            echo 1; 
        } else {    
            
            $id = $_POST['resid'];
        
            //AUDIT TRAIL
            $log = $main->log_action("DELETE_RESERVATION", $id, $profile_id);
        
            $delete_reservation = $main->reserve_action($_POST, 'delete', $id);
        }        
    } 
    else {
        $id = $_POST['resid'];
    
        //AUDIT TRAIL
        $log = $main->log_action("DELETE_RESERVATION", $id, $profile_id);
    
        $delete_reservation = $main->reserve_action($_POST, 'delete', $id);
    }
	
?>			