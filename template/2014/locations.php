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
                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Location Management</div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>                            
                            <td align="right"><input type="button" name="btnaddloc" value="Add Location" onClick="parent.location='<?php echo WEB; ?>/location/add'" class="btn" /></td>                            
                        </tr>
                    </table>
                    <table class="tdata" width="100%">
                        <tr>
                            <th width="10%">Location ID</td>
                            <th width="30%">Location Name</td>                            
                            <th width="25%">Description</td>                           
                            <th width="10%">Rooms</td>
                            <th width="20%" colspan="2">Manage</td>
                        </tr>
                        <?php if ($locations) { ?>
                        <?php foreach ($locations as $key => $value) { 
                            $room_count = $main->get_rooms_by_loc($value['loc_id'], 1);
                        ?>
                        <tr>
                            <td><?php echo $value['loc_id']; ?></td>
                            <td><?php echo $value['loc_name']; ?></td>      
                            <td><?php echo $value['loc_desc']; ?></td>
                            <td><?php echo $room_count; ?></td>
                            <td align="center"<?php if ($room_count != 0) { ?> colspan="2"<?php } ?> ><a title="Edit Location" href="<?php echo WEB; ?>/location/<?php echo $value['loc_id']; ?>"><i class="fa fa-edit fa-lg"></i></a></td>                            
                            <?php if ($room_count == 0) { ?>
                            <td align="center">                                
                                <a title="Delete Location" class="delLoc cursorpoint" attribute="<?php echo $value['loc_id']; ?>"><i class="fa fa-trash-o fa-lg redtext"></i></a>                                
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                        <?php if ($pages) { ?>
                        <tr>
                            <td colspan="5" align="center" class="whitebg"><?php echo $pages; ?></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="5" align="center">No location found</td>
                        </tr>
                        <?php } ?>
                    </table>
                    <i>Note: Location must have no rooms to delete</i>
                </div>
            </div>
        </div>
    </div>

    <?php include(TEMP."/footer.php"); ?>