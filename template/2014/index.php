	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
    
    <div id="subcontainer" class="subcontainer">        
        <div id="lowersub" class="lowersub tbpadding10 dwhitebg">
            <div id="ltitle" class="lowerlist robotobold cattext dbluetext"><?php echo SYSTEMNAME; ?></div>
            <div id="lowerlist" class="lowerlist minheight150">
                <div class="lowerleft"<?php if ($profile_level < 7) : ?> style="display: none;"<?php endif; ?>>
                    <?php include(TEMP."/menu.php"); ?>
                </div>
                <div class="lowerright"<?php if ($profile_level < 7) : ?> style="width: 96% !important;"<?php endif; ?>>
                    <?php if ($profile_level >= 7) : ?><div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">iRoom Dashboard</div><?php endif; ?>
                    
                    <?php if (ANNOUNCEMENT != "") { ?>
                    <div id="announcement" class="announcement marginbottom12"><?php echo ANNOUNCEMENT; ?></div>
                    <?php } ?>

                    <table class="margintop15 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <form action="<?php echo WEB; ?>" id="quick_jump" method="POST">
                                Search Reservation by Room&nbsp;
                                <select id="resroom" class="vsmalltext">
                                    <option value="<?php echo WEB; ?>" <?php echo $_GET['roomid'] ? "" : "selected" ?>>All room</option>
                                    <?php foreach ($rooms as $key => $value) { ?>
                                    <option value="<?php echo WEB."/myreservation/room/".$value['room_id']; ?>" <?php echo $_GET['roomid'] == $value['room_id'] ? "selected" : "" ?>><?php echo $value['loc_name']; ?> - <?php echo $value['room_name']; ?></option>
                                    <?php } ?>
                                </select>
                                </form>
                            </td>
                            <td class="righttalign">
                                <?php if ($profile_level != 2) { ?><button name="openEvCreate" class="btn openEvCreate">Reserve A Room</button><?php } ?>
                            </td>
                        </tr>
                    </table>
                    
                    <?php if ($profile_level == 1) { ?>
                    <div class="caltab1 caltab<?php if (!$_GET["page"] && !$_POST["searchres"]) { ?> calsel<?php } ?> cursorpoint">Reservation Calendar</div>                    
                    <div class="caltab2 caltab<?php if ($_GET["page"] || $_POST["searchres"]) { ?> calsel<?php } ?> cursorpoint">Room I've Reserved</div>
                    <?php } else { ?>
                    <div class="caltab2 caltab calsel cursorpoint">Reservations for Approval</div>
                    <?php } ?>    
                    
                    <?php if ($profile_level == 1) { ?>
                    <div class="calview1<?php if ($_GET["page"] || $_POST["searchres"]) { ?> nodisplay<?php } ?>">                    
                        <!--div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Reservation Dashboard</div-->
                        <!-- CALENDAR HERE -->
                        <div id="rcalendar" class="marginbottom15"></div>                         
                    </div>
                    <?php } ?>    
                        
                    <div class="calview2<?php if (!$_GET["page"] && !$_POST["searchres"] && $profile_level != 2) { ?> nodisplay<?php } ?>">                    
                        <!--div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Room I've Reserved</div-->
                        <div id="rcaltable2">
                            <!-- LIST HERE -->
                            
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
                                <?php if ($reservation_user) { ?>
                                <?php foreach ($reservation_user as $key => $value) { ?>
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
                                    <td colspan="6" align="center" class="whitebg"><?php echo $pages; ?></td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                    <td colspan="6" align="center">You haven't made any reservation<?php echo $_GET['roomid'] ? " on this room" : ""; ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include(TEMP."/footer.php"); ?>