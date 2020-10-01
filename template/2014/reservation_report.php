<style type="text/css">
    .doc
    {
        width: 85%;
        padding: 50px;
    }
    .title
    {
        font-weight: bold;
        font-size: 20px;        
    }
    .subtitle
    {
        font-weight: bold;
        font-size: 16px; 
        padding: 5px;
    }
    .tdata 
    {
        width: 100% !important;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
    }
    .tdata th
    {
        color: #FFF;
        background-color: #333;
    }
    .tdata td, .tdata th
    {
        padding: 5px;
    }
</style>
<page style="font-size: 14px">
    <div class="doc">
        <span class="title">Reservation Report</span>
        <hr /><br />
        <?php if ($part == 'summary') { ?>
        <table border="1" bordercolor="white" style="width: 90%;">
            <tr>
                <td style="width: 50%;">            
                    <div class="subtitle">Department with Most Reservation</div>
                    <table class="tdata" border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tr>
                            <th style="width: 150px;  height: 2px;">Department</th>
                            <th style="width: 80px;  height: 2px;">Reservations</th>
                        </tr>
                        <?php if ($rescount_dept) { ?>
                        <?php foreach ($rescount_dept as $key => $value) { ?>
                        <?php $dept_info = $main->get_dept($value['user_dept']); ?>
                        <tr>
                            <td style="width: 150px; height: 2px;"><?php echo $dept_info[0]['dept_name']; ?></td>
                            <td style="width: 80px; height: 2px;"><?php echo $value['rescount']; ?></td>                            
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="2" align="center" class="whitebg">No reservation has been made</td>
                        </tr>
                        <?php } ?>
                    </table>
                </td>
                <td style="width: 50%;">            
                    <div class="subtitle">Room with Most Reservation</div>
                    <table class="tdata" border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tr>
                            <th style="width: 220px;  height: 2px;">Room</th>
                            <th style="width: 80px;  height: 2px;">Reservations</th>
                        </tr>
                        <?php if ($rescount_room) { ?>
                        <?php foreach ($rescount_room as $key => $value) { ?>
                        <tr>
                            <td style="width: 220px;  height: 2px;"><?php echo $value['room_name']; ?></td>
                            <td style="width: 80px;  height: 2px;"><?php echo $value['rescount']; ?></td>                          
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="2" align="center" class="whitebg">No reservation has been made</td>
                        </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
        </table>
        <?php } else { ?>
        <div class="subtitle">Reservation List</div>
        <table class="tdata" border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
            <tr>
                <th style="width: 100px;  height: 2px;">Reservation ID</th>
                <th style="width: 200px;  height: 2px;">Event Name</th>                            
                <th style="width: 120px;  height: 2px;">Room</th>
                <th style="width: 120px;  height: 2px;">Duration</th>
                <th style="width: 80px;  height: 2px;">Status</th>
                <th style="width: 150px;  height: 2px;">Reserved by</th>
            </tr>
            <?php if ($reservation) { ?>
            <?php foreach ($reservation as $key => $value) { ?>
            <?php $dept_info = $main->get_dept($value['user_dept']); ?>
            <tr>
                <td style="width: 100px;  height: 2px;"><?php echo $value['reserve_id']; ?></td>
                <td style="width: 200px;  height: 2px;"><?php echo $value['reserve_eventname']; ?></td>                            
                <td style="width: 120px;  height: 2px;"><?php echo $value['room_name']; ?></td>
                <td style="width: 120px;  height: 2px;"><?php echo date("M j g:ia", strtotime($value['reserve_checkin'])); ?> to <?php echo date("g:ia", strtotime($value['reserve_checkout'])); ?></td>
                <td style="width: 80px;  height: 2px;"><?php echo $main->get_reservestatus2($value['reserve_status']); ?></td>
                <td style="width: 150px;  height: 2px;"><?php echo $value['user_fullname']; ?> (<?php echo $dept_info[0]['dept_name']; ?>)</td>                            
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
                <td colspan="5" align="center" class="whitebg">No reservation has been made</td>
            </tr>
            <?php } ?>
        </table>
        <?php } ?>
    </div>
</page>