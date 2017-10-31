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
	
	// get profile info
	$vocalsArray = json_decode(str_replace("\\", "", dbClass::valuesFromPost('vocals')), TRUE);
	$fileList = '
		<ul id="vocal-list">
	';

	foreach($vocalsArray['file'] as $vocalArray) {
		$fileList .= '
			<li>
				<a data-filename="' . $vocalArray['filename'] . '" href="javascript: void(2);"><img class="vocal-list-image" src="' . BROWSER_IMAGES . 'sound.png"><span class="vocal-list-name">' . $vocalArray['title'] . '</span></a>
			</li>
		';
	}
	$fileList .= '
		</ul>
	';

	
	$content = '
		<h1 id="modal-title">Vocal Control</h1>
		<hr / class="modal-divider">
		<div class="control-modal-div">
			' . $fileList . '
			<div class="clearer"></div>
		</div>
		<hr / class="modal-divider">
		<div class="control-modal-div">
			<a id="audio-control-play" href="javascript: void(2);" class="audio-control"><img src="' . BROWSER_IMAGES . 'play.png"></a>
			<a id="audio-control-stop" href="javascript: void(2);" class="audio-control"><img src="' . BROWSER_IMAGES . 'stop.png"></a>
			<a id="audio-control-repeat" href="javascript: void(2);" class="audio-control"><img src="' . BROWSER_IMAGES . 'repeat.png"></a>
			<div id="volume-controls">
				<!-- <p id="mute-volume-title" class="clearer">Mute</p> -->
				<p id="volume-title">- Volume + (<span class="volume-setting"></span>)</p>
				<!-- <input type="checkbox" id="mute-volume" class="clearer"> -->
				<!-- Old Slider
				<div id="volume-slider"></div> -->
				<!-- New slider -->
				<input value="0" id="volume-slider" class="strip-value new control-slider-1 float-left lung" data-highlight="true">		
			</div>
			<div class="clearer"></div>
		</div>
		<!-- <hr / class="modal-divider">
		<div class="control-modal-div">
			<button class="red-button modal-button apply">Apply</button>
			<button class="red-button modal-button cancel">Cancel</button>
		</div> -->
	';


	$returnVal['status'] = AJAX_STATUS_OK;
	$returnVal['html'] = $content;
	echo json_encode($returnVal);
	exit();


?>