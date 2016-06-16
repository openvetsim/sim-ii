/* 
	simmgr Communications

	There are two basic modes for ythis class:
	
	After init, this class will poll the simmgr via AJAX to
	fetch parameter changes for display. It will push sync
	signals to the EKG and Respiration strip charts.
	
	The AJAX call is to the cgi function: simstatus.cgi
*/

var simmgr = {
	timer : 0,
	breathCount : 0,
	pulseCount : 0,
	interval : 500,
	running : 0,
	
	init : function() {
		console.log("simmgr: init" );
		// Set the interval faster if the client is the local vitals display
		if ( simmgr.isLocalDisplay() )
		{
			simmgr.interval = 50;
		}
		else
		{
			simmgr.interval = 500;
		}
		simmgr.timer = setTimeout(function() { simmgr.getStatus(); }, simmgr.interval );
		simmgr.running = 1;
		
		// bind demo button to start and stop polling of sim mgr
		$("#startStopButton").click(function(){
			var txt = $(this).text();
			if ( txt == "Start Status Updates" )
			{
				simmgr.running = 1;
				simmgr.timer = setTimeout(function() { simmgr.getStatus(); }, simmgr.interval );
				$(this).text("Stop Status Updates");
			}
			else
			{
				simmgr.running = 0;
				clearTimeout(simmgr.timer );
				$(this).text("Start Status Updates");
			}
		});
	},
	
	getStatus : function () {
		$.ajax({
			url: BROWSER_CGI + 'simstatus.cgi',
			type: 'get',
			dataType: 'json',
			data: { status: 1 },
			success: function(response,  textStatus, jqXHR ) {
				if ( simmgr.isLocalDisplay() )
				{
					if ( response.respiration.breathCount != simmgr.breathCount )
					{
						simmgr.breathCount  = response.respiration.breathCount;
						controls.awRR.setSynch();
					}
					if ( response.cardiac.pulseCount != simmgr.pulseCount )
					{
						simmgr.pulseCount = response.cardiac.pulseCount;
						controls.heartRate.setSynch();
					}
				}
				
				/************ cardiac **************/
				if ( typeof(response.cardiac) != "undefined" )
				{
					// cardiac rate
					if ( ( typeof(response.cardiac.rate) != "undefined" ) && ( response.cardiac.rate != controls.heartRate.value ) )
					{
						controls.heartRate.setHeartRateValue(response.cardiac.rate );
						chart.updateCardiac(response.cardiac );
					}
					
					// cardiac nbp
					if ( ( typeof(response.cardiac.bps_sys) != "undefined" ) && ( response.cardiac.bps_dia != "undefined" ) )
					{
						controls.nbp.diastolicValue = response.cardiac.bps_dia;
						controls.nbp.systolicValue = response.cardiac.bps_sys;
						controls.nbp.reportedHRValue = response.cardiac.nibp_rate;
						controls.nbp.updateDisplayedNBP();
					}
					
					// ekg indicator
					if(typeof(response.cardiac.ecg_indicator) != "undefined") {
						var changed = false;
						if( response.cardiac.ecg_indicator == 1) {
							if ( controls.ekg.leadsConnected == false ) {
								changed = true;
							}
							controls.ekg.leadsConnected = true;
						} else {
							if ( controls.ekg.leadsConnected == true ) {
								changed = true;
							}
							controls.ekg.leadsConnected = false;					
						}
						if ( changed ) {
							controls.heartRate.displayValue();
						}
						buttons.setVSButton('ekg');
					}

					/***** heart sounds *****/
					// heart sound name
					if(typeof(response.cardiac.heart_sound) != "undefined") {
						controls.heartSound.soundName = response.cardiac.heart_sound;
					}

					// heart sound name
					if(typeof(response.cardiac.heart_sound_mute) != "undefined") {
						// change value only if necessary
						if(response.cardiac.heart_sound_mute == 1 && controls.heartSound.mute == false) {
							controls.heartSound.mute = true;
							$('#heart-sound-mute').show();
						} else if(response.cardiac.heart_sound_mute == 0 && controls.heartSound.mute == true) {
							controls.heartSound.mute = false;							
							$('#heart-sound-mute').hide();
						}
					}
					
					// heart sound volume
					if(typeof(response.cardiac.heart_sound_volume) != "undefined") {
						controls.heartSound.value = response.cardiac.heart_sound_volume;
					}
					
					// pulse strength
					if(typeof(response.cardiac.pulse_strength) != "undefined") {
						controls.pulseStrength.value = response.cardiac.pulse_strength;
					}
					
					/***** heart rhythm *****/
					// heart ecg pattern selection
					if(typeof(response.cardiac.rhythm) != "undefined") {
						controls.heartRhythm.currentRhythm = response.cardiac.rhythm;
					}
					
					// heart pea
					if(typeof(response.cardiac.pea) != "undefined") {
						controls.heartRhythm.pea = (response.cardiac.pea == 1) ? true : false;
					}
					
					// heart vpc
					if(typeof(response.cardiac.vpc) != "undefined") {
						controls.heartRhythm.vpc = response.cardiac.vpc;
					}
					
					// heart vfib amplitude
					if(typeof(response.cardiac.vfib_amplitude) != "undefined") {
						controls.heartRhythm.vfibAmplitude = response.cardiac.vfib_amplitude;
					}
					
					// heart vpc frequency
					if(typeof(response.cardiac.vpc_freq) != "undefined") {
						controls.heartRhythm.vpcFrequency = response.cardiac.vpc_freq;
					}
					
					
				}
				
				/************ general **************/
				// temperature Tperi
				if ( ( typeof(response.general) != "undefined" ) && ( typeof(response.general.temperature) != "undefined" ) )
				{
					var temperature = response.general.temperature / 10;
					if ( temperature != controls.Tperi.value )
					{
						controls.Tperi.setValue(temperature );
						controls.Tperi.displayValue();
					}
				}
				
				/************ vocals **************/
				if(typeof(response.vocals) != "undefined" ) {
					// filename
					if(typeof(response.vocals.filename) != "undefined") {
						controls.vocals.fileName = response.vocals.filename;
					}
					
					// repeat
					if(typeof(response.vocals.repeat) != "undefined" && response.vocals.repeat == 1) {
						controls.vocals.repeat = true;
						controls.vocals.displayRepeat();
					} else {
						controls.vocals.repeat = false;					
						controls.vocals.displayRepeat();
					}
					
					// mute
					if(typeof(response.vocals.mute) != "undefined") {
						if(response.vocals.mute == 1) {
							controls.vocals.mute = true;
						} else {
							controls.vocals.mute = false;					
						}
						controls.vocals.displayMute();
					}
					
					// volume
					if(typeof(response.vocals.volume) != "undefined") {
						controls.vocals.value = response.vocals.volume;
					}
				}
				
				/************ respiration **************/
				if(typeof(response.respiration) != "undefined" ) {
					// awRR
					if(typeof(response.respiration.rate) != "undefined") {
						var respirationRate = response.respiration.rate;
						if(respirationRate != controls.awRR.value) {
							controls.awRR.value = response.respiration.rate;
							controls.awRR.displayValue();
						}
					}
					
					// spo2
					if(typeof(response.respiration.spo2) != "undefined") {
						var spo2Rate = response.respiration.spo2;
						if ( spo2Rate != controls.SpO2.value )
						{
							controls.SpO2.value = response.respiration.spo2;
							controls.SpO2.displayValue();
						}
					}

					// etco2
					if (typeof(response.respiration.etco2) != "undefined") {
						var etCO2Rate = response.respiration.etco2;
						if(etCO2Rate != controls.etCO2.value) {
							controls.etCO2.value = response.respiration.etco2;
							controls.etCO2.displayValue();
						}
					}
					
					// etco2 indicator
					if(typeof(response.respiration.etco2_indicator) != "undefined") {
						var changed = false;
						if( response.respiration.etco2_indicator == 1) {
							if ( controls.CO2.leadsConnected == false ) {
								changed = true;
							}
							controls.CO2.leadsConnected = true;
						} else {
							if ( controls.CO2.leadsConnected == true ) {
								changed = true;
							}
							controls.CO2.leadsConnected = false;					
						}
						if ( changed ) {
							controls.awRR.displayValue();
							controls.etCO2.displayValue();
						}
						buttons.setVSButton('CO2');
					}
					
					// spo2 indicator
					if(typeof(response.respiration.spo2_indicator) != "undefined") {
						var changed = false;
						if( response.respiration.spo2_indicator == 1) {
							if ( controls.SpO2.leadsConnected == false ) {
								changed = true;
							}
							controls.SpO2.leadsConnected = true;
						} else {
							if ( controls.SpO2.leadsConnected == true ) {
								changed = true;
							}
							controls.SpO2.leadsConnected = false;					
						}
						if ( changed ) {
							controls.SpO2.displayValue();
						}
						buttons.setVSButton('SpO2');
					}
					
					/***** Left Lung *****/
					// left lung sound
					if(typeof(response.respiration.left_lung_sound) != "undefined") {
						controls.leftLung.fileName = response.respiration.left_lung_sound;
					}
					
					// left lung mute
					if(typeof(response.respiration.left_lung_sound_mute) != "undefined") {
						if(response.respiration.left_lung_sound_mute == 1) {
							controls.leftLung.mute = true;
							$('#left-lung-mute').show();
						} else {
							controls.leftLung.mute = false;
							$('#left-lung-mute').hide();						
						}
					}
					
					// left lung volume
					if(typeof(response.respiration.left_lung_sound_volume) != "undefined") {
						controls.leftLung.value = response.respiration.left_lung_sound_volume;
					}
					
					/***** Right Lung *****/
					// right lung sound
					if(typeof(response.respiration.right_lung_sound) != "undefined") {
						controls.rightLung.fileName = response.respiration.right_lung_sound;
					}
					
					// right lung mute
					if(typeof(response.respiration.right_lung_sound_mute) != "undefined") {
						if(response.respiration.right_lung_sound_mute == 1) {
							controls.rightLung.mute = true;
							$('#right-lung-mute').show();
						} else {
							controls.rightLung.mute = false;
							$('#right-lung-mute').hide();						
						}
					}
					
					// right lung volume
					if(typeof(response.respiration.right_lung_sound_volume) != "undefined") {
						controls.rightLung.value = response.respiration.right_lung_sound_volume;
					}
					
					// chest movement
					if(typeof(response.respiration.chest_movement) != "undefined" && response.respiration.chest_movement == 1) {
						controls.chestRise.active = true;
					} else {
						controls.chestRise.active = false;					
					}

				}

				/************ scenario **************/
				if( typeof(response.scenario) != '"undefined"' ) {
					if(typeof(response.scenario.runtime) != "undefined" ) {
						$('#scenario-running-time').html(response.scenario.runtime);
					}
					
					// scenario state
					if(typeof response.scenario.state != "undefined") {
						// normalize result, see if there was a change
						var newScenarioState = response.scenario.state.toUpperCase();
						if(scenario.currentScenarioState != scenario.scenarioState[newScenarioState]) {
							switch(newScenarioState) {
								case 'STOPPED':
									scenario.currentScenarioState = scenario.scenarioState.STOPPED;
									scenario.stopScenario();
									break;
								
								case 'PAUSED':
									scenario.currentScenarioState = scenario.scenarioState.PAUSED;
									scenario.pauseScenario();
									break;
								
								case 'RUNNING':
									scenario.currentScenarioState = scenario.scenarioState.RUNNING;
									scenario.continueScenario();
									break;
								
								default:
									break;
							}
						}
					}
				}
			},
			
			error: function( jqXHR,  textStatus,  errorThrown){
				console.log("error: "+textStatus+" : "+errorThrown );
			},
			complete: function(jqXHR,  textStatus ){
				if ( simmgr.running == 1 )
				{
					simmgr.timer = setTimeout(function() { simmgr.getStatus(); }, simmgr.interval );
				}
			}
		});			
	},
	
	// Generic routine to change Instructor parameters. 'data' is an array of parameters and values
	sendChange : function (data ) {
		$.ajax({
			url: BROWSER_CGI + 'simstatus.cgi',
			type: 'get',
			dataType: 'json',
			data: data,
			success: function(response,  textStatus, jqXHR ) {
				
			},
			error: function( jqXHR,  textStatus,  errorThrown){
				console.log("error: "+textStatus+" : "+errorThrown );
			}
		});			
	},
	
	isLocalDisplay: function()
	{
		return ( SERVER_ADDR == REMOTE_ADDR );
	}
	
}
