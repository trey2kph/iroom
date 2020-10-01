<?php
	
	if ($logged == 0) {
	
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
		$page_title = "Login";	
		
		//***********************  MAIN CODE END  **********************\\

		$roomid = $_GET['roomid']; 
		
		global $sroot, $profile_id;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";
	}
	
?>