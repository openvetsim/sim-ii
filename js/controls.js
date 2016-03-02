	var controls = {
		heartRate: {
			value: 75,
			minValue: 1,
			maxValue: 150,
			slideBar: '',
			increment: 1,
			
			beatInterval: 0,
			audio: new Audio('./audio/ekg.mp3'),
			
			modalUnitsLabel: 'BPM',
			
			init: function() {
				clearInterval(controls.heartRate.beatInterval);
				controls.heartRate.beatInterval = setInterval(controls.heartRate.setSynch, Math.round((60 / controls.heartRate.value) * 1000));	
				controls.heartRate.displayValue();
			},
			
			setHeartRate: function() {
				// get latest value from modal
				controls.heartRate.value = $('.strip-value.new').val();
				
				// set controls and update new value
				controls.heartRate.slideBar.slider("value", controls.heartRate.value);
				
				clearInterval(controls.heartRate.beatInterval);
				controls.heartRate.beatInterval = setInterval(controls.heartRate.setSynch, Math.round((60 / controls.heartRate.value) * 1000));
				controls.heartRate.displayValue();
			},
			
			setSynch: function() {
				chart.status.cardiac.synch = true;
			},
			
			validateNewValue: function() {
				var newValue = parseInt($('.strip-value.new').val());
				if(newValue < controls.heartRate.minValue || isNaN(newValue) == true) {
					$('.strip-value.new').val(controls.heartRate.minValue);			
				} else if(newValue > controls.heartRate.maxValue) {
					$('.strip-value.new').val(controls.heartRate.maxValue);
				}
				controls.heartRate.slideBar.slider("value", $('.strip-value.new').val());
			},
			
			displayValue: function() {
				$('#vs-heartRhythm a.display-rate').html(controls.heartRate.value + '<span class="vs-upper-label"> bpm</span>');
			}
		},
		
		awRR: {
			value: 30,
			minValue: 1,
			maxValue: 60,
			slideBar: '',
			beatInterval: 0,
			increment: 1,
			
			modalUnitsLabel: 'BPM',
			
			init: function() {
				clearInterval(controls.awRR.beatInterval);
				controls.awRR.beatInterval = setInterval(controls.awRR.setSynch, Math.round((60 / controls.awRR.value) * 1000));
				controls.awRR.displayValue();							
			},
			
			displayValue: function() {
				$('.awRR a.alt-control-rate').html(controls.awRR.value + '<span class="vs-lower-label"> bpm</span>');							
			},
			
			setRespRate: function() {
				// get latest value from modal
				controls.awRR.value = $('.strip-value.new').val();
				$('#display-awRR').html(controls.awRR.value);							
				
				// set controls and update new value
				controls.awRR.slideBar.slider("value", controls.awRR.value);
				
				clearInterval(controls.awRR.beatInterval);
				controls.awRR.beatInterval = setInterval(controls.awRR.setSynch, Math.round((60 / controls.awRR.value) * 1000));
				controls.awRR.displayValue();											
			},
			
			setSynch: function() {
				chart.status.resp.synch = true;
			},
			
			validateNewValue: function() {
				var newValue = parseInt($('.strip-value.new').val());
				if(newValue < controls.awRR.minValue || isNaN(newValue) == true) {
					$('.strip-value.new').val(controls.awRR.minValue);			
				} else if(newValue > controls.awRR.maxValue) {
					$('.strip-value.new').val(controls.awRR.maxValue);
				}
				controls.awRR.slideBar.slider("value", $('.strip-value.new').val());
			}
		},
		
		chestRise: {
			active: false
		},
		
		pulseStrength: {
			strength: ["None", "Weak", "Medium", "Strong"],
			value: "Medium"
		},
		
		ekg: {
			leadsConnected: false,
			connectHTML: "Disconnect EKG Leads",
			disconnectHTML: "Connect EKG Leads"
		},
		
		SpO2: {
			value: 98,
			minValue: 0,
			maxValue: 100,
			slideBar: '',
			increment: 1,
			
			leadsConnected: false,
			connectHTML: 'Disconnect SpO2 Sensor',
			disconnectHTML: "Connect SpO2 Sensor",
			
			modalUnitsLabel: '%',
			
			init: function() {
				controls.SpO2.displayValue();			
			},
			
			validateNewValue: function() {
				var newValue = parseInt($('.strip-value.new').val());
				if(newValue < controls.SpO2.minValue || isNaN(newValue) == true) {
					$('.strip-value.new').val(controls.SpO2.minValue);			
				} else if(newValue > controls.SpO2.maxValue) {
					$('.strip-value.new').val(controls.SpO2.maxValue);
				}
				controls.SpO2.slideBar.slider("value", $('.strip-value.new').val());
			},
			
			displayValue: function(){
				$('#display-SpO2').html(controls.SpO2.value + '<span class="vs-lower-label"> %</span>');			
			}

		},
		
		etCO2: {
			value: 34,
			minValue: 0,
			maxValue: 150,
			slideBar: '',
			increment: 1,
			
			modalUnitsLabel: 'mmHg',
			
			init: function() {
				controls.etCO2.displayValue();
			},
			
			validateNewValue: function() {
				var newValue = parseInt($('.strip-value.new').val());
				if(newValue < controls.etCO2.minValue || isNaN(newValue) == true) {
					$('.strip-value.new').val(controls.SpO2.minValue);			
				} else if(newValue > controls.etCO2.maxValue) {
					$('.strip-value.new').val(controls.etCO2.maxValue);
				}
				controls.etCO2.slideBar.slider("value", $('.strip-value.new').val());
			},
			
			displayValue: function() {
				$('#vs-etCO2 a').html(controls.etCO2.value + '<span class="vs-upper-label"> mmHg</span>');						
			}

		},
		
		Tperi: {
			value: 98.0,
			minValue: 70.0,
			maxValue: 110.0,
			slideBar: '',
			increment: 0.1,
			
			leadsConnected: false,
			connectHTML: 'Disconnect SpO2 Sensor',
			disconnectHTML: "Connect SpO2 Sensor",
			
			modalUnitsLabel: '&deg;F',
			
			init: function() {
				controls.Tperi.displayValue();
			},
			
			validateNewValue: function() {
				var newValue = parseFloat($('.strip-value.new').val());
				if(newValue < controls.Tperi.minValue || isNaN(newValue) == true) {
					$('.strip-value.new').val(controls.Tperi.minValue);			
				} else if(newValue > controls.Tperi.maxValue) {
					$('.strip-value.new').val(controls.Tperi.maxValue);
				}
				controls.Tperi.slideBar.slider("value", $('.strip-value.new').val());
			},
			
			displayValue: function() {
				$('#display-Tperi').html(controls.Tperi.value.toFixed(1) + '<span class="vs-lower-label"> &ordm;F</span>');			
			}
		}, 

		CO2: {
			leadsConnected: false,
			connectHTML: 'Disconnect CO2 Sensor',
			disconnectHTML: "Connect CO2 Sensor"
		},
		
		vocals: {
			audio: new Audio(),
			fileName: '',
			repeat: false,
			slideBar: '',
			minValue: 1,
			maxValue: 10,
			increment: 1,
			value: 5,
			mute: false,
			
			init: function() {
				controls.vocals.displayMute();
			},
			
			displayMute: function() {
				if(controls.vocals.mute == true) {
					$('#vocals-mute').show();
					controls.vocals.slideBar.slider("option", "disabled", true);
				} else {
					$('#vocals-mute').hide();				
					controls.vocals.slideBar.slider("option", "disabled", false);
				}
			}
		},
		
		nbp: {
			systolicValue: 120,
			minSystolicValue: 0,
			maxSystolicValue: 300,
			
			diastolicValue: 80,
			minDiastolicValue: 0,
			maxDiastolicValue: 290,
			
			meanValue: 0,
			
			slideBarSystolic: '',
			slideBarDiastolic: '',
			slideBarLinkedHR: '',
			reportedHRValue: 70,
			previousReportedHRValue: 70,
			increment: 1,
			coupled: false,
			linkedHR: false,
			
			init: function() {
				controls.nbp.updateDisplayedNBP();
			},
			
			updateDisplayedNBP: function() {
				// update displayed NBP
				$('#displayed-systolic').html(controls.nbp.systolicValue);
				$('#displayed-diastolic').html(controls.nbp.diastolicValue);
				
				// calculate mean NBP
				controls.nbp.meanValue = Math.floor((controls.nbp.systolicValue - controls.nbp.diastolicValue) / 3) + parseInt(controls.nbp.diastolicValue);
				$('#displayed-meanNBP').html(controls.nbp.meanValue)
				
				// display reported HR
				$('#displayed-reportedHR').html(controls.nbp.reportedHRValue + ' <span class="nbip-label">bpm</span>');				
			},
						
			validateNewValue: function(type) {
				var newValue = 0;
				if(type == 'systolic') {
					newValue = parseInt($('.strip-value.new.systolic').val());
					if(newValue < controls.nbp.minSystolicValue || isNaN(newValue) == true) {
						$('.strip-value.new.systolic').val(controls.nbp.minSystolicValue);			
					} else if(newValue > controls.nbp.maxSystolicValue) {
						$('.strip-value.new.systolic').val(controls.nbp.maxSystolicValue);
					}
					controls.nbp.slideBarSystolic.slider("value", $('.strip-value.new.systolic').val());
				} else if(type == 'diastolic') {
					newValue = parseInt($('.strip-value.new.diastolic').val());
					if(newValue < controls.nbp.minDiastolicValue || isNaN(newValue) == true) {
						$('.strip-value.new.diastolic').val(controls.nbp.minDiastolicValue);			
					} else if(newValue > controls.nbp.maxDiastolicValue) {
						$('.strip-value.new.diastolic').val(controls.nbp.maxDiastolicValue);
					}
					controls.nbp.slideBarDiastolic.slider("value", $('.strip-value.new.diastolic').val());
				}
			},
			
			validateNewLinkedHRValue: function() {
				newValue = parseInt($('.strip-value.new.linked-hr').val());
				if(newValue < controls.heartRate.minValue || isNaN(newValue) == true) {
					$('.strip-value.new.linked-hr').val(controls.heartRate.minValue);			
				} else if(newValue > controls.heartRate.maxValue) {
					$('.strip-value.new.linked-hr').val(controls.heartRate.maxValue);
				}
				controls.nbp.slideBarLinkedHR.slider("value", $('.strip-value.new.linked-hr').val());
				controls.nbp.reportedHRValue = $('.strip-value.new.linked-hr').val();
				if(controls.nbp.linkedHR == true) {
					controls.nbp.previousReportedHRValue = $('.strip-value.new.linked-hr').val();
				}
			},
			
			setDiastolicValue: function(systolicSlideDifference) {
				// if sliders are coupled and diastolic = 0, do not move diastolic unil systolic is at least at value of 10.
				var currentDisatolicValue = $('.strip-value.new.diastolic').val();
				if(controls.nbp.coupled == true && ($('.strip-value.new.systolic').val() - currentDisatolicValue) >= 10) {
					$('.strip-value.new.diastolic').val(parseInt(currentDisatolicValue) + parseInt(systolicSlideDifference));
				} else if( ($('.strip-value.new.systolic').val() - currentDisatolicValue) < 10) {
					$('.strip-value.new.diastolic').val(parseInt($('.strip-value.new.systolic').val()) - 10)
				}
				controls.nbp.validateNewValue("diastolic");
				return;
			}, 
			
			setSystolicValue: function(diastolicSlideDifference) {
				// if sliders are coupled and systolic = 0, jump systolic to 10
				var currentSystolicValue = $('.strip-value.new.systolic').val();
				if(controls.nbp.coupled == true && (currentSystolicValue - $('.strip-value.new.diastolic').val()) >= 10) {
					$('.strip-value.new.systolic').val(parseInt(currentSystolicValue) + parseInt(diastolicSlideDifference));
				} else if( (currentSystolicValue - $('.strip-value.new.diastolic').val()) < 10) {
					$('.strip-value.new.systolic').val(parseInt($('.strip-value.new.diastolic').val()) + 10)
				}
				controls.nbp.validateNewValue("systolic");
				return;
			},
			
			updateSlideBar: function(type) {
				var systolicObj = $('.strip-value.new.systolic');
				var diastolicObj = $('.strip-value.new.diastolic');
				
				if(type == "diastolic") {
					if(controls.nbp.coupled == true) {
						diastolicObj.val(parseInt(systolicObj.val()) - 10);
					} else if((systolicObj.val() - 10) <= diastolicObj.val()) {
						diastolicObj.val(parseInt(systolicObj.val()) - 10);					
					}
				} else if(type == "systolic") {
					if(controls.nbp.coupled == true) {
						systolicObj.val(parseInt(diastolicObj.val()) + 10);
					} else if((systolicObj.val() - 10) <= diastolicObj.val()) {
						systolicObj.val(parseInt(diastolicObj.val()) + 10);					
					}
				}
				controls.nbp.validateNewValue(type);
				return;
			},
			
			setLinkedHRValue: function(linkedHRSlideDifference) {
				var currentLinkedHRValue = $('.strip-value.new.linked-hr').val();
				$('.strip-value.new.linked-hr').val(parseInt(currentLinkedHRValue) + parseInt(linkedHRSlideDifference));
				controls.nbp.validateNewLinkedHRValue();
				return;
			},
			
			linkedHRControl: function() {
				if(controls.nbp.linkedHR == true) {
					controls.nbp.reportedHRValue = controls.heartRate.value;
				} else {
					controls.nbp.reportedHRValue = controls.nbp.previousReportedHRValue;
				}
				$('input.strip-value.new.linked-hr').val(controls.nbp.reportedHRValue);
				controls.nbp.slideBarLinkedHR.slider("value", controls.nbp.reportedHRValue);
				
				$('input.strip-value.new.linked-hr').prop('disabled', controls.nbp.linkedHR);
				controls.nbp.slideBarLinkedHR.slider('option', 'disabled', controls.nbp.linkedHR);
				$('a.control-incr-decr-rate.linked-hr').prop('disabled', controls.nbp.linkedHR);
				return;
			}
		},
		
		leftLung: {
			soundID: 0,
			slideBar: '',
			minValue: 1,
			maxValue: 10,
			increment: 1,
			value: 5,
			mute: false,
			
			init: function() {
				controls.leftLung.displayMute();
			},
			
			displayMute: function() {
				if(controls.leftLung.mute == true) {
					$('#left-lung-mute').show();
					controls.leftLung.slideBar.slider("option", "disabled", true);
				} else {
					$('#left-lung-mute').hide();				
					controls.leftLung.slideBar.slider("option", "disabled", false);
				}
			}
		},
		
		rightLung: {
			soundID: 0,
			slideBar: '',
			minValue: 1,
			maxValue: 10,
			increment: 1,
			value: 5,
			mute: false,
			
			init: function() {
				controls.rightLung.displayMute();
			},
			
			displayMute: function() {
				if(controls.rightLung.mute == true) {
					$('#right-lung-mute').show();
					controls.rightLung.slideBar.slider("option", "disabled", true);
				} else {
					$('#right-lung-mute').hide();				
					controls.rightLung.slideBar.slider("option", "disabled", false);
				}
			}
		},
		
		heartSound: {
			soundID: 0,
			slideBar: '',
			minValue: 1,
			maxValue: 10,
			increment: 1,
			value: 5,
			mute: false,
			
			displayMute: function() {
				if(controls.heartSound.mute == true) {
					$('#heart-sound-mute').show();
					controls.heartSound.slideBar.slider("option", "disabled", true);
				} else {
					$('#heart-sound-mute').hide();				
					controls.heartSound.slideBar.slider("option", "disabled", false);
				}
			}
		},
		
		

	}