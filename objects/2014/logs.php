<?php
	if ($logged == 1 && $profile_level == 10) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);              
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$article_page = true;
		$page_title = "Logbook";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id;
        
        $searchlog_sess = $_SESSION['searchlogs'];
        $userlog_sess = $_SESSION['userlogs'];
        $tasklog_sess = $_SESSION['tasklogs'];
        $fromlog_sess = $_SESSION['fromlogs'];
        $tolog_sess = $_SESSION['tologs'];
		if ($_POST) {        
            $searchlog = $_POST['searchlogs'] ? $_POST['searchlogs'] : NULL;
            $searchuser = $_POST['userlogs'] ? $_POST['userlogs'] : 0;
            (int)$searchtask = $_POST['tasklogs'] ? $_POST['tasklogs'] : 0;
            $searchfrom = $_POST['fromlogs'] ? $_POST['fromlogs'] : 0;
            $searchto = $_POST['tologs'] ? $_POST['tologs'] : 0;
            $_SESSION['searchlogs'] = $searchlog;
            $_SESSION['userlogs'] = $_POST['userlogs'] ? $_POST['userlogs'] : 0;
            $_SESSION['tasklogs'] = $searchtask;
            $_SESSION['fromlogs'] = $searchfrom ? $searchfrom : '2014-01-01';
            $_SESSION['tologs'] = $searchto ? $searchto : date("Y-m-d");
        }
        elseif ($searchlog_sess || $userlog_sess || $tasklog_sess || $fromlog_sess || $tolog_sess) {
            $searchlog = $searchlog_sess ? $searchlog_sess : NULL;
            $searchuser = $userlog_sess ? $userlog_sess : 0;
            $searchtask = $tasklog_sess ? $tasklog_sess : 0;
            $searchfrom = $fromlog_sess ? $fromlog_sess : 0;
            $searchto = $tolog_sess ? $tolog_sess : 0;
            $_POST['searchlogs'] = $searchlog;
            $_POST['userlogs'] = $searchuser;
            $_POST['tasklogs'] = $searchtask;
            $_POST['fromlogs'] = $searchfrom ? $searchfrom : '2014-01-01';
            $_POST['tologs'] = $searchto ? $searchto : date("Y-m-d");
        }
        else {
            $searchlog = NULL;
            $searchuser = 0;
            $searchtask = 0;
            $searchfrom = 0;
            $searchto = 0;
            $_POST['searchres'] = NULL;
            $_POST['userlogs'] = 0;
            $_POST['tasklogs'] = 0;
            $_POST['fromlogs'] = '2014-01-01';
            $_POST['tologs'] = date("Y-m-d");
        }

		$logs = $main->get_log(0, $start, NUM_ROWS, $searchuser, $searchtask, $searchfrom, $searchto, $searchlog);
		$logs_count = $main->get_log(1, 0, 0, $searchuser, $searchtask, $searchfrom, $searchto, $searchlog);

		$pages = $main->pagination("logs", $logs_count, NUM_ROWS, 9);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>