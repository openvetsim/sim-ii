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
	
	$title = dbClass::valuesFromPost('ModalTitle');
	
	$content = '
		<h1 id="modal-title">' . $title . '</h1>
		<hr / class="modal-divider">
		<h2 class="modal-section-title">Systolic (mmHg)</h2>
		<div class="control-modal-div">
			<p class="modal-input-label">Current</p>
			<p class="modal-input-label new-value">New</p>
			<a class="control-incr-decr-rate decr-rate systolic" href="javascript: void(2);"><<</a>
			<input value="0" class="strip-value current systolic" readonly="readonly" disabled="disabled">
			<div class="control-slider-1 systolic"></div>
			<input value="0" class="strip-value new systolic">
			<a class="control-incr-decr-rate incr-rate systolic" href="javascript: void(2);">>></a>
			<div class="clearer"></div>
		</div>
		<hr / class="modal-divider clearer">
		<h2 class="modal-section-title">Diastolic (mmHg)</h2>
		<div class="control-modal-div">
			<p class="modal-input-label">Current</p>
			<p class="modal-input-label new-value">New</p>
			<a class="control-incr-decr-rate decr-rate diastolic" href="javascript: void(2);"><<</a>
			<input value="0" class="strip-value current diastolic" readonly="readonly" disabled="disabled">
			<div class="control-slider-1 diastolic"></div>
			<input value="0" class="strip-value new diastolic">
			<a class="control-incr-decr-rate incr-rate diastolic" href="javascript: void(2);">>></a>
			<div class="clearer"></div>
		</div>
		<div class="control-modal-div">
			<span id="nbp-control-coupled-title">Link BP Controls</span>
			<input type="checkbox" id="nbp-control-coupled" name="nbp-control-coupled">
		</div>
		<hr / class="modal-divider clearer">
		
		<h2 class="modal-section-title">NBP Reported HR (BPM)</h2>
		<div class="control-modal-div">
			<p class="modal-input-label">Current</p>
			<p class="modal-input-label new-value">New</p>
			<a class="control-incr-decr-rate decr-rate linked-hr" href="javascript: void(2);"><<</a>
			<input value="0" class="strip-value current linked-hr" readonly="readonly" disabled="disabled">
			<div class="control-slider-1 linked-hr"></div>
			<input value="0" class="strip-value new linked-hr">
			<a class="control-incr-decr-rate incr-rate linked-hr" href="javascript: void(2);">>></a>
			<div class="clearer"></div>
		</div>
		<div class="control-modal-div">
			<span id="nbp-control-coupled-title-hr">Link NBP HR to Main HR</span>
			<input type="checkbox" id="nbp-control-coupled-hr" name="nbp-control-coupled-hr">
		</div>

		<hr / class="modal-divider">
		<div class="control-modal-div">
			<div class="sub-control">
				<p class="modal-section-title">Transfer Time</p>
				<select class="transfer-time modal-select">
					' . controls::getTransferDropDown() . '
				</select>
			</div>
			<div class="sub-control">
				<p class="modal-section-title">NIBP Read Time</p>
				<select class="read-time modal-select">
					<option value="0">Manual</option>
					<option value="3">3 minutes</option>
					<option value="5">5 minutes</option>
					<option value="10">10 minutes</option>
					<option value="15">15 minutes</option>
				</select>
			</div>
		</div>
		<div class="clearer"></div>
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