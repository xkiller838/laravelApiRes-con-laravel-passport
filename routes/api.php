<?php

// use Illuminate\Http\Request;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');


Route::middleware('auth:api', 'cors')->group(function(){
	Route::post('details', 'Api\AuthController@details');
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('update', 'Api\AuthController@update');
});
