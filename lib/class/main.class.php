<?php

class main {
    
    public function db_connect() //connect to database
	{
        $result = mssql_connect(DBHOST, DBUSER, DBPASS);
        if(!$result) return false;
        else return $result;
	}  
    public function db_select($con) //connect to database
	{
        $result = mssql_select_db(DBNAME, $con);
        if(!$result) return false;
        else return $result;
	}  
    
	private function db_result_to_array($query) //Transform query results into array
	{
        if(!$query) return false;
        $res_array = array();
        for($count = 0; $row = mssql_fetch_array($query, MSSQL_ASSOC); $count++) :
            $res_array[$count] = $row;								
		endfor;
        
        return $res_array;
	}
	private function db_result_to_num($query) //Transform query results into array
	{
        if(!$query) return false;
        $row_cnt = mssql_num_rows($query);
        return $row_cnt;
	}
    
	public function get_row($sql)
	{
        if(!$sql) return;
        $con = $this->db_connect();
        $seltab = $this->db_select($con);
        $result = mssql_query($sql);
        if(!$result) return;
        $result = $this->db_result_to_array($result);
        return $result;
	}
	
	public function get_numrow($sql) //Get num rows of a table from $sql
	{
        if(!$sql) return;
        $con = $this->db_connect();
        $seltab = $this->db_select($con);
        $result = mssql_query($sql);
        if(!$result) return;
        $result = $this->db_result_to_num($result);
        return $result;
	}
    
    public function get_execute($sql) //Get num rows of a table from $sql
	{
        if(!$sql) return;
        $con = $this->db_connect();
        $seltab = $this->db_select($con);
        $result = mssql_query($sql);
        if(!$result) return;
        return $result;
	}
    
    function get_sp_data_status($sp_name, $parameters = NULL)
	{        
        // TYPE:
        // 1 - array
        // 2 - num_row
        
        $status = 0;
        $con = $this->db_connect();
        
        $stmt = mssql_init(DBNAME.'.dbo.'.$sp_name, $con);
        
        if ($parameters) :
            foreach ($parameters as $key => $value) :
                //var_dump($value);
                mssql_bind($stmt, '@'.$value['field_name'], $value['field_value'], $value['field_type'], $value['field_isoutput'], $value['field_isnull'], $value['field_maxlen']);
            endforeach;
        endif;
        
        //$status = 0;
        mssql_bind($stmt, '@STATUS', $status, SQLVARCHAR, true);

        $query = mssql_execute($stmt);
        
        $result = $status;
        
		return $result;
	}		
    
    function get_sp_data($sp_name, $parameters = NULL)
	{        
        // TYPE:
        // 1 - array
        // 2 - num_row
        
        $status = 0;
        $con = $this->db_connect();
        
        $stmt = mssql_init(DBNAME.'.dbo.'.$sp_name, $con);
        
        if ($parameters) :
            foreach ($parameters as $key => $value) :
                //var_dump($value);
                mssql_bind($stmt, '@'.$value['field_name'], $value['field_value'], $value['field_type'], $value['field_isoutput'], $value['field_isnull'], $value['field_maxlen']);
            endforeach;
        endif;

        $query = mssql_execute($stmt);
        
        $result = $query;
        
		return $result;
	}		
	
	# MAIN CLASS
	
	function get_reservations($id = 0, $start = 0, $limit = 0, $not_all = 0, $user = 0, $room = 0, $search = NULL, $count = 0, $sort = 0, $from = 0, $to = 0, $approver = 0)
	{
        $logfrom = $from." 00:00:00";
        $logto = $to." 23:59:59";
        
        $sql="SELECT [outer].* FROM ( ";
        if ($sort != 0) :
            $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY r.reserve_checkin ASC) as ROW_NUMBER, ";
        else :
            $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY r.reserve_checkin DESC) as ROW_NUMBER, ";
        endif;
		$sql.=" r.reserve_id, r.reserve_eventname, ro.room_name, ro.room_color, f.floor_id, f.floor_name, r.reserve_checkin, r.reserve_roomid, r.reserve_checkout, r.reserve_user, u.user_empnum, u.user_fullname, u.user_dept, u.user_telno, u.user_email, 
			r.reserve_person, r.reserve_participant, r.reserve_purpose, r.reserve_notes, r.reserve_status, GETDATE() AS now, CASE WHEN r.reserve_checkin < GETDATE() AND r.reserve_checkout > GETDATE() THEN 1 ELSE 0 END AS ifnow ";
		$sql.=" FROM tbl_reservation r ";
        $sql.=" LEFT JOIN tbl_floor AS f ON f.floor_id = r.reserve_floorid
            LEFT JOIN tbl_room AS ro ON ro.room_id = r.reserve_roomid AND ro.room_status = 2
            LEFT JOIN tbl_user AS u ON u.user_id = r.reserve_user";
		$sql.=" WHERE r.reserve_status > 0";
		if ($search != NULL) $sql.=" AND r.reserve_eventname LIKE '%".$search."%'";
        if ($approver != 0) : $sql .= " AND reserve_user IN (SELECT appr_userid FROM tbl_approver WHERE appr_approverid = ".$approver.") "; endif;     
		if ($user != 0) $sql.=" AND r.reserve_user = ".$user;
		if ($room != 0) $sql.=" AND r.reserve_roomid = ".$room;
		if ($not_all != 0) $sql.=" AND r.reserve_checkout >= GETDATE()";
		if ($id != 0) $sql.=" AND r.reserve_id = ".$id;
        if ($from && $to) $sql .= " AND r.reserve_date BETWEEN '".$logfrom."' AND '".$logto."' ";
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
	
	function get_calres($room = 0)
	{
        $logfrom = $from." 00:00:00";
        $logto = $to." 23:59:59";
        
        $sql="SELECT [outer].* FROM ( ";
        if ($sort != 0) :
            $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY r.reserve_checkin ASC) as ROW_NUMBER, ";
        else :
            $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY r.reserve_checkin DESC) as ROW_NUMBER, ";
        endif;
		$sql.=" r.reserve_id, r.reserve_eventname, ro.room_name, ro.room_color, f.floor_id, f.floor_name, r.reserve_checkin, r.reserve_roomid, r.reserve_checkout, r.reserve_user, u.user_empnum, u.user_fullname, u.user_dept, u.user_telno, u.user_email, 
			r.reserve_person, r.reserve_participant, r.reserve_purpose, r.reserve_notes, r.reserve_status, GETDATE() AS now, CASE WHEN r.reserve_checkin < GETDATE() AND r.reserve_checkout > GETDATE() THEN 1 ELSE 0 END AS ifnow ";
		$sql.=" FROM tbl_reservation r ";
        $sql.=" LEFT JOIN tbl_floor AS f ON f.floor_id = r.reserve_floorid
            LEFT JOIN tbl_room AS ro ON ro.room_id = r.reserve_roomid AND ro.room_status = 2
            LEFT JOIN tbl_user AS u ON u.user_id = r.reserve_user";
		$sql.=" WHERE r.reserve_status > 0 AND r.reserve_status <> 7";
		if ($room != 0) $sql.=" AND r.reserve_roomid = ".$room;
        $sql .= ") AS [outer] ";

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
    
    function get_all_reservations($id = 0, $start = 0, $limit = 0, $not_all = 0, $user = 0, $room = 0, $search = NULL, $count = 0, $sort = 0, $from = 0, $to = 0)
	{
        $logfrom = strtotime($from." 00:00:00");
        $logto = strtotime($to." 23:59:59");
        
        $sql="SELECT [outer].* FROM ( ";
        if ($sort != 0) :
            $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY r.reserve_checkin ASC) as ROW_NUMBER, ";
        else :
            $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY r.reserve_checkin DESC) as ROW_NUMBER, ";
        endif;
		$sql.=" r.reserve_id, r.reserve_eventname, ro.room_name, ro.room_color, f.floor_id, f.floor_name, r.reserve_checkin, r.reserve_roomid, r.reserve_checkout, r.reserve_user, u.user_empnum, u.user_fullname, u.user_dept, u.user_telno, u.user_email, 
			r.reserve_person, r.reserve_participant, r.reserve_purpose, r.reserve_notes, r.reserve_status, GETDATE() AS now, CASE WHEN r.reserve_checkin < GETDATE() AND r.reserve_checkout > GETDATE() THEN 1 ELSE 0 END AS ifnow ";
		$sql.=" FROM tbl_reservation r ";
        $sql.=" LEFT JOIN tbl_room AS ro ON ro.room_id = r.reserve_roomid AND ro.room_status = 2
            LEFT JOIN tbl_user AS u ON u.user_id = r.reserve_user
			WHERE r.reserve_status >= 0";
		if ($search != NULL) $sql.=" AND r.reserve_eventname LIKE '%".$search."%'";
		if ($user != 0) $sql.=" AND r.reserve_user = ".$user;
		if ($room != 0) $sql.=" AND r.reserve_roomid = ".$room;
		if ($not_all != 0) $sql.=" AND r.reserve_checkout >= GETDATE()";
		if ($id != 0) $sql.=" AND r.reserve_id = ".$id;
        if ($from && $to) $sql .= " AND r.reserve_date BETWEEN ".$logfrom." AND ".$logto." ";
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
    
    function get_reservedata($id)
	{        
		$sql="SELECT r.reserve_id, r.reserve_eventname, r.reserve_checkin, 
			r.reserve_roomid, r.reserve_checkout, r.reserve_user, r.reserve_emails,
			r.reserve_person, r.reserve_participant, r.reserve_purpose, r.reserve_notes, r.reserve_status ";
		$sql.=" FROM tbl_reservation r
			WHERE r.reserve_status >= 1";
		$sql.=" AND r.reserve_id = ".$id;
		$sql.=" LIMIT 0, 1";	

		$result = $this->get_row($sql);			
			
		return $result;
	}
    
    function get_reservestatus($type, $level = 1, $attr = NULL)
    {
        switch($type) {
            case 0: echo 'Deleted'; break;
            case 1: 
                if ($level == 1) : echo "For approval"; 
                elseif ($level == 2) : echo "For your approval"; 
                else : echo "For approval"; 
                endif;
            break;            
            case 2: 
                if ($level == 1) : echo "For admin's approval"; 
                elseif ($level == 2) : echo "Approved by you"; 
                else : echo "For your approval"; 
                endif;
            break;          
            case 6: echo "WAITING LIST"; break;                          
            case 7: echo "REJECTED"; break;                 
            case 9: echo "APPROVED"; break;
            case 10: echo "CLOSED"; break;
        }
    }
    
    
    
    function get_reservestatus2($type)
    {
        switch($type) {
            case 0: echo 'Deleted'; break;
            case 1: echo "For approval"; break;            
            case 2: echo "For admin's approval"; break;            
            case 6: echo "WAITING LIST"; break;                          
            case 7: echo "REJECTED"; break;                 
            case 9: echo "APPROVED"; break;
            case 10: echo "CLOSED"; break;
        }
    }
    
	function get_rescount_dept($from = 0, $to = 0)
	{
        $logfrom = $from." 00:00:00";
        $logto = $to." 23:59:59";
        
		$sql="SELECT COUNT(r.reserve_id) AS rescount, u.user_dept ";
		$sql.=" FROM tbl_reservation r, tbl_user u
			WHERE u.user_id = r.reserve_user
			AND r.reserve_status = 9 ";
        if ($from && $to) $sql .= " AND r.reserve_date BETWEEN '".$logfrom."' AND '".$logto."' ";
        $sql.=" GROUP BY u.user_dept ";
		$sql.=" ORDER BY rescount DESC ";

		$result = $this->get_row($sql);			
			
		return $result;
	}
    
	function get_rescount_room($from = 0, $to = 0)
	{
        $logfrom = $from." 00:00:00";
        $logto = $to." 23:59:59";
        
		$sql="SELECT COUNT(r.reserve_id) AS rescount, ro.room_name";
		$sql.=" FROM tbl_reservation r, tbl_room ro
			WHERE ro.room_id = r.reserve_roomid
			AND r.reserve_status = 9";
        if ($from && $to) $sql .= " AND r.reserve_date BETWEEN '".$logfrom."' AND '".$logto."' ";
        $sql.=" GROUP BY ro.room_id, ro.room_name ";
		$sql.=" ORDER BY rescount DESC ";
		
        $result = $this->get_row($sql);			
			
		return $result;
	}
	
	function get_rooms($id = 0, $start = 0, $limit = 0, $search = NULL, $count = 0, $status = 0, $location = 0, $floor = 0)
	{
        $sql="SELECT [outer].* FROM ( ";
        $sql.=" SELECT ROW_NUMBER() OVER(ORDER BY ro.room_locid DESC) as ROW_NUMBER, ";
		$sql.=" ro.room_id, ro.room_name, ro.room_color, ro.room_locid, ro.room_floorid, ro.room_desc, ro.room_img, ro.room_capacity, ro.room_type, ro.room_status, l.loc_name, f.floor_name ";
		$sql.=" FROM tbl_room ro
            LEFT JOIN tbl_location l ON l.loc_id = ro.room_locid
            LEFT JOIN tbl_floor f ON f.floor_id = ro.room_floorid";
		if ($status != 0) : 
            if ($status == 500) :
                $sql .= " WHERE ro.room_status >= 1 ";
            else :
                $sql .= " WHERE ro.room_status = ".$status;
            endif;
        else : 
            $sql .= " WHERE ro.room_status >= 2 ";
        endif;    
		if ($search != NULL) $sql.=" AND ro.room_name LIKE '%".$search."%'";
		if ($id != 0) $sql.=" AND ro.room_id = ".$id;		
        if ($location != 0) $sql.=" AND ro.room_locid = ".$location;		
        if ($floor != 0) $sql.=" AND ro.room_floorid = ".$floor;		
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
	
	function get_rooms_by_loc($locid, $count = 0)
	{
		$sql="SELECT ro.room_id, ro.room_name, ro.room_color, ro.room_locid, ro.room_desc, ro.room_img, ro.room_capacity, ro.room_type";
		$sql.=" FROM tbl_room ro
			WHERE ro.room_locid = ".$locid."
			AND ro.room_status = 2 
			ORDER BY ro.room_date DESC";

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
    
    function get_rooms_dropdown($locid = 0, $floorid = 0, $count = 0)
	{
		$sql="SELECT ro.room_id, ro.room_name, ro.room_color, ro.room_locid, ro.room_desc, ro.room_img, ro.room_capacity, ro.room_type";
		$sql.=" FROM tbl_room ro
            WHERE ro.room_status = 2 ";
        if ($locid != 0) $sql.=" AND ro.room_locid = ".$locid;
		if ($floorid != 0) $sql.=" AND ro.room_floorid = ".$floorid;
		$sql.="  ORDER BY ro.room_date DESC";

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
	
	function get_locations($id = 0, $start = 0, $limit = 0, $count = 0, $status = 0, $floorcnt = 0)
	{
        $sql="SELECT [outer].* FROM ( ";
        $sql.=" SELECT ROW_NUMBER() OVER(ORDER BY l.loc_name ASC) as ROW_NUMBER, ";
        $sql.=" COALESCE(f.floorCount, 0) AS floorCount, ";
		$sql.=" l.loc_id, l.loc_name, l.loc_desc ";
		$sql.=" FROM tbl_location l ";
        $sql.=" LEFT JOIN (
            SELECT COUNT(floor_id) AS floorCount, floor_location AS floorLoc 
                FROM tbl_floor
                GROUP BY floor_location
        ) AS f
        ON f.floorLoc = l.loc_id";
        if ($status != 0) : 
            if ($status == 500) :
                $sql .= " WHERE l.loc_status >= 0 ";
            else :
                $sql .= " WHERE l.loc_status >= ".$status;
            endif;
        else : 
            $sql .= " WHERE l.loc_status >= 1 ";
        endif;    			
		if ($id != 0) $sql.=" AND l.loc_id = ".$id;
        if ($floorcnt != 0) $sql .= " AND floorCount > 0";
		$sql .= " GROUP BY l.loc_id, l.loc_name, l.loc_desc, f.floorCount ";
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
	
	function get_floors($id = 0, $start = 0, $limit = 0, $count = 0, $loc = 0)
	{
        $sql="SELECT [outer].* FROM ( ";
        $sql.=" SELECT ROW_NUMBER() OVER(ORDER BY f.floor_name ASC) as ROW_NUMBER, ";
		$sql.=" f.floor_id, f.floor_name, f.floor_location ";
		$sql.=" FROM tbl_floor f ";
        $sql .= " WHERE f.floor_status >= 1 ";
		if ($id != 0) $sql.=" AND f.floor_id = ".$id;
        if ($loc != 0) $sql.=" AND f.floor_location = ".$loc;
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
	
	function get_floors_by_loc($locid, $count = 0)
	{
		$sql="SELECT f.floor_id, f.floor_name";
		$sql.=" FROM tbl_floor f
			WHERE f.floor_location = ".$locid."
			AND f.floor_status = 1 
			ORDER BY f.floor_name ASC";

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
	
	function get_floors_dropdown($locid, $count = 0)
	{
		$sql="SELECT f.floor_id, f.floor_name, COUNT(r.room_id) AS roomcount ";
		$sql.=" FROM tbl_floor f
            LEFT JOIN tbl_room r ON r.room_floorid = f.floor_id
			WHERE f.floor_location = ".$locid."
			AND f.floor_status = 1 
            AND r.room_status = 2 
			GROUP BY f.floor_id, f.floor_name
			ORDER BY f.floor_name ASC";

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
    
    function get_locations_dropdown($id = 0, $start = 0, $limit = 0, $count = 0)
	{
        $sql="SELECT [outer].* FROM ( ";
        $sql.=" SELECT ROW_NUMBER() OVER(ORDER BY l.loc_name ASC) as ROW_NUMBER, ";
		$sql.=" COUNT(f.floor_id) AS floorcount, COUNT(r.room_id) AS roomcount, l.loc_id, l.loc_name ";
		$sql.=" FROM tbl_location l
            LEFT JOIN tbl_floor f ON f.floor_location = l.loc_id
            LEFT JOIN tbl_room r ON r.room_locid = l.loc_id
			WHERE l.loc_status >= 1 
            AND f.floor_status >= 1
            AND r.room_status = 2";
		if ($id != 0) $sql.=" AND l.loc_id = ".$id;
		$sql.=" GROUP BY l.loc_id, l.loc_name ";
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
	
	function get_rtypes($id = 0, $limit = 0)
	{
        $sql="SELECT [outer].* FROM ( ";
        $sql.=" SELECT ROW_NUMBER() OVER(ORDER BY rt.rtype_id ASC) as ROW_NUMBER, ";
		$sql.=" rt.rtype_id, rt.rtype_name
			FROM tbl_roomtype rt
			WHERE rt.rtype_status >= 1 ";
		if ($id != 0) $sql.=" AND rt.rtype_id = ".$id;
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;	
			
		return $result;
	}
    
    function get_log($count = 0, $start = 0, $limit = 0, $uid = 0, $task = 0, $from = 0, $to = 0, $searchstr = 0)
	{
        $logfrom = strtotime($from." 00:00:00");
        $logto = strtotime($to." 23:59:59");
        
		$sql="SELECT [outer].* FROM ( ";
        $sql.=" SELECT ROW_NUMBER() OVER(ORDER BY l.logs_date DESC) as ROW_NUMBER, ";
        $sql.=" l.logs_id, l.logs_userid, u.user_fullname, l.logs_task, l.logs_date, l.logs_data, l.logs_status
			FROM tbl_logs l, tbl_user u
			WHERE u.user_id = l.logs_userid 
			AND l.logs_status != 0 ";
        
		if ($uid != 0) $sql .= " AND l.logs_userid = ".$uid." ";
		if ($task != 0 || $task != NULL) $sql .= " AND l.logs_task = '".$task."' ";
        if ($from && $to) $sql .= " AND l.logs_date BETWEEN ".$logfrom." AND ".$logto." ";
		if ($searchstr != 0 || $searchstr != NULL) $sql .= " AND l.logs_data = '".$searchstr."' ";
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;
		
		if ($count == 1) $result = $this->get_numrow($sql); 
		else $result = $this->get_row($sql, 1);
		return $result;
	}
    
    function get_data_from_logs($id = 0, $task = 0)
	{
        switch ($task) {
        
		    case 'RESERVE_ROOM' :
            case 'EDIT_RESERVATION' :
            case 'DELETE_RESERVATION' :
            case 'APPROVE_RESERVATION' :
                $log_idata = 'Reservation ID: '.$id.'<br>';
                $res_data = $this->get_all_reservations($id, 0, 1, 0, 0, 0, NULL, 0);
                $log_idata .= $res_data[0]['reserve_eventname'].'<br>'.$res_data[0]['room_name'].'<br>'.date("M j, Y", $res_data[0]['reserve_checkin']);
                break;               
            case 'APPROVE_ROOM' :
            case 'ADD_ROOM' :
            case 'UPDATE_ROOM' :
            case 'DELETE_ROOM' :
                $log_idata = 'Room ID: '.$id.'<br>';
                $room_data = $this->get_rooms($id, 0, 1, NULL, 0, 500);
                $log_idata .= $room_data[0]['room_name'];
                break;   
            case 'ADD_LOCATION' :
            case 'UPDATE_LOCATION' :
            case 'DELETE_LOCATION' :
                $log_idata = 'Location ID: '.$id.'<br>';
                $loc_data = $this->get_locations($id, 0, 1, 0, 500);
                $log_idata .= $loc_data[0]['loc_name'];
                break;   
            case 'REGISTER_USER' :
            case 'ADD_USER' :
            case 'UPDATE_USER' :
            case 'DELETE_USER' :
            case 'APPROVE_USER' :
            case 'DISAPPROVE_USER' :
            case 'UPDATE_PROFILE' :
            case 'EDIT_PASSWORD' :
                $log_idata = 'User ID: '.$id.'<br>';
                $user_data = $this->get_all_users($id, 0, 1, NULL, 0, 0, 0);
                $log_idata .= $user_data[0]['user_fullname'];
                break;
            default :
                $log_idata = 'n/a';
        }
        return $log_idata;
	}

	function get_users($id = 0, $start = 0, $limit = 0, $search = NULL, $count = 0, $nameid = 0, $profile_id = 0)
	{
		$sql="SELECT [outer].* FROM ( ";
        $sql.=" SELECT ROW_NUMBER() OVER(ORDER BY u.user_date ASC) as ROW_NUMBER, ";
        $sql.=" u.user_id, u.user_level, u.user_empnum, u.user_passw, u.user_fullname, 
			u.user_dept, u.user_telno, u.user_email, u.user_status, u.user_date ";
		$sql.=" FROM tbl_user u
			WHERE u.user_status >= 1 ";
		if ($search != NULL) $sql.=" AND (u.user_empnum LIKE '%".$search."%' OR u.user_fullname LIKE '%".$search."%')";
		if ($id != 0) $sql.=" AND u.user_id = ".$id;
		if ($nameid != 0) $sql.=" AND u.user_empnum = '".$nameid."'";
		if ($profile_id != 0) $sql.=" AND u.user_id != ".$profile_id." AND u.user_level != 9 ";
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
    
    function get_userapp($id = 0, $start = 0, $limit = 0, $search = NULL, $count = 0, $dept = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY user_fullname ASC) as ROW_NUMBER, ";
        $sql .= " user_id, user_empnum, user_fullname, user_level, user_telno, user_email, user_dept, user_image, user_date, user_status
                FROM tbl_user ";  
        $sql .= " WHERE user_id != 0 ";      
        $sql .= " AND user_level = 2 ";      
        if ($id != 0) : $sql .= " AND user_id = ".$id." "; endif;        
        if ($search != NULL) : $sql .= " AND user_fullname LIKE '%".$search."%' "; endif;        
        if ($dept != 0) : $sql .= " AND user_dept = ".$dept." "; endif;        
        $sql .= " AND user_status != 0 ";
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;
        
		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
		return $result;
	}
    
    function get_userlevel($level)
    {
        switch($level) {
            case 1: return 'Requestor'; break;
            case 2: return 'Approver'; break;
            case 7: return 'Receptionist'; break;
            case 8: return 'Report Viewer'; break;
            case 9: return 'Admin Head'; break;
        }
    }
    
    function get_approver($userid = 0, $apprid = 0)
	{
		$sql = "SELECT appr_id, appr_approverid, appr_userid
                FROM tbl_approver ";  
        $sql .= " WHERE appr_id != 0 ";      
        if ($userid != 0) : $sql .= " AND appr_userid = ".$userid." "; endif;        
        if ($apprid != 0) : $sql .= " AND appr_approverid = ".$apprid." "; endif;        
        
        $result = $this->get_row($sql);			
		return $result;
	}
    
    function get_dept($id = 0, $start = 0, $limit = 0, $search, $count = 0)
	{
		$sql="SELECT [outer].* FROM ( ";
        $sql.=" SELECT ROW_NUMBER() OVER(ORDER BY d.dept_name ASC) as ROW_NUMBER, ";
        $sql.=" d.dept_id, d.dept_name, d.dept_abbr, d.dept_division, d.dept_status ";
		$sql.=" FROM tbl_dept d
			WHERE d.dept_status >= 1 ";
		if ($search != NULL) $sql.=" AND d.dept_uname LIKE '%".$search."%'";
		if ($id != 0) $sql.=" AND d.dept_id = ".$id;
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}

	function get_all_users($id = 0, $start = 0, $limit = 0, $search, $count = 0, $nameid = 0, $profile_id = 0)
	{
		$sql="SELECT [outer].* FROM ( ";
        $sql.=" SELECT ROW_NUMBER() OVER(ORDER BY u.user_date DESC) as ROW_NUMBER, ";
        $sql.=" u.user_id, u.user_level, u.user_empnum, u.user_passw, u.user_fullname, 
			u.user_dept, u.user_telno, u.user_email, u.user_status, u.user_date ";
		$sql.=" FROM tbl_user u
			WHERE u.user_status >= 0 ";
		if ($search != NULL) $sql.=" AND (u.user_uname LIKE '%".$search."%' OR u.user_fullname LIKE '%".$search."%' OR u.user_dept LIKE '%".$search."%')";
		if ($id != 0) $sql.=" AND u.user_id = ".$id;
		if ($nameid != 0) $sql.=" AND u.user_empnum = '".$nameid."'";
		if ($profile_id != 0) $sql.=" AND u.user_id != ".$profile_id." AND u.user_level != 9 ";
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
			
		return $result;
	}
	
	function get_set($num = 0)
	{        
		$sql="SELECT TOP 1 s.set_announce, s.set_annexpire, s.set_mailfoot, s.set_numrows
			FROM tbl_setting s ";

        if ($num == 1) $result = $this->get_numrow($sql);			
		else $result = $this->get_row($sql, 1);			
			
		return $result;
	}

	function find_username($username)
	{
		$sql="SELECT TOP 1 *
			FROM tbl_user u
			WHERE u.user_status >= 1 
			AND u.user_empnum = '".$username."'";

		$result = $this->get_numrow($sql);			
			
		return $result;
	}

	function find_email($email)
	{
		$sql="SELECT TOP 1 u.user_empnum
			FROM tbl_user u
			WHERE u.user_status >= 1 
			AND u.user_email = '".$email."'";

		$result = $this->get_row($sql);			
			
		return $result[0]['user_uname'];
	}

	function find_password($username, $password)
	{		
		$sql="SELECT * FROM tbl_user u
			WHERE u.user_status >= 1 
			AND u.user_empnum = '".$username."'
			AND u.user_passw = CONVERT(NVARCHAR(32), HashBytes('MD5', '".$password."'), 2)";

		$result = $this->get_numrow($sql);			
			
		return $result;
	}

	function send_password($email, $username)
	{
		$md5uname = md5($username);

		$message = "<div style='display: block; border: 5px solid #000; padding: 10px; font-size: 12px; font-family: Verdana;'><span style='font-size: 18px; color: #000; font-weight: bold;'>iRoom Change Password</span><br><br>Hi ".$username.",<br><br>";
		$message .= "To change the password of your iRoom Account, please click on the following link.<br><br>";
		$message .= "<a href='".WEB."/reset/".$md5uname."'>".WEB."/reset/".$md5uname."</a><br><br>";
		$message .= "Thanks,<br>";
		$message .= "iRoom Admin";
        $message .= "<hr />".MAILFOOT."</div>";
        
        $headers = "From: noreply@megaworldcorp.com\r\n";
        $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$sendmail = mail($email, "Change Your Password", $message, $headers);

		if ($sendmail) return true;
		else return false;
	}
    
    function getholisun($timestamp)
    {
        $month = date("n", $timestamp);
        $day = date("j", $timestamp);
        
        $sql = "SELECT ID, Description, HolidayMonth, HolidayDay, Type FROM tbl_holiday ";
        $sql .= " WHERE Type <> 'LC' AND HolidayMonth = '".$month.".00' AND HolidayDay = '".$day.".00' ";
        
		$result = $this->get_numrow($sql);	
        
        if (!$result) :
            $daynum = date("N", $timestamp);
            if ($daynum == 7) :
                $result = 1;
            else :
                $result = 0;
            endif;
        endif;
        
		return $result;  
    }
    
    function HTMLToRGB($htmlCode)
    {
        if($htmlCode[0] == '#') $htmlCode = substr($htmlCode, 1);

        if (strlen($htmlCode) == 3) :
            $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
        endif;

        $r = hexdec($htmlCode[0] . $htmlCode[1]);
        $g = hexdec($htmlCode[2] . $htmlCode[3]);
        $b = hexdec($htmlCode[4] . $htmlCode[5]);

        return $b + ($g << 0x8) + ($r << 0x10);
    }

    function RGBToHSL($RGB) 
    {
        $r = 0xFF & ($RGB >> 0x10);
        $g = 0xFF & ($RGB >> 0x8);
        $b = 0xFF & $RGB;

        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;

        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);

        $l = ($maxC + $minC) / 2.0;

        if($maxC == $minC) :
            $s = 0;
            $h = 0;
        else :
            if($l < .5) :
                $s = ($maxC - $minC) / ($maxC + $minC);
            else :
                $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
            endif;
            if($r == $maxC) $h = ($g - $b) / ($maxC - $minC);
            if($g == $maxC) $h = 2.0 + ($b - $r) / ($maxC - $minC);
            if($b == $maxC) $h = 4.0 + ($r - $g) / ($maxC - $minC);
            $h = $h / 6.0; 
        endif;

        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);

        return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }

	function check_reservation($room_id, $checkin, $checkout, $res_id = 0)
	{
		$sql="SELECT r.reserve_id, r.reserve_eventname
			FROM tbl_reservation r
			WHERE r.reserve_status >= 1 
			AND r.reserve_roomid = ".$room_id."
			AND r.reserve_checkin < '".$checkout."'
			AND r.reserve_checkout > '".$checkin."'";
		if ($res_id != 0) $sql.=" AND r.reserve_id != ".$res_id;	

		//var_dump($sql);

		$result = $this->get_numrow($sql);			
		if ($result == 0) return true;
		else {
			return false;
		}
	}

	function reserve_action($value, $action, $id = 0)
	{
		//$value = extract($value);

		switch ($action) {
			case 'add':		
                            
                $accepted_field = array('reserve_eventname', 'reserve_floorid', 'reserve_roomid', 'reserve_checkin', 'reserve_checkout', 'reserve_person', 'reserve_participant', 'reserve_purpose', 'reserve_notes', 'reserve_emails', 'reserve_user');

                $knum = 0;
                foreach ($value as $key => $value) :        
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;        
                        $val[$knum]['field_value'] = $value;   
                        if ($key == 'reserve_floorid' || $key == 'reserve_roomid' || $key == 'reserve_person' || $key == 'reserve_user') :     
                            $val[$knum]['field_type'] = SQLINT4;      
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;  
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        if ($key == 'reserve_notes' || $key == 'reserve_emails') :
                            $val[$knum]['field_isnull'] = true;
                        else :
                            $val[$knum]['field_isnull'] = false;
                        endif;
                        $knum++;
                    endif;
                endforeach;


                $lastid = $this->get_sp_data_status('SP_ADD_RESERVATION', $val);
                if($lastid) {
                    return $lastid;
                } else {
                    return FALSE;
                }

			break;

			case 'edit':
                
                $accepted_field = array('reserve_id', 'reserve_eventname', 'reserve_floorid', 'reserve_checkin', 'reserve_checkout', 'reserve_person', 'reserve_participant', 'reserve_purpose', 'reserve_notes');

                $knum = 0;
                foreach ($value as $key => $value) :        
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;        
                        $val[$knum]['field_value'] = $value;    
                        if ($key == 'reserve_floorid' || $key == 'reserve_person' || $key == 'reserve_id') :     
                            $val[$knum]['field_type'] = SQLINT4;      
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;  
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        if ($key == 'reserve_notes') :
                            $val[$knum]['field_isnull'] = true;
                        else :
                            $val[$knum]['field_isnull'] = false;
                        endif;
                        $knum++;
                    endif;
                endforeach;


                $editres = $this->get_sp_data_status('SP_EDIT_RESERVATION', $val);
                if($editres) {
                    return 1;
                } else {
                    return FALSE;
                }

			break;

			case 'post':

				$sql="UPDATE tbl_reservation SET reserve_status = 2
					WHERE reserve_id = ".$id;

				if($this->get_execute($sql)) {
					return true;
				} else {
					return false;
				}			

			break;

			case 'unpost':

				$sql="UPDATE tbl_reservation SET reserve_status = 1
					WHERE reserve_id = ".$id;

				if($this->get_execute($sql)) {
					return true;
				} else {
					return false;
				}			

			break;

			case 'approve':

				$sql = "UPDATE tbl_reservation 
                    SET reserve_status = 2,
                    reserve_remark = '".$value['reserve_remark']."',
                    reserve_date = GETDATE()
					WHERE reserve_id = ".$id;

				if($this->get_execute($sql)) {					
					return true;
				} else {
					return false;
				}			

			break;

			case 'adminapprove':

				$sql = "UPDATE tbl_reservation 
                    SET reserve_status = 9,
                    reserve_roomid = ".$value['roomid'].",
                    reserve_adremark = '".$value['reserve_remark']."',
                    reserve_date = GETDATE()
					WHERE reserve_id = ".$id;

				if($this->get_execute($sql)) {					
					return true;
				} else {
					return false;
				}			

			break;

			case 'reject':

				$sql = "UPDATE tbl_reservation 
                    SET reserve_status = 7,
                    reserve_remark = '".$value['reserve_remark']."',
                    reserve_date = GETDATE()
					WHERE reserve_id = ".$id;

				if($this->get_execute($sql)) {					
					return true;
				} else {
					return false;
				}			

			break;

			case 'adminreject':

				$sql = "UPDATE tbl_reservation 
                    SET reserve_status = 6,
                    reserve_adremark = '".$value['reserve_remark']."',
                    reserve_date = GETDATE()
					WHERE reserve_id = ".$id;

				if($this->get_execute($sql)) {					
					return true;
				} else {
					return false;
				}			

			break;

			case 'delete':

				$sql = "UPDATE tbl_reservation SET reserve_status = 0
					WHERE reserve_id = ".$id;

				if($this->get_execute($sql)) {
					return true;
				} else {
					return false;
				}			

			break;
		}
	}

	function room_action($value, $action, $id = 0)
	{
		switch ($action) {
			case 'add':	
                            
                $accepted_field = array('room_name', 'room_locid', 'room_floorid', 'room_desc', 'room_capacity', 'room_img', 'room_type', 'room_color');

                $knum = 0;
                foreach ($value as $key => $value) :        
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;        
                        $val[$knum]['field_value'] = $value;   
                        if ($key == 'room_id') :     
                            $val[$knum]['field_type'] = SQLINT4; 
                        elseif ($key == 'room_locid' || $key == 'room_floorid' || $key == 'room_capacity') :     
                            $val[$knum]['field_type'] = SQLINT2;      
                        elseif ($key == 'room_type') :     
                            $val[$knum]['field_type'] = SQLINT1;      
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;  
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;


                $lastid = $this->get_sp_data_status('SP_ADD_ROOM', $val);
                if($lastid) {
                    return $lastid;
                } else {
                    return FALSE;
                }

			break;

			case 'update':

				$accepted_field = array('room_id', 'room_name', 'room_locid', 'room_floorid', 'room_desc', 'room_capacity', 'room_img', 'room_type', 'room_color');

                $knum = 0;
                foreach ($value as $key => $value) :        
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;        
                        $val[$knum]['field_value'] = $value;   
                        if ($key == 'room_id') :     
                            $val[$knum]['field_type'] = SQLINT4; 
                        elseif ($key == 'room_locid' || $key == 'room_floorid' || $key == 'room_capacity') :     
                            $val[$knum]['field_type'] = SQLINT2;      
                        elseif ($key == 'room_type') :     
                            $val[$knum]['field_type'] = SQLINT1;      
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;  
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;

                $editroom = $this->get_sp_data_status('SP_EDIT_ROOM', $val);
                if($editroom) {
                    return $editroom;
                } else {
                    return FALSE;
                }

			break;

			case 'delete':

				$sql = "UPDATE tbl_room SET room_status = 0
					WHERE room_id = ".$id;

				if($this->get_execute($sql)) {
					return TRUE;
				} else {
					return FALSE;
				}			

			break;

			case 'approve':

				$sql="UPDATE tbl_room SET room_status = ".($_POST['room_status'] == 2 ? 1 : 2)."
					WHERE room_id = ".$id;

				if($this->get_execute($sql)) {
					if ($_POST['room_status'] == 2) return 1;
					else return 2;
				} else {
					return false;
				}			

			break;
		}
	}

	function floor_action($value, $action, $id = 0)
	{

		switch ($action) {
			case 'add':	
                            
                $accepted_field = array('floor_name', 'floor_location', 'floor_user');

                $knum = 0;
                foreach ($value as $key => $value) :        
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;        
                        $val[$knum]['field_value'] = $value;   
                        if ($key == 'floor_location' || $key == 'floor_user') :     
                            $val[$knum]['field_type'] = SQLINT4;      
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;  
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        if ($key == 'floor_user') :
                            $val[$knum]['field_isnull'] = true;
                        else :
                            $val[$knum]['field_isnull'] = false;
                        endif;
                        $knum++;
                    endif;
                endforeach;


                $lastid = $this->get_sp_data_status('SP_ADD_FLOOR', $val);
                if($lastid) {
                    return $lastid;
                } else {
                    return FALSE;
                }

			break;

			case 'update':

				$accepted_field = array('floor_id', 'floor_name', 'floor_user');

                $knum = 0;
                foreach ($value as $key => $value) :        
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;        
                        $val[$knum]['field_value'] = $value;   
                        if ($key == 'floor_id' || $key == 'floor_user') :     
                            $val[$knum]['field_type'] = SQLINT4;      
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;  
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        if ($key == 'floor_user') :
                            $val[$knum]['field_isnull'] = true;
                        else :
                            $val[$knum]['field_isnull'] = false;
                        endif;
                        $knum++;
                    endif;
                endforeach;

                $editfloor = $this->get_sp_data_status('SP_EDIT_FLOOR', $val);
                if($editfloor) {
                    return $editfloor;
                } else {
                    return FALSE;
                }

			break;

			case 'delete':

				$sql = "UPDATE tbl_floor SET floor_user = ".$value['floor_user'].", floor_status = 0
					WHERE floor_id = ".$id;

				if($this->get_execute($sql)) {
					return TRUE;
				} else {
					return FALSE;
				}			

			break;
		}
	}

	function loc_action($value, $action, $id = 0)
	{
		switch ($action) {
			case 'add':	
                            
                $accepted_field = array('loc_name', 'loc_desc');

                $knum = 0;
                foreach ($value as $key => $value) :        
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;        
                        $val[$knum]['field_value'] = $value;  
                        $val[$knum]['field_type'] = SQLVARCHAR;  
                        $val[$knum]['field_maxlen'] = 512;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;


                $lastid = $this->get_sp_data_status('SP_ADD_LOCATION', $val);
                if($lastid) {
                    return $lastid;
                } else {
                    return FALSE;
                }

			break;

			case 'update':

				$accepted_field = array('loc_id', 'loc_name', 'loc_desc');

                $knum = 0;
                foreach ($value as $key => $value) :        
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;        
                        $val[$knum]['field_value'] = $value;   
                        if ($key == 'loc_id') :     
                            $val[$knum]['field_type'] = SQLINT4;      
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;  
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;

                $editloc = $this->get_sp_data_status('SP_EDIT_LOCATION', $val);
                if($editloc) {
                    return $editloc;
                } else {
                    return FALSE;
                }

			break;

			case 'delete':

				$sql = "UPDATE tbl_location SET loc_status = 0
					WHERE loc_id = ".$id;

				if($this->get_execute($sql)) {
					return TRUE;
				} else {
					return FALSE;
				}			

			break;
		}
	}

	function user_action($value, $action, $id = 0)
	{

		switch ($action) {
			case 'add':
                
                $accepted_field = array('user_level', 'user_empnum', 'user_passw', 'user_fullname', 'user_dept', 'user_telno', 'user_email', 'user_approver');

                $knum = 0;
                foreach ($value as $key => $value) :        
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;        
                        $val[$knum]['field_value'] = $value;    
                        if ($key == 'user_level') :     
                            $val[$knum]['field_type'] = SQLINT1;      
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;  
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;

                $lastid = $this->get_sp_data_status('SP_INSERT_USER', $val);
                if($lastid) {
                    return $lastid;
                } else {
                    return FALSE;
                }

			break;
			case 'update':

				$accepted_field = array('user_id', 'user_level', 'user_empnum', 'user_passw', 'user_fullname', 'user_dept', 'user_telno', 'user_email', 'user_approver');

                $knum = 0;
                foreach ($value as $key => $value) :        
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;        
                        $val[$knum]['field_value'] = $value;   
                        if ($key == 'user_id') :     
                            $val[$knum]['field_type'] = SQLINT4;      
                        elseif ($key == 'user_level') :     
                            $val[$knum]['field_type'] = SQLINT1;      
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;  
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;

                $edituser = $this->get_sp_data_status('SP_UPDATE_USER', $val);
                if($edituser) {
                    return $edituser;
                } else {
                    return FALSE;
                }

			break;

			case 'edit_password':

				$sql="UPDATE tbl_user 
					SET user_passw = CONVERT(NVARCHAR(32), HashBytes('MD5', '".$value['user_password1']."'), 2) WHERE user_id = ".$value['user_id'];			

				if($this->get_execute($sql)) {
					return true;
				} else {
					return false;
				}

			break;

			case 'delete':

				$sql="UPDATE tbl_user SET user_status = 0
					WHERE user_id = ".$id;

				if($this->get_execute($sql)) {
					return true;
				} else {
					return false;
				}			

			break;

			case 'approve':

				$sql="UPDATE tbl_user SET user_status = ".($value['user_status'] == 2 ? 1 : 2)."
					WHERE user_id = ".$id;

				if($this->get_execute($sql)) {
					if ($value['user_status'] == 2) return 1;
					else return 2;
				} else {
					return false;
				}			

			break;
		}
	}
    
    function set_update($value)
	{
		$value = extract($value);
        
        $numrow = $this->get_set(1);
        
        if ($numrow == 0)
        {
            $sql="INSERT INTO tbl_setting
                (set_announce, set_annexpire, set_mailfoot, set_numrows, set_date)
                VALUES
                ('".$set_announce."', '".strtotime($set_annexpire." 00:00:00")."', '".$set_mailfoot."', '".$set_numrows."', GETDATE())";
            $query = $this->get_execute($sql);        
        }
        else
        {
            $sql="UPDATE tbl_setting 
                SET set_announce = '".$set_announce."', set_annexpire = '".strtotime($set_annexpire." 00:00:00")."', set_mailfoot = '".$set_mailfoot."', set_numrows = '".$set_numrows."', set_date = GETDATE()";			    
            $query = $this->get_execute($sql);        
        }            

        if($query) {
            return true;
        } else {
            return false;
        }
	}

	# LOGS (AUDIT TRAIL)

	function log_action($task, $dataid, $userid)
	{		
		if ($task && $userid) {

			$sql = "INSERT INTO tbl_logs
				(logs_userid, logs_date, logs_task, logs_data, logs_status)
				VALUES
				('".$userid."', GETDATE() + 28800, '".$task."', '".$dataid."', 1)";				

			if($this->get_execute($sql)) {
				return true;
			} else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	
	# MISCELLEANNOUS
	
	function pagination($section, $record, $limit, $range = 9){
	  // $paged - number of the current page
	  global $paged;
		$web_root = ROOT;
		
		$pagetxt = "";
		
	  // How much pages do we have?
		$paged = $_GET['page'] ? $_GET['page'] : "1";
	
		$max_num_pages = ceil($record/$limit);
	
		if (!$max_page) {
			$max_page = $max_num_pages;
		}

	  // We need the pagination only if there are more than 1 page
	  if($max_page > 1){
		if(!$paged){
		  $paged = 1;
		}
		
		// On the first page, don't put the First page link
		if($paged != 1){
		  $pagetxt .= "<a href='".$web_root."/".$section."/page/1' class='blacktext nodecor'><i class='fa fa-lg fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;</a>";
		  $prev_var = $_GET['page'] ? $_GET['page'] - 1 : "0"; //previous page_num
		  $pagetxt .= "<a href='".$web_root."/".$section."/page/".$prev_var."' class='blacktext nodecor'>Previous&nbsp;&nbsp;&nbsp;</a>";
		}
		
		// We need the sliding effect only if there are more pages than is the sliding range
		if($max_page > $range){
		  // When closer to the beginning
		  if($paged < $range){
				for($i = 1; $i <= ($range + 1); $i++){
					$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."' class='nodecor'>";
					if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext'>".$i."</div>";
					else $pagetxt .= "<div class = 'pagelink blacktext'>".$i."</div>";				
					$pagetxt .= "</a>";
				}
		  }
		  // When closer to the end
		  elseif($paged >= ($max_page - ceil(($range/2)))){
				for($i = $max_page - $range; $i <= $max_page; $i++){
					$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."' class='nodecor'>";
					if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext'>".$i."</div>";
					else $pagetxt .= "<div class = 'pagelink blacktext'>".$i."</div>";				
					$pagetxt .= "</a>";
				}
		  }
		  // Somewhere in the middle
		  elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))) {
				for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++) {
					$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."' class='nodecor'>";
					if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext'>".$i."</div>";
					else $pagetxt .= "<div class = 'pagelink blacktext'>".$i."</div>";				
					$pagetxt .= "</a>";
				}
		  }
		}
		// Less pages than the range, no sliding effect needed
		else{
		  for($i = 1; $i <= $max_page; $i++){
				$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."' class='nodecor'>";
				if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext'>".$i."</div>";
				else $pagetxt .= "<div class = 'pagelink blacktext'>".$i."</div>";				
				$pagetxt .= "</a>";
		  }
		}
	
		
		// On the last page, don't put the Last page link
		if($paged != $max_page){
			$next_var= $_GET['page'] ? $_GET['page'] + 1 : "2"; //next page_num
			$pagetxt .= "<a href='".$web_root."/".$section."/page/".$next_var."' class = 'blacktext nodecor'>&nbsp;&nbsp;&nbsp;Next</a>";
			$pagetxt .= "<a href='".$web_root."/".$section."/page/".$max_page."' class = 'blacktext nodecor'>&nbsp;&nbsp;&nbsp;<i class='fa fa-lg fa-angle-double-right'></i></a>";
		}
	  }
		
		return $pagetxt;
	}
	
	
	
	function curPageURL() 
	{
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	function cleanuserinput($input)
	{
		if (get_magic_quotes_gpc()) {
			$clean = mysqli_real_escape_string(stripslashes($input));
		}
		else
		{
			$clean = mysqli_real_escape_string($input);
		}
		return $clean;
	}
	
	function cleanpostvar($getvar)
	{		
		$conn = $this->db_connect();
		$str = $conn->real_escape_string($getvar);
		return $str;
	}

	function cleanpostname($input, $reverse=false)
	{

		if($reverse==true) {
			$str = $input;		
			$str = str_replace("ï¿½", "&rsquo;", $str);
			$str = str_replace("ÃƒÂ©", "&eacute;", $str);
			$str = str_replace("â€¦ ï¿½", "&nbsp;", $str);
			$str = str_replace("â€¦", "&nbsp;", $str);
			$str = str_replace("&amp;", "&", $str);
			$str = str_replace("&quot;", "\"", $str);
			$str = str_replace("&rsquo;", "'", $str);
			$str = str_replace("ï¿½", "&ntilde;", $str);
			$str = str_replace("ï¿½", "&eacute;", $str);			
			$str = str_replace("ï¿½", "&Eacute;", $str);			
			$str = str_replace("ï¿½", "&hellip;", $str);
			$str = str_replace("ï¿½", "&nbsp;", $str);
			$str = str_replace("Ã©", "&eacute;", $str);				
			$str = str_replace("Ã±", "&ntilde;", $str);			
			$str = str_replace("Ã'", "&Ntilde;", $str);			
			$str = str_replace("ï¿½", "&Ntilde;", $str);
			$str = str_replace("&nbsp;", " ", $str);
			$str = str_replace("â€™", "'", $str);			
			$str = stripslashes($str);
		} else {
			$str = stripslashes($input);
			$str = str_replace("&amp;", "&", $str);
			$str = str_replace("&quot;", "\"", $str);
			$str = str_replace("&rsquo;", "'", $str);
			$str = str_replace(" ", "-", $str);
			$str = str_replace("&ntilde;", "n", $str);
			$str = str_replace("&eacute;", "ï¿½", $str);			
			$str = str_replace("&hellip;", "", $str);						
			$str = stripslashes(urldecode(html_entity_decode($str)));
			$str = preg_replace("/[^a-zA-Z0-9-]/", "", urldecode($str));
		}

		return $str;
	}
	
	function get_logs($artid)
	{		
		$sql = "SELECT a.log_content, a.log_date, b.user_firstname, b. user_lastname
			 FROM logs a, users b
			 WHERE b.ID = a.user_id
			 AND a.object_id = $artid
			 AND a.log_status = 1
			 AND a.log_deleted = 0";
		$record = mysqli_query($con, $sql);
		while($row = mysqli_fetch_assoc($record)) {
			$result[] = $row;
		
		}
		mysqli_free_result($record);
		return $result;
	}
	
	function activate_directory_tab($link,$tab)
	{
		if($link == $tab)
		{
			return 'class="dir_link current"';
		}else{
			return 'class="dir_link"';
		}	
	}
	
	function truncate($string, $length)
	{
		if (strlen($string) <= $length) {
			$string = $string; //do nothing
			}
		else {
			$string = wordwrap($string, $length);
			$string = substr($string, 0, strpos($string, "\n"));
			$string .= '...';
		}
		return $string;
	}
	
	function filter_bad_words($words)
	{
		$badwords = array("pokpok", "kupal", "kups", "fucker", "slut", "pucha", "tae", "bullshit", "shit", "gago", "puta", "tangina", "tonto", "tang ", "asshole", "fuck", "pekpek", "titi", "etits", "tits", "penis", "vagina", "pudayday", "puday", "kepyas", "kepkep", "dede", "tarantado", "bitch", "hosto", "ass", "putang ina", "pussy", "satan", "shit", "ulol", "puke", "puki", "kakantutin", "kakantuten", "makantot", "ass", "echas", "tits", "asshole", "tang ina", "ass wipe", "fag", "tarantado", "bitch ", "gago", "biatch", "bitch", "ulul", "biatches", "gagi", "utong", "beyotch", "hoe", "beeyotch", "hooker", "bulbol", "haliparot", "bolbol ", "jakol", "boobs", "jackol", "bullshit", "kunt", "kantot", "cunt", "nigger", "pakshit", "callboy", "puta", "pota", "callgirl", "puerta", "clit", "pwerta", "pussy", "douche bag", "dumb ass", "dodo", "doofus", "shit", "dipshit", "dung face", "ebs", "p0kp0k", "p0t@", "fcuk", "pwet", "pwit", "haliparot", "lawlaw", "pokpok", "crap");	
	
		$bw_exp = "";
		$badword_match = 0;
		foreach ($badwords as $badwords_exp) {
            $bw_exp = "/". $badwords_exp ."/i";
		
			if (preg_match($bw_exp, $words)) {
				$badword_match = $badword_match + 1;
                $bw_match = $badwords_exp;
			}
		}	
			
		if($badword_match > 0)
		{
			return $bw_match;
		}
        else
        {
			return FALSE;
		}
	
	}
	
	function clean_variable($var, $type = 0)
	{
		if (get_magic_quotes_gpc())
		{
			$newvar = stripslashes($var);
		}
		else
		{
			$newvar = $var;
		}   
			
        return $newvar;
	}

}
?>