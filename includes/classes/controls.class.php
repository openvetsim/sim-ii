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
	}
?>