<?php

	class dbClass {		
		private static $connection;
		
		private $connection2;
		
		private static $dbParams = array(
							'vet' => array(
											'dbHost' => 'localhost',
											'dbUser' => 'phpmyadmin',
											'dbPswd' => 'vet$im',
											'dbName' => 'vet'
										),
							'' => array(
											'dbHost' => '',
											'dbUser' => '',
											'dbPswd' => '',
											'dbName' => ''
										),
		);
		
		function __construct($dbSelect = 'vet') {
			$this->connection2 = self::dbConnect($dbSelect);
		}

		
		public static function dbConnect($dbSelect) {
			$dbHost = self::$dbParams[$dbSelect]['dbHost'];
			$dbUser = self::$dbParams[$dbSelect]['dbUser'];
			$dbPswd = self::$dbParams[$dbSelect]['dbPswd'];
			$dbName = self::$dbParams[$dbSelect]['dbName'];
			
			$connection = mysqli_connect($dbHost, $dbUser, $dbPswd) or self::dbError('Logon database failed '.$dbHost, DB_DEBUG);
			$status = mysqli_select_db($connection, $dbName) or self::dbError('Could not find database '.$dbName, DB_DEBUG);
			if($status == TRUE) {
				return $connection;
			} else {
				return FALSE;
			}
		}
		
		public static function dbClose($connection) {
			mysqli_close($connection);
		}
		
		public static function dbSelectQueryResult($queryString, $passedConnection = '', $dbSelect = DB_DEFAULT) {
			if($passedConnection == '') {
				$connection = self::dbConnect($dbSelect);
			} else {
				$connection = $passedConnection;
			}
			$result = mysqli_query($connection, $queryString) or self::dbError($queryString, DB_DEBUG);
			if($result == FALSE) {
				return FALSE;
			}
			$resultArray = array();
			while($row = self::dbGetRowAssocClean($result)) {
				$resultArray[] = $row;
			}
			if($passedConnection == '') {
				self::dbClose($connection);
			}
			return $resultArray;
		}
		
		public static function dbStartTransaction($passedConnection = '', $dbSelect = DB_DEFAULT) {
			if($passedConnection == '') {
				$connection = self::dbConnect($dbSelect);
			} else {
				$connection = $passedConnection;
			}
			$result = mysqli_query($connection, "START TRANSACTION") or self::dbError($queryString, DB_DEBUG);
			if($passedConnection == '') {
				self::dbClose($connection);
			}
			return $result;
		}
		
		public static function dbCommitTransaction($passedConnection = '', $dbSelect = DB_DEFAULT) {
			if($passedConnection == '') {
				$connection = self::dbConnect($dbSelect);
			} else {
				$connection = $passedConnection;
			}
			$result = mysqli_commit($connection) or self::dbError($queryString, DB_DEBUG);
			return $result;
		}
		
		public static function dbRollBackTransaction($passedConnection = '', $dbSelect = DB_DEFAULT) {
			if($passedConnection == '') {
				$connection = self::dbConnect($dbSelect);
			} else {
				$connection = $passedConnection;
			}
			$result = mysqli_rollback($connection) or self::dbError($queryString, DB_DEBUG);
			return $result;
		}
		
		public static function dbUpdateQueryResult($queryString, $passedConnection = '', $dbSelect = DB_DEFAULT) {
			if($passedConnection == '') {
				$connection = self::dbConnect($dbSelect);
			} else {
				$connection = $passedConnection;
			}
			$result = mysqli_query($connection, $queryString) or self::dbError($queryString, DB_DEBUG);
			if($result == FALSE) {
				return FALSE;
			}
			
			if($passedConnection == '') {
				self::dbClose($connection);
			}
			return $result;
		}
		
		// return TRUE for successful result
		public static function dbDeleteQueryResult($queryString, $passedConnection = '', $dbSelect = DB_DEFAULT) {
			if($passedConnection == '') {
				$connection = self::dbConnect($dbSelect);
			} else {
				$connection = $passedConnection;
			}
			$result = mysqli_query($connection, $queryString) or self::dbError($queryString, DB_DEBUG);
			if($result == FALSE) {
				return FALSE;
			}
			
			if($passedConnection == '') {
				self::dbClose($connection);
			}
			return $result;
		}

		public static function dbInsertQueryResult($queryString, $passedConnection = '', $dbSelect = DB_DEFAULT) {
			if($passedConnection == '') {
				$connection = self::dbConnect($dbSelect);
			} else {
				$connection = $passedConnection;
			}
			$result = mysqli_query($connection, $queryString) or self::dbError($queryString, $connection, DB_DEBUG);
			if($result == FALSE) {
				return FALSE;
			}
			
			$newIndex = mysqli_insert_id($connection);
			if($passedConnection == '') {
				self::dbClose($connection);
			}
			return $newIndex;
		}

		public static function dbGetRowAssocClean($result) {
			$row = mysqli_fetch_assoc($result);
            if(!$row) {
                return '';
            }
            
            // clean row for output
            $cleanRow = array();
            foreach($row as $key => $value) {
                $cleanRow[$key] = self::cleanOutput($row[$key]);
            }            
			return $cleanRow;
		}
		
		public static function dbResetPointer($resource) {
			$result = mysqli_data_seek($resource, 0) or $this->dbError('Error in dbResetPointer', DB_DEBUG);
			return $result;
		}	
				
		public static function dbError($query="db error", $connection, $mode="debug") {
			if ($mode == "debug") {
				die($query.": ".mysqli_error($connection));
			} else {
				// if this happens in production mode, try not to die()... but definitely log the error:
		
				$report = "\n-------------------------------------------------------------------\n";
				$report .= date("F j, Y, g:i a")."\n";
				$report .= "Page: ".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\n";
				$report .= "Error: ". $query .": ".mysql_error()."\n";
				$report .= "User IP: ".$_SERVER['REMOTE_ADDR']."\n";
		
				if (defined("SERVER_LOGS")) {
					$log_file_name = SERVER_LOGS . 'database_errors.txt';
					$handle = fopen($log_file_name, "a+");
					if ($handle) {
						fwrite($handle, $report);
						fclose($handle);
					}
				}
			}
		}
		
		// sanitize functions
		public static function valuesFromPost($varName) {
			$connection = self::dbConnect(DB_DEFAULT);
			$tempString = "";

			if(isset($_POST[$varName])){
				if (get_magic_quotes_gpc() == false) {
					$tempString = mysqli_real_escape_string($connection, $_POST[$varName]);
				} else {
					$tempString = $_POST[$varName];
				}
			} else {
				$tempString = "";
			}
			self::dbClose($connection);
			return $tempString;
		}
		
		public static function valuesFromGet($varName) {
			$connection = self::dbConnect(DB_DEFAULT);
			$tempString = "";

			if(isset($_GET[$varName])){
				if (get_magic_quotes_gpc() == false) {
					$tempString = mysqli_real_escape_string($connection, $_GET[$varName]);
				} else {
					$tempString = $_GET[$varName];
				}
			} else {
				$tempString = "";
			}
			self::dbClose($connection);
			return $tempString;
		}
		
		public static function valuesFromSession($varName) {
			$connection = self::dbConnect(DB_DEFAULT);
			$tempString = "";

			if(isset($_SESSION[$varName])){
				if (get_magic_quotes_gpc() == false) {
					$tempString = mysqli_real_escape_string($connection, $_SESSION[$varName]);
				} else {
					$tempString = $_SESSION[$varName];
				}
			} else {
				$tempString = "";
			}
			self::dbClose($connection);
			return $tempString;
		}		
		
		public static function cleanMySQLInput($instring) {
			$connection = self::dbConnect(DB_DEFAULT);
			$outstring = str_replace('`', '\`', $instring);
			return mysqli_real_escape_string($connection, $outstring);
			self::dbClose($connection);			
		}
		
		public static function cleanOutput($instring, $mode="normal") {
			switch ($mode)
			{
				case "html":
					return stripslashes($instring);
					break;

				case "java":
					// javascript chokes on certain characters:
					$out = htmlentities(stripslashes($instring));
					$out = str_replace("\\","\\\\", $out);
					$out = str_replace("'","\'", $out);
					$out = str_replace("\n","\\n", $out);
					$out = str_replace("\r","\\r", $out);

					return $out;
					break;

				default:
				{
					$out = htmlentities(stripslashes($instring));
					//$out = str_replace("'","&apos;",$out);
					return $out;
				}
			}
		}
		
		public static function isIndex($input) {
			if(is_int((int)$input) === TRUE && $input > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} 
		
		public static function isInt($input) {
			if(filter_var($input, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0))) === FALSE) {
				return FALSE;
			} else {
				return TRUE;
			}
		} 
		
	}
?>
