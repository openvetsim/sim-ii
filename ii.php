<?php
	require_once('init.php');
	
	// delete session data
	$status = adminClass::isUserLoggedIn();
	if($status === FALSE) {
		header('location: index.php');
	}
	
	$userRow = adminClass::getUserRowFromSession();
	$userName = $userRow['UserFirstName'] . " " . $userRow['UserLastName'];
	
	// get scenario list
	$scenarioList = scandir(SERVER_SCENARIOS);
	$scenarioContent = '';
	foreach($scenarioList as $key => $scenario) {
		if(is_dir(SERVER_SCENARIOS . $scenario) === TRUE) {
			continue;
		}
		
		// open file, create scenario dropdown
		$scenarioFileArray = pathinfo(SERVER_SCENARIOS . $scenario);
		$scenarioHeader = scenarioXML::getScenarioHeaderArray($scenarioFileArray['filename']);
		$scenarioContent .= '
			<option value="' . $scenario . '">' . $scenarioHeader['title']['name'] . '</option>
		';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once(SERVER_INCLUDES . "header.php"); ?>
		
		<script type="text/javascript">
			$(document).ready(function() {
				// init menu
				menu.init();
				
				// init profile data
				scenario.loadScenario();
				profile.init();
				
				chart.init();
				
				controls.heartRate.init();
				controls.awRR.init();
				controls.SpO2.init();
				controls.etCO2.init();
				controls.Tperi.init();
				controls.nbp.init();
				buttons.init();
				events.init();
				scenario.init();
				media.init();
				log.init();
				
				// init displayed values
				$('#vs-heartRhythm p.display-rate').html(controls.heartRate.value);
				$('#vs-awRR p.display-rate').html(controls.awRR.value);
				
				// demo controls -- will be removed for production
				// demo beat now
				/*
				$('#switch-ekg-now').click(function() {
					if(chart.ekg.rhythmIndex == 0) {
						chart.ekg.rhythmIndex = 1;
					} else if(chart.ekg.rhythmIndex == 1) {
						chart.ekg.rhythmIndex = 2;
					} else {
						chart.ekg.rhythmIndex = 0;
					}
					chart.ekg.length = chart.ekg.rhythm[chart.ekg.rhythmIndex].length
				});
				$('#ekg-sound').click(function() {
					if($(this).hasClass('play') == true) {
						controls.heartRate.audio.play();
						$(this).removeClass('play').addClass('pause');
						$(this).html('Turn EKG Sound OFF!');
						chart.ekg.beepFlag = true;
					} else {
						$(this).removeClass('pause').addClass('play');
						$(this).html('Turn EKG Sound ON!');
						chart.ekg.beepFlag = false;
					}
				
				});
				
				$('#switch-resp-now').click(function() {
					if(chart.resp.rhythmIndex == 0) {
						chart.resp.rhythmIndex = 1;
					} else {
						chart.resp.rhythmIndex = 0;
					}
					chart.resp.length = chart.resp.rhythm[chart.resp.rhythmIndex].length
				});
				*/
				simmgr.init();
			});
		</script>
		<style>
			#startStopButton
			{
				position: absolute;
				bottom: 0px;
				right: 0px;
			}
		</style>
	</head>
	<body>
		<div id="sitewrapper">
			<div id="admin-nav">
				<h1>Cornell Vet School Simulator</h1>
				<h1 class="welcome-title">Welcome <?= $userName; ?></h1>
				<div class="profile-display scenario">
					Scenario: <span id="scenario-name-display">Default Scenario: Frame 1</span>
				</div>
				<ul id="main-nav">
					<li class="with-sub-nav">
						<a href="javascript:void(2);">File</a>
						<ul class="sub-nav">
							<li><a href="javascript: void(2);">File Another Item</a></li>
							<li><a href="javascript: void(2);">File Another Item</a></li>
							<li><a href="javascript: void(2);">File Another Item</a></li>
							<li><a href="javascript: void(2);">File Another Item</a></li>
						</ul>
					</li>
					<li class="with-sub-nav">
						<a href="javascript:void(2);">Settings</a>
						<ul class="sub-nav">
							<li><a href="javascript: void(2);">Settings Another Item</a></li>
							<li><a href="javascript: void(2);">Settings Another Item</a></li>
							<li><a href="javascript: void(2);">Settings Another Item</a></li>
							<li><a href="javascript: void(2);">Settings Another Item</a></li>
						</ul>
					</li>
					<li >
						<a href="javascript:void(2);" onclick="modal.showUsers();">Users</a>
					</li>
					<li >
						<a href="javascript:void(2);" onclick="modal.showEvents(); return false;">Events</a>
					</li>
					<li class="logout">
						<a href="index.php">Logout</a>						
					</li>
					<li class="logout">
						Version: <?= VERSION_MAJOR . '.' . VERSION_MINOR; ?>						
					</li>
				</ul>
			</div>

			<div id="mannequin" class="clearer float-left ii-border">
				<h1>Non Vital Controls</h1>
				<h2 id="button-SpO2-title" class="nvs-button"></h2>
				<img class="nvs-button" id="button-SpO2" src="<?= BROWSER_IMAGES; ?>spo2.png" alt="SpO2 Icon">
				<h2 id="button-ekg-title" class="nvs-button"></h2>
				<img class="nvs-button" id="button-ekg" src="<?= BROWSER_IMAGES; ?>ekg.png" alt="EKG Icon">
				<h2 id="button-CO2-title" class="nvs-button"></h2>
				<img class="nvs-button" id="button-CO2" src="<?= BROWSER_IMAGES; ?>co2.png" alt="CO2 Icon">

				<div id="vocals-dog-control" class="dog-control">
					<a href="javascript: void(2)" onclick="modal.vocals(); return false;">Vocals</a>
					<a class="sound-mute" id="vocals-mute" href="javascript: void(2)" onclick="modal.vocals(); return false;"><img src="<?= BROWSER_IMAGES; ?>sound_mute.png"></a>
				</div>
				<div id="pulse-dog-control" class="dog-control">
					<a href="javascript: void(2)" onclick="modal.pulseStrength(); return false;">Pulse Strength</a>
				</div>
				<div id="left-lung-dog-control" class="dog-control">
					<a href="javascript: void(2)" onclick="modal.leftLung(); return false;">Left Lung</a>
					<a class="sound-mute" id="left-lung-mute" href="javascript: void(2)" onclick="modal.leftLung(); return false;"><img src="<?= BROWSER_IMAGES; ?>sound_mute.png"></a>
				</div>
				<div id="right-lung-dog-control" class="dog-control">
					<a href="javascript: void(2)" onclick="modal.rightLung(); return false;">Right Lung</a>
					<a class="sound-mute" id="right-lung-mute" href="javascript: void(2)" onclick="modal.rightLung(); return false;"><img src="<?= BROWSER_IMAGES; ?>sound_mute.png"></a>
				</div>
				<div id="heart-sound-dog-control" class="dog-control">
					<a href="javascript: void(2)" onclick="modal.heartSound(); return false;">Heart Sound</a>
					<a class="sound-mute" id="heart-sound-mute" href="javascript: void(2)" onclick="modal.heartSound(); return false;"><img src="<?= BROWSER_IMAGES; ?>sound_mute.png"></a>
				</div>
				<div id="chest-dog-control" class="dog-control">
					<a href="javascript: void(2)" onclick="modal.chestRise(); return false;">Chest Movement</a>
				</div>
			</div>
			
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
						<a href="javascript: void(0)" onclick="modal.etCO2(); return false;" class="strip-label color-white">ETCO<sub>2</sub></a>
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
						<a id="display-nbp-hr" class="alt-control-rate color-red" href="javascript: void(0)" onclick="modal.nbp(); return false;"><span style="font-size: 18px;">PR</span> <span id="displayed-reportedHR">75</span></a>
					</div>
				</div>
				<button id="startStopButton">Stop Status Updates</button>
				<!-- <div class="float-left ii-border button demo-button">
					<button id="switch-ekg-now">Switch EKG Patterns!</button>
					<button id="ekg-sound" class="pause">Turn EKG Sound Off!</button>
					<button id="switch-resp-now">Switch Resp Patterns!</button>
				</div> -->
			</div>
			
			<div id="media-col">
				<div id="scenario-select" class="float-left clearer ii-border">
					<h2 class="float-left clearer">Scenario Select:</h2>
					<select class=" clearer float-left">
						<?= $scenarioContent; ?>
					</select>
					<button id="scenario-button" class="scenario-button float-left">Start Scenario</button>
					<h2 id="scenario-video-label">Start Video With Scenario</h2>
					<input type="checkbox" id="start-video" class="float-left">
					<p id="scenario-run-time" class="clearer float-left">Scenario Running time: <span id="scenario-running-time">01:01</span></p>
					<button id="scenario-terminate-button" class="scenario-button float-left">Terminate Scenario</button>
				</div>
				<div id="media-select" class="float-left clearer ii-border">
					<h2 class="float-left clearer">Media Select:</h2>
					<select class="clearer float-left">
					</select>
					<button id="media-button" class="scenario-button float-left">Show Media</button>
				</div>
			</div>
			<div id="event-monitor" class="float-right ii-border">
				<table>
					<tr>
						<td class="time-stamp">00:00:00</td>
						<td class="event">VS: awRR: 90; HR: 80; BP: 120/80; SP02: 90; etCO2: 34 mmHg</td>
					</tr>
					<tr>
						<td class="time-stamp">00:01:00</td>
						<td class="event">VS: awRR: 90; HR: 80; BP: 120/80; SP02: 90; etCO2: 34 mmHg</td>
					</tr>
					<tr>
						<td class="time-stamp">00:02:00</td>
						<td class="event">VS: awRR: 90; HR: 80; BP: 120/80; SP02: 90; etCO2: 34 mmHg</td>
					</tr>
					<tr>
						<td class="time-stamp">00:03:00</td>
						<td class="event">VS: awRR: 90; HR: 80; BP: 120/80; SP02: 90; etCO2: 34 mmHg</td>
					</tr>
					<tr>
						<td class="time-stamp">00:04:00</td>
						<td class="event">VS: awRR: 90; HR: 80; BP: 120/80; SP02: 90; etCO2: 34 mmHg</td>
					</tr>
					<tr>
						<td class="time-stamp">00:05:00</td>
						<td class="event">VS: awRR: 90; HR: 80; BP: 120/80; SP02: 90; etCO2: 34 mmHg</td>
					</tr>
				</table>
			</div>

			<div id="event-library" class="float-left"></div>

			<div class="clearer"></div>
		</div> <!-- sitewrapper -->
		
		<!-- Modal -->
		<div id="modal">
			<div class="container">
				<div id="modal-content">
				</div>
				<a class="close_modal" href="javascript: void(2);">
					<img src="<?= BROWSER_IMAGES; ?>x.png" alt="Close Modal">
				</a>
			</div>
		</div>
	</body>
</html>