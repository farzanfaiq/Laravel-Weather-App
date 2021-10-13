<!DOCTYPE html>
<html>
<head>
	<title>Weather App</title>
</head>
<body>
	<form action="{{route('weather')}}" method="POST">
		@csrf
		<label for="city_name">City Name: </label>
		<input type="text" name="city_name" id="city_name" value="{{ $page_data['city_name'] }}">
		<input type="submit" value="Check" name="submit">

		@if($errors->has('city_name'))
			<p>{{ $errors->first('city_name') }}</p>
		@endif

		@if($page_data['data'] && $page_data['data']['cod'] == 404)
			<p>{{ $page_data['data']['message'] }}</p>
		@endif

	</form>
	<div>
		<?php  
			echo "<pre>"; print_r($page_data); echo "</pre>"; 
		?>
	</div>
</body>
</html>