<?php

	if ($logged == 1) {
        
        if ($profile_level >= 9) {
	
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
            $page_title = "Reservation Management";	

            //***********************  MAIN CODE END  **********************\\

            $roomid = $_GET['roomid']; 

            global $sroot, $profile_id;

            $searchres_sess = $_SESSION['searchres2'];
            if ($_POST) {        
                $searchres = $_POST['searchres'] ? $_POST['searchres'] : 0;
                $_SESSION['searchres2'] = $searchres;
            }
            elseif ($searchres_sess) {
                $searchres = $searchres_sess ? $searchres_sess : 0;
                $_POST['searchres'] = $searchres != 0 ? $searchres : NULL;
            }
            else {
                $searchres = 0;
                $_POST['searchres'] = NULL;
            }

            $reservation = $main->get_reservations(0, $start, NUM_ROWS, 0, 0, $roomid, $searchres);
            $reservation_count = $main->get_reservations(0, 0, 0, 0, 0, $roomid, $searchres, 1);
            $rooms = $main->get_rooms(0, 0 , 0, NULL, 0, 2);
            $locations = $main->get_locations(0);

            //var_dump($reservation);

            $pages = $main->pagination("reservation", $reservation_count[0]['rescount'], NUM_ROWS, 9);
            
        } else {
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";    
        }

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>