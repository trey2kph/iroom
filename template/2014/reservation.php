	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
    
    <div id="subcontainer" class="subcontainer">        
        <div id="lowersub" class="lowersub tbpadding10 dwhitebg">
            <div id="ltitle" class="lowerlist robotobold cattext dbluetext"><?php echo SYSTEMNAME; ?></div>
            <div id="lowerlist" class="lowerlist minheight150">
                <div class="lowerleft">
                    <?php include(TEMP."/menu.php"); ?>
                </div>
                <div class="lowerright">
                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Reservation Management</div>

                    <table class="margintop15" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <form action="<?php echo WEB."/reservation"; ?>" id="quick_jump" method="POST">
                                Search Reservation by Room&nbsp;
                                <select id="resroom" class="vsmalltext">
                                    <option value="<?php echo WEB."/reservation"; ?>" <?php echo $_GET['roomid'] ? "" : "selected" ?>>All room</option>
                                    <?php foreach ($rooms as $key => $value) { ?>
                                    <option value="<?php echo WEB."/reservation/room/".$value['room_id']; ?>" <?php echo $_GET['roomid'] == $value['room_id'] ? "selected" : "" ?>><?php echo $value['loc_name']; ?> - <?php echo $value['room_name']; ?></option>
                                    <?php } ?>
                                </select>
                                </form>
                            </td>
                        </tr>
                    </table>
                    
                    <div class="caltab2 caltab calsel cursorpoint">List View</div>
                    <div class="caltab1 caltab cursorpoint">Calendar View</div>
                    
                    <!-- LIST HERE -->
                    <div class="calview2">
                        <div id="rcaltable">
                            
                            <a name="restable"></a>
                            <table class="margintop15" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td><form action="#restable" method="POST" enctype="multipart/form-data">Search Reservation&nbsp;<input type="text" name="searchres" placeholder="by event name..." class="txtbox" />&nbsp;<input type="submit" name="btnressearch" value="Search" class="btn" /></form></td>
                                </tr>
                                <?php if ($searchres) { ?>
                                <tr>
                                    <td>Your search result for &quot;<b><?php echo $searchres; ?></b>&quot;</td>
                                </tr>
                                <?php } ?>
                            </table>
                            <table class="tdata" width="100%">
                                <tr>
                                    <th width="5%">ID</td>
                                    <th width="25%">Event Name</td>                            
                                    <th width="20%">Duration</td>
                                    <th width="15%">Status</td>
                                    <th width="25%">Reserved by</td>
                                    <th width="10%" colspan="3">Manage</td>
                                </tr>
                                <?php if ($reservation) { ?>
                                <?php foreach ($reservation as $key => $value) { ?>
                                <?php $dept_info = $main->get_dept($value['user_dept']); ?>
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
                                    <td align="right" style="background: <?php echo $value['room_color'] ? $value['room_color'] : "#CCC"; ?> !important"<?php echo $dark == 1 ? ' class="whitetext"' : ''; ?>><?php echo $value['reserve_id']; ?></td>
                                    <td><?php echo $value['reserve_eventname']; ?></td>
                                    <td><?php echo date("M j Y | g:ia", strtotime($value['reserve_checkin'])); ?> to <?php echo date("g:ia", strtotime($value['reserve_checkout'])); ?></td>
                                    <td>
                                        <?php 
                                            if ($value['reserve_status'] >= 1 && $value['reserve_status'] <= 6 && strtotime($value['reserve_checkout']) <= date('U')) :
                                                $expired = 1;
                                                echo 'EXPIRED';
                                            else :    
                                                $expired = 0;                   
                                                echo $main->get_reservestatus($value['reserve_status'], $profile_level); 
                                            endif;
                                        ?>
                                    </td>
                                    <td><?php echo $value['user_fullname']; ?> (<?php echo $dept_info[0]['dept_name']; ?>)</td>                            
                                    <td align="center"><div title="View Reserve" attribute="<?php echo $value['reserve_id']; ?>" attribute2="<?php echo $value['room_color']; ?>" attribute3="<?php echo $dark; ?>" class="openEvDetail cursorpoint"><i class="fa fa-eye fa-lg"></i></div></td>
                                    <?php if ($value['reserve_status'] == 2 && !$expired) { ?>
                                    <td align="center"><div title="Approve Reservation" attribute="<?php echo $value['reserve_id']; ?>" attribute2="<?php echo $value['room_color']; ?>" attribute3="<?php echo $dark; ?>" class="aappEvDetail cursorpoint"><i class="fa fa-check greentext fa-lg"></i></div></td>
                                    <td align="center"><div title="Set Waiting" attribute="<?php echo $value['reserve_id']; ?>" attribute2="<?php echo $value['room_color']; ?>" attribute3="<?php echo $dark; ?>" attribute4="1" class="rejEvDetail cursorpoint"><i class="fa fa-clock-o fa-lg redtext"></i></div></td>
                                    <?php } elseif ($value['reserve_status'] == 6 && !$expired) { ?>
                                    <td colspan="2" align="center"><div title="Approve Reservation" attribute="<?php echo $value['reserve_id']; ?>" attribute2="<?php echo $value['room_color']; ?>" attribute3="<?php echo $dark; ?>" class="aappEvDetail cursorpoint"><i class="fa fa-check greentext fa-lg"></i></div></td>
                                    <?php } else { ?>
                                    <td colspan="2" align="center">&nbsp;</td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                                <?php if ($pages) { ?>
                                <tr>
                                    <td colspan="8" align="center" class="whitebg"><?php echo $pages; ?></td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                    <td colspan="8" align="center" class="whitebg">No reservation has been made<?php echo $_GET['roomid'] ? " on this room" : ""; ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    
                    <!-- CALENDAR HERE -->
                    <div class="calview1 nodisplay">
                        <div id="rcalendar" class="marginbottom15"></div>                            
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include(TEMP."/footer.php"); ?>