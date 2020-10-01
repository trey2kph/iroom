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
                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Logbook</div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <form action="<?php echo WEB."/logs"; ?>" method="POST" enctype="multipart/form-data">
                                    Search Log&nbsp;<input type="text" name="searchlogs" id="searchlogs" value="<?php echo $searchlog; ?>" placeholder="by ID..." class="txtbox width75" />                                    
                                    <select name="userlogs" id="userlogs" class="width95">
                                        <option value="0">Select user...</option>
                                        <?php $users = $main->get_users(0, 0, 0, 0, 0, 0, 0); ?>
                                        <?php foreach($users as $value) { ?>
                                            <option value="<?php echo $value['user_id']; ?>" <?php echo $_POST['userlogs'] == $value['user_id'] ? "selected" : ""; ?>><?php echo $value['user_fullname']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php
                                        $taskarray = array('0'=>'All Task', 'LOGIN'=>'Login', 'LOGOUT'=>'Logout', 'RESERVE_ROOM'=>'Reserve Room', 'EDIT_RESERVATION'=>'Edit Reservation', 'DELETE_RESERVATION'=>'Delete Reservation', 'APPROVE_RESERVATION'=>'Approved Reservation', 'ADD_ROOM'=>'Add Room', 'UPDATE_ROOM'=>'Update Room', 'DELETE_ROOM'=>'Delete Room', 'ADD_LOCATION'=>'Add Location', 'UPDATE_LOCATION'=>'Update Location', 'DELETE_LOCATION'=>'Delete Location', 'REGISTER_USER'=>'Register User', 'ADD_USER'=>'Add User', 'UPDATE_USER'=>'Update User', 'DELETE_USER'=>'Delete User', 'APPROVE_USER'=>'Approved User', 'DISAPPROVE_USER'=>'Disapproved User', 'UPDATE_PROFILE'=>'Update Profile', 'EDIT_PASSWORD'=>'Edit Passowrd');
                                    ?>
                                    <select name="tasklogs" id="tasklogs" class="width95">
                                        <?php foreach($taskarray as $id => $value) { ?>
                                            <option value="<?php echo $id; ?>" <?php echo $_POST['tasklogs'] === $id ? "selected" : ""; ?>><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                    From&nbsp;<input type="text" name="fromlogs" id="fromlogs" class="txtbox fromlogs width75" value="<?php echo $_POST['fromlogs'] ? $_POST['fromlogs'] : '2014-01-01'; ?>" />&nbsp;To&nbsp;<input type="text" name="tologs" id="tologs" class="txtbox tologs width75" value="<?php echo $_POST['tologs'] ? $_POST['tologs'] : date("Y-m-d"); ?>" />&nbsp;<input type="submit" name="btnlogsearch" value="Search" class="btn" />
                                </form>
                            </td>
                        </tr>
                        <?php if ($searchlog) { ?>
                        <tr>
                            <td>Your search result for &quot;<b><?php echo $searchlog; ?></b>&quot;</td>
                        </tr>
                        <?php } ?>
                    </table>
                    <table class="tdata" width="100%">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%">User</th>
                            <th width="20%">Task Code</th>
                            <th width="30%">Data</th>
                            <th width="25%">Date</th>
                        </tr>
                        <?php if ($logs) { ?>
                        <?php foreach ($logs as $key => $value) { ?>
                        <tr>
                            <td><?php echo $value['logs_id']; ?></td>
                            <td><?php echo $value['user_fullname']; ?></td>
                            <td><?php echo $value['logs_task']; ?></td>
                            <td><?php echo $value['logs_data'] == 0 ? 'n/a' : $main->get_data_from_logs($value['logs_data'], $value['logs_task']); ?></td>
                            <td><?php echo date("M j, Y | g:ia", $value['logs_date']); ?></td>
                        </tr>
                        <?php } ?>
                        <?php if ($pages) { ?>
                        <tr>
                            <td colspan="5" align="center" class="whitebg"><?php echo $pages; ?></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="5" align="center">No logs found</td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include(TEMP."/footer.php"); ?>