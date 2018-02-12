<?php

	class fileClass {
				
		function __construct() {

		}
		
		static public function getSPLFileList($dir) {
			$fileListArray = array();
			$fileInfoArr = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST);
			foreach($fileInfoArr as $index => $fileInfo) {
				if (in_array($fileInfo->getBasename(), [".", ".."])) {
					continue;
				}
				$fileListArray[] =  $fileInfo->getPath() . DIRECTORY_SEPARATOR . $fileInfo->getBasename();
			}
			return $fileListArray;
		}
		
		static public function deleteDir($dir) {
			if(!is_dir($dir)) {
				return FALSE;
			}
			
			$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
			$files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
			foreach($files as $file) {
				if ($file->isDir()){
					rmdir($file->getRealPath());
				} else {
					unlink($file->getRealPath());
				}
			}
			rmdir($dir);
			return TRUE;			
		}
		
		static public function copyDir($srcDir, $destDir, $mode) {
			if (!file_exists($destDir)) {
				mkdir($destDir);
				chmod($destDir, $mode);
			}

			$splFileInfoArr = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($srcDir), RecursiveIteratorIterator::SELF_FIRST);

			foreach ($splFileInfoArr as $fullPath => $splFileinfo) {
				//skip . ..
				if (in_array($splFileinfo->getBasename(), [".", ".."])) {
					continue;
				}
				//get relative path of source file or folder
				$path = str_replace($srcDir, "", $splFileinfo->getPathname());

				if ($splFileinfo->isDir()) {
					mkdir($destDir . "/" . $path);
				} else {
					copy($fullPath, $destDir . "/" . $path);
				}
				chmod($destDir . "/" . $path, $mode);
			}
		}

		static public function setDirModeRecursive($dir, $mode) {
			if (!file_exists($dir)) {
				return FALSE;
			}
			
			// iterate over dir
			$splFileInfoArr = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST);

			foreach ($splFileInfoArr as $fullPath => $splFileinfo) {
				//skip . ..
				if (in_array($splFileinfo->getBasename(), [".", ".."])) {
					continue;
				}
				
				//get relative path of source file or folder
				$path = str_replace($dir, "", $splFileinfo->getPathname());
				chmod($dir . "/" . $path, $mode);
			}
		}
		
		static public function validateScenarioArchive() {
			// function to validate unpacked scenario in temp directory
			// check that only one xml exists and it is called main
			// check that directories images, vocals and media exist
			$fileNameArray = scandir(TMP_SCENARIO_DIR);

			// set up status flags
			$statusImage = FALSE;
			$statusVocal = FALSE;
			$statusMedia = FALSE;
			$statusXML = FALSE;
			$xmlCount = 0;
			$xmlFileName = '';
			
			// iterate over list
			foreach($fileNameArray as $fileName) {
				if($fileName == '.' || $fileName == '..') {
					continue;
				} else if(is_dir(TMP_SCENARIO_DIR . $fileName)) {
					switch ($fileName) {
						case 'images':
							$statusImage = TRUE;
							break;
						case 'vocals':
							$statusVocal = TRUE;
							break;
						case 'media':
							$statusMedia = TRUE;
							break;
						default:
							break;
					}
				} else {
					if(strstr($fileName, '.xml')) {
						$xmlCount++;
						$xmlFileName = $fileName;
					}
				}
			}
			
			// see if xml count > 1 and check name of file.
			if($xmlCount == 1) {
				if($xmlFileName != 'main.xml') {
					rename(TMP_SCENARIO_DIR . $xmlFileName, TMP_SCENARIO_DIR . 'main.xml');
				}
				$statusXML = TRUE;
			}
			
			return $statusImage & $statusVocal & $statusMedia & $statusXML;
		}
	}
?>