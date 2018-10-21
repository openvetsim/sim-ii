<?php
	// Called periodically to keep PHP Session from timing out
	// init
	require_once("../init.php");
	$returnVal = array();

	// is user logged in
	if(adminClass::isUserLoggedIn() === FALSE) {
		$returnVal['status'] = AJAX_STATUS_LOGIN_FAIL;
		echo json_encode($returnVal);
		exit();
	}
	
	$count = 0;
	if ( isset($_SESSION['tapCount'] ) )
		$count = $_SESSION['tapCount'];
	$count++;
	$_SESSION['tapCount'] = $count;
	
	$returnVal['count'] = $count;
	$returnVal['status'] = AJAX_STATUS_OK;
	echo json_encode($returnVal);
	exit();
?>