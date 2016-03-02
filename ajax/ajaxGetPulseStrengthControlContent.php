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
	$controlTitle = dbClass::valuesFromPost('ControlTitle');
	$pulseStrength = dbClass::valuesFromPost('PulseStrength');

	$content = '
		<h1 id="modal-title">' . $title . '</h1>
		<hr / class="modal-divider">
		<h2 class="modal-section-title">' . $controlTitle . '</h2>
		<div class="control-modal-div pulse-strength">
			<p class="modal-section-title pulse-strength-label clearer">None</p>
			<p class="modal-section-title pulse-strength-label">Weak</p>
			<p class="modal-section-title pulse-strength-label">Medium</p>
			<p class="modal-section-title pulse-strength-label">Strong</p>
			<input type="radio" name="pulse-strength" class="modal-radio pulse-strength clearer" value="None">
			<input type="radio" name="pulse-strength" class="modal-radio pulse-strength" value="Weak">
			<input type="radio" name="pulse-strength" class="modal-radio pulse-strength" value="Medium">
			<input type="radio" name="pulse-strength" class="modal-radio pulse-strength" value="Strong">
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