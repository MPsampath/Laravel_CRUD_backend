<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('saveEmploy', 'App\Http\Controllers\Employcontroller@insert');

Route::post('getSerchData','App\Http\Controllers\Employcontroller@index');
 