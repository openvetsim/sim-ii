	var profile = {
		init: function() {
			// set up background image for animal silhouette from profile
			$('#mannequin').css('background-image', 'url(' + BROWSER_PROFILES_IMAGES + scenario.scenarioProfile['filename'] + ')');
		
			// set positioning of controls
			$.each(scenario.scenarioProfile.controls.control, function() {
				var height = $('#' + this.id).height();
				$('#' + this.id).css('left', this.left + 'px');
				$('#' + this.id).css('top', this.top + 'px');
				$('#' + this.id + '-title').html(this.title).css({
																'left': this.left + 'px',
																'top': (parseInt(this.top) - 20).toString() + 'px',
																});
			});

			// place title
			$('#mannequin h1').html("Scenario: " + scenario.scenarioHeader.title.name);
			$('#mannequin h1').css({
				top: scenario.scenarioHeader.title.top + 'px',
				left: scenario.scenarioHeader.title.left + 'px'
			});
			
			// update header
			$('#scenario-name-display').html(scenario.scenarioHeader.title.name);		
			
		}
	}