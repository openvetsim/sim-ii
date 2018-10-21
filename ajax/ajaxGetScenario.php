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

	// get file name
	$fileName = dbClass::valuesFromPost('fn');
	if($fileName == '') {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		$returnVal['cause'] = "fn not set";
		echo json_encode($returnVal);
		exit();			
	}
	
	// update path to scenario
	$fileName = $fileName . DIRECTORY_SEPARATOR . 'main';
	
	$scenarioProfileArray = scenarioXML::getScenarioProfileArray($fileName);
	if($scenarioProfileArray === FALSE) {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		echo json_encode($returnVal);
		exit();		
	}

	$scenarioHeaderArray = scenarioXML::getScenarioHeaderArray($fileName);
	if($scenarioHeaderArray === FALSE) {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		echo json_encode($returnVal);
		exit();		
	}

	$scenarioEventsArray = scenarioXML::getScenarioEventsArray($fileName);
	if($scenarioEventsArray === FALSE) {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		echo json_encode($returnVal);
		exit();		
	}
	
	$scenarioMediaArray = scenarioXML::getScenarioMediaArray($fileName);
	if($scenarioEventsArray === FALSE) {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		echo json_encode($returnVal);
		exit();		
	}

	$scenarioVocalsArray = scenarioXML::getScenarioVocalsArray($fileName);
	if($scenarioEventsArray === FALSE) {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		echo json_encode($returnVal);
		exit();		
	}

	$returnVal['status'] = AJAX_STATUS_OK;
	$returnVal['profile'] = $scenarioProfileArray;
	$returnVal['header'] = $scenarioHeaderArray;
	$returnVal['events'] = $scenarioEventsArray;
	$returnVal['media'] = $scenarioMediaArray;
	$returnVal['vocals'] = $scenarioVocalsArray;
	echo json_encode($returnVal);
	exit();
?>