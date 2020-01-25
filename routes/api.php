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
    Route::post('login', 'User\SocialAuthController@login');
    Route::post('register', 'User\SocialAuthController@register');
    Route::get('genders', 'User\RegisterController@genders');
    Route::get('schools', 'User\RegisterController@schools');
    Route::get('courses/{school}', 'User\RegisterController@courses');
    Route::get('departments/{course}/{school}', 'User\RegisterController@department');
    Route::get('school_years', 'User\RegisterController@schoolYears');
    Route::get('batches', 'User\RegisterController@batches');
    Route::get('jobs/{course}', 'User\RegisterController@jobs');

    Route::middleware('auth:api')->group(function () {
        Route::get('graduates/{id}', 'User\GraduateController@graduate');
        Route::post('graduates/{id}/response', 'User\GraduateController@response');

        Route::get('users', 'User\UserController@users');
        Route::get('users/{id}', 'User\UserController@user');
        Route::get('users/{id}/graduates', 'User\UserController@graduates');

        Route::get('logout', 'User\SocialAuthController@logout');
    });
});

