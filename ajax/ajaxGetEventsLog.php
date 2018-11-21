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
	
	// get params
	$logFileName = dbClass::valuesFromPost('fileName');
	if(file_exists(SERVER_SIM_LOGS . $logFileName) === FALSE) {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		echo json_encode($returnVal);
		exit();
	}
	
	$logRecordCount = dbClass::valuesFromPost('recordCount');
	if(ctype_digit($logRecordCount) === FALSE) {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		echo json_encode($returnVal);
		exit();
	}
	
	$logArray = array_reverse(file(SERVER_SIM_LOGS . $logFileName, FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES));
//FB::log($logArray);

	if(count($logArray) == 0) {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		echo json_encode($returnVal);
		exit();	
	}

	$content = '';
	foreach($logArray as $logRecord) {
		list($timeSystemTime, $timeScenario, $timeScene, $event) = explode(" ", $logRecord, 4);
		$content .= '
			<tr>
				<td class="time-stamp">' . $timeScenario . '</td>
				<td class="event">' . $event . '</td>
			<tr>
		';
	}

	$returnVal['status'] = AJAX_STATUS_OK;
	$returnVal['html'] = $content;
	echo json_encode($returnVal);
	exit();
?>