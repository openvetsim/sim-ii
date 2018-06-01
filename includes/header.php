		<meta charset="UTF-8">
		<title>Open VetSim Instructor Interface</title>
		<link rel="shortcut icon" href="favicon.ico" />		

<?php
		if(MOBILIZED) {
//			echo '<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />';
			echo '<link rel="stylesheet" href="' . BROWSER_CSS . 'jquery.mobile-1.4.5.min.css" />';
			echo '<link rel="stylesheet" href="' . BROWSER_CSS . 'mobilize.css" />';
		}
?>

		
		<link rel="stylesheet" href="<?= BROWSER_CSS; ?>common.css" type="text/css" />
		<link rel="stylesheet" href="scripts/jquery-ui/1.11.4/jquery-ui.smoothness.min.css">


		<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> -->

		<link rel="stylesheet" href="<?= BROWSER_CSS; ?>controls.css" type="text/css" />
		<link rel="stylesheet" href="<?= BROWSER_CSS; ?>modal.css" type="text/css" />
		
		<?php
			// php defines in JS
			require_once(SERVER_INCLUDES."phpDefinesToJs.php");
			$ts = date("U");
		?>

		<script type="text/javascript" src="scripts/jquery/2.2.1/jquery.min.js"></script>
		<script src="scripts/jquery-ui/1.11.4/jquery-ui.js"></script>

		<!-- <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script> -->
<?php
		if(MOBILIZED) {
			echo '<script src="scripts/jquery.mobile.custom.min.js"></script>';
		}
?>
		
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>menu.js?v=<?= $ts ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>chart.js?v=<?= $ts ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>controls.js?v=<?= $ts ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>modal.js?v=<?= $ts ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>buttons.js?v=<?= $ts ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>events.js?v=<?= $ts ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>profile.js?v=<?= $ts ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>scenario.js?v=<?= $ts ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>media.js?v=<?= $ts ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>log.js?v=<?= $ts ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>user.js?v=<?= $ts ?>"></script>		
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>simmgr.js?v=<?= $ts ?>"></script>
		
