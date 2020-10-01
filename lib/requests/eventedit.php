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

	//input validation and cleaner (anti-MySQL injection)
    if ($profile_level >= 8 && $_POST['reserve_reason'] != 1) {
        $validation->fields = array("Room"            =>	$main->clean_variable($_POST['reserve_roomid']),
                            "Event Name"		      =>	$main->clean_variable($_POST['reserve_eventname']),
                            "Event Date In"	 	      =>	$main->clean_variable($_POST['reserve_datein']),
                            "Event Time In"		      =>	$main->clean_variable($_POST['reserve_timein']),
                            "Event Time Out"	      =>	$main->clean_variable($_POST['reserve_timeout']),
                            "Valid Update Reason"	  =>	$main->clean_variable($_POST['reserve_reason'])
        );
    } else {    
        $validation->fields = array("Event Name"	=>	$main->clean_variable($_POST['reserve_eventname']),
                            "Event Date In"	 	    =>	$main->clean_variable($_POST['reserve_datein']),
                            "Event Time In"		    =>	$main->clean_variable($_POST['reserve_timein']),
                            "Event Time Out"	    =>	$main->clean_variable($_POST['reserve_timeout'])
        );
    }

	$validation->validate_required();
	$validation->validate_date($_POST['reserve_datein'], true);

	if(!empty($validation->message['error'])) {
		$message = $validation->message['error'];
		$err_message = "";
		foreach ($message as $key => $value) {
			$err_message .= $value.'<br>';
		}
		echo $err_message; 
	} else {
        
        $_POST['reserve_checkin'] = $_POST['reserve_datein'].' '.date('H:i:00', strtotime($_POST['reserve_timein']));
        $_POST['reserve_checkout'] = $_POST['reserve_datein'].' '.date('H:i:00', strtotime($_POST['reserve_timeout']));
        $reserve_checkin2 = strtotime($_POST['reserve_datein'].' '.$_POST['reserve_timein']);
        $reserve_checkout2 = strtotime($_POST['reserve_datein'].' '.$_POST['reserve_timeout']);

        if ($reserve_checkin2 >= $reserve_checkout2) {
            echo "Time in is greater than time out";
        }
        else {

            if ($reserve_checkin > UNIX3MONTH) {
                echo 'Reservation must be made 3 months from now.';
            }
            else
            {
                $check_res = $main->check_reservation($_POST['reserve_roomid'], $_POST['reserve_checkin'], $_POST['reserve_checkout'], $_POST['reserve_id']);
                if ($check_res) {

                    $edit_reservation = $main->reserve_action($_POST, 'edit');			                    

                    $reserve_data = $main->get_reservedata($_POST['reserve_id']);
                    $reserve_invite = $reserve_data[0]['reserve_emails'];

                    $room_name = $main->get_rooms($_POST['reserve_roomid']);

                    if($edit_reservation) {

                        if ($profile_level >= 8) {
                            ini_set("SMTP", "mail.megaworldcorp.com");
                            ini_set("smtp_port", "25");
                            ini_set("sendmail_from", "pmis@megaworldcorp.com");

                            if($reserve_invite)
                            {
                                $email_invite = explode(',', $reserve_invite);
                                foreach ($email_invite as $invite)
                                {                                                
                                    $message = "<div style='display: block; border: 5px solid #000; padding: 10px; font-size: 12px; font-family: Verdana;'><span style='font-size: 18px; color: #000; font-weight: bold;'>iRoom Invites Update</span><br><br>Hi,<br><br>";
                                    $message .= $_POST['reserve_eventname']." has been moved on ".date("M j g:ia", $reserve_checkin)." to ".date("g:ia", $reserve_checkout)." at ".$room_name[0]['room_name'].", thru Reservation #".$_POST['reserve_id'].".<br>";
                                    $message .= "<br>Thanks,<br>";
                                    $message .= "iRoom Admin";
                                    $message .= "<hr />".MAILFOOT."</div>";

                                    $headers = "From: noreply@megaworldcorp.com\r\n";
                                    $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                                    $headers .= "MIME-Version: 1.0\r\n";
                                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                                    $sendmail = mail(trim($invite), "iRoom Invites Update", $message, $headers);
                                }
                            }

                            $message = "<div style='display: block; border: 5px solid #000; padding: 10px; font-size: 12px; font-family: Verdana;'><span style='font-size: 18px; color: #000; font-weight: bold;'>iRoom Update Reservation</span><br><br>Hi ".$_POST['user_fullname'].",<br><br>";
                            $message .= "Your reservation with iRoom No. ".$_POST['reserve_id']." has been updated to...<br><br>";					
                            $message .= "<b>Event Name:</b> ".$_POST['reserve_eventname']."<br>";
                            $message .= "<b>Room:</b> ".$room_name[0]['room_name']."<br>";
                            $message .= "<b>Check in/out:</b> ".date("M j, g:ia", $reserve_checkin)." to ".date("g:ia", $reserve_checkout)."<br>";
                            $message .= "<b>Person:</b> ".($_POST['reserve_person'] == 10 ? "10 or more" : $_POST['reserve_person'])."<br><br>";
                            if($reserve_reason) : $message .= "<b>Reason:</b> ".$_POST['reserve_reason']."<br><br>"; endif;

                            $message .= "Thanks,<br>";
                            $message .= "iRoom Admin";
                            $message .= "<hr />".MAILFOOT."</div>";

                            $headers = "From: noreply@megaworldcorp.com\r\n";
                            $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                            $sendmail = mail(trim($_POST['user_email']), "iRoom Update Reservation", $message, $headers);
                        }
                    }

                    //AUDIT TRAIL
                    $log = $main->log_action("EDIT_RESERVATION", $_POST['reserve_id'], $profile_id);
                    echo "Reservation has been successfully modified.";
                }
                else {
                    echo "Someone already reserved that room on prescribed date and time. Please choose another time or room.";
                }
            }
        }
    }

?>			