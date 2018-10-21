<?php

	// init
	require_once("../init.php");
	$returnVal = array();

	// is user logged in
	if(adminClass::isUserLoggedIn() === FALSE) {
		if ( SERVER_ADDR != REMOTE_ADDR )
		{
			$returnVal['status'] = AJAX_STATUS_LOGIN_FAIL;
			$returnVal['cause'] = "No login";
			echo json_encode($returnVal);
			exit();
		}
	}
	
	$profileArray = $_POST['profile'];
	$directory = dbClass::valuesFromPost('dir');
	
	// resize image
	$imageSizeArray = getImageSize(SERVER_SCENARIOS . $directory . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR .  $profileArray['image']);
	if($imageSizeArray !== FALSE) {
		// check width, max = 300px
		if($imageSizeArray[0] >= $imageSizeArray[1]) {
			$cssContent = ' style="width: 138px" ';
		} else {
			$cssContent = ' style="height: 138px" ';		
		}
	}
	
	$content = '
		<div id="patient-info">
			<h1>Patient Information</h1>
			<img src="' . BROWSER_SCENARIOS . $directory . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR .  $profileArray['image'] . '" ' . $cssContent . '>
			<table>
	';
	if(isset($profileArray['species']) === TRUE) {
		$content .= '
				<tr>
					<td>Species:</td>
					<td>' . $profileArray['species'] . '</td>
				</tr>
		';
	}
	if(isset($profileArray['breed']) === TRUE) {
		$content .= '
				<tr>
					<td>Breed:</td>
					<td>' . $profileArray['breed'] . '</td>
				</tr>
		';
	}
	if(isset($profileArray['age']) === TRUE) {
		$content .= '
				<tr>
					<td>Age:</td>
					<td>' . $profileArray['age'] . '</td>
				</tr>
		';
	}
	if(isset($profileArray['sex']) === TRUE) {
		$content .= '
				<tr>
					<td>Sex:</td>
					<td>' . $profileArray['sex'] . '</td>
				</tr>
		';
	}
	if(isset($profileArray['weight']) === TRUE) {
		$content .= '
				<tr>
					<td>Weight:</td>
					<td>' . $profileArray['weight'] . '</td>
				</tr>
		';
	}
	if(isset($profileArray['complaint']) === TRUE) {
		$content .= '
				<tr>
					<td>Complaint:</td>
					<td>' . $profileArray['complaint'] . '</td>
				</tr>
		';
	}
	if(isset($profileArray['description']) === TRUE) {
		$content .= '
				<tr>
					<td>Description:</td>
					<td>' . $profileArray['description'] . '</td>
				</tr>
		';
	}
	$content .= '
			</table>	
		</div>
	';


	$returnVal['status'] = AJAX_STATUS_OK;
	$returnVal['html'] = $content;
	echo json_encode($returnVal);
	exit();


?>