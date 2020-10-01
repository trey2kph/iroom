<?php 

	include("../../config.php"); 
	//**************** USER MANAGEMENT - START ****************\\

	include(LIB."/login/chklog.php");

	$profile_full = $logfname;
	$profile_name = $logname;
	$profile_id = $userid;
	$profile_level = $level;
	
	//***************** USER MANAGEMENT - END *****************\\

    if ($_POST['admin'] == 1) {
        $validation->fields = array(
            "Remark"	=>	$main->clean_variable($_POST['reserve_remark'])
        );
        $validation->validate_required();
        
        if(!empty($validation->message['error'])) {
            $message = $validation->message['error'];
            $err_message = "";
            foreach ($message as $key => $value) {
                $err_message .= $value.'<br>';
            }
            echo str_replace('<br>', '', trim($err_message)); 
        } else {   
            
            if ($_POST['reject']) :
            
                $id = $_POST['resid'];

                //AUDIT TRAIL
                //$log = $main->log_action("DELETE_RESERVATION", $id, $profile_id);

                $rej_reservation = $main->reserve_action($_POST, 'adminreject', $id);   
            
                $message = "<div style='display: block; border: 5px solid #000; padding: 10px; font-size: 12px; font-family: Verdana;'><span style='font-size: 18px; color: #000; font-weight: bold;'>iRoom Reservation</span><br><br>Hi ".$_POST['user_fullname'].",<br><br>";
                $message .= "Your reservation with iRoom No. ".$id." has been rejected by admin.<br><br><b>Remarks:</b> ".$_POST['reserve_remark'];					
                $message .= "<br><br>Thanks,<br>";
                $message .= "iRoom Admin";
                $message .= "<hr />".MAILFOOT."</div>";

                $headers = "From: noreply@megaworldcorp.com\r\n";
                $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                $sendmail = mail($_POST['user_email'], "iRoom Rejected Reservation", $message, $headers);
            
            else :
            
                $id = $_POST['resid'];

                //AUDIT TRAIL
                //$log = $main->log_action("DELETE_RESERVATION", $id, $profile_id);

                $app_reservation = $main->reserve_action($_POST, 'adminapprove', $id);
                $reservation_info = $main->get_reservations($id);
                $room_info = $main->get_rooms($_POST['reserve_roomid']);
                $user_info = $main->get_users($reservation_info[0]['reserve_user']);            

                if($reservation_info[0]['reserve_emails'])
                {
                    $email_invite = explode(',', $reservation_info[0]['reserve_emails']);
                    foreach ($email_invite as $invite)
                    {                                                
                        $message = "<div style='display: block; border: 5px solid #000; padding: 10px; font-size: 12px; font-family: Verdana;'><span style='font-size: 18px; color: #000; font-weight: bold;'>iRoom Invites</span><br><br>Hi,<br><br>";
                        $message .= $user_info[0]['user_fullname']." (".$user_info[0]['user_email'].") invited you on ".$reservation_info[0]['reserve_eventname']." at ".$room_info[0]['room_name'].", ".date("M j g:ia", $reservation_info[0]['reserve_checkin'])." to ".date("g:ia", $reservation_info[0]['reserve_checkout'])." thru Reservation #".$reservation_info[0]['reserve_id'].".<br>";
                        if ($reservation_info[0]['reserve_notes']) {
                        $message .= "<br><b>Notes:</b> ".$reservation_info[0]['reserve_notes']."<br>";
                        }
                        $message .= "<br>Thanks,<br>";
                        $message .= "iRoom Admin";
                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: noreply@megaworldcorp.com\r\n";
                        $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail(trim($invite), "iRoom Invites", $message, $headers);
                    }
                }

                $message = "<div style='display: block; border: 5px solid #000; padding: 10px; font-size: 12px; font-family: Verdana;'><span style='font-size: 18px; color: #000; font-weight: bold;'>iRoom Reservation</span><br><br>Hi ".$user_info[0]['user_fullname'].",<br><br>";
                $message .= "Your reservation with iRoom No. ".$id." has been approved by admin.<br><br><b>Remarks:</b> ".$_POST['reserve_remark'];					
                $message .= "<br><br>Thanks,<br>";
                $message .= "iRoom Admin";
                $message .= "<hr />".MAILFOOT."</div>";

                $headers = "From: noreply@megaworldcorp.com\r\n";
                $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                $sendmail = mail($_POST['user_email'], "iRoom Approved Reservation", $message, $headers);
            
            endif;
        }        
    } 
    else {
        $validation->fields = array(
            "Remark"	=>	$main->clean_variable($_POST['reserve_remark'])
        );
        $validation->validate_required();
        
        if(!empty($validation->message['error'])) {
            $message = $validation->message['error'];
            $err_message = "";
            foreach ($message as $key => $value) {
                $err_message .= $value.'<br>';
            }
            echo str_replace('<br>', '', trim($err_message)); 
        } else {     
            
            if ($_POST['reject']) :
            
                $id = $_POST['resid'];

                //AUDIT TRAIL
                //$log = $main->log_action("DELETE_RESERVATION", $id, $profile_id);

                $rej_reservation = $main->reserve_action($_POST, 'reject', $id);   
            
                $message = "<div style='display: block; border: 5px solid #000; padding: 10px; font-size: 12px; font-family: Verdana;'><span style='font-size: 18px; color: #000; font-weight: bold;'>iRoom Reservation</span><br><br>Hi ".$_POST['user_fullname'].",<br><br>";
                $message .= "Your reservation with iRoom No. ".$id." has been rejected by your immediate superior.<br><br><b>Remarks:</b> ".$_POST['reserve_remark'];					
                $message .= "<br><br>Thanks,<br>";
                $message .= "iRoom Admin";
                $message .= "<hr />".MAILFOOT."</div>";

                $headers = "From: noreply@megaworldcorp.com\r\n";
                $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                $sendmail = mail($_POST['user_email'], "iRoom Rejected Reservation", $message, $headers);
            
            else :
        
                $id = $_POST['resid'];

                //AUDIT TRAIL
                //$log = $main->log_action("APPROVE_RESERVATION", $id, $profile_id);

                $app_reservation = $main->reserve_action($_POST, 'approve', $id);

                $message = "<div style='display: block; border: 5px solid #000; padding: 10px; font-size: 12px; font-family: Verdana;'><span style='font-size: 18px; color: #000; font-weight: bold;'>iRoom Reservation</span><br><br>Hi ".$_POST['user_fullname'].",<br><br>";
                $message .= "Your reservation with iRoom No. ".$id." has been approved by your immediate superior.<br><br><b>Remarks:</b> ".$_POST['reserve_remark'];					
                $message .= "<br><br>Thanks,<br>";
                $message .= "iRoom Admin";
                $message .= "<hr />".MAILFOOT."</div>";

                $headers = "From: noreply@megaworldcorp.com\r\n";
                $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                $sendmail = mail($_POST['user_email'], "iRoom Approved Reservation", $message, $headers);
            
            endif;
        }
    }
	
?>