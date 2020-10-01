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

                    <?php 

                    switch($part) {

                    case "room":                   

                    ?>

                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12"><?php if ($id == "add") echo "Add Room"; elseif ($id == "delete") echo "Are you sure to delete this room?"; else echo "Edit Room"; ?></div>

                    <?php 

                    if ($id == "add")
                    {

                    ?>

                    <form name="frmbmanage" method="POST" enctype="multipart/form-data">                        
                        <div class="fields">
                            <div class="lfield valigntop">Room Name <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="text" name="room_name" value="<?php echo $_POST['room_name']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields">                            
                            <div class="lfield valigntop">Location <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <select id="room_locid" name="room_locid" class="text40">
                                <?php foreach ($locations as $k => $v) { ?>    
                                    <option value="<?php echo $v['loc_id']; ?>" <?php echo $_POST['room_locid']==$v['loc_id'] ? "selected" : ""; ?>><?php echo $v['loc_name']; ?></option>
                                <?php } ?>
                                </select>
                                <a href="<?php echo WEB; ?>/locations">Manage Locations</a>
                            </div>
                        </div>
                        <div class="fields">                            
                            <div class="lfield valigntop">Floor <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <select id="room_floorid" name="room_floorid" class="text40">
                                    <?php $floors = $main->get_floors(0, 0, 0, 0, $locations[0]['loc_id']); ?>
                                    <?php foreach ($floors as $k => $v) { ?>    
                                        <option value="<?php echo $v['floor_id']; ?>" <?php echo $_POST['room_floorid']==$v['floor_id'] ? "selected" : ""; ?>><?php echo $v['floor_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Description</div>
                            <div class="rfield valigntop"><textarea name="room_desc" class="txtarea"><?php echo $_POST['room_desc']; ?></textarea></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Image</div>
                            <div class="rfield valigntop"><input id="room_img" type="file" name="room_img" class="dgraytext" /></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Capacity</div>
                            <div class="rfield valigntop">
                                <select id="room_capacity" name="room_capacity" class="text20">
                                    <?php for ($ic=0; $ic<=100; $ic++) { ?>    
                                        <option value="<?php echo $ic; ?>" <?php echo $_POST['room_capacity']==$ic ? "selected" : ""; ?>><?php echo $ic; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Color Code <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="text" name="room_color" class="txtcolor text40 txtbox" value="<?php echo $_POST['room_color']; ?>" readonly /></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Type <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <select name="room_type" class="text40">       
                                <?php foreach ($rtypes as $k => $v) { ?>                                 
                                    <option value="<?php echo $v['rtype_id']; ?>" <?php echo $_POST['room_type']==$v['rtype_id'] ? "selected" : ""; ?>><?php echo $v['rtype_name']; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="fields centertalign margintop10">                        
                            <input type="submit" name="btnaddroom" value="Add Room" class="btn" />&nbsp;                            
                            <input type="button" name="btnback" value="Back" onClick="parent.location='<?php echo WEB; ?>/rooms'" class="redbtn" />
                        </div>
                        <div class="fields margintop10">  
                            <i class="redtext">* required</i>
                        </div>
                    </form> 

                    <?php

                    } 

                    else {

                    foreach ($room as $key => $value) { ?>

                    <form name="frmbmanage" method="POST" enctype="multipart/form-data">                        
                        <div class="fields">
                            <div class="lfield valigntop">Room Name <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="text" name="room_name" value="<?php echo $value['room_name']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields">                            
                            <div class="lfield valigntop">Location <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <select id="room_locid" name="room_locid" class="text40">
                                    <?php foreach ($locations as $k => $v) { ?>    
                                        <option value="<?php echo $v['loc_id']; ?>" <?php echo $value['room_locid']==$v['loc_id'] ? "selected" : ""; ?>><?php echo $v['loc_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <a href="<?php echo WEB; ?>/locations">Manage Locations</a>
                            </div>
                        </div>
                        <div class="fields">                            
                            <div class="lfield valigntop">Floor <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <?php $floors_info = $main->get_floors($value['room_floorid']); ?>
                                <?php //var_dump($floors_info); ?>
                                <select id="room_floorid" name="room_floorid" class="text40">
                                    <?php $floors = $main->get_floors(0, 0, 0, 0, ($value['room_floorid'] ? $floors_info[0]['floor_location'] : $value['room_locid'])); ?>
                                    <?php foreach ($floors as $k => $v) { ?>    
                                        <option value="<?php echo $v['floor_id']; ?>" <?php echo $value['room_floorid']==$v['floor_id'] ? "selected" : ""; ?>><?php echo $v['floor_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Description</div>
                            <div class="rfield valigntop"><textarea name="room_desc" class="txtarea"><?php echo $value['room_desc']; ?></textarea></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Image</div>
                            <div class="rfield valigntop"><input id="room_img" type="file" name="room_img" class="dgraytext" /></div>
                        </div>
                        <?php if ($value['room_img']) { ?>
                        <div class="fields">
                            <div class="lfield valigntop">&nbsp;</div>
                            <div class="rfield valigntop"><img src="<?php echo WEB; ?>/uploads/rooms/<?php echo $value['room_img']; ?>" class="img200" /></div>
                        </div>
                        <?php } ?>
                        <div class="fields">
                            <div class="lfield valigntop">Capacity</div>
                            <div class="rfield valigntop">
                                <select id="room_capacity" name="room_capacity" class="text20">
                                    <?php for ($ic=0; $ic<=100; $ic++) { ?>    
                                        <option value="<?php echo $ic; ?>" <?php echo $value['room_capacity']==$ic ? "selected" : ""; ?>><?php echo $ic; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Color Code <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="text" name="room_color" class="txtcolor text40 txtbox" value="<?php echo $value['room_color']; ?>" style="border: #999 solid 1px; background-color: <?php echo $value['room_color']; ?>;" readonly />&nbsp;<i>text inside textbox must be readable</i></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Type</div>
                            <div class="rfield valigntop">
                                <select name="room_type" class="text40">
                                <?php foreach ($rtypes as $k => $v) { ?>                                 
                                    <option value="<?php echo $v['rtype_id']; ?>" <?php echo $value['room_type']==$v['rtype_id'] ? "selected" : ""; ?>><?php echo $v['rtype_name']; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="fields centertalign margintop10">                        
                            <input type="submit" name="btneditroom" value="Update" class="btn" />&nbsp;                            
                            <input type="button" name="btnback" value="Back" onClick="parent.location='<?php echo WEB; ?>/rooms'" class="redbtn" />
                            <input type="hidden" name="room_id" value="<?php echo $value['room_id']; ?>" />
                        </div>
                        <div class="fields margintop10">  
                            <i class="redtext">* required</i>
                        </div>
                    </form> 

                    <?php } ?>

                    <?php } ?>

                    <?php

                    break;

                    case "location":                   

                    ?>

                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12"><?php echo $id == "add" ? "Add" : "Edit"; ?> Location</div>

                    <?php 

                    if ($id == "add")
                    {

                    ?>

                    <form name="frmbmanage" method="POST" enctype="multipart/form-data">                        
                        <div class="fields">
                            <div class="lfield valigntop">Location Name <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="text" name="loc_name" value="<?php echo $_POST['loc_name']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Description</div>
                            <div class="rfield valigntop"><input type="text" name="loc_desc" value="<?php echo $_POST['loc_desc']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields centertalign margintop10">                        
                            <input type="submit" name="btnaddloc" value="Add Location and Set Floors" class="btn" />&nbsp;                            
                            <input type="button" name="btnback" value="Back" onClick="parent.location='<?php echo WEB; ?>/locations'" class="redbtn" />
                        </div>
                    </form> 

                    <?php

                    }

                    else {

                    foreach ($location as $key => $value) { ?>
                    <form name="frmbmanage" method="POST" enctype="multipart/form-data">                        
                        <div class="fields">
                            <div class="lfield valigntop">Location Name <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="text" name="loc_name" value="<?php echo $value['loc_name']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Description</div>
                            <div class="rfield valigntop"><input type="text" name="loc_desc" value="<?php echo $value['loc_desc']; ?>" class="txtbox" /></div>
                        </div>
                    
                        <div class="fields">
                            <div class="lfield valigntop">Floors</div>
                            <div class="rfield valigntop">
                                <div class="floordiv">
                                    <table class="tdata" width="100%">
                                        <tr>
                                            <th>Name</th>
                                            <th>Delete</th>
                                        </tr>
                                        <?php foreach ($floor_data as $kf => $vf) : ?>
                                        <tr>
                                            <td>
                                                <span attribute="<?php echo $vf['floor_id']; ?>" class="btneditfloor floortxt<?php echo $vf['floor_id']; ?> floortxt"><?php echo $vf['floor_name']; ?></span>
                                                <input type="text" name="txteditfloor[<?php echo $vf['floor_id']; ?>]" value="<?php echo $vf['floor_name']; ?>" class="txteditfloor txteditfloor<?php echo $vf['floor_id']; ?> txtbox invisible" attribute="<?php echo $vf['floor_id']; ?>" /><span class="editfloortxt editfloortxt<?php echo $vf['floor_id']; ?> nlblock invisible">then press ENTER</span>
                                            </td>
                                            <td class="centertalign"><i attribute="<?php echo $vf['floor_id']; ?>" class="btndelfloor cursorpoint fa fa-times redtext"></i></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td>
                                                <input id="txtaddfloor" type="text" name="txtaddfloor" placeholder="Type floor name then press ENTER" class="txtaddfloor txtbox" />
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="fields centertalign margintop10">                        
                            <input type="submit" name="btneditloc" value="Update" class="btn" />&nbsp;            
                            <input type="button" name="btnback" value="Back" onClick="parent.location='<?php echo WEB; ?>/locations'" class="redbtn" />
                            <input id="loc_id" type="hidden" name="loc_id" value="<?php echo $value['loc_id']; ?>" />
                        </div>
                    </form> 

                    <?php } ?>

                    <?php } ?>

                    <?php

                    break;

                    case "reservation":                    

                    ?>

                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Post a Reservation</div>

                    <?php foreach ($reservation as $key => $value) { ?>

                    <form name="frmrmanage" method="POST" class="smalltext">                        
                        <div class="fields">
                            <div class="lfield valigntop">Reservation Details</div>
                            <div class="rfield valigntop">
                                <b>Event Name:</b> <?php echo $value['reserve_eventname']; ?><br />
                                <b>Room:</b> <?php echo $value['room_name']; ?><br />
                                <b>Check-in:</b> <?php echo date("F j, Y - g:ia", $value['reserve_checkin']); ?><br />
                                <b>Check-out:</b> <?php echo date("F j, Y - g:ia", $value['reserve_checkout']); ?><br />                                
                                <b>Person/s:</b> <?php echo $value['reserve_person']; ?><br />
                                <b>Notes:</b><br /><?php echo $value['reserve_notes']; ?><br />
                                <b>Status:</b> <?php echo $value['reserve_status'] == 1 ? "Pending" : "Approved"; ?>
                            </div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Reserved by</div>
                            <div class="rfield valigntop">
                                <b>Name:</b> <br />
                                <b>Department:</b> <br />
                                <b>Contact #:</b> <br />
                                <b>Email Address:</b> <br />     
                            </div>
                        </div>
                        <div class="fields centertalign margintop10">                        
                            <input type="submit" name="btnreserve" value="Post Reservation" class="btn" />&nbsp;                            
                            <input type="button" name="btnback" value="Cancel" class="redbtn" onClick="parent.location='<?php echo WEB; ?>/reservation'" />
                        </div>
                    </form> 

                    <?php } ?>

                    <?php

                    break;

                    case "reserve":                    

                    ?>

                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">View Reservation</div>

                    <?php foreach ($reservation as $key => $value) { ?>

                    <form name="frmrmanage" method="POST" class="smalltext">                        
                        <div class="fields">
                            <div class="lfield valigntop">Reservation Details</div>
                            <div class="rfield valigntop">
                                <b>Event Name:</b> <?php echo $value['reserve_eventname']; ?><br />
                                <b>Room:</b> <?php echo $value['room_name']; ?><br />
                                <b>Check-in:</b> <?php echo date("F j, Y - g:ia", $value['reserve_checkin']); ?><br />
                                <b>Check-out:</b> <?php echo date("F j, Y - g:ia", $value['reserve_checkout']); ?><br />                                
                                <b>Person/s:</b> <?php echo $value['reserve_person']; ?><br />
                                <b>Notes:</b><br /><?php echo $value['reserve_notes']; ?><br />
                                <b>Status:</b> <?php echo $value['reserve_status'] == 1 ? "Pending" : "Approved"; ?>
                            </div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Reserved by</div>
                            <div class="rfield valigntop">
                                <b>Name:</b> <br />
                                <b>Department:</b> <br />
                                <b>Contact #:</b> <br />
                                <b>Email Address:</b> <br />     
                            </div>
                        </div>
                        <div class="fields centertalign margintop10">      
                            <input type="button" name="btnback" value="Back" class="redbtn" onClick="parent.location='<?php echo WEB; ?>/'" />
                        </div>
                    </form> 

                    <?php } ?>

                    <?php

                    break;
                    case "user":                    

                    ?>

                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12"><?php echo $id == "add" ? "Create" : "Edit"; ?> User</div>

                    <?php 

                    if ($id == "add")
                    {

                    ?>

                    <form name="frmadduser" method="POST" enctype="multipart/form-data">     
                        <div class="fields">
                            <div class="lfield valigntop">Employee ID <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input id="user_empnum" type="text" name="user_empnum" value="<?php echo $_POST['user_empnum']; ?>" class="txtbox" /></div>
                        </div>                                     
                        <div class="fields">
                            <div class="lfield valigntop">Name <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input id="user_fullname" type="text" name="user_fullname" value="<?php echo $_POST['user_fullname']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Level <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <select id="user_level" name="user_level" class="txtbox">
                                    <option value="1"<?php echo $_POST['user_level'] == 1 ? ' selected' : ''; ?>>Requestor</option>
                                    <option value="2"<?php echo $_POST['user_level'] == 2 ? ' selected' : ''; ?>>Approver</option>
                                    <option value="7"<?php echo $_POST['user_level'] == 7 ? ' selected' : ''; ?>>Receptionist</option>
                                    <option value="8"<?php echo $_POST['user_level'] == 8 ? ' selected' : ''; ?>>Report Viewer</option>
                                    <option value="9"<?php echo $_POST['user_level'] == 9 ? ' selected' : ''; ?>>Admin Head</option>
                                </select>
                            </div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Department <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <select id="user_dept" name="user_dept" class="txtbox width300">
                                <?php foreach ($dept as $key => $value) : ?>
                                    <option value="<?php echo $value['dept_id'] ?>"<?php echo $_POST['user_dept'] == $value['dept_id'] ? ' selected' : ''; ?>><?php echo $value['dept_name'] ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div id="tdapp" class="fields">
                            <div class="lfield valigntop">Approver <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <select id="user_approver" name="user_approver" class="txtbox">
                                <?php
                                    $approver_list = $main->get_userapp(0, 0, 0, NULL, 0, $dept[0]['user_dept']);
                                    foreach ($approver_list as $k => $v) : ?>
                                        <option value="<?php echo $v['user_id']; ?>"<?php echo $_POST['user_approver'] == $v['user_id'] ? ' selected' : ''; ?>><?php echo $v['user_fullname']; ?></option>
                                    <?php endforeach; 
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Email Address <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input id="user_email" type="text" name="user_email" value="<?php echo $_POST['user_email']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Contact Number <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input id="user_telno" type="text" name="user_telno" value="<?php echo $_POST['user_telno']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields centertalign margintop10">                        
                            <input type="submit" name="btnadduser" value="Register" class="btn" />
                        </div>
                        <div class="fields margintop10">  
                            <i class="redtext">* required</i>
                        </div>
                    </form> 

                    <?php

                    }

                    else {

                    foreach ($user as $key => $value) { 
                    $approver_list = $main->get_userapp(0, 0, 0, NULL, 0, $value['user_dept']);
                    $approver_data = $main->get_approver($value['user_id']);
                    ?>

                    <form name="frmedituser" method="POST" enctype="multipart/form-data">                                                
                        <div class="fields">
                            <div class="lfield valigntop">Employee ID <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input id="user_empnum" type="text" name="user_empnum" value="<?php echo $value['user_empnum']; ?>" class="txtbox" /></div>
                        </div>                                     
                        <div class="fields">
                            <div class="lfield valigntop">Name <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input id="user_fullname" type="text" name="user_fullname" value="<?php echo $value['user_fullname']; ?>" class="txtbox" /></div>
                        </div>                                     
                        <div class="fields">
                            <div class="lfield valigntop">Level <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <select id="user_level" name="user_level" class="txtbox">
                                    <option value="1"<?php echo $value['user_level'] == 1 ? ' selected' : ''; ?>>Requestor</option>
                                    <option value="2"<?php echo $value['user_level'] == 2 ? ' selected' : ''; ?>>Approver</option>
                                    <option value="7"<?php echo $value['user_level'] == 7 ? ' selected' : ''; ?>>Receptionist</option>
                                    <option value="8"<?php echo $value['user_level'] == 8 ? ' selected' : ''; ?>>Report Viewer</option>
                                    <option value="9"<?php echo $value['user_level'] == 9 ? ' selected' : ''; ?>>Administrator</option>
                                </select>
                            </div>
                        </div>                       
                        <div class="fields">
                            <div class="lfield valigntop">Department <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <select id="user_dept" name="user_dept" class="txtbox">
                                    <?php foreach ($dept as $v) : ?>
                                    <option value="<?php echo $v['dept_id']; ?>"<?php echo $value['user_dept'] == $v['dept_id'] ? ' selected' : ''; ?>><?php echo $v['dept_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div id="tdapp" class="fields">
                            <div class="lfield valigntop">Approver <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <select id="user_approver" name="user_approver" class="txtbox">
                                <?php
                                    foreach ($approver_list as $k => $v) :     
                                        echo '<option value="'.$v['user_id'].'"'.($approver_data[0]['appr_approverid'] == $v['user_id'] ? ' selected' : '').'>'.$v['user_fullname'].'</option>';            
                                    endforeach; 
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Contact Number <span class="redtext">*</span></div>
                            <div class="rfield valigntop">
                                <input id="user_telno" type="text" name="user_telno" value="<?php echo $value['user_telno']; ?>" class="txtbox" />
                            </div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Email Address <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input id="user_email" type="text" name="user_email" value="<?php echo $value['user_email']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields centertalign margintop10">   
                            <input type="hidden" name="user_id" value="<?php echo $value['user_id']; ?>" />                      
                            <input type="submit" name="btnedituser" value="Edit User" class="btn" />&nbsp;                            
                            <input type="button" name="btnback" value="Back" onClick="parent.location='<?php echo WEB; ?>/user'" class="redbtn" />
                        </div>
                        <div class="fields margintop10">  
                            <i class="redtext">* required</i>
                        </div>
                    </form> 

                    <?php } ?>

                    <?php } ?>

                    <?php

                    break;
                    case "profile":                    

                    ?>

                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Change Password</div>

                    <?php 

                    foreach ($user as $key => $value) { ?>

                    <form name="frmeditaccount" method="POST" enctype="multipart/form-data">                                                
                        <!--div class="fields">
                            <div class="lfield valigntop">Name <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="text" name="user_fullname" value="<?php echo $value['user_fullname']; ?>" class="txtbox" /></div>
                        </div>                                     
                        <div class="fields">
                            <div class="lfield valigntop">Department <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="text" name="user_dept" value="<?php echo $value['user_dept']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Contact Number <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="text" name="user_telno" value="<?php echo $value['user_telno']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Email Address <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="text" name="user_email" value="<?php echo $value['user_email']; ?>" class="txtbox" /></div>
                        </div-->
                        
                        <?php if ($profile_level != 8) : ?>
                        
                        <div class="fields">
                            <i>To update your password, please fill up textbox below</i>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Current Password</div>
                            <div class="rfield valigntop"><input type="password" name="user_password0" autocomplete="off" class="txtbox" /></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">New Password</div>
                            <div class="rfield valigntop"><input type="password" name="user_password1" autocomplete="off" class="txtbox" /></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Confirm New Password</div>
                            <div class="rfield valigntop"><input type="password" name="user_password2" class="txtbox" /></div>
                        </div>
                        
                        <?php endif; ?>
                        
                        <div class="fields centertalign margintop10">    
                            <input type="hidden" name="user_id" value="<?php echo $value['user_id']; ?>" />                         
                            <input type="submit" name="btneditprofile" value="Change Password" class="btn" />
                            <button name="btneditprofilecancel" class="redbtn"><a href="<?php echo WEB; ?>" class="whitetext">Back</a></button>
                        </div>
                        
                        <div class="fields margintop10">  
                            <i class="redtext">* required</i>
                        </div>
                    </form> 

                    <?php } ?>

                    <?php

                    break;
                    case "forgot":                    

                    ?>

                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Forgot My Password</div>

                    <form name="frmeditaccount" method="POST" enctype="multipart/form-data">                                                
                        <div class="fields">
                            <div class="lfield valigntop">Email Address <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="text" name="user_email" value="<?php echo $_GET['user_email']; ?>" class="txtbox" /></div>
                        </div>
                        <div class="fields centertalign margintop10">    
                            <input type="submit" name="btnsendpassword" value="Send to My Email" class="btn" />&nbsp;                            
                            <input type="button" name="btnback" value="Cancel" onClick="parent.location='<?php echo WEB; ?>'" class="redbtn" />
                        </div>
                        <div class="fields margintop10">  
                            <i class="redtext">* required</i>
                        </div>
                    </form> 

                    <?php

                    break;
                    case "reset":                    

                    ?>

                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Reset My Password</div>

                    <?php 

                    foreach ($user as $key => $value) { ?>

                    <form name="frmeditaccount" method="POST" enctype="multipart/form-data">                                                
                        <div class="fields">
                            <div class="lfield valigntop">New Password <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="password" name="user_password1" autocomplete="off" class="txtbox" /></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Confirm New Password <span class="redtext">*</span></div>
                            <div class="rfield valigntop"><input type="password" name="user_password2" class="txtbox" /></div>
                        </div>
                        <div class="fields centertalign margintop10">  
                            <input type="hidden" name="user_id" value="<?php echo $value['user_id']; ?>" />   
                            <input type="submit" name="btnresetpassword" value="Reset My Email" class="btn" />
                        </div>
                        <div class="fields margintop10">  
                            <i class="redtext">* required</i>
                        </div>
                    </form> 

                    <?php } ?>

                    <?php

                    break;
                    }

                    ?>

                </div>
            </div>
        </div>
    </div>

    <?php include(TEMP."/footer.php"); ?>