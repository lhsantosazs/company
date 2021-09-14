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
