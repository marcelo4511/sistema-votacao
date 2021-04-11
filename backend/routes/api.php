<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api']], function (){
    route::get('/user' , 'LoginController@user');
    Route::get('/survey','SurveyController@index');
    Route::get('/survey/{id}','SurveyController@show');
    Route::post('/survey','SurveyController@store');
    Route::post('/surveytotal1/{id}','SurveyController@save1');
    Route::post('/surveytotal2/{id}','SurveyController@save2');
    Route::post('/surveytotal3/{id}','SurveyController@save3');
    Route::put('/survey/{id}','SurveyController@update');
    Route::delete('/survey/{id}','SurveyController@destroy');
    Route::post('/logout', 'LoginController@logout');
});

    route::post('/login' , 'LoginController@login');
    route::post('/register' , 'LoginController@store');
    
