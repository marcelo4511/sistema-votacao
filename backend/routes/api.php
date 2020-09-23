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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    Route::get('/survey','SurveyController@index');
    Route::get('/survey/{id}','SurveyController@show');
    Route::post('/survey','SurveyController@store');
    Route::post('/surveytotal1/{id}','SurveyController@save1');
    Route::post('/surveytotal2/{id}','SurveyController@save2');
    Route::post('/surveytotal3/{id}','SurveyController@save3');
    Route::put('/survey/{id}','SurveyController@update');
    Route::delete('/survey/{id}','SurveyController@destroy');

