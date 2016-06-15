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
	$chestRiseActive = dbClass::valuesFromPost('ChestRise');
	$chestRiseOffSelect = ($chestRiseActive == 'false') ? ' selected="selected" ' : '';
	$chestRiseOnSelect = ($chestRiseActive == 'true') ? ' selected="selected" ' : '';
	$content = '
		<h1 id="modal-title">' . $title . '</h1>
		<hr / class="modal-divider">
		<h2 class="modal-section-title">' . $controlTitle . '</h2>
		<div class="control-modal-div">
			<select class="chest-rise modal-select">
				<option value="false"' . $chestRiseOffSelect . '>Chest Rise Off</option>
				<option value="true"' . $chestRiseOnSelect . '>Chest Rise On</option>
			</select>
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