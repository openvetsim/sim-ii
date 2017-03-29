var scenario = {
	currentScenarioFileName: '',
	scenarioActive: false,
	startVideoWithScenario: false,
	scenarioState: {
		STOPPED: 0,
		PAUSED: 1,
		RUNNING: 2,
		TERMINATED: 3
	},
	
	currentScenarioState: null,
	
	scenarioProfile: '',
	scenarioHeader: '',
	scenarioEvents: '',
	scenarioMedia: '',
	scenarioVocals: '',
	
	init: function() {
//		this.currentScenarioState = this.scenarioState.STOPPED;
//		simmgr.sendChange( {'set:scenario:state' : 'terminate'} );
//		scenario.stopScenario();
//console.log(this.currentScenarioState);
		
		// bind change of scenario
//		$('#scenario-select select').change(function() {
//			$('#scenario-name-display').html($(this).children('option:selected').html());
//		});
		
		// bind change of start video check box
		$('#start-video').unbind().change(function() {
			if($(this).is(':checked') == false) {
				simmgr.sendChange( {'set:scenario:record' : 0} );
			} else {
				simmgr.sendChange( {'set:scenario:record' : 1} );
			}
		});
		
		// bind click of scenario button
		$('#scenario-button').unbind().click(function() {
			scenario.sendNextScenarioState();
		});
		
		// init terminate button
		$('#scenario-terminate-button').css({'background-color': buttons.disconnectColor, 
									border: '1px solid ' + buttons.disconnectColor
									}).html('Terminate Scenario').hide();
									
		$('#scenario-terminate-button').unbind().click(function() {
			simmgr.sendChange( {'set:scenario:state' : 'Terminate'} );
		});
		
		// bind change of scenario dropdown
		$('#scenario-select select').unbind().change(function() {
			simmgr.sendChange({'set:scenario:active': $(this).children('option:selected').val()});
		});
	},
	
	// start scenario
	// send to simmgr set:scenario:active='scenario-name-no-quotes'
	// scenario will get put into 'RUNNING' state
	// set START button to PAUSE SCENARIO
	// expose TERMINATE SCENARIO BUTTON
	startScenario: function() {
		$('#scenario-button').css({'background-color': buttons.connectColor, 
									border: '1px solid ' + buttons.connectColor
									}).html('Pause1 Scenario');
		$('#scenario-terminate-button').show();
		$('#scenario-select select').prop('disabled', true);
		$('#start-video').prop('disabled', true);
		$('.profile-display.scenario img').show();
		return;
	},

	stopScenario: function() {
		$('#scenario-button').css({'background-color': buttons.disconnectColor,
									border: '1px solid ' + buttons.disconnectColor}).html('Start Scenario');
		$('#scenario-terminate-button').hide();
		$('#scenario-select select').prop('disabled', false);
		$('#start-video').prop('disabled', false);
		$('.profile-display.scenario img').hide();
		return;
	},
	
	pauseScenario: function() {
		$('#scenario-button').css({'background-color': buttons.disconnectColor,
									border: '1px solid ' + buttons.disconnectColor}).html('Continue Scenario');
		$('#scenario-terminate-button').show();
		$('#scenario-select select').prop('disabled', true);
		$('#start-video').prop('disabled', true);
		$('.profile-display.scenario img').hide();
		return;	
	},

	continueScenario: function() {
		$('#scenario-button').css({'background-color': buttons.connectColor, 
									border: '1px solid ' + buttons.connectColor
									}).html('Pause Scenario');
		$('#scenario-terminate-button').show();
		$('#scenario-select select').prop('disabled', true);
		$('#start-video').prop('disabled', true);
		$('.profile-display.scenario img').show();
		return;
	},
	
	sendNextScenarioState: function() {
		switch(this.currentScenarioState) {
			// if stopped, send currently selected scenario
			case this.scenarioState.STOPPED:
				simmgr.sendChange( {'set:scenario:state' : 'Running'} );
				break;
			
			// if paused, send running
			case this.scenarioState.PAUSED:
				simmgr.sendChange( {'set:scenario:state' : 'Running'} );
				break;

			// if running, send paused
			case this.scenarioState.RUNNING:
				simmgr.sendChange( {'set:scenario:state' : 'Paused'} );
				break;
		}
	},
	
	loadScenario: function() {
		$.ajax({
			url: BROWSER_AJAX + 'ajaxGetScenario.php',
			type: 'post',
			async: false,
			data: {fn: scenario.currentScenarioFileName},
			dataType: 'json',
			success: function(response) {
				scenario.scenarioProfile = response.profile;
				scenario.scenarioHeader = response.header;
				scenario.scenarioEvents = response.events;
				scenario.scenarioMedia = response.media;
				scenario.scenarioVocals = response.vocals;

				// update scenario dropdown if needed
				$('#scenario-select select').val(scenario.currentScenarioFileName);
			}
		});
	}	
}