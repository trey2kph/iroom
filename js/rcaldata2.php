<?php include("../config.php"); ?><?php 
				$roomid = $_GET['roomid'] ? $_GET['roomid'] : 0; 

				$reservations = $main->get_calres($roomid);

				$return_array = array();
        		$event_array;

				foreach ($reservations as $key => $value) { 

		            $event_array = array();

		            $event_array['id'] = $value['reserve_id'];
		            $event_array['title'] = $main->truncate($value['reserve_eventname'], 16)."\n".$value['room_name'];
		            $event_array['start'] = date("Y-m-d H:i:s", strtotime($value['reserve_checkin']));
		            $event_array['end'] = date("Y-m-d H:i:s", strtotime($value['reserve_checkout']));
		            $event_array['allDay'] = false;
		            $event_array['textColor'] = '#333';
		            $event_array['editable'] = false;
		            $event_array['backgroundColor'] = $value['room_color'] ? $value['room_color'] : "#FFF";
		            $event_array['borderColor'] = $value['room_color'] ? $value['room_color'] : "#000";
                    $rgb = $main->HTMLToRGB($value['room_color']);
                    $hsl = $main->RGBToHSL($rgb);
                    if ($value['reserve_status'] <= 2 || $value['reserve_status'] == 6 || $value['reserve_status'] == 7) : 
                        $dark = 0;
                    else :
                        if($hsl->lightness > 165) :
                            $dark = 0;
                        else :
                            $dark = 1;
                        endif;
                    endif;
		            $event_array['textColor'] = $dark ? "#EEE" : "#222";
                    $event_array['dark'] = $dark;

		            array_push($return_array, $event_array);
		        }

			    echo json_encode($return_array);