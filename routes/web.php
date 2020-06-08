<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'IndexController@index')->name('index');
Route::get('file_manager', 'HomeController@fileManager')->name('file_manager');
Route::get('pages', 'HomeController@showPages')->name('pages.show');
Route::post('page', 'HomeController@storePage')->name('pages.store');
Route::post('notifications', 'HomeController@notifications')->name('notifications');
Route::post('notifications/token', 'HomeController@token')->name('notifications.token');
Route::post('notifications/read', 'HomeController@read')->name('notifications.read');

Route::middleware('admin')->group(function () {
    Route::get('admin', 'Administrator\AdminController@index')->name('admin.index');
    Route::get('admin/profile', 'Administrator\AdminController@profile')->name('admin.profile');
    Route::post('departments/fetch', 'Administrator\DepartmentController@fetch')->name('dept.fetch');
    Route::resources([
        'users' => 'Administrator\UserController',
        'accounts' => 'Administrator\AccountController',
        'schools' => 'Administrator\SchoolController',
        'departments' => 'Administrator\DepartmentController'
    ]);
});

Route::middleware('department')->group(function () {
    Route::get('dept', 'Department\DepartmentController@index')->name('dept');
    Route::get('reports', 'Department\ReportController@reports')->name('reports');
    Route::get('reports/{id?}', 'Department\ReportController@report')->name('report');
    Route::get('dept/profile', 'Department\DepartmentController@profile')->name('dept.profile');
    Route::post('graduates/parse', 'Department\GraduateController@parse')->name('g.parse');
    Route::post('graduates/upload', 'Department\GraduateController@upload')->name('g.upload');
    Route::post('profiles/parse', 'Department\LinkedInController@parse')->name('in.parse');
    Route::post('profiles/upload', 'Department\LinkedInController@upload')->name('in.upload');
    Route::resources([
        'graduates' => 'Department\GraduateController',
        'profiles' => 'Department\LinkedInController',
        'courses' => 'Department\CourseController',
        'jobs' => 'Department\JobController',
        'rewards' => 'Department\RewardController'
    ]);
});
