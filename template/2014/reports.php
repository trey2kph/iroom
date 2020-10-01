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
                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">Reports</div> 
                    Date Coverage&nbsp;<input type="text" name="rep_date_from" id="rep_date_from" class="rep_date_from width100 txtbox" value="<?php echo $post['rep_date_from'] ? $post['rep_date_from'] : date("Y-m-d", strtotime('last month')); ?>" />&nbsp;to&nbsp;<input type="text" name="rep_date_to" id="rep_date_to" class="rep_date_to width100 txtbox" value="<?php echo $post['rep_date_to'] ? $post['rep_date_to'] : date("Y-m-d"); ?>" />
                    <ul class="report_list margintop30">
                        <li><a id="replink1" href="<?php echo WEB; ?>/reservation_report/summary" target="_blank" class="underlined">Reservation Summary</a></li>
                        <li><a id="replink2" href="<?php echo WEB; ?>/reservation_report/list" target="_blank" class="underlined">Reservation List</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include(TEMP."/footer.php"); ?>