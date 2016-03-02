var media = {
	currentMediaURL: '',
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