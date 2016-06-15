<?php
	class controls {
		function __construct() {
		}
		
		static public function getTransferDropDown() {
			return '
				<option value="0">0 sec</option>
				<option value="20">20 sec</option>
				<option value="40">40 sec</option>
				<option value="60">1 min</option>
				<option value="120">2 min</option>
				<option value="180">3 min</option>
				<option value="240">4 min</option>
				<option value="300">5 min</option>
				<option value="360">6 min</option>
				<option value="480">8 min</option>
				<option value="600">10 min</option>
			';
		}
		
		private static $ecgList = array(
			array('value' => 'sinus', 'type' => 'pulse', 'name' => 'Sinus Rhythm'),
			array('value' => 'afib', 'type' => 'pulse', 'name' => 'Atrial Fibrillation'),
			array('value' => 'vtach1', 'type' => 'pulse', 'name' => 'Ventricular Tarchycardia 1'),
			array('value' => 'vtach2', 'type' => 'pulse', 'name' => 'Ventricular Tarchycardia 2'),
			array('value' => 'vtach3', 'type' => 'pulse', 'name' => 'Ventricular Tarchycardia 3'),
			array('value' => 'vfib', 'type' => 'no-pulse', 'name' => 'Ventricular Fibrillation'),
			array('value' => 'asystole', 'type' => 'no-pulse', 'name' => 'Asystole')
		);
		
		private static $pulseList = array(
			array('value' => 'none', 'name' => 'None'),
			array('value' => '1-1', 'name' => 'VPC 1 Singlet'),
			array('value' => '1-2', 'name' => 'VPC 1 Couplet'),
			array('value' => '1-3', 'name' => 'VPC 1 Triplet'),
			array('value' => '2-1', 'name' => 'VPC 2 Singlet'),
			array('value' => '2-2', 'name' => 'VPC 2 Couplet'),
			array('value' => '2-3', 'name' => 'VPC 2 Triplet'),
			array('value' => '3-1', 'name' => 'VPC 3 Singlet'),
			array('value' => '3-2', 'name' => 'VPC 3 Couplet'),
			array('value' => '3-3', 'name' => 'VPC 3 Triplet')
		);				
		
		private static $amplitudeList = array(
			array('value' => 'low', 'name' => 'Low'),
			array('value' => 'med', 'name' => 'Medium'),
			array('value' => 'high', 'name' => 'High')
		);				
		
		static public function getECGDropDown($currentECG) {
			$pulseContent = '
				<option disabled="disabled">Pulses</option>
			';
			$noPulseContent = '
				<option disabled="disabled"></option>			
				<option disabled="disabled">No Pulses</option>
			';

			foreach(self::$ecgList as $ecgArray) {
				$selectContent = ($currentECG == $ecgArray['value']) ? ' selected="selected"' : '';
				if($ecgArray['type'] == 'pulse') {
					$pulseContent .= '
						<option data-type="pulse" value="' . $ecgArray['value'] . '"' . $selectContent . '>' . $ecgArray['name'] . '</option>
					';
				} else {
					$noPulseContent .= '
						<option data-type="no-pulse" value="' . $ecgArray['value'] . '"' . $selectContent . '>' . $ecgArray['name'] . '</option>
					';				
				}
			}
			return $pulseContent . $noPulseContent;
		}
		
		static public function getPulseDropDown($currentPulse) {
			$pulseContent = '';

			foreach(self::$pulseList as $pulseArray) {
				$selectContent = ($currentPulse == $pulseArray['value']) ? ' selected="selected"' : '';
				$pulseContent .= '
					<option value="' . $pulseArray['value'] . '"' . $selectContent . '>' . $pulseArray['name'] . '</option>
				';
			}
			return $pulseContent;
		}
		
		static public function getVFIBAmplitudeDropDown($currentAmplitude) {
			$amplitudeContent = '';
			foreach(self::$amplitudeList as $amplitudeArray) {
				$selectContent = ($currentAmplitude == $amplitudeArray['value']) ? ' selected="selected"' : '';
				$amplitudeContent .= '
					<option value="' . $amplitudeArray['value'] . '"' . $selectContent . '>' . $amplitudeArray['name'] . '</option>
				';
			}
			return $amplitudeContent;
		}
		
		static public function getPulseFrequencyDropDown($currentPulseFrequency) {
			$pulseFrequencyContent = '';
			for($frequency = 0; $frequency <= 100; $frequency += 10) {
				$selectContent = ($currentPulseFrequency == $frequency) ? ' selected="selected"' : '';
				$pulseFrequencyContent .= '
					<option value="' . $frequency . '"' . $selectContent . '>' . $frequency . '%</option>
				';
			}
			return $pulseFrequencyContent;
		}
	}
?>