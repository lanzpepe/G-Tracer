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

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', 'Api\SocialAuthController@login');
    Route::post('register', 'Api\SocialAuthController@register');

    Route::middleware('auth:api')->group(function () {
        Route::get('graduates', 'Api\GraduateController@getAllGraduates');
        Route::get('graduates/{id}', 'Api\GraduateController@getGraduate');
        Route::post('graduates/{id}/add', 'Api\GraduateController@addGraduate');
        Route::post('graduates/{id}/response', 'Api\GraduateController@addResponseToGraduate');

        Route::get('users', 'Api\UserController@getAllUsers');
        Route::get('users/{id}', 'Api\UserController@getUser');
        Route::get('users/{id}/graduates', 'Api\UserController@getAllGraduatesExceptId');

        Route::post('token', 'Api\GraduateController@addToken');
        Route::get('logout', 'Api\SocialAuthController@logout');
    });
});

