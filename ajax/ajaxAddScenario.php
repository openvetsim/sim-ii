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
	
	// get tmp file name
	$scenarioDir = dbClass::valuesFromPost('sd');
	if($scenarioDir == '') {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		echo json_encode($returnVal);
		exit();
	}
	
	fileClass::deleteDir(SERVER_SCENARIOS . $scenarioDir);					
	fileClass::copyDir(TMP_SCENARIO_DIR, SERVER_SCENARIOS . $scenarioDir . '/', 0777);
	fileClass::deleteDir(TMP_SCENARIO_DIR);					
	
	$returnVal['status'] = AJAX_STATUS_OK;
	echo json_encode($returnVal);
	exit();
?>