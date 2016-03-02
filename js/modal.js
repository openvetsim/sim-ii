	var modal = {
		imgTop: '50px',
		imgPadding: '0px',
		
		textTop: '200px',
		textPadding: '20px',
		textWidth: 300,
		
		fadeDelay: 200,
		
		defaultControlWidth: 400,
		
		showText: function(content, text_align) {
			if(typeof text_align == 'undefined') {
				text_align = 'center';
			} else {
				switch(text_align) {
					case 'left':
					case 'center':
						break;
					default:
						text_align = 'center';
						break;
				}
			}
			$('#modal #modal-content').append(content);
			$('#modal .container').width(modal.textWidth);
			$('#modal .container').css({
										'height': 'auto',
										'padding': modal.textPadding,
										'text-align': text_align,
										'top': modal.textTop
			});
			$('#modal').css('position', 'fixed').fadeIn(modal.fadeDelay);
			modal.bindCloseModal();
		},
		
		heartRate: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetSingleControlContent.php',
				type: 'post',
				async: false,
				data: {ModalTitle: 'Set Heart Rate', ControlTitle: "Heart Rate", ModalUnits: controls.heartRate.modalUnitsLabel},
				dataType: 'json',
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						modal.bindCloseModal();
						
						// bind controls
						controls.heartRate.slideBar = $(".control-slider-1").slider({
							value: controls.heartRate.value,
							min: controls.heartRate.minValue,
							max: controls.heartRate.maxValue,
							step: 1,
							slide: function(event, ui) {
								$('.strip-value.new').val(ui.value);
							}
						});
						$('.strip-value').val(controls.heartRate.value);
						
						// bind apply button
						$('.modal-button.apply').click(function() {
							controls.heartRate.setHeartRate();
							modal.closeModal();
						});
						
						// bind change in new value
						$('.strip-value.new').change(controls.heartRate.validateNewValue);
						
						// bind increment and decrement
						$('.control-incr-decr-rate.decr-rate').click(function() {
							$('.strip-value.new').val(parseInt($('.strip-value.new').val()) - 1);
							controls.heartRate.validateNewValue();
						});
						$('.control-incr-decr-rate.incr-rate').click(function() {
							$('.strip-value.new').val(parseInt($('.strip-value.new').val()) + 1);
							controls.heartRate.validateNewValue();
						});
					}
				}
			});
		},

		awRR: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetSingleControlContent.php',
				type: 'post',
				async: false,
				data: {ModalTitle: 'Set Respiration Rate (awRR)', ControlTitle: "Respiration Rate", ModalUnits: controls.awRR.modalUnitsLabel},
				dataType: 'json',
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						modal.bindCloseModal();
						
						// bind controls
						controls.awRR.slideBar = $(".control-slider-1").slider({
							value: controls.awRR.value,
							min: controls.awRR.minValue,
							max: controls.awRR.maxValue,
							step: 1,
							slide: function(event, ui) {
								$('.strip-value.new').val(ui.value);
							}
						});
						$('.strip-value').val(controls.awRR.value);
						
						// bind apply button
						$('.modal-button.apply').click(function() {
							controls.awRR.setRespRate();
							modal.closeModal();
						});
						
						// bind change in new value
						$('.strip-value.new').change(controls.awRR.validateNewValue);
						
						// bind increment and decrement
						$('.control-incr-decr-rate.decr-rate').click(function() {
							$('.strip-value.new').val(parseInt($('.strip-value.new').val()) - 1);
							controls.awRR.validateNewValue();
						});
						$('.control-incr-decr-rate.incr-rate').click(function() {
							$('.strip-value.new').val(parseInt($('.strip-value.new').val()) + 1);
							controls.awRR.validateNewValue();
						});
					}
				}
			});
		},
		
		SpO2: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetSingleControlContent.php',
				type: 'post',
				async: false,
				data: {ModalTitle: 'Set SpO<sub>2</sub>', ControlTitle: "SpO<sub>2</sub>", ModalUnits: controls.SpO2.modalUnitsLabel},
				dataType: 'json',
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						modal.bindCloseModal();
						
						// bind controls
						controls.SpO2.slideBar = $(".control-slider-1").slider({
							value: controls.SpO2.value,
							min: controls.SpO2.minValue,
							max: controls.SpO2.maxValue,
							step: 1,
							slide: function(event, ui) {
								$('.strip-value.new').val(ui.value);
							}
						});
						$('.strip-value').val(controls.SpO2.value);
						
						// bind apply button
						$('.modal-button.apply').click(function() {
							controls.SpO2.value = $('.strip-value.new').val();
							controls.SpO2.displayValue();
							modal.closeModal();
						});
						
						// bind change in new value
						$('.strip-value.new').change(controls.SpO2.validateNewValue);
						
						// bind increment and decrement
						$('.control-incr-decr-rate.decr-rate').click(function() {
							$('.strip-value.new').val(parseInt($('.strip-value.new').val()) - 1);
							controls.SpO2.validateNewValue();
						});
						$('.control-incr-decr-rate.incr-rate').click(function() {
							$('.strip-value.new').val(parseInt($('.strip-value.new').val()) + 1);
							controls.SpO2.validateNewValue();
						});
					}
				}
			});
		},
		
		etCO2: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetSingleControlContent.php',
				type: 'post',
				async: false,
				data: {ModalTitle: 'Set etCO<sub>2</sub>', ControlTitle: "etCO<sub>2</sub>", ModalUnits: controls.etCO2.modalUnitsLabel},
				dataType: 'json',
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						modal.bindCloseModal();
						
						// bind controls
						controls.etCO2.slideBar = $(".control-slider-1").slider({
							value: controls.etCO2.value,
							min: controls.etCO2.minValue,
							max: controls.etCO2.maxValue,
							step: 1,
							slide: function(event, ui) {
								$('.strip-value.new').val(ui.value);
							}
						});
						$('.strip-value').val(controls.etCO2.value);
						
						// bind apply button
						$('.modal-button.apply').click(function() {
							controls.etCO2.value = $('.strip-value.new').val();
							controls.etCO2.displayValue();
							modal.closeModal();
						});
						
						// bind change in new value
						$('.strip-value.new').change(controls.etCO2.validateNewValue);
						
						// bind increment and decrement
						$('.control-incr-decr-rate.decr-rate').click(function() {
							$('.strip-value.new').val(parseInt($('.strip-value.new').val()) - 1);
							controls.etCO2.validateNewValue();
						});
						$('.control-incr-decr-rate.incr-rate').click(function() {
							$('.strip-value.new').val(parseInt($('.strip-value.new').val()) + 1);
							controls.etCO2.validateNewValue();
						});
					}
				}
			});
		},
		
		Tperi: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetSingleControlContent.php',
				type: 'post',
				async: false,
				data: {ModalTitle: 'Set Tperi', ControlTitle: "Tperi", ModalUnits: controls.Tperi.modalUnitsLabel},
				dataType: 'json',
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						modal.bindCloseModal();
						
						// bind controls
						controls.Tperi.slideBar = $(".control-slider-1").slider({
							value: controls.Tperi.value,
							min: controls.Tperi.minValue,
							max: controls.Tperi.maxValue,
							step: controls.Tperi.increment,
							slide: function(event, ui) {
								$('.strip-value.new').val(ui.value);
							}
						});
						$('.strip-value').val(parseFloat(controls.Tperi.value).toFixed(1));
						
						// bind apply button
						$('.modal-button.apply').click(function() {
							controls.Tperi.value = parseFloat($('.strip-value.new').val());
							controls.Tperi.displayValue();
							modal.closeModal();
						});
						
						// bind change in new value
						$('.strip-value.new').change(controls.Tperi.validateNewValue);
						
						// bind increment and decrement
						$('.control-incr-decr-rate.decr-rate').click(function() {
							$('.strip-value.new').val( (parseFloat($('.strip-value.new').val()) - controls.Tperi.increment).toFixed(1) );
							controls.Tperi.validateNewValue();
						});
						$('.control-incr-decr-rate.incr-rate').click(function() {
							$('.strip-value.new').val( (parseFloat($('.strip-value.new').val()) + controls.Tperi.increment).toFixed(1) );
							controls.Tperi.validateNewValue();
						});
					}
				}
			});
		},
		
		chestRise: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetChestRiseControlContent.php',
				type: 'post',
				async: false,
				data: {ModalTitle: 'Control Chest Rise', ControlTitle: "Chest Rise", ChestRise: controls.chestRise.active},
				dataType: 'json',
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						modal.bindCloseModal();
						
						// bind change in control
						$('.modal-button.apply').click(function() {
							controls.chestRise.active = $('select.chest-rise option:selected').val()
							modal.closeModal();
						});
					
					}
				}
			});
		},

		pulseStrength: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetPulseStrengthControlContent.php',
				type: 'post',
				async: false,
				data: {ModalTitle: 'Control Pulse Strength', ControlTitle: "Pulse Strength", ChestRise: controls.chestRise.active},
				dataType: 'json',
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						modal.bindCloseModal();
						
						// set checkbox
						$('input.pulse-strength').prop('checked', false);
						$('input.pulse-strength[value=' + controls.pulseStrength.value + ']').prop('checked', true);
						
						// bind change in control
						$('.modal-button.apply').click(function() {
							controls.pulseStrength.value = $('input.pulse-strength:checked').val();
							modal.closeModal();
						});
					
					}
				}
			});
		},
		
		nbp: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetNBPControlContent.php',
				type: 'post',
				async: false,
				data: {ModalTitle: 'Set Non Invasive BP'},
				dataType: 'json',
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						$('#modal .container').css('top', '100px');
						modal.bindCloseModal();
						
						// init values
						$('.strip-value.systolic').val(parseInt(controls.nbp.systolicValue));
						$('.strip-value.diastolic').val(parseInt(controls.nbp.diastolicValue));
						$('#nbp-control-coupled').prop('checked', controls.nbp.coupled);
						
						// bind controls
						controls.nbp.slideBarSystolic = $(".control-slider-1.systolic").slider({
							value: controls.nbp.systolicValue,
							min: controls.nbp.minSystolicValue,
							max: controls.nbp.maxSystolicValue,
							step: controls.nbp.increment,
							slide: function(event, ui) {
								var slideDifference =  ui.value - $('.strip-value.new.systolic').val();
								$('.strip-value.new.systolic').val(ui.value);
								controls.nbp.setDiastolicValue(slideDifference);
							}
						});
						
						controls.nbp.slideBarDiastolic = $(".control-slider-1.diastolic").slider({
							value: controls.nbp.diastolicValue,
							min: controls.nbp.minDiastolicValue,
							max: controls.nbp.maxDiastolicValue,
							step: controls.nbp.increment,
							slide: function(event, ui) {
								var slideDifference = ui.value - $('.strip-value.new.diastolic').val();
								$('.strip-value.new.diastolic').val(ui.value);
								controls.nbp.setSystolicValue(slideDifference);
							}
						});
						
						controls.nbp.slideBarLinkedHR = $(".control-slider-1.linked-hr").slider({
							value: controls.nbp.reportedHRValue,
							min: controls.heartRate.minValue,
							max: controls.heartRate.maxValue,
							step: controls.heartRate.increment,
							slide: function(event, ui) {
								$('.strip-value.new.linked-hr').val(ui.value);
								controls.nbp.previousReportedHRValue = ui.value;
							}
						});
						
						// set disabled linkd hr control
						$('#nbp-control-coupled-hr').prop('checked', controls.nbp.linkedHR);
						controls.nbp.linkedHRControl();
						$('.strip-value.current.linked-hr').val($('.strip-value.new.linked-hr').val());
						
						// bind change in new value
						$('.strip-value.new.systolic').change(function() {
							controls.nbp.validateNewValue('systolic');
							controls.nbp.updateSlideBar('diastolic');
						});
						$('.strip-value.new.diastolic').change(function() {
							controls.nbp.validateNewValue('diastolic');
							controls.nbp.updateSlideBar('systolic');
						});
						
						// bind change in coupled checkbox
						$('#nbp-control-coupled').change(function() {
							if($(this).is(':checked') == true) {
								controls.nbp.coupled = true;
							} else {
								controls.nbp.coupled = false;
							}
						});
						
						// bind change in linked HR checkbox
						$('#nbp-control-coupled-hr').change(function() {
							if($(this).is(':checked') == true) {
								controls.nbp.linkedHR = true;
							} else {
								controls.nbp.linkedHR = false;
							}
							controls.nbp.linkedHRControl();
						});
						
						// bind increment and decrement
						$('.control-incr-decr-rate.decr-rate.systolic').click(function() {
							$('.strip-value.new.systolic').val((parseInt($('.strip-value.new.systolic').val()) - controls.nbp.increment));
							controls.nbp.validateNewValue('systolic');
							controls.nbp.updateSlideBar('diastolic');
						});
						$('.control-incr-decr-rate.incr-rate.systolic').click(function() {
							$('.strip-value.new.systolic').val((parseInt($('.strip-value.new.systolic').val()) + controls.nbp.increment));
							controls.nbp.validateNewValue('systolic');
							controls.nbp.updateSlideBar('diastolic');
						});
						$('.control-incr-decr-rate.decr-rate.diastolic').click(function() {
							$('.strip-value.new.diastolic').val((parseInt($('.strip-value.new.diastolic').val()) - controls.nbp.increment));
							controls.nbp.validateNewValue('diastolic');
							controls.nbp.updateSlideBar('systolic');
						});
						$('.control-incr-decr-rate.incr-rate.diastolic').click(function() {
							$('.strip-value.new.diastolic').val((parseInt($('.strip-value.new.diastolic').val()) + controls.nbp.increment));
							controls.nbp.validateNewValue('diastolic');
							controls.nbp.updateSlideBar('systolic');
						});
						$('.control-incr-decr-rate.decr-rate.linked-hr').click(function() {
							$('.strip-value.new.linked-hr').val((parseInt($('.strip-value.new.linked-hr').val()) - controls.nbp.increment));
							controls.nbp.validateNewLinkedHRValue();
						});
						$('.control-incr-decr-rate.incr-rate.linked-hr').click(function() {
							$('.strip-value.new.linked-hr').val((parseInt($('.strip-value.new.linked-hr').val()) + controls.nbp.increment));
							controls.nbp.validateNewLinkedHRValue();
						});
												
						// bind change in control
						$('.modal-button.apply').click(function() {
							controls.nbp.systolicValue = $('.strip-value.new.systolic').val();
							controls.nbp.diastolicValue = $('.strip-value.new.diastolic').val();
							
							// if hr controls are not linked, save reported value as previous.
							if(controls.nbp.linkedHR == true) {
							
							} else {
							
							}
							
							controls.nbp.reportedHRValue = $('.strip-value.new.linked-hr').val();
							
							// update displayed values for NBP
							controls.nbp.updateDisplayedNBP();

							modal.closeModal();
						});
					}
				}
			});
		},
		
		vocals: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetVocalsControlContent.php',
				type: 'post',
				async: false,
				dataType: 'json',
				data: {'profileINI': profile.profileINI},
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						
						// highlight previous vocal file
						$('#vocal-list li a span').each(function() {
							if($(this).html() == controls.vocals.fileName) {
								$(this).addClass('selected');
								controls.vocals.audio.src = BROWSER_VOCALS + controls.vocals.fileName;
								controls.vocals.audio.loop = false;
							}
						});
						
						// clear out repeat
						controls.vocals.repeat = false;

						// adjust css
						$('.control-modal-div').css({'height': 'auto', 'text-align': 'left'});
						
						// bind filename click
						$('#vocal-list li a').click(function() {
							controls.vocals.fileName = $(this).children('span').html();
							$('#vocal-list li a span').removeClass('selected');
							$(this).children('span').addClass('selected');
							controls.vocals.audio.src = BROWSER_VOCALS + controls.vocals.fileName;
						});
						$('#vocal-list li a').dblclick(function() {
							controls.vocals.fileName = $(this).children('span').html();
							$('#vocal-list li a span').removeClass('selected');
							$(this).children('span').addClass('selected');
							controls.vocals.audio.src = BROWSER_VOCALS + controls.vocals.fileName;
							controls.vocals.audio.load();
							controls.vocals.audio.play();
						});
						
						// play button
						$('#audio-control-play').click(function() {
							if(controls.vocals.fileName != '') {
								controls.vocals.audio.load();
								controls.vocals.audio.play();							
							}
						});
						
						// stop button
						$('#audio-control-stop').click(function() {
							if(controls.vocals.fileName != '') {
								controls.vocals.audio.load();
								controls.vocals.repeat = false;
								$('#audio-control-repeat img').removeClass('selected');							
								controls.vocals.audio.loop = false;
							}
						});
						
						// repeat button
						$('#audio-control-repeat').click(function() {
							if(controls.vocals.repeat == false) {
								controls.vocals.repeat = true;
								$(this).children('img').addClass('selected');
								controls.vocals.audio.loop = true;
							} else {
								controls.vocals.repeat = false;
								$(this).children('img').removeClass('selected');							
								controls.vocals.audio.loop = false;
							}
						});
						
						// volume control
						controls.vocals.slideBar = $("#volume-slider").slider({
							value: controls.vocals.value,
							min: controls.vocals.minValue,
							max: controls.vocals.maxValue,
							step: controls.vocals.increment,
							slide: function(event, ui) {
								controls.vocals.value = ui.value;
							}
						});
						
						// mute button
						$('#mute-volume').prop('checked', controls.vocals.mute);
						
						// mute change
						$('#mute-volume').change(function() {
							if($(this).prop('checked') == true) {
								controls.vocals.mute = true;
							} else {
								controls.vocals.mute = false;							
							}
							$('#mute-volume').prop('checked', controls.vocals.mute);
							controls.vocals.displayMute();							
						});
						
						// init mute display
						controls.vocals.displayMute();							
						
						// bind close of modal to stop sound
						$('a.close_modal, button.cancel').click(function() {
							if(controls.vocals.fileName != '') {
								controls.vocals.audio.load();
								controls.vocals.repeat = false;
								$('#audio-control-repeat img').removeClass('selected');							
								controls.vocals.audio.loop = false;
							}
							modal.closeModal();
						});						
					}
				}
			});
		},
		
		leftLung: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetLungSoundContent.php',
				type: 'post',
				async: false,
				dataType: 'json',
				data: {'side': 'left', 'soundID': controls.leftLung.soundID},
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						$('#modal .container').css('width', '300px');
						$('#modal .container .control-modal-div').css('width', '300px');
						$('#volume-controls').css({
													'float': 'none',
													'margin': '0 auto'
													});
						
						// volume control
						controls.leftLung.slideBar = $("#volume-slider").slider({
							value: controls.leftLung.value,
							min: controls.leftLung.minValue,
							max: controls.leftLung.maxValue,
							step: controls.leftLung.increment,
							slide: function(event, ui) {
								controls.leftLung.value = ui.value;
							}
						});
						
						// init mute button
						$('#mute-volume').prop('checked', controls.leftLung.mute);
						
						// init slidebar
						controls.leftLung.displayMute();							
						
						// mute change
						$('#mute-volume').change(function() {
							if($(this).prop('checked') == true) {
								controls.leftLung.mute = true;
							} else {
								controls.leftLung.mute = false;							
							}
							$('#mute-volume').prop('checked', controls.leftLung.mute);
							controls.leftLung.displayMute();							
						});
						
						// change of sound select
						$('#sound-select').change(function() {
							controls.leftLung.soundID = $(this).children('option:selected').val();
						});
						
						modal.bindCloseModal();
					}
				}
			});
		},
		
		rightLung: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetLungSoundContent.php',
				type: 'post',
				async: false,
				dataType: 'json',
				data: {'side': 'right', 'soundID': controls.rightLung.soundID},
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						$('#modal .container').css('width', '300px');
						$('#modal .container .control-modal-div').css('width', '300px');
						$('#volume-controls').css({
													'float': 'none',
													'margin': '0 auto'
													});
						
						// volume control
						controls.rightLung.slideBar = $("#volume-slider").slider({
							value: controls.rightLung.value,
							min: controls.rightLung.minValue,
							max: controls.rightLung.maxValue,
							step: controls.rightLung.increment,
							slide: function(event, ui) {
								controls.rightLung.value = ui.value;
							}
						});
						
						// mute button
						$('#mute-volume').prop('checked', controls.rightLung.mute);
						
						// init slidebar
						controls.rightLung.displayMute();							
						
						// mute change
						$('#mute-volume').change(function() {
							if($(this).prop('checked') == true) {
								controls.rightLung.mute = true;
							} else {
								controls.rightLung.mute = false;							
							}
							$('#mute-volume').prop('checked', controls.rightLung.mute);
							controls.rightLung.displayMute();							
						});
						
						// change of sound select
						$('#sound-select').change(function() {
							controls.rightLung.soundID = $(this).children('option:selected').val();
						});
						
						modal.bindCloseModal();
					}
				}
			});
		},

		heartSound: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetHeartSoundContent.php',
				type: 'post',
				async: false,
				dataType: 'json',
				data: {'soundID': controls.heartSound.soundID},
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						$('#modal .container').css('width', '300px');
						$('#modal .container .control-modal-div').css('width', '300px');
						$('#volume-controls').css({
													'float': 'none',
													'margin': '0 auto'
													});
						
						// volume control
						controls.heartSound.slideBar = $("#volume-slider").slider({
							value: controls.heartSound.value,
							min: controls.heartSound.minValue,
							max: controls.heartSound.maxValue,
							step: controls.heartSound.increment,
							slide: function(event, ui) {
								controls.heartSound.value = ui.value;
							}
						});
						
						// mute button
						$('#mute-volume').prop('checked', controls.heartSound.mute);
						
						// init slidebar
						controls.heartSound.displayMute();							
						
						// mute change
						$('#mute-volume').change(function() {
							if($(this).prop('checked') == true) {
								controls.heartSound.mute = true;
							} else {
								controls.heartSound.mute = false;							
							}
							$('#mute-volume').prop('checked', controls.heartSound.mute);
							controls.heartSound.displayMute();							
						});
						
						// change of sound select
						$('#sound-select').change(function() {
							controls.heartSound.soundID = $(this).children('option:selected').val();
						});
						
						modal.bindCloseModal();
					}
				}
			});
		},
		
		showLog: function() {
			var response = {
				html: '<h1 id="modal-title">Event Log</h1>' + 
										'<hr / class="modal-divider">' +
										'<div class="control-modal-div">' +
											$('#event-monitor').html() +
											'<div class="clearer"></div>' +
										'</div>'
			};

			modal.showModal(response);
			$('#modal .container').css('width', '500px');
			$('#modal .container .control-modal-div').css({
				'width': '500px',
				height: '300px',
				'overflow': 'scroll'
			});
			$('#modal .container .control-modal-div table').css({
				width: '100%'
			});
			$('#modal .container .control-modal-div table tr td').css({
				'text-align': 'left'
			});
			$('#modal .container .control-modal-div table tr:nth-child(2n+1)').css({
				'background-color': '#CCCCCC'
			});
			modal.bindCloseModal();
		},

		showEvents: function() {
			var response = {
				html: '<h1 id="modal-title">Event Library</h1>' + 
										'<hr / class="modal-divider">' +
										'<div class="control-modal-div">' +
											$('#event-library').html() +
											'<div class="clearer"></div>' +
										'</div>'
			};

			modal.showModal(response);
			$('#modal .container').css({'width': '1000px', top: '50px'});
			$('#modal .container .control-modal-div').css({
				'width': '1000px',
				height: '400px',
				'overflow': 'auto'
			});
			modal.bindCloseModal();
		},

		showUsers: function() {
			$.ajax({
				url: BROWSER_AJAX + 'ajaxGetUserTableContent.php',
				type: 'post',
				async: false,
				dataType: 'json',
				success: function(response) {
					if(response.status == AJAX_STATUS_OK) {
						modal.showModal(response);
						$('#modal .container').css('width', '900px');
						$('#modal .container .control-modal-div').css('width', '900px');
						$('#modal-content').css('margin-top', '0');
						modal.bindCloseModal();
					}
				}
			});
		},

		/********************* Utils for modals *******************/

		bindCloseModalAudio: function() {
			$('a.close_modal, button.cancel').click(function() {
				controls.vocals.audio.loop = false;
				controls.vocals.repeat = false;
				controls.vocals.audio.load();				
				modal.closeModal();
			});
		},
		
		bindCloseModal: function() {
			$('a.close_modal, button.cancel').click(modal.closeModal);
		},
		
		showModal: function(response) {
			$('#modal-content').html(response.html);
			$('#modal').css('position', 'fixed').fadeIn(modal.fadeDelay);
			$('#modal .container').css('height', 'auto');
		},
		
		ajaxWait: function() {
			$('#modal .close_modal').hide();
			$('#modal #modal-content').append('<img class="image_modal modal_content" src="' + BROWSER_THEME_IMAGES + 'ajax_loader.gif" alt="Product Image">');
			$('#modal .container').width(modal.textWidth);
			$('#modal .container').css({
										'height': '150px',
										'padding': modal.textPadding,
										'text-align': 'center',
										'top': modal.textTop,
										'background-color': '#FFFFFF' 
			});
			$('#modal img').css('margin', 'auto');
			$('#modal').css('position', 'fixed').show();					
		},

		closeModal: function() {
			$('#modal').fadeOut(modal.fadeDelay,
				function() {
					$('#modal-content').empty();
					$('#modal .close_modal').show();
					$('#modal .container').css('width', '400px');
					$('#modal .container .control-modal-div').css('width', '345px');					
				}
			);
		},
		closeModalFast: function() {
			$('#modal').hide();
			$('#modal-content').empty();
			$('#modal .close_modal').show();
		},
	}
