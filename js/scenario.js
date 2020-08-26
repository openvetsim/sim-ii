/*
sim-ii: Copyright (C) 2019  VetSim, Cornell University College of Veterinary Medicine Ithaca, NY

See gpl.html
*/
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
console.log("Scenario Init");		
console.log("Current Scenario State: " + this.currentScenarioState);		
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
									}).html('Terminate Scenario');
		if(scenario.currentScenarioState == scenario.scenarioState.STOPPED) {
			$('#scenario-terminate-button').hide();
		}
									
		$('#scenario-terminate-button').unbind().click(function() {
			simmgr.sendChange( {'set:scenario:state' : 'Terminate'} );
		});
		
		// bind change of scenario dropdown
		$('#scenario-select select').unbind().change(function() {
			simmgr.sendChange({'set:scenario:active': $(this).children('option:selected').val()});
		});
		
		$('#scenario-select select option').unbind().click(function(evt) {
			var newScenarioFileName = $(this).val();
			if(newScenarioFileName == scenario.currentScenarioFileName) {
				simmgr.sendChange({'set:scenario:active': 'blank'});
				setTimeout(function() {
					simmgr.sendChange({'set:scenario:active': newScenarioFileName});
				}, 1000);
			}
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
				if ( typeof(response.soundtags) !== 'undefined' )
				{
					scenario.soundtags = response.soundtags;
					if ( typeof(simsound) !== 'undefined' )
					{
						simsound.parseTags();
					}
				}
				
				if( typeof(response.telesim) !== 'undefined' ) {
					scenario.telesim = response.telesim;
				}
				// update scenario dropdown if needed
				$('#scenario-select select').val(scenario.currentScenarioFileName);
			}
		});
	},

	deleteScenario: function(scenarioDir) {
/*
		if ( userID == 5 )
		{
			alert("Delete is not allowed from Demo" );
		}
		else
		{
*/
			if(confirm("Are you sure you want to delete this scenario?") == true) {
				window.location = "ii.php?ddir=" + scenarioDir;
			}
//		}
	},
	
	addScenario: function(scenarioDir) {
/*		if ( userID == 5 )
		{
			alert("Add is not allowed from Demo" );
		}
		else
		{
*/
			$.ajax({
				url: BROWSER_AJAX + 'ajaxAddScenario.php',
				type: 'post',
				async: false,
				data: {sd: scenarioDir},
				dataType: 'json',
				success: function(response) {
					window.location = "ii.php?ddir=x...";
				}
			});
//		}
	}
}