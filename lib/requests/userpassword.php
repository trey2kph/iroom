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
    //$log = $this->Core->log_action("SENDPASSWORD_USER", $id, $this->profile_id());

    $user_info = $main->get_users($id);

    if ($user_info[0]['user_email']) :        

        $mailink = WEB;

        $new_password = $register->random_password();	 

        $post['user_empnum'] = $user_info[0]['user_empnum'];
        $post['user_passw'] = $new_password;

        $update_password = $register->update_member($post, 2);

        $message = "<div style='display: block; border: 5px solid #000; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #000; font-weight: bold;'>Your iRoom New Account Password</span><br><br>Hi ".$user_info[0]['user_fullname'].",<br><br>";
        $message .= "Your account username/password has been sent by system.<br><br>";
        $message .= "<b>Username</b> ".$user_info[0]['user_empnum']."<br><br>";
        $message .= "<b>Password</b> ".$new_password."</b><br><br>";
        $message .= "Please change your password upon login<br>";
        $message .= "Click <a href='".$mailink."'>here</a> to log in<br><br>";
        $message .= "Thanks,<br>";
        $message .= "iRoom Admin";
        $message .= "<hr />".MAILFOOT."</div>";

        $headers = "From: noreply@megaworldcorp.com\r\n";
        $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $sendmail = mail($user_info[0]['user_email'], "Your iRoom New Account Password", $message, $headers);        
    endif;
?>			