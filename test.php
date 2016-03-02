<?php

	require_once('init.php');

FB::log('Initialized!');
	
	
	$cleanArray['UserFirstName'] = 'Dan';
	$cleanArray['UserLastName'] = 'Fletcher';
	$cleanArray['UserEmail'] = 'dan.fletcher@cornell.edu';
	$cleanArray['UserPassWord'] = 'dandev';
	$cleanArray['UserSalt'] = adminClass::generateSalt();

$result = dbClass::dbInsertQueryResult(modelClass::createInsertQuery('Users', $cleanArray));
	
//FB::log(adminClass::isAdminLoginValid('dweiner@twcny.rr.com', 'daviddev'));

/*
	$result = $db->dbQueryResult("
									SELECT * FROM Admin 
									WHERE AdminUserName = 'David'
									");
	$row = $db->dbGetRowAssocClean($result);
*/
//FB::log(hash('sha256', 'davedev'.$salt.PEPPER));
?>