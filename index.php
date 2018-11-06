<?php
	require_once('init.php');
	
	// delete session data
	adminClass::removeUserfromSession();

	// check admin login
	$loginErrorFlag = 0;
	if(isset($_POST['submit'])) {
//FB::log($_POST);

		if(($userRow = adminClass::isUserLoginValid($_POST['UserEmail'], $_POST['UserPassWord'])) !== FALSE) {
			adminClass::addUserToSession($userRow);
			header('location: ii.php');
		} else {
			adminClass::removeUserFromSession();
			$loginErrorFlag = 1;
		}
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once(SERVER_INCLUDES . "header.php"); ?>
		
		<script type="text/javascript">
			$(document).ready(function() {
				var loginErrorFlag = <?php echo $loginErrorFlag; ?>;
				if(loginErrorFlag == 1) {
					$('p.error_login').toggle();
				}
				
				// focus on username
				$('input[name=UserEmail]').focus();
			});
		</script>
	</head>
	<body>
		<div id="sitewrapper">
			<div id="admin_header">
				<img src="<?php echo BROWSER_IMAGES; ?>logo-open-vetsim.gif" alt="logo" style="height: 90px;">
				<h1>Please login to Open VetSim.</h1>
			</div>
			<div class="clearer" id="admin_login">
				<form method="post" action="#" autocomplete="off">
					<fieldset>
						<label>Username:</label>
						<input type="text" name="UserEmail" />
						<label>Password:</label>
						<input type="password" name="UserPassWord" />
					</fieldset>
					<button id="login_submit" name="submit" class="admin-btn red-button">Submit</button>
					<p class="error_login">Incorrect username or password.  Please try again.</p>
				</form>
			</div>
			
			<div class="clearer"></div>
		</div>	
	</body>
</html>