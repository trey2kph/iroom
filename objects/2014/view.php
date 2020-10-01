<?php
	
	# PAGINATION
	$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
	
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
	
	//***********************  MAIN CODE END  **********************\\
	
	global $sroot, $profile_id;

	$part = $_GET['part'];
	$id = $_GET['id'];

	if ($logged == 1 && ($profile_level == 9 || $profile_level == 10)) {

		switch($part) {		

	    	case "room":                
                
	    		$room = $main->get_rooms($id, 0, 0, NULL, 0, 500);    
	            $page_title = "Room Management";	
            
	    		if($_POST['btnaddroom'] || $_POST['btnaddroom_x'])
				{		
					//input validation and cleaner (anti-MySQL injection)
					$validation->fields = array("Room Name"	=>	$main->clean_variable($_POST['room_name']),
											"Room Color"	=>	$main->clean_variable($_POST['room_color'])
					);

					$validation->validate_required();

					if(!empty($validation->message['error'])) {
						$message = $validation->message['error'];
						$err_message = "";
						foreach ($message as $key => $value) {
							$err_message .= $value.'\n';
						}
						echo '<script type="text/javascript">alert("'.$err_message.'");</script>';
                        return false;
					} else {
                        
                        $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "jpg", "jpeg", "gif", "png");
                        
                        if ($_FILES['room_img']['name']) :
                            $filename = $_FILES['room_img']['name'];
                            $filesize = $_FILES['room_img']['size'];

                            $tempext = explode(".", $filename);
                            $extension = end($tempext);

                            if (($filesize >= 209715) || !in_array($extension, $allowedExts)) :
                                echo '<script type="text/javascript">alert("Image isn\'t JPG, PNG nor GIF and/or not less then 200Kb");</script>';
                                return false;    
                            endif;
                        endif;
                        
                        if ($_FILES['room_img']['name']) :

                            $image = $_FILES['room_img']['tmp_name'];
                            $filename = $_FILES['room_img']['name'];
                            $filesize = $_FILES['room_img']['size'];
                            $filetype = $_FILES['room_img']['type'];

                            $tempext = explode(".", $filename);
                            $extension = end($tempext);

                            if (($filesize < 209715) && in_array($extension, $allowedExts)) :

                                $path = "uploads/rooms/";
                                $fixname = 'room_'.date('U').'.'.$extension;
                                $target_path = $path.$fixname; 

                                $filemove = move_uploaded_file($image, $target_path);

                                $_POST['room_img'] = $fixname ? $fixname : NULL;

                            endif;

                        endif;

						$add_room = $main->room_action($_POST, 'add');

						if ($add_room) {
							//AUDIT TRAIL
							//$log = $main->log_action("ADD_ROOM", $add_room, $profile_id);

							echo '<script type="text/javascript">alert("The room has been successfully added");</script>';					
							echo '<script>window.location.href = "'.WEB.'/rooms";</script>';
						}
						else {
                            echo '<script type="text/javascript">alert("There\'s a problem");</script>';
                            return false;
                        }
					}
				}

				if($_POST['btneditroom'] || $_POST['btneditroom_x'])
				{
					//input validation and cleaner (anti-MySQL injection)
					$validation->fields = array("Room Name"	=>	$main->clean_variable($_POST['room_name'])
					);

					$validation->validate_required();

					if(!empty($validation->message['error'])) {
						$message = $validation->message['error'];
						$err_message = "";
						foreach ($message as $key => $value) {
							$err_message .= $value.'\n';
						}
						echo '<script type="text/javascript">alert("'.$err_message.'");</script>';
                        return false;
					} else {	
                        
                        $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "jpg", "jpeg", "gif", "png");
                        
                        if ($_FILES['room_img']['name']) :
                            $filename = $_FILES['room_img']['name'];
                            $filesize = $_FILES['room_img']['size'];

                            $tempext = explode(".", $filename);
                            $extension = end($tempext);

                            if (($filesize >= 209715) || !in_array($extension, $allowedExts)) :
                                echo '<script type="text/javascript">alert("Image isn\'t JPG, PNG nor GIF and/or not less then 200Kb");</script>';
                                return false;    
                            endif;
                        endif;
                        
                        if ($_FILES['room_img']['name']) :

                            $image = $_FILES['room_img']['tmp_name'];
                            $filename = $_FILES['room_img']['name'];
                            $filesize = $_FILES['room_img']['size'];
                            $filetype = $_FILES['room_img']['type'];

                            $tempext = explode(".", $filename);
                            $extension = end($tempext);

                            if (($filesize < 209715) && in_array($extension, $allowedExts)) :

                                $path = "uploads/rooms/";
                                $fixname = 'room_'.date('U').'.'.$extension;
                                $target_path = $path.$fixname; 

                                $filemove = move_uploaded_file($image, $target_path);

                                $_POST['room_img'] = $fixname ? $fixname : NULL;

                            endif;

                        endif;	

						$edit_room = $main->room_action($_POST, 'update');

						if ($edit_room) {
							//AUDIT TRAIL
							//$log = $main->log_action("UPDATE_ROOM", $_POST['room_id'], $profile_id);
							echo '<script type="text/javascript">alert("The room has been successfully updated");</script>';
                            echo '<script>window.location.href = "'.WEB.'/rooms";</script>';
						} 
						else {
                            echo '<script type="text/javascript">alert("There\'s a problem");</script>';
                            return false;
                        }
					}
				}

	    		$locations = $main->get_locations(0, 0, 0, 0, 0, 1);
	    		$rtypes = $main->get_rtypes(0);
	    		$room = $main->get_rooms($id, 0, 0, NULL, 0, 500);    
	    	break;
	    	case "location":
                $location = $main->get_locations($id);
                
	            $page_title = "Location Management";	
	    		if($_POST['btnaddloc'] || $_POST['btnaddloc_x'])
				{		
					//input validation and cleaner (anti-MySQL injection)
					$validation->fields = array("Location Name"	=>	$main->clean_variable($_POST['loc_name'])
					);

					$validation->validate_required();

					if(!empty($validation->message['error'])) {
						$message = $validation->message['error'];
						$err_message = "";
						foreach ($message as $key => $value) {
							$err_message .= $value.'\n';
						}
						echo '<script type="text/javascript">alert("'.$err_message.'");</script>';
                        return false;
					} else {
						$add_loc = $main->loc_action($_POST, 'add');

						if ($add_loc) {
							//AUDIT TRAIL
							//$log = $main->log_action("ADD_LOCATION", $add_loc, $profile_id);

							echo '<script type="text/javascript">alert("Location has been successfully added");</script>';					
							echo '<script>window.location.href = "'.WEB.'/location/'.$add_loc.'";</script>';
						}
						else {
                            echo '<script type="text/javascript">alert("There\'s a problem");</script>';
                            return false;
                        }
					}
				}

				if($_POST['btneditloc'] || $_POST['btneditloc_x'])
				{		
					//input validation and cleaner (anti-MySQL injection)
					$validation->fields = array("Location Name"	=>	$main->clean_variable($_POST['loc_name'])
					);

					$validation->validate_required();

					if(!empty($validation->message['error'])) {
						$message = $validation->message['error'];
						$err_message = "";
						foreach ($message as $key => $value) {
							$err_message .= $value.'\n';
						}
						echo '<script type="text/javascript">alert("'.$err_message.'");</script>';
                        return false;
					} else {

						$edit_loc = $main->loc_action($_POST, 'update');

						if ($edit_loc) {
							//AUDIT TRAIL
							//$log = $main->log_action("UPDATE_LOCATION", $_POST['loc_id'], $profile_id);
							echo '<script type="text/javascript">alert("Location has been successfully updated");</script>';
                            echo '<script>window.location.href = "'.WEB.'/locations";</script>';
						}
						else {
                            echo '<script type="text/javascript">alert("There\'s a problem");</script>';
                            return false;
                        }
					}
				}

	    		$location = $main->get_locations($id);
                if ($id) {
                    $floor_data = $main->get_floors(0, 0, 0, 0, $id);
                }
	    	break;
	    	case "reservation":
	    		$reservation = $main->get_reservations($id);
	    	break;
	    	case "reserve":
	    		$reservation = $main->get_reservations($id);
	    	break;
	    	case "user":
                $user = $main->get_users($id, 0, 0, NULL);
                
	            $page_title = "User Management";	
	    		if($_POST['btnadduser'] || $_POST['btnadduser_x'])
				{	
					//input validation and cleaner (anti-MySQL injection)
					$validation->fields = array("Name"			=>	$main->clean_variable($_POST['user_fullname']),
										"Department"			=>	$main->clean_variable($_POST['user_dept']),
										"Contact Number"		=>	$main->clean_variable($_POST['user_telno']),
										"Email Address"			=>	$main->clean_variable($_POST['user_email'])
					);

					$validation->validate_required();
					$validation->validate_email($_POST['user_email']);

					if(!empty($validation->message['error'])) {
						$message = $validation->message['error'];
						$err_message = "";
						foreach ($message as $key => $value) {
							$err_message .= $value.'\n';
						}
						echo '<script type="text/javascript">alert("'.$err_message.'");</script>';
                        return false;
					} else {

						$same_account = $main->find_username($_POST['user_empnum']);
						if ($same_account > 0)
						{
							echo '<script type="text/javascript">alert("Employee number '.$_POST['user_uname'].' has been already used.");</script>';
                            return false;
						}
						else 
						{
                            $_POST['password'] = $register->random_password();                            
                            $_POST['user_passw'] = md5($_POST['password']);                            
                            $level_text = strtolower($main->get_userlevel($_POST['user_level']));
                            
                            $add_user = $main->user_action($_POST, 'add');
                            //var_dump($add_user);

                            if ($add_user) {
                                //AUDIT TRAIL
                                //$log = $main->log_action("CREATE_USER", $add_user, $profile_id);
                                
                                $message = "<div style='display: block; border: 5px solid #000; padding: 10px; font-size: 12px; font-family: Verdana; width: 90%;'><span style='font-size: 18px; color: #000; font-weight: bold;'>Your iRoom Account</span><br><br>Hi ".$_POST['user_fullname'].",<br><br>";
                                $message .= "You've been registered on our system as <b>".$level_text."</b>.<br><br>";
                                $message .= "Your account credential are:<br><br>";
                                $message .= "<b>Username:</b> ".strtoupper($_POST['user_empnum'])."<br>";
                                $message .= "<b>Password:</b> ".$_POST['password']."<br><br>";
                                $message .= "Please click <a href='".WEB."'>here</a> to log in<br><br>";
                                $message .= "Thanks,<br>";
                                $message .= "iRoom Admin";
                                $message .= "<hr />".MAILFOOT."</div>";

                                $headers = "From: noreply@megaworldcorp.com\r\n";
                                $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                                $headers .= "MIME-Version: 1.0\r\n";
                                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                                $sendmail = mail($_POST['user_email'], "Your iRoom Account", $message, $headers);   
                                
                                echo '<script type="text/javascript">alert("User has been successfully added and approve.");</script>';										
                                echo '<script>window.location.href = "'.WEB.'/user";</script>';
                            }
                            else {
                                echo '<script type="text/javascript">alert("There\'s a problem");</script>';
                                return false;
                            }

						}
					}
					
				}

				if($_POST['btnedituser'] || $_POST['btnedituser_x'])
				{		
					//input validation and cleaner (anti-MySQL injection)
					$validation->fields = array("Name"			=>	$main->clean_variable($_POST['user_fullname']),
										"Department"			=>	$main->clean_variable($_POST['user_dept']),
										"Contact Number"		=>	$main->clean_variable($_POST['user_telno']),
										"Email Address"			=>	$main->clean_variable($_POST['user_email'])
					);

					$validation->validate_required();
					$validation->validate_email($_POST['user_email']);

					if(!empty($validation->message['error'])) {
						$message = $validation->message['error'];
						$err_message = "";
						foreach ($message as $key => $value) {
							$err_message .= $value.'\n';
						}
						echo '<script type="text/javascript">alert("'.$err_message.'");</script>';
                        return false;
					} else {

						$edit_user = $main->user_action($_POST, 'update');

						if ($edit_user) {
							//AUDIT TRAIL
							$log = $main->log_action("UPDATE_USER", $_POST['user_id'], $profile_id);
							echo '<script type="text/javascript">alert("The user info has been successfully modified");</script>';
                            echo '<script>window.location.href = "'.WEB.'/user";</script>';
						} 
						else {
                            echo '<script type="text/javascript">alert("There\'s a problem");</script>';
                            return false;
                        }
                        
					}
				}

	    		$user = $main->get_users($id, 0, 0, NULL);
                $dept = $main->get_dept();
	    	break;

	    	case "profile":
            
	            $page_title = "Change Password";	
	    		if($_POST['btneditprofile'] || $_POST['btneditprofile_x'])
				{		
					if ($_POST['user_password0']) 
					{
						$find_account = $main->find_password($profile_name, $_POST['user_password0']);

						if ($find_account > 0)
						{

							if ($_POST['user_password1']) 
							{
								if ($_POST['user_password1'] == $_POST['user_password2']) 
								{
									//AUDIT TRAIL
									$log = $main->log_action("EDIT_PASSWORD", 0, $profile_id);

									$edit_account = $main->user_action($_POST, 'edit_password');
									//$edit_user = $main->user_action($_POST, 'update');
									if ($edit_account) echo '<script type="text/javascript">alert("Your user account has been successfully modified");</script>';
									else echo '<script type="text/javascript">alert("There\'s a problem");</script>';
								}
								else
								{
									echo '<script type="text/javascript">alert("Password mismatch");</script>';
								}
							}
							else
							{
								echo '<script type="text/javascript">alert("Please enter new password");</script>';
							}
						}
						else
						{
							echo '<script type="text/javascript">alert("Your current password is incorrect");</script>';
						}
					}
					/*else 
					{
						//input validation and cleaner (anti-MySQL injection)
						$validation->fields = array("Name"			=>	$main->clean_variable($_POST['user_fullname']),
											"Department"			=>	$main->clean_variable($_POST['user_dept']),
											"Contact Number"		=>	$main->clean_variable($_POST['user_telno']),
											"Email Address"			=>	$main->clean_variable($_POST['user_email'])
						);

						$validation->validate_required();
						$validation->validate_email($_POST['user_email']);

						if(!empty($validation->message['error'])) {
							$message = $validation->message['error'];
							$err_message = "";
							foreach ($message as $key => $value) {
								$err_message .= $value.'\n';
							}
							echo '<script type="text/javascript">alert("'.$err_message.'");</script>'; 
						} else {
							$edit_user = $main->user_action($_POST, 'update');

							if ($edit_user) {
								//AUDIT TRAIL
								$log = $main->log_action("UPDATE_PROFILE", $profile_id, $profile_id);
								echo '<script type="text/javascript">alert("Your user profile has been successfully modified");</script>';
							}
							else echo '<script type="text/javascript">alert("There\'s a problem");</script>';
						}
					}*/
				}

	    		$user = $main->get_users($profile_id, 0, 0, NULL);
	    	break; 

	    	case "forgot":
	    	case "reset":
	    		echo '<script>window.location.href = "'.WEB.'";</script>';
	    	break;    	
	    }
	}
	elseif ($logged == 1) {		

		switch($part) {		
		
	    	case "profile":
	            $page_title = "My Profile";	
	    		if($_POST['btneditprofile'] || $_POST['btneditprofile_x'])
				{		
					if ($_POST['user_password0']) 
					{
						$find_account = $main->find_password($profile_name, $_POST['user_password0']);

						if ($find_account > 0)
						{

							if ($_POST['user_password1']) 
							{
								if ($_POST['user_password1'] == $_POST['user_password2']) 
								{
									//AUDIT TRAIL
									$log = $main->log_action("EDIT_PASSWORD", 0, $profile_id);

									$edit_account = $main->user_action($_POST, 'edit_password');
									$edit_user = $main->user_action($_POST, 'update');
									if ($edit_account) echo '<script type="text/javascript">alert("Your user account has been successfully modified");</script>';
									else echo '<script type="text/javascript">alert("There\'s a problem");</script>';
								}
								else
								{
									echo '<script type="text/javascript">alert("Password mismatch");</script>';
								}
							}
							else
							{
								echo '<script type="text/javascript">alert("Please enter new password");</script>';
							}
						}
						else
						{
							echo '<script type="text/javascript">alert("Your current password is incorrect");</script>';
						}
					}
					else 
					{
						//input validation and cleaner (anti-MySQL injection)
						$validation->fields = array("Name"			=>	$main->clean_variable($_POST['user_fullname']),
											"Department"			=>	$main->clean_variable($_POST['user_dept']),
											"Contact Number"		=>	$main->clean_variable($_POST['user_telno']),
											"Email Address"			=>	$main->clean_variable($_POST['user_email'])
						);

						$validation->validate_required();
						$validation->validate_email($_POST['user_email']);

						if(!empty($validation->message['error'])) {
							$message = $validation->message['error'];
							$err_message = "";
							foreach ($message as $key => $value) {
								$err_message .= $value.'\n';
							}
							echo '<script type="text/javascript">alert("'.$err_message.'");</script>'; 
						} else {
							$edit_user = $main->user_action($_POST, 'update');

							if ($edit_user) {
								//AUDIT TRAIL
								$log = $main->log_action("UPDATE_PROFILE", $profile_id, $profile_id);
								echo '<script type="text/javascript">alert("Your user profile has been successfully modified");</script>';
							}
							else echo '<script type="text/javascript">alert("There\'s a problem");</script>';
						}
					}
				}

	    		$user = $main->get_users($profile_id, 0, 0, NULL);
	    	break;  
	    }
    }
    else {

    	switch($part) {
            
            case "room":  
            case "location":  
            case "profile":
                echo '<script>window.location.href = "'.WEB.'";</script>';
            break;

	    	case "forgot":
	            $page_title = "Forgot Password";	
	    		if($_POST['btnsendpassword'] || $_POST['btnsendpassword_x'])
				{		
					if ($_POST['user_email']) 
					{
						$find_email = $main->find_email($_POST['user_email']);

						if ($find_email)
						{							
							$send_password = $main->send_password($_POST['user_email'], $find_email);
							if ($send_password) {

								//AUDIT TRAIL
								$log = $main->log_action("SEND_PASSWORD", 0, $profile_id);

								echo '<script type="text/javascript">alert("The change password procedure has been successfully sent to your email address");</script>';
								echo '<script>window.location.href = "'.WEB.'";</script>';
							}
							else echo '<script type="text/javascript">alert("There\'s a problem on mail side");</script>';
						}
						else
						{
							echo '<script type="text/javascript">alert("There\'s no email address '.$_POST['user_email'].' on our database");</script>';
						}
					}
					else 
					{
						echo '<script type="text/javascript">alert("Your email address must fill-up");</script>';
					}
				}
	    	break;    
            
	    	case "user":
	            $page_title = "iRoom User Management";	
	    		if($_POST['btnadduser'] || $_POST['btnadduser_x'])
				{	
					//input validation and cleaner (anti-MySQL injection)
					$validation->fields = array("Name"			=>	$main->clean_variable($_POST['user_fullname']),
										"Department"			=>	$main->clean_variable($_POST['user_dept']),
										"Contact Number"		=>	$main->clean_variable($_POST['user_telno']),
										"Email Address"			=>	$main->clean_variable($_POST['user_email']),
										"Username"				=>	$main->clean_variable($_POST['user_uname']),
										"Password"				=>	$main->clean_variable($_POST['user_password1']),
										"Confirm Password"		=>	$main->clean_variable($_POST['user_password2'])
					);

					$validation->validate_required();
					$validation->validate_email($_POST['user_email']);

					if(!empty($validation->message['error'])) {
						$message = $validation->message['error'];
						$err_message = "";
						foreach ($message as $key => $value) {
							$err_message .= $value.'\n';
						}
						echo '<script type="text/javascript">alert("'.$err_message.'");</script>'; 
					} else {

						$same_account = $main->find_username($_POST['user_uname']);
						if ($same_account > 0)
						{
							echo '<script type="text/javascript">alert("Username '.$_POST['user_uname'].' has been already used.");</script>';				
						}
						else 
						{					
							if ($_POST['user_password1'] != $_POST['user_password2']) 
							{
								echo '<script type="text/javascript">alert("Password mismatch!");</script>';
								return false;									
							}
							else
							{
								if ($profile_id) $add_user = $main->user_action($_POST, 'add_approve');
								else $add_user = $main->user_action($_POST, 'add');

								if ($add_user) {
									//AUDIT TRAIL
									if ($profile_id) $log = $main->log_action("ADD_USER", $add_user, $profile_id);
									else { 
										$log = $main->log_action("REGISTER_USER", $add_user, $add_user);

										$message = "Hi ".$_POST['user_fullname'].",\n\n";
										$message .= "Your registration with User ID. ".$add_user." is on process and subject for approval by administrator\n\n";					
										$message .= "Thanks,\n";
										$message .= "iRoom Admin";

										$sendmail = mail($_POST['user_email'], "iRoom Registration", $message, "From: noreply@megaworldcorp.com");
									}

									if ($profile_id) {
										echo '<script type="text/javascript">alert("User has been successfully added and approve.");</script>';										
										echo '<script>window.location.href = "'.WEB.'/user";</script>';
									}
									else {
										echo '<script type="text/javascript">alert("User '.$_POST['user_uname'].' has been registered and subject for approval.");</script>';										
										echo '<script>window.location.href = "'.WEB.'";</script>';
									}
								}
								else echo '<script type="text/javascript">alert("There\'s a problem");</script>';
							}

						}
					}
					
				}

				if($_POST['btnedituser'] || $_POST['btnedituser_x'])
				{		
					//input validation and cleaner (anti-MySQL injection)
					$validation->fields = array("Name"			=>	$main->clean_variable($_POST['user_fullname']),
										"Department"			=>	$main->clean_variable($_POST['user_dept']),
										"Contact Number"		=>	$main->clean_variable($_POST['user_telno']),
										"Email Address"			=>	$main->clean_variable($_POST['user_email'])
					);

					$validation->validate_required();
					$validation->validate_email($_POST['user_email']);

					if(!empty($validation->message['error'])) {
						$message = $validation->message['error'];
						$err_message = "";
						foreach ($message as $key => $value) {
							$err_message .= $value.'\n';
						}
						echo '<script type="text/javascript">alert("'.$err_message.'");</script>'; 
					} else {

						$edit_user = $main->user_action($_POST, 'update');

						if ($edit_user) {
							//AUDIT TRAIL
							$log = $main->log_action("UPDATE_USER", $_POST['user_id'], $profile_id);
							echo '<script type="text/javascript">alert("The user info has been successfully modified");</script>';
                            echo '<script>window.location.href = "'.WEB.'/user";</script>';
						} 
						else echo '<script type="text/javascript">alert("There\'s a problem");</script>';
					}
				}

	    		$user = $main->get_users($id, 0, 0, NULL);
                $dept = $main->get_dept();
	    	break;

	    	case "reset":
	            $page_title = "Reset Password";

	    		if($_POST['btnresetpassword'] || $_POST['btnresetpassword_x'])
				{	

					if ($_POST['user_password1']) 
					{
						if ($_POST['user_password1'] == $_POST['user_password2']) 
						{	

							//AUDIT TRAIL
							$log = $main->log_action("RESET_PASSWORD", 0, $profile_id);

							$edit_account = $main->user_action($_POST, 'edit_password');
							if ($edit_account) echo '<script type="text/javascript">alert("Your user password has been successfully modified");</script>';
							else echo '<script type="text/javascript">alert("There\'s a problem");</script>';
						}
						else
						{
							echo '<script type="text/javascript">alert("Password mismatch");</script>';
						}
					}
					else
					{
						echo '<script type="text/javascript">alert("Please enter new password");</script>';
					}

				}

	    		if($_GET['nameid'])
				{		
					$nameid = $_GET['nameid'];

					$user = $main->get_users(0, 0, 0, NULL, 0, $nameid);

					if (!$user)
					{							
						echo '<script>window.location.href = "'.WEB.'";</script>';
					}
				}
				else 
				{
					echo '<script>window.location.href = "'.WEB.'";</script>';				
				}

	    	break;    	
    	}
    }
	
?>