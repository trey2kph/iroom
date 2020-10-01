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
        case 'floor':
            $locid = $_POST['locid'];

            $floors = $main->get_floors_dropdown($locid);

            $sel = '';
            if ($floors) {	
                foreach ($floors as $k => $v) {
                    if ($v['roomcount']) {
                        $sel .= '<option value="'.$v['floor_id'].'" >'.$v['floor_name'].'</option>';
                    }
                }	
            }
            else
            {
                $sel .= 'No floor from this location';
            }

            echo $sel;      
        break; 
        case 'floor2':
            $locid = $_POST['locid'];

            $floors = $main->get_floors_dropdown($locid);

            $sel = '';
            if ($floors) {	
                foreach ($floors as $k => $v) {
                    $sel .= '<option value="'.$v['floor_id'].'" >'.$v['floor_name'].'</option>';
                }	
            }
            else
            {
                $sel .= 'No floor from this location';
            }

            echo $sel;      
        break; 
	    default :

            $locid = $_POST['locid'] ? $_POST['locid'] : 0;
            $floorid = $_POST['floorid'] ? $_POST['floorid'] : 0;

            $rooms = $main->get_rooms_dropdown($locid, $floorid);

            $sel = '';
            if ($rooms) {	
                foreach ($rooms as $k => $v) {
                    $sel .= '<option value="'.$v['room_id'].'" >'.$v['room_name'].'</option>';
                }	
            }
            else
            {
                $sel .= 'No room from this location';
            }

            echo $sel;      
        break;
    }
?>