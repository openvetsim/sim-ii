	var events = {
		currentLogRecord: 1,
		currentLogFileName: '',
		
		init: function() {
			// set up list of events for this scenario into modal
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetEventsList.php',
				type: 'post',
				async: false,
				dataType: 'json',
				data: {events: JSON.stringify(scenario.scenarioEvents)},
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						$('#event-library').html(response.html).hide();

						// bind expansion of event library
						$('a.expand').click(function() {
							if($(this).hasClass('expanded') == true) {
								$(this).html('+').removeClass('expanded');
								$(this).next('ul').hide();
							} else {
								$(this).html("-").addClass('expanded');
								$(this).next('ul').show();					
							}
						});
					}
				}
			});
						
			// force event monitor to scroll to bottom and hide div for modal
			$("#event-monitor").scrollTop(1000);
		},
		
		sendEventLibraryClick: function(eventObj) {
			$(eventObj).prev('img').show();
			$('#event-monitor table').append('<tr><td class="time-stamp">00:02:00</td><td class="event">Event: ' + $(eventObj).attr('data-category') + ':' + $(eventObj).html() + '</td></tr>');
			$("#event-monitor").scrollTop($('#event-monitor table').height());
			
			// code stub to send event to sim mgr
		},
		
		addEventsFromLog: function() {
			// set up list of events for this scenario into modal
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetEventsLog.php',
				type: 'post',
				async: false,
				dataType: 'json',
				data: {fileName: events.currentLogFileName, recordCount: events.currentLogRecord},
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						$('#event-monitor table').html(response.html);
					}
				}
			});
		}
		
	}