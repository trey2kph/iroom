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
                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">User Management</div>
                    <a name="restable"></a>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><form action="<?php echo WEB."/user"; ?>" method="POST" enctype="multipart/form-data">Search User&nbsp;<input type="text" name="searchuser" placeholder="by name..." class="txtbox" />&nbsp;<input type="submit" name="btnusersearch" value="Search" class="btn" /></form></td>
                            <td align="right"><input type="button" name="btnadduser" value="Add User" onClick="parent.location='<?php echo WEB; ?>/user/add'" class="btn" /></td>                            
                        </tr>
                        <?php if ($searchuser) { ?>
                        <tr>
                            <td>Your search result for &quot;<b><?php echo $searchuser; ?></b>&quot;</td>
                        </tr>
                        <?php } ?>
                    </table>
                    <table class="tdata" width="100%">
                        <tr>
                            <th width="5%">User ID</td>
                            <th width="25%">Name</td>                            
                            <th width="20%">Department</td>                                
                            <th width="20%">Email Address</td>                             
                            <th width="10%">Status</td>                                
                            <th width="20%" colspan="3">Manage</td>
                        </tr>
                        <?php if ($users) { ?>
                        <?php foreach ($users as $key => $value) { ?>
                        <?php $dept_data = $main->get_dept($value['user_dept']); ?>
                        <tr>
                            <td><?php echo $value['user_id']; ?></td>
                            <td><?php echo $value['user_fullname']; ?></td>
                            <td><?php echo $dept_data[0]['dept_name']; ?></td>                            
                            <td><?php echo $value['user_email']; ?></td>
                            <td align="center" class="ustatusDiv<?php echo $value['user_id']; ?>"><a class="approveUser cursorpoint" attribute="<?php echo $value['user_id']; ?>" attribute2="<?php echo $value['user_status']; ?>"><?php echo $value['user_status'] == 1 ? '<i class="fa fa-lock fa-lg redtext"></i>' : '<i class="fa fa-unlock-alt fa-lg greentext"></i>'; ?></a></td>
                            <td align="center"><a title="Send Password" class="pwordUser cursorpoint" attribute="<?php echo $value['user_id']; ?>" attribute2="<?php echo $value['user_email']; ?>"><i class="fa fa-key fa-lg"></i></a></td>
                            <td align="center"><a title="Edit User" href="<?php echo WEB; ?>/user/<?php echo $value['user_id']; ?>"><i class="fa fa-edit fa-lg"></i></a></td>                
                            <td align="center"><a title="Delete User" class="delUser cursorpoint" attribute="<?php echo $value['user_id']; ?>"><i class="fa fa-trash-o fa-lg redtext"></i></a></td>
                        </tr>
                        <?php } ?>
                        <?php if ($pages) { ?>
                        <tr>
                            <td colspan="7" align="center" class="whitebg"><?php echo $pages; ?></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="7" align="center">No user found</td>
                        </tr>
                        <?php } ?>
                    </table>
                    <!--i>Note: Click on user's status to change</i-->
                </div>
            </div>
        </div>
    </div>

    <?php include(TEMP."/footer.php"); ?>