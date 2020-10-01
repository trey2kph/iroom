<?php 

	include("../../config.php"); 
	//**************** USER MANAGEMENT - START ****************\\

	include(LIB."/login/chklog.php");
    include(LIB."/init/settinginit.php");

	$profile_full = $logfname;
	$profile_name = $logname;
	$profile_id = $userid;
	$profile_level = $level;
	
	//***************** USER MANAGEMENT - END *****************\\
?>

<?php				
	$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
	$start = NUM_ROWS * ($page - 1);

	$roomid = $_GET['roomid'] ? $_GET['roomid'] : 0; 
		
	global $sroot, $profile_id;

	$searchres = $_POST['searchres'] ? $_POST['searchres'] : 0;

    if ($profile_level == 1) {
        $reservation = $main->get_reservations(0, $start, NUM_ROWS, 1, $profile_id, $roomid, $searchres, 0, 1);
        $reservation_count = $main->get_reservations(0, 0, 0, 1, $profile_id, $roomid, $searchres, 1);
    } elseif ($profile_level == 2) {
        $reservation = $main->get_reservations(0, $start, NUM_ROWS, 1, 0, $roomid, $searchres, 0, 1, 0, 0, $profile_id);
        $reservation_count = $main->get_reservations(0, 0, 0, 1, $profile_id, $roomid, $searchres, 1, 0, 0, 0, $profile_id);
    }
	$rooms = $main->get_rooms(0);
	$locations = $main->get_locations(0);

	$pages = $main->pagination("reservation", $reservation_count[0]['rescount'], NUM_ROWS, 9);
?>	

                        <script type="text/javascript">
    
                            $(".openEvDetail").on("click", function() {	
                                $("#floatDiv").removeClass("invisible");	
                                $(".radd").addClass("invisible");	
                                $(".rdel").addClass("invisible");	
                                $(".redit").addClass("invisible");	
                                $(".rcal").removeClass("invisible");
                                $(".rpost").addClass("invisible");	
                                $(".rcon").addClass("invisible");
                                $(".rapp").addClass("invisible");
                                $(".raapp").addClass("invisible"); 
                                $(".rrej").addClass("invisible");    
                                $(".rcalinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

                                eventid = $(this).attr('attribute');
                                eventcolor = $(this).attr('attribute2');
                                dark = $(this).attr('attribute3');
                                del = 0;		

                                $(".rcal").css("background-color", eventcolor);

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
                                    data: "resid=" + eventid + "&dark=" + dark,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $(".rcalinfo").html(data);
                                    }
                                })

                                return false;
                            });

                            $(".editEvDetail").on("click", function() {	
                                $("#floatDiv").removeClass("invisible");
                                $(".radd").addClass("invisible");			
                                $(".rcal").addClass("invisible");		
                                $(".redit").removeClass("invisible");
                                $(".rdel").addClass("invisible");
                                $(".rpost").addClass("invisible");
                                $(".rcon").addClass("invisible");
                                $(".rapp").addClass("invisible");
                                $(".raapp").addClass("invisible");  
                                $(".rrej").addClass("invisible");   
                                $(".reditinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');	

                                eventid = $(this).attr('attribute');
                                eventcolor = $(this).attr('attribute2');
                                dark = $(this).attr('attribute3');
                                edit = 1;

                                $("#editEvId").val(eventid);		

                                $(".redit").css("background-color", eventcolor);

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
                                    data: "resid=" + eventid + "&edit=" + edit + "&dark=" + dark,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $(".reditinfo").html(data);
                                    }
                                })

                                return false;
                            });

                            $(".editEvApp").on("click", function() {	
                                $("#floatDiv").removeClass("invisible");
                                $(".radd").addClass("invisible");			
                                $(".rcal").addClass("invisible");		
                                $(".redit").removeClass("invisible");
                                $(".rdel").addClass("invisible");
                                $(".rpost").addClass("invisible");
                                $(".rcon").addClass("invisible");
                                $(".rapp").addClass("invisible");
                                $(".raapp").addClass("invisible");  
                                $(".rrej").addClass("invisible");   
                                $(".reditinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');	

                                eventid = $(this).attr('attribute');
                                eventcolor = $(this).attr('attribute2');
                                dark = $(this).attr('attribute3');
                                edit = 1;

                                $("#editEvId").val(eventid);	
                                $(".redit").css("background-color", eventcolor);

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventapp.php",
                                    data: "resid=" + eventid + "&edit=" + edit + "&dark=" + dark,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $(".reditinfo").html(data);
                                    }
                                })

                                return false;
                            });

                            $(".delEvDetail").on("click", function() {
                                $("#floatDiv").removeClass("invisible");
                                $(".radd").addClass("invisible");				
                                $(".rcal").addClass("invisible");
                                $(".redit").addClass("invisible");		
                                $(".rdel").removeClass("invisible");
                                $(".rpost").addClass("invisible");	
                                $(".rcon").addClass("invisible");
                                $(".rapp").addClass("invisible");
                                $(".raapp").addClass("invisible");
                                $(".rrej").addClass("invisible");     
                                $(".rdelinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

                                eventid = $(this).attr('attribute');
                                eventcolor = $(this).attr('attribute2');
                                dark = $(this).attr('attribute3');
                                del = 1;

                                $("#delEvId").val(eventid);	
                                $(".rdel").css("background-color", eventcolor);

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
                                    data: "resid=" + eventid + "&delete=" + del + "&dark=" + dark,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $(".rdelinfo").html(data);
                                    }
                                })

                                return false;
                            });

                            $("#editEvent").on('click', function() {	
                                $("#floatDiv").removeClass("invisible");
                                $(".radd").addClass("invisible");			
                                $(".redit").addClass("invisible");	
                                $(".rcon").removeClass("invisible");
                                $(".rapp").addClass("invisible");
                                $(".raapp").addClass("invisible"); 
                                $(".rrej").addClass("invisible");          	
                                $(".rconinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

                                //alert($(".reserve_roomid option:selected").val());

                                eventid = $("#editEvId").val();		
                                floor = $(".reserve_roomid option:selected").attr('attribute');	
                                room = $(".reserve_roomid option:selected").val();	
                                eventname = $("#reserve_eventname").val();
                                datein = $("#reserve_datein").val();	
                                timein = $("#reserve_timein").val();			
                                timeout = $("#reserve_timeout").val();	
                                person = $("#reserve_person option:selected").val();	
                                notes = $("#reserve_notes").val();
                                reason = $("#reserve_reason").val();
                                fullname = $("#user_fullname").val();		
                                email = $("#user_email").val();	
                                ruser = $("#reserve_user").val();		

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventedit.php",
                                    data: "reserve_id=" + eventid + "&reserve_floorid=" + floor + "&reserve_roomid=" + room + "&reserve_eventname=" + eventname + "&reserve_datein=" + datein + "&reserve_timein=" + timein + "&reserve_timeout=" + timeout + "&reserve_person=" + person + "&reserve_notes=" + notes + "&reserve_reason=" + reason + "&user_fullname=" + fullname + "&user_email=" + email,
                                    type: "POST",
                                    success: function(data) {
                                        $(".rconinfo").html(data);
                                    }
                                })

                                return false;
                            });

                            $("#delEvent").unbind('click').click(function() {

                                eventid = $("#delEvId").val();		
                                reason = $("#reserve_reason").val();
                                fullname = $("#user_fullname").val();		
                                email = $("#user_email").val();		

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventdelete.php",
                                    data: "resid=" + eventid + "&reserve_reason=" + reason + "&user_fullname=" + fullname + "&user_email=" + email,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        if (data == 1) {
                                            alert('Cancel Valid Reason is required.');
                                        }
                                        else {
                                            $("#floatDiv").addClass("invisible");			
                                            $(".rdel").addClass("invisible");	
                                            ajaxEvents();
                                            ajaxEvents2();
                                        }
                                    }
                                })

                                return false;
                            });

                            $(".appEvDetail").on("click", function() {
                                $("#floatDiv").removeClass("invisible");
                                $(".radd").addClass("invisible");				
                                $(".rcal").addClass("invisible");
                                $(".redit").addClass("invisible");		
                                $(".rdel").addClass("invisible");
                                $(".rpost").addClass("invisible");	
                                $(".rcon").addClass("invisible");
                                $(".rapp").removeClass("invisible");
                                $(".raapp").addClass("invisible");
                                $(".rrej").addClass("invisible");           
                                $(".rappinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

                                eventid = $(this).attr('attribute');
                                eventcolor = $(this).attr('attribute2');
                                dark = $(this).attr('attribute3');
                                app = 1;

                                $("#appEvId").val(eventid);	
                                $(".rapp").css("background-color", eventcolor);

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
                                    data: "resid=" + eventid + "&app=" + app + "&dark=" + dark,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $(".rappinfo").html(data);
                                    }
                                })

                                return false;
                            });

                            $("#appEvent").unbind('click').click(function() {

                                eventid = $("#appEvId").val();		
                                remark = $("#reserve_reason").val();	
                                fullname = $("#user_fullname").val();		
                                email = $("#user_email").val();		

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventapprove.php",
                                    data: "resid=" + eventid + "&reserve_remark=" + remark + "&user_fullname=" + fullname + "&user_email=" + email,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        if (data) {
                                            alert(data);
                                        } else {
                                            $("#floatDiv").addClass("invisible");			
                                            $(".rapp").addClass("invisible");	
                                            ajaxEvents();
                                            ajaxEvents2();
                                        }
                                    }
                                })

                                return false;
                            });

                            $(".aappEvDetail").on("click", function() {
                                $("#floatDiv").removeClass("invisible");
                                $(".radd").addClass("invisible");				
                                $(".rcal").addClass("invisible");
                                $(".redit").addClass("invisible");		
                                $(".rdel").addClass("invisible");
                                $(".rpost").addClass("invisible");	
                                $(".rcon").addClass("invisible");
                                $(".rapp").addClass("invisible");
                                $(".raapp").removeClass("invisible");  
                                $(".rrej").addClass("invisible");        
                                $(".raappinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

                                eventid = $(this).attr('attribute');
                                eventcolor = $(this).attr('attribute2');
                                dark = $(this).attr('attribute3');
                                aapp = 1;

                                $("#aappEvId").val(eventid);		        
                                $(".raapp").css("background-color", eventcolor);

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
                                    data: "resid=" + eventid + "&aapp=" + aapp + "&dark=" + dark,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $(".raappinfo").html(data);
                                    }
                                })

                                return false;
                            });

                            $("#aappEvent").unbind('click').click(function() {

                                eventid = $("#aappEvId").val();		
                                roomid = $("#reserve_roomid option:selected").val();		
                                remark = $("#reserve_reason").val();	
                                fullname = $("#user_fullname").val();		
                                email = $("#user_email").val();		

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventapprove.php",
                                    data: "resid=" + eventid + "&roomid=" + roomid + "&reserve_remark=" + remark + "&user_fullname=" + fullname + "&user_email=" + email + "&admin=1",
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        if (data) {
                                            alert(data);
                                        } else {
                                            $("#floatDiv").addClass("invisible");			
                                            $(".raapp").addClass("invisible");	
                                            ajaxEvents();
                                            ajaxEvents2();
                                        }
                                    }
                                })

                                return false;
                            });

                            $(".rejEvDetail").on("click", function() {
                                $("#floatDiv").removeClass("invisible");
                                $(".radd").addClass("invisible");				
                                $(".rcal").addClass("invisible");
                                $(".redit").addClass("invisible");		
                                $(".rdel").addClass("invisible");
                                $(".rpost").addClass("invisible");	
                                $(".rcon").addClass("invisible");
                                $(".rapp").addClass("invisible");
                                $(".raapp").addClass("invisible");
                                $(".rrej").removeClass("invisible");           
                                $(".rrejinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

                                eventid = $(this).attr('attribute');
                                eventcolor = $(this).attr('attribute2');
                                dark = $(this).attr('attribute3');
                                admin = $(this).attr('attribute4');
                                rej = 1;

                                $("#rejEvId").val(eventid);		
                                $(".rrej").css("background-color", eventcolor);

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
                                    data: "resid=" + eventid + "&rej=" + rej + "&dark=" + dark + "&admin=" + admin,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $(".rrejinfo").html(data);
                                    }
                                })

                                return false;
                            });

                            $("#rejEvent").unbind('click').click(function() {

                                eventid = $("#rejEvId").val();		
                                remark = $("#reserve_reason").val();	
                                fullname = $("#user_fullname").val();		
                                email = $("#user_email").val();		
                                admin = $("#admin").val();		

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/eventapprove.php",
                                    data: "resid=" + eventid + "&reserve_remark=" + remark + "&user_fullname=" + fullname + "&user_email=" + email + "&reject=1" + "&admin=" + admin,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        if (data) {
                                            alert(data);
                                        } else {
                                            $("#floatDiv").addClass("invisible");			
                                            $(".rrej").addClass("invisible");	
                                            ajaxEvents();
                                            ajaxEvents2();
                                        }
                                    }
                                })

                                return false;
                            });

                        </script>

						<a name="restable"></a>
						<table class="margintop15 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td><form action="#restable" method="POST" enctype="multipart/form-data">Search Reservation&nbsp;<input type="text" name="searchres" placeholder="by event name..." class="txtbox" />&nbsp;<input type="submit" name="btnressearch" value="Search" class="btn" /></form></td>
                            </tr>
                            <?php if ($searchres) { ?>
                            <tr>
                                <td>Your search result for &quot;<b><?php echo $searchres; ?></b>&quot;</td>
                            </tr>
                            <?php } ?>
                        </table>
                        <table class="tdata vsmalltext" width="100%">
                            <tr>
                                <th width="5%">ID</td>
                                <th width="30%">Event Name</td>                            
                                <th width="30%">Duration</td>                              
                                <th width="20%">Status</td>  
                                <th width="15%" colspan="3">Manage</td>
                            </tr>
                            <?php if ($reservation) { ?>
                            <?php foreach ($reservation as $key => $value) { ?>
                            <?php 
                                $rgb = $main->HTMLToRGB($value['room_color']);
                                $hsl = $main->RGBToHSL($rgb);
                                if ($value['reserve_status'] <= 2 || $value['reserve_status'] == 6 || $value['reserve_status'] == 7) : 
                                    $dark = 0;
                                else :
                                    if($hsl->lightness > 165) :
                                        $dark = 0;
                                    else :
                                        $dark = 1;
                                    endif;
                                endif;
                            ?>
                            <tr <?php echo $value['ifnow'] == 1 ? 'class="bold blinked"' : ''; ?>>
                                <td align="right" style="background: <?php echo $value['room_color']; ?> !important"<?php echo $dark == 1 ? ' class="whitetext"' : ''; ?>><?php echo $value['reserve_id']; ?></td>
                                <td><?php echo $value['reserve_eventname']; ?></td>                            
                                <td><?php echo date("M j Y | g:ia", strtotime($value['reserve_checkin'])); ?> to <?php echo date("g:ia", strtotime($value['reserve_checkout'])); ?></td>
                                <td><?php echo $main->get_reservestatus($value['reserve_status'], $profile_level); ?></td>
                                <td align="center"><div title="View Reserve" attribute="<?php echo $value['reserve_id']; ?>" attribute2="<?php echo $value['room_color']; ?>" attribute3="<?php echo $dark; ?>" class="openEvDetail cursorpoint"><i class="fa fa-eye fa-lg"></i></div></td>
                                <?php if ($profile_level == 2) { ?>
                                <?php if ($value['reserve_status'] == 1) { ?>
                                <td align="center"><div title="Approve Reservation" attribute="<?php echo $value['reserve_id']; ?>" attribute2="<?php echo $value['room_color']; ?>" attribute3="<?php echo $dark; ?>" class="appEvDetail cursorpoint"><i class="fa fa-check fa-lg greentext"></i></div></td>
                                <td align="center"><div title="Reject Reservation" attribute="<?php echo $value['reserve_id']; ?>" attribute2="<?php echo $value['room_color']; ?>" attribute3="<?php echo $dark; ?>" attribute4="0" class="rejEvDetail cursorpoint"><i class="fa fa-times fa-lg redtext"></i></div></td>
                                <?php } ?>
                                <?php } else { ?>
                                <?php if ($value['reserve_status'] == 1) { ?>
                                <td align="center"><div title="Edit Reservation" attribute="<?php echo $value['reserve_id']; ?>" attribute2="<?php echo $value['room_color']; ?>" attribute3="<?php echo $dark; ?>" class="editEvDetail cursorpoint"><i class="fa fa-edit fa-lg"></i></div></td>
                                <td align="center"><div title="Cancel Reservation" attribute="<?php echo $value['reserve_id']; ?>" attribute2="<?php echo $value['room_color']; ?>" attribute3="<?php echo $dark; ?>" class="delEvDetail cursorpoint"><i class="fa fa-trash-o fa-lg redtext"></i></div></td>
                                <?php } else { ?>
                                <td colspan="2" align="center"><div title="Cancel Reservation" attribute="<?php echo $value['reserve_id']; ?>" attribute2="<?php echo $value['room_color']; ?>" attribute3="<?php echo $dark; ?>" class="delEvDetail cursorpoint"><i class="fa fa-trash-o fa-lg redtext"></i></div></td>
                                <?php } ?> 
                                <?php } ?> 
                            </tr>
                            <?php } ?>
                            <?php if ($pages) { ?>
                            <tr>
                                <td colspan="7" align="center" class="whitebg"><?php echo $pages; ?></td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td colspan="7" align="center" class="whitebg">You haven't made any reservation<?php echo $_GET['roomid'] ? " on this room" : ""; ?></td>
                            </tr>
                            <?php } ?>
                        </table>		