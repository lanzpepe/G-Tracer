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

Route::get('/', function () {
    return view('welcome');
})->name('index');

Auth::routes();

Route::middleware('admin')->group(function () {
    Route::get('admin', 'Administrator\AdminController@index')->name('admin');
    Route::get('accounts', 'Administrator\AccountController@accounts')->name('accounts');
    Route::post('account/add', 'Administrator\AccountController@addAccount')->name('add_account');
    Route::get('account/{username}/mark', 'Administrator\AccountController@markAccount');
    Route::get('account/{username}/delete', 'Administrator\AccountController@removeAccount');
    Route::get('schools', 'Administrator\SchoolController@schools')->name('schools');
    Route::post('school/add', 'Administrator\SchoolController@addSchool')->name('add_school');
    Route::get('school/{school}/mark', 'Administrator\SchoolController@markSchool');
    Route::get('school/{school}/delete', 'Administrator\SchoolController@removeSchool');
    Route::get('departments', 'Administrator\DepartmentController@departments')->name('departments');
    Route::post('department/fetch', 'Administrator\DepartmentController@fetch')->name('fetch_dept');
    Route::post('department/add', 'Administrator\DepartmentController@addDepartment')->name('add_dept');
    Route::get('department/{dept}/mark', 'Administrator\DepartmentController@markDepartment');
    Route::get('department/{dept}/{school}/delete', 'Administrator\DepartmentController@removeDepartment');
    Route::get('courses', 'Administrator\CourseController@courses')->name('courses');
    Route::post('course/add', 'Administrator\CourseController@addCourse')->name('add_course');
    Route::get('course/search', 'Administrator\CourseController@searchCourse');
    Route::get('course/major/search', 'Administrator\CourseController@searchMajor');
    Route::get('course/{course}/{major}/mark', 'Administrator\CourseController@markCourse');
    Route::get('course/{course}/{major}/{dept}/{school}/delete', 'Administrator\CourseController@removeCourse');
    Route::get('school_years', 'Administrator\SchoolYearController@schoolYears')->name('school_years');
    Route::post('school_year/add', 'Administrator\SchoolYearController@addSchoolYear')->name('add_sy');
    Route::get('school_year/{sy}/mark', 'Administrator\SchoolYearController@markSchoolYear');
    Route::get('school_year/{sy}/delete', 'Administrator\SchoolYearController@removeSchoolYear');
    Route::get('jobs', 'Administrator\JobController@jobs')->name('jobs');
    Route::post('job/add', 'Administrator\JobController@addJob')->name('add_job');
    Route::get('job/{name}/mark', 'Administrator\JobController@markJob');
    Route::get('job/{name}/{course}/{major}/delete', 'Administrator\JobController@removeJob');
    Route::get('admin/profile', 'Administrator\AdminController@profile')->name('admin_profile');
});

Route::middleware('department')->group(function () {
    Route::get('dept', 'Department\DepartmentController@index')->name('dept');
    Route::get('reports', 'Department\DepartmentController@report')->name('reports');
    Route::get('graduates', 'Department\GraduateController@graduates')->name('graduates');
    Route::post('graduate/add', 'DepartmentController@addGraduate')->name('add_graduate');
    Route::get('manual', 'ImportController@displayManualEntry')->name('manual');
    Route::post('addEntry', 'ImportController@addEntry')->name('addEntry');
    Route::get('import', 'Department\ImportController@import')->name('import');
    Route::post('import', 'Department\ImportController@parseImport')->name('import');
    Route::post('import/process', 'Department\ImportController@processImport')->name('import_process');
    Route::get('dept/profile', 'Department\DepartmentController@profile')->name('dept_profile');
});
