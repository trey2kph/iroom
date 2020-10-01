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
		$page_title = "User Management";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id;

        $searchuser_sess = $_SESSION['searchuser'];
		if ($_POST) {        
            $searchuser = $_POST['searchuser'] ? $_POST['searchuser'] : NULL;
            $_SESSION['searchuser'] = $searchuser;
        }
        elseif ($searchuser_sess) {
            $searchuser = $searchuser_sess ? $searchuser_sess : NULL;
            $_POST['searchuser'] = $searchuser != 0 ? $searchuser : NULL;
        }
        else {
            $searchuser = NULL;
            $_POST['searchuser'] = NULL;
        }

		$users = $main->get_users(0, $start, NUM_ROWS, $searchuser, 0, 0, $profile_id);
		$users_count = $main->get_users(0, 0, 0, $searchuser, 1, 0, $profile_id);
        //var_dump($users);
		$pages = $main->pagination("user", $users_count, NUM_ROWS, 9);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>