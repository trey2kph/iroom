<?php

class register
{
	var $ccount = false;
	
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
    
    function get_sp_data($sp_name, $parameters = NULL)
	{        
        // TYPE:
        // 1 - array
        // 2 - num_row
        
        $con = $this->db_connect();
        
        $stmt = mssql_init(DBNAME.'.dbo.'.$sp_name, $con);
        
        if ($parameters) :
            foreach ($parameters as $key => $value) :
                mssql_bind($stmt, '@'.$value['field_name'], $value['field_value'], $value['field_type'], $value['field_isoutput'], $value['field_isnull'], $value['field_maxlen']);
            endforeach;
        endif;

        $query = mssql_execute($stmt);
        
        $result = $query;        
			
		return $result;   
	}
	
	function check_user($username)
	{
		$nameid = $username;

		$sql = "SELECT COUNT(user_id) AS mcount FROM tbl_user WHERE user_empnum = '".$nameid."' AND user_status = 2 ";
		$result = $this->get_row($sql);			
		if($result[0]['mcount'] <= 0) 
		{
			return false;
		}
		else
		{
			return true;
		}	
	}		
	
	function check_member($username, $password)
	{
		$nameid = $username;
		$password = md5($password);
		
		$sql = "SELECT COUNT(user_id) AS mcount FROM tbl_user WHERE user_empnum = '".$nameid."' AND user_passw = '".$password."' AND user_status = 2 ";		
		$result = $this->get_row($sql);			
		if($result[0]['mcount'] <= 0) 
		{
			return false;
		}
		else
		{
			return true;
		}	
	}		
	
	function get_member($username)
	{
		$nameid = $username;

		$sql = "SELECT TOP 1 user_id, user_level, user_empnum, user_passw, user_fullname, user_dept, user_telno, user_email FROM tbl_user WHERE user_empnum = '".$nameid."' AND user_status = 2";
		$result = $this->get_row($sql);			
		return $result;
	}

	function random_password() {
	    $alphabet = array('a','b','c','d','e','f','g','h','i','j','k','m','n','p','r','s','t','u','v','x','y','z','1','2','3','4','5','6','7','8','9');
	    $pass = "";
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, count($alphabet)-1);
	        $pass .= $alphabet[$n];
	    }
	    return $pass;
	}
	
	function add_member($post)
	{		
		if(is_array($post)){			
			$input = array();
			foreach($post as $key => $value) {
				$input[$key] = mysql_escape_string($value);
			}
			
			extract($input);			
			
			$sql = "INSERT INTO tbl_user 
					   (username, lastname, firstname, 
					   email,, pass, gender, status, 
					   country, income, birthdate,
					   timestamp, status, deleted)
					   VALUES 
					   ('$uname', '$lname', '$fname',
					   '$email', '$gender', '$status', 
					   '$country', '$income', '$bdate', 
					   NOW(), 1, 0)";
			
			if($this->db_query($sql)) {
				return true;
			} else {
				return false;
			}			
		}
	}
    
    function update_member($post, $type = 0)
	{			
        /*
            TYPE
            0 - update
            1 - create
            2 - change password
        */
        
        if ($type == 2) :        
        
            $accepted_field = array('user_empnum', 'user_passw');

            $knum = 0;
            $val = array();
            foreach ($post as $key => $value) :        
                if (in_array($key, $accepted_field)) :
                    $val[$knum]['field_name'] = $key;        
                    $val[$knum]['field_value'] = $value;        
                    $val[$knum]['field_type'] = SQLVARCHAR; 
                    $val[$knum]['field_isoutput'] = false;
                    $val[$knum]['field_isnull'] = false;
                    $val[$knum]['field_maxlen'] = 512;  

                    $knum++;
                endif;
            endforeach;  
        
        elseif ($type == 1) :        
        
            $accepted_field = array('user_level', 'user_empnum', 'user_passw', 'user_fullname', 'user_dept', 'user_telno', 'user_email');

            $knum = 0;
            $val = array();
            foreach ($post as $key => $value) :        
                if (in_array($key, $accepted_field)) :
                    $val[$knum]['field_name'] = $key;        
                    $val[$knum]['field_value'] = $value;        
                    if ($key == 'user_level') :
                    $val[$knum]['field_type'] = SQLINT1;    
                    else :
                    $val[$knum]['field_type'] = SQLVARCHAR; 
                    endif;
                    $val[$knum]['field_isoutput'] = false;
                    $val[$knum]['field_isnull'] = false;
                    if ($key != 'user_level') :
                    $val[$knum]['field_maxlen'] = 512;  
                    endif;

                    $knum++;
                endif;
            endforeach;
        
        else :       
        
            $accepted_field = array('user_id', 'user_level', 'user_empnum', 'user_fullname', 'user_dept', 'user_telno', 'user_email');

            $knum = 0;
            $val = array();
            foreach ($post as $key => $value) :        
                if (in_array($key, $accepted_field)) :
                    $val[$knum]['field_name'] = $key;        
                    $val[$knum]['field_value'] = $value;        
                    if ($key == 'user_id') :
                    $val[$knum]['field_type'] = SQLINT4;    
                    elseif ($key == 'user_level') :
                    $val[$knum]['field_type'] = SQLINT1;    
                    else :
                    $val[$knum]['field_type'] = SQLVARCHAR; 
                    endif;
                    $val[$knum]['field_isoutput'] = false;
                    $val[$knum]['field_isnull'] = false;
                    if ($key != 'user_level') :
                    $val[$knum]['field_maxlen'] = 512;  
                    endif;

                    $knum++;
                endif;
            endforeach; 
        
        endif;
        
        if ($type == 2) :
            $insert_updateemp = $this->get_sp_data('SP_PROFILE_PASSWORD', $val);
        elseif ($type == 1) :
            $insert_updateemp = $this->get_sp_data('SP_PROFILE_CREATE', $val);
        else :
            $insert_updateemp = $this->get_sp_data('SP_PROFILE_UPDATE', $val);
        endif;

        if($insert_updateemp) :
            return TRUE;
        else :
            return FALSE;
        endif;
	}

	function mailthis($post)
	{
		if(is_array($post))
		{
			
			$input = array();
			foreach($post as $key => $value) {
				$input[$key] = mysql_escape_string($value);
			}
			
			extract($input);
		
			$to  = $email; 				
			$subject = 'Megaworld New Account Password';
		
			$message = '
			<html>
			<head>
			  <title>Megaworld New Account Password</title>
			</head>
			<body>
			  <p>Hi '.$fname.'</p>
			  <p>It seems that you have asked for us to send you your password.</p>
			  <p>Below is the information that you will need to login to the site and forums.</p>
			  <p>Username: '.$uname.'<br />Password: '.$pass.'<br />E-Mail Address: '.$email.'</p>
			</body>
			</html>
			';
		
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		
			$headers .= 'To: '.$fname.' '.$lname.' <'.$email.'>' . "\r\n";
			$headers .= 'From: Megaworld Admin <admin@megaworld.com.ph>' . "\r\n";
		
			mail($to, $subject, $message, $headers);
			
		}
	}


}

?>