var scenario = {
	currentScenarioURL: 'default.sce',
	scenarioActive: false,
	startVideoWithScenario: false,
	
	init: function() {
		scenario.setScenarioState(false);

		// bind event of scenario button
		$('#scenario-button').click(function() {
			if(scenario.scenarioActive == true) {
				scenario.stopScenario();
			} else {
				scenario.startScenario();			
			}
		});
		
		// bind change of scenario
		$('#scenario-select select').change(function() {
			$('#scenario-name-display').html($(this).children('option:selected').html());
		});
		
		// bind change of start video check box
		$('#start-video').change(function() {
			if($(this).is(':checked') == false) {
				scenario.startVideoWithScenario = false;			
			} else {
				scenario.startVideoWithScenario = true;
			}
		});
	},
	
	startScenario: function() {
		$('#scenario-button').css({'background-color': buttons.connectColor, 
									border: '1px solid ' + buttons.connectColor
									}).html('Stop Scenario');
		scenario.scenarioActive = true;
		$('#scenario-select select').prop('disabled', true);
		$('#start-video').prop('disabled', true);
		$('.profile-display.scenario img').show();
		/* code stub for SimMgr */
		return;
	},

	stopScenario: function() {
		$('#scenario-button').css({'background-color': buttons.disconnectColor,
									border: '1px solid ' + buttons.disconnectColor}).html('Start Scenario');
		scenario.scenarioActive = false;
		$('#scenario-select select').prop('disabled', false);
		$('#start-video').prop('disabled', false);
		$('.profile-display.scenario img').hide();
		/* code stub for SimMgr */
		return;
	},

	setScenarioState: function(scenarioState) {
		if(scenarioState == true) {
			scenario.startScenario();
		} else {
			scenario.stopScenario();
		}
	}
}