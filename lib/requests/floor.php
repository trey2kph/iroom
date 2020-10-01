<?php 

	include("../../config.php"); 
	//**************** USER MANAGEMENT - START ****************\\

	include(LIB."/login/chklog.php");

	$profile_full = $logfname;
	$profile_name = $logname;
	$profile_id = $userid;
	$profile_level = $level;
	
	//***************** USER MANAGEMENT - END *****************\\

    $sec = $_GET['sec'];

    switch ($sec) {
        case 'add':
            $value['floor_name'] = $_POST['floorname'];
            $value['floor_location'] = $_POST['locid'];
            $value['floor_user'] = $profile_id;
            
            $addfloor = $main->floor_action($value, 'add');
            
            //AUDIT TRAIL
            $log = $main->log_action("ADD_FLOOR", $id, $profile_id);
        break; 
        case 'edit':
            $value['floor_id'] = $_POST['floorid'];
            $value['floor_name'] = $_POST['floorname'];
            $value['floor_user'] = $profile_id;
            
            $editfloor = $main->floor_action($value, 'update');
            
            echo $editfloor;
            //AUDIT TRAIL
            $log = $main->log_action("EDIT_FLOOR", $id, $profile_id);
        break; 
        case 'delete':
            $value['floor_user'] = $profile_id;
            
            $delfloor = $main->floor_action($value, 'delete', $_POST['floorid']);
            //var_dump($delfloor);
            
            //AUDIT TRAIL
            $log = $main->log_action("DELETE_FLOOR", $id, $profile_id);
        break; 
	    default :
            $locid = $_POST['locid'];
            
            $floor_data = $main->get_floors(0, 0, 0, 0, $locid);
            
            ?>
            <script type="text/javascript">
                $(".txtaddfloor").on("keypress", function(e) {
                    if (e.keyCode == 13) {
                        var floorname = $(this).val();
                        var locid = $("#loc_id").val();
                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/floor.php?sec=add",
                            data: "floorname=" + floorname + "&locid=" + locid,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/floor.php",
                                    data: "locid=" + locid,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $(".floordiv").html(data);
                                    }   
                                })
                            }
                        })
                        return false;
                    }
                });

                $(".btneditfloor").on("click", function() {		
                    var floorid = $(this).attr("attribute");	

                    $(".floortxt").removeClass('invisible');
                    $(".floortxt" + floorid).addClass('invisible');
                    $(".txteditfloor").addClass('invisible');
                    $(".txteditfloor" + floorid).removeClass('invisible');   
                    $(".editfloortxt").addClass('invisible');               
                    $(".editfloortxt" + floorid).removeClass('invisible');        

                    return false;
                });

                $(".txteditfloor").blur(function() {		
                    var floorid = $(this).attr("attribute");		

                    $(".floortxt").removeClass('invisible');
                    $(".txteditfloor").addClass('invisible');
                    $(".txteditfloor" + floorid).addClass('invisible');       
                    $(".editfloortxt").addClass('invisible');          

                    return false;
                });

                $(".txteditfloor").on("keypress", function(e) {
                    if (e.keyCode == 13) {
                        var floorid = $(this).attr("attribute");
                        var floorname = $(this).val();
                        var locid = $("#loc_id").val();
                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/floor.php?sec=edit",
                            data: "floorid=" + floorid + "&floorname=" + floorname,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/floor.php",
                                    data: "locid=" + locid,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $(".floordiv").html(data);
                                    }   
                                })
                            }
                        })
                        return false;
                    }
                });

                $(".btndelfloor").on("click", function() {		

                    var r = confirm("Are you sure you want to delete this floor?");
                    floorid = $(this).attr("attribute");
                    locid = $("#loc_id").val();

                    if (r == true)
                    {
                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/floor.php?sec=delete",
                            data: "floorid=" + floorid,
                            type: "POST",
                            success: function(data) {                        
                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/floor.php",
                                    data: "locid=" + locid,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $(".floordiv").html(data);
                                    }   
                                })
                            }
                        })

                        return false;
                    }

                    return false;
                });
            </script>

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
            </table><?php
    }
?>