<?php

	class fileClass {
				
		function __construct() {

		}
		
		static public function uploadPortfolioFile($portfolioID, $fHandle) {
			$portfolioRow = portfolioClass::getPortfolioRow($portfolioID);
			if($portfolioRow === FALSE) {
				return array(FILE_SYSTEM_ERROR, '');
			}
			$fileErrorCode = FILE_NO_ERROR;
			switch ($fHandle["type"])
			{
				case "image/png":
				case "image/jpg":
				case "image/jpeg":
					break;
				default:
					return array(FILE_INVALID_TYPE, '');
					
			} // end switch
			
			// upload file and rename...
			if($fHandle['error'] === UPLOAD_ERR_OK && $fHandle['size'] > 0) {
				$imgFileNameInfo = pathinfo($fHandle['name']);
				$imgFileName = $imgFileNameInfo['filename'].'-'.time().'.'.$imgFileNameInfo['extension'];
				$imgFileNameServer = SERVER_PORTFOLIOS.$imgFileName;
				if(move_uploaded_file($fHandle["tmp_name"], $imgFileNameServer) == FALSE) {
					return array(FILE_TRANSFER_FAIL, 'default.png');
				}
				chmod($imgFileNameServer, 0644);
				
				// delete old file from portfolio directory if not default and not the same name as the old file.
				if($portfolioRow['PortfolioURL'] != 'default.png' && $portfolioRow['PortfolioURL'] != $imgFileName) {
					$oldFileNameServer = SERVER_PORTFOLIOS.$portfolioRow['PortfolioURL'];
					@unlink($oldFileNameServer);
				}
				
				// add to database
				if(dbClass::dbUpdateQueryResult("UPDATE Portfolio SET PortfolioURL = '$imgFileName' WHERE PortfolioID = $portfolioID") === FALSE) {
					return array(FILE_TRANSFER_FAIL, 'default.png');
				}
			} else if($fHandle['error'] === UPLOAD_ERR_NO_FILE) {
				return array(FILE_MISSING_FILE, '');		
			}
			return array($fileErrorCode, $imgFileName); 
		}
		
		static public function uploadProductFile($productID, $fHandle) {
			$productRow = productClass::getProductRow($productID);
			if($productRow === FALSE) {
				return array(FILE_SYSTEM_ERROR, '');
			}
			$fileErrorCode = FILE_NO_ERROR;
			switch ($fHandle["type"])
			{
				case "image/png":
				case "image/jpg":
				case "image/jpeg":
					break;
				default:
					return array(FILE_INVALID_TYPE, '');
					
			} // end switch
			
			// upload file and rename...
			if($fHandle['error'] === UPLOAD_ERR_OK && $fHandle['size'] > 0) {
				$imgFileNameInfo = pathinfo($fHandle['name']);
				$imgFileName = $imgFileNameInfo['filename'].'-'.time().'.'.$imgFileNameInfo['extension'];
				$imgFileNameServer = SERVER_PRODUCTS.$imgFileName;
				if(move_uploaded_file($fHandle["tmp_name"], $imgFileNameServer) == FALSE) {
					return array(FILE_TRANSFER_FAIL, 'default.png');
				}
				chmod($imgFileNameServer, 0644);
				
				// delete old file from portfolio directory if not default and not the same name as the old file.
				if($productRow['ProductImageURL'] != 'default.png' && $productRow['ProductImageURL'] != $imgFileName) {
					$oldFileNameServer = SERVER_PRODUCTS.$productRow['ProductImageURL'];
					@unlink($oldFileNameServer);
				}
				
				// add to database
				if(dbClass::dbUpdateQueryResult("UPDATE Product SET ProductImageURL = '$imgFileName' WHERE ProductID = $productID") === FALSE) {
					return array(FILE_TRANSFER_FAIL, 'default.png');
				}
			} else if($fHandle['error'] === UPLOAD_ERR_NO_FILE) {
				return array(FILE_MISSING_FILE, '');		
			}
			return array($fileErrorCode, $imgFileName); 
		}
		
		static public function uploadDesignFile($designID, $fHandle) {
			$designRow = designClass::getDesignRow($designID);
			if($designRow === FALSE) {
				return array(FILE_SYSTEM_ERROR, '');	
			}
		
			$fileErrorCode = FILE_NO_ERROR;
			switch ($fHandle["type"])
			{
				case "image/png":
				case "image/jpg":
				case "image/jpeg":
					break;
				default:
					return array(FILE_INVALID_TYPE, '');
					
			} // end switch
			
			// upload file and rename...
			if($fHandle['error'] === UPLOAD_ERR_OK && $fHandle['size'] > 0) {
				$imgFileNameInfo = pathinfo($fHandle['name']);
				$imgFileName = $imgFileNameInfo['filename'].'-'.time().'.'.$imgFileNameInfo['extension'];
				$imgFileNameServer = SERVER_DESIGNS.$imgFileName;
				if(move_uploaded_file($fHandle["tmp_name"], $imgFileNameServer) == FALSE) {
					return array(FILE_TRANSFER_FAIL, 'default.png');
				}
				chmod($imgFileNameServer, 0644);
				
				// delete old file from design directory if not default and not the same name as the old file.
//FB::log($designRow['DesignURL']);
				if($designRow['DesignURL'] != 'default.png' && $designRow['DesignURL'] != $imgFileName) {
					$oldFileNameServer = SERVER_DESIGNS.$designRow['DesignURL'];
					@unlink($oldFileNameServer);
				}
				
				// add to database
				if(dbClass::dbUpdateQueryResult("UPDATE Design SET DesignURL = '$imgFileName' WHERE DesignID = $designID") === FALSE) {
					return array(FILE_TRANSFER_FAIL, 'default.png');
				}
			} else if($fHandle['error'] === UPLOAD_ERR_NO_FILE) {
				return array(FILE_MISSING_FILE, '');		
			}
			return array($fileErrorCode, $imgFileName); 
		}
		
		static public function uploadFontFile($fontID, $fHandle) {
			$fontRow = fontClass::getFontRow($fontID);
			if($fontRow === FALSE) {
				return array(FILE_SYSTEM_ERROR, '');	
			}
		
			$fileErrorCode = FILE_NO_ERROR;
			switch ($fHandle["type"])
			{
				case "application/octet-stream":
					break;
				default:
					return array(FILE_INVALID_TYPE, '');
					
			} // end switch
			
			// upload file and rename...
			if($fHandle['error'] === UPLOAD_ERR_OK && $fHandle['size'] > 0) {
				$imgFileNameInfo = pathinfo($fHandle['name']);
				$imgFileName = $imgFileNameInfo['filename'].'.'.$imgFileNameInfo['extension'];
				$imgFileNameServer = SERVER_FONTS.$imgFileName;
				if(move_uploaded_file($fHandle["tmp_name"], $imgFileNameServer) == FALSE) {
					return array(FILE_TRANSFER_FAIL, '');
				}
				chmod($imgFileNameServer, 0644);
//FB::log($imgFileName);				
//FB::log($imgFileNameServer);				
				// delete old file from font directory
				$oldFileNameServer = SERVER_FONTS.$fontRow['FontFileURL'];
				if($oldFileNameServer != $imgFileNameServer) {
					@unlink($oldFileNameServer);
				}
			} else if($fHandle['error'] === UPLOAD_ERR_NO_FILE) {
				return array(FILE_MISSING_FILE, '');		
			}
			return array($fileErrorCode, $imgFileName); 
		}
		
		static public function getResizeDirection($fileURL) {
			$imageArray = self::getImageInfo($fileURL);
			$resizeDir = 'w';
			if($imageArray['height'] > $imageArray['width']) {
				$resizeDir = 'h';
			}
			return $resizeDir;
		}
		
		static public function getImageInfo($fileURL) {
			if(file_exists($fileURL) === FALSE) {
				return FALSE;
			}
			$imageArray = getimagesize($fileURL);
			$imageInfoArray['width'] = $imageArray[0];
			$imageInfoArray['height'] = $imageArray[1];
			$imageInfoArray['mime'] = $imageArray['mime'];
			return $imageInfoArray;
		}
	}
?>