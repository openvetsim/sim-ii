<?php

	class logClass {
		
		function _construct() {
		}
		
		static public function openLogFile($logPath) {
			$fHandle = fopen($logPath, "a");
			if($fHandle === FALSE) {
				return FALSE;
			} else {
				return $fHandle;
			}
		}
		
		static public function closeLogFile($fHandle) {
			fclose($fHandle);
		}
		
		static public function initLogRecord($logPath) {
			$fHandle = self::openLogFile($logPath);
			if($fHandle === FALSE) {
				FB::log("Error opening log file".$logPath);
				return FALSE;
			}
			$initString = "--------\n".date("Y-m-d H:i:s")."\n";
			$status = fwrite($fHandle, $initString);
			self::closeLogFile($fHandle);
			return $status;
		}
		
		static public function addLogRecord($logPath, $logString) {
			$fHandle = self::openLogFile($logPath);
			if($fHandle === FALSE) {
				FB::log("Error opening log file".$logPath);
				return FALSE;
			}
			$status = fwrite($fHandle, $logString."\n");
			self::closeLogFile($fHandle);
			return $status;
		}
		
		static public function closeLogRecord($logPath, $logString) {
			$fHandle = self::openLogFile($logPath);
			if($fHandle === FALSE) {
				FB::log("Error opening log file".$logPath);
				return FALSE;
			}
			$status = fwrite($fHandle, $logString."\n--------\n");
			self::closeLogFile($fHandle);
			return $status;
		}

	}
?>