<?php

class validation
{
	var $fields = array();
	var $message = array();
	
	function validation()
	{
	}
	
	function validate_required()
	{
		if(is_array($this->fields))
		{
			foreach($this->fields as $key => $value)
			{
				if(empty($value))
					$this->message['error'][$key] = "$key is required.";
			}
		}
	}
	
	function validate_email($email)
	{
		if($email)
			if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+\.[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $email))
				$this->message['error'][] .= "Invalid Email Address.";
	}
	
	function validate_file($file, $extension = array(), $max_filesize="")
	{
		
		if(isset($file["name"]) && $file["name"]!='')
		{
			if(isset($file) && is_array($file))
			{
				$image 		= $file['name'];
				$type 		= $file['type'];
				$tmp_name 	= $file['tmp_name'];
				$error 		= $file['error'];
				$size		= $file['size'];
	
				if(is_array($extension) && !empty($extension)) 
				{
					$ext = array_keys($extension, $type);
					if(empty($ext[0])) $this->message["error"][] = "Invalid file format.";
				}
				
				if(isset($max_filesize) && $max_filesize != "")
				{
					if($max_filesize < $size) $this->message["error"][] = "Filesize exceed.";
				}
			}
		}
	}
	
	function validate_captcha($input1, $input2)
	{
		if($input1)
			if(!(mysqli_escape_string($input1) === mysqli_escape_string($input2)))
				$this->message['error'][] .= "Security code didn't match.";
		
		return $this->message;
	}

	function validate_phpsessid($input1, $input2)
	{
		if($input1 != "")
			if(!(mysqli_escape_string($input1) === mysqli_escape_string($input2)))
				$this->message['error'][] .= "Unable to process your request.";
	}

	function validate_date($date, $now=false)
	{
		$today = mktime(0,0,0,date("m"),date("d"),date("Y"));
		$d = explode("-", $date);
		
		$check = true;
		foreach($d as $k => $v) {
			if(!is_numeric($v)) {
				$check = false;
			}
		}

		if($check==true) {
			$date = mktime(0,0,0, $d[1], $d[2], $d[0]);
			
			if($now==false)
			{

				if(!checkdate($d[1], $d[2], $d[0]))
					$this->message['error'][] = "Invalid Date";
						
			} else {
				
				if($date < $today)
					$this->message['error'][] = "Date should be greater than the current";

			}
		} else { $this->message['error'][] = "Invalid Date."; }
		return $this->message;
	}
	
	function return_message()
	{
		return $this->message;
	}
}

?>