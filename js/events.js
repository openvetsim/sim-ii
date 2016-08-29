	var events = {
		currentLogRecord: 1,
		currentLogFileName: '',
		defaultComment: 'Please enter comment for log',
		
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
					
					// remove previous events
					$('.event-priority').remove();
					
					// get priority events if any
					if(response.priority.length > 0) {
						var content = '<li class="event-priority event-divider">|</li><li class="event-priority">Quick Event Links:</li>';
						response.priority.forEach(function(element, index, event) {
							content += '<li class="event-priority"><a class="event-link" href="javascript: void(2);" onclick="events.sendPriorityEvent(\'' + element.id + '\');">' + element.title + '</a></li>';
						});
						$('ul#main-nav li.menu-events').after(content);
					}
					
				}
			});
						
			// force event monitor to scroll to bottom and hide div for modal
			$("#event-monitor").scrollTop(1000);
			
			// bind comments
			$('#comment-input').unbind().focus(function() {
				if($(this).val() == events.defaultComment) {
					$(this).val('');
				}
			});
			
			$('#comment-button').unbind().click(function() {
				if($('#comment-input').val() == '' || $('#comment-input').val() == events.defaultComment) {
					modal.showText('Please enter a comment');
				} else {
					simmgr.sendChange({'set:event:comment': $('#comment-input').val()});
				}
				$('#comment-input').val(events.defaultComment);
			});
		},
		
		sendEventLibraryClick: function(eventObj) {
			$(eventObj).prev('img').show();
//			$('#event-monitor table').append('<tr><td class="time-stamp">00:02:00</td><td class="event">Event: ' + $(eventObj).attr('data-category') + ':' + $(eventObj).html() + '</td></tr>');
//			$("#event-monitor").scrollTop($('#event-monitor table').height());
			
			// code stub to send event to sim mgr
			simmgr.sendChange({'set:event:event_id': $(eventObj).attr('data-event-id')});
			modal.closeModal();
		},
		
		sendPriorityEvent: function(eventID) {
			// code stub to send event to sim mgr
			simmgr.sendChange({'set:event:event_id': eventID});
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