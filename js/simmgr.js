/* 
	simmgr Communications

	There are two basic modes for this class:
	
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
	audioPlayStarted : 0,
	mediaPlayStarted : 0,
	timeStamp: 0,
	
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
		
		// This call will periodically tap the server to prevent PHP session timeouts.
		simmgr.tapHost();
	},
	
	getStatus : function () {
		// get unique time stamp
		simmgr.timeStamp = new Date().getTime();
		
		$.ajax({
			url: BROWSER_CGI + 'simstatus.cgi',
			type: 'get',
			dataType: 'json',
			data: { status: simmgr.timeStamp },
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
						if(response.cardiac.rhythm == 'vtach3') {
							// pre calculate R on T based on heart rate
							chart.initVtach3();
						}
						
						chart.updateCardiac(response.cardiac );
					}
					
					// cardiac nbp
					if ( ( typeof(response.cardiac.bps_sys) != "undefined" ) && ( response.cardiac.bps_dia != "undefined" ) )
					{
						controls.nbp.diastolicValue = response.cardiac.bps_dia;
						controls.nbp.systolicValue = response.cardiac.bps_sys;
						controls.nbp.reportedHRValue = response.cardiac.nibp_rate;
						
						// only update reading when requested.
						//controls.nbp.updateDisplayedNBP();
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

					// bp cuff
					if(typeof(response.cardiac.bp_cuff) != "undefined") {
						if( response.cardiac.bp_cuff == 1) {
							controls.bpcuff.leadsConnected = true;
							$('#button-nbp').show();
						} else {
							controls.bpcuff.leadsConnected = false;					
							$('#button-nbp').hide();
						}
						buttons.setVSButton('bpcuff');
					}
					
					// read nibp
					if(typeof(response.cardiac.nibp_read) != "undefined" && controls.bpcuff.leadsConnected == true) {
						if( response.cardiac.nibp_read == 1) {
							$('#button-nbp').css('background-color', buttons.disconnectColor);
						} else {
							$('#button-nbp').css('background-color', buttons.connectColor);							
						}
						
						if(response.cardiac.nibp_read != controls.nbp.nibp_read) {
							controls.nbp.nibp_read = response.cardiac.nibp_read;
							controls.nbp.updateDisplayedNBP();
						}
					}
					
					// nibp frequency
					if(typeof(response.cardiac.nibp_freq) != "undefined") {
						controls.nbp.nibp_freq = response.cardiac.nibp_freq;
					}
					
					/***** heart sounds *****/
					// heart sound name
					if(typeof(response.cardiac.heart_sound) != "undefined") {
						controls.heartSound.soundName = response.cardiac.heart_sound;
					}

					// heart sound mute
					if(typeof(response.cardiac.heart_sound_mute) != "undefined") {
						// change value only if necessary
						if(response.cardiac.heart_sound_mute == 1 && controls.heartSound.mute == false) {
//							controls.heartSound.mute = true;
//							$('#heart-sound-mute').show();
							
							// force heart sound to not mute
							simmgr.sendChange({'set:cardiac:heart_sound_mute': 0});
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
					if(typeof(response.cardiac.rhythm) != "undefined" && controls.heartRhythm.currentRhythm != response.cardiac.rhythm) {
						controls.heartRhythm.currentRhythm = response.cardiac.rhythm;
						chart.ekg.rhythmIndex = response.cardiac.rhythm;
						chart.updateCardiac(response.cardiac );
						
						// set minimum heart rate
						if(response.cardiac.rhythm == 'vtach3') {
							controls.heartRate.minValue = controls.heartRate.rOnTMinValue;
							if(controls.heartRate.value < controls.heartRate.minValue) {
								simmgr.sendChange( { 'set:cardiac:rate' : controls.heartRate.minValue } );
								controls.heartRate.setHeartRateValue(controls.heartRate.minValue);
							}
						} else {
							controls.heartRate.minValue = controls.heartRate.normalMinValue;						
						}


						// calculate afib delays...scale heart rate between 0 and 2 for 100 samples
						// average delay will be with +/- 3%.
						if(response.cardiac.rhythm == 'afib') {
							chart.afib.delay = new Array;
							for(var index = 0; index <= chart.afib.delayCount; index++) {
								chart.afib.delay[index] = parseFloat((Math.random() * 2.0).toFixed(2));
 							}
						} else if(response.cardiac.rhythm == 'vtach3') {
							// pre calculate R on T based on heart rate
							chart.initVtach3();
							chart.updateCardiac(response.cardiac );
						}
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
						switch(controls.heartRhythm.vfibAmplitude) {
							case 'low':
								chart.fibDivide = 4;
								break;
							case 'med':
								chart.fibDivide = 2.5;
								break;
							case 'high':
							default:
								chart.fibDivide = 1;
								break;						
						}
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
					
					// Play/Stop control
					if(typeof(response.vocals.play) != "undefined") {
						controls.vocals.play = response.vocals.play;
						// Local Display Only section
						if ( simmgr.isLocalDisplay() ) {
							if(response.vocals.play == 1) {
								// First, prevent replay
								if ( simmgr.audioPlayStarted == 1 ) {
									// Do nothing, wait for play to clear
								}
								else {
									// Play current sound
									simmgr.audioPlayStarted = 1;
									controls.vocals.audio.src = BROWSER_SCENARIOS_VOCALS + controls.vocals.fileName;
									controls.vocals.audio.load();
									controls.vocals.audio.play();
								}
							}
							else {
								if ( simmgr.audioPlayStarted == 1 ) {
									// Play has cleared, so stop and allow restart
									controls.vocals.audio.pause();
									controls.vocals.audio.currentTime = 0;
									controls.vocals.audio.src = "";
								}
								simmgr.audioPlayStarted = 0;
							}
						}
						// End Local Display Only
					}
					$('#vocal-list li a').dblclick(function() {
							controls.vocals.fileName = $(this).attr('data-filename');
							$('#vocal-list li a span').removeClass('selected');
							$(this).children('span').addClass('selected');
							controls.vocals.audio.src = BROWSER_SCENARIOS_VOCALS + controls.vocals.fileName;
							controls.vocals.audio.load();
							controls.vocals.audio.addEventListener('ended', simmgr.endAudio );
							controls.vocals.audio.play();
							simmgr.sendChange({
								'set:vocals:filename': controls.vocals.fileName,
								'set:vocals:play': 1
							});

						});
				}
				
				/************ media **************/
				if(typeof(response.media) != "undefined" ) {
					// filename
					if(typeof(response.media.filename) != "undefined") {
						controls.media.fileName = response.media.filename;
					}
					if(typeof(response.media.play) !== 'undefined' )
					{
						if ( ( response.media.play == 1 ) && ( simmgr.mediaPlayStarted == 0 ) )
						{
							// Start new media display. Base action on file type
							var fileName = controls.media.fileName;
							var fileExt = fileName.split('.')[fileName.split('.').length - 1].toLowerCase();
							switch ( fileExt )
							{
								// Image files - List from https://www.library.cornell.edu/preservation/tutorial/presentation/table7-1.html
								case 'jpg': case 'jpeg': case 'jif': case 'jfif':
								case 'png':	case 'gif':	case 'tif': case 'tiff':
								case 'jp2': case 'jpx': case 'j2k': case 'j2c':
								case 'fpx':	case 'pcd':	case 'pdf':
									
									// Create a window the full size of the image. Scale down to fit in screen (if larger)
									$('#media-video').remove();
									$('#media-overlay').remove();
									$('body').append("<img id='media-overlay' src='"+BROWSER_SCENARIOS_MEDIA+controls.media.fileName+"'>" );
									$('#media-overlay').on('load', function() {
										var margintop = 0;
										var marginleft = 0;
										var iHeight = $('#media-overlay').height();
										var bHeight = $('body').height();
										if (iHeight < bHeight) {
											margintop = (bHeight - iHeight) / 2;
										}
										var iWidth = $('#media-overlay').width();
										var bWidth = $('body').width();
										if (iWidth < bWidth) {
											marginleft = (bWidth - iWidth) / 2;
										}
										$('#media-overlay').css({'margin-left': marginleft, 'margin-top' : margintop } );
									});
									$('#media-overlay').draggable();
									break;
								
								// Video file
								
								case 'mp4': case 'webm': case 'ogg':
									$('#media-video').remove();
									$('#media-overlay').remove();
									var vcontrol = "controls autoplay";
									var vheight;
									var vwidth;
									if ( simmgr.isLocalDisplay() ) {
										vwidth=1280;
										vheight=960;
									}
									else {
										vwidth=640;
										vheight=480;
									}
									$('body').append("<video id='media-overlay' width='"+vwidth+"' height='"+vheight+"' "+vcontrol+" ><source src='"
											+BROWSER_SCENARIOS_MEDIA+controls.media.fileName+
											"' type='video/"+fileExt+"'>Browser does not support this video tag ("+fileExt+")</video>");
									var margintop = ($(window).height() - (vheight+200) ) / 2;
									if ( margintop < 0 ) {
										margintop = 0;
									}
									var marginleft = ($(window).width() - vwidth ) / 2;
									$('#media-overlay').css({'margin-left': marginleft, 'margin-top' : margintop, 'cursor' : 'pointer' } );
									$('#media-overlay').draggable();
									break;
							
							}
							simmgr.mediaPlayStarted = 1;
						}
						else if ( ( response.media.play == 0 ) && ( simmgr.mediaPlayStarted == 1 ) )
						{
							$('#media-overlay').remove();
							$('#media-video').remove();
							simmgr.mediaPlayStarted = 0;
						}
					}
				}
				/************ respiration **************/
				if(typeof(response.respiration) != "undefined" ) {
					// awRR
					if(typeof(response.respiration.rate) != "undefined") {
						var respirationRate = response.respiration.rate;
						if( respirationRate != controls.awRR.value ) {
//console.log("recalc" );
							controls.awRR.value = respirationRate;
							controls.awRR.displayValue();
							// Calculate the inhalation time
							if ( respirationRate > 0 )
							{
								controls.inhalation_duration.value = Math.floor((1/(respirationRate/60))*1000);
							}
							else
							{
								// Default to avoid divide by zero
								controls.inhalation_duration.value = 400; 
							}
						}
					}
					else
					{
						console.log("no respiration rate" );
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
//							controls.leftLung.mute = true;
//							$('#left-lung-mute').show();
							// force mute to false
							simmgr.sendChange({'set:respiration:left_lung_sound_mute': 0});						
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
//							controls.rightLung.mute = true;
//							$('#right-lung-mute').show();
							// force mute to false
							simmgr.sendChange({'set:respiration:left_lung_sound_mute': 0});						
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
				else
				{
					console.log("no respiration" );
				}
				/************ scenario **************/
				if( ( typeof(response.scenario) != '"undefined"' ) && ( !isVitalsMonitor ) ){
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
									profile.removePatientInfo();
									break;
								
								case 'RUNNING':
									scenario.currentScenarioState = scenario.scenarioState.RUNNING;
									scenario.continueScenario();
									profile.removePatientInfo();
									break;
								
								default:
									break;
							}
						}
					}
					
					// scenario selection
					if(typeof(response.scenario.active) != "undefined" && response.scenario.active != scenario.currentScenarioFileName) {
						scenario.currentScenarioFileName = response.scenario.active;
						scenario.loadScenario();
						scenario.init();
						profile.init();
						events.init();
						profile.initPatientInfo();
					}
					
					// scenario scene name
					if(typeof(response.scenario.scene_name) != "undefined") {
						$('#scene-name').html(response.scenario.scene_name);
					}
					
					// scenario scene number
					if(typeof(response.scenario.scene_id) != "undefined") {
						$('#scene-id').html(response.scenario.scene_id);
					}
					
					// scenario record
					if(typeof(response.scenario.record) != "undefined" && response.scenario.record == 1) {
						scenario.startVideoWithScenario = true;
					} else {
						scenario.startVideoWithScenario = false;
					}
					$('#start-video').attr('checked', scenario.startVideoWithScenario);
				}
				
				/************ event log **************/
				if( typeof(response.logfile) != '"undefined"' ) {
					if(typeof(response.logfile.filename) != "undefined" && typeof(response.logfile.lines_written) != "undefined") {
						if( (response.logfile.filename != events.currentLogFileName) || (response.logfile.lines_written != events.currentLogRecord) ) {
							events.currentLogFileName = response.logfile.filename;
							events.currentLogRecord = response.logfile.lines_written;
							events.addEventsFromLog();
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
	
	// After audio play, clear the play controller (II only). Allow a 2 second lag
	endAudio : function() {
		setTimeout(function(){
			if ( controls.vocals.play == 1 )	// Only clear if still set.
			{
				simmgr.sendChange({
					'set:vocals:play': 0
				});
			}
		}, 2000 );
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
	
	// PHP call to maintain login
	tapHost : function ( ) {
		$.ajax({
			url: BROWSER_AJAX + 'ajaxTap.php',
			type: 'post',
			complete: function() {
				setTimeout(function() { simmgr.tapHost(); }, 600000 );	// Run very 10 minutes
			}
		});			
	},
	
	isLocalDisplay: function()
	{
		return ( SERVER_ADDR == REMOTE_ADDR );
	}
}
