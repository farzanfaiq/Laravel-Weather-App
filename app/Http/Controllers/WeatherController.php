<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class WeatherController extends Controller
{

 	public function index(Request $request){

 		return view('weather');

 	} 	

 	public function get_weather_detail_by_city_name( Request $request ){

 		$city_name = $request->input('city_name');

 		$request->validate([
 			'city_name'=>'required|string'
 		]);

 		$data_in_cache = false;

 		if(Cache::has($city_name)){

 			$api_parsed_resp = Cache::get($city_name);
 			$data_in_cache = true;

 		}

 		if(!$data_in_cache){

	 		$weather_api_key = config('weather')['api_key'];

	 		$weather_api_base_url = config('weather')['base_url']; 

	 		$api_raw_resp = Http::get($weather_api_base_url . '?q='.$city_name.'&appid='.$weather_api_key);

	 		$api_parsed_resp = json_decode($api_raw_resp->body(), true);

	 		Cache::put($city_name, $api_parsed_resp);

 		}

 		return redirect()->route('weather')->with(['api_resp'=>$api_parsed_resp])->withInput();
 	}

}