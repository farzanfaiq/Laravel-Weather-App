<!DOCTYPE html>
<html>
<head>
	<title>Weather App</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style type="text/css">
		.container{
			width: 40%;
			border: 1px solid #ccc;
			border-radius: 4px;
			margin: 0 auto;
			margin-top: 4%;
			padding: 20px;
		}
	</style>
</head>
<body>
	<form action="{{route('get_weather_detail_by_city_name')}}" method="POST">
		@csrf
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3 class="text-center">Weather Info</h3>
					<hr />
				</div>
				<div class="col-md-12">
					@if($api_resp = Session::get('api_resp'))
						@if($api_resp['cod'] == 404)
							<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<strong>Error !</strong>
								<p>City not found.</p>
							</div>
						@elseif($api_resp['cod'] != 200)
							<div class="alert alert-warning alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<strong>Error !</strong>
								<p>{{ $api_resp['message'] }}</p>
							</div>
						@endif
					@endif
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="city_name">City Name: </label>
						<input type="text"  class="form-control" name="city_name" value="{{ old('city_name') }}">
						@if($errors->has('city_name'))
							<p class="text-danger">{{ $errors->first('city_name') }}</p>
						@endif
					</div>
				</div>
				<div class="col-md-12">
					<button class="btn btn-block btn-success" type="submit">Check</button>
				</div>
				@if($api_resp = Session::get('api_resp'))
					@if($api_resp['cod'] == 200)
						<div class="col-md-12">
							<table class="table table-bordered table-striped table-hoverd mt-4">
								<tr>
									<th width="30%">Latitude</th>
									<td width="70%">{{ $api_resp['coord']['lat'] }}</td>
								</tr>
								<tr>
									<th width="30%">Longitude</th>
									<td width="70%">{{ $api_resp['coord']['lon']  }}</td>
								</tr>
								<tr>
									<th width="30%">Main</th>
									<td width="70%">{{ $api_resp['weather'][0]['main'] }}</td>
								</tr>
								<tr>
									<th width="30%">Description</th>
									<td width="70%">{{ $api_resp['weather'][0]['description'] }}</td>
								</tr>
								<tr>
									<th width="30%">Pressure</th>
									<td width="70%">{{ $api_resp['main']['pressure'] }}</td>
								</tr>
								<tr>
									<th width="30%">Humidity</th>
									<td width="70%">{{ $api_resp['main']['humidity'] }}</td>
								</tr>
								<tr>
									<th width="30%">Speed</th>
									<td width="70%">{{ $api_resp['wind']['speed'] }}</td>
								</tr>
							</table>
						</div>
						<div class="col-md-12">
							<div id="accordion mt-4">
								<div class="card">
								    <div class="card-header">
								      <button type="button" class="btn btn-link btn-block" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
								        Weather Raw Data
								      </button>
								    </div>
								    <div class="collapse" id="collapseExample">
								      <div class="card-body">
								        @php
								        	echo "<pre>"; print_r($api_resp); echo "</pre>";
								        @endphp
								      </div>
								    </div>
								</div>
							</div>
						</div>
					@endif
				@endif
			</div>
		</div>
	</form>
	<div>
		<?php  
			//echo "<pre>"; print_r($errors); echo "</pre>"; 
			// if(isset(session())){
			// 	echo "<pre>"; print_r($api_resp); echo "</pre>"; 
			// }
			
			///echo "<pre>"; print_r($api_resp); echo "</pre>";	
		?>
	</div>
</body>
</html>