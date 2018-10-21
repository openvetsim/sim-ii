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
	if($soundName == '') {
		$soundName = "normal";
	}
	
	$heartSoundArray = array(
		"normal" => "Normal",
		"systolic_murmur" => "Systolic Murmur",
		"pansystolic_murmur" => "Pansystolic Murmur",
		"holosystolic_murmur" => "Holoystolic Murmur",
		"continuous_murmur" => "Continuous Murmur",
		"diastolic_murmur" => "Diastolic Murmur",
		"gallop" => "Gallop"
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
				<!-- <p id="mute-volume-title" class="clearer">Mute</p> -->
				<p id="volume-title">- Volume + (<span class="volume-setting">5</span>)</p>
				<!-- <input type="checkbox" id="mute-volume" class="clearer"> -->

				<!-- Old slider
				<div id="volume-slider"></div> -->
				
				<!-- New slider -->
				<input value="0" id="volume-slider" class="strip-value new control-slider-1 float-left heart" data-highlight="true">		
			</div>
			<div class="clearer"></div>
		</div>
		<hr / class="modal-divider">
		<div class="control-modal-div">
			<button class="red-button modal-button apply">Apply</button>
			<button class="red-button modal-button cancel">Cancel</button>
		</div>
	';

	$returnVal['status'] = AJAX_STATUS_OK;
	$returnVal['html'] = $content;
	echo json_encode($returnVal);
	exit();


?>