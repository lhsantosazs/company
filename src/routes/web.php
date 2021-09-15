<?php

use Illuminate\Support\Facades\Route;

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
});

Route::get('/test', function () {
    return 'Docker works! Company project';
});

//Company routes
Route::group(['prefix' => 'company'], function () {
    Route::post('/', 'CompanyController@create');
    Route::get('/', 'CompanyController@read')->where('companyId', '[0-9]+');
    Route::put('/{companyId}', 'CompanyController@update')->where('companyId', '[0-9]+');
    Route::delete('/{companyId}', 'CompanyController@delete')->where('companyId', '[0-9]+');
});

//Customer routes
Route::group(['prefix' => 'employee'], function () {
    Route::post('/', 'EmployeeController@create');
    Route::get('/', 'EmployeeController@read')->where('employeeId', '[0-9]+');
    Route::put('/{employeeId}', 'EmployeeController@update')->where('employeeId', '[0-9]+');
    Route::delete('/{employeeId}', 'EmployeeController@delete')->where('employeeId', '[0-9]+');
});

//Customer routes
Route::group(['prefix' => 'customer'], function () {
    Route::post('/', 'CustomerController@create');
    Route::get('/', 'CustomerController@read')->where('customerId', '[0-9]+');
    Route::put('/{customerId}', 'CustomerController@update')->where('customerId', '[0-9]+');
    Route::delete('/{customerId}', 'CustomerController@delete')->where('customerId', '[0-9]+');
});
