<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $page_title; ?>&nbsp;|&nbsp;<?php echo SITENAME; ?></title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        
        <!-- FAVICON -->
        
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
        
        <!-- VIEWPORT -->
        <meta name="viewport" content="width=1320" />
        
        <!-- CSS STYLES -->
        <link rel="stylesheet" href="<?php echo CSS; ?>/style_iroom.css"> 
        <link rel="stylesheet" href="<?php echo CSS; ?>/lightbox.css">        
        <link rel="stylesheet" href="<?php echo CSS; ?>/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo CSS; ?>/fullcalendar.css">
        <link rel="stylesheet" href="<?php echo CSS; ?>/colorpicker.css">
        <link rel="stylesheet" href="<?php echo CSS; ?>/timepicker.css">
		<link rel="stylesheet" href="<?php echo CSS; ?>/font-awesome.min.css">
        
        <!-- JQUERY -->        
        <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>            
        
    </head>
    <body>  
        
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        
        <div id="floatDiv" class="floatdiv invisible">            

            <!-- CALENDAR VIEW POPUP HERE -->
            <div id="radd" class="radd invisible"> 
                <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                
                <div id="raddinfo" class="raddinfo">
                
                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Reserve A Room</div>
                    
                    <table id="reserve" class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">                        
                        <form id="add_reserve" name="add_reserve" action="?ignore-page-cache=true" method="POST" enctype="multipart/form-data">
                        <tr>
                            <td>Preferred Location <span class="redtext">*</span></td>
                            <td>
                                <select name="reserve_locid" id="reserve_locid" class="reserve_locid select90 width160">       
                                <option value="0">Choose location...</option>    
                                <?php foreach ($locations as $k => $v) { ?>                                 
                                    <?php if ($v['floorcount'] && $v['roomcount']) { ?>
                                        <option value="<?php echo $v['loc_id']; ?>"<?php if ($_POST['reserve_locid'] == $v['loc_id']) echo ' selected="selected"'; ?>><?php echo $v['loc_name']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Preferred Floor <span class="redtext">*</span></td>
                            <td class="floordiv">
                                <select name="reserve_floorid" class="reserve_floorid select90 width160">
                                    <?php if ($_POST['reserve_floorid']) {
                                        $locid = $_POST['reserve_locid'];

                                        $floors = $main->get_floors_dropdown($locid);

                                        $sel = '';
                                        if ($floors) {   
                                            foreach ($floors as $k => $v) {
                                                if ($v['roomcount']) {
                                                    $sel .= '<option value="'.$v['floor_id'].'"'.($_POST['reserve_floorid'] == $v['floor_id'] ? ' selected="selected"' : '').'>'.$v['floor_name'].'</option>';
                                                }
                                            }   
                                        }
                                        else
                                        {
                                            $sel .= 'No floor from this location';
                                        }

                                        echo $sel;   
                                    } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Event Name <span class="redtext">*</span></td>
                            <td><input type="text" name="reserve_eventname" class="txtbox width300" value="<?php echo $_POST['reserve_eventname']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Date <span class="redtext">*</span></td>
                            <td>
                                <input type="text" name="reserve_datein" class="txtbox checkindate width135" value="<?php echo $_POST['reserve_datein'] ? $_POST['reserve_datein'] : date("Y-m-d"); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Time <span class="redtext">*</span></td>
                            <td>
                                <input type="text" name="reserve_timein" class="txtbox timein width95" value="<?php echo $_POST['reserve_timein'] ? $_POST['reserve_timein'] : '8:30am'; ?>" /> to
                                <input type="text" name="reserve_timeout" class="txtbox timein width95" value="<?php echo $_POST['reserve_timeout'] ? $_POST['reserve_timeout'] : '5:30pm'; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Person/s <span class="redtext">*</span></td>
                            <td>
                                <select name="reserve_person" class="reserve_person">       
                                <?php for($i = 2; $i <= 9; $i++) { ?>                                 
                                    <option value="<?php echo $i; ?>"<?php if ($_POST['reserve_person'] == $i) echo ' selected="selected"'; ?>><?php echo $i; ?></option>
                                <?php } ?>
                                <option value="10"<?php if ($_POST['reserve_person'] == 10) echo ' selected="selected"'; ?>>10 or more</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Name of Participants</td>
                            <td><textarea name="reserve_participant" rows="3" class="txtarea width300"></textarea><br /><i>* multiple separated by comma</i></td>
                        </tr>
                        <tr>
                            <td>Purpose</td>
                            <td><input type="text" name="reserve_purpose" class="txtbox width300" /></td>
                        </tr>
                        <tr>
                            <td>Notes</td>
                            <td><input type="text" name="reserve_notes" class="txtbox width300" /></td>
                        </tr>
                        <tr>
                            <td>E-mail Invites</td>
                            <td><input type="text" name="reserve_emails" class="txtbox width300" /><br /><i>* multiple separated by comma</i></td>
                        </tr>
                        <tr>
                            <td>Reserve by</td>
                            <td><b><?php echo $profile_name; ?></b><input type="hidden" name="reserve_user" value="<?php echo $profile_id; ?>" /><input type="hidden" name="user_fullname" value="<?php echo $profile_full; ?>" /><input type="hidden" name="user_email" value="<?php echo $profile_email; ?>" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><button name="btnresroom" value="1" class="btn">Reserve</button></td>
                        </tr><tr>
                            <td colspan="2"><i class="redtext">* required</i></td>
                        </tr>
                        </form>
                    </table>
                    
                </div>
                
            </div>
            
            <!-- CALENDAR VIEW POPUP HERE -->
            <div id="rcal" class="rcal invisible"> 
                <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                <div id="rcalinfo" class="rcalinfo"></div>
            </div>

            <!-- CALENDAR POST POPUP HERE -->
            <div id="rpost" class="rpost invisible"> 
                <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                <div id="rpostinfo" class="rpostinfo"></div>
                <div class="fields centertalign margintop10">   
                    <input type="hidden" id="postEvId" value="0">   
                    <input type="button" name="btnback" id="postEvent" value="Yes" class="btn" />
                </div>                    
            </div>

            <!-- CALENDAR EDIT POPUP HERE -->
            <div id="redit" class="redit invisible"> 
                <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                <div id="reditinfo" class="reditinfo"></div>
                <div class="fields centertalign margintop10">   
                    <input type="hidden" id="editEvId" value="0">   
                    <input type="button" name="btnback" id="editEvent" value="Update" class="btn" />
                </div>                    
            </div>

            <!-- CALENDAR EDIT SUCCESS POPUP HERE -->
            <div id="rcon" class="rcon invisible"> 
                <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                <div id="rconinfo" class="rconinfo"></div>
            </div>

            <!-- CALENDAR DELETE POPUP HERE -->
            <div id="rdel" class="rdel invisible"> 
                <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                <div id="rdelinfo" class="rdelinfo"></div>
                <div class="fields centertalign margintop10">   
                    <input type="hidden" id="delEvId" value="0">   
                    <input type="button" name="btnback" id="delEvent" value="Yes" class="btn" />
                </div>                    
            </div>

            <!-- CALENDAR APPROVE POPUP HERE -->
            <div id="rapp" class="rapp invisible"> 
                <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                <div id="rappinfo" class="rappinfo"></div>
                <div class="fields centertalign margintop10">   
                    <input type="hidden" id="appEvId" value="0">   
                    <input type="button" name="btnback" id="appEvent" value="Yes" class="btn" />
                </div>                    
            </div>

            <!-- CALENDAR ADMIN APPROVE POPUP HERE -->
            <div id="raapp" class="raapp invisible"> 
                <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                <div id="raappinfo" class="raappinfo"></div>
                <div class="fields centertalign margintop10">   
                    <input type="hidden" id="aappEvId" value="0">   
                    <input type="button" name="btnback" id="aappEvent" value="Yes" class="btn" />
                </div>                    
            </div>

            <!-- CALENDAR REJECT POPUP HERE -->
            <div id="rrej" class="rrej invisible"> 
                <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                <div id="rrejinfo" class="rrejinfo"></div>
                <div class="fields centertalign margintop10">   
                    <input type="hidden" id="rejEvId" value="0">   
                    <input type="button" name="btnback" id="rejEvent" value="Yes" class="btn" />
                </div>                    
            </div>
            
        </div>
        
        
		<div id="main" class="main">
        	
          
          <div id="upper" class="upper">
            <div class="wrapper">       
            	<div id="maincontainer" class="maincontainer clearfix whitebg">            
                  <div id="header" class="header">   
                    <img src="<?php echo IMG_WEB; ?>/mwlogo3.png" />
                  </div>     
                  <div id="loginheader" class="loginheader">&nbsp;</div>     
                </div>
            </div>				        
          </div>
          
          <div id="middle" class="middle">
        	<div class="wrapper">
            <div id="maincontainer" class="maincontainer clearfix">                  
                <div id="loginbox" class="logcontainer dwhitebg righttalign">
                    <?php if ($logged == 1) { ?>
                    <div class="logbox">
                        <b>Howdy <?php echo $profile_full; ?>!</b> | <a href="<?php echo WEB; ?>/profile" class="dgraytext underlined">Change Password</a> | <a href="<?php echo WEB; ?>/logout" class="dgraytext underlined">Logout</a>
                    </div>
                    <?php } ?>
                </div>          