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
                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Room Management</div>
                    <a name="restable"></a>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><form action="<?php echo WEB."/rooms"; ?>" method="POST" enctype="multipart/form-data">Search Room&nbsp;<input type="text" name="searchroom" placeholder="by name..." class="txtbox" />&nbsp;<input type="submit" name="btnroomsearch" value="Search" class="btn" /></form></td>
                            <td align="right"><input type="button" name="btnaddroom" value="Add Room" onClick="parent.location='<?php echo WEB; ?>/room/add'" class="btn" /></td>                            
                        </tr>
                        <?php if ($searchroom) { ?>
                        <tr>
                            <td>Your search result for &quot;<b><?php echo $searchroom; ?></b>&quot;</td>
                        </tr>
                        <?php } ?>
                    </table>
                    <table class="tdata" width="100%">
                        <tr>
                            <th width="10%">Room ID</td>
                            <th width="20%">Room Name</td>                            
                            <th width="25%">Location</td>
                            <th width="10%">Capacity</td>                            
                            <th width="10%">Status</td>
                            <th width="20%" colspan="2">Manage</td>
                        </tr>
                        <?php if ($rooms) { ?>
                        <?php foreach ($rooms as $key => $value) { ?>
                        <tr>
                            <?php 
                                $rescount = $main->get_reservations(0, 0, 0, 1, 0, $value['room_id'], NULL, 1);
                                $rgb = $main->HTMLToRGB($value['room_color']);
                                $hsl = $main->RGBToHSL($rgb);
                                if($hsl->lightness > 165) :
                                    $dark = 0;
                                else :
                                    $dark = 1;
                                endif;
                            ?>
                            <td bgcolor="<?php echo $value['room_color']; ?>"<?php echo $dark == 1 ? ' class="whitetext"' : ''; ?>><?php echo $value['room_id']; ?></td>
                            <td><b><?php echo $value['room_name']; ?></b><?php echo $value['room_dual'] ? ' (DUAL)' : ''; ?></td>      
                            <td><?php echo $value['loc_name']; ?> - <?php echo $value['floor_name']; ?></td>
                            <td class="righttalign"><?php if ($value['room_dual']) : echo $dual_capacity; else : echo $value['room_capacity'] ? $value['room_capacity'] : '<i>not set</i>'; endif; ?></td>
                            <td align="center" class="rstatusDiv<?php echo $value['room_id']; ?>"><a class="approveRoom cursorpoint" attribute="<?php echo $value['room_id']; ?>" attribute2="<?php echo $value['room_status']; ?>"><?php echo $value['room_status'] == 1 ? '<i class="fa fa-times fa-lg redtext"></i>' : '<i class="fa fa-check fa-lg greentext"></i>'; ?></a></td>
                            <td width="10%" align="center"><a title="Edit Room" href="<?php echo WEB; ?>/room/<?php echo $value['room_id']; ?>"><i class="fa fa-edit fa-lg"></i></a></td>                            
                            <td width="10%" align="center"><?php if (!$rescount) : ?><a title="Delete Room" class="delRoom cursorpoint" attribute="<?php echo $value['room_id']; ?>"><i class="fa fa-trash-o fa-lg redtext"></i></a><?php endif; ?></td>
                        </tr>
                        <?php } ?>
                        <?php if ($pages) { ?>
                        <tr>
                            <td colspan="5" align="center" class="whitebg"><?php echo $pages; ?></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="5" align="center">No room found</td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include(TEMP."/footer.php"); ?>