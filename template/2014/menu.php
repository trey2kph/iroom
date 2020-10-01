
                    <?php if ($logged == 1) { ?>
                    <div class="cmsmenu mediumtext2">
                        <?php if ($profile_level <= 2) { ?>
                        <a href="<?php echo WEB; ?>"><div<?php if ($section == NULL) { ?> class="dselected"<?php } ?>><i class="fa fa-dashboard"></i> Dashboard</div></a>
                        <?php } ?>                        
                        <?php if ($profile_level >= 9) { ?>
                        <a href="<?php echo WEB; ?>/reservation"><div<?php if ($section == "reservation") { ?> class="dselected"<?php } ?>><i class="fa fa-calendar"></i> Reservations</div></a>
                        <?php if ($profile_level == 9 || $profile_level == 10) { ?>
                        <a href="<?php echo WEB; ?>/rooms"><div<?php if ($section == "rooms" || ($section == "view" && $part == "room")) { ?> class="dselected"<?php } ?>><i class="fa fa-building-o"></i> Rooms</div></a>
                        <a href="<?php echo WEB; ?>/locations"><div<?php if ($section == "locations" || ($section == "view" && $part == "location")) { ?> class="dselected"<?php } ?>><i class="fa fa-map-marker"></i> Locations</div></a>
                        <a href="<?php echo WEB; ?>/reports"><div<?php if ($section == "reports") { ?> class="dselected"<?php } ?>><i class="fa fa-bar-chart-o"></i> Reports</div></a>  
                        <a href="<?php echo WEB; ?>/user"><div<?php if ($section == "user" || ($section == "view" && $part == "user")) { ?> class="dselected"<?php } ?>><i class="fa fa-users"></i> Users</div></a>
                        <?php } ?>
                        <?php } ?>
                        <?php if ($profile_level == 10) { ?>
                        <a href="<?php echo WEB; ?>/logs"><div<?php if ($section == "logs") { ?> class="dselected"<?php } ?>><i class="fa fa-book"></i> Logs</div></a>                        
                        <a href="<?php echo WEB; ?>/setting"><div<?php if ($section == "setting") { ?> class="dselected"<?php } ?>><i class="fa fa-cogs"></i> Setting</div></a> 
                        <?php } ?>                        
                    </div>

                    <?php if ($section == "reservation") { ?>
                    <table class="tdataform rightmargin margintop<?php echo $section == "reservation" ? "20" : "10"; ?> vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <th colspan="2">Legend</th>
                        </tr>
                        <?php foreach ($locations as $key => $value) { ?>
                        <?php $roomperloc = $main->get_rooms_by_loc($value['loc_id']); ?>
                        <?php if ($roomperloc != NULL) { ?>
                        <tr>
                            <td colspan="2" align="center" style="background: #EEE;"><b><?php echo $value['loc_name']; ?></b></td>
                        </tr>                        
                        <?php } ?>
                        <?php foreach ($roomperloc as $k => $v) { ?>
                        <tr>
                            <td width="20%" style="background: <?php echo $v['room_color']; ?>;"></td>
                            <td width="80%"><a href="<?php echo WEB; ?>/<?php echo $section == "reservation" ? "" : "my"; ?>reservation/room/<?php echo $v['room_id']; ?>"><?php echo $v['room_name']; ?></a></td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <tr>
                            <td width="20%" style="background: #CCC;"></td>
                            <td width="80%" class="bold">Unassigned</a></td>
                        </tr>
                    </table>              
                    <?php } ?>

                    <?php } else { ?>&nbsp;<?php } ?>