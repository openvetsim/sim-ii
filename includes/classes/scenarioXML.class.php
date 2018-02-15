<?php
	class scenarioXML {
	
		function __construct() {
		}
				
		static public function getScenarioArray($fileName) {
			$filePath = SERVER_SCENARIOS . $fileName . ".xml";
			if(file_exists($filePath) === FALSE) {
				return FALSE;
			} else {
				libxml_use_internal_errors(true);
				$simpleXMLObj = simplexml_load_file($filePath);
				return json_decode(json_encode($simpleXMLObj), TRUE);
			}
		}
		
		static public function getScenarioProfileArray($fileName) {
			$scenarioArray = self::getScenarioArray($fileName);
			if($scenarioArray === FALSE || count($scenarioArray['profile']) == 0) {
				return FALSE;
			} else {
				return $scenarioArray['profile'];
			}
		}
		
		static public function getScenarioHeaderArray($fileName) {
			$scenarioArray = self::getScenarioArray($fileName);
			if($scenarioArray === FALSE || count($scenarioArray['header']) == 0) {
				return FALSE;
			} else {
				return $scenarioArray['header'];
			}
		}

		static public function getScenarioEventsArray($fileName) {
			$scenarioArray = self::getScenarioArray($fileName);
			if($scenarioArray === FALSE || count($scenarioArray['events']) == 0) {
				return FALSE;
			} else {
				return $scenarioArray['events'];
			}
		}
		
		static public function getScenarioMediaArray($fileName) {
			$scenarioArray = self::getScenarioArray($fileName);
			if($scenarioArray === FALSE || count($scenarioArray['media']) == 0) {
				return FALSE;
			} else if(!array_key_exists('0', $scenarioArray['media']['file']) === TRUE) {
				$tmp = $scenarioArray['media']['file'];
				unset($scenarioArray['media']['file']);
				$scenarioArray['media']['file'][0] = $tmp;
			}
			return $scenarioArray['media'];
		}
		
		static public function getScenarioVocalsArray($fileName) {
			$scenarioArray = self::getScenarioArray($fileName);
			if($scenarioArray === FALSE || count($scenarioArray['vocals']) == 0) {
				return FALSE;
			} else if(!array_key_exists('0', $scenarioArray['vocals']['file']) === TRUE) {
				$tmp = $scenarioArray['vocals']['file'];
				unset($scenarioArray['vocals']['file']);
				$scenarioArray['vocals']['file'][0] = $tmp;
			}
			return $scenarioArray['vocals'];
		}
	}
?>