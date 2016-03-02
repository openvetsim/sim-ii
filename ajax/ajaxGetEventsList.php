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
	$profileINI = $_POST['profileINI'];

	$events = array();
	// unpack events
	foreach($profileINI['eventsLib']['events'] as $key => $value) {
		$keyArray = explode(":", $key);
		if(isset($events[$keyArray[0]]) == FALSE) {
			$events[$keyArray[0]] = array();
		}
		
		// no child event
		if(isset($keyArray[2]) === FALSE) {
			$events[$keyArray[0]][$keyArray[1]] = count($events[$keyArray[0]]);
		} else {
			$events[$keyArray[0]][$keyArray[1]][$keyArray[2]] = count($events[$keyArray[0]][$keyArray[1]]);				
		}

		
	}
/*	
	// simulate event library
	$events = array('ABC' => array('Sweat' => 0,
											'Intubate' => 0,
											'Panic' => array(
																'Call for Help' => 0,
																'CPR' => 0
															),
											'Give Food' => 0
											),
					'Medicine' => array('Item 1' => 0,
											'Item 2' => 1,
											'Item 3' => array(
																'Item 4' => 0,
																'Item 5' => 1
															),
											'Item 6' => 2
											),
					'Miscellaneous' => array('Item 1' => 0,
											'Item 2' => 1,
											'Item 3' => array(
																'Item 4' => 0,
																'Item 5' => 1
															),
											'Item 6' => 2
											)
					);
*/					
	$content = '';

	// get elements of event library
	foreach($events as $eventCategory => $eventCategoryData) {
		$content .= '
				<div class="event-library-col">
					<h2>' . $eventCategory . '</h2>
					<ul class="event-primary">
		';
		
		// get next level
		foreach($eventCategoryData as $eventLink => $eventLinkData) {
			if(is_array($eventLinkData) == TRUE) {
				$content .= '
						<li>
							<a href="javascript: void(2);" class="expand">+</a>' . $eventLink . '
							<ul class="event-secondary">
					';
				foreach($eventLinkData as $eventSubLink => $eventSubLinkData) {
					$content .= '
								<li>
									<img class="event-check secondary" src="' . BROWSER_IMAGES . 'check.png" alt="event checkmark">
									<a data-category="' . $eventCategory . '" href="javascript: void(2);" onclick="events.sendEventLibraryClick(this);">' . $eventSubLink . '</a>
								</li>
					';
				}
				
				$content .= '
							</ul>
						</li>
				';
			} else {
				$content .= '
						<li>
							<img class="event-check primary" src="' . BROWSER_IMAGES . 'check.png" alt="event checkmark">
							<a  data-category="' . $eventCategory . '" href="javascript: void(2);" onclick="events.sendEventLibraryClick(this);">' . $eventLink . '</a>
						</li>					
				';
			}
		}
		
		$content .= '
					</ul>
				</div>		
		';
	}
					
/*					
					
				<div class="event-library-col">
					<h2>Title</h2>
					<ul class="event-primary">
						<li><a href="javascript: void(2);">Event</a></li>
						<li><a href="javascript: void(2);">Event</a></li>
						<li>
							<a href="javascript: void(2);" class="expand">+</a>Event Sub
							<ul class="event-secondary">
								<li><a><href="javascript: void(2);">Sub Event</a></li>
								<li><a><href="javascript: void(2);">Sub Event</a></li>
							</ul>
						</li>
						<li><a href="javascript: void(2);">Event</a></li>
					</ul>
				</div>
*/

	$returnVal['status'] = AJAX_STATUS_OK;
	$returnVal['html'] = $content;
	echo json_encode($returnVal);
	exit();
?>