<?php
	// init
	require_once("../init.php");
	$returnVal = array();

	// is user logged in
	if(adminClass::isUserLoggedIn() === FALSE) {
		$returnVal['status'] = AJAX_STATUS_LOGIN_FAIL;
		echo json_encode($returnVal);
		exit();
	}
	
	// get variables
	$userID = dbClass::valuesFromPost('uID');
	$userFirstName = dbClass::valuesFromPost('fn');
	$userLastName = dbClass::valuesFromPost('ln');
	$userEmail = dbClass::valuesFromPost('em');
	$userPassWord = dbClass::valuesFromPost('pw');
	
	// get list of users
	$userRow = adminClass::getUserRow($userID);

	if($userRow == FALSE) {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		echo json_encode($returnVal);
		exit();
	}
	
	$cleanArray['UserID'] = $userID;
	$cleanArray['UserFirstName'] = $userFirstName;
	$cleanArray['UserLastName'] = $userLastName;
	$cleanArray['UserEmail'] = $userEmail;
	
	if($userPassWord != '') {
		$cleanArray['UserPassWord'] = $userPassWord;
		$cleanArray['UserSalt'] = adminClass::generateSalt();
	}

	$result = dbClass::dbUpdateQueryResult(modelClass::createUpdateQuery('Users', $cleanArray));
//FB::log(modelClass::createUpdateQuery('Users', $cleanArray));
	
	$returnVal['status'] = AJAX_STATUS_OK;
	echo json_encode($returnVal);
	exit();
?>