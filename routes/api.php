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
    Route::get('graduates', 'Api\GraduateController@graduates');

    Route::prefix('register')->group(function () {
        Route::get('genders', 'Api\RegisterController@genders');
        Route::get('schools', 'Api\RegisterController@schools');
        Route::get('courses/{school}', 'Api\RegisterController@courses');
        Route::get('departments/{course}/{school}', 'Api\RegisterController@department');
        Route::get('school_years', 'Api\RegisterController@schoolYears');
        Route::get('batches', 'Api\RegisterController@batches');
        Route::get('jobs/{course}', 'Api\RegisterController@jobs');
        Route::get('companies', 'Api\RegisterController@companies');
        Route::post('verify', 'Api\RegisterController@verify');
        Route::post('linkedin/profile', 'Api\RegisterController@linkedin');
    });

    Route::middleware('auth:api')->group(function () {
        Route::get('graduates/{id}', 'Api\GraduateController@graduate');
        Route::post('graduates/save', 'Api\GraduateController@save');
        Route::post('graduates/response', 'Api\GraduateController@response');

        Route::get('users', 'Api\UserController@users');
        Route::get('users/{id}', 'Api\UserController@user');
        Route::get('users/{id}/graduates', 'Api\UserController@graduates');
        Route::post('users/update', 'Api\UserController@updateEmployment');

        Route::get('logout', 'Api\SocialAuthController@logout');
    });
});

