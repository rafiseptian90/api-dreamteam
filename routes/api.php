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

Route::group(['middleware' => 'api', 'prefix' => 'v1', 'namespace' => 'API'], function(){
    Route::get('/', function(){
        return response()->json(['message' => 'Hello'], 200);
    });
    
    // Authentication routes
    Route::group(['prefix' => 'auth'], function(){
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('change-password', 'AuthController@changePassword');
        Route::get('profile', 'AuthController@profile');
        Route::put('profile', 'AuthController@updateProfile');
    });

    // Project endpoints
    Route::apiResource('project', 'ProjectController');
});