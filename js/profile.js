	var profile = {
		profileINI: '',
		init: function() {
			
			// set up background image for animal silhouette from profile
			$('#mannequin').css('background-image', 'url(' + BROWSER_PROFILES_IMAGES + profile.profileINI['settings']['imageURL'] + ')');
			
			// set positioning of controls
			for(var controlName in profile.profileINI['controls']) {
				var controlArray = profile.profileINI['controls'][controlName];
				var height = $('#' + controlArray['id']).height();
				$('#' + controlArray['id']).css('left', controlArray['left'] + 'px');
				$('#' + controlArray['id']).css('top', controlArray['top'] + 'px');
				$('#' + controlArray['id'] + '-title').html(controlArray['title']).css({
																					'left': controlArray['left'] + 'px',
																					'top': (parseInt(controlArray['top']) - 15).toString() + 'px',
																					});
			}
			
			// place title
			$('#mannequin h1').html("Profile: " + profile.profileINI['settings']['profileName']);
			$('#mannequin h1').css({
				top: profile.profileINI['title']['top'] + 'px',
				left: profile.profileINI['title']['left'] + 'px'
			});
			
		}
	}