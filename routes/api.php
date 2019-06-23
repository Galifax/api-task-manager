<?php
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
Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');
Route::post('user/check-email/{email}', 'Api\UserController@checkEmail');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('details', 'Api\UserController@details');
    Route::resource('tasks', 'Api\TaskController');
});

