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
	$eventsArray = json_decode(str_replace("\\", "", dbClass::valuesFromPost('events')), TRUE);
	if(count($eventsArray) == 0) {
		$returnVal['status'] = AJAX_STATUS_FAIL;
		echo json_encode($returnVal);
		exit();		
	}
			
	$content = '';
	$priority = array();

	// get elements of event library
	foreach($eventsArray['category'] as $eventCategory) {
		$content .= '
				<div class="event-library-col">
					<h2>' . $eventCategory['title'] . '</h2>
					<ul class="event-primary">
		';
		
		// get next level
		if(count($eventCategory) == 0) {
			$returnVal['status'] = AJAX_STATUS_FAIL;
			echo json_encode($returnVal);
			exit();		
		}
		foreach($eventCategory as $eventKey => $eventArray) {
			if($eventKey != 'event') {
				continue;
			}

			// iterate over events
			if(count($eventArray) == 0) {
				$returnVal['status'] = AJAX_STATUS_FAIL;
				echo json_encode($returnVal);
				exit();					
			}
			
			// HACK...need elements to be an array
			if(isset($eventArray[0]) === FALSE || is_array($eventArray[0]) === FALSE) {
				$eventArray[0] = array(
					'title' => $eventArray['title'],
					'id' => $eventArray['id'],
					'priority' => $eventArray['priority']
				);
				unset($eventArray['title']);
				unset($eventArray['id']);
				unset($eventArray['priority']);
			}
			
			
			foreach($eventArray as $event) {
				$content .= '
						<li>
							<img class="event-check primary" src="' . BROWSER_IMAGES . 'check.png" alt="event checkmark">
							<a data-category="' . $eventCategory['title'] . '" data-category-id="' . $eventCategory['name'] . '" data-event-id="' . $event['id'] . '" href="javascript: void(2);" onclick="events.sendEventLibraryClick(this);">' . $event['title'] . '</a>
						</li>					
				';
				
				if(isset($event['priority']) === TRUE && $event['priority'] == 1) {
					$priority[] = array(
						'title' => $event['title'],
						'id' => $event['id'],
					);
				}
			}
		}
		
		$content .= '
					</ul>
				</div>		
		';
	}

	$returnVal['status'] = AJAX_STATUS_OK;
	$returnVal['html'] = $content;
	$returnVal['priority'] = $priority;
	echo json_encode($returnVal);
	exit();
?>