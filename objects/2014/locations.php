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
		$page_title = "Location Management";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id;
		$locations = $main->get_locations(0, $start, NUM_ROWS);
		$locations_count = $main->get_locations(0, 0, NUM_ROWS, 1);
        
        //var_dump($locations);

		$pages = $main->pagination("locations", $locations_count, NUM_ROWS, 9);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>