<?php
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
?>
	<html>
	<body>
		<p>Test Page (3)</p>
		<pre>
<?php

	require_once('init.php');
/*
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
/*
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("/var/www/html/temp"));

				foreach($iterator as $item) {
					print_r($item );
				}
*/
/*
	$fileName = "ALS_Scenario_1";
	$fileName = $fileName . '/main';
	printf("Media\n");
	$scenarioMediaArray = scenarioXML::getScenarioMediaArray($fileName );
	print_r($scenarioMediaArray );
	printf("Vocals\n");
	$scenarioVocalsArray = scenarioXML::getScenarioVocalsArray($fileName );
	print_r($scenarioVocalsArray );
	printf("Events\n");
	$eventsArray = scenarioXML::getScenarioEventsArray($fileName );
	print_r($eventsArray );
	printf("Done\n");
*/
function getWavParams($fileName )
{
	$fp = fopen($fileName, 'r');
	fseek($fp, 20);
	$rawheader = fread($fp, 16);
	print_r($rawheader );
	$header = unpack('vtype/vchannels/Vsamplerate/Vbytespersec/valignment/vbits', $rawheader);
	if ( $header['bits'] != 8 && $header['bits'] != 16 )
	{
		$header['error'] = "Unsupported bit Rate";
	}
	return ( $header );
}
	$path = "../scenarios/ALS_Scenario_1/vocals/";
	$file = "AggressiveDogGrowlBark.wav";
	
	printf("%s: %s", $file, print_r(getWavParams($path.$file ), TRUE ) );
	
	$file = "BigDogBark.wav";
	printf("%s: %s", $file, print_r(getWavParams($path.$file ), TRUE ) );
	
	$file = "DogBarkSnarl.wav";
	printf("%s: %s", $file, print_r(getWavParams($path.$file ), TRUE ) );
	//print_r($hdr);
?>
		</pre>
	</body>
</html>