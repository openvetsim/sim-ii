	var buttons = {
		disconnectColor: "#B31B1B",
		connectColor: "green",
		
		init: function() {
			// init colors and label
			buttons.setVSButton("ekg");
			buttons.setVSButton("SpO2");
			buttons.setVSButton("CO2");
			
			// bind button events
			$('#button-ekg').click(function() {
				buttons.bindVSButton("ekg");
			});
			$('#button-SpO2').click(function() {
				buttons.bindVSButton("SpO2");
			});
			$('#button-CO2').click(function() {
				buttons.bindVSButton("CO2");
			});
		},
		
		setVSButton: function(buttonType) {
			if(controls[buttonType].leadsConnected == false) {
				$('#button-' + buttonType).css({
					'background-color': buttons.disconnectColor
					}).prop('title', controls[buttonType].disconnectHTML);
			} else {
				$('#button-' + buttonType).css({
					'background-color': buttons.connectColor
					}).prop('title', controls[buttonType].connectHTML);			
			}
		},
		
		bindVSButton: function(buttonType) {
				var value = 0;
				if(controls[buttonType].leadsConnected == false) {
					value = 1;
				}
				
				// send command based on button type
				if(buttonType == 'ekg') {
					simmgr.sendChange({'set:cardiac:ecg_indicator': value});
				} else if(buttonType == 'SpO2') {
					simmgr.sendChange({'set:respiration:spo2_indicator': value});					
				} else if(buttonType == 'CO2') {
					simmgr.sendChange({'set:respiration:etco2_indicator': value});										
				}
		}
	}