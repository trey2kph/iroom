<?php include("../config.php"); ?>[<?php 
				$roomid = $_GET['roomid'] ? $_GET['roomid'] : 0; 

				$reservations = $main->get_reservations(0, 0, 0, 0, 0, $roomid);
				foreach ($reservations as $key => $value) { 
				?><?php if($key != 0) echo ","; ?>{ title: '<?php echo $main->truncate($value['reserve_eventname'], 16); ?>\nEnd: <?php echo date("g:ia", $value['reserve_checkout']); ?>', start: '<?php echo date("Y-m-d H:i:s", $value['reserve_checkin']); ?>', end: '<?php echo date("Y-m-d H:i:s", $value['reserve_checkout']); ?>', url: '<?php echo $value['reserve_id']; ?>', allDay : false,textColor: '#333', editable: false, backgroundColor: '<?php echo $value['room_color']; ?>', borderColor: '<?php echo $value['reserve_status'] == 1 ? $value['room_color'] : "#000"; ?>'}<?php } ?>]