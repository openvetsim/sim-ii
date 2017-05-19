<!doctype html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<title>slider demo</title>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<style>#slider { margin: 10px; }	</style>
	<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
	<!-- <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script> -->
	<script src="scripts/jquery.mobile.custom.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#slider-1').slider({
				stop: function( event, ui ) {
				},
				create: function() {
					$('.ui-slider-bg').css('background-color', '#b31b1b');
					$('.ui-slider-handle').css({
						'background-color': 'white',
						'border': '1px solid black'
					});
				}
			});
			
			$('#increment').click(function() {
				var oldVal = $('#slider-1').val();
				$('#slider-1').val(parseFloat(oldVal) + 1).slider("refresh");
			});
			$('#decrement').click(function() {
				var oldVal = $('#slider-1').val();
				$('#slider-1').val(parseFloat(oldVal) - 1).slider("refresh");
			});
		});
	</script>
	<style>
		a {
			margin-right: 50px;
			font-size: 30px;
		}
	</style>
	</head>
	<body>

	<div id="slider" style="width: 500px;">
		<label for="slider-1">Input slider:</label>
		<input type="input" name="slider-1" id="slider-1" value="0.5" min="0" max="100" step="1" data-highlight="true">
		<a id="decrement" href="javascript: void(2);">&laquo;</a>
		<a id="increment" href="javascript: void(2);">&raquo;</a>
	</div>
	</body>
</html>