<?php

use Illuminate\Http\Request;
use Jarvis\Service;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('service/{number?}', 'ControllerService@api_show');
Route::get('service', 'ControllerService@getAllServices');
Route::get('service/{number}', 'ControllerService@getService');
Route::post('service', 'ControllerService@createService');
Route::post('vlanUpdate', 'ControllerService@updateServiceVlan');
Route::delete('service/{number}','ControllerService@deleteService');

