<html>
	<body>
		<p>Test Page</p>
		<pre>
<?php
/*
	require_once('init.php');

FB::log('Initialized!');
	
	
	$cleanArray['UserFirstName'] = 'admin';
	$cleanArray['UserLastName'] = '';
	$cleanArray['UserEmail'] = 'admin';
	$cleanArray['UserPassWord'] = 'admin';
	$cleanArray['UserSalt'] = adminClass::generateSalt();

$result = dbClass::dbInsertQueryResult(modelClass::createInsertQuery('Users', $cleanArray));
	
//FB::log(adminClass::isAdminLoginValid('dweiner@twcny.rr.com', 'daviddev'));
*/
/*
	$result = $db->dbQueryResult("
									SELECT * FROM Admin 
									WHERE AdminUserName = 'David'
									");
	$row = $db->dbGetRowAssocClean($result);
*/
//FB::log(hash('sha256', 'davedev'.$salt.PEPPER));

		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("/var/www/html/temp"));

				foreach($iterator as $item) {
					print_r($item );
				}
?>
		</pre>
	</body>
</html>