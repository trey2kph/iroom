<?php include("../../config.php"); ?>
<?php	

	$cookiename = 'megairoom_user';

	extract($_POST);

	$checkfmem = $register->check_member($username, $password);
	$getmem = $register->get_member($username);
	if ($checkfmem)
	{
		$expire = time() + 60;
		$_SESSION[$cookiename] = $username;
		//AUDIT TRAIL
		$log = $main->log_action("LOGIN", 0, $getmem[0]['user_id']);
		$success = 1;
	}
	else
	{	
		$success = 0;		
	}	

	echo $success;

?>