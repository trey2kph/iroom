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

    $sec = $_GET['sec'];

    switch ($sec) {
	    default :

            $dept = $_POST['dept'] ? $_POST['dept'] : 0;

            $userapp = $main->get_userapp(0, 0, 0, NULL, 0, $dept);

            $sel = '';
            if ($userapp) {	
                foreach ($userapp as $k => $v) {
                    $sel .= '<option value="'.$v['user_id'].'" >'.$v['user_fullname'].'</option>';
                }	
            }
            else
            {
                $sel .= 'No approver from this department';
            }

            echo $sel;      
        break;
    }
?>