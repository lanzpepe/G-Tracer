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
Route::get('pages', 'HomeController@showPages')->name('pages.show');
Route::post('page', 'HomeController@storePage')->name('pages.store');
Route::post('notification/token', 'HomeController@token')->name('token');
Route::post('notification/read', 'HomeController@read');
Route::get('file_manager', 'HomeController@fileManager')->name('file_manager');

Route::middleware('admin')->group(function () {
    Route::get('admin', 'Administrator\AdminController@index')->name('admin.index');
    Route::get('admin/profile', 'Administrator\AdminController@profile')->name('admin.profile');
    Route::post('departments/fetch', 'Administrator\DepartmentController@fetch')->name('dept.fetch');
    Route::resources([
        'users' => 'Administrator\UserController',
        'accounts' => 'Administrator\AccountController',
        'schools' => 'Administrator\SchoolController',
        'departments' => 'Administrator\DepartmentController',
        'school_years' => 'Administrator\SchoolYearController'
    ]);
});

Route::middleware('department')->group(function () {
    Route::get('dept', 'Department\DepartmentController@index')->name('dept');
    Route::get('linkedin', 'Department\DepartmentController@linkedIn')->name('linkedin');
    Route::get('reports', 'Department\ReportController@reports')->name('reports');
    Route::get('reports/{id?}', 'Department\ReportController@report')->name('report');
    Route::get('import', 'Department\ImportController@import')->name('import');
    Route::post('import/g/parse', 'Department\ImportController@parseGraduateData')->name('import.g.parse');
    Route::post('import/g/upload', 'Department\ImportController@uploadGraduateData')->name('import.g.upload');
    Route::post('import/in/parse', 'Department\Importcontroller@parseLinkedInData')->name('import.in.parse');
    Route::post('import/in/upload', 'Department\Importcontroller@uploadLinkedInData')->name('import.in.upload');
    Route::get('dept/profile', 'Department\DepartmentController@profile')->name('dept.profile');
    Route::resources([
        'graduates' => 'Department\GraduateController',
        'courses' => 'Department\CourseController',
        'jobs' => 'Department\JobController',
        'rewards' => 'Department\RewardController'
    ]);
});
