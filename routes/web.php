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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('/shared-with-me', ['as' => 'sharedWithMe', 'uses' => 'HomeController@sharedWithMe']);

Route::get('/profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);
Route::get('/profile/edit', ['as' => 'profile_edit', 'uses' => 'ProfileController@edit']);
Route::post('/profile/edit', 'ProfileController@store');

Route::get('/directory/{id?}', ['as' => 'directory', 'uses' => 'DirectoryController@index']);
Route::get('/directory/delete/{id}', 'DirectoryController@delete');
Route::get('/directory/download/{id}', 'DirectoryController@download');
Route::get('/directory/get/{id}', 'DirectoryController@downloadWithToken');
Route::post('/directory/share', 'DirectoryController@share');
Route::post('/directory/rename', 'DirectoryController@rename');
Route::post('/directory/create', 'DirectoryController@store');
Route::post('/directory/get-dir-token', 'DirectoryController@getDirToken');

Route::get('/file/{id}', 'FilesController@download');
Route::get('/file/get/{id}', 'FilesController@downloadWithToken');
Route::get('/file/delete/{id}', 'FilesController@delete');
Route::post('/file/create/{id?}', 'FilesController@store');
Route::post('/file/share', 'FilesController@share');
Route::post('/file/get-file-token', 'FilesController@getFileToken');
Route::post('/file/rename', 'FilesController@rename');
