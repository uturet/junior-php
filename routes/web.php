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

Route::get('', 'EmployeesDataController@index')->name('employees_data');

Route::middleware(['auth'])->group(function () {

    Route::get('employees', 'EmployeeController@index')->name('employees.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
