<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

	// session
	session_start();
	
	// debug
	define("DEBUG", TRUE);
	if(DEBUG === TRUE) {
		define("DB_DEBUG", TRUE);
	} else {
		define("DB_DEBUG", FALSE);	
	}
	$parts = explode('/',$_SERVER['SCRIPT_NAME'], 3 );
	if ( count($parts) > 2 )
	{
		$top_dir = $parts[1];
	}
	else
	{
		$top_dir = "ii";
	}
	// server defines
	define("SERVER_ROOT", $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $top_dir . DIRECTORY_SEPARATOR);

	// sever locations
	define("SERVER_INCLUDES", SERVER_ROOT . "includes" . DIRECTORY_SEPARATOR);
	define("SERVER_CLASSES", SERVER_INCLUDES . "classes" . DIRECTORY_SEPARATOR);
	define("SERVER_SIM_LOGS", $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "simlogs" . DIRECTORY_SEPARATOR);	
	define("SERVER_SCENARIOS", $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "scenarios" . DIRECTORY_SEPARATOR);	
	define("SERVER_SCENARIOS_PATIENTS", SERVER_SCENARIOS . "patients" . DIRECTORY_SEPARATOR);	
	
	// server location for ini files
//	define("SERVER_PROFILES",  SERVER_SCENARIOS . "profiles" . DIRECTORY_SEPARATOR);
	define("SERVER_PROFILES", $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "profiles" . DIRECTORY_SEPARATOR);	
	define("SERVER_VOCALS", SERVER_SCENARIOS . "vocals" . DIRECTORY_SEPARATOR);
	define("SERVER_MEDIA", SERVER_SCENARIOS . "media" . DIRECTORY_SEPARATOR);

	// browser defines
	if(isset($_SERVER['HTTPS']) == true) {
		define("HOST_PROTOCOL", "https://");
	} else {
		define("HOST_PROTOCOL", "//");
	}
	if ( $_SERVER['SERVER_PORT'] != 80 )
	{
		define("SERVER_FULL", $_SERVER["SERVER_NAME"] . ":" . $_SERVER['SERVER_PORT'] );
	}
	else
	{
		define("SERVER_FULL", $_SERVER["SERVER_NAME"] );
	
	}
	define("BROWSER_HTML", SERVER_FULL . DIRECTORY_SEPARATOR .  $top_dir . DIRECTORY_SEPARATOR);
//	define("BROWSER_HTML", $_SERVER["HTTP_HOST"].DIRECTORY_SEPARATOR);
	define("BROWSER_ROOT", HOST_PROTOCOL . BROWSER_HTML);
	define("BROWSER_PROFILES_IMAGES", HOST_PROTOCOL . SERVER_FULL . DIRECTORY_SEPARATOR . "scenarios" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR);
	define("BROWSER_CGI",  HOST_PROTOCOL . SERVER_FULL . DIRECTORY_SEPARATOR . "cgi-bin" . DIRECTORY_SEPARATOR);
	define("BROWSER_SCENARIOS", HOST_PROTOCOL . SERVER_FULL . DIRECTORY_SEPARATOR . "scenarios" . DIRECTORY_SEPARATOR);
	define("BROWSER_SCENARIOS_IMAGES", BROWSER_SCENARIOS . "images" . DIRECTORY_SEPARATOR);
	define("BROWSER_SCENARIOS_PATIENTS", BROWSER_SCENARIOS . "patients" . DIRECTORY_SEPARATOR);
	define("BROWSER_SCENARIOS_MEDIA", BROWSER_SCENARIOS . "media" . DIRECTORY_SEPARATOR);
	define("BROWSER_SCENARIOS_VOCALS", BROWSER_SCENARIOS . "vocals" . DIRECTORY_SEPARATOR);
	
	define("BROWSER_CSS", BROWSER_ROOT . "css" . DIRECTORY_SEPARATOR);
	define("BROWSER_IMAGES", BROWSER_ROOT . "images" . DIRECTORY_SEPARATOR);
	define("BROWSER_VOCALS",  BROWSER_ROOT . "vocals" . DIRECTORY_SEPARATOR);
	define("BROWSER_AJAX", BROWSER_ROOT . "ajax" . DIRECTORY_SEPARATOR);
	define("BROWSER_SCRIPTS", BROWSER_ROOT . "js" . DIRECTORY_SEPARATOR);
	
	define("SERVER_ADDR", $_SERVER['SERVER_ADDR'] );
	define("REMOTE_ADDR", $_SERVER['REMOTE_ADDR'] );
	
	// Default DB select
	define('DB_DEFAULT', 'vet');
	
	// pepper for password encryption
	define("PEPPER", "vetschool");
	
	// define for file transfers
	define('FILE_NO_ERROR', 0);
	define('FILE_INVALID_TYPE', 1);
	define('FILE_TRANSFER_FAIL', 2);
	define('FILE_MISSING_FILE', 3);
	define('FILE_SYSTEM_ERROR', 4);
	
	// AJAX defines
	// AJAX Constants
	define('AJAX_STATUS_OK', 0);
	define('AJAX_STATUS_FAIL', 1);
	define('AJAX_STATUS_LOGIN_FAIL', 2);
	
	// version
	define('VERSION_MAJOR', 1);
	define('VERSION_MINOR', 0);
	
	// mobilized
//	define('MOBILIZED', FALSE);
	define('MOBILIZED', TRUE);
		
	/************************************/
	// requires for global classes
	require_once(SERVER_CLASSES . "fb.class.php");
	require_once(SERVER_CLASSES . "admin.class.php");
	require_once(SERVER_CLASSES . "db.class.php");
	require_once(SERVER_CLASSES . "file.class.php");
	require_once(SERVER_CLASSES . "model.class.php");
	require_once(SERVER_CLASSES . "log.class.php");
	require_once(SERVER_CLASSES . "controls.class.php");
	require_once(SERVER_CLASSES . "scenarioXML.class.php");
	
	// Excel class -- optional
//	require_once(SERVER_CLASSES.'PHPExcel.php');
//	require_once(SERVER_CLASSES.'PHPExcel/IOFactory.php');


	// mail class -- optional
//	require_once(SERVER_CLASSES . "mail.class.php");

	
?>