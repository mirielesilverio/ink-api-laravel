<?php

Route::post('/login', 'App\Http\Controllers\api\AuthController@login');
Route::group(['middleware' => 'apiJwt'], function () {
    Route::apiResource('clients','App\Http\Controllers\api\ClientController' );
    Route::apiResource('budget','App\Http\Controllers\api\BudgetController' );
    Route::apiResource('agenda','App\Http\Controllers\api\AgendaController' );
    Route::post('logout', 'App\Http\Controllers\api\AuthController@logout');
    Route::post('me', 'App\Http\Controllers\api\AuthController@me');
});