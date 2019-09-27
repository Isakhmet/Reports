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

Route::middleware('auth')
     ->get(
         '/', function () {
         return view('report');
     }
     )
;

Route::get('logout', 'Auth\LoginController@logout');

Route::group(
    ['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

    Route::get('/', function () {
        return view('admin.home');
    })->name('home_admin');

    Route::get('/', function () {
        return view('admin.home');
    })->name('home_admin');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('roles', 'RolesController');
    Route::resource('users', 'UsersController');
});

Auth::routes();