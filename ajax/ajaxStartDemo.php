<?php
	// init
	require_once("../init.php");
	$returnVal = array();
	
	// is user logged in
	if(adminClass::isUserLoggedIn() === FALSE) {
		if ( SERVER_ADDR != REMOTE_ADDR ) // This allows access without login for Student Vitals display
		{
			$returnVal['status'] = AJAX_STATUS_LOGIN_FAIL;
			$returnVal['cause'] = "No login";
			echo json_encode($returnVal);
			exit();
		}
	}
	
	// Get the Session ID
	if ( !isset($_COOKIE['PHPSESSID'] ) )
	{
		$returnVal['status'] = AJAX_STATUS_FAIL;
		$returnVal['cause'] = "No Session ID in Cookies";
		echo json_encode($returnVal);
		exit();
	}
	$sesid = $_COOKIE['PHPSESSID'];
	// Start a simmgr demo session
	$returnVal['cause'] = shell_exec("simmgrDemo ".$sesid );
	if ( $returnVal['cause'] != '' )
	{
		$returnVal['status'] = AJAX_STATUS_FAIL;
	}
	else
	{
		$returnVal['status'] = AJAX_STATUS_OK;
	}
	echo json_encode($returnVal);
	exit();
?>
	