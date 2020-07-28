/*
sim-ii: Copyright (C) 2020  VetSim, Cornell University College of Veterinary Medicine Ithaca, NY

See gpl.html
*/
/* 
	simulation sounds for TeleSim 
*/


var simsound = {
	currentHeart : 0,
	currentLung : 0,
	init : function() {
	},
	
	play : function(index, level ) {
		console.log ("play", index, level );
		if ( typeof(level) == 'undefined' )
		{
			level = 5;
		}
		if ( index > 0 )
		{
			var sound = $('#snd_'+index).get(0);
			sound.pause();
			sound.currentTime = 0;
			level = level / 10;
			console.log("Level", level );
			sound.volume = level;
			sound.play();
		}
	},
	
	playHeartSound : function() {
		if ( typeof(controls.auscultation) !== 'undefined' &&  controls.auscultation.side > 0 )
		{
			console.log("Heart", controls.auscultation.side, controls.auscultation.col, controls.auscultation.row );
			if ( typeof(simsound.tags[controls.auscultation.side] ) == 'undefined' )
				console.log("Side not in table" );
			else if ( typeof(simsound.tags[controls.auscultation.side][controls.auscultation.col] ) == 'undefined' )
				console.log("Col (X) not in table" ); 
			else if ( typeof(simsound.tags[controls.auscultation.side][controls.auscultation.col][controls.auscultation.row] ) == 'undefined' )
				console.log("Row (Y) not in table" ); 
			else
			{
				var level = simsound.tags[controls.auscultation.side][controls.auscultation.col][controls.auscultation.row].heartStrength;
				simsound.play(simsound.currentHeart, level );
			}
		}
	},
	
	playLungSound : function() {
		if ( typeof(controls.auscultation) !== 'undefined' &&  controls.auscultation.side > 0 )
		{
			console.log("Lung", controls.auscultation.side, controls.auscultation.col, controls.auscultation.row );
			if ( typeof(simsound.tags[controls.auscultation.side] ) == 'undefined' )
				console.log("Side not in table" );
			else if ( typeof(simsound.tags[controls.auscultation.side][controls.auscultation.col] ) == 'undefined' )
				console.log("Col (X) not in table" ); 
			else if ( typeof(simsound.tags[controls.auscultation.side][controls.auscultation.col][controls.auscultation.row] ) == 'undefined' )
				console.log("Row (Y) not in table" ); 
			else
			{
				var level = simsound.tags[controls.auscultation.side][controls.auscultation.col][controls.auscultation.row].lungStrength;
				simsound.play(simsound.currentLung, level );
			}
		}
	},
	
	lookupLungSound : function() {
		console.log ("Lookup Lung sound is", simmgr.respResponse.left_lung_sound, simmgr.respResponse.rate  );
		$.each(soundPlayList, function(idx, el) {
			//console.log ( el );
			if ( el.type == 'lung' && el.name == simmgr.respResponse.left_lung_sound )
			{
				var rate = simmgr.respResponse.rate;
				var low = el.low_limit;
				var high = el.high_limit;
				//console.log ( el, low, ">=", rate, "<=", high );
				if ( rate >= low && rate <= high )
				{
					simsound.currentLung = el.index;
					console.log ("Lung sound is", simsound.currentLung );
					return false;
				}
			}
		});
	},
	
	
	lookupHeartSound : function() {
		console.log ("Lookup Heart sound is", controls.heartSound.soundName, controls.heartRate.value  );
		$.each(soundPlayList, function(idx, el) {
			if ( el.type == 'heart' && 
				el.name == controls.heartSound.soundName &&  
				controls.heartRate.value >= el.low_limit &&
				controls.heartRate.value <= el.high_limit )
			{
				simsound.currentHeart = el.index;
				
				console.log ("Heart sound is", simsound.currentHeart );
				return false;
			}
		});
	},
	
	parseTags : function() {
		// Tags are loaded to the scenario section and processed here
		simsound.tags = new Array();
		simsound.tags[1] = new Array();	// First dimension is the sides, 
		simsound.tags[2] = new Array();
		simsound.tags[3] = new Array();
		//console.log(scenario.soundtags.tag );
		$.each(scenario.soundtags.tag, function(idx, tag ) {
			console.log(idx, tag );
			if ( typeof(simsound.tags[tag.side][tag.xPosition] ) == 'undefined' )
			{
				simsound.tags[tag.side][tag.xPosition] = new Array();
			}
			simsound.tags[tag.side][tag.xPosition][tag.yPosition] = tag;
		});
		console.log(simsound.tags);
	}
	
}