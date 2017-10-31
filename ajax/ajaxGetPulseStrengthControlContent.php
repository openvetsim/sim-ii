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
	
	$pulseStrength = dbClass::valuesFromPost('PulseStrength');
	$side = dbClass::valuesFromPost('s');
	$pulseType = dbClass::valuesFromPost('p');
	
	if($side != 'left' && $side != 'right') {
		$side = 'left';
	}
	if($pulseType != 'femoral' && $pulseType != 'dorsal') {
		$pulseType = 'femoral';
	}

	$content = '
		<h1 id="modal-title">' . ucfirst($side) . ' ' . ucfirst($pulseType) . ' Pulse Control</h1>
		<hr / class="modal-divider">
		<h2 class="modal-section-title">Pulse Strength</h2>
		<div class="control-modal-div pulse-strength">
			<p class="modal-section-title pulse-strength-label clearer">None</p>
			<p class="modal-section-title pulse-strength-label">Weak</p>
			<p class="modal-section-title pulse-strength-label">Medium</p>
			<p class="modal-section-title pulse-strength-label">Strong</p>
			<input type="radio" name="pulse-strength" class="modal-radio pulse-strength clearer" value="none">
			<input type="radio" name="pulse-strength" class="modal-radio pulse-strength" value="weak">
			<input type="radio" name="pulse-strength" class="modal-radio pulse-strength" value="medium">
			<input type="radio" name="pulse-strength" class="modal-radio pulse-strength" value="strong">
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