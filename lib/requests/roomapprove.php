<?php 

	include("../../config.php"); 
	//**************** USER MANAGEMENT - START ****************\\

	include(LIB."/login/chklog.php");

	$profile_full = $logfname;
	$profile_name = $logname;
	$profile_id = $userid;
	$profile_level = $level;
	
	//***************** USER MANAGEMENT - END *****************\\
?>

<?php			

	$id = $_POST['roomid'];

	//AUDIT TRAIL
	$log = $main->log_action("APPROVE_ROOM", $id, $profile_id);

	$room_approve = $main->room_action($_POST, 'approve', $id);

    ?>
    
    <script type="text/javascript">
        $(".approveRoom").on("click", function() {		

            roomid = $(this).attr('attribute');	
            roomstatus = $(this).attr('attribute2');		
            $(".rstatusDiv" + roomid).html('<i class="fa fa-refresh fa-spin"></i>');

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/roomapprove.php",
                data: "roomid=" + roomid + "&room_status=" + roomstatus,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $(".rstatusDiv" + roomid).html(data);
                }
            })

            return false;
        });    
    </script>       

    <?php

	echo '<a class="approveRoom cursorpoint" attribute="'.$id.'" attribute2="'.$room_approve.'">'.($room_approve == 2 ? '<i class="fa fa-check fa-lg greentext"></i>' : '<i class="fa fa-times fa-lg redtext"></i>').'</a>';

?>			