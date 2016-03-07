/* 
	simmgr Communications

	After init, this class will poll the simmgr via AJAX to
	fetch parameter changes for display. It will push sync
	signals to the EKG and Respiration strip charts.
	
	The AJAX call is to the cgi function: 
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
		
		if ( isLocalDisplay() )
		{
			simmgr.interval = 50;
		}
		else
		{
			simmgr.interval = 100;
		}
		simmgr.timer = setTimeout(function() { simmgr.getStatus(); }, simmgr.interval );
		simmgr.running = 1;
		
		$("#startStopButton").click(function(){
			var txt = $(this).text();
			if ( txt == "Start" )
			{
				simmgr.running = 1;
				simmgr.timer = setTimeout(function() { simmgr.getStatus(); }, simmgr.interval );
				$(this).text("Stop");
			}
			else
			{
				simmgr.running = 0;
				clearTimeout(simmgr.timer );
				$(this).text("Start");
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
				//console.log("success: "+textStatus );
				//console.log(response);
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
	}
}
