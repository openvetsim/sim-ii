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
	$modalUnitsLabel = dbClass::valuesFromPost('ModalUnits');
	
	$content = '
		<h1 id="modal-title">' . $title . '</h1>
		<hr / class="modal-divider">
		<h2 class="modal-section-title">' . $controlTitle . ' (' . $modalUnitsLabel . ')</h2>
		<div class="control-modal-div">
			<p class="modal-input-label">Current</p>
			<p class="modal-input-label new-value">New</p>
			<a class="control-incr-decr-rate decr-rate" href="javascript: void(2);"><<</a>
			<input value="0" class="strip-value current" readonly="readonly" disabled="disabled">
			<div class="control-slider-1"></div>
			<input value="0" class="strip-value new">
			<a class="control-incr-decr-rate incr-rate" href="javascript: void(2);">>></a>
			<div class="clearer"></div>
		</div>
		<hr / class="modal-divider clearer">
		<div class="control-modal-div">
			<p class="modal-section-title">Transfer Time</p>
			<select class="transfer-time modal-select">
				' . controls::getTransferDropDown() . '
			</select>
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