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

    Route::prefix('register')->group(function () {
        Route::post('verify', 'Api\RegisterController@verify');
        Route::post('linkedin', 'Api\RegisterController@linkedin');
        Route::post('token', 'Api\RegisterController@token');
    });

    Route::prefix('list')->group(function () {
        Route::get('gender', 'Api\ListController@genders');
        Route::get('school', 'Api\ListController@schools');
        Route::get('department/{school}', 'Api\ListController@schoolDepartments');
        Route::get('department/{course}/{school}', 'Api\ListController@courseDepartment');
        Route::get('course/{school}', 'Api\ListController@schoolCourses');
        Route::get('course/{department}/{school}', 'Api\ListController@deptCourses');
        Route::get('school_year', 'Api\ListController@schoolYears');
        Route::get('batch', 'Api\ListController@batches');
        Route::get('job/{course}', 'Api\ListController@jobs');
        Route::get('company', 'Api\ListController@companies');
        Route::get('reward', 'Api\ListController@rewards');
    });

    Route::middleware('auth:api')->group(function () {
        Route::get('graduates', 'Api\GraduateController@graduates');
        Route::get('graduates/{id}', 'Api\GraduateController@graduate');
        Route::post('graduate/save', 'Api\GraduateController@save');
        Route::post('graduate/response', 'Api\GraduateController@response');

        Route::get('user', 'Api\UserController@user');
        Route::get('users', 'Api\UserController@users');
        Route::get('user/graduates', 'Api\UserController@graduates');
        Route::post('user/twitter', 'Api\UserController@twitter');
        Route::post('user/job/update', 'Api\UserController@employment');
        Route::post('user/preference/set', 'Api\UserController@preference');
        Route::post('user/reward/claim', 'Api\UserController@reward');

        Route::get('logout', 'Api\SocialAuthController@logout');
    });
});

