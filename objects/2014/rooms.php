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
		$page_title = "Room Management";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id;

		$searchroom_sess = $_SESSION['searchroom'];
		if ($_POST) {        
            $searchroom = $_POST['searchroom'] ? $_POST['searchroom'] : 0;
            $_SESSION['searchroom'] = $searchroom;
        }
        elseif ($searchroom_sess) {
            $searchroom = $searchroom_sess ? $searchroom_sess : 0;
            $_POST['searchroom'] = $searchroom != 0 ? $searchroom : NULL;
        }
        else {
            $searchroom = 0;
            $_POST['searchroom'] = NULL;
        }

		$rooms = $main->get_rooms(0, $start, NUM_ROWS, $searchroom, 0, 500);
		$rooms_count = $main->get_rooms(0, 0, NUM_ROWS, $searchroom, 1, 500);

		$pages = $main->pagination("rooms", $rooms_count, NUM_ROWS, 9);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>