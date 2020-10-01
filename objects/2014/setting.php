<?php

	if ($logged == 1 && ($profile_level == 9 || $profile_level == 10)) {
	
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
		$page_title = "iRoom User Management";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id;
        
        if($_POST['btneditset'] || $_POST['btneditset_x'])
        {
            $edit_set = $main->set_update($_POST);

            if ($edit_set) {
                //AUDIT TRAIL
                $log = $main->log_action("UPDATE_SET", 0, $profile_id);
                echo '<script type="text/javascript">alert("Setting has been successfully updated");</script>';
            } 
            else echo '<script type="text/javascript">alert("There\'s a problem");</script>';
        }

		$setting = $main->get_set(0);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>