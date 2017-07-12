<?php
	require_once('init.php');
	
	// delete session data
	
	adminClass::removeUserfromSession();
	// check admin login
	$loginErrorFlag = 0;
	
	if(isset($_POST['submit'])) {
//FB::log($_POST);
		if ( isset($_POST['userID']) ) // && ( $_POST['userID'] == 5 ) )
		{
			// Demo User
			$userID = '5';
			if(($userRow = adminClass::getUserRow($userID)) !== FALSE) 
			{
				adminClass::addUserToSession($userRow);
				header("location: ii-demo.php" );
				//header('location: ii.php');
			}
			else
			{
				adminClass::removeUserFromSession();
				$loginErrorFlag = 1;
			}
		}
		else if( isset($_POST['UserEmail']) && isset($_POST['UserPassWord']) && ($userRow = adminClass::isUserLoginValid($_POST['UserEmail'], $_POST['UserPassWord'])) !== FALSE) {
			adminClass::addUserToSession($userRow);
			header('location: ii-demo.php');
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
			document.cookie = "TestCookie=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=;";
			document.cookie = "simIIUserID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=;";
			$(document).ready(function() {
				var loginErrorFlag = <?php echo $loginErrorFlag; ?>;
				if(loginErrorFlag == 1) {
					$('p.error_login').toggle();
				}
				
				// focus on username
				$('input[name=UserEmail]').focus();
				/* $('#demo_submit').click(function(event){
					event.preventDefault();
					window.location.href = "ii-demo.php";
				}); */
			});
		</script>
	</head>
	<body>
		<div id="sitewrapper">
			<div id="admin_header">
				<img src="<?php echo BROWSER_IMAGES; ?>cuLogo75.gif" alt="logo">
				<h1>Welcome to the Cornell Vet School Simulation Login.</h1>
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
			<form method="post" action="#" autocomplete="off">
				<button id="demo_submit" name="submit" class="admin-demo-btn red-button">Start Demo Session</button>
				<input type="hidden" name="userID" value="5" />
			</form>
			<div class="clearer"></div>
		</div>	
	</body>
</html>