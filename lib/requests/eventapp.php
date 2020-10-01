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

	$single_reservation = $main->get_reservations($id);
    $floorsel = $main->get_floors($single_reservation[0]['floor_id']);
    //var_dump($floorsel);
    $location_data = $main->get_locations($floorsel[0]['floor_location']);
    $location = $main->get_locations(0);
    $floors = $main->get_floors(0, 0, 0, 0, $floorsel[0]['floor_location']);
    $rooms = $main->get_rooms(0, 0, 0, NULL, 0, 0, 0, $floors[0]['floor_id']);
    ?>

	<?php foreach ($single_reservation as $key => $value) { 

    $dateinbreak = explode(" ", date("Y-m-d H:i:s", strtotime($value['reserve_checkin'])));
    $dateoutbreak = explode(" ", date("Y-m-d H:i:s", strtotime($value['reserve_checkout'])));
    $dateinval = $dateinbreak[0];
    $timeinval = $dateinbreak[1];
    $timeoutval = $dateoutbreak[1];

    ?>

	<div id="ltitle" class="robotobold cattext2 <?php if ($_POST['delete']) { ?>redtext <?php } else { ?>dbluetext <?php } ?>marginbottom12"><?php if ($_POST['delete']) { ?>Are you sure you want to cancel <?php } elseif ($_POST['post']) { ?>Are you sure you want to approve <?php } ?><?php echo $value['reserve_eventname']; ?><?php if ($_POST['delete'] || $_POST['post']) { ?>?<?php } ?></div>                        

    <?php if ($_POST['edit']) { ?>

    <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
        <form name="edit_reserve" method="POST" enctype="multipart/form-data">
        <tr>
            <td>Location</td>
            <td class="locdiv">
                <b><?php echo $location_data[0]['loc_name']; ?></b>
                <!--select name="reserve_locid" id="reserve_locid" class="reserve_locid select90">
                    <?php foreach ($location as $k => $v) { ?>
                    <option value="<?php echo $v['loc_id']; ?>" <?php if ($v['loc_id'] == $location_data[0]['loc_id']) { ?>selected="selected"<?php } ?>><?php echo $v['loc_name']; ?></option>
                    <?php } ?>
                </select-->
            </td>
        </tr>
        <tr>
            <td>Floor</td>
            <td class="floordiv">
                <b><?php echo $value['floor_name']; ?></b>
                <!--select name="reserve_floorid" id="reserve_floorid" class="reserve_floorid select90">
                    <?php foreach ($floors as $k => $v) { ?>
                    <option value="<?php echo $v['floor_id']; ?>" <?php if ($v['floor_id'] == $value['reserve_floorid']) { ?>selected="selected"<?php } ?>><?php echo $v['floor_name']; ?></option>
                    <?php } ?>
                </select-->
            </td>
        </tr-->
        <tr>
            <td>Room</td>
            <td class="roomdiv">
                <select name="reserve_roomid" id="reserve_roomid" class="reserve_roomid select90">
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
            <td><?php echo $value['reserve_person'] >= 10 ? "10 or more" : $value['reserve_person']; ?></td>
        </tr>
        <tr>
            <td>Notes</td>
            <td><?php echo $value['reserve_notes']; ?></td>
        </tr>
        <?php if ($profile_level >= 8 && $value['reserve_user'] != $profile_id) { ?>
        <tr>
            <td>Update Valid Reason</td>
            <td><input type="text" name="reserve_reason" id="reserve_reason" class="txtbox" /></td>
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

    <?php } else { ?>

    <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">        
        <form name="frmrmanage" action="" method="POST" class="smalltext">                        
            <tr>
                <td colspan = "2">
                    <div class="fields">
                        <div class="lfield valigntop">Reservation Details</div>
                        <div class="rfield valigntop">
                            <b>ID No.:</b> <?php echo $value['reserve_id']; ?><br />
                            <b>Floor:</b> <?php echo $location_data[0]['location_name']; ?><br />
                            <b>Floor:</b> <?php echo $value['floor_name']; ?><br />
                            <b>Room:</b> <?php echo $value['room_name'] ? $value['room_name'] : "<span class='redtext'>NOT YET SET</span>"; ?><br />
                            <b>Check-in:</b> <?php echo date("F j, Y - g:ia", strtotime($value['reserve_checkin'])); ?><br />
                            <b>Check-out:</b> <?php echo date("F j, Y - g:ia", strtotime($value['reserve_checkout'])); ?><br />                                
                            <b>Person/s:</b> <?php echo $value['reserve_person'] == 10 ? "10 or more" : $value['reserve_person']; ?><br />
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
                            <b>Email Address:</b> <a href="mailto:<?php echo $value['user_email']; ?>"><?php echo $value['user_email']; ?></a><br />                                 
                            <input type="hidden" name="reserve_user" id="reserve_user" value="<?php echo $value['reserve_user']; ?>" />
                            <input type="hidden" name="user_fullname" id="user_fullname" value="<?php echo $value['user_fullname']; ?>" />
                            <input type="hidden" name="user_email" id="user_email" value="<?php echo $value['user_email']; ?>" />
                        </div>
                    </div>
                </td>
            </tr>
            <?php if ($_POST['delete'] && $profile_level >= 8 && $value['reserve_user'] != $profile_id) { ?>
            <tr>
                <td width="25%">Cancel Valid Reason</td>
                <td width="75%">
                    <input type="text" name="reserve_reason" id="reserve_reason" class="txtbox" />
                </td>
            </tr>
            <?php } else { ?>            
                    <input type="hidden" name="reserve_reason" id="reserve_reason" value="1" />
            <?php } ?>            
        </form> 
    </table>

    <?php } ?>

    <?php } ?>

<script type="text/javascript" src="<?php echo JSCRIPT; ?>/plugins.php"></script>           