<?php
	require_once('init.php');
	
	$status = adminClass::isUserLoggedIn();
	if($status === FALSE) {
		header('location: index.php?sts='.$status );
	}
	
	$userRow = adminClass::getUserRowFromSession();
	$userName = $userRow['UserFirstName'] . " " . $userRow['UserLastName'];
	$uid = $userRow['UserID'];
	$sessionID = session_id();
	
	// get scenario list
	$scenarioFolderList = scandir(SERVER_SCENARIOS);
	$scenarioContent = '';
	foreach($scenarioFolderList as $key => $scenarioFolder) {
		if(is_dir(SERVER_SCENARIOS . $scenarioFolder) === TRUE) {
			if( $scenarioFolder == '.' || $scenarioFolder == '..' || $scenarioFolder == '.git' ) {
				continue;
			}
			
			if(file_exists(SERVER_SCENARIOS . $scenarioFolder . DIRECTORY_SEPARATOR . 'main.xml') === TRUE) {
				$scenarioHeader = scenarioXML::getScenarioHeaderArray($scenarioFolder . DIRECTORY_SEPARATOR . 'main');
				$scenarioContent .= '
					<option value="' . $scenarioFolder . '">';
				if ( isset($scenarioHeader['title']['name'] ) && strlen($scenarioHeader['title']['name']) > 0 ) {
					$scenarioContent .= $scenarioHeader['title']['name'];
				} else {
					$scenarioContent .= $scenarioFolder;
				}
				$scenarioContent .= '</option>
				';
			}
		}
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once(SERVER_INCLUDES . "header.php"); ?>
		
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>demo.js?v=<?= $ts ?>"></script>
		<script type="text/javascript">
var userID = <?= $uid ?>;
document.cookie = "userID="+userID+"; path=/";
var isVitalsMonitor = 0;	// Student Display Flag
			$(document).ready(function() {
				console.log(document.cookie );
				
				// init menu
				menu.init();
				
				// Initialize the demo
				simDemo.init();
				
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
				controls.pulse.init();
				buttons.init();
				events.init();
				scenario.init();
//				media.init();
//				log.init();

				// init patient info
				profile.initPatientInfo();
				controls.heartRhythm.calculateVPCFreq();
console.log(controls['awRR'].increment);
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
				controls.cpr.init();
				controls.manualRespiration.init();
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
				<h1>Cornell Vet School Simulator - Demo</h1>
				<h1 class="welcome-title">Welcome <?= $userName; ?></h1>
				<div class="profile-display scenario">
					Scenario Name: 
					<span id="scenario-name-display">Default Scenario</span>
					&nbsp;&nbsp;|&nbsp;&nbsp;Scene Name:&nbsp;<span id="scene-name">Test</span>
					&nbsp;&nbsp;|&nbsp;&nbsp;Scene ID:&nbsp;<span id="scene-id">1</span>
				</div>
				<ul id="main-nav">
					<!-- <li class="with-sub-nav">
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
					</li> -->
					<li >
						<a href="javascript:void(2);" onclick="modal.showUsers();">Users</a>
					</li>
					<li class="menu-events">
						<a href="javascript:void(2);" onclick="modal.showEvents(); return false;">Events</a>
					</li>

					<li class="logout">
						Version: <?= VERSION_MAJOR . '.' . VERSION_MINOR; ?>						
					</li>
					<li class="logout">
						<a href="index2.php" class="event-link">Logout</a>						
					</li>
					<li class="logout">
						<a href="javascript: void(2);" onclick="modal.manageScenarios();" class="event-link" id="scenario-click">Scenarios</a>						
					</li>
					<!-- <li class="logout">
						<a href="../../editor/editor.php"  class="event-link breath-link">Editor</a>						
					</li> -->
					<li class="logout">
						<a href="javascript: void(2);"  class="event-link cpr-link">Start CPR</a>						
					</li>
					<li class="logout">
						<a href="javascript: void(2);"  class="event-link breath-link">Manual Breath</a>						
					</li>
				</ul>
			</div>

			<div id="mannequin" class="clearer float-left ii-border">
				<h1>Non Vital Controls</h1>
				<h2 id="button-palpate-title" class="nvs-button"></h2>
				<img class="nvs-button" id="button-palpate" src="<?= BROWSER_IMAGES; ?>palpate.png" alt="Palpate Icon">
				<h2 id="button-cpr-title" class="nvs-button"></h2>
				<img class="nvs-button" id="button-cpr" src="<?= BROWSER_IMAGES; ?>empty.png" alt="CPR Icon">
				<h2 id="button-SpO2-title" class="nvs-button"></h2>
				<img class="nvs-button" id="button-SpO2" src="<?= BROWSER_IMAGES; ?>spo2.png" alt="SpO2 Icon">
				<h2 id="button-ekg-title" class="nvs-button"></h2>
				<img class="nvs-button" id="button-ekg" src="<?= BROWSER_IMAGES; ?>ekg.png" alt="EKG Icon">
				<h2 id="button-Tperi-title" class="nvs-button"></h2>
				<img class="nvs-button" id="button-Tperi" src="<?= BROWSER_IMAGES; ?>Tperi.png" alt="Temperature Icon">
				<h2 id="button-CO2-title" class="nvs-button"></h2>
				<img class="nvs-button" id="button-CO2" src="<?= BROWSER_IMAGES; ?>co2.png" alt="CO2 Icon">
				<h2 id="button-bpcuff-title" class="nvs-button"></h2>
				<img class="nvs-button" id="button-bpcuff" src="<?= BROWSER_IMAGES; ?>bpcuff.png" alt="bpcuff Icon">
				
				<!-- PEA and Cardiac Arrest Indicators -->
				<h2 id="indicator-pea">PEA</h2>
				<h2 id="indicator-arrest">Arrest</h2>

				<div id="vocals-dog-control" class="dog-control">
					<a id="vocals-dog-control-title" href="javascript: void(2)" onclick="modal.vocals(); return false;">Vocals</a>
					<a class="sound-mute" id="vocals-mute" href="javascript: void(2)" onclick="modal.vocals(); return false;"><img src="<?= BROWSER_IMAGES; ?>sound_mute.png"></a>
				</div>
				<div id="pulse-dog-control" class="dog-control">
					<a id="pulse-dog-control-title" href="javascript: void(2)" onclick="modal.pulseStrength(); return false;">Pulse Strength</a>
				</div>
				<div id="left-lung-dog-control" class="dog-control">
					<a id="left-lung-dog-control-title" href="javascript: void(2)" onclick="modal.leftLung(); return false;">Left Lung</a>
					<a class="sound-mute" id="left-lung-mute" href="javascript: void(2)" onclick="modal.leftLung(); return false;"><img src="<?= BROWSER_IMAGES; ?>sound_mute.png"></a>
				</div>
				<div id="right-lung-dog-control" class="dog-control">
					<a id="right-lung-dog-control-title" href="javascript: void(2)" onclick="modal.rightLung(); return false;">Right Lung</a>
					<a class="sound-mute" id="right-lung-mute" href="javascript: void(2)" onclick="modal.rightLung(); return false;"><img src="<?= BROWSER_IMAGES; ?>sound_mute.png"></a>
				</div>
				<div id="heart-sound-dog-control" class="dog-control">
					<a id="heart-sound-dog-control-title" href="javascript: void(2)" onclick="modal.heartSound(); return false;">Heart Sound</a>
					<a class="sound-mute" id="heart-sound-mute" href="javascript: void(2)" onclick="modal.heartSound(); return false;"><img src="<?= BROWSER_IMAGES; ?>sound_mute.png"></a>
				</div>
				<div id="chest-dog-control" class="dog-control">
					<a id="chest-dog-control-title" href="javascript: void(2)" onclick="modal.chestRise(); return false;">Chest Movement</a>
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
						<a href="javascript: void(0)" onclick="modal.heartRhythm(); return false;" class="strip-label color-green">HR</a>
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
						<a class="alt-control-title color-blue" href="javascript: void(0)" onclick="modal.Tperi(); return false;">Temp</a>
						<a class="alt-control-rate color-blue" href="javascript: void(0)" onclick="modal.Tperi(); return false;" id="display-Tperi">123</a>
					</div>
					<div class="alt-control awRR">
						<a class="alt-control-title color-white" href="javascript: void(0)" onclick="modal.awRR(); return false;">awRR</a>
						<a class="alt-control-rate color-white" href="javascript: void(0)" onclick="modal.awRR(); return false;">123</a>
					</div>
					<div class="alt-control with-sub SpO2">
						<a class="alt-control-title color-yellow" href="javascript: void(0)" onclick="modal.SpO2(); return false;">SpO<sub>2</sub></a>
						<a id="display-SpO2" class="alt-control-rate color-yellow" href="javascript: void(0)" onclick="modal.SpO2(); return false;">123</a>
					</div>
					<div id="vs-nbp" class="alt-control">
						<a class="alt-control-title color-red" href="javascript: void(0)" onclick="modal.nbp(); return false;">NIBP</a>
						<a id="display-nbp" class="alt-control-rate nbip color-red" href="javascript: void(0)" onclick="modal.nbp(); return false;"><span id="displayed-systolic">140</span>/<span id="displayed-diastolic">75</span> (<span id="displayed-meanNBP">80</span>) <span class="nbip-label">mmHg</span></a>
						<a id="display-nbp-hr" class="alt-control-rate color-red" href="javascript: void(0)" onclick="modal.nbp(); return false;"><span style="font-size: 18px;">PR</span> <span id="displayed-reportedHR">75</span></a>
						<button id="button-nbp" class="scenario-button red-button">Read NIBP</button>
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
				</table>
			</div>
			<div id="comment-box" class="float-left ii-border">
				<input type="text" id="comment-input" value="Please enter comment for log">
				<button id="comment-button" class="scenario-button float-left">Log Comment</button>				
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
		<pre>
		<?php
		/*
			printf("Session ID is %s\n", $sessionID );
			echo "SID: ".SID."<br>session_id(): ".session_id()."<br>COOKIE: ".$_COOKIE["PHPSESSID"];
			printf("\n_COOKIE:\n%s\n", print_r($_COOKIE, TRUE ) );
		*/
		?>
		</pre>
	</body>
</html>