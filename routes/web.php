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


Route::get('/','testControler@home');
Route::post('/app/create_tag','AdminController@addTag');
Route::get('/app/get_tags','AdminController@getTags');
Route::post('/app/edit_tag','AdminController@editTag');
Route::post('/app/delete_tag','AdminController@deleteTag');
Route::post('/app/upload','AdminController@upload');
Route::post('/app/remove_file','AdminController@removeFile');
Route::post('/app/create_category','AdminController@addCategory');
Route::get('/app/get_categories','AdminController@getCategories');
Route::post('/app/edit_cat','AdminController@editCat');
Route::post('/app/delete_cat','AdminController@deleteCat');







Route::get('/test','testControler@myFucntion');

Route::any('{slug}','testControler@anyRoute');
