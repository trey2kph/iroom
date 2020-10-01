<?php

	include("config.php");
	
	//**************** USER MANAGEMENT - START ****************\\

	include(LIB."/login/chklog.php");
    include(LIB."/init/settinginit.php");

	$profile_full = $logfname;
	$profile_name = $logname;
	$profile_id = $userid;
	$profile_email = $email;
	$profile_level = $level;

	$GLOBALS['level'] = $level;
	
	//***************** USER MANAGEMENT - END *****************\\
		
	$section = $_REQUEST['section'];

    //var_dump($profile_id);

    if ($logged) :
		
        if ($section) :

            include(OBJ."/".$section.".php");
            include(TEMP."/".$section.".php");

        else :

            $ishome = 1;
            include(OBJ."/index.php");
            include(TEMP."/index.php");

        endif;

    else :

        unset($_SESSION[$cookiename]);

        if ($section) :

            include(OBJ."/".$section.".php");
            include(TEMP."/".$section.".php");

        else :

            $ishome = 1;
            include(OBJ."/index.php");
            include(TEMP."/index.php");

        endif;

    endif;
	
?>