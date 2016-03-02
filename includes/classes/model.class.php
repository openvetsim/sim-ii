<?php

	class modelClass {
				
		// define required fields from queries
		private static $usersTableDescriptor = array(
			'UserFirstName' => array('required', 'text'),
			'UserLastName' => array('required', 'text'),
			'UserEmail' => array('required', 'text'),
			'UserPassWord' => array('required', 'sha256'),
			'UserSalt' => array('required', 'text'),
			'UserLastLogin' => array('optional', 'now'),
			'Salt' => 'UserSalt'	// column name for salt
		);
		
		private static $tableDescriptors = array(
			'Users' => array('usersTableDescriptor', 'UserID')
		);
		
		private static $salt;
				
		function __construct() {

		}
		
		// get descriptors for creating models
		private static function getTableDescriptors($tableName) {
			if(isset(self::$tableDescriptors[$tableName]) === FALSE) {
				die('Illegal table name in model class');
			}
			
			return self::$tableDescriptors[$tableName];
		}
		
		// get descriptors for fields
		static public function createUpdateQuery($tableName, $postArray) {
			list($tableDescriptorName, $tableIndex) = self::getTableDescriptors($tableName);
			$tableDescriptor = self::$$tableDescriptorName;
			$queryString = "UPDATE `".dbClass::cleanMySQLInput($tableName)."` SET ";
			$queryString .= self::getQueryString($tableDescriptor, $postArray);
			$queryString .= " WHERE " . dbClass::cleanMySQLInput($tableIndex) . " = " . dbClass::cleanMySQLInput($postArray[$tableIndex]);
//FB::log($queryString);
			return $queryString;
		}
		
		// get descriptors for fields
		static public function createInsertQuery($tableName, $postArray) {
			list($tableDescriptorName, $tableIndex) = self::getTableDescriptors($tableName);
			$tableDescriptor = self::$$tableDescriptorName;
			$queryString = "INSERT INTO `".dbClass::cleanMySQLInput($tableName)."` SET ";
			$queryString .= self::getQueryString($tableDescriptor, $postArray);
			return $queryString;
		}		
		
		static private function getQueryString($tableDescriptor, $postArray) {
			$queryString = '';
			foreach($tableDescriptor as $fieldName => $fieldParameters) {
				if(array_key_exists($fieldName, $postArray) === FALSE || $fieldParameters[1] == 'id') {
					continue;
				}
				if($fieldParameters[0] == 'required' || $fieldParameters[0] == 'optional') {
					$queryString .= "`".dbClass::cleanMySQLInput($fieldName)."` = ";
					switch ($fieldParameters[1]) {
						//case 'id':
							//$queryString .= dbClass::cleanMySQLInput($postArray[$fieldName]).', ';
							//break;
						case 'int':
							$queryString .= dbClass::cleanMySQLInput($postArray[$fieldName]).', ';
							break;
						case 'text':
							$queryString .= "'".dbClass::cleanMySQLInput($postArray[$fieldName])."', ";
							break;
						case 'sha256':
							$salt = $postArray[$tableDescriptor['Salt']];
							$queryString .= "'".hash("sha256", dbClass::cleanMySQLInput($postArray[$fieldName]) . $salt . PEPPER)."', ";
							break;
						case 'now':
							$queryString .= "NOW(), ";
							break;
						default:
							$fieldType = explode(':', $fieldParameters[1]);
							if($fieldType[0] == 'const') {
								$queryString .= $fieldType[1].", ";
							} else if($fieldType[0] == 'checkbox') { // format: 'checkbox:valueIfChecked:valueIfCheckedForDB:valueIfNotCheckedForDB'
								$queryString .= (isset($postArray[$fieldName]) == true 
												&& $postArray[$fieldName] == $fieldType[1]) 
													? $fieldType[2].', ' 
													: $fieldType[3].', ';				
							} else if($fieldType[0] == 'float') { // format: 'float:x' where x = number of decimal places
								$queryString .= number_format(dbClass::cleanMySQLInput($postArray[$fieldName]), $fieldType[1]).', ';
							}
							break;
					}
				}
			}
			// last comma
			return substr($queryString, 0, -2);
		}
		
	}
?>