var media = {
	currentMediaFileName: 'xray.jpg',
	mediaIsDisplayed: false,
	
	init: function() {
		media.clearMedia();

		// bind event of scenario button
		$('#media-button').click(function() {
			if(media.mediaIsDisplayed == true) {
				media.clearMedia();
			} else {
				media.showMedia();			
			}
		});
		
		// create dropdown for media select
		var mediaOptionContent = '';
		var mediaSelected = '';
		for(var index = 0; index < scenario.scenarioMedia.file.length; index++) {
			
			if(scenario.scenarioMedia.file[index]['filename'] == media.currentMediaFileName) {
				mediaSelected = ' selected="selected" ';
			} else {
				mediaSelected = '';			
			}
			mediaOptionContent += '<option value="' + scenario.scenarioMedia.file[index]['filename'] + '" ' + mediaSelected + '>' + scenario.scenarioMedia.file[index]['title'] + '</option>';
		}
		$('#media-select > select').html(mediaOptionContent);

	},
	
	showMedia: function() {
		$('#media-button').css({'background-color': buttons.connectColor, 
									border: '1px solid ' + buttons.connectColor
									}).html('Remove Media');
		media.mediaIsDisplayed = true;
		$('#media-select select').prop('disabled', true);
		/* code stub for SimMgr */
		return;
	},

	clearMedia: function() {
		$('#media-button').css({'background-color': buttons.disconnectColor,
									border: '1px solid ' + buttons.disconnectColor
									}).html('Show Media');
		media.mediaIsDisplayed = false;
		$('#media-select select').prop('disabled', false);
		/* code stub for SimMgr */
		return;
	}
}