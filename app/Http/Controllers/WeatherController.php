<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yuuhao\Weather\Weather;
class WeatherController extends Controller
{
    public function show(Request $request,$city){
         dd(app('weather')->getWeather($city));
    }
}
