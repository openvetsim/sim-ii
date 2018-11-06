<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>slider demo</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <style>#slider { margin: 10px; }	</style>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>
<body>
 
<div id="slider" style="width: 500px;"></div>
 <input value="50" id="current-slider">
 <a id="decrement-slider" href="javascript: void(2);"><< Move slider | </a>
 <a id="increment-slider" href="javascript: void(2);">Move slider >></a>
<script>
	var minSlider = 1;
	var maxSlider = 100;
	var initValue = 50;
	$('#current-slider').val(initValue);
	$(document).ready(function() {
		var slideBar = $("#slider").slider({
			value: $('#current-slider').val(),
			min: minSlider,
			max: maxSlider,
			step: 1,
			slide: function(event, ui) {
				$('#current-slider').val(ui.value);
			}
		});
		
		$('#increment-slider').click(function() {
			var currentValue = parseInt($('#current-slider').val()) + 1;
			if(currentValue > maxSlider) {
				currentValue = maxSlider;
			}
			slideBar.slider("value", currentValue);
			$('#current-slider').val(currentValue);
		});
		$('#decrement-slider').click(function() {
			var currentValue = parseInt($('#current-slider').val()) - 1;
			if(currentValue < minSlider) {
				currentValue = minSlider;
			}
			slideBar.slider("value", currentValue);
			$('#current-slider').val(currentValue);
		});
		
		$('#current-slider').change(function() {
			var currentValue = parseInt($('#current-slider').val());
			if(currentValue < minSlider) {
				currentValue = minSlider;
			}
			slideBar.slider("value", currentValue);
			$('#current-slider').val(currentValue);		
		});
		
	});
</script>
 
</body>
</html>