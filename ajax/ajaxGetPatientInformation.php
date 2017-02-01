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
	
	// resize image
	$imageSizeArray = getImageSize(SERVER_SCENARIOS_PATIENTS .  $profileArray['image']);
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
			<img src="' . BROWSER_SCENARIOS_PATIENTS .  $profileArray['image'] . '" ' . $cssContent . '>			<table>
				<tr>
					<td>Species:</td>
					<td>' . $profileArray['species'] . '</td>
				</tr>
				<tr>
					<td>Breed:</td>
					<td>' . $profileArray['breed'] . '</td>
				</tr>
				<tr>
					<td>Gender:</td>
					<td>' . $profileArray['gender'] . '</td>
				</tr>
				<tr>
					<td>Weight:</td>
					<td>' . $profileArray['weight'] . '</td>
				</tr>
				<tr>
					<td>Symptoms:</td>
					<td>' . $profileArray['symptoms'] . '</td>
				</tr>
				<tr>
					<td>Description:</td>
					<td>' . $profileArray['description'] . '</td>
				</tr>
			</table>	
		</div>
	';


	$returnVal['status'] = AJAX_STATUS_OK;
	$returnVal['html'] = $content;
	echo json_encode($returnVal);
	exit();


?>