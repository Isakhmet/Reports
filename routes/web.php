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
});

Route::get('report', function (){
    return view('report');
})->middleware('auth');

Route::get('users/data-table', 'UserData@getUsers')->name('users.table');
Route::get('reports', 'ReportController@getReport')->name('reports');

Auth::routes();
