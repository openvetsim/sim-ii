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
	
	// get list of scenarios and descriptions
	$scenarioDirs = scandir(SERVER_SCENARIOS);
	$scenarioList = array();
	foreach($scenarioDirs as $scenarioDir) {
		if(is_dir(SERVER_SCENARIOS . $scenarioDir) === true && $scenarioDir != '.' && $scenarioDir != '..' && $scenarioDir != '.git') {
			$scenarioList[] = $scenarioDir;
		}
	}
	
	// generate content
	$content = '
		<h2 id="user-table-title">Manage Scenarios</h2>
		
		<h2 id="scenario-add">Add / Update Scenario (.zip archive only)</h2>
		<form class="clearer" id="scenario-select" method="post" action="ii.php" enctype="multipart/form-data">
			<input name="scenario-file-select" id="scenario-file-select" type="file" value="" accept=".zip">
			<input name="scenario-submit" type="submit" id="scenario-submit" style="visibility: hidden;">
		</form>
		
		<table id="user-table" class="scenario">
			<tr>
				<td class="scenario user-header col-200">Scenario Name</td>
				<td class="scenario user-header col-200">Scenario Dir</td>
				<td class="user-header scenario col-300">Description</td>
				<td class="user-header  col-150">Date Created</td>
				<td class="user-header col-150">&nbsp;</td>
			</tr>
	';
	
	$scenarioNameArray = array();
	foreach($scenarioList as $scenarioDir) {
		$fileName = $scenarioDir . DIRECTORY_SEPARATOR . 'main';
		$scenarioHeaderArray = scenarioXML::getScenarioHeaderArray($fileName);
		$scenarioNameArray[$scenarioHeaderArray['title']['name']] = $scenarioDir;
	}
	ksort($scenarioNameArray);

	foreach($scenarioNameArray as $scenarioName => $scenarioDir) {
		$fileName = $scenarioDir . DIRECTORY_SEPARATOR . 'main';
		$scenarioHeaderArray = scenarioXML::getScenarioHeaderArray($fileName);
		
		$content .= '
			<tr>
				<td class="scenario col-200">' . $scenarioHeaderArray['title']['name'] . '</td>
				<td class="scenario col-200">' . $scenarioDir . '</td>
				<td class="col-300 scenario">' . $scenarioHeaderArray['description'] . '</td>
				<td class="col-150 ">' . $scenarioHeaderArray['date_of_creation'] . '</td>
				<td class="col-150"><a href="javascript: void(2);" onclick="scenario.deleteScenario(\'' . $scenarioDir . '\');">Delete Scenario</a></td>
			</tr>
		';
	}
	
	$content .= '
		</table>
	';

	$returnVal['status'] = AJAX_STATUS_OK;
	$returnVal['html'] = $content;
	echo json_encode($returnVal);
	exit();
?>