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
	
	$soundName = dbClass::valuesFromPost('soundName');
	if(dbClass::isInt($soundID) === FALSE) {
		$soundID = 1;
	}
	
	$heartSoundArray = array(
		"none" => "None",
		"normal" => "Normal",
		"aortic_stenosis" => "Aortic Stenosis",
		"austin_flint_murmur" => "Austin Flint Murmur",
		"friction_rub" => "Friction Rub",
		"mitral_valve_prolapse" => "Mitral Valve Prolapse",
		"systolic_murmur" => "Systolic Murmur",
		"diastolic_murmur" => "Diastolic Murmur",
		"os70" => "OS70 (Opening snap of Mitral Stenosis)"
	);
	
	// lung sound options
	$heartSoundOption = '
		<select id="sound-select" class="modal-select">
	';
	foreach($heartSoundArray as $index => $value) {
		$select = ($soundName == $index) ? ' selected="selected" ' : '';
		$heartSoundOption .= '
			<option value="' . $index . '"' . $select . '>' . $value . '</option>
		';
	}
	
	$heartSoundOption .= '
		</select>
	';
	
	$content = '
		<h1 id="modal-title">Heart Sound Control</h1>
		<hr / class="modal-divider">
		<h2 class="modal-section-title">Heart Sound Control</h2>
		<div class="control-modal-div">
			' . $heartSoundOption . '
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