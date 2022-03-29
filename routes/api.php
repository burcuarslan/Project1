<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'users'=>'App\Http\Controllers\Api\UserController',
    'cars'=>'App\Http\Controllers\Api\CarController',
    //'cars2'=>'App\Http\Resources\CarResource'
]);

Route::get('http://project1.test/selam',function (){
    return  'selam';
});

Route::get('/cars2/{id}', function ($id) {
    return new \App\Http\Resources\CarResource(Car::findOrFail($id));
});
