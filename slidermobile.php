<!doctype html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<title>slider demo</title>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<style>#slider { margin: 10px; }	</style>
	<script src="//code.jquery.com/jquery-1.11.1.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#slider-1').slider({
				stop: function( event, ui ) {
				}
			});
			
			$('#increment').click(function() {
				var oldVal = $('#slider-1').val();
				$('#slider-1').val(parseFloat(oldVal) + 0.1).slider("refresh");
			});
			$('#decrement').click(function() {
				var oldVal = $('#slider-1').val();
				$('#slider-1').val(parseFloat(oldVal) - 0.1).slider("refresh");
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
		<input type="input" name="slider-1" id="slider-1" value="0.5" min="0" max="10" step="0.1" data-highlight="true">
		<a id="decrement" href="javascript: void(2);">&laquo;</a>
		<a id="increment" href="javascript: void(2);">&raquo;</a>
	</div>
	</body>
</html>