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
	
	$side = dbClass::valuesFromPost('side');
	if($side == '' || ($side != 'left' && $side != 'right') ) {
		$side = 'left';
	}
	
	$soundID = dbClass::valuesFromPost('soundID');
	if(dbClass::isInt($soundID) === FALSE) {
		$soundID = 1;
	}
	
	$lungSoundArray = array(
		"Normal",
		"Course Crackles",
		"Fine Crackles",
		"Pleural Rib",
		"Pneumonia",
		"Rhonchi",
		"Stridor",
		"Wheezes"
	);
	
	// lung sound options
	$lungSoundOption = '
		<select id="sound-select" class="modal-select">
	';
	foreach($lungSoundArray as $index => $value) {
		$select = ($soundID == $index) ? ' selected="selected" ' : '';
		$lungSoundOption .= '
			<option value="' . $index . '"' . $select . '>' . $value . '</option>
		';
	}
	
	// add in extra option for left lung
	if($side == 'left') {
		$select = ($soundID == "10") ? ' selected="selected" ' : '';
		$lungSoundOption .= '
			<option value="10"' . $select . '>Same as Right Lung</option>
		';	
	}
	$lungSoundOption .= '
		</select>
	';
	
	$content = '
		<h1 id="modal-title">Lung Sound Control</h1>
		<hr / class="modal-divider">
		<h2 class="modal-section-title">' . ucfirst($side) . ' Lung Sound Control</h2>
		<div class="control-modal-div">
			' . $lungSoundOption . '
		</div>
		<hr / class="modal-divider">
		<div class="control-modal-div">
			<div id="volume-controls">
				<p id="mute-volume-title" class="clearer">Mute</p>
				<p id="volume-title">- Volume +</p>
				<input type="checkbox" id="mute-volume" class="clearer">
				<div id="volume-slider"></div>
			</div>
			<div class="clearer"></div>
		</div>
	';

	$returnVal['status'] = AJAX_STATUS_OK;
	$returnVal['html'] = $content;
	echo json_encode($returnVal);
	exit();


?>