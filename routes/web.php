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

// Category routes
Route::get('/categories', 'CategoryController@index');
Route::put('/categories/{category}', 'CategoryController@rename');
Route::delete('/categories/{category}', 'CategoryController@delete');
Route::post('/store','CategoryController@store');
Route::get('/getFilesByCategory', 'CategoryController@getFilesByCategory');

// Permission routes
Route::post('/permission','PermissionController@store');
Route::get('/permission/{category}', 'PermissionController@show');

// Document routes
Route::post('/upload','DocumentController@store');
Route::get('/categories/{categoryId}/download/{fileId}', 'DocumentController@download');
