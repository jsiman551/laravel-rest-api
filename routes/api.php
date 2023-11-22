<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
Route::get('/test', 'App\Http\Controllers\Api\AuthController@test');

//authenticated routes
Route::group(['middleware'=>'auth:api'], function(){
    Route::post('/testOauth', 'App\Http\Controllers\Api\AuthController@testOauth');
    Route::get('getUsers', 'App\Http\Controllers\Api\UserDataController@show');
    Route::get('getUsers/{id}', 'App\Http\Controllers\Api\UserDataController@showDetail');
    Route::post('addUsers', 'App\Http\Controllers\Api\UserDataController@store');
    Route::put('updateUsers', 'App\Http\Controllers\Api\UserDataController@update');
    Route::delete('deleteUsers', 'App\Http\Controllers\Api\UserDataController@destroy');
    Route::get('getActividades', 'App\Http\Controllers\Api\ActividadesController@show');
    Route::get('getActividad/{id}', 'App\Http\Controllers\Api\ActividadesController@showDetail');
    Route::post('addActividad', 'App\Http\Controllers\Api\ActividadesController@store');
    Route::post('addConfirmation', 'App\Http\Controllers\Api\ConfirmationController@store');
    Route::get('getConfirmations', 'App\Http\Controllers\Api\ConfirmationController@show');
    Route::delete('deleteConfirmations', 'App\Http\Controllers\Api\ConfirmationController@destroy');
    Route::get('getConfirmation/{id}', 'App\Http\Controllers\Api\ConfirmationController@showDetail');
    Route::get('getConfirmationUser/{id}', 'App\Http\Controllers\Api\ConfirmationController@showDetailUser');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
