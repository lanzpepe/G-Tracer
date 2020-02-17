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

Route::middleware('admin')->group(function () {
    Route::get('admin', 'Administrator\AdminController@index')->name('admin.index');
    Route::get('admin/profile', 'Administrator\AdminController@profile')->name('admin.profile');
    Route::post('departments/fetch', 'Administrator\DepartmentController@fetch');
    Route::resources([
        'accounts' => 'Administrator\AccountController',
        'schools' => 'Administrator\SchoolController',
        'departments' => 'Administrator\DepartmentController',
        'school_years' => 'Administrator\SchoolYearController'
    ]);
});

Route::middleware('department')->group(function () {
    Route::get('dept', 'Department\DepartmentController@index')->name('dept');
    Route::get('reports', 'Department\ReportController@reports')->name('reports');
    Route::get('reports/{id}', 'Department\ReportController@report')->name('report');
    Route::get('import', 'Department\ImportController@import')->name('import');
    Route::post('import/parse', 'Department\ImportController@parseImport')->name('import_parse');
    Route::post('import/process', 'Department\ImportController@processImport')->name('import_process');
    Route::get('file_manager', 'Department\FileManagerController@index')->name('file_manager');
    Route::get('dept/profile', 'Department\DepartmentController@profile')->name('dept_profile');
    Route::post('batches/fetch', 'Department\GraduateController@fetch');

    Route::resources([
        'graduates' => 'Department\GraduateController',
        'courses' => 'Department\CourseController',
        'jobs' => 'Department\JobController'
    ]);
});
