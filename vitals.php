<?php
	require_once('init.php');
	// get profile ini
	$profileURL = parse_ini_file(SERVER_PROFILES . "profile.ini", TRUE);
	$profileURL = SERVER_PROFILES . $profileURL['settings']['defaultProfile'];
	$profileINI = json_encode(parse_ini_file($profileURL, TRUE));

	$profileINI_Decoded = json_decode($profileINI, TRUE);

?>
<!DOCTYPE html >
<html>
  <head>
    <?php require_once(SERVER_INCLUDES . "header.php"); ?>
	<script type="text/javascript">
var isVitalsMonitor = 1;	// Student Display Flag

			$(document).ready(function() {
				
				// init profile data
				//profile.profileINI = <?= $profileINI; ?>;
				//profile.init();
				
				// Resize Chart based on Window Size
				Wwidth = $(window).width();
				Wheight = $(window).height();
				console.log("Screen size ", Wwidth, Wheight );
				//$("#vsm").css({width:(Wwidth-40), height:(Wheight)} );
				
				//$("#vs-left-col").css({width:(Wwidth-190)} );
				//$(".wide-col").css({width:(Wwidth-40)} );
				chart.init();
				simmgr.init();
				controls.heartRate.init();
				controls.awRR.init();
				controls.SpO2.init();
				controls.etCO2.init();
				controls.Tperi.init();
				controls.nbp.init();
				//buttons.init();
				//events.init();
				//scenario.init();
				//media.init();
				//log.init();
			});
		</script>
<style type="text/css" media="screen">
  * {
    margin: 0px 0px 0px 0px;
    padding: 0px 0px 0px 0px;
  }

  body, html {
    padding: 3px 3px 3px 3px;

    background-color: black;
	color: yellow;

    font-family: Verdana, sans-serif;
    font-size: 11pt;
    text-align: left;
  }		
	</style>
	
</head>

<body>
			<div id="vsm" class="float-left ii-border">
				<h1>VS Monitor</h1>
				<div id="vs-left-col">
					<canvas id="vs-trace-1" class="vs-trace" width="500" height="125" onclick="modal.heartRhythm(); return false;"></canvas>
					<canvas id="vs-trace-2" class="vs-trace" width="500" height="125" onclick="modal.respRhythm(); return false;"></canvas>
				</div>
				<div id="vs-right-col">
					<div class="vs-controls clearer">
						<a href="javascript: void(0)" onclick="modal.heartRhythm(); return false;"class="strip-label color-green">HR</a>
					</div>
					<div id="vs-heartRhythm" class="vs-controls">
						<a href="javascript: void(0)" onclick="modal.heartRate(); return false;" class="display-rate color-green">70</a>
					</div>
					<div class="vs-controls clearer">
						<a href="javascript: void(0)" class="strip-label color-white">etCO<sub>2</sub></a>
					</div>
					<div id="vs-etCO2" class="vs-controls">
						<a href="javascript: void(0)" onclick="modal.etCO2(); return false;" class="display-rate color-white">75</a>
					</div>
				</div>
				<div class="wide-col">
					<div class="alt-control control-Tperi">
						<a class="alt-control-title color-blue" href="javascript: void(0)" onclick="modal.Tperi(); return false;">Tperi</a>
						<a class="alt-control-rate color-blue" href="javascript: void(0)" onclick="modal.Tperi(); return false;" id="display-Tperi">123</a>
					</div>
					<div class="alt-control awRR">
						<a class="alt-control-title color-white" href="javascript: void(0)" onclick="modal.awRR(); return false;">awRR</a>
						<a class="alt-control-rate color-white" href="javascript: void(0)" onclick="modal.awRR(); return false;">123</a>
					</div>
					<div class="alt-control with-sub SpO2">
						<a class="alt-control-title color-yellow" href="javascript: void(0)" onclick="modal.SpO2(); return false;">SpO<sub>2<sub></a>
						<a id="display-SpO2" class="alt-control-rate color-yellow" href="javascript: void(0)" onclick="modal.SpO2(); return false;">123</a>
					</div>
					<div id="vs-nbp" class="alt-control">
						<a class="alt-control-title color-red" href="javascript: void(0)" onclick="modal.nbp(); return false;">NIBP</a>
						<a id="display-nbp" class="alt-control-rate nbip color-red" href="javascript: void(0)" onclick="modal.nbp(); return false;"><span id="displayed-systolic">140</span>/<span id="displayed-diastolic">75</span> (<span id="displayed-meanNBP">80</span>) <span class="nbip-label">mmHg</span></a>
						<a id="display-nbp-hr" class="alt-control-rate color-red" href="javascript: void(0)" onclick="modal.nbp(); return false;"><span style="font-size: 24px;">PR</span> <span id="displayed-reportedHR">75</span></a>
					</div>
				</div>
				

			</div>
			<button id="startStopButton">Stop</button>
</body>
</html>