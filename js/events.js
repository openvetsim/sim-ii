	var events = {
		init: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetEventsList.php',
				type: 'post',
				async: false,
				dataType: 'json',
				data: {profileINI: profile.profileINI},
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
		}
	}