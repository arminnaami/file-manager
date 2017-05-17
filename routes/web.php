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

Route::get('/home', [
    'as'   => 'home',
    'uses' => 'HomeController@index',
]);
Route::get('/shared-with-me', [
    'as'   => 'sharedWithMe',
    'uses' => 'HomeController@sharedWithMe',
]);
Route::get('/profile', [
    'as'   => 'profile',
    'uses' => 'ProfileController@index',
]);
Route::get('/profile/edit', [
    'as'   => 'profile_edit',
    'uses' => 'ProfileController@edit',
]);
Route::get('/profile/change-password', [
    'as'   => 'changePassword',
    'uses' => 'ProfileController@changePassword',
]);
Route::post('/profile/change-password', [
    'as'   => 'changePasswordPost',
    'uses' => 'ProfileController@changePasswordSubmit',
]);
Route::get('/directory/{id?}', [
    'as'   => 'directory',
    'uses' => 'DirectoryController@index',
]);
Route::get('/directory/back/{id}', [
    'as'   => 'back',
    'uses' => 'DirectoryController@back',
]);
Route::post('/profile/edit', 'ProfileController@store');
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

Route::group(['middleware' => ['auth', 'roles'], 'prefix' => 'admin'], function ()
{
    Route::get('/', [
        'as'    => 'admin',
        'uses'  => 'AdminController@index',
        'roles' => ['admin', 'manager'],
    ]);
    Route::get('/managers', [
        'as'    => 'managers',
        'uses'  => 'AdminUsersController@managers',
        'roles' => ['admin'],
    ]);
    Route::get('/make-manager/{id}', [
        'as'    => 'makeManager',
        'uses'  => 'AdminUsersController@makeManager',
        'roles' => ['admin'],
    ]);
    Route::get('/remove-manager/{id}', [
        'as'    => 'removeManager',
        'uses'  => 'AdminUsersController@removeManager',
        'roles' => ['admin'],
    ]);
    Route::get('/users', [
        'as'    => 'users',
        'uses'  => 'AdminUsersController@index',
        'roles' => ['admin', 'manager'],
    ]);
    Route::post('/users/change-package', [
        'as'    => 'changePackage',
        'uses'  => 'AdminUsersController@changePackage',
        'roles' => ['admin', 'manager'],
    ]);
    Route::get('/block-user/{id}', [
        'as'    => 'blockUser',
        'uses'  => 'AdminUsersController@blockUser',
        'roles' => ['admin', 'manager'],
    ]);
    Route::get('/unblock-user/{id}', [
        'as'    => 'unblockUser',
        'uses'  => 'AdminUsersController@unblockUser',
        'roles' => ['admin', 'manager'],
    ]);
    Route::get('/extensions', [
        'as'    => 'extensions',
        'uses'  => 'AdminExtensionsController@index',
        'roles' => ['admin', 'manager'],
    ]);
    Route::get('/block-extension/{id}', [
        'as'    => 'blockExtension',
        'uses'  => 'AdminExtensionsController@blockExtension',
        'roles' => ['admin', 'manager'],
    ]);
    Route::get('/unblock-extension/{id}', [
        'as'    => 'unblockExtension',
        'uses'  => 'AdminExtensionsController@unblockExtension',
        'roles' => ['admin', 'manager'],
    ]);
    Route::post('/extensions', [
        'as'    => 'extensions',
        'uses'  => 'AdminExtensionsController@index',
        'roles' => ['admin', 'manager'],
    ]);
    Route::post('/extensions/create', [
        'as'    => 'addExtension',
        'uses'  => 'AdminExtensionsController@store',
        'roles' => ['admin', 'manager'],
    ]);

});

Route::group(['middleware' => ['auth', 'roles'], 'prefix' => 'admin/package'], function ()
{
    Route::get('/index', [
        'as'    => 'packages',
        'uses'  => 'AdminPackagesController@index',
        'roles' => ['admin', 'manager'],
    ]);
    Route::get('/create', [
        'as'    => 'addPackage',
        'uses'  => 'AdminPackagesController@create',
        'roles' => ['admin', 'manager'],
    ]);
    Route::post('/store', [
        'as'    => 'storePackage',
        'uses'  => 'AdminPackagesController@store',
        'roles' => ['admin', 'manager'],
    ]);
    Route::get('/edit/{id}', [
        'as'    => 'editPackage',
        'uses'  => 'AdminPackagesController@edit',
        'roles' => ['admin', 'manager'],
    ]);
    Route::post('/save/{id}', [
        'as'    => 'savePackage',
        'uses'  => 'AdminPackagesController@save',
        'roles' => ['admin', 'manager'],
    ]);
});
