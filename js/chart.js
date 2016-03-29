	
	// routine to get max of an array
	Array.prototype.max = function () {
		return Math.max.apply(Math, this);
	};
	
	var chart = {
		status: {
			cardiac: {
				heartRate: 0,
				synch: false
			},
			
			resp: {
				synch: false
			}
		},
			
		// ekg strip parameters
		ekg: {
			width: 0,				// width of strip in pixels
			height: 125,			// height of strip in pixles
			id: 'vs-trace-1',		// id of canvas for strip
			interval: 0,			// variable to hold interval instantiation
			color: 'green',			// color of trace (either hex or html color)
			rhythm: new Array,		// array of digitized rhythms
			yOffset: 0,				// yOffset of trace
			xOffsetLeft: 10,		// left xOffset of trace
			xOffsetRight: 0,		// right xOffset of trace
			rhythmIndex: 0,			// index of current rhythm being displayed
			length: 0,				// variable to hold length of pattern
			patternIndex: 0,		// index of currently displayed pixel in pattern
			lastY: 0,				// variable to save last displayed Y coordinate of pattern
			xPos: 0,				// current x position on strip
			drawInterval: 13,		// interval in milli-sec to display pixels
			noiseMax: 2,			// max amplitude of background noise total +/-
			stopFlag: false,			// stop flag 
			beepValue: 0,			// value to beep at
			beepFlag: false
		},
		
		// respiration strip parameters
		resp: {
			width: 0,				// width of strip in pixels
			height: 125,			// height of strip in pixles
			id: 'vs-trace-2',		// id of canvas for strip
			interval: 0,			// variable to hold interval instantiation
			color: 'white',			// color of trace (either hex or html color)
			rhythm: new Array,		// array of digitized rhythms
			yOffset: 0,				// yOffset of trace
			xOffsetLeft: 10,		// left xOffset of trace
			xOffsetRight: 0,		// right xOffset of trace
			rhythmIndex: 0,			// index of current rhythm being displayed
			length: 0,				// variable to hold length of pattern
			patternIndex: 0,		// index of currently displayed pixel in pattern
			lastY: 0,				// variable to save last displayed Y coordinate of pattern
			xPos: 0,				// current x position on strip
			drawInterval: 25,		// interval in milli-sec to display pixels
			stopFlag: false			// stop flag
		},
		
		cursorWidth: 10,			// width of cursor in pixels

		// assume document is rendered before calling init.
		init: function() {
			/************************** EKG **********************************/
			// init respiration
			chart.initStrip('ekg');
			
			// init rhythm patterns
			/*
			chart.ekg.rhythm[0] = [
				 0,  1,  2,  3,  5, 8, 10, 5,
				 1,  0,  1,  3,  6, 15, 25, 37,  45,
				 50, 45, 37,
				 24, 16, 10,  6,  3,  1,  -5, -8, -10, -5, 0
			];
			chart.ekg.rhythm[1] = [
				2,  0,  0,  2,  -5,  -8, -15, -25, -37, -45, -50, -45,
				-37, -24, -15,  -8,  3,  1,  0,  0,  0,  0
			];
			chart.ekg.rhythm[2] = [
				2,  0,  0,  2,  -5,  -8, -15, -25, -37, -45, -50, -45,
				-37, -24, -15,  -8,  3,  1,  0,  0,  0,  0
			];
			*/
			chart.ekg.rhythm[0] = [
			0, 0, 0, 0, 0, 0, 0		// Flatline
			];
			chart.ekg.rhythm[1] = [
			7, 7, 8, 8, 8, 7, 7, 6, 6, 6, 7, 7, 7, 8, 7, 7, 7 // Currently Unused
			];
			chart.ekg.rhythm[2] = [
			7, 7, 8, 8, 8, 7, 7, 6, 6, 6, 7, 7, 7, 8, 7, 7, 7 // Random - Pattern is not actually used.
			];
			chart.ekg.rhythm[3] = [
			4, 3, 4, 6, 7, 7, 6, 4, 2, 1, 1, 1, 2, 2, 2, 3, 17, 52, 64, 26, -3, -5, -2, 0, 1, 2, 3, 4, 4, 5, 6, 7, 8, 10, 11, 13, 15, 16, 17, 17, 16, 14, 10, 7, 4, 2, 1, 0, 0, 1, 1 // Up to 75
			];
			chart.ekg.rhythm[4] = [
			4, 3, 6, 7, 4, 2, 1, 2, 3, 17, 64, 26, -5, -2, 0, 2, 4, 5, 6,  10, 11, 15, 16, 17, 16, 10, 4, 1, 0, 1 // Up to 140
			];
			chart.ekg.rhythm[5] = [
			4, 3, 7, 4, 1, 3, 35, 64, -5, -2, 4, 6, 11, 15, 17, 10, 4, 1 // Up to 230
			];
			chart.ekg.rhythm[6] = [
			3, 7, 1, 3, 35, 64, -5, 4, 11, 17, 4, 1 // Up to 300
			]
			// setup pattern length
			chart.ekg.length = chart.ekg.rhythm[chart.ekg.rhythmIndex].length
			
			// setup beep value
			chart.ekg.beepValue = chart.ekg.rhythm[0].max() * -1;
			
			// start the pattern
			chart.ekg.interval = setInterval(chart.drawEkgPixel, chart.ekg.drawInterval);
			
			/************************** Respiration **********************************/
			// init respiration
			chart.initStrip('resp');
			
			// init rhythm patterns
			chart.resp.rhythm[1] = [ 
				0,1,2,4,8,16,24,28,30,31,
				32,33,34,35,36,37,38,39,40,41,42,43,44,45,
				44,43,42,41,40,35,31,30,28,24,16,8,4,2,1,
				0,
			];
			chart.resp.rhythm[0] = [ 
				0,1,2,4,8,16,24,28,30,31,32,32,32,32,32,32,32,
				32,32,32,32,32,
				32,32,32,32,32,
				32,32,32,32,32,
				32,32,32,32,32,31,25,15,8,0,0,0,0,0
			];
			
			// beep indicator
			if(chart.ekg.beepFlag == true){
				$('#ekg-sound').html('Turn EKG Sound OFF!').removeClass('play').addClass('pause')
			} else {
				$('#ekg-sound').html('Turn EKG Sound ON!').removeClass('pause').addClass('play')			
			}
			
			// setup pattern length
			chart.resp.length = chart.resp.rhythm[chart.resp.rhythmIndex].length
			
			// start the pattern
			chart.resp.interval = setInterval(chart.drawRespPixel, chart.resp.drawInterval, "resp");
		},
		
		// Passed the cardiac data from simmgr status
		updateCardiac: function( cardiac) {
			if ( cardiac.rate <= 0 )
			{
				chart.ekg.rhythmIndex = 0;	// Flatline
			}
			else if ( cardiac.rate <= 75 )
			{
				chart.ekg.rhythmIndex = 3;
			}
			else if ( cardiac.rate <= 140 )
			{
				chart.ekg.rhythmIndex = 4;
			}
			else if ( cardiac.rate <= 230 )
			{
				chart.ekg.rhythmIndex = 5;
			}
			else
			{
				chart.ekg.rhythmIndex = 6;
			}
			chart.ekg.length = chart.ekg.rhythm[chart.ekg.rhythmIndex].length;
			if(chart.ekg.patternIndex >= chart.ekg.length) {
				chart.ekg.patternIndex = 0;
			}
			
			chart.heartRate = cardiac.rate;
			controls.heartRate.value = cardiac.rate;
			console.log(cardiac );
		},
		initStrip: function(stripType) {
			chart[stripType].canvas = document.getElementById(chart[stripType].id);
			chart[stripType].ctx = chart[stripType].canvas.getContext("2d");
			chart[stripType].xPos = chart[stripType].xOffsetLeft;
			chart[stripType].yOffset = chart[stripType].lastY = Math.floor(chart[stripType].height / 2);
			
			// set width of strip dynamically
			chart[stripType].width = $('#' + chart[stripType].id).width() - chart[stripType].xOffsetLeft - chart[stripType].xOffsetRight;
			return;
		},
		
		drawEkgPixel: function() {
			var y;

			// Create the 'cursor' by clearing out a 10px wide section in front of the pixel
			chart.drawCursor('ekg');
	
//console.log(chart.ekg.patternIndex)
			
			// see if we need to draw waveform or if we are in background
			if(chart.ekg.stopFlag == true) {
				y = 0;
				controls.heartRate.audio.pause();
			} else if(chart.ekg.rhythmIndex == 2) {
				// generate random noise between range
				y = (Math.floor((Math.random() * chart.ekg.yOffset)) * -1) + (chart.ekg.yOffset / 2);

			} else if(chart.status.cardiac.synch == false && chart.ekg.patternIndex == 0) {
				// generate random noise between range
				y = Math.floor((Math.random() * chart.ekg.noiseMax));
				if(y > (chart.ekg.noiseMax / 2)) {
					y -= (chart.ekg.noiseMax / 2);
				}
			} else if(chart.status.cardiac.synch == true || chart.ekg.patternIndex > 0) {
				y = chart.ekg.rhythm[chart.ekg.rhythmIndex][chart.ekg.patternIndex] * -1;
				
				// beep?
				if(y == chart.ekg.beepValue && chart.ekg.beepFlag == true && chart.ekg.stopFlag == false) {
					// controls.heartRate.audio.load();  // Don't do this!!
					controls.heartRate.audio.play();
				}
				
				// increment pointers
				chart.ekg.patternIndex++;
			}
			
			// clear out sync flag
			if(chart.status.cardiac.synch == true) {
				chart.status.cardiac.synch = false;
			}
			
			// are we beyond pattern?
			if(chart.ekg.patternIndex >= chart.ekg.length) {
				chart.ekg.patternIndex = 0;
			}
			
			y += chart.ekg.yOffset;
			
			// create stroke
			chart.ekg.ctx.lineWidth = 2;
			chart.ekg.ctx.strokeStyle = chart.ekg.color;
			chart.ekg.ctx.beginPath();
			chart.ekg.ctx.moveTo(chart.ekg.xPos, chart.ekg.lastY);
			
			// increment xpos
			chart.ekg.xPos++;
			
			chart.ekg.ctx.lineTo(chart.ekg.xPos, y);
			chart.ekg.ctx.stroke();
						
			// save last values for next segment
			chart.ekg.lastY = y;
			
			// see if we are beyond end of chart
			if((chart.ekg.xPos + chart.ekg.xOffsetRight) > chart.ekg.width) {
				chart.ekg.xPos = chart.ekg.xOffsetLeft;
				chart.ekg.ctx.fillRect(0, 0, chart.ekg.xOffsetLeft, chart.ekg.height);
			}
		},
		
		drawCursor: function(stripType) {
			// Create the 'cursor' by clearing out section in front of the pixel
			chart[stripType].ctx.fillStyle="black";
			chart[stripType].ctx.clearRect(chart[stripType].xPos, 0, chart.cursorWidth, chart[stripType].height );
		},
		
		
		drawRespPixel: function() {
			var y;

			// Create the 'cursor' by clearing out a 10px wide section in front of the pixel
			chart.drawCursor('resp');
	
//console.log(chart.ekg.patternIndex)
			
			// see if we need to draw waveform or if we are in background
			if((chart.status.resp.synch == false && chart.resp.patternIndex == 0) || chart.resp.stopFlag == true) {
				// generate random noise between range
				y = 0;
			} else if(chart.status.resp.synch == true || chart.resp.patternIndex > 0) {
				y = chart.resp.rhythm[chart.resp.rhythmIndex][chart.resp.patternIndex] * -1;
				
				// increment pointers
				chart.resp.patternIndex++;
			}
			
			// clear out sync flag
			if(chart.status.resp.synch == true) {
				chart.status.resp.synch = false;
			}
			
			// are we beyond pattern?
			if(chart.resp.patternIndex >= chart.resp.length) {
				chart.resp.patternIndex = 0;
			}
			
			y += chart.resp.yOffset;
			
			// create stroke
			chart.resp.ctx.lineWidth = 2;
			chart.resp.ctx.strokeStyle = chart.resp.color;
			chart.resp.ctx.beginPath();
			chart.resp.ctx.moveTo(chart.resp.xPos, chart.resp.lastY);
			
			// increment xpos
			chart.resp.xPos++;
			
			chart.resp.ctx.lineTo(chart.resp.xPos, y);
			chart.resp.ctx.stroke();
						
			// save last values for next segment
			chart.resp.lastY = y;
			
			// see if we are beyond end of chart
			if((chart.resp.xPos + chart.resp.xOffsetRight) > chart.resp.width) {
				chart.resp.xPos = chart.resp.xOffsetLeft;
				chart.resp.ctx.fillRect(0, 0, chart.resp.xOffsetLeft, chart.resp.height);
			}
		},
	}
