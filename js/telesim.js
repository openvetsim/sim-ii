/*
sim-ii: Copyright (C) 2019  VetSim, Cornell University College of Veterinary Medicine Ithaca, NY

See gpl.html
*/
	
	// telesim functions
	var telesim = {
		init: function() {
			// check if localStorage exists
			if( typeof(localStorage.telesim) === "undefined" ) {
				localStorage.telesim = "disabled";
			}
			this.setTeleSim( localStorage.telesim );
		},
		
		toggleTeleSim: function() {
			if( localStorage.telesim == "enabled") {
				this.setTeleSim( "disabled" );	
			} else {
				this.setTeleSim( "enabled" );
			}
		},
		
		setTeleSim: function( action ) {
			if( typeof action !== "undefined" ) {
				if( action == 'enabled' ) {
					localStorage.telesim = "enabled";
					$('.tele-sim > a').html("Disable TeleSim");
					$('.tele-sim').addClass("enabled").removeClass("disabled");
					
					// manikin and buttons
					$('#mannequin, .nvs-button').addClass("tele-sim");

					if( typeof scenario.scenarioProfile !== "undefined") {
						// avatar
						$('#mannequin').css({
							'background-size': scenario.scenarioProfile.avatar['width_pct_telesim'] + '% ' +  scenario.scenarioProfile.avatar['height_pct_telesim'] + '%'
						});
						$('#mannequin').css({
							'background-size': '50% 70%'
						});
				
						// controls
						$.each(scenario.scenarioProfile.controls.control, function() {
							$('#' + this.id).css('left', this.left_telesim + 'px');
							$('#' + this.id).css('top', this.top_telesim + 'px');
							$('#' + this.id + '-title').html(this.title).css({
																			'left': this.left_telesim + 'px',
																			'top': (parseInt(this.top_telesim) - 20).toString() + 'px',
																			});
						});
						
						// dog controls
						$("div.dog-control a.control-tele-sim").show();
						$("div.dog-control a.control-title").hide();
					}
					
				} else if( action == 'disabled' ) {
					localStorage.telesim = "disabled";
					$('.tele-sim > a').html("Enable TeleSim");
					$('.tele-sim').removeClass("enabled").addClass("disabled");
					
					// manikin
					$('#mannequin, .nvs-button').removeClass("tele-sim");
					
					if( typeof scenario.scenarioProfile !== "undefined") {
						// avatar
						$('#mannequin').css({
							'background-size': scenario.scenarioProfile.avatar['width_pct'] + '% ' +  scenario.scenarioProfile.avatar['height_pct'] + '%'
						});

						// controls
						$.each(scenario.scenarioProfile.controls.control, function() {
							$('#' + this.id).css('left', this.left + 'px');
							$('#' + this.id).css('top', this.top + 'px');
							$('#' + this.id + '-title').html(this.title).css({
																			'left': this.left + 'px',
																			'top': (parseInt(this.top) - 20).toString() + 'px',
																			});
						});
						
						// dog controls
						$("div.dog-control a.control-tele-sim").hide();
						$("div.dog-control a.control-title").show();

					}
				}			
			}			
		}	
	}