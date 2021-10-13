<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
 	public function index(Request $request){

 		$page_data = ['data'=>null, 'city_name'=>''];

 		if($request->input('submit')){

 			$api_resp = $this->get_weather_detail_by_city_name( $request );
 			$page_data['data'] = $api_resp['data'];
 			$page_data['city_name'] = $api_resp['city_name'];
 		}

 		return view('weather', ['page_data'=>$page_data]);

 	} 	

 	public function get_weather_detail_by_city_name( $request ){

 		$resp_data = array();

 		$city_name = $request->input('city_name');

 		$request->validate([
 			'city_name'=>'required|string'
 		]);

 		$weather_api_key = config('weather')['api_key'];

 		$weather_api_base_url = config('weather')['base_url']; 

 		$api_resp = Http::get($weather_api_base_url . '?q='.$city_name.'&appid='.$weather_api_key);

 		$api_res_body = json_decode($api_resp->body(), true);

 		$resp_data['city_name'] = $city_name;

 		$resp_data['data'] = $api_res_body;

 		return $resp_data;
 	}

}