<?php
	
	if ($logged == 1) {        
        
        if ($profile_level <= 2) {

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            # CLEAN THE GET VARIABLES
            if (isset($_GET['id']))
            { 
                $_GET['id'] = $main->clean_variable($_GET['id'], 1); 
            }
            $_GET['category_slug'] = $main->clean_variable($_GET['category_slug'], 2);
            $post_name = $main->clean_variable($_GET['article_post_name'], 2);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $article_page = true;
            $page_title = "Dashboard";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            $roomid = $_GET['roomid']; 

            if($_POST['btnresroom'] || $_POST['btnresroom_x'])
            {	
                //input validation and cleaner (anti-MySQL injection)
                $validation->fields = array("Location"	=>	$main->clean_variable($_POST['reserve_locid']),
                                    "Floor"				=>	$main->clean_variable($_POST['reserve_floorid']),
                                    "Event Name"		=>	$main->clean_variable($_POST['reserve_eventname']),
                                    "Event Date In"	 	=>	$main->clean_variable($_POST['reserve_datein']),
                                    "Event Time In"		=>	$main->clean_variable($_POST['reserve_timein']),
                                    "Event Time Out"	=>	$main->clean_variable($_POST['reserve_timeout'])
                );

                $_POST['reserve_roomid'] = 0;

                $validation->validate_required();
                $validation->validate_date($_POST['reserve_datein'], true);

                if(!empty($validation->message['error'])) {
                    $message = $validation->message['error'];
                    $err_message = ""; 
                    foreach ($message as $key => $value) {
                        $err_message .= $value.'<br>';
                    }                
                    echo '{"success": false, "error": "'.$err_message.'"}';
                    exit();                
                } elseif($main->filter_bad_words($_POST['reserve_eventname'])) {
                    $bad_word = $main->filter_bad_words($_POST['reserve_eventname']);
                    echo '{"success": false, "error": "Event name you\'ve entered contains inappropriate word"}';
                    exit();  
                } else {
                    
                    $_POST['reserve_checkin'] = $_POST['reserve_datein'].' '.date('H:i:00', strtotime($_POST['reserve_timein']));
                    $_POST['reserve_checkout'] = $_POST['reserve_datein'].' '.date('H:i:00', strtotime($_POST['reserve_timeout']));
                    $reserve_checkin = $_POST['reserve_datein'].' '.date('H:i:00', strtotime($_POST['reserve_timein']));
                    $reserve_checkout = $_POST['reserve_datein'].' '.date('H:i:00', strtotime($_POST['reserve_timeout']));
                    $reserve_checkin2 = strtotime($_POST['reserve_datein'].' '.$_POST['reserve_timein']);
                    $reserve_checkout2 = strtotime($_POST['reserve_datein'].' '.$_POST['reserve_timeout']);

                    if ($reserve_checkin2 >= $reserve_checkout2) {
                        echo '{"success": false, "error": "Time in is greater than time out"}';
                        exit();
                    }
                    else {

                        if ($reserve_checkin > UNIX3MONTH) {
                            echo '{"success": false, "error": "Reservation must be made 3 months from now. '.$reserve_checkin.' > '.UNIX3MONTH.'"}';
                            exit();
                        }
                        else
                        {
                            $check_res = $main->check_reservation($_POST['reserve_roomid'], $reserve_checkin, $reserve_checkout, 0);
                            if ($check_res) {
                                
                                $add_reserve = $main->reserve_action($_POST, 'add');      

                                if ($add_reserve) { 
                                    $room_name = $main->get_rooms($reserve_roomid);

                                    ini_set("SMTP", "mail.megaworldcorp.com");
                                    ini_set("smtp_port", "25");
                                    ini_set("sendmail_from", "pmis@megaworldcorp.com");

                                    $message = "<div style='display: block; border: 5px solid #000; padding: 10px; font-size: 12px; font-family: Verdana;'><span style='font-size: 18px; color: #000; font-weight: bold;'>iRoom New Reservation</span><br><br>Hi ".$user_fullname.",<br><br>";
                                    $message .= "You've successfully reserved a room from iRoom System and subject for approval, please check on the following detail.<br><br>";
                                    $message .= "<b>iRoom ID:</b> ".$lastid."<br>";
                                    $message .= "<b>Event Name:</b> ".$reserve_eventname."<br>";
                                    $message .= "<b>Room:</b> ".$room_name[0]['room_name']."<br>";
                                    $message .= "<b>Check in/out:</b> ".date("M j, g:ia", $reserve_checkin)." to ".date("g:ia", $reserve_checkout)."<br>";
                                    $message .= "<b>Person:</b> ".($reserve_person == 10 ? "10 or more" : $reserve_person)."<br>";
                                    if ($reserve_notes) {
                                    $message .= "<b>Notes:</b> ".$reserve_notes."<br>";
                                    }
                                    $message .= "<br>Thanks,<br>";
                                    $message .= "iRoom Admin";
                                    $message .= "<hr />".MAILFOOT."</div>";

                                    $headers = "From: noreply@megaworldcorp.com\r\n";
                                    $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                                    $headers .= "MIME-Version: 1.0\r\n";
                                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                                    $sendmail = mail(trim($user_email), "iRoom New Reservation #".$lastid, $message, $headers); 

                                    unset($_POST);

                                    //AUDIT TRAIL
                                    //$log = $main->log_action("RESERVE_ROOM", $add_reserve, $profile_id);
                                    echo '{"success": true}';
                                    exit();
                                }
                                else {
                                    echo '{"success": false, "error": "Process error"}';
                                    exit();
                                }
                            
                            }
                            else {
                                echo '{"success": false, "error": "Someone already reserved that room on prescribed date and time. Please choose another time or room."}';
                                exit();
                            }
                        }
                    }
                }
            }

            $searchres_sess = $_SESSION['searchres'];
            if ($_POST) {        
                $searchres = $_POST['searchres'] ? $_POST['searchres'] : 0;
                $_SESSION['searchres'] = $searchres;
            }
            elseif ($searchres_sess) {
                $searchres = $searchres_sess ? $searchres_sess : 0;
                $_POST['searchres'] = $searchres != 0 ? $searchres : NULL;
            }
            else {
                $searchres = 0;
                $_POST['searchres'] = NULL;
            }

            if ($profile_level == 1) {
                $reservation = $main->get_reservations(0, 0, NUM_ROWS, 1, 0, $roomid, NULL, 0, 1);
                $reservation_user = $main->get_reservations(0, $start, NUM_ROWS, 1, $profile_id, $roomid, $searchres, 0, 1);
                $reservation_count = $main->get_reservations(0, 0, 0, 1, $profile_id, $roomid, $searchres, 1);
            } elseif ($profile_level == 2) {
                $reservation = $main->get_reservations(0, 0, NUM_ROWS, 1, 0, $roomid, NULL, 0, 1);
                $reservation_user = $main->get_reservations(0, $start, NUM_ROWS, 1, 0, $roomid, $searchres, 0, 1, 0, 0, $profile_id);
                $reservation_count = $main->get_reservations(0, 0, 0, 1, $profile_id, $roomid, $searchres, 1, 0, 0, 0, $profile_id);
            }

            $rooms = $main->get_rooms(0, 0, 0, NULL, 0, 2);
            $locations = $main->get_locations_dropdown(0);

            $pages = $main->pagination("index", $reservation_count, NUM_ROWS, 9);
        }
        else
        {
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/reservation'</script>";
        }

	}	
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

	
?>