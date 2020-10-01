<?php 

	include("../../config.php"); 
    error_reporting(0);
    ini_set('error_reporting', E_ERROR);
    ini_set('display_errors', 0);
	//**************** USER MANAGEMENT - START ****************\\

	include(LIB."/login/chklog.php");

	$profile_full = $logfname;
	$profile_name = $logname;
	$profile_id = $userid;
	$profile_level = $level;
	
	//***************** USER MANAGEMENT - END *****************\\
?>

<?php

	$id = $_POST['userid'];	

	//AUDIT TRAIL
	$log = $main->log_action("APPROVE_USER", $id, $profile_id);

	$user_approve = $main->user_action($_POST, 'approve', $id);
	$user_info = $main->get_users($id, 0, 0, NULL);

    ?>

    <script type="text/javascript">

        $(".approveUser").on("click", function() {		

            userid = $(this).attr('attribute');	
            userstatus = $(this).attr('attribute2');		
            $(".ustatusDiv" + userid).html('<i class="fa fa-refresh fa-spin fa-lg"></i>');
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/userapprove.php",
                data: "userid=" + userid + "&user_status=" + userstatus,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $(".ustatusDiv" + userid).html(data);
                }
            })

            return false;
        });

    </script>

    <?php

	echo '<a class="approveUser cursorpoint" attribute="'.$id.'" attribute2="'.$user_approve.'">'.($user_approve == 2 ? '<i class="fa fa-unlock-alt fa-lg greentext"></i>' : '<i class="fa fa-lock fa-lg redtext"></i>').'</a>';

	$message = "Hi ".$user_info[0]['user_fullname'].",\n\n";
	$message .= "Your account (".$user_info[0]['user_empnum'].") has been ".($user_approve == 2 ? 'ACTIVATED' : 'DEACTIVATED')." on system administrator.\n\n";
	$message .= "Thanks,\n";
	$message .= "iRoom Admin";

	$sendmail = mail($user_info[0]['user_email'], "iRoom Account Update", $message, "From: noreply@megaworldcorp.com");
?>			