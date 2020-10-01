	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
    
    <div id="subcontainer" class="subcontainer">        
        <div id="lowersub" class="lowersub tbpadding10 dwhitebg">
            <div id="ltitle" class="lowerlist robotobold cattext dbluetext centertalign">Welcome to <?php echo SYSTEMNAME; ?></div>
            <div id="lowerlist" class="lowerlist minheight150">
                <div class="lowerlogin">
                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">&nbsp;</div>
                    <div id="frmlogin">
                    <table class="margintop15 centertalign vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td id="errortd"></td>
                        </tr>
                        <tr>
                            <td><div class="curvebox centermargin"><input type="text" id="username" name="username" autocomplete="off" placeholder="Username" /></div></td>
                        </tr>
                        <tr>
                            <td><div class="curvebox centermargin"><input type="password" id="password" name="password" autocomplete="off" placeholder="Password" /></div></td>
                        </tr>
                        <tr>                            
                            <td><input type="submit" name="btnlogin" id="btnlogin" value="LOGIN" class="bigbtn" /></td>
                        </tr>
                        <tr>                            
                            <td><a href ="<?php echo WEB; ?>/forgot">Cannot Access?</a> | <a href="<?php echo WEB; ?>/user/add">Register</a></td>
                        </tr>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include(TEMP."/footer.php"); ?>