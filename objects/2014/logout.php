<?php
	
	if ($logged == 1) {
	
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
		$page_title = "Megaworld Portal";	
		
		//***********************  MAIN CODE END  **********************\\

		$cookiename = 'megairoom_user';
		//AUDIT TRAIL
		$log = $main->log_action("LOGOUT", 0, $profile_id);
		unset($_SESSION[$cookiename]);
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
		
		global $sroot, $profile_id;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>