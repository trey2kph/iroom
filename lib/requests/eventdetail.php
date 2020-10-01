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
	$id = $_POST['resid'];
    $dark = $_POST['dark'];
    $admin = $_POST['admin'];

	$single_reservation = $main->get_reservations($id);
    $floorsel = $main->get_floors($single_reservation[0]['floor_id']);
    //var_dump($floorsel);
    $location_data = $main->get_locations($floorsel[0]['floor_location']);
    $location = $main->get_locations(0);
    $floors = $main->get_floors_dropdown($floorsel[0]['floor_location']);
    //$floors = $main->get_floors(0, 0, 0, 0, $floorsel[0]['floor_location']);
    $rooms = $main->get_rooms(0, 0, 0, NULL, 0, 0, 0, $single_reservation[0]['floor_id']);
    ?>

	<?php foreach ($single_reservation as $key => $value) { 

    $dept_info = $main->get_dept($value['user_dept']);
    $dateinbreak = explode(" ", date("Y-m-d H:i:s", strtotime($value['reserve_checkin'])));
    $dateoutbreak = explode(" ", date("Y-m-d H:i:s", strtotime($value['reserve_checkout'])));
    $dateinval = $dateinbreak[0];
    $timeinval = $dateinbreak[1];
    $timeoutval = $dateoutbreak[1];

    ?>

    <script type="text/javascript">
        $(".checkindate").datepicker({ 
            dateFormat: 'yy-mm-dd',
            minDate: "1D",
            maxDate: "5D",
            changeMonth: true,
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day != 0), ''];
            }
        });

        $('.timein').timepicker({ 
            timeFormat: 'h:mmtt',
            stepHour: 1,
            stepMinute: 30,
            hourMin: 6,
            hourMax: 22
        });
    </script>

	<div id="ltitle" class="robotobold cattext2 <?php if (!$dark) { ?><?php if ($_POST['delete'] || $_POST['rej']) { ?>redtext <?php } else { ?>dbluetext <?php } ?><?php } else { ?>whitetext <?php } ?>marginbottom12"><?php if ($_POST['delete']) { ?>Are you sure you want to cancel <?php } elseif ($_POST['post'] || $_POST['app'] || $_POST['aapp']) { ?>Are you sure you want to approve <?php } elseif ($_POST['rej']) { ?>Are you sure you want to <?php if ($_POST['admin']) { ?>waiting list<?php } else { ?>reject<?php } ?> <?php } ?><?php echo $value['reserve_eventname']; ?><?php if ($_POST['delete'] || $_POST['post'] || $_POST['app'] || $_POST['aapp'] || $_POST['rej']) { ?>?<?php } ?></div>                            

    <?php if ($_POST['edit']) { ?>

    <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0"<?php echo $dark ? ' style="color: #FFF !important";' : ''; ?>>
        <form name="edit_reserve" method="POST" enctype="multipart/form-data">
        <tr>
            <td>Location</td>
            <td class="locdiv">
                <b><?php echo $location_data[0]['loc_name']; ?></b>
                <!--select name="reserve_locid" id="reserve_locid" class="reserve_locid select90">
                    <?php foreach ($location as $k => $v) { ?>
                        <?php $floor_count = $main->get_floors(0, 0, 0, 1, $v['loc_id']); ?>
                        <?php if ($floor_count) { ?>
                            <option value="<?php echo $v['loc_id']; ?>" <?php if ($v['loc_id'] == $location_data[0]['loc_id']) { ?>selected="selected"<?php } ?>><?php echo $v['loc_name']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select-->
            </td>
        </tr>
        <tr>
            <td>Floor</td>
            <td class="floordiv">
                <!--b><?php echo $value['floor_name']; ?></b-->
                <select name="reserve_floorid" id="reserve_floorid" class="reserve_floorid">
                    <?php foreach ($floors as $k => $v) { ?>
                    <option value="<?php echo $v['floor_id']; ?>"<?php if ($v['floor_id'] == $value['floor_id']) { ?> selected="selected"<?php } ?>><?php echo $v['floor_name']; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Event Name</td>
            <td><input type="text" name="reserve_eventname" id="reserve_eventname" value="<?php echo $value['reserve_eventname']; ?>" class="txtbox" /></td>
        </tr>
        <tr>
            <td>Date-in</td>
            <td>
                <input type="text" name="reserve_datein" id="reserve_datein" class="txtbox checkindate" value="<?php echo $dateinval; ?>" class="txtbox" />
            </td>
        </tr>
        <tr>
            <td>Time</td>
            <td>
                <input type="text" name="reserve_timein" id="reserve_timein" class="txtbox timein" value="<?php echo date("g:ia", strtotime($value['reserve_checkin'])); ?>" /> to <input type="text" name="reserve_timeout" id="reserve_timeout" class="txtbox timein" value="<?php echo date("g:ia", strtotime($value['reserve_checkout'])); ?>" />
            </td>
        </tr>
        <tr>
            <td>Person/s</td>
            <td>
                <select name="reserve_person" id="reserve_person" class="reserve_person">       
                <?php for($i = 2; $i <= 9; $i++) { ?>                                 
                    <option value="<?php echo $i; ?>" <?php echo $i == $value['reserve_person'] ? "selected" : ""; ?>><?php echo $i; ?></option>
                <?php } ?>
                <option value="10" <?php echo $value['reserve_person'] == 10 ? "selected" : ""; ?>>10 or more</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Name of Participants</td>
            <td><textarea name="reserve_participant" rows="3" class="txtarea width300"><?php echo $value['reserve_participant']; ?></textarea><br /><i>* multiple separated by comma</i></td>
        </tr>
        <tr>
            <td>Purpose</td>
            <td><input type="text" name="reserve_purpose" id="reserve_purpose" value="<?php echo $value['reserve_purpose']; ?>" class="txtbox width90per" /></td>
        </tr>
        <tr>
            <td>Notes</td>
            <td><input type="text" name="reserve_notes" id="reserve_notes" value="<?php echo $value['reserve_notes']; ?>" class="txtbox width90per" /></td>
        </tr>
        <?php if ($profile_level >= 8 && $value['reserve_user'] != $profile_id) { ?>
        <tr>
            <td>Update Reason</td>
            <td><input type="text" name="reserve_reason" id="reserve_reason" class="txtbox width90per" /></td>
        </tr>
        <?php } ?>
        <tr>
            <td>Reserve by</td>
            <td>
                <b><?php echo $value['user_fullname']; ?></b>
                <input type="hidden" name="reserve_user" id="reserve_user" value="<?php echo $value['reserve_user']; ?>" />
                <input type="hidden" name="user_fullname" id="user_fullname" value="<?php echo $value['user_fullname']; ?>" />
                <input type="hidden" name="user_email" id="user_email" value="<?php echo $value['user_email']; ?>" />
                <input type="hidden" name="reserve_user" id="reserve_user" value="<?php echo $value['reserve_user']; ?>" />
            </td>
        </tr>
        </form>
    </table> 

    <?php } elseif ($_POST['aapp']) { ?>

    <script type="text/javascript">
        $(".reserve_floorid").change(function() {	
            floorid = $("#reserve_floorid option:selected").val();
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/roomsel.php",
                data: "floorid=" + floorid,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $(".reserve_roomid").html(data);
                }
            })
        });
    </script>

    <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0"<?php echo $dark ? ' style="color: #FFF !important";' : ''; ?>>
        <form name="edit_reserve" method="POST" enctype="multipart/form-data">
        <tr>
            <td>Location</td>
            <td class="locdiv">
                <b><?php echo $location_data[0]['loc_name']; ?></b>
            </td>
        </tr>
        <tr>
            <td>Floor</td>
            <td class="floordiv">
                <select name="reserve_floorid" id="reserve_floorid" class="reserve_floorid">
                    <?php foreach ($floors as $k => $v) { ?>
                        <?php if ($v['roomcount']) { ?>
                        <option value="<?php echo $v['floor_id']; ?>"<?php if ($v['floor_id'] == $value['floor_id']) { ?> selected="selected"<?php } ?>><?php echo $v['floor_name']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Room</td>
            <td class="roomdiv">
                <select name="reserve_roomid" id="reserve_roomid" class="reserve_roomid">
                    <?php foreach ($rooms as $k => $v) { ?>
                    <option value="<?php echo $v['room_id']; ?>" <?php if ($v['room_id'] == $value['reserve_roomid']) { ?>selected="selected"<?php } ?>><?php echo $v['room_name']; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Event Name</td>
            <td><?php echo $value['reserve_eventname']; ?></td>
        </tr>
        <tr>
            <td>Date-in</td>
            <td>
                <?php echo date('F j, Y', strtotime($dateinval)); ?>
            </td>
        </tr>
        <tr>
            <td>Time</td>
            <td>
                <?php echo date("g:ia", strtotime($timeinval)); ?> to <?php echo date("g:ia", strtotime($timeoutval)); ?>
            </td>
        </tr>
        <tr>
            <td>Person/s</td>
            <td>
                <?php echo $value['reserve_person'] == 10 ? "10or more" : $value['reserve_person']; ?>
            </td>
        </tr>
        <?php if ($value['reserve_participant']) { ?>
        <tr>
            <td>Name of Participants</td>
            <td><?php echo $value['reserve_participant']; ?></td>
        </tr>
        <?php } ?>   
        <?php if ($value['reserve_purpose']) { ?>
        <tr>
            <td>Purpose</td>
            <td><?php echo $value['reserve_purpose']; ?></td>
        </tr>
        <?php } ?>   
        <?php if ($value['reserve_notes']) { ?>
        <tr>
            <td>Notes</td>
            <td><?php echo $value['reserve_notes']; ?></td>
        </tr>
        <?php } ?>    
        <tr>
            <td>Remarks</td>
            <td><input type="text" name="reserve_reason" id="reserve_reason" class="txtbox width90per" /></td>
        </tr>
        <tr>
            <td>Reserve by</td>
            <td>
                <b><?php echo $value['user_fullname']; ?></b>
                <input type="hidden" name="reserve_user" id="reserve_user" value="<?php echo $value['reserve_user']; ?>" />
                <input type="hidden" name="user_fullname" id="user_fullname" value="<?php echo $value['user_fullname']; ?>" />
                <input type="hidden" name="user_email" id="user_email" value="<?php echo $value['user_email']; ?>" />
                <input type="hidden" name="reserve_user" id="reserve_user" value="<?php echo $value['reserve_user']; ?>" />
            </td>
        </tr>
        </form>
    </table>  

    <?php } else { ?>

    <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0"<?php echo $dark ? ' style="color: #FFF !important";' : ''; ?>>        
        <form name="frmrmanage" action="" method="POST" class="smalltext">                        
            <tr>
                <td colspan = "2">
                    <div class="fields">
                        <div class="lfield valigntop">Reservation Details</div>
                        <div class="rfield valigntop">
                            <b>ID No.:</b> <?php echo $value['reserve_id']; ?><br />
                            <b>Location:</b> <?php echo $location_data[0]['loc_name']; ?><br />
                            <b>Floor:</b> <?php echo $value['floor_name']; ?><br />
                            <b>Room:</b> <?php echo $value['room_name'] ? $value['room_name'] : "<span class='redtext'>NOT YET SET</span>"; ?><br />
                            <b>Check-in:</b> <?php echo date("F j, Y - g:ia", strtotime($value['reserve_checkin'])); ?><br />
                            <b>Check-out:</b> <?php echo date("F j, Y - g:ia", strtotime($value['reserve_checkout'])); ?><br />                                
                            <b>Person/s:</b> <?php echo $value['reserve_person'] == 10 ? "10 or more" : $value['reserve_person']; ?><br />
                            <b>Participants:</b><br /><?php echo $value['reserve_participant'] ? $value['reserve_participant'] : "n/a"; ?><br />
                            <b>Purpose:</b><br /><?php echo $value['reserve_purpose'] ? $value['reserve_purpose'] : "n/a"; ?><br />
                            <b>Notes:</b><br /><?php echo $value['reserve_notes'] ? $value['reserve_notes'] : "n/a"; ?><br />
                            <b>Status:</b> <?php echo $main->get_reservestatus($value['reserve_status'], $profile_level); ?>
                        </div>
                    </div>
                    <div class="fields">
                        <div class="lfield valigntop">Reserved by</div>
                        <div class="rfield valigntop">
                            <b>Name:</b> <?php echo $value['user_fullname']; ?><br />
                            <b>Department:</b> <?php echo $dept_info[0]['dept_name']; ?><br />
                            <b>Contact #:</b> <?php echo $value['user_telno']; ?><br />
                            <b>Email Address:</b> <a href="mailto:<?php echo $value['user_email']; ?>"<?php echo $dark ? ' style="color: #FFF !important";' : ''; ?>><?php echo $value['user_email']; ?></a><br />                               
                            <input type="hidden" name="reserve_user" id="reserve_user" value="<?php echo $value['reserve_user']; ?>" />
                            <input type="hidden" name="user_fullname" id="user_fullname" value="<?php echo $value['user_fullname']; ?>" />
                            <input type="hidden" name="user_email" id="user_email" value="<?php echo $value['user_email']; ?>" />
                            <input type="hidden" name="admin" id="admin" value="<?php echo $admin ? 1 : 0; ?>" />
                        </div>
                    </div>
                </td>
            </tr>
            <?php if (($_POST['delete'] || $_POST['rej']) && ($profile_level == 2 || $profile_level == 9) && $value['reserve_user'] != $profile_id) { ?>
            <tr>
                <td width="25%">Reason</td>
                <td width="75%">
                    <input type="text" name="reserve_reason" id="reserve_reason" class="txtbox width90per" />
                </td>
            </tr>
            <?php } elseif (($_POST['app'] && $profile_level == 2) && $value['reserve_user'] != $profile_id) { ?>
            <tr>
                <td width="25%">Remarks</td>
                <td width="75%">
                    <input type="text" name="reserve_reason" id="reserve_reason" class="txtbox width90per" />
                </td>
            </tr>
            <?php } else { ?>            
                    <input type="hidden" name="reserve_reason" id="reserve_reason" value="1" />
            <?php } ?>            
        </form> 
    </table>

    <?php } ?>

    <?php } ?>