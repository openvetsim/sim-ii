		<meta charset="UTF-8">
		<title>Vet School Simulator</title>
		<link rel="shortcut icon" href="favicon.ico" />		
		<link rel="stylesheet" href="<?= BROWSER_CSS; ?>common.css" type="text/css" />
		<link rel="stylesheet" href="scripts/jquery-ui/1.11.4/jquery-ui.smoothness.min.css">
		<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> -->

		<link rel="stylesheet" href="<?= BROWSER_CSS; ?>controls.css" type="text/css" />
		<link rel="stylesheet" href="<?= BROWSER_CSS; ?>modal.css" type="text/css" />
		
		<?php
			// php defines in JS
			require_once(SERVER_INCLUDES."phpDefinesToJs.php");
			$ts = date("%s");
		?>

		<script type="text/javascript" src="scripts/jquery/2.2.1/jquery.min.js"></script>
		<script src="scripts/jquery-ui/1.11.4/jquery-ui.js"></script>
		
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>menu.js?v=<?= $date ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>chart.js?v=<?= $date ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>controls.js?v=<?= $date ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>modal.js?v=<?= $date ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>buttons.js?v=<?= $date ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>events.js?v=<?= $date ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>profile.js?v=<?= $date ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>scenario.js?v=<?= $date ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>media.js?v=<?= $date ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>log.js?v=<?= $date ?>"></script>
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>user.js?v=<?= $date ?>"></script>		
		<script type="text/javascript" src="<?= BROWSER_SCRIPTS; ?>simmgr.js?v=<?= $date ?>"></script>
		
