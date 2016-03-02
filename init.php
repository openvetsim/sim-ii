<?php
	// session
	session_start();
	
	// debug
	define("DEBUG", TRUE);
	if(DEBUG === TRUE) {
		define("DB_DEBUG", TRUE);
	} else {
		define("DB_DEBUG", FALSE);	
	}
	
	// server defines
	define("SERVER_ROOT", $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "ii" . DIRECTORY_SEPARATOR);

	// sever locations
	define("SERVER_INCLUDES", SERVER_ROOT . "includes" . DIRECTORY_SEPARATOR);
	define("SERVER_CLASSES", SERVER_INCLUDES . "classes" . DIRECTORY_SEPARATOR);
	define("SERVER_LOGS", SERVER_ROOT . "logs" . DIRECTORY_SEPARATOR);	
	
	// server location for ini files
	define("SERVER_PROFILES",  $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "profiles" . DIRECTORY_SEPARATOR);
	define("SERVER_VOCALS", SERVER_PROFILES . "vocals" . DIRECTORY_SEPARATOR);

	// browser defines
	if(isset($_SERVER['HTTPS']) == true) {
		define("HOST_PROTOCOL", "https://");
	} else {
		define("HOST_PROTOCOL", "//");
	}

	define("BROWSER_HTML", $_SERVER["SERVER_NAME"] . DIRECTORY_SEPARATOR . "ii" . DIRECTORY_SEPARATOR);
//	define("BROWSER_HTML", $_SERVER["HTTP_HOST"].DIRECTORY_SEPARATOR);
	define("BROWSER_ROOT", HOST_PROTOCOL . BROWSER_HTML);
	define("BROWSER_PROFILES", HOST_PROTOCOL . $_SERVER["SERVER_NAME"] . DIRECTORY_SEPARATOR . "profiles" . DIRECTORY_SEPARATOR);
	define("BROWSER_PROFILES_IMAGES", BROWSER_PROFILES . "images" .  DIRECTORY_SEPARATOR);

	define("BROWSER_CSS", BROWSER_ROOT . "css" . DIRECTORY_SEPARATOR);
	define("BROWSER_IMAGES", BROWSER_ROOT . "images" . DIRECTORY_SEPARATOR);
	define("BROWSER_VOCALS",  BROWSER_PROFILES . "vocals" . DIRECTORY_SEPARATOR);
	define("BROWSER_AJAX", BROWSER_ROOT . "ajax" . DIRECTORY_SEPARATOR);
	define("BROWSER_SCRIPTS", BROWSER_ROOT . "js" . DIRECTORY_SEPARATOR);
	
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
		
	/************************************/
	// requires for global classes
	require_once(SERVER_CLASSES . "fb.class.php");
	require_once(SERVER_CLASSES . "admin.class.php");
	require_once(SERVER_CLASSES . "db.class.php");
	require_once(SERVER_CLASSES . "file.class.php");
	require_once(SERVER_CLASSES . "model.class.php");
	require_once(SERVER_CLASSES . "log.class.php");
	require_once(SERVER_CLASSES . "controls.class.php");
	
	// Excel class -- optional
//	require_once(SERVER_CLASSES.'PHPExcel.php');
//	require_once(SERVER_CLASSES.'PHPExcel/IOFactory.php');


	// mail class -- optional
//	require_once(SERVER_CLASSES . "mail.class.php");

	
?>