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

Route::get('/', function () {
    return view('welcome');
})->name('index');

Auth::routes();

Route::middleware('admin')->group(function () {
    Route::get('admin', 'Administrator\AdminController@index')->name('admin.index');
    Route::get('admin/profile', 'Administrator\AdminController@profile')->name('admin.profile');
    Route::post('departments/fetch', 'Administrator\DepartmentController@fetch');
    Route::resources([
        'accounts' => 'Administrator\AccountController',
        'schools' => 'Administrator\SchoolController',
        'departments' => 'Administrator\DepartmentController',
        'courses' => 'Administrator\CourseController',
        'school_years' => 'Administrator\SchoolYearController',
        'jobs' => 'Administrator\JobController'
    ]);
});

Route::middleware('department')->group(function () {
    Route::get('dept', 'Department\DepartmentController@index')->name('dept');
    Route::get('reports', 'Department\DepartmentController@report')->name('reports');
    Route::get('graduates', 'Department\GraduateController@graduates')->name('graduates');
    Route::post('graduate/add', 'Department\GraduateController@addGraduate')->name('add_graduate');
    Route::get('graduate/{id}/mark', 'Department\GraduateController@markGraduate');
    Route::get('import', 'Department\ImportController@import')->name('import');
    Route::post('import/parse', 'Department\ImportController@parseImport')->name('import_parse');
    Route::post('import/process', 'Department\ImportController@processImport')->name('import_process');
    Route::get('dept/profile', 'Department\DepartmentController@profile')->name('dept_profile');
});
